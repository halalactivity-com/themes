(function($) {
  'use strict'
  $(function() {
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('#header-menu-left').outerHeight();
    var hasScrolled = function() {
      var st = $(window).scrollTop();
      if (Math.abs(lastScrollTop - st) <= delta) return;
      if (st > lastScrollTop && st > navbarHeight || st == 0) {
        $('header#header-menu-left').removeClass('sticky');
      } else {
        if ( st + $(window).height() < $(document).height()) {
          $("header#header-menu-left").addClass('sticky');
        }
      }
      lastScrollTop = st;
    };
    $(window).scroll(function(e) {
      didScroll = true;
    });
    setInterval(function() {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 250);
  })
})(jQuery);

(function($) {
  'use strict'
  let body = $('body');
  let divAsideMenuLeft = $('aside.aside-menu-left');
  let btnToggleMenuLeft = $('header .btn-toggle-menu-left');
  let btnToggleCloseMenuLeft = $('aside .btn-toggle-close-menu-left');

  function toggleBody(el) {
    body.toggleClass('overflow-visible');
    $('body').css({
      'overflow': 'visible'
    });
  }

  btnToggleMenuLeft.on('click', function(e) {
    e.preventDefault();
    toggleBody(divAsideMenuLeft);
    divAsideMenuLeft.toggleClass('open');
  });
  btnToggleCloseMenuLeft.on('click', function(e) {
    toggleBody(divAsideMenuLeft);
    divAsideMenuLeft.toggleClass('open');
    e.preventDefault();
  });
  body.click(function (ev) {
    if ($(ev.target).is('aside.aside-menu-left')) {
      toggleBody($(ev.target));
      body.addClass('overflow-visible')
      divAsideMenuLeft.removeClass('open');
    }
  });

  let hotelActivityListRoom = $('.hotel-activity-list-room.style-2');
  hotelActivityListRoom.find('.ico-next').on('click', function(e) {
    if (hotelActivityListRoom.find('.nav-tabs > li:nth-last-child(2)').hasClass('active')) {
      hotelActivityListRoom.find('.nav-tabs > li').first('li').find('a').trigger('click');
    } else {
      hotelActivityListRoom.find('.nav-tabs > .active').next('li').find('a').trigger('click');
    }
  });
})(jQuery)