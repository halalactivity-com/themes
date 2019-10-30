<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel payment item row
 *
 * Created by ShineTheme
 *
 */
$item = $data;
$hotel = $item['data']['st_booking_id'];
$item_id = $hotel;

$check_in = $item['data']['check_in'];
$check_out = $item['data']['check_out'];

$date_diff = STDate::dateDiff($check_in,$check_out);

$extras = isset($item['data']['extras']) ? $item['data']['extras'] : array();
$adult_number = intval($item['data']['adult_number']);
$child_number = intval($item['data']['child_number']);
?>
<div class="service-section">
    <div class="service-left">
        <h4 class="title"><a href="<?php echo get_permalink($hotel)?>"><?php echo get_the_title($hotel)?></a></h4>
        <?php
        $address = get_post_meta( $item_id, 'address', true);
        if( $address ):
            ?>
            <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
        <?php
        endif;
        ?>
    </div>
    <div class="service-right">
        <?php echo get_the_post_thumbnail($hotel,array(110,110,'bfi_thumb'=>true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($hotel )), 'class' => 'img-responsive'));?>
    </div>
</div>
<div class="info-section">
    <ul>
        <li><span class="label"><?php echo __('Name', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo get_the_title($item_id)?></span></li>
        <li>
            <span class="label">
                <?php echo __('Date', ST_TEXTDOMAIN); ?>
            </span>
            <span class="value">
                <?php echo date_i18n( TravelHelper::getDateFormat(), strtotime( $check_in ) ); ?>
                -
                <?php echo date_i18n( TravelHelper::getDateFormat(), strtotime( $check_out ) ); ?>
                <?php
                $start = date( TravelHelper::getDateFormat(), strtotime( $check_in ) );
                $end   = date( TravelHelper::getDateFormat(), strtotime( $check_out ) );
                $date  = date( 'd/m/Y h:i a', strtotime( $check_in ) ) . '-' . date( 'd/m/Y h:i a', strtotime( $check_out ) );
                $args  = [
                    'start' => $start,
                    'end'   => $end,
                    'date'  => $date
                ];
                ?>
                <a class="st-link" style="font-size: 12px;" href="<?php echo add_query_arg( $args, get_the_permalink( $item_id ) ); ?>"><?php echo __( 'Edit', ST_TEXTDOMAIN ); ?></a>
            </span>
        </li>
        <li class="ad-info">
            <ul>
                <li><span class="label"><?php echo __('Number of Night', ST_TEXTDOMAIN); ?></span><span class="value">
                        <?php
                        if($date_diff>1){
                            printf(__('%d Nights', ST_TEXTDOMAIN),$date_diff);
                        }else{
                            printf(__('%d Night', ST_TEXTDOMAIN),$date_diff);
                        }
                        ?>
                    </span></li>
                <?php if($adult_number) {?>
                    <li><span class="label"><?php echo __('Number of Adult', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo $adult_number; ?></span></li>
                <?php } ?>
                <?php if($child_number) {?>
                    <li><span class="label"><?php echo __('Number of Children', ST_TEXTDOMAIN); ?></span><span class="value"><?php echo $child_number; ?></span></li>
                <?php } ?>
            </ul>
        </li>
        <?php if(isset($extras['value']) && is_array($extras['value']) && count($extras['value'])): ?>
            <li>
                <span class="label"><?php echo __('Extra', ST_TEXTDOMAIN); ?></span>
            </li>
            <li class="extra-value">
                <?php
                foreach ($extras['value'] as $name => $number):
                    $number_item = intval($extras['value'][$name]);
                    if ($number_item <= 0) $number_item = 0;
                    if ($number_item > 0):
                        $price_item = floatval($extras['price'][$name]);
                        if ($price_item <= 0) $price_item = 0;
                        ?>
                        <span class="pull-right">
                            <?php echo $extras['title'][$name] . ' (' . TravelHelper::format_money($price_item) . ') x ' . $number_item . ' ' . __('Item(s)', ST_TEXTDOMAIN); ?>
                            </span> <br/>
                    <?php endif;
                endforeach;
                ?>
            </li>
        <?php endif; ?>
        <?php
        if(isset($item['data']['deposit_money'])):
            $deposit      = $item['data']['deposit_money'];
            if(!empty($deposit['type']) and !empty($deposit['amount'])){
                ?>
                <li>
                    <span class="label"><?php printf(__('Deposit %s',ST_TEXTDOMAIN),$deposit['type']) ?></span>
                    <span class="value pull-right">
                    <?php
                    switch($deposit['type']){
                        case "percent":
                            echo $deposit['amount'].' %';
                            break;
                        case "amount":
                            echo TravelHelper::format_money($deposit['amount']);
                            break;
                    }
                    ?>
                </span>
                </li>
            <?php } endif; ?>
    </ul>
</div>