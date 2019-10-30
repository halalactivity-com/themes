<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 11:19 AM
 */
get_header('hotel-activity'); ?>
    <?php
    if ( isset( $style ) && $style == 3 ) : ?>
        <div class="st-single-hotel-modern-page sts-single-room-alone style-3">
            <?php echo st()->load_template( 'layouts/modern/single_hotel/elements/banner', '', array( 'is_room_alone' => true, 'style' => $style ) ); ?>

            <?php
            while (have_posts()) {
                the_post();
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-lg-push-9 col-md-push-8">
                            <?php echo st()->load_template( 'layouts/modern/single_hotel/room/book-form' ); ?>
                        </div>
                        <div class="col-lg-9 col-md-8 col-lg-pull-3 col-md-pull-4">
                            <h3 class="section-title sts-pf-font"><?php echo __( 'Summary', ST_TEXTDOMAIN ); ?></h3>
                            <?php echo st()->load_template( 'layouts/modern/single_hotel/room/facility' ); ?>
                            <div class="desc">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/attributes' );
                    ?>
                </div>
                <div class="container">
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/gallery', 'grid' ); ?>
                </div>
                <div class="container">
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template( 'layouts/modern/single_hotel/room/facility', 'detail' ); ?>
                </div>
                <?php
                $address = get_post_meta( get_the_ID(), 'address', true );
                $hotel_room = get_post_meta( get_the_ID(), 'room_parent', true );
                $hotel_map_longitude = get_post_meta( $hotel_room, 'map_lng', true );
                $hotel_map_latitude = get_post_meta( $hotel_room, 'map_lat', true );
                $hotel_address = get_post_meta( $hotel_room, 'address', true );
                $hotel_map_zoom = get_post_meta( $hotel_room, 'map_zoom', true);
                $location_tmp = new stdClass();
                $location_tmp->location_name = $hotel_address;
                $location_tmp->location_address = $address;
                $location_tmp->location_longitude = $hotel_map_longitude;
                $location_tmp->location_latitude = $hotel_map_latitude;
                $list_location = urlencode( json_encode( [
                    $location_tmp
                ] ));
                echo do_shortcode( '<div class="mt-80">[st_hotel_alone_mapbox map_zoom="'.$hotel_map_zoom.'" list_location="'.$list_location.'" ]</div>' );
                ?>
                <?php
                echo st()->load_template('layouts/modern/single_hotel/room/other_rooms');
            }
            wp_reset_query();
            ?>
        </div>
        <?php
    else : ?>
        <div class="st-single-hotel-modern-page sts-single-room-alone">
            <?php echo st()->load_template('layouts/modern/single_hotel/elements/banner', '', array('is_room_alone' => true)); ?>

            <?php
            while (have_posts()) {
                the_post();
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-lg-push-9 col-md-push-8">
                            <?php echo st()->load_template('layouts/modern/single_hotel/room/book-form'); ?>
                        </div>
                        <div class="col-lg-9 col-md-8 col-lg-pull-3 col-md-pull-4">
                            <h3 class="section-title sts-pf-font"><?php echo __('Summary', ST_TEXTDOMAIN); ?></h3>
                            <?php echo st()->load_template('layouts/modern/single_hotel/room/facility'); ?>
                            <div class="desc">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="sts-hr"></div>
                    <?php
                    echo st()->load_template('layouts/modern/single_hotel/room/attributes');
                    ?>
                </div>
                <?php
                echo st()->load_template('layouts/modern/single_hotel/room/gallery');
                echo st()->load_template('layouts/modern/single_hotel/room/other_rooms');
                echo do_shortcode('[st_single_hotel_check_availability_new title="'. __('BOOK YOUR STAY', ST_TEXTDOMAIN) .'"]');
            }
            wp_reset_query();
            ?>
        </div>
        <?php
    endif; ?>
<?php get_footer('hotel-activity'); ?>