<div class="info">
    <div class="row">
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('First name ' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_first_name', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Last name ' , ST_TEXTDOMAIN) ; ?></strong>:
                <?php echo get_post_meta($order_id, 'st_last_name', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Email ' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_email', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Phone ' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_phone', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Address Line 2' , ST_TEXTDOMAIN ) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_address2', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('City' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_city', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('State/Province/Region' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_province', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('ZIP code/Postal code' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_zip_code', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Country' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_country', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Special Requirements' , ST_TEXTDOMAIN) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_note', true) ?>
            </div>
        </div>
    </div>

</div>