"use strict";

(function ($) {
  $(document).ready(function () {
    var $tabLinks = $(".tabs__link");
    var $tabs = $(".tabs__tab");
    var $tabLinkItems = $(".tabs__link-item");
    $tabLinks.each(function (index) {
      $(this).on("click", function (event) {
        event.preventDefault(); // Remove active classes

        $tabLinkItems.removeClass("tabs__link-item--active");
        $tabs.removeClass("tabs__tab--active");
        $tabLinkItems.eq(index).addClass("tabs__link-item--active");
        $tabs.eq(index).addClass("tabs__tab--active");
      });
    });
  });
  var ads = $('#rotating-ads img');
  var currentIndex = 0;
  $(ads[currentIndex]).css('opacity', 1);

  if (ads.length > 1) {
    setInterval(function () {
      $(ads[currentIndex]).animate({
        opacity: 0
      }, 1000);
      currentIndex = (currentIndex + 1) % ads.length;
      $(ads[currentIndex]).animate({
        opacity: 1
      }, 1000);
    }, 2000);
  }

  var swiper2 = new Swiper(".ngjarjeSlider", {
    slidesPerView: 1,
    spaceBetween: 0,
    grid: {
      rows: 1,
      fill: "row"
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    breakpoints: {
      1200: {
        slidesPerView: 4,
        spaceBetween: 40
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 20
      }
    }
  });
  var swiper = new Swiper(".mySwiper", {
    slidesPerView: 2,
    spaceBetween: 10,
    autoplay: {
      delay: 2000,
      disableOnInteraction: false
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    breakpoints: {
      1024: {
        slidesPerView: 4,
        spaceBetween: 40
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 30
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 20
      }
    }
  }); // TODO Youtube Iframe

  $('.youtubeiFrame').on('click', function () {
    if ($(this).data('iframeurl')) {
      $(this).find('img').remove();
      $(this).append('<iframe src="' + $(this).data('iframeurl') + '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 100%;height: 300px;"> </iframe>');
    }
  }); // TODO FAQ Sorting Functionality

  $('#filters a').on('click', function (e) {
    e.preventDefault();
    var term = $(this).data('filter');
    $(this).addClass('faq-filter-active').siblings().removeClass('faq-filter-active');

    if (term === 'all') {
      $('#items li').css('display', 'inline-block');
    } else {
      $('#items li').hide();
      $('#items li[data-filter-item="' + term + '"]').css('display', 'inline-block');
      ;
    }
  }); // TODO Redirect Thanks Page

  document.addEventListener('wpcf7mailsent', function (event) {
    window.location.href = '/thank-you/';
  }, false); // TODO Scroll To ID

  $(document).on('click', 'a[href^=\\#]', function (e) {
    var el = $($(this).attr('href'));

    if (el.length && el.offset()) {
      // one of those may be unnecessary
      e.preventDefault();
      $('html, body').animate({
        scrollTop: el.offset().top - $('header').height()
      }, 2000);
    }
  }); // TODO Menu mobile

  $('button.burger').on('click', function () {
    $('body').toggleClass('overflowGlobal');
    $('.header-nav').toggleClass('active');
    $(this).toggleClass('burger-active');
  }); // TODO Add functionality for the mobile menu open

  $('.header .genesis-nav-menu > ul > .menu-item-has-children').on('click', function () {
    if ($('.header').hasClass('header-mobile')) {
      $(this).toggleClass('open').children().last().slideToggle(150);
    } else {
      $(this).toggleClass('open');
    }
  });
  $('.header .genesis-nav-menu > ul > .menu-item-has-children .menu-item-has-children').on('click', function (event) {
    event.stopPropagation();

    if ($('.header').hasClass('header-mobile')) {
      $(this).toggleClass('open').children().last().slideToggle(150);
    } else {
      $(this).toggleClass('open');
    }
  }); // TODO Header active class, CTA on mobile and btn up fixed elements

  var lastScrollTop = 0;

  function menuFixed() {
    // Header Active Class
    if ($(window).scrollTop() > 20) {
      $('.header').addClass('header-active');
    } else {
      $('.header').removeClass('header-active');
    } // CTA on mobile show/hide


    var st = $(this).scrollTop();
    var header = $('header.header');

    if (header.hasClass('header-mobile')) {
      if ($(window).scrollTop() > 350) {
        if (st >= lastScrollTop) {
          header.addClass('header-scroll');
        } else {
          header.removeClass('header-scroll');
        }
      }

      lastScrollTop = st;
    } // Btn Up Active Show/Hide


    if ($(this).scrollTop() > 500) {
      $('#scrollToTop').addClass('btn-up-active');
    } else {
      $('#scrollToTop').removeClass('btn-up-active');
    }
  }

  $(window).bind('scroll', menuFixed); // TODO scroll body to 0px on click

  $('#scrollToTop').on('click', function (event) {
    event.preventDefault();
    $('body,html').animate({
      scrollTop: 0
    }, 700);
    $(this).removeClass('btn-up-active');
  }); //TODO HD Modal

  $(document).on('click', '.video-modal .play-icon, .open-modal', function (e) {
    e.preventDefault();
    var imgElement = $(this).hasClass('play-icon') ? $(this).siblings('img.open-modal') : $(this);
    var hdModalTitle = imgElement.data('modal-title');
    var hdModalContentType = imgElement.data('modal-content-type');
    var hdModalContent = imgElement.data('modal-content');

    if (!hdModalContentType || !hdModalContent) {
      console.error("Required modal data attributes are missing.");
      return;
    }

    var hdModalHTML = '<div class="modal">';
    hdModalHTML += '<div class="modal-top">';

    if (hdModalTitle) {
      hdModalHTML += '<span class="modal-title">' + hdModalTitle + '</span>';
    }

    hdModalHTML += '<div class="modal-close">' + '<svg clip-rule="evenodd" width="24" height="24" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">' + '<path d="m12 10.93 5.719-5.72c.146-.146.339-.219.531-.219.404 0 .75.324.75.749 0 .193-.073.385-.219.532l-5.72 5.719 5.719 5.719c.147.147.22.339.22.531 0 .427-.349.75-.75.75-.192 0-.385-.073-.531-.219l-5.719-5.719-5.719 5.719c-.146.146-.339.219-.531.219-.401 0-.75-.323-.75-.75 0-.192.073-.384.22-.531l5.719-5.719-5.72-5.719c-.146-.147-.219-.339-.219-.532 0-.425.346-.749.75-.749.192 0 .385.073.531.219z"/>' + '</svg></div></div>';

    if (hdModalContentType === 'youtube') {
      hdModalHTML += '<div class="modal-before">' + '<iframe src="https://www.youtube.com/embed/' + hdModalContent + '?autoplay=1&mute=1" ' + 'allow="autoplay" allowfullscreen></iframe></div>';
    } else if (hdModalContentType === 'wistia') {
      hdModalHTML += '<div class="modal-before">' + '<iframe src="https://fast.wistia.net/embed/iframe/' + hdModalContent + '" ' + 'allowfullscreen frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" ' + 'allow="autoplay; fullscreen" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"></iframe></div>' + '<script src="https://fast.wistia.com/embed/medias/' + hdModalContent + '.jsonp" async></script>' + '<script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>';
    } else if (hdModalContentType === 'mp4') {
      hdModalHTML += '<div class="modal-before">' + '<video controls autoplay>' + '<source src="' + hdModalContent + '" type="video/mp4">' + 'Your browser does not support the video tag.' + '</video></div>';
    } else {
      hdModalHTML += hdModalContent;
    }

    $('#modal-container').append(hdModalHTML);
    $('#modal-container').fadeIn();
  });
  $(document).on('click', '.modal-close , #modal-container', function (e) {
    /*
    * The First Statement checks if the user is clicking outside of the modal
    * The Second Statement checks if the user clicked the X button
    * Meaning this if is: If User clicked outside of the modal OR clicked on the X button, destroy the modal
    * */
    if ($(this).is('#modal-container') && !$(e.target).closest('.modal').length || $(this).hasClass('modal-close')) {
      $('#modal-container').fadeOut(function () {
        $(this).empty();
      });
    }
  });
})(jQuery);