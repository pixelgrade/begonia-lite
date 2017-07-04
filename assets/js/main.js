;(function(window, document, $) {
"use strict";

jQuery(document).ready(function($) {
    jQuery(".site-title > a").fitText(.4, { minFontSize: '20px', maxFontSize: '160px' });
});
/*global jQuery */
/*!
* FitText.js 1.2
*
* Copyright 2011, Dave Rupert http://daverupert.com
* Released under the WTFPL license
* http://sam.zoy.org/wtfpl/
*
* Date: Thu May 05 14:23:00 2011 -0600
*/

(function( $ ){

  $.fn.fitText = function( kompressor, options ) {

    // Setup options
    var compressor = kompressor || 1,
        settings = $.extend({
          'minFontSize' : Number.NEGATIVE_INFINITY,
          'maxFontSize' : Number.POSITIVE_INFINITY
        }, options);

    return this.each(function(){

      // Store the object
      var $this = $(this);

      // Resizer() resizes items based on the object width divided by the compressor * 10
      var resizer = function () {
        $this.css('font-size', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
      };

      // Call once to set.
      resizer();

      // Call on resize. Opera debounces their resize by default.
      $(window).on('resize.fittext orientationchange.fittext', resizer);

    });

  };

})( jQuery );

/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
(function () {


    var container, button, menu;

    container = document.getElementById('site-navigation');
    if (!container) {
        return;
    }

    button = container.getElementsByTagName('button')[0];
    if ('undefined' === typeof button) {
        return;
    }

    menu = container.getElementsByTagName('ul')[0];

    // Hide menu toggle button if menu is empty and return early.
    if ('undefined' === typeof menu) {
        button.style.display = 'none';
        return;
    }

    menu.setAttribute('aria-expanded', 'false');

    if (-1 === menu.className.indexOf('nav-menu')) {
        menu.className += ' nav-menu';
    }

    button.onclick = function () {
        if (-1 !== container.className.indexOf('toggled')) {
            container.className = container.className.replace(' toggled', '');
            button.setAttribute('aria-expanded', 'false');
            menu.setAttribute('aria-expanded', 'false');
        } else {
            container.className += ' toggled';
            button.setAttribute('aria-expanded', 'true');
            menu.setAttribute('aria-expanded', 'true');
        }
    };
})();


jQuery(document).ready(function ($) {
    $(".arrow-wrap").click(function() {
        $('html, body').animate({
            scrollTop: $("#arrow-anchor").offset().top
        }, 500);
        return false;
    });

    /* Search */

    $(".nav__item--search").click(function(){
        $(".overlay--search").fadeIn("fast");

    });
    $(".overlay__close").click(function() {
        $(".overlay--search").fadeOut("fast");
    });

    $(".menu-toggle").click(function() {
        $(".toolbar, .logo").toggle().css("z-index","1");
    });

    $(document).keyup(function(e) {
        if (e.keyCode == 27)
            $('.overlay--search').fadeOut("fast");
    });
});
}(window, document, jQuery));
