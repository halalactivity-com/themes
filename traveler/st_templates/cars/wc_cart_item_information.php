<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 02/06/2015
 * Time: 3:32 CH
 */

if (!empty($st_booking_data['data_equipment'])) {
    $selected_equipments = $st_booking_data['data_equipment'];
}
$pick_up_date = $st_booking_data['check_in_timestamp'];
$drop_off_date = $st_booking_data['check_out_timestamp'];

$diff = abs($drop_off_date - $pick_up_date);
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) 
               / (30*60*60*24));
$days_extra = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$format = TravelHelper::getDateFormat();
$div_id = "st_cart_item" . md5(json_encode($st_booking_data['cart_item_key']));

$numberdays = (int)$st_booking_data['numberday'];
?>
<p class="booking-item-description">
    <?php echo __('Date:', ST_TEXTDOMAIN); ?> <?php echo date_i18n($format . ' ' . get_option('time_format'), $pick_up_date) ?>
    <i class="fa fa-long-arrow-right"></i> <?php echo date_i18n($format . ' ' . get_option('time_format'), $drop_off_date) ?>
    </br>
    <?php echo __('Location:', ST_TEXTDOMAIN); ?>
    <?php if (!empty($st_booking_data['location_id_pick_up']) && !empty($st_booking_data['location_id_drop_off'])): ?>
        <?php echo get_the_title($st_booking_data['location_id_pick_up']); ?> <i
                class="fa fa-long-arrow-right"></i> <?php echo get_the_title($st_booking_data['location_id_drop_off']) ?>
    <?php else: ?>
        <?php echo __('None', ST_TEXTDOMAIN); ?>
    <?php endif; ?>
</p>
<div id="<?php echo esc_attr($div_id); ?>" class='<?php if (apply_filters('st_woo_cart_is_collapse', false)) {
    echo esc_attr("collapse");
} ?>'>
    <p>
        <small><?php echo __("Booking Details", ST_TEXTDOMAIN); ?></small>
    </p>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <p class="booking-item-description">
            <b class='booking-cart-item-title'><?php echo __("Car price", ST_TEXTDOMAIN); ?>  </b>
            :
            <?php
            if ($st_booking_data['duration_unit'] == 'day') {
                echo TravelHelper::format_money($st_booking_data['sale_price']) . ' / ';
                if($numberdays == 1){
                    echo __("day", ST_TEXTDOMAIN);
                }else{
                    echo sprintf(__('%s days', ST_TEXTDOMAIN), $numberdays);
                }
            }
            if ($st_booking_data['duration_unit'] == 'hour') {
                echo TravelHelper::format_money($st_booking_data['sale_price']) . ' / ';
                echo __("hour", ST_TEXTDOMAIN);
            }
            if ($st_booking_data['duration_unit'] == "distance") {
                $type_distance = st()->get_option("cars_price_by_distance", "kilometer");
                echo TravelHelper::format_money($st_booking_data['item_price']) . ' / ';
                if ($type_distance == "kilometer") {
                    echo __("kilometer", ST_TEXTDOMAIN);
                } else {
                    echo __("mile", ST_TEXTDOMAIN);
                }
            }
            ?>
        </p>
        <?php
        if ($st_booking_data['duration_unit'] == "distance") {
        ?>
            <p class="booking-item-description">
                <b class='booking-cart-item-title'><?php echo __("Distance", ST_TEXTDOMAIN); ?>  </b>
                :
                <?php
                    $type_distance = st()->get_option("cars_price_by_distance", "kilometer");
                    echo TravelHelper::format_money($st_booking_data['data_destination']) . ' ';
                    if ($type_distance == "kilometer") {
                        echo __("kilometer", ST_TEXTDOMAIN);
                    } else {
                        echo __("mile", ST_TEXTDOMAIN);
                    }
                ?>
            </p>
        <?php } ?>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <p class="booking-item-description">
            <?php

            if (!empty($selected_equipments) and $selected_equipments):
            $extras = $selected_equipments;
            if (isset($extras['title']) && is_array($extras['title']) && count($extras['title'])): ?>
            <b class='booking-cart-item-title'><?php _e("Equipments price", ST_TEXTDOMAIN) ?></b>
            <div class="booking-item-payment-price-amount">
            <?php foreach ($extras['title'] as $key => $title):
                $price_item = floatval($extras['price'][$key]);
                if ($price_item <= 0) $price_item = 0;
                $number_item = intval($extras['value'][$key]);
                $price_type = $extras['price_type'][$key];
                if ($number_item <= 0) $number_item = 0;
                ?><?php if ($number_item) { ?>
                <span style="padding-left: 10px ">
                    <?php
                    if($price_type == 'fixed'){
                        echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>';
                    }else{
                        echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>' .' x '.$numberdays.' '. __('Day(s)', ST_TEXTDOMAIN);
                    }
                    ?>
                        </span> <br/>
            <?php }; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        </p>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php
        $discount = $st_booking_data['discount_rate'];
        if (!empty($discount)) { ?>
            <b class='booking-cart-item-title'><?php echo __("Discount", ST_TEXTDOMAIN); ?>: </b>
            <?php echo esc_attr($discount) . "%" ?>
        <?php }
        ?>
    </div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <?php if (get_option('woocommerce_tax_total_display') == 'itemized') {
            $wp_cart = WC()->cart->cart_contents;
            $item = $wp_cart[$st_booking_data['cart_item_key']];
            $tax = $item['line_tax'];
            if (!empty($tax)) { ?>
                <b class='booking-cart-item-title'><?php echo __("Tax", ST_TEXTDOMAIN); ?>: </b>
                <?php echo TravelHelper::format_money($tax); ?>
            <?php }
        } else {
            $tax = 0;
        }
        ?>
    </div>
    <div class='cart_border_bottom'></div>
    <div class="cart_item_group" style='margin-bottom: 10px'>
        <b class='booking-cart-item-title'><?php echo __("Total amount", ST_TEXTDOMAIN); ?>:</b>
        <?php
        $include_tax_price = get_option('woocommerce_prices_include_tax');
        if ($include_tax_price == 'yes')
            echo TravelHelper::format_money($st_booking_data['ori_price']);
        else
            echo TravelHelper::format_money($st_booking_data['ori_price'] + $tax);
        ?>
    </div>
</div>