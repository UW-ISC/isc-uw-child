$(document).ready(function() {
    /* CODE FOR THE FLOATING MENU TO BE USED ON THE USER GUIDE TEMPLATE (CLASS float-menu) */
    // gathering the necessary elements we need
    var toc = $(".float-menu");
    var content = $(".float-content");
    if (toc.length > 0 && content.length > 0) {
        var width_change = 991; // the width at which the table of contents is simply put on top of the content
        var new_width = $('.col-md-3').width(); // width of the menu
        var top_padding = getCSS('top', 'uw-accordion-menu-floater').slice(0, -2); // where the floating menu should be placed from the top
        var change = true;
        var nav = $("#menu-main-navigation");
        var alert_height = 0;
        var height_change = 0;
        jQuery(document).delegate('#uwalert-alert-message', 'DOMNodeInserted', function () {
            // There's an alert!
            if (height_change !== 0) {
              // if we already set the height to change variable, simply add on to it
              height_change += $("#uwalert-alert-message").height() + parseInt(top_padding) * 2;
            } else {
              // else try to play catch up and add it later when height_change is set
              alert_height = $("#uwalert-alert-message").height() + parseInt(top_padding) * 2;
            }
        });

        var top_tracker = nav.height();

        if ($(window).width() > width_change && change) {
            // this is information we need, but it will never change so we need to find it once (when it is ok to get it)
            height_change = content.offset().top - top_padding;
            if (alert_height > 0) {
              // account for the alert
              height_change += alert_height;
            }
            var footer_barrier = content.height() + content.offset().top - $(this).scrollTop() - toc.height() - top_padding * 2;
            change = false;
        }

        // There are two ways the user could potentially activate the floating behavior, by resizing the page or by scrolling
        $(window).resize(function() {
            // by resizing the window, the width of a potentially floating toc changes, so we have to recalculate it
            new_width = $('.col-md-3').width();
            if (top_tracker != nav.height() && $(this).width() > width_change) {
              top_tracker = nav.height();
              height_change = content.offset().top - top_padding;
              if (alert_height > 0) {
                height_change += alert_height;
              }
            }
            if ($(this).width() > width_change && change) {
                // we don't wanna continually update this
                height_change = content.offset().top - top_padding;
                if (alert_height > 0) {
                  height_change += alert_height;
                }
                footer_barrier = content.height() + content.offset().top - $(this).scrollTop() - toc.height() - top_padding * 2;
                change = false;
            }

            if ($(this).width() > width_change) {
                // if a user resizes the page to activate the floating thingy, we have to be ready and
                // account for their location on the page
                if ($(this).scrollTop() > height_change && footer_barrier > 0) {
                    // in the sweet spot to activate floating behavior
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css({
                        'top': ''
                    });
                } else if ($(this).scrollTop() > height_change) {
                    // hit the footer barrier
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css("top", parseInt(footer_barrier) + parseInt(top_padding));
                } else {
                    // no floating behavior
                    toc.removeClass("uw-accordion-menu-floater");
                    content.removeClass("uw-content-floater");
                    toc.css({
                        'width': ''
                    });
                    toc.css({
                        'top': ''
                    });
                }
            } else { // the case in which the page is expanded beyond 991px
                // we don't want to intefere with the behavior implemented in the css
                toc.removeClass("uw-accordion-menu-floater");
                content.removeClass("uw-content-floater");
                toc.css({
                    'width': ''
                });
                toc.css({
                    'top': ''
                });
            }
        });

        $(window).scroll(function() {
            footer_barrier = content.height() + content.offset().top - $(this).scrollTop() - toc.height() - top_padding * 2;
            // if the page is more than 991 px, it can follow the floating behavior
            if ($(this).width() > width_change) {
                if ($(this).scrollTop() > height_change && footer_barrier > 0) {
                    // in the sweet spot to activate floating behavior
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css({
                        'top': ''
                    });
                } else if ($(this).scrollTop() > height_change) {
                    // hit the footer barrier
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css("top", parseInt(footer_barrier) + parseInt(top_padding));
                }
                else {
                    // no floating behavior
                    toc.removeClass("uw-accordion-menu-floater");
                    content.removeClass("uw-content-floater");
                    toc.css({
                        'width': ''
                    });
                    toc.css({
                        'top': ''
                    });
                }
            }
        });
    }
});

var getCSS = function (prop, fromClass) {
    var $inspector = $("<div>").css('display', 'none').addClass(fromClass);
    $("body").append($inspector); // add to DOM, in order to read the CSS property
    try {
        return $inspector.css(prop);
    } finally {
        $inspector.remove(); // and remove from DOM
    }
};
