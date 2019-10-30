<?php

$start = STInput::post('check_in', date(TravelHelper::getDateFormat()));

$end = STInput::post('check_out', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));

$adult_number = STInput::post('adult_number', 0);

$child_number = STInput::post('child_number', 0);

$infant_number = STInput::post('infant_number', 0);

$min_people = get_post_meta(get_the_ID(), 'min_people', true);

$max_people = get_post_meta(get_the_ID(), 'max_people', true);

$price_type = get_post_meta(get_the_ID(), 'tour_price_by', true);

if(empty($min_people) or $min_people <= 0)
    $min_people = 1;

if(empty($max_people) or $max_people <= 0)
    $max_people = 20;

$has_icon = (isset($has_icon))? $has_icon: false;

$hide_adult = get_post_meta(get_the_ID(), 'hide_adult_in_booking_form', true);

$hide_children = get_post_meta(get_the_ID(), 'hide_children_in_booking_form', true);

$hide_infant = get_post_meta(get_the_ID(), 'hide_infant_in_booking_form', true);

global $wpdb;
$post_id = get_the_ID();
$d = new DateTime('+2day');
$tomorrow = $d->format('d');
$thisMonth = date("F", mktime(0, 0, 0, date("m"), 10));
$thisYear = date("Y");
$thisTime = strtotime($tomorrow . " " . $thisMonth . " " . $thisYear);
$result = $wpdb->get_row("SELECT *, Count(*) AS `Total` from `wp_st_activity_availability` WHERE `post_id` = '$post_id' AND `check_in` = '$thisTime' ");

if( $price_type == "fixed" ) {
?>
    <div class="form-group form-guest-search clearfix <?php if($has_icon) echo ' has-icon '; ?>">
        <?php

        if($has_icon){

            echo TravelHelper::getNewIcon('ico_calendar_search_box');

        }
        $grpObj = json_decode( stripcslashes($result->price) );

        // var_dump($result);
        // var_dump($grpObj);

        if( !empty($grpObj) )
            $grp_keys = array_keys( get_object_vars($grpObj) );
        ?>
        <div class="guest-wrapper clearfix">

            <div class="select-wrapper check-in-wrapper">

                <label>Packages</label>
                <p class="selected-group"><?php echo ucfirst($grp_keys[0]); ?></p>
                <button class="dropbtn"><i class="fa fa-angle-down"></i></button>
                <div class="dropdown" id="activity-groups">
                    <ul class="grp-list">
        <?php
            $init = 0;
                foreach ($grpObj as $key => $grp) {
                    if($init==0){
                        $init_max_size = $grp->grp_max_size;
                        $init = 1;
                    }
        ?>
                        <li data-max-size="<?php echo $grp->grp_max_size; ?>" data-symbol='<?php echo TravelHelper::just_symbol()["symbol"]; ?>' data-template = '<?php echo TravelHelper::just_symbol()["template"]; ?>' data-price='<?php echo TravelHelper::just_money($grp->grp_price); ?>' data-title='<?php echo ucfirst($key); ?>'>
                            <table>
                                <tr>
                                    <td><?php echo ucfirst($key); ?></td>
                                    <td rowspan="2"><b><?php echo TravelHelper::format_money($grp->grp_price); ?></b></td>
                                </tr>
                                <tr>
                                    <td>( <?php echo $grp->grp_min_size . " to " . $grp->grp_max_size; ?> person )</td>
                                </tr>
                            </table>                
                        </li>
        <?php
                }
        ?>

                    </ul>

                 <input type="hidden" name="adult_number" value="<?php echo $init_max_size; ?>" />

            	</div>
            </div>

        </div>
        <?php 
        // }
        // else {
        ?>
        <!-- <div class="guest-wrapper clearfix">
            <div class="msg-wrapper">
                No Packages for this date.
            </div>
        </div> -->
        <?php
        // }
        ?>
    </div>
<?php
}
else {

    $adult_price = $result->adult_price;//get_post_meta(get_the_ID(), 'adult_price', true);
    $child_price = $result->child_price;//get_post_meta(get_the_ID(), 'child_price', true);
    $infant_price = $result->infant_price;//get_post_meta(get_the_ID(), 'infant_price', true);

    $adult_age_range = get_post_meta(get_the_ID(), 'adult_age_range', true);
    $child_age_range = get_post_meta(get_the_ID(), 'child_age_range', true);
    ?>

    <div class="form-group form-guest-search clearfix <?php if($has_icon) echo ' has-icon '; ?>">

        <?php

        if($has_icon){

            echo TravelHelper::getNewIcon('ico_calendar_search_box');

        }

        ?>

        <?php if($hide_adult != 'on'): ?>
        

        <div class="guest-wrapper clearfix">

            <div class="check-in-wrapper">

                <label><?php echo __('Adults', ST_TEXTDOMAIN); ?></label>

                <div class="render"><?php echo "Age " . $adult_age_range . "+"; //echo __('Age 18+', ST_TEXTDOMAIN); ?></div>

            </div>

            <div class="select-wrapper">

                <div class="st-number-wrapper">

                    <?php if($post_id == '12239') { $max_people = 1; }?>
                    <input type="text" name="adult_number" data-price="<?php echo TravelHelper::just_money($adult_price);?>" value="<?php echo $adult_number; ?>" class="form-control st-input-number adult_price" autocomplete="off" readonly data-min="0" data-max="<?php echo $max_people; ?>"/>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <?php if($hide_children != 'on'): ?>

        <div class="guest-wrapper clearfix">

            <div class="check-in-wrapper">

                <label><?php echo __('Children', ST_TEXTDOMAIN); ?></label>

                <div class="render"><?php echo "Age ". $child_age_range . "-" .$adult_age_range;//echo __('Age 6-17', ST_TEXTDOMAIN); ?></div>

            </div>

            <div class="select-wrapper">

                <div class="st-number-wrapper">

                    <input type="text" name="child_number" data-price="<?php echo TravelHelper::just_money($child_price);?>" value="<?php echo $child_number; ?>" class="form-control st-input-number child_price" autocomplete="off" readonly data-min="0" data-max="<?php echo $max_people; ?>"/>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <?php if($hide_infant != 'on'): ?>

        <div class="guest-wrapper clearfix">

            <div class="check-in-wrapper">

                <label><?php echo __('Infant', ST_TEXTDOMAIN); ?></label>

                <div class="render"><?php echo "Age 0-" . $child_age_range; //echo __('Age 0-5', ST_TEXTDOMAIN); ?></div>

            </div>

            <div class="select-wrapper">

                <div class="st-number-wrapper">

                    <input type="text" name="infant_number" data-price="<?php echo TravelHelper::just_money($infant_price);?>" value="<?php echo $infant_number; ?>" class="form-control st-input-number infant_price" autocomplete="off" readonly data-min="0" data-max="<?php echo $max_people; ?>"/>

                </div>

            </div>

        </div>

        <?php endif; ?>

        <input type="hidden" class="currency_info" name="currency_info"  data-symbol='<?php echo TravelHelper::just_symbol()["symbol"]; ?>' data-template = '<?php echo TravelHelper::just_symbol()["template"]; ?>'>

    </div>
<?php
}