<?php
    /**
     * Order details
     *
     * @author  WooThemes
     * @package WooCommerce/Templates
     * @version 3.5.2
     */

    if (!defined('ABSPATH')) {
        exit; // Exit if accessed directly
    }

    $order = wc_get_order($order_id);

    // $total = get_post_meta($order_id, 'total_price', true);
    // $total = round((float)$total, 2);
    // echo $currency = TravelHelper::get_current_currency('name');
    
    // echo '<pre>' . var_export($order, true) . '</pre>';
    

    $customer_name = $order->get_billing_first_name();
    if (!$customer_name) {
        $customer_name = $order->get_billing_email();
    }
?>

<div class="col-md-6">
    <div class="card">
        <div class="row border-bottom">
            <header class="col-md-12 sb">
                <h2><?php _e('Booking Details', ST_TEXTDOMAIN) ?></h2>
            </header>
        
            <div class="col-md-12 sb">
            <ul class="order-payment-list list">
                <?php
                if (sizeof($order->get_items()) > 0) {
                    foreach ($order->get_items() as $item_id => $item) {
                        $key_item =  key($item['item_meta']['_st_extras']['value']);
                        
                        //Don't delete this $data variable
                        $data = $item['item_meta']['_st_st_booking_id'];
                        
                        // echo '<pre>' . var_export($item['item_meta'], true) . '</pre>';
                        
                        $_product      = apply_filters('woocommerce_order_item_product', $order->get_product_from_item($item), $item);
                        $post_type     = !empty($item[ 'item_meta' ][ '_st_st_booking_post_type' ]) ? $item[ 'item_meta' ][ '_st_st_booking_post_type' ] : false;
                        $st_booking_id = wc_get_order_item_meta($item_id, '_st_st_booking_id', true);

                        $check_in = $item['item_meta']['_st_check_in'];
                        $check_out = $item['item_meta']['_st_check_out'];
                        
                        $adult_price = $item['item_meta']['_st_data_price']['adult_price'];
                        $adult_number = $item['item_meta']['_st_adult_number'];
                        $child_price = $item['item_meta']['_st_data_price']['child_price'];
                        $child_number = $item['item_meta']['_st_child_number'];
                        $infant_price = $item['item_meta']['_st_data_price']['infant_price'];
                        $infant_number = $item['item_meta']['_st_infant_number'];
                        $total_price = $item['item_meta']['_st_total_price'];
                        
                        

                        $extra_items_value = $item['item_meta']['_st_extras']['value'][$key_item];
                        $extra_items_price = $item['item_meta']['_st_extras']['price'][$key_item];
                        $extra_items_title = $item['item_meta']['_st_extras']['title'][$key_item];

                        $authorID = get_post($st_booking_id)->post_author;
                        $authorName = get_the_author_meta('display_name', $authorID);
                       
                        if (is_array($post_type) and isset($post_type[ 0 ])) {
                            $post_type = $post_type[ 0 ];
                        }

                        if (apply_filters('woocommerce_order_item_visible', true, $item)) {
                            ?>
                <li
                    class="<?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'order_item', $item, $order)); ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>
                                <i class="fa <?php echo apply_filters('st_post_type_' . $post_type . '_icon', '') ?>"></i>
                                <?php
                                                if ($_product && !$_product->is_visible()) {
                                                    echo apply_filters('woocommerce_order_item_name', $item[ 'name' ], $item);
                                                } else {
                                                    echo apply_filters('woocommerce_order_item_name', sprintf('<a href="%s">%s</a>', get_permalink($st_booking_id), $item[ 'name' ]), $item);
                                                } ?>
                            </h5>
                            <span class="text-muted">By: <?php echo $authorName ?></span>
                        </div>
                        <div class="col-md-12">
                            <?php if ($_product && !$_product->is_visible()) {
                                                    echo apply_filters('woocommerce_order_item_name', $item[ 'name' ], $item);
                                                } ?>
                        </div>

                    </div>

                </li>
                <?php
                        }

                        if ($order->has_status([ 'completed', 'processing' ]) && ($purchase_note = get_post_meta($_product->get_id(), '_purchase_note', true))) {
                            ?>
                <li class="product-purchase-note">
                    <div colspan="3"><?php echo wpautop(do_shortcode(wp_kses_post($purchase_note))); ?></div>
                </li>
                <?php
                        }
                    }
                }

                do_action('woocommerce_order_items_table', $order);
            ?>
            </ul>
            </div>
                <table class="personal-deatil">
                    <tr>
                        <?php  $billing_name = $order->get_billing_first_name() ." ". $order->get_billing_last_name(); ?>
                        <?php if ($billing_name) {
                echo '<td class="duration-label">Name: </td>';
                echo '<td class="duration">';
                echo $billing_name;
                echo '</td>';
            } ?>
                    </tr>
                    <tr>
                        <?php  $billing_email = $order->get_billing_email(); ?>
                        <?php if ($billing_email) {
                echo '<td class="duration-label">Email: </td>';
                echo '<td class="duration">';
                echo $billing_email;
                echo '</td>';
            } ?>
                    </tr>
                    <tr>
                        <?php  $billing_phone = $order->get_billing_phone(); ?>
                        <?php if ($billing_phone) {
                echo '<td class="duration-label">Phone: </td>';
                echo '<td class="duration">';
                echo $billing_phone;
                echo '</td>';
            } ?>
                    </tr>
                    <tr>
                        <?php  $tripdate = $check_in ." → ". $check_out; ?>
                        <?php if ($tripdate) {
                echo '<td class="location-label">Trip Date: </td>';
                echo '<td class="location">';
                echo $tripdate;
                echo '</td>';
            } ?>
                    </tr>
                    <tr>
                        <?php  $location = get_post_meta($data, 'address', true); ?>
                        <?php if ($location) {
                echo '<td class="location-label">Location: </td>';
                echo '<td class="location">';
                echo $location;
                echo '</td>';
            } ?>
                    </tr>
                    <tr>
                        <?php  $duration = get_post_meta($data, 'duration', true); ?>
                        <?php if ($duration) {
                echo '<td class="duration-label">Duration: </td>';
                echo '<td class="duration">';
                echo $duration;
                echo '</td>';
            } ?>
                    </tr>
                </table>
        </div>
    </div>
</div>

<div class="col-md-6 mobile">
    <div class="card">
        <header class="border-bottom">
            <h2><?php _e('Payment Details', ST_TEXTDOMAIN) ?></h2>
        </header>

        <div class="price">
            <h5>Price<h5>
        </div>

        <table>
            <?php if ($adult_number) { ?>
                <tr>
                <?php
                    echo '<td class="price-td">Adult x '.$adult_number. ' </td>';
                    echo '<td class="price-td-value">';
                    echo esc_html(TravelHelper::format_money($adult_price, true));
                    echo '</td>';
                ?>
                </tr>
            <?php } ?>
            <?php if ($child_number) { ?>
                <tr>
                <?php
                    echo '<td class="price-td">Child x '.$child_number. ' </td>';
                    echo '<td class="price-td-value">';
                    echo esc_html(TravelHelper::format_money($child_price, true));
                    echo '</td>';
                ?>
                </tr>
            <?php } ?>
            <?php if ($infant_number) { ?>
                <tr>
                <?php
                    echo '<td class="price-td">Infant x '.$infant_number. ' </td>';
                    echo '<td class="price-td-value">';
                    echo esc_html(TravelHelper::format_money($infant_price, true));
                    echo '</td>';
                ?>
                </tr>
            <?php } ?>
        </table>

        <div class="extra">
            <h5>Extra<h5>
        </div>
        
        <table>
            <?php if ($extra_items_value) { ?>
                <tr>
                <?php
                    echo '<td class="price-td">'.$extra_items_title. ' x '.$extra_items_value.' </td>';
                    echo '<td class="price-td-value">';
                    echo esc_html(TravelHelper::format_money($extra_items_value*$extra_items_price, true));
                    echo '</td>';
                ?>
                </tr>
            <?php } ?>
        </table>

        <div class="total">
            <h5>Total Amount<h5>
        </div>
        
        <table>
            <?php if ($total_price) { ?>
                <tr>
                <?php
                    echo '<td class="price-td"></td>';
                    echo '<td class="price-td-value">';
                    echo esc_html(TravelHelper::format_money($total_price, true));
                    echo '</td>';
                ?>
                </tr>
            <?php } ?>
        </table>

    </div>
</div>


<div class="clear"></div>