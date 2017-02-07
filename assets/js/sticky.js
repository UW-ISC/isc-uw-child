$(document).ready(function() {
    /* CODE FOR THE FLOATING MENU TO BE USED ON THE USER GUIDE TEMPLATE (CLASS float-menu) */
    // gathering the necessary elements we need
    var toc = $(".float-menu");
    var content = $(".float-content");
    // if these elements don't exist, don't bother with the following code
    if (toc.length > 0 && content.length > 0) {
        var parent = $(".row");
        var padding = content.css("padding-left").slice(0, -2);
        // if its col-md-4, the width should be 4 / 12 (based on bootstrap's grid system)
        var menu_percentage = toc.parent().prop('className').slice(-1) / 12;
        var width_change = 991; // the width at which the table of contents is simply put on top of the content
        var new_width = (parent.width() * menu_percentage) - padding * 2;
        // where the floating menu should be placed from the top
        var top_padding = getCSS('top', 'uw-accordion-menu-floater').slice(0, -2);

        var change = true;
        if ($(window).width() > width_change && change) {
            var height_change = $(".float-menu").offset().top - top_padding;
            var footer_barrier = $(document).height() - $(this).scrollTop() - top_padding * 2 - toc.height() - $(".uw-footer").height() - 35;
            change = false;
        }

        // There are two ways the user could potentially activate the
        // floating behavior, by resizing the page or by scrolling
        $(window).resize(function() {
            // by resizing the window, the width and padding of a potentially
            // floating toc changes, so we have to recalculate it
            new_width = (parent.width() * menu_percentage) - padding * 2;

            if ($(this).width() > width_change && change) {
                // we don't wanna continually update this
                height_change = toc.offset().top - top_padding;
                footer_barrier = $(document).height() - $(this).scrollTop() - top_padding * 2 - toc.height() - $(".uw-footer").height() - 35;
                change = false;
            }
            // if a user resizes the page to activate the floating thingy, we have to be ready and
            // account for their location on the page
            if ($(this).width() > width_change) {
                if ($(this).scrollTop() > height_change && footer_barrier > 0) {
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css({
                      'top': ''
                    });
                } else if ($(this).scrollTop() > height_change) {
                  toc.addClass("uw-accordion-menu-floater");
                  content.addClass("uw-content-floater");
                  toc.css("width", new_width);
                    toc.css("top", parseInt(footer_barrier) + parseInt(top_padding));
                } else {
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

        // document - scrollTop

        $(window).scroll(function() {
            footer_barrier = $(document).height() - $(this).scrollTop() - top_padding * 2 - toc.height() - $(".uw-footer").height() - 35;
            // if the page is more than 991 px, it can follow the floating behavior
            if ($(this).width() > width_change) {
                if ($(this).scrollTop() > height_change && footer_barrier > 0) {
                    toc.addClass("uw-accordion-menu-floater");
                    content.addClass("uw-content-floater");
                    toc.css("width", new_width);
                    toc.css({
                        'top': ''
                    });
                } else if ($(this).scrollTop() > height_change) {
                  toc.addClass("uw-accordion-menu-floater");
                  content.addClass("uw-content-floater");
                  toc.css("width", new_width);
                    toc.css("top", parseInt(footer_barrier) + parseInt(top_padding));
                }
                else {
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
