<?php
$start = STInput::post('check_in', date(TravelHelper::getDateFormat()));
$end = STInput::post('check_out', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));
$adult_number = STInput::post('adult_number', 0);
$child_number = STInput::post('child_number', 0);
$infant_number = STInput::post('infant_number', 0);

global $wpdb;
$post_id = get_the_ID();
$d = new DateTime('+2day');
$tomorrow = $d->format('d');
$thisMonth = date("F", mktime(0, 0, 0, date("m"), 10));
$thisYear = date("Y");
$thisTime = strtotime($tomorrow . " " . $thisMonth . " " . $thisYear);
$result = $wpdb->get_row("SELECT *, Count(*) AS `Total` from `wp_st_activity_availability` WHERE `post_id` = '$post_id' AND `check_in` = '$thisTime' ");


$adult_price = $result->adult_price;//get_post_meta(get_the_ID(), 'adult_price', true);
$child_price = $result->child_price;//get_post_meta(get_the_ID(), 'child_price', true);
$infant_price = $result->infant_price;//get_post_meta(get_the_ID(), 'infant_price', true);
$adult_age_range = get_post_meta(get_the_ID(), 'adult_age_range', true);
$child_age_range = get_post_meta(get_the_ID(), 'child_age_range', true);

$max_people = get_post_meta(get_the_ID(), 'max_people', true);

if(empty($max_people) or $max_people <= 0)
    $max_people = 20;

$has_icon = (isset($has_icon))? $has_icon: false;
$hide_adult = get_post_meta(get_the_ID(), 'hide_adult_in_booking_form', true);
$hide_children = get_post_meta(get_the_ID(), 'hide_children_in_booking_form', true);
$hide_infant = get_post_meta(get_the_ID(), 'hide_infant_in_booking_form', true);
?>

<div class="form-group form-guest-search clearfix <?php if($has_icon) echo ' has-icon '; ?>">
    <?php
    if($has_icon){
        echo TravelHelper::getNewIcon('ico_calendar_search_box');
    }
    ?>
    <?php if($hide_adult != 'on'): ?>
    <div class="guest-wrapper clearfix">
        <div class="check-in-wrapper">
            <label><?php echo __('Adults', ST_TEXTDOMAIN); ?></label>
            <div class="render"><?php echo "Age " . $adult_age_range . "+";//echo sprintf(__( '%s', ST_TEXTDOMAIN ),$tour_guest_adult); ?></div>
        </div>
        <div class="select-wrapper">
            <div class="st-number-wrapper">
                <input type="text" name="adult_number" data-price="<?php echo TravelHelper::just_money($adult_price);?>" value="<?php echo esc_html($adult_number); ?>" class="form-control st-input-number adult_price" autocomplete="off" readonly data-min="0" data-max="<?php echo esc_attr($max_people); ?>"/>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($hide_children != 'on'): ?>
    <div class="guest-wrapper clearfix">
        <div class="check-in-wrapper">
            <label><?php echo __('Children', ST_TEXTDOMAIN); ?></label>
            <div class="render"><?php echo "Age ". $child_age_range . "-" .$adult_age_range;//echo sprintf(__( '%s', ST_TEXTDOMAIN ),$tour_guest_children); ?></div>
        </div>
        <div class="select-wrapper">
            <div class="st-number-wrapper">
                <input type="text" name="child_number" data-price="<?php echo TravelHelper::just_money($child_price);?>" value="<?php echo esc_html($child_number); ?>" class="form-control st-input-number child_price" autocomplete="off" readonly data-min="0" data-max="<?php echo $max_people; ?>"/>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($hide_infant != 'on'): ?>
    <div class="guest-wrapper clearfix">
        <div class="check-in-wrapper">
            <label><?php echo __('Infant', ST_TEXTDOMAIN); ?></label>
            <div class="render"><?php echo "Age 0-" . $child_age_range;//echo sprintf(__( '%s', ST_TEXTDOMAIN ),$tour_guest_infant); ?></div>
        </div>
        <div class="select-wrapper">
            <div class="st-number-wrapper">
                <input type="text" name="infant_number" data-price="<?php echo TravelHelper::just_money($infant_price);?>" value="<?php echo $infant_number; ?>" class="form-control st-input-number infant_price" autocomplete="off" readonly data-min="0" data-max="<?php echo $max_people; ?>"/>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>