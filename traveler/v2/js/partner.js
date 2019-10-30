jQuery(function($) {
    $(".sidebar-dropdown").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).find(".sidebar-submenu").slideDown(200);
            $(this).addClass("active");
        }
    });
    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
        $('body').removeClass('with-panel-right-reveal');
        $(".with-panel-right-reveal .sidenav-overlay").hide();
    });
    $(".sidenav-overlay").click(function() {
        $(".page-wrapper").removeClass("toggled");
        $('body').removeClass('with-panel-right-reveal');
        $(".with-panel-right-reveal .sidenav-overlay").hide();
    });
    $("#show-sidebar").click(function() {
        $('body').addClass('with-panel-right-reveal');
        $(".page-wrapper").addClass("toggled");
        $(".with-panel-right-reveal .sidenav-overlay").show();
    });
    /*Data chart*/
    $('#mySelect-tab').on('change', function (e) {
        // $('#myTab li a').eq($(this).val()).tab('show');
        var id = $(this).val();
        console.log(id);
        $('#myTab li a[href="#' + id + '"]').tab('show');
    });
    let partnerSearchFormInput = $('.partner-search-form input[name=_s]');
    let partnerSearchFormButton = $('.partner-search-form button[type=submit]');
    partnerSearchFormButton.prop('disabled', true);
    partnerSearchFormInput.on('keyup', function(e) {
        if ($(this).val().trim()) {
            partnerSearchFormButton.prop('disabled', false);
        } else {
            partnerSearchFormButton.prop('disabled', true);
        }
    });
});
