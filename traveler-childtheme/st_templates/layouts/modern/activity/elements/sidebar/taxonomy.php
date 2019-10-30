<div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4>Tags<?php //echo $title; ?></h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php New_Layout_Helper::listTaxTreeFilter($taxonomy, 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>
<?php /*
<div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4>Category</h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php New_Layout_Helper::listTaxTreeFilter("categories", 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>
*/?>
<!-- <div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4>Food Availability Nearby</h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php //New_Layout_Helper::listTaxTreeFilter("nearby-food-availability", 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php //echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div> -->
<div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4>Activities</h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php New_Layout_Helper::listTaxTreeFilter("activity", 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>
<div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4>Season</h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php New_Layout_Helper::listTaxTreeFilter("season", 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>
<div class="sidebar-item pag st-icheck">
    <div class="item-title">
        <h4><img src="http://www.halalactivities.com/demo/wp-content/uploads/2019/08/crown.svg" alt="">VIP Section</h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <?php New_Layout_Helper::listTaxTreeFilter("vip-section", 0, -1, 'st_activity'); ?>
        </ul>
        <button class="btn btn-link btn-more-item"><?php echo __('More', ST_TEXTDOMAIN); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>