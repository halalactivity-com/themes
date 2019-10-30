<?php

    if( isset($_POST['booking_id']) ){
        require $_SERVER['DOCUMENT_ROOT']."/wp-load.php";
        $order_code = $_POST['booking_id'];
    	$order_item = get_post($order_code);

        if( empty($order_item) )
            return 0;
    	wp_reset_postdata();
    	$payment_method = get_post_meta($order_item->ID, 'payment_method', true);
    	$currency = get_post_meta($order_code, 'currency', true);
?>
    	<div class="cart-info-container">
    		<h3 class="title">
    			<?php echo __('My Booking', ST_TEXTDOMAIN); ?>
    			<span class="fa fa-chevron-up arrow down-arrow active"></span>
    			<span class="fa fa-chevron-down arrow up-arrow"></span>
    		</h3>
    		<div class="cart-info active">
                <?php
                $i = 0;
                $key = get_post_meta($order_code, 'st_booking_id', true);
                do_action('st_payment_success_cart_info', $key, $order_code);
                $post_type = get_post_type($key);
                $value_cart_info = get_post_meta($order_code,'st_cart_info',true);
                $value = $value_cart_info[$key];
                switch ($post_type) {
                    case "st_hotel":
                        echo st()->load_template('layouts/modern/hotel/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                        break;
                    case "hotel_room":
                        echo st()->load_template('layouts/modern/hotel_room/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                        break;
                    case "st_tours":
                        echo st()->load_template('layouts/modern/tour/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                        break;
                    case "st_activity":
                        echo st()->load_template('layouts/modern/activity/success_payment_item_row', false, array('order_id' => $order_code, 'data' => $value, 'key' => $key, 'i' => $i));
                        break;
                }
                ?>
    			<div class="total-section">
                    <?php
                    $arr_item_custom_info = apply_filters('st_array_item_custom_payment_info', array());
                    if(in_array($key, $arr_item_custom_info)){
                        do_action('st_custom_payment_info', $key, $order_code);
                    }else{
                    $data_price = get_post_meta($order_code, 'data_prices', true);
                    // var_dump($data_price);
                    if(!$data_price) $data_price = array();
                    $data_price['adult_price'] = get_post_meta($order_code, 'adult_price', true) * get_post_meta($order_code, 'adult_number', true);
                    $data_price['child_price'] = get_post_meta($order_code, 'child_price', true) * get_post_meta($order_code, 'child_number', true);
                    $data_price['infant_price'] = get_post_meta($order_code, 'infant_price', true) * get_post_meta($order_code, 'infant_number', true);
                    $adult_price = isset($data_price['adult_price']) ? $data_price['adult_price'] : 0;
                    $child_price = isset($data_price['child_price']) ? $data_price['child_price'] : 0;
                    $infant_price = isset($data_price['infant_price']) ? $data_price['infant_price'] : 0;
                    $tax = intval(get_post_meta($order_code, 'st_tax_percent', true));
                    $deposit_status = get_post_meta($order_code, 'deposit_money', true);
                    $extras = get_post_meta($order_code, 'extras', true);
                    $extra_price = floatval(get_post_meta($order_code, 'extra_price', true));
                    $origin_price = get_post_meta($order_code, 'ori_price', true);//isset($data_price['origin_price']) ? $data_price['origin_price'] : 0;
                    $sale_price = $origin_price;//isset($data_price['sale_price']) ? $data_price['sale_price'] : 0;
                    $total_price = get_post_meta($order_code, 'total_price', true);//isset($data_price['total_price']) ? $data_price['total_price'] : 0 ;
                    $deposit_price = isset($data_price['deposit_price']) ? $data_price['deposit_price'] : 0;
                    $coupon_price = isset($data_price['coupon_price']) ? $data_price['coupon_price'] : 0;
                    $price_with_tax = $sale_price + $extra_price; //isset($data_price['price_with_tax']) ? $data_price['price_with_tax'] : 0;
                    $price_equipment = isset($data_price['price_equipment']) ? $data_price['price_equipment'] : 0;
                    //Tour package
                    $hotel_package = get_post_meta($order_code, 'package_hotel', true);
                    $hotel_package_price = get_post_meta($order_code, 'package_hotel_price', true);
                    $activity_package = get_post_meta($order_code, 'package_activity', true);
                    $activity_package_price = get_post_meta($order_code, 'package_activity_price', true);
                    $car_package = get_post_meta($order_code, 'package_car', true);
                    $car_package_price = get_post_meta($order_code, 'package_car_price', true);
                    $flight_package = get_post_meta($order_code, 'package_flight', true);
                    $flight_package_price = get_post_meta($order_code, 'package_flight_price', true);
                    //End package
                    $passenger = get_post_meta($order_code, 'passenger', true);
                    $enable_tax_depart = get_post_meta($order_code, 'enable_tax_depart', true);
                    $tax_percent_depart = get_post_meta($order_code, 'tax_percent_depart', true);
                    $enable_tax_return = get_post_meta($order_code, 'enable_tax_return', true);
                    $tax_percent_return = get_post_meta($order_code, 'tax_percent_return', true);
                    ?>
    				<ul>
                        <?php
                        if ($post_type != 'st_flight') {
                            if (isset($data_price['adult_price']) && isset($data_price['child_price']) && isset($data_price['infant_price'])) {
                                ?>
        
                                <?php if($adult_price) { ?>
                                    <li><span class="label"><?php echo __('Adult Price', ST_TEXTDOMAIN); ?></span><span
                                                class="value"><?php echo TravelHelper::format_money_from_db($adult_price, $currency); ?></span>
                                    </li>
                                <?php } ?>
                                <?php if ($child_price) { ?>
                                    <li><span class="label"><?php echo __('Children Price', ST_TEXTDOMAIN); ?></span><span
                                                class="value"><?php echo TravelHelper::format_money_from_db($child_price, $currency); ?></span>
                                    </li>
                                <?php } ?>
                                <?php if ($infant_price) { ?>
                                    <li><span class="label"><?php echo __('Infant Price', ST_TEXTDOMAIN); ?></span><span
                                                class="value"><?php echo TravelHelper::format_money_from_db($infant_price, $currency); ?></span>
                                    </li>
                                <?php } ?>
                                <?php
                            }
                            ?>
                            <?php
                            if ($key == 'car_transfer') {
                                $base_price = get_post_meta($order_code, 'base_price', true);
                                $discount_rate = get_post_meta($order_code, 'discount_rate', true);
                                ?>
                                <li>
                                    <span class="label"><?php echo __('Car price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($base_price, $currency); ?></span>
                                </li>
                                <li>
                                    <span class="label"><?php echo __('Extra price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($extra_price, $currency); ?></span>
                                </li>
                                <?php if (!empty($discount_rate)) { ?>
                                    <li>
                                        <span class="label"><?php echo __('Discount rate', ST_TEXTDOMAIN); ?></span>
                                        <span class="value"><?php echo $discount_rate . '%'; ?></span>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                            <li>
                                <span class="label"><?php echo __('Subtotal', ST_TEXTDOMAIN); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($sale_price, $currency); ?></span>
                            </li>
                            <?php if (!empty($extras['value']) and is_array($extras['value']) && count($extras['value'])) { ?>
                                <li>
                                    <span class="label"><?php echo __('Extra Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($extra_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <!-- Hotel package -->
                            <?php if (!empty($hotel_package) and is_array($hotel_package) && count($hotel_package)) { ?>
                                <li>
                                    <span class="label"><?php echo __('Hotel Package Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($hotel_package_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (!empty($activity_package) and is_array($activity_package) && count($activity_package)) { ?>
                                <li>
                                    <span class="label"><?php echo __('Activity Package Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($activity_package_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (!empty($car_package) and is_array($car_package) && count($car_package)) { ?>
                                <li>
                                    <span class="label"><?php echo __('Car Package Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($car_package_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (!empty($flight_package) and is_array($flight_package) && count($flight_package)) { ?>
                                <li>
                                    <span class="label"><?php echo __('Flight Package Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($flight_package_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (isset($data_price['price_equipment'])) { ?>
                                <li>
                                    <span class="label"><?php echo __('Equipment Price', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($price_equipment, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <li>
                                <span class="label"><?php echo __('Tax', ST_TEXTDOMAIN); ?></span>
                                <span class="value"><?php echo __('All Tax Inclusive', ST_TEXTDOMAIN); //echo $tax . ' %'; ?></span>
                            </li>
                            <?php if ($coupon_price) { ?>
                                <li>
                                    <span class="label"><?php echo __('Coupon', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($coupon_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <?php if (is_array($deposit_status) && !empty($deposit_status['type']) && floatval($deposit_status['amount']) > 0) { ?>
                                <li>
                                    <span class="label"><?php echo __('Deposit', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($deposit_price, $currency); ?></span>
                                </li>
                                <?php
                                if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                    ?>
                                    <li>
                                        <span class="label"><?php echo __('Fee', ST_TEXTDOMAIN); ?></span>
                                        <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                                    </li>
                                <?php } ?>
                                <li>
                                    <span class="label"><?php echo __('Total', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($price_with_tax, $currency); ?></span>
                                </li>
                                <li>
                                    <span class="label"><?php echo __('Pay Amount', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($total_price, $currency); ?></span>
                                </li>
                            <?php } else { ?>
                                <?php
                                if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                    ?>
                                    <li>
                                        <span class="label"><?php echo __('Fee', ST_TEXTDOMAIN); ?></span>
                                        <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                                    </li>
                                <?php } ?>
                                <li class="payment-amount">
                                    <span class="label"><?php echo __('Pay Amount', ST_TEXTDOMAIN); ?></span>
                                    <span class="value">
                                        <?php
                                        $booking_fee_add_total = 0;
                                        if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                            $booking_fee_add_total = $booking_fee_price;
                                        }
                                        echo TravelHelper::format_money_from_db($price_with_tax + $booking_fee_add_total, $currency);
                                        ?>
                                    </span>
                                </li>
                            <?php
                            }
                        } else {
                            if (!empty($passenger) && intval($passenger) > 0) { ?>
                                <li>
                                    <span class="label"><?php echo __('Passenger', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo esc_attr($passenger); ?></span>
                                </li>
                            <?php } ?>
                            <?php if ($enable_tax_depart == 'yes_not_included' && intval($tax_percent_depart) > 0) { ?>
                                <li>
                                    <span class="label"><?php echo __('Tax Depart', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo esc_attr($tax_percent_depart) . '%'; ?></span>
                                </li>
                            <?php } ?>
                            <?php if ($enable_tax_return == 'yes_not_included' && intval($tax_percent_return) > 0) { ?>
                                <li>
                                    <span class="label"><?php echo __('Tax Return', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo esc_attr($tax_percent_return) . '%'; ?></span>
                                </li>
                            <?php } ?>
                            <?php
                            if (!empty($booking_fee_price = get_post_meta($order_code, 'booking_fee_price', true))) {
                                ?>
                                <li>
                                    <span class="label"><?php echo __('Fee', ST_TEXTDOMAIN); ?></span>
                                    <span class="value"><?php echo TravelHelper::format_money_from_db($booking_fee_price, $currency); ?></span>
                                </li>
                            <?php } ?>
                            <li class="payment-amount">
                                <span class="label"><?php echo __('Pay Amount', ST_TEXTDOMAIN); ?></span>
                                <span class="value"><?php echo TravelHelper::format_money_from_db($price_with_tax, $currency); ?></span>
                            </li>
                            <?php
                        }
                        ?>
    				</ul>
                    <?php } ?>
    			</div>
    		</div>
    	</div>
    	<div class="personal-info-container">
    		<h3 class="title">
    			<?php echo __('My Information', ST_TEXTDOMAIN); ?>
                <span class="fa fa-chevron-up arrow down-arrow"></span>
                <span class="fa fa-chevron-down arrow up-arrow active"></span>
    		</h3>
            <?php
            ob_start();
            ?>
    		<div class="info-form">
    			<ul>
    				<li><span class="label"><?php echo __('First Name', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_first_name', true) ?></span></li>
    				<li><span class="label"><?php echo __('Last name', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_last_name', true) ?></span></li>
    				<li><span class="label"><?php echo __('Email', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_email', true) ?></span></li>
    				<li><span class="label"><?php echo __('Phone', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_phone', true) ?></span></li>
    				<li><span class="label"><?php echo __('City', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_city', true) ?></span></li>
    				<li><span class="label"><?php echo __('Country', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_country', true) ?></span></li>
    				<li><span class="label"><?php echo __('Special Requirements', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_note', true) ?></span></li>
    				<?php /*<li><span class="label"><?php echo __('Address Line 1', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_address', true) ?></span></li>
    				<li><span class="label"><?php echo __('Address Line 2', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_address2', true) ?></span></li>
    				<li><span class="label"><?php echo __('State/Province/Region', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_province', true) ?></span></li>
    				<li><span class="label"><?php echo __('ZIP code/Postal code', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_post_meta($order_code, 'st_zip_code', true) ?></span></li> */ ?>
    			</ul>
    		</div>
            <?php
            $customer_infomation = @ob_get_clean();
            echo apply_filters( 'st_order_success_custommer_billing' , $customer_infomation, $order_code );
            ?>
            <div class="text-center mg20 mt30">
                <?php
                if (is_user_logged_in()){
                    $page_user = st()->get_option('page_my_account_dashboard');
                    if ($link = get_permalink($page_user)){
                        $link = esc_url(add_query_arg(array('sc'=>'booking-history'),$link));
                        ?>
                        <a href="<?php echo esc_url($link)?>" class="btn btn-primary"><i
                                    class="fa fa-book"></i> <?php echo __('Booking Management' , ST_TEXTDOMAIN) ;  ?></a>
                        <?php
                    }
                }
                ?>
                <?php
                $option_allow_guest_booking = st()->get_option('is_guest_booking');
                if($option_allow_guest_booking == 'on'){
                    do_action('st_after_order_success_page_information_table',$order_code);
                }else{
                    if (is_user_logged_in()){
                        do_action('st_after_order_success_page_information_table',$order_code);
                    }
                }
                ?>
            </div>
    	</div>
<?php
    }