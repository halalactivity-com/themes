<?php

/**

 * Created by PhpStorm.

 * User: MSI

 * Date: 21/08/2015

 * Time: 9:45 SA

 */



function childtheme_resources()
{
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0', 'all');
    wp_register_script('my-custom-script', get_stylesheet_directory_uri() . '/scripts/custom-script.js', array('jquery'));

    wp_localize_script('my-custom-script', 'user_page_tabs', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('my-custom-script');
}
add_action('wp_enqueue_scripts', 'childtheme_resources');

//Ajax Tabs
add_action("wp_ajax_my_user_like", "user_page_tabs");
function user_page_tabs()
{
    if (!wp_verify_nonce($_REQUEST['nonce'], "user_page_tabs_nonce")) {
        exit();
    }
    // Check if action was fired via Ajax call.
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        //   $result = json_encode($result);
      //   echo $result;
    } else {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    die();
}


//Replace woocommerce cart button
// add_filter('add_to_cart_redirect', 'redirect_add_to_cart_book');
// function redirect_add_to_cart_book()
// {
//    global $woocommerce;
//    $cw_redirect_url_checkout = $woocommerce->cart->get_checkout_url();
//    return $cw_redirect_url_checkout;
// }

// add_filter('woocommerce_product_single_add_to_cart_text', 'cart_button_text');
// add_filter('woocommerce_product_add_to_cart_text', 'cart_button_text');
// function cart_button_text()
// {
//    return __('Book Now', 'woocommerce');
// }


//Custom PayPal button text
add_filter('gettext', 'ha_custom_paypal_button_text', 20, 3);
function ha_custom_paypal_button_text($translated_text, $text, $domain)
{
    switch ($translated_text) {
      case 'Proceed to PayPal':
         $translated_text = __('Proceed to checkout', 'woocommerce');
         break;
   }
    return $translated_text;
}

//Empty cart before adding a new item
// So only last item is always in cart for checkout
add_action('woocommerce_before_calculate_totals', 'keep_only_last_cart_item', 30, 1);
function keep_only_last_cart_item($cart)
{
    if (is_admin() && ! defined('DOING_AJAX')) {
        return;
    }

    if (did_action('woocommerce_before_calculate_totals') >= 2) {
        return;
    }

    $cart_items = $cart->get_cart();

    if (count($cart_items) > 1) {
        $cart_item_keys = array_keys($cart_items);
        $cart->remove_cart_item(reset($cart_item_keys));
    }
}


// Iyzico payment button text
// add_filter('iyzico-woocommerce-checkout-form', 'iyzico_custom_button_text', 30, 1);
// function iyzico_custom_button_text(){
//    return 'Submit';
// }

//Disble coupon field on the checkout page
add_filter('woocommerce_coupons_enabled', 'disable_coupon_field_on_cart');
function disable_coupon_field_on_cart($enabled)
{
    if (is_cart()) {
        $enabled = false;
    }
    return $enabled;
}

// Iyzico payment button text
add_filter('woocommerce_order_button_text', 'checkout_custom_button_text');

function checkout_custom_button_text($button_text)
{
    return 'Proceed to Checkout'; // new text is here
}

$preview = get_stylesheet_directory() . '/woocommerce/emails/woo-preview-emails.php';

if (file_exists($preview)) {
    require $preview;
}


//Add currency Parameter from URL
function currency_param_redirect()
{
    if (!is_admin() && !isset($_GET['currency'])) {
        $location = "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $location .= "?currency=TRY";
        wp_redirect($location);
    }
}
    
// add_action('template_redirect', 'currency_param_redirect');

function enable_duplicate_comments_preprocess_comment($comment_data)
{
    //add some random content to comment to keep dupe checker from finding it
    $random = md5(time());  
    $comment_data['comment_content'] .= "disabledupes{" . $random . "}disabledupes";    
    
    return $comment_data;
}
add_filter('preprocess_comment', 'enable_duplicate_comments_preprocess_comment');

function enable_duplicate_comments_comment_post($comment_id)
{
    global $wpdb;
    
    //remove the random content
    $comment_content = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_ID = '$comment_id' LIMIT 1");  
    $comment_content = preg_replace("/disabledupes{.*}disabledupes/", "", $comment_content);
    $wpdb->query("UPDATE $wpdb->comments SET comment_content = '" . $wpdb->escape($comment_content) . "' WHERE comment_ID = '$comment_id' LIMIT 1");
        
    /*
        add your own dupe checker here if you want
    */
}