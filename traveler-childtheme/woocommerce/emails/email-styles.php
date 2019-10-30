<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg        = get_option( 'woocommerce_email_background_color' );
$body      = get_option( 'woocommerce_email_body_background_color' );
$base      = get_option( 'woocommerce_email_base_color' );
$base_text = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text      = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link_color = wc_hex_is_light( $base ) ? $base : $base_text;

if ( wc_hex_is_light( $body ) ) {
	$link_color = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
// body{padding: 0;} ensures proper scale/positioning of the email in the iOS native email app.
?>
body {
	padding: 0;
}
table {
	border: none;
}
#wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
	margin: 0;
	padding: 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1) !important;
	background-color: <?php echo esc_attr( $body ); ?>;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
}

#template_header {
	background-color: <?php echo esc_attr( $base ); ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
}
table#template_footer {
	width: 708px !important;
}
#template_footer td {
	padding: 0;
	border-radius: 6px;
}

#template_footer #credit {
	border: 0;
	color: <?php echo esc_attr( $base_lighter_40 ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 12px;
	line-height: 125%;
	text-align: center;
	padding: 0 48px 48px 48px;
}

#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 48px 48px 0;
}

#body_content table td td {
	padding: 12px;
}

#body_content table td th {
	padding: 12px;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 14px;
	line-height: 150%;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	vertical-align: middle;
}

.address {
	padding: 12px;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
}

.link {
	color: <?php echo esc_attr( $base ); ?>;
}

#header_wrapper {
	padding: 36px 48px;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 150%;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 130%;
	margin: 0 0 18px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 130%;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a {
	color: <?php echo esc_attr( $link_color ); ?>;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin-<?php echo is_rtl() ? 'left' : 'right'; ?>: 10px;
}
/* Customer Processing Page CSS */
.welcome_msg {
	text-align: center;
}
.welcome_msg h1 {
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
	color: #29abe2;
	text-align: center;
}
.thanks_msg_cont {
	padding: 20px;
}
.thanks_msg_cont h1, .thanks_msg_cont h3, .thanks_msg_cont h5 {
	color: #000000; 
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
	margin-bottom: 0; 
	margin-top: 5px;
	padding-bottom: 0;
}
.thanks_msg_cont h1 {
	color: #29abe2;
	font-weight: 900;
}
.thanks_msg_cont h3 {
	color: #29abe2;
	font-weight: 300;	
}
.thanks_msg_cont h3 {
	font-size: 21px;
}
table tr.tr_order_details h2, table tr.tr_order_details h4 {
	margin: 0;
}
table tr.tr_order_details>td {
	padding: 0 !important;
	padding-left: 10px !important;
}
table.tbl_order_info * {
	font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
}
table tr.tr_order_details td.td_item_name h2 {
	margin-bottom: 5px;
}
table tr.tr_order_details td.td_item_name h2 a {
	color: #29abe2;
	font-size: 30px;
}
table td.td_item_name a {
	text-decoration: none;
}
table.tbl_order_info {
	background: #F7F9F8;
	width: 100%;
	border: 1px solid #cccccc;
}
table.tbl_order_info, table.tbl_order_info table.tbl_payment_details {
	width: 100%; 
	padding: 10px;
}
table.tbl_order_info>tr>td, table.tbl_order_info>tr>th {
	border-bottom: 1px solid #cccccc;
	text-align: left;
}
table.tbl_order_info>tr>td:first-child {
	width: 30%;
	word-wrap:break-word;
}
table.tbl_payment_details tr>td {
	text-align: left;
}
table.tbl_payment_details tr>td:last-child {
	text-align: right;
}
.tbl_payment_details tr td, .tbl_payment_details tr th {
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}
table.tbl_payment_details tr.tr_label_row td, table.tbl_payment_details tr.tr_label_row th {
	width: 33%;
	padding-top: 10px !important;
}

table.tbl_order_info tr th {
	font-size: 21px;
	font-weight: 900;
}
table.tbl_order_info tr td {
	font-size: 21px;
}
table.tbl_order_info tr td:nth-child(2) {
	font-weight: 500;
}
	font-weight: 100 !important;
table.tbl_order_info tr td:last-child {
	font-weight: 800;
}
table tr.tr_total_row td:last-child {
	color: #29abe2;
}
table.tbl_payment_details tr td:nth-child(2) {
	font-weight: 300 !important;
}

table tr.tr_total_row td, table tr.tr_total_row th {
	padding-top: 20px !important;
	padding-bottom: 20px !important;
}

table.tbl_payment_details tr:nth-last-child(3) td {
	padding-bottom: 20px !important;
}

.contact_us {
	padding: 15px;
}
.contact_us h3 {
	color: #000000;
	font-size: 21px;
	margin-top: 0px;
	margin-bottom: 5px;
	font-weight: 300;
}
.contact_us h3 a {
	font-weight: 300;
	color: #000000;
	text-decoration: none;
}
.auto_msg p {
	font-size: 12px;
	text-align: center;
}
<?php
