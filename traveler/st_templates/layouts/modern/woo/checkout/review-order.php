<?php



/**

 * Review order table

 *

 * @author        WooThemes

 * @package    WooCommerce/Templates

 * @version     3.3.0

 */

 

if (!defined('ABSPATH')) {
    exit;
}



$hotel_alone_in_setting  = st()->get_option('hotel_alone_assign_hotel', '');

$class_wrapper = 'woocommerce-checkout-review-order-table';

if (!empty($hotel_alone_in_setting)) {
    $class_wrapper = 'woocommerce-checkout-review-order-table1';
}

?>



<div class="<?php echo esc_attr($class_wrapper); ?> booking-item-payment">

    <?php

    do_action('woocommerce_review_order_before_cart_contents');

    
    
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $key_item =  key($cart_item['st_booking_data']['extras']['value']);
        
        // echo '<pre>' . var_export(WC()->cart->get_cart(), true) . '</pre>';
        // echo '<pre>' . var_export($cart_item['st_booking_data']['extras'], true) . '</pre>';

        




        if (isset($cart_item)) {
            $duration = $cart_item['st_booking_data']['duration'];

            $adult_number = intval($cart_item['st_booking_data']['adult_number']);

            $child_number = intval($cart_item['st_booking_data']['child_number']);

            $infant_number = intval($cart_item['st_booking_data']['infant_number']);

            $adult_price = $cart_item['st_booking_data']['data_price']['adult_price'];

            $child_price = $cart_item['st_booking_data']['data_price']['child_price'];

            $infant_price = $cart_item['st_booking_data']['data_price']['infant_price'];

            $extra_items_value = $cart_item['st_booking_data']['extras']['value'][$key_item];

            $extra_items_price = $cart_item['st_booking_data']['extras']['price'][$key_item];

            $extra_items_title = $cart_item['st_booking_data']['extras']['title'][$key_item];
            
            $extra_items_total = $cart_item['st_booking_data']['extra_price'];
        }



        

        $is_woo_product = false;

        if (!isset($cart_item['st_booking_data'])) {
            $is_woo_product = true;
        }



        //product_id



        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);



        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
            $product_url = '';

            $post_type = false;

            // Traveler

            if (isset($cart_item['st_booking_data']) and !empty($cart_item['st_booking_data'])) {
                $st_booking_data = $cart_item['st_booking_data'];



                $post_type = isset($st_booking_data['st_booking_post_type']) ? $st_booking_data['st_booking_post_type'] : false;



                $booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : false;

                if ($booking_id) {
                    $product_url = esc_url(get_permalink($booking_id));
                }
            } else {
                $product_url = esc_url($_product->get_permalink($cart_item));
            } ?>

            <header class="clearfix">

                <div class="col-left">

                    <h5 class="booking-item-payment-title">

                        <?php

                                if (!$_product->is_visible()) {
                                    echo apply_filters('woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key) . '&nbsp;';
                                } else {
                                    if (isset($cart_item['st_booking_data']) && isset($cart_item['st_booking_data']['st_booking_post_type']) && $cart_item['st_booking_data']['st_booking_post_type'] == 'st_hotel') {
                                        $st_booking_data = $cart_item['st_booking_data'];

                                        $hotel_id = $st_booking_data['st_booking_id'];

                                        $room_id = $st_booking_data['room_id'];

                                        echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" target="_blank">%s</a>', get_the_permalink($hotel_id), get_the_title($hotel_id)), $cart_item, $cart_item_key);
                                    } else {
                                        echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s" target="_blank">%s </a>', $product_url, $_product->get_title()), $cart_item, $cart_item_key);
                                    }
                                }



            // Meta data

            echo wc_get_formatted_cart_item_data($cart_item);



            // Backorder notification

            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                echo '<p class="backorder_notification">' . __('Available on backorder', ST_TEXTDOMAIN) . '</p>';
            } ?>

                    </h5>

                    <?php

                            if (!$is_woo_product) {
                                $address = get_post_meta($booking_id, 'address', true); ?>

                        <p class="room-name">

                            <?php

                                        $st_booking_data = $cart_item['st_booking_data'];

                                $booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : false;

                                $hotel_alone_in_setting = st()->get_option('hotel_alone_assign_hotel', '');

                                if (isset($st_booking_data['st_booking_post_type']) && $st_booking_data['st_booking_post_type'] == 'st_hotel' && $hotel_alone_in_setting == $booking_id) {
                                    echo esc_html__('Room Name', ST_TEXTDOMAIN) . ': ' . sprintf('<a href="%s" target="_blank">%s </a>', get_the_permalink($st_booking_data['room_id']), get_the_title($st_booking_data['room_id']));
                                } ?>

                        </p>

                        <?php

                                    if (!empty($address)) {
                                        ?>

                            <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>

                        <?php
                                    } ?>

                    <?php
                            } ?>

                </div>

                <a class="booking-item-payment-img" target="_blank" href="<?php echo $product_url; ?>">

                    <?php

                            if (isset($cart_item['st_booking_data']) and !empty($cart_item['st_booking_data'])) {
                                $st_booking_data = $cart_item['st_booking_data'];

                                $booking_id = isset($st_booking_data['st_booking_id']) ? $st_booking_data['st_booking_id'] : false;



                                $hotel_alone_in_setting = st()->get_option('hotel_alone_assign_hotel', '');

                                if (isset($st_booking_data['st_booking_post_type']) && $st_booking_data['st_booking_post_type'] == 'st_hotel' && $hotel_alone_in_setting == $booking_id) {
                                    echo get_the_post_thumbnail($st_booking_data['room_id'], 'thumbnail', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
                                } else {
                                    echo get_the_post_thumbnail($booking_id, 'thumbnail', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
                                }
                            } else {
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);



                                if (!$_product->is_visible()) {
                                    echo $thumbnail;
                                } else {
                                    echo $thumbnail;
                                }
                            } ?>

                </a>

            </header>



            <!-- info-section-start -->

            <div class="info-section">

                <ul>

                    <li>

                        <span class="label">

                            <?php echo __('Date', ST_TEXTDOMAIN); ?>

                        </span>

                        <span class="value">

                            <?php if ($type_activity == 'daily_activity') { ?>

                                <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_in)); ?>

                                <?php echo ($starttime != '' && isset($starttime)) ? ' - ' . $starttime : ''; ?>

                            <?php } else { ?>

                                <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_in)); ?>

                                -

                                <?php echo date_i18n(TravelHelper::getDateFormat(), strtotime($check_out)); ?>

                                <?php echo ($starttime != '' && isset($starttime)) ? ' - ' . $starttime : ''; ?>

                            <?php } ?>

                            <?php

                            $start = date(TravelHelper::getDateFormat(), strtotime($check_in));

            $end   = date(TravelHelper::getDateFormat(), strtotime($check_out));

            $date  = date('d/m/Y h:i a', strtotime($check_in)) . '-' . date('d/m/Y h:i a', strtotime($check_out));

            $args  = [

                                'start' => $start,

                                'end'   => $end,

                                'date'  => $date

                            ]; ?>

                            <!-- <a class="st-link" style="font-size: 12px;" href="<?php //echo add_query_arg($args, get_the_permalink($cart_item));?>"><?php //echo __('Edit', ST_TEXTDOMAIN);?></a> -->

                        </span>

                    </li>

                    <li>            

                        <span class="label">

                            <?php echo __('Cancellation', ST_TEXTDOMAIN); ?>

                        </span>

                        

                        <span class="value"> 

                            <?php

                                if ($cancellation== 'on') {
                                    if ($cancellation_day == 0) {
                                        echo __('Fully Refundable', ST_TEXTDOMAIN);
                                    } else {
                                        if ($cancellation_day > 1) {
                                            echo sprintf(__('Up to %s days', ST_TEXTDOMAIN), $cancellation_day);
                                        } else {
                                            echo sprintf(__('Up to %s day', ST_TEXTDOMAIN), $cancellation_day);
                                        }
                                    }
                                } else {
                                    echo __('Non Refundable', ST_TEXTDOMAIN);
                                } ?>

                        </span>

                    </li>

                    <?php if ($duration): ?>

                        <li>

                            <span class="label"><?php  _e('Duration', ST_TEXTDOMAIN)?> </span>

                            <span class="value">

                                <?php

                                echo $duration; ?>

                            </span>

                        </li>

                    <?php endif; ?>

                    

                    <!-- <li>

                        <span class="label"><?php // _e("Max People",ST_TEXTDOMAIN)?> </span>

                        <span class="value">

                            <?php

                                // $max_people = (int)get_post_meta($item_id ,'max_people',true);

                                // if( $max_people == 0 ){

                                //     $max_people = __('Unlimited', ST_TEXTDOMAIN);

                                // }

                                // echo $max_people;

                            ?>

                        </span>

                    </li> -->

                    <!--Add Info-->

                    <li class="ad-info">

                        <ul>

                            <?php if ($adult_number) {?>

                            <li><span class="label"><?php echo __('Number of Adult', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo $adult_number; ?></span></li>

                            <?php } ?>

                            <?php if ($child_number) {?>

                                <li><span class="label"><?php echo __('Number of Children', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo $child_number; ?></span></li>

                            <?php } ?>

                            <?php if ($infant_number) {?>

                                <li><span class="label"><?php echo __('Number of Infant', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo $infant_number; ?></span></li>

                            <?php } ?>
                            
                            <?php if ($extra_items_value) {?>
                                <span>Extras:</span>

                                <li><span class="label"><?php echo $extra_items_title ?></span><span class="value"><?php echo $extra_items_value; ?></span></li>

                            <?php } ?>

                        </ul>

                    </li>

                    <?php

                    if (isset($extras['value']) && is_array($extras['value']) && count($extras['value'])):

                        $count = 0;

            foreach ($extras['value'] as $key => $value) {
                $count += $value;
            }

            if ($count> 0) {
                ?>

                        <li>

                            <span class="label"><?php echo __('Extra', ST_TEXTDOMAIN); ?></span>

                        </li>

                        <li class="extra-value">

                                <?php

                                foreach ($extras['value'] as $name => $number):

                                    $number_item = intval($extras['value'][$name]);

                if ($number_item <= 0) {
                    $number_item = 0;
                }

                if ($number_item > 0):

                                        $price_item = floatval($extras['price'][$name]);

                if ($price_item <= 0) {
                    $price_item = 0;
                } ?>

                                        <span class="pull-right">

                                        <?php echo $extras['title'][$name] . ' (' . TravelHelper::format_money($price_item) . ') x ' . $number_item . ' ' . __('Item(s)', ST_TEXTDOMAIN); ?>

                                        </span> <br/>

                                    <?php endif;

                endforeach; ?>

                        </li>

                    <?php
            }

            endif; ?>

                    <?php

                    if (isset($item['data']['deposit_money'])):

                        $deposit      = $item['data']['deposit_money'];

            if (!empty($deposit['type']) and !empty($deposit['amount'])) {
                ?>

                        <li>

                            <span class="label"><?php printf(__('Deposit %s', ST_TEXTDOMAIN), $deposit['type']) ?></span>

                            <span class="value pull-right">

                                <?php

                                switch ($deposit['type']) {

                                    case "percent":

                                        echo $deposit['amount'].' %';

                                        break;

                                    case "amount":

                                        echo TravelHelper::format_money($deposit['amount']);

                                        break;

                                } ?>

                            </span>

                        </li>

                    <?php
            }

            endif; ?>

                </ul>

            </div>

             <!-- info-section-end -->



    <?php
        }
    }



    do_action('woocommerce_review_order_after_cart_contents');

    ?>

    

    <div class="total-amount-section">

        <ul>

            <?php if ($adult_number) { ?>

            <li>

                <span class="label">

                    <?php echo __('Adult Price', ST_TEXTDOMAIN); ?>

                </span>

                <span class="value">

                    <?php if ($adult_price) {
        echo TravelHelper::format_money($adult_price);
    } else {
        echo '0';
    } ?>

                </span>

            </li>

            <?php } ?>

            <?php if ($child_number) { ?>

            <li>

                <span class="label">

                    <?php echo __('Children Price', ST_TEXTDOMAIN); ?>

                </span>

                <span class="value">

                    <?php if ($child_price) {
        echo TravelHelper::format_money($child_price);
    } else {
        echo '0';
    } ?>

                </span>

            </li>

            <?php } ?>

            <?php if ($infant_number) { ?>

            <li>

                <span class="label">

                    <?php echo __('Infant Price', ST_TEXTDOMAIN); ?>

                </span>

                <span class="value">

                <?php if ($infant_price) {
        echo TravelHelper::format_money($infant_price);
    } else {
        echo '0';
    } ?>

                </span>

            </li>

            <?php } ?>

            <?php if ($extra_items_value) { ?>

            <li>

                <span class="label">

                    <?php echo $extra_items_title ?>

                </span>

                <span class="value">

                <?php if ($extra_items_value) {
        echo TravelHelper::format_money($extra_items_total);
    } else {
        echo '0';
    } ?>

                </span>

            </li>

            <?php } ?>



        </ul>

    </div>





    <ul class="booking-item-payment-details">

        <li>

            <ul class="booking-item-payment-price">

                <li>

                    <p class="booking-item-payment-price-title"><?php _e('Subtotal', ST_TEXTDOMAIN); ?>



                    </p>



                    <p class="booking-item-payment-price-amount"><?php wc_cart_totals_subtotal_html(); ?></p>

                </li>

                <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>



                    <li>

                        <p class="booking-item-payment-price-title"><?php wc_cart_totals_coupon_label($coupon); ?>



                        </p>



                        <p class="booking-item-payment-price-amount"><?php wc_cart_totals_coupon_html($coupon); ?></p>

                    </li>

                <?php endforeach; ?>



                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>



                    <?php do_action('woocommerce_review_order_before_shipping'); ?>



                    <?php wc_cart_totals_shipping_html(); ?>



                    <?php do_action('woocommerce_review_order_after_shipping'); ?>



                <?php endif; ?>



                <?php foreach (WC()->cart->get_fees() as $fee) : ?>

                    <li>

                        <p class="booking-item-payment-price-title"><?php echo esc_html($fee->name); ?>



                        </p>



                        <p class="booking-item-payment-price-amount"><?php wc_cart_totals_fee_html($fee); ?></p>

                    </li>

                <?php endforeach; ?>



                <?php if (WC()->cart->tax_display_cart === 'excl') : ?>

                    <?php if (get_option('woocommerce_tax_total_display') === 'itemized') : ?>

                        <?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : ?>

                            <li class="tax-rate tax-rate-<?php echo sanitize_title($code); ?>">

                                <p class="booking-item-payment-price-title"><?php echo esc_html($tax->label); ?>



                                </p>



                                <p class="booking-item-payment-price-amount"><?php echo wp_kses_post($tax->formatted_amount); ?></p>

                            </li>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <li class="tax-total">

                            <p class="booking-item-payment-price-title"><?php echo esc_html(WC()->countries->tax_or_vat()); ?>



                            </p>



                            <p class="booking-item-payment-price-amount"><?php echo wc_price(WC()->cart->get_taxes_total()); ?></p>

                        </li>

                    <?php endif; ?>

                <?php endif; ?>





            </ul>

        </li>

    </ul>

    <?php do_action('woocommerce_review_order_before_order_total'); ?>



    <p class="booking-item-payment-total"><?php _e('Total', ST_TEXTDOMAIN); ?>:

        <span><?php wc_cart_totals_order_total_html(); ?></span>

    </p>



    <?php do_action('woocommerce_review_order_after_order_total'); ?>



</div>







