<?php
if( isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) ){
	require $_SERVER['DOCUMENT_ROOT']."/wp-load.php";
    global $wpdb;
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    $month = date("F", mktime(0, 0, 0, $month, 10));

	$dateTime = strtotime($day . " " . $month . " " . $year);//floor($_POST['datePrice']/1000);
    // echo $day." ".$month." ".$year." ".$dateTime;
	$post_id = $_POST['post_id'];
    $result = $wpdb->get_row("SELECT *, Count(*) AS `Total` from `wp_st_activity_availability` WHERE `post_id` = '$post_id' AND `check_in` = '$dateTime' ");
    if( $result->Total == 0 )
    	echo "Error. No calendar price found.";
    else {
        // echo '<pre>' . var_export($result->price, true) . '</pre>';
        // die();
        if( $result->price == 0 || is_null($result->price) ) {
            $data['tour_price_by'] = "person";
            $data['adult_price'] = TravelHelper::just_money( $result->adult_price );
            $data['child_price'] = TravelHelper::just_money( $result->child_price );
            $data['infant_price'] = TravelHelper::just_money( $result->infant_price );
        }
        else {
            $data['tour_price_by'] = "fixed";
            $grpObj = json_decode($result->price);
            foreach ($grpObj as $grpKey => $grp) {
                foreach ($grp as $key => $value) {
                    if( $key == 'grp_price' ){
                        $grp->$key = TravelHelper::just_money($value);
                    }
                }
            }
            $data['result'] = json_encode( $grpObj );
        }
        echo json_encode($data);
    }
}