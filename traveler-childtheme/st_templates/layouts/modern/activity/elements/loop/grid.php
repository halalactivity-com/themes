<?php

global $wpdb, $post;

$info_price = STActivity::inst()->get_info_price();

$url=st_get_link_with_search(get_permalink(),array('start'),$_GET);

$post_id = get_the_ID();

$check_in = strtotime( TravelHelper::convertDateFormat( $_GET['start'] ) );

$result = $wpdb->get_row("SELECT *, Count(*) AS `Total` from `wp_st_activity_availability` WHERE `post_id` = '$post_id' AND `check_in` = '$check_in' ");

$flag = 0;
if( $result->Total == 0 ){
    $flag = 1;
}

$class = 'col-lg-4 col-md-6 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';

if(isset($top_search) and $top_search)

    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';

if(isset($slider) and $slider)

    $class = 'item-service grid-item has-matchHeight';

?>

<div class="<?php echo esc_attr($class); ?>">

    <div class="service-border">

        <div class="thumb">

            <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>

                <?php echo STFeatured::get_sale($info_price['discount']); ?>

            <?php } ?>

            <?php if(is_user_logged_in()){ ?>

                <?php $data = STUser_f::get_icon_wishlist();?>

                <div class="service-add-wishlist login <?php echo $data['status'] ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', ST_TEXTDOMAIN) : __('Add to wishlist', ST_TEXTDOMAIN); ?>">

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

            <?php echo st_get_avatar_in_list_service(get_the_ID(),35)?>

        </div>

        <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>

            <p class="service-location plr15"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>

        <?php endif;?>

        <h4 class="service-title plr15"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>



        <div class="service-review plr15">

            <ul class="icon-group text-color booking-item-rating-stars">

                <?php

                $avg = STReview::get_avg_rate();

                echo TravelHelper::rate_to_string($avg);

                ?>

            </ul>

            <?php

            $count_review = STReview::count_comment(get_the_ID());

            ?>

            <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', ST_TEXTDOMAIN),esc_html__('Reviews', ST_TEXTDOMAIN),$count_review); ?></span>

        </div>



        <div class="section-footer">

            <div class="footer-inner plr15">
                
                <?php
                    if( !empty($check_in) && $flag == 1 ) {
                ?>
                <p class="not-available-red" style="margin-right: 0; width: 50%; float: left;">
                    Not available on your selected dates.
                </p>
                <?php
                    }
                ?>
                <div class="service-price">

                    <span>

                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>

                            <span class="fr_text"><?php _e("from", ST_TEXTDOMAIN) ?></span>

                    </span>

                    <span class="price">

                        <?php
                        $post_id = get_the_ID();
                        if(STTour::get_price_type($post_id) == 'fixed'){
                            $group_price  = get_post_meta( $post_id, 'group_price', true );
                            $init_base_price = TravelHelper::format_money( $group_price[0]['group_price'] );
                        ?>
                        <span data-grp-prices='<?php echo htmlspecialchars(json_encode($group_price), ENT_QUOTES, 'UTF-8'); ?>' class="text-lg lh1em item "><?php echo $init_base_price; ?></span>
                        <?php
                        }
                        else{
                            echo STActivity::inst()->get_price_html(get_the_ID());
                        }

                        ?>

                    </span>

                </div>

            </div>

        </div>

    </div>

</div>