<?php
/*
 * Template Name: User Dashboard
*/
$user_link = get_permalink();
$current_user = wp_get_current_user();
$lever = $current_user->roles;
$lever = array_shift($lever);
$url_id_user = '';
if (!empty($_REQUEST['id_user'])) {
    $id_user_tmp = $_REQUEST['id_user'];
    $current_user = get_userdata($id_user_tmp);
    $url_id_user = $id_user_tmp;
}

$default_page = "setting";
if (STUser_f::check_lever_partner($lever) and st()->get_option('partner_enable_feature') == 'on') {
    $default_page = "setting";
}
$sc = get_query_var('sc');
if (empty($sc)) {
    $sc = 'setting';
}
//==== Redirect to user settings if not have a package
$admin_packages = STAdminPackages::get_inst();
if ($admin_packages->user_can_register_package(get_current_user_id()) && in_array($sc, array(
    'create-hotel',
    'my-hotel',
    'add-hotel-booking',
    'booking-hotel',
    'create-room',
    'my-room',
    'add-hotel-room-booking',
    'booking-hotel-room',
    'create-tours',
    'my-tours',
    'add-tour-booking',
    'booking-tours',
    'create-activity',
    'add-activity-booking',
    'my-activity',
    'booking-activity',
    'create-cars',
    'my-cars',
    'add-car-booking',
    'booking-cars',
    'create-rental',
    'my-rental',
    'add-rental-booking',
    'create-room-rental',
    'my-room-rental',
    'booking-rental',
    'create-flight',
    'my-flights',
    'add-flight-booking',
    'booking-booking',
))) {
    wp_redirect(TravelHelper::get_user_dashboared_link($user_link, 'setting'));
    exit();
}

echo st()->load_template('layouts/modern/common/header-userdashboard');
wp_enqueue_script('template-user-js');
wp_enqueue_script('user.js');

$show_menu = true;
$hide_menu_ins = ['create-hotel', 'edit-hotel', 'create-room', 'edit-room', 'create-room-rental', 'edit-room-rental', 'create-rental', 'edit-rental', 'create-tours', 'edit-tours', 'create-activity', 'edit-activity', 'create-cars', 'edit-cars', 'create-flight', 'edit-flight'];

if (STInput::get('sc') == 'inbox' && STInput::get('message_id')) {
    $show_menu = false;
}

if (in_array(STInput::get('sc'), $hide_menu_ins)) {
    $show_menu = false;
}
?>
<?php if ($sc == "details-owner") { ?>
    <?php echo st()->load_template('user/user', $sc); ?>
<?php } else { ?>
    <!-- <style type="text/css" media="screen">
        &::-webkit-scrollbar {
            width: 5px;
            height: 7px;
        }

        &::-webkit-scrollbar-button {
            width: 0px;
            height: 0px;
        }

        &::-webkit-scrollbar-thumb {
            background: #525965;
            border: 0px none #ffffff;
            border-radius: 0px;

            &:hover {
                background: #525965;
            }

            &:active {
                background: #525965;
            }
        }

        &::-webkit-scrollbar-track {
            background: transparent;
            border: 0px none #ffffff;
            border-radius: 50px;

            &:hover {
                background: transparent;
            }

            &:active {
                background: transparent;
            }
        }

        &::-webkit-scrollbar-corner {
            background: transparent;
        }
    </style> -->
    <?php
        $admin_packages = STAdminPackages::get_inst();
        $detected_device = st_detected_device();

        if ($detected_device->isMobile() || $detected_device->isTablet()) {
            $toggled = '';
        } else {
            $toggled = 'toggled';
        }
        ?>

    <!-- <header id="header" class="test">


        <div id="topbar">
            <div class="topbar-left">

                <a href="https://www.halalactivities.com/" class="logo hidden-xs">

                    <img src="https://www.halalactivities.com/wp-content/uploads/2019/05/Halalactivities-footer-logos.png" alt="">

                </a>

                <a href="https://www.halalactivities.com/" class="logo hidden-lg hidden-md hidden-sm">

                    <img src="https://www.halalactivities.com/wp-content/uploads/2019/05/Halalactivities-footer-logos.png" alt="">

                </a>
            </div>

            <div class="topbar-right">

                <ul class="st-list topbar-items">


                    <li class="topbar-item link-item">

                        <a href="https://api.whatsapp.com/send?phone=905356289999" class="login">+90 535 628 99 99</a>

                    </li>


                    <li class="topbar-item link-item">

                        <a href="#" class="login">+44 20 3289 3984</a>

                    </li>

                    <li class="dropdown dropdown-language hidden-xs hidden-sm">
                        <a href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">English <i class="fa fa-angle-down"></i></a>

                        <ul class="dropdown-menu">
                            <li><a href="https://www.halalactivities.com/ar/">العربية</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-currency hidden-xs hidden-sm">
                        <a href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            USD </a>
                        <ul class="dropdown-menu">
                        </ul>
                    </li>
                </ul>

            </div>

        </div>

    </header> -->

    <?php echo st()->load_template('layouts/modern/common/header/style', '1'); ?>

    <div class="user-banner">
        <img src="https://www.halalactivities.com/wp-content/uploads/2019/08/banner-6.png?id=12207" alt="Banner">
        <h1>User Profile</h1>
    </div>
    <div class="main-wrapper">
        <div class="nav user-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">Account</a></li>
        </div>

        <div class="page-wrapper chiller-theme <?php echo $toggled; ?>">
            <!-- <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
                <i class="fa fa-bars"></i>
            </a> -->

            <!-- sidebar-wrapper  -->
            <main class="page-content">
                <nav id="sidebar" class="">
                    <div class="sidebar-content">
                        <div class="sidebar-header">
                            <div class="user-pic">
                                <?php echo st_get_profile_avatar($current_user->ID, 50); ?>
                                <!-- <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg" alt="User picture"> -->
                            </div>
                            <div class="user-info">
                                <span class="user-name"><?php echo esc_html($current_user->display_name) ?></span>
                                <span class="user-role"><?php echo st_get_language('user_member_since') . mysql2date(' M Y', $current_user->data->user_registered); ?></span>
                            </div>
                        </div>
                        <?php
                            $check_upgrade = false;
                            // if (($lever == "subscriber" || $lever == 'contributor' || $lever == 'author' || $lever == 'editor') && $lever != 'administrator' && $lever != 'partner') {
                            if ($lever == 'partner') {
                                $check_upgrade = true;
                            }
                            ?>



                        <?php
                            if ($check_upgrade) {
                                $stas_partner = get_user_meta($current_user->ID, 'st_pending_partner', true);
                                if ($stas_partner == '1') { ?>
                                <div class="sidebar-header">
                                    <div class="user-upgrade">
                                        <button class="btn btn-primary btn-xs"><?php echo __('Waiting for approval', ST_TEXTDOMAIN); ?></button>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="sidebar-header">
                                    <div class="freelpand">
                                        <a href="" title=""><?php _e('Free Plan', ST_TEXTDOMAIN); ?></a>
                                    </div>
                                    <div class="user-upgrade">
                                        <a href="<?php echo $admin_packages->register_member_page(); ?>" title=""><?php _e('Upgrade', ST_TEXTDOMAIN); ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php
                            }
                            ?>
                        <div class="sidebar-menu">
                            <ul>
                                <?php if (!empty($_REQUEST['id_user'])) { ?>
                                    <li class="<?php if ($sc == 'setting-info') {
                                echo 'active';
                            } ?>">
                                        <a href="<?php echo add_query_arg('id_user', $url_id_user, TravelHelper::get_user_dashboared_link($user_link, 'setting-info')) ?>">
                                            <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_seting.svg"; ?>" alt="" class="st-icon-menu">
                                            <span><?php _e("Settings", ST_TEXTDOMAIN) ?></span>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <?php if (STUser_f::check_lever_partner($lever) and st()->get_option('partner_enable_feature') == 'on') : ?>
                                        <li class="sidebar-dropdown <?php if ($sc == 'dashboard' or $sc == 'dashboard-info') {
                                echo 'active';
                            } ?>">
                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'dashboard'); ?>">
                                                <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_dashboard.svg"; ?>" alt="" class="st-icon-menu">
                                                <span><?php _e("Dashboard", ST_TEXTDOMAIN) ?></span>
                                                <span class="badge fa fa-angle-down badge-warning"></span>
                                            </a>
                                            <div class="sidebar-submenu">
                                                <ul>
                                                    <?php if (STUser_f::_check_service_available_partner('st_hotel')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'st_hotel') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'st_hotel', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Hotel Statistics', ST_TEXTDOMAIN); ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (STUser_f::_check_service_available_partner('st_hotel')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'hotel_room') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'hotel_room', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Room Statistics', ST_TEXTDOMAIN); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (STUser_f::_check_service_available_partner('st_rental')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'st_rental') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'st_rental', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Rental Statistics', ST_TEXTDOMAIN); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (STUser_f::_check_service_available_partner('st_cars')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'st_cars') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'st_cars', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Car Statistics', ST_TEXTDOMAIN); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (STUser_f::_check_service_available_partner('st_tours')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'st_tours') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'st_tours', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Tour Statistics', ST_TEXTDOMAIN); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (STUser_f::_check_service_available_partner('st_activity')) : ?>
                                                        <li class="<?php if ($sc == 'dashboard-info' and STInput::request('type') == 'st_activity') {
                                echo 'active';
                            } ?>">
                                                            <a href="<?php echo add_query_arg('type', 'st_activity', TravelHelper::get_user_dashboared_link($user_link, 'dashboard-info')); ?>"><?php _e('Activity Statistics', ST_TEXTDOMAIN); ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php endif ?>

                                    <li class="<?php if ($sc == 'setting') {
                                echo 'active';
                            } ?>">
                                        <a href="<?php echo add_query_arg('id_user', $url_id_user, TravelHelper::get_user_dashboared_link($user_link, 'setting')) ?>">
                                            <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_seting.svg"; ?>" alt="" class="st-icon-menu">
                                            <span><?php _e("Profile", ST_TEXTDOMAIN) ?></span>
                                        </a>
                                    </li>
                                    <?php
                                            $custom_layout = st()->get_option('partner_custom_layout', 'off');
                                            $custom_layout_booking_history = st()->get_option('partner_custom_layout_booking_history', 'on');
                                            if ($custom_layout == "off") {
                                                $custom_layout_booking_history = "on";
                                            }
                                            ?>
                                    <?php if ($custom_layout_booking_history == "on") { ?>
                                        <li class="<?php if ($sc == 'booking-history') {
                                                echo 'active';
                                            } ?>">
                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-history'); ?>">
                                                <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_booking_his.svg"; ?>" alt="" class="st-icon-menu">
                                                <span><?php _e("Booking History", ST_TEXTDOMAIN) ?></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="<?php if ($sc == 'wishlist') {
                                                echo 'active';
                                            } ?>">
                                        <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'wishlist'); ?>">
                                            <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_wishlish.svg"; ?>" alt="" class="st-icon-menu">
                                            <span><?php _e("Wishlist", ST_TEXTDOMAIN) ?></span>
                                        </a>
                                    </li>

                                    <?php if (STUser_f::check_lever_partner($lever) and st()->get_option('partner_enable_feature') == 'on') : ?>
                                        <?php if ($lever != "administrator" && st()->get_option('enable_withdrawal', 'on') == 'on') { ?>

                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('withdrawal', 'withdrawal-history'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'withdrawal'); ?>">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_wishlish.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Withdrawal", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'withdrawal-history'); ?>"><?php _e("History", ST_TEXTDOMAIN) ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>

                                        <?php } ?>
                                        <?php if (STUser_f::_check_service_available_partner('st_hotel')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('my-hotel', 'create-hotel', 'edit-hotel', 'add-hotel-booking', 'booking-hotel', 'hotel-inventory', 'my-room', 'create-room', 'add-hotel-room-booking', 'booking-hotel-room'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_hotel.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Hotel", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-hotel'); ?>"><?php echo __('Add new hotel', ST_TEXTDOMAIN) ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-hotel'); ?>"><?php _e("My Hotel", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-hotel-booking'); ?>"><?php _e("Add Booking Hotel", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-hotel'); ?>"><?php _e("Booking Hotel", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'hotel-inventory'); ?>"><?php _e("Hotel Inventory", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-room'); ?>"><?php _e("My Room", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-room'); ?>"><?php esc_html_e('Add new room', 'traveler') ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-hotel-room-booking'); ?>"><?php _e("Add Booking Room", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-hotel-room'); ?>"><?php _e("Booking Room", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (STUser_f::_check_service_available_partner('st_tours')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('my-tours', 'create-tours', 'add-tour-booking', 'booking-tours'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_tour.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Tour", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-tours'); ?>"><?php _e("My Tour", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-tours'); ?>"><?php esc_html_e('Add new tour', ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-tour-booking'); ?>"><?php _e("Add Booking Tour", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-tours'); ?>"><?php _e("Tour Bookings", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (STUser_f::_check_service_available_partner('st_activity')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('create-activity', 'edit-activity', 'my-activity', 'booking-activity', 'add-activity-booking'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_activities.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Activity", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-activity'); ?>"><?php _e("My Activity", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li <?php if ($sc == 'create-activity') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-activity'); ?>"><?php esc_html_e('Add new activity', 'traveler') ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'add-activity-booking') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-activity-booking'); ?>"><?php _e("Add Booking Activity", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'booking-activity') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-activity'); ?>"><?php _e("Activity Bookings", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <!-- Car -->
                                        <?php if (STUser_f::_check_service_available_partner('st_cars')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('create-cars', 'edit-cars', 'my-cars', 'booking-cars', 'add-car-booking'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_car.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Car", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-cars'); ?>"><?php _e("My Car", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li <?php if ($sc == 'create-cars') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-cars'); ?>"><?php esc_html_e('Add new car', 'traveler') ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'add-car-booking') {
                                                echo 'class="active"';
                                            } ?>><a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-car-booking'); ?>"><?php _e("Add Booking Car", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'booking-cars') {
                                                echo 'class="active"';
                                            } ?>><a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-cars'); ?>"><?php _e("Car Bookings", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <!-- Rental -->
                                        <?php if (STUser_f::_check_service_available_partner('st_rental')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('create-rental', 'edit-rental', 'my-rental', 'create-room-rental', 'my-room-rental', 'booking-rental', 'add-rental-booking'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_hotel.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Rental", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-rental'); ?>"><?php _e("My Rental", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li <?php if ($sc == 'create-rental') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-rental'); ?>"><?php esc_html_e('Add new rental', 'traveler') ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'create-room-rental') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-room-rental'); ?>"><?php echo __('Add new Rental Room', ST_TEXTDOMAIN); ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'my-room-rental') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-room-rental'); ?>"><?php echo __('My Rental Room', ST_TEXTDOMAIN); ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'add-rental-booking') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'add-rental-booking'); ?>"><?php _e("Add Booking Rental", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'booking-rental') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-rental'); ?>"><?php _e("Rental Bookings", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <!-- Flight -->
                                        <?php if (STUser_f::_check_service_available_partner('st_flight')) : ?>
                                            <li class="sidebar-dropdown st-active <?php if (in_array($sc, array('create-flight', 'edit-flight', 'my-flights', 'booking-flight', 'add-flight-booking'))) {
                                                echo 'active';
                                            }  ?>">
                                                <a href="#">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_fly.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php _e("Flight", ST_TEXTDOMAIN) ?></span>
                                                </a>
                                                <div class="sidebar-submenu">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'my-flights'); ?>"><?php _e("My Flight", ST_TEXTDOMAIN) ?> <span class="badge fa fa-angle-down badge-success"></span></a>
                                                        </li>
                                                        <li <?php if ($sc == 'create-flight') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'create-flight'); ?>"><?php echo esc_html__('Add New Flight', ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                        <li <?php if ($sc == 'booking-flight') {
                                                echo 'class="active"';
                                            } ?>>
                                                            <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'booking-flight'); ?>"><?php _e("Flight Bookings", ST_TEXTDOMAIN) ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (is_super_admin()) : ?>
                                            <li class="<?php if (in_array($sc, array('list-refund'))) {
                                                echo "active";
                                            } ?>">
                                                <a href="<?php echo TravelHelper::get_user_dashboared_link($user_link, 'list-refund'); ?>">
                                                    <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_refund.svg"; ?>" alt="" class="st-icon-menu">
                                                    <span><?php echo __('Refund Manager', ST_TEXTDOMAIN); ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php } ?>
                                <?php do_action('st_more_user_menu', $user_link, $sc); ?>
                                <li>
                                    <a href="<?php echo wp_logout_url() ?>">
                                        <img src="<?php echo get_template_directory_uri() . "/v2/images/dashboard/ico_seting.svg"; ?>" alt="" class="st-icon-menu">
                                        <span><?php echo __('Log Out', ST_TEXTDOMAIN) ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div class="sidebar-footer">
                            <ul>
                                
                            </ul>
                        </div> -->
                        <!-- sidebar-menu  -->
                    </div>
                    <!-- sidebar-content  -->
                </nav>
                <div class="st_content">
                    <?php
                        if (!empty($_REQUEST['id_user'])) {
                            echo st()->load_template('user/user', 'setting-info', get_object_vars($current_user));
                        } else {
                            if (STUser_f::check_lever_partner($lever)) {
                                if (STUser_f::check_lever_service_partner($sc, $lever)) {
                                    switch ($sc) {
                                        case "create-hotel":
                                            $sc = "edit-hotel";
                                            break;
                                        case "create-room":
                                            $sc = "edit-room";
                                            break;
                                        case "create-rental":
                                            $sc = "edit-rental";
                                            break;
                                        case "create-room-rental":
                                            $sc = "edit-room-rental";
                                            break;
                                        case "create-tours":
                                            $sc = "edit-tours";
                                            break;
                                        case "create-cars":
                                            $sc = "edit-cars";
                                            break;
                                        case "create-activity":
                                            $sc = "edit-activity";
                                            break;
                                        case "create-flight":
                                            $sc = "edit-flight";
                                            break;
                                    }
                                    echo st()->load_template('user/user', $sc, get_object_vars($current_user));
                                } else {
                                    _e("You don't have permission to access this page", ST_TEXTDOMAIN);
                                }
                            } else {
                                $arr_page_menu = ["overview", "setting", "setting-info", "wishlist", "booking-history", "certificate", "write_review", "inbox"];
                                if (in_array($sc, apply_filters('st_menu_link_page', $arr_page_menu))) {
                                    // echo st()->load_template('user/user', $sc, get_object_vars($current_user));

                                    //Ajax tabs start here?>
                                    <div class="user_page_tabs" data-user_tab="settings_tab">
                                        <?php echo st()->load_template('user/user', 'setting', get_object_vars($current_user)); ?>
                                    </div>
                                    <div class="user_page_tabs" data-user_tab="booking_tab">
                                        <?php echo st()->load_template('user/user', 'booking-history', get_object_vars($current_user)); ?>
                                    </div>
                                    <div class="user_page_tabs" data-user_tab="wishlist_tab">
                                        <?php echo st()->load_template('user/user', 'wishlist', get_object_vars($current_user)); ?>
                                    </div>
                        <?php
                                } else {
                                    echo st()->load_template('user/user', 'setting', get_object_vars($current_user));
                                }
                            }

                            $arr_other_menu = array();
                            if (in_array($sc, apply_filters('st_more_user_menu_link_page', $arr_other_menu))) {
                                echo apply_filters('st_more_content_page', '', $sc);
                            }
                        } ?>
                </div>

                <?php
                    $is_expired = $admin_packages->is_package_expired(get_current_user_id());

                    if ($is_expired) {
                        echo st()->load_template('user/user', 'alert_package');
                    }

                    echo st()->load_template('layouts/modern/common/footer-userdashboard');
                    ?>
            </main>
            <div class="sidenav-overlay"></div>
            <!-- page-content" -->
        </div>

    </div>

<?php } ?>