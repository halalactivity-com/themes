jQuery(document).ready(function () {
    jQuery(".user_page_tabs").click(function (e) {
        e.preventDefault();
        user_tab = jQuery(this).attr("data-user_tab");
        console.log(user_tab);
        // jQuery.ajax({
        //     type: "post",
        //     dataType: "json",
        //     url: user_page_tabs.ajaxurl,
        //     data: { nonce: nonce },
        //     success: function (response) {
        //         // Do something
        //         console.log('clicked');
        //     }
        // });
    });
});