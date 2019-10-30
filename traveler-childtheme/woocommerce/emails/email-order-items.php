<?php
/**
 * Email Order Items
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-items.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

$text_align  = is_rtl() ? 'right' : 'left';
$margin_side = is_rtl() ? 'left' : 'right';

foreach ( $items as $item_id => $item ) :
	$product       = $item->get_product();
	$sku           = '';
	$purchase_note = '';
	$image         = '';

	if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
		continue;
	}

	if ( is_object( $product ) ) {
		$sku           = $product->get_sku();
		$purchase_note = $product->get_purchase_note();
		$image         = $product->get_image( $image_size );
	}

	$totalTickets = $item['_st_adult_number'] + $item['_st_child_number'] + $item['_st_infant_number'];
	$order_data = $order->get_data();
	$bookingId = $item['_st_st_booking_id'];
	// echo $bookingId;
	$location = get_post_meta( $item['_st_st_booking_id'], 'address', true );
	$authorID = get_post( $bookingId )->post_author;
	$authorURL = get_author_posts_url( $authorID );
	$authorName = get_the_author_meta( 'user_nicename',$authorID );
	$orderID = $item['_st_wc_order_id'];
	$custFirstName = get_post_meta( $orderID, "_billing_first_name" );
	$custLastName = get_post_meta( $orderID, "_billing_last_name" );
	$custEmail = get_post_meta( $orderID, "_billing_email" );
	$custPhone = get_post_meta( $orderID, "_billing_phone" );
	$totalExtraPrice = $item['_st_extra_price'];
	$totalPrice = TravelHelper::just_money( $item['_st_total_price'] );

	?>
<tr>
	<td>
		<table class="tbl_order_info" border="0">
			<tr class="tr_order_details">
				<td class="td_item_name" style="word-wrap:break-word; border: none;" colspan="2">
					<h2><a href="<?php echo get_permalink( $bookingId ) ?>"><?php echo $item->get_name() ?></a></h2>
					<h4>By: <a class="author_url" href="<?php echo $authorURL ?>"><?php echo ucfirst($authorName); ?></a></h4>
				</td>
			</tr>
			<tr>
				<th style="text-align: left; font-size: 25px;">
					Booking Details:
				</th>
				<td></td>
			</tr>
			<tr>
				<th>Name</th>
				<td style="text-align: left; font-weight: 300;"><?php echo ucfirst($custFirstName[0]) . " " . ucfirst( $custLastName[0] ); ?></td>
			</tr>
			<tr>
				<th>Email</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $custEmail[0]; ?></td>
			</tr>
			<tr>
				<th>Phone</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $custPhone[0]; ?></td>
			</tr>
			<tr>
				<th>Trip Date</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $item['_st_check_in']; ?></td>
			</tr>
			<?php
			if( !empty($item['_st_starttime']) ){
			?>
			<tr>
				<th>Preferred Time</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $item['_st_starttime']; ?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<th>Location</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $location; ?></td>
			</tr>
			<?php if( !empty($item['_st_duration_unit']) ){
			?>
			<tr>
				<th>Duration</th>
				<td style="text-align: left; font-weight: 300;"><?php echo $item['_st_duration_unit']; ?></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="3" style="border: none;">
					<table class="tbl_payment_details" border="0">
						<tr>
							<td></td>
							<th style="text-align: left; font-size: 25px;">
								Payment Details
							</th>											
							<th></th>
						</tr>
						<!-- <tr class="tr_label_row">
							<td></td>
							<th style="text-align: left;">Gateway Information:</td>
							<td></td>
						</tr> -->
						<tr class="tr_label_row">
							<td></td>
							<th style="text-align: left;">Price:</td>
							<td></td>
						</tr>
						<?php
							if( $item['_st_price'] !== 0 && !is_null($item['_st_price']) ){ //If condition price for grp activity
								$max_size = $item['_st_adult_number'];
								$grpObj = json_decode( $item['_st_price'] );
								foreach ($grpObj as $grpKey => $grp) {
									if( $max_size == $grp->grp_max_size ){
										$price = TravelHelper::just_money($grp->grp_price);
										break;
									}
								}
						?>
						<tr>
							<td></td>
							<td>Group Activity ( Max Size: <?php echo $max_size; ?>)</td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $price; ?></td>
						</tr>
						<?php } else {// Start of Normal activity numbers and price condition
							$adult_number = $item['_st_adult_number'];
							$child_number = $item['_st_child_number'];
							$infant_number = $item['_st_infant_number'];

							$adult_price = TravelHelper::just_money( $item['_st_adult_price'] );
							$child_price = TravelHelper::just_money( $item['_st_child_price'] );
							$infant_price = TravelHelper::just_money( $item['_st_infant_price'] );


							if( $adult_number != 0 ) {
						?>				
						<tr>
							<td></td>
							<td>Adults x <?php echo $adult_number; ?></td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $adult_price; ?></td>
						</tr>
						<?php } if( $child_number != 0 ) {?>		
						<tr>
							<td></td>
							<td>Children x <?php echo $child_number; ?></td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $child_price; ?></td>
						</tr>
						<?php } if( $infant_number != 0 ) {?>		
						<tr>
							<td></td>
							<td>Infants x <?php echo $infant_number; ?></td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $infant_price; ?></td>
						</tr>
						<?php }//End of infant if	
						}//End of normal activity condition
						if( $totalExtraPrice != 0 ) { // If Condition Extra Exist Start
							// Extra price
							$arr_extra = $item['_st_extras'];
						?>
						<tr class="tr_label_row">
							<td></td>
							<th style="text-align: left;">Extra:</td>
							<td></td>
						</tr>
						<?php
							$extra = array();
							foreach ($arr_extra['value'] as $key => $value) {
								if( $value > 0 ) {
									array_push($extra, $key);
								}
							}																					
							foreach ($extra as $key => $value) {//Start of print extra foreach
						?>												
						<tr>
							<td></td>
							<td><?php echo $arr_extra['title'][$value] ?> x <?php echo $arr_extra['value'][$value]; ?></td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $arr_extra['value'][$value] * TravelHelper::just_money( $arr_extra['price'][$value] ); ?></td>
						</tr>
						<?php
							}//End of print extra foreach 
						?>										
						<tr>
							<td></td>
							<td>Total Extra:</td>
							<td><?php echo TravelHelper::just_symbol()["symbol"]; echo $totalExtraPrice ?></td>
						</tr>
						<?php
						} // If Condition Extra Exist End	
						?>							
						<tr class="tr_total_row">
							<td></td>
							<th style="border-top: 5px solid #000000; text-align: left;">Total Amount:</th>
							<td style="border-top: 5px solid #000000;"><?php echo TravelHelper::just_symbol()["symbol"]; echo $totalPrice ?></td>
						</tr>
						<tr>
							<td></td>
							<td><a href="https://www.halalactivities.com/refund-policy/">[REFUND POLICY]</a></td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>


<?php endforeach; ?>