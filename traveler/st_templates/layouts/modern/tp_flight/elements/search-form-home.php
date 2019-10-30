<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Content search flight
 *
 * Created by ShineTheme
 *
 */

wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' );
wp_enqueue_script('affilate-api.js');

$fields = array(
    array(
        'title' => esc_html__('Origin', ST_TEXTDOMAIN),
        'name' => 'origin',
        'placeholder' => esc_html__('Origin', ST_TEXTDOMAIN),
        'layout_col' => '6',
        'layout2_col' => '6',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Destination', ST_TEXTDOMAIN),
        'name' => 'destination',
        'placeholder' => esc_html__('Destination', ST_TEXTDOMAIN),
        'layout_col' => '6',
        'layout2_col' => '6',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Depart date', ST_TEXTDOMAIN),
        'name' => 'depart',
        'placeholder' => esc_html__('Depart date', ST_TEXTDOMAIN),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Return date', ST_TEXTDOMAIN),
        'name' => 'return',
        'placeholder' => esc_html__('Return date', ST_TEXTDOMAIN),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'off'
    ),
    array(
        'title' => esc_html__('Passengers/Class', ST_TEXTDOMAIN),
        'name' => 'passengers-class',
        'placeholder' => esc_html__('Passengers/Class', ST_TEXTDOMAIN),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'off'
    )
);

$st_direction = !empty($st_direction) ? $st_direction : "horizontal";

$marker = st()->get_option('tp_marker', '124778');
$class = '';
$id = 'id="sticky-nav"';
if(isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}

if (!isset($field_size)) $field_size = '';
?>
<div class="search-form hotel-search-form-home hotel-search-form <?php echo $class; ?>" <?php echo $id; ?>>
    <?php
    $tp_show_api_info = st()->get_option('tp_show_api_info', 'on');
    $use_whitelabel = st()->get_option('tp_redirect_option', 'off');
    $action = 'https://jetradar.com/searches/new';
    $target = '_blank';
    $button_class = '';
    if($use_whitelabel == 'on'){
        $button_class = 'btn-tp-search-flights';
        $action = '';
        $target = '_self';
        $page_id = st()->get_option('tp_whitelabel_page','');

        if(empty($page_id)){
            $whitelabel_name = st()->get_option('tp_whitelabel', 'whilelabel.travelerwp.com');
        }else{
            $whitelabel_name = get_permalink($page_id).'/#/flights';
        }
        echo '<input type="hidden" id="current_url" name="current_url" value="'.esc_url($whitelabel_name).'/">';
    }
    ?>
    <form role="search" method="get" class="search main-search" autocomplete="off" action="<?php echo esc_url($action); ?>" target="<?php echo esc_attr($target); ?>">
        <input type="hidden" name="marker" value="<?php echo esc_attr($marker); ?>">
        <div class="row">
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-lg-6 field-origin">
                        <?php echo TravelHelper::getNewIcon('ico_maps_search_box'); ?>
                        <?php echo st()->load_template('layouts/modern/travelpayouts_api/search/flight/field-origin'); ?>
                    </div>
                    <div class="col-lg-6 field-destination">
                        <?php echo st()->load_template('layouts/modern/travelpayouts_api/search/flight/field-destination'); ?>
                        <span class="border-right"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-6 field-depart">
                        <?php echo TravelHelper::getNewIcon('ico_calendar_search_box'); ?>
                        <?php echo st()->load_template('layouts/modern/travelpayouts_api/search/flight/field-depart'); ?>
                    </div>
                    <div class="col-lg-6 field-return">
                        <?php echo st()->load_template('layouts/modern/travelpayouts_api/search/flight/field-return'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 field-passenger">
                <?php echo st()->load_template('layouts/modern/travelpayouts_api/search/flight/field-passengers-class'); ?>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary btn-lg <?php echo esc_attr($button_class); ?>" type="submit"><?php echo esc_html__('SEARCH', ST_TEXTDOMAIN); ?></button>
            </div>
        </div>
        <?php if($use_whitelabel == 'on'){
            echo '<input type="hidden" name="with_request" value="true">';
        } ?>
    </form>
</div>