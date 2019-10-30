<?php

global $wpdb, $post;

$info_price = STActivity::inst()->get_info_price();

$url=st_get_link_with_search(get_permalink(),array('start'),$_GET);

$post_id = get_the_ID();

$check_in = strtotime( TravelHelper::convertDateFormat( $_GET['start'] ) );

$check_out = strtotime( TravelHelper::convertDateFormat( $_GET['end'] ) );

$result = $wpdb->get_row("SELECT *, Count(*) AS `Total` from `wp_st_activity_availability` WHERE `post_id` = '$post_id' AND `check_in` = '$check_in' ");

$flag = 0;
if( $result->Total == 0 ){
    $flag = 1;
}
?>

<div class="item-service">
    <div class="service-border">
        <div class="row item-service-wrapper has-matchHeight">

            <div class="col-sm-4 thumb-wrapper">

                <div class="thumb">

                    <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>

                        <?php echo STFeatured::get_sale($info_price['discount']); ?>

                    <?php } ?>

                    <?php if(is_user_logged_in()){ ?>

                        <?php $data = STUser_f::get_icon_wishlist();?>

                        <div class="service-add-wishlist login <?php echo $data['status'] ? 'added' : ''; ?>" data-id="<?php echo $post_id; ?>" data-type="<?php echo get_post_type($post_id); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', ST_TEXTDOMAIN) : __('Add to wishlist', ST_TEXTDOMAIN); ?>">

                            <i class="fa fa-heart"></i>

                            <div class="lds-dual-ring"></div>

                        </div>

                    <?php }else{ ?>

                        <a href="" class="login" data-toggle="modal" data-target="#st-login-form">

                            <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', ST_TEXTDOMAIN); ?>">

                                <i class="fa fa-heart"></i>

                                <div class="lds-dual-ring"></div>

                            </div>

                        </a>

                    <?php } ?>

                    <div class="service-tag bestseller">

                        <?php echo STFeatured::get_featured(); ?>

                    </div>

                    <a href="<?php echo esc_url($url); ?>">

                        <?php

                        if(has_post_thumbnail()){

                            the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));

                        }else{

                            echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';

                        }

                        ?>

                    </a>

                </div>

            </div>

            <div class="col-sm-5 item-content">

                <div class="item-content-w">

                    <h4 class="service-title"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>

                    <?php if ($address = get_post_meta($post_id, 'address', TRUE)): ?>

                    <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo $address; ?></p>

                    <?php endif;?>

                    <div class="service-review">

                        <ul class="icon-group text-color booking-item-rating-stars">

                            <?php

                            $avg = STReview::get_avg_rate();

                            echo TravelHelper::rate_to_string($avg);

                            ?>

                        </ul>

                        <?php

                        $count_review = STReview::count_comment($post_id);

                        ?>

                        <span class="review"><?php echo $count_review . ' ' . _n(esc_html__('Review', ST_TEXTDOMAIN),esc_html__('Reviews', ST_TEXTDOMAIN),$count_review); ?></span>

                    </div>

                    <div class="service-excerpt">

                        <?php echo New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 15); ?>

                    </div>



                    <div class="service-content-footer hidden-xs">

                        <?php

                        $duration = get_post_meta($post_id, 'duration', true);

                        if(!empty($duration)){

                            ?>

                            <div class="service-duration">

                                <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>

                                <?php echo esc_html($duration); ?>

                            </div>

                            <?php

                        }



                        $is_cancel = get_post_meta($post_id, 'st_allow_cancel', true);
                        $cancellation_day= (int)get_post_meta( $post_id, 'st_cancel_number_days', true );
                        echo '<div class="service-cancel">';

                            echo TravelHelper::getNewIcon('currency-dollar-bubble', '#5E6D77', '17px', '17px');

                            if( $is_cancel == 'on' ){
                                if( $cancellation_day == 0 ){
                                    echo __( 'Fully Refundable', ST_TEXTDOMAIN);
                                }
                                else{
                                    if( $cancellation_day > 1 )
                                        echo sprintf(__( 'Up to %s days', ST_TEXTDOMAIN ), $cancellation_day);
                                    else
                                        echo sprintf(__( 'Up to %s day', ST_TEXTDOMAIN ), $cancellation_day);
                                }
                            }
                            else {
                               echo __('Non Refundable', ST_TEXTDOMAIN);
                            }

                        echo '</div>';

                        ?>

                    </div>

                </div>

            </div>

            <div class="col-sm-3 section-footer">



                <div class="st-center-y">

                    <div class="service-price">

                            <span class="price-text">

                                <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '16px', '16px'); ?>

                                <span class="fr_text"><?php _e("from", ST_TEXTDOMAIN) ?></span>

                            </span>

                        <span class="price">

                            <?php
                                if(STTour::get_price_type($post_id) == 'fixed'){
                                    $group_price  = get_post_meta( $post_id, 'group_price', true );
                                    $init_base_price = TravelHelper::format_money( $group_price[0]['group_price'] );
                                    // var_dump($group_price);
                                ?>
                                <span data-grp-prices='<?php echo htmlspecialchars(json_encode($group_price), ENT_QUOTES, 'UTF-8'); ?>' class="text-lg lh1em item "><?php echo $init_base_price; ?></span>
                                <?php
                                }
                                else {
                                    echo STActivity::inst()->get_price_html($post_id);
                                }
                            ?>

                        </span>

                    </div>
                    <?php

                        if( !empty($check_in) && $flag == 1 ) {
                    ?>
                    <p class="not-available-red">
                        Not available on your selected dates.
                    </p>
                    <?php
                        }
                    ?>

                    <a href="<?php echo esc_url($url) ?>" class="btn btn-primary btn-view-more"><?php echo __('VIEW DETAILS', ST_TEXTDOMAIN); ?></a>

                </div>



                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>

                    <?php echo STFeatured::get_sale($info_price['discount']); ?>

                <?php } ?>

            </div>
        </div>
    </div>
    <div class="mobile-service-border row">        
        <div class="thumb col-xs-5">
            <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                <?php echo STFeatured::get_sale($info_price['discount']); ?>
            <?php } ?>
            <?php if(is_user_logged_in()){ ?>
                <?php $data = STUser_f::get_icon_wishlist();?>
                <div class="service-add-wishlist login <?php echo $data['status'] ? 'added' : ''; ?>" data-id="<?php echo $post_id; ?>" data-type="<?php echo get_post_type($post_id); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', ST_TEXTDOMAIN) : __('Add to wishlist', ST_TEXTDOMAIN); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php }else{ ?>
                <a href="" class="login" data-toggle="modal" data-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', ST_TEXTDOMAIN); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>">
                <?php
                    if(has_post_thumbnail()){
                        the_post_thumbnail(array(680, 500), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                    }else{
                        echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                    }
                ?>
            </a>
            <?php echo st_get_avatar_in_list_service($post_id,35)?>
        </div>
        <div class="rest col-xs-7">
            <h4 class="service-title plr15"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>
            <?php if ($address = get_post_meta($post_id, 'address', TRUE)): ?>
                <p class="service-location plr15  st-flex justify-left"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><span class="ml5"><?php echo $address; ?></span></p>
            <?php endif;?>
            <div class="service-review plr15">
                <ul class="icon-group text-color booking-item-rating-stars">
                    <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                    ?>
                </ul>
                <?php
                    $count_review = STReview::count_comment($post_id);
                ?>
                <span class="review"><?php echo $count_review . ' ' . _n(esc_html__('Review', ST_TEXTDOMAIN),esc_html__('Reviews', ST_TEXTDOMAIN),$count_review); ?></span>
            </div>
            <div class="section-footer">
                <div class="footer-inner plr15">
                    <div class="service-price">
                        <span>
                            <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                            <span class="fr_text"><?php _e("from", ST_TEXTDOMAIN) ?></span>
                        </span>
                        <span class="price">
                            <?php
                                if(STTour::get_price_type($post_id) == 'fixed'){
                                    $group_price  = get_post_meta( $post_id, 'group_price', true );
                                    $init_base_price = TravelHelper::format_money( $group_price[0]['group_price'] );
                                    // var_dump($group_price);
                                ?>
                                <span data-grp-prices='<?php echo htmlspecialchars(json_encode($group_price), ENT_QUOTES, 'UTF-8'); ?>' class="text-lg lh1em item "><?php echo $init_base_price; ?></span>
                                <?php
                                }
                                else {
                                    echo STActivity::inst()->get_price_html($post_id);
                                }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>