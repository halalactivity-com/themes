<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-2018
 * Time: 5:10 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
$args = [
    'post_type' => 'st_hotel',
    'posts_per_page' => $posts_per_page,
    'post__in' => explode(',', $ids),
];


    if (st_check_service_available('st_hotel')) {
        $st_pride_query = new WP_Query($args);
        $html = '<div class="services-grid"><div class="row">';
        while ($st_pride_query->have_posts()):
            $st_pride_query->the_post();
            $html .= st()->load_template('layouts/modern/hotel/loop/grid', '');
        endwhile;
        wp_reset_postdata();
        $html .= '</div></div>';
        echo balanceTags($html); ?>
        <div class="row st-loadmore loadmore-ccv">
            <div class="col-md-12 load-ajax-icon">
                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
            </div>
            <div class="text-center st-button-loadmore">
                <div class="control-loadmore text-center">
                    <a class="load_more_post st-button--main" href="#" data-posts-per-page="<?php echo (int)$posts_per_page;?>" data-paged="1" type_service="st_hotel"  data-id_service = "<?php echo $ids ?>" check-all="true" ><?php echo esc_html__('Load more' ,ST_TEXTDOMAIN)  ?></a>

                </div>

            </div>
        </div>
    <?php }
?>
    

