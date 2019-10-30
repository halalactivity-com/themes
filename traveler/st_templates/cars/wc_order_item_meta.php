<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 14/07/2015
 * Time: 3:17 CH
 */
$item_data = isset($item['item_meta']) ? $item['item_meta'] : array();
$numberdays = $item_data['_st_numberday'];
?>
<ul class="wc-order-item-meta-list">    
    <?php if(isset($item_data['_st_price_unit'])):?>
        <li>
            <span class="meta-label"><?php _e('Price Unit:',ST_TEXTDOMAIN) ?></span>
            <span class="meta-data"><?php echo STCars::get_price_unit_by_unit_id($item_data['_st_price_unit']) ?></span>
        </li>
    <?php endif;?>

    <?php if(isset($item_data['_st_pick_up']) and $item_data['_st_pick_up']){?>
    <li>
        <span class="meta-label"><?php _e('Pick-up:',ST_TEXTDOMAIN) ?></span>
        <span class="meta-data"><?php
            if($item_data['_st_pick_up']){
                echo esc_html($item_data['_st_pick_up']);
            }

             ?></span>
    </li>
    <?php 

    }?>

    <?php if(isset($item_data['_st_drop_off']) and $item_data['_st_drop_off']){?>
    <li>
        <span class="meta-label"><?php _e('Drop-off:',ST_TEXTDOMAIN) ?></span>
        <span class="meta-data"><?php
            if($item_data['_st_drop_off']){
                echo esc_html($item_data['_st_drop_off']);
            }
            ?>
        </span>
    </li>
    <?php 

    }?>

    <?php if(isset($item_data['_st_check_in_timestamp'])):?>
    <li>
        <span class="meta-label"><?php _e('Date:',ST_TEXTDOMAIN) ?></span>
        <span class="meta-data"><?php echo date_i18n(TravelHelper::getDateFormat().' '.get_option('time_format'),$item_data['_st_check_in_timestamp']) ?>
            <?php if(isset($item_data['_st_check_out_timestamp'])){?>
                <i class="fa fa-long-arrow-right"></i>
                <?php echo date_i18n(TravelHelper::getDateFormat().' '.get_option('time_format'),$item_data['_st_check_out_timestamp']) ?>
            <?php }?>
        </span>
    </li>
    <?php endif;?>
    <?php

     if(isset($item_data['_st_data_equipment'])):

        $selected_equipment=$item_data['_st_data_equipment'];
        if($selected_equipment and $selected_equipment=maybe_unserialize($selected_equipment)){
            if(is_array($selected_equipment) and !empty($selected_equipment)){
                ?>
                <li>
                    <span class="meta-label"><?php _e('Equipments:',ST_TEXTDOMAIN) ?></span>
                    <span class="meta-data">
                        <br>
                            <?php
                            foreach($selected_equipment['title'] as $key=>$title){
                                $price_item = floatval($selected_equipment['price'][$key]);
                                if ($price_item <= 0) {
                                    $price_item = 0;
                                }
                                $number_item = intval($selected_equipment['value'][$key]);

                                $price_type = $selected_equipment['price_type'][$key];

                                if ($number_item <= 0){
                                    $number_item = 0;
                                }
                                if ($number_item) { ?>
                                    <span style="padding-left: 10px ">
                                        <?php
                                        if($price_type == 'fixed'){
                                            echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>';
                                        }else{
                                            echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>' .' x '.$numberdays.' '. __('Day(s)', ST_TEXTDOMAIN);
                                        }
                                        ?>
                                    </span><br/>
                                <?php
                                }
                            }
                            ?>
                    </span>
                </li>
            <?php
            }
        }
     endif;?>
     <?php if(isset($item_data['_st_sale_price'])):?>
        <li>
            <span class="meta-label"><?php _e('Price:',ST_TEXTDOMAIN) ?></span>
            <span class="meta-data"><?php echo TravelHelper::format_money($item_data['_st_item_price']); ?></span>
            /
            <?php 
            $duration = $item_data['_st_duration_unit'] ;
                if ($duration =='day') {
                    if($numberdays == 1){
                        echo __("day" , ST_TEXTDOMAIN) ;
                    }else{
                        echo sprintf(__('%s days', ST_TEXTDOMAIN), $numberdays);
                    }
                }
                if ($duration =='hour') {echo __("hour" , ST_TEXTDOMAIN) ; }
                if ($duration == "distance") {
                    $type_distance = st()->get_option( "cars_price_by_distance" , "kilometer" );
                    if($type_distance == "kilometer") {
                        echo __( "kilometer" , ST_TEXTDOMAIN );
                    } else {
                        echo __( "mile" , ST_TEXTDOMAIN );
                    }
                }
            ?>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_data_destination']) && $item_data['_st_duration_unit'] == 'distance'):?>
        <li>
            <span class="meta-label"><?php _e('Distance:',ST_TEXTDOMAIN) ?></span>
            <span class="meta-data"><?php echo TravelHelper::format_money($item_data['_st_data_destination']); ?></span>
            <?php
            $type_distance = st()->get_option( "cars_price_by_distance" , "kilometer" );
            if($type_distance == "kilometer") {
                echo __( "kilometer" , ST_TEXTDOMAIN );
            } else {
                echo __( "mile" , ST_TEXTDOMAIN );
            }
            ?>
        </li>
    <?php endif;?>
     <?php  if(isset($item_data['_st_discount_rate'])): $data=$item_data['_st_discount_rate'];?>
        <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Discount"  ,ST_TEXTDOMAIN) .": "; ?>
            <?php echo esc_attr($data) ."%";?>
        <?php } ;?></p></li>
    <?php endif; ?>
    <?php  if(isset($item_data['_line_tax'])): $data=$item_data['_line_tax'];?>
            <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Tax"  ,ST_TEXTDOMAIN) .": "; ?>
            <?php echo TravelHelper::format_money($data) ;?>
        <?php } ;?></p></li>
    <?php endif; ?>
    
</ul>