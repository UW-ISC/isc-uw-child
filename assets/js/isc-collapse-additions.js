/**
 * This on-click function allow us to add additional
 * functionality to the bootstrap-collapse.js functions
 *
 * @author Mason Gionet <mgionet@uw.edu>
 */

$(document).ready(function() {

    // table of contents collapse menu
    $(".has-children").each( function () {

      var currentLink = ($(this).children("a"));

      $(this).on('show', function () {
        $(currentLink).attr('aria-expanded', 'true');
      });

      $(this).on('hide', function () {
        $(currentLink).attr('aria-expanded', 'false');
      });

    });

    // user guide collapse content
    $(".isc-expander").each( function () {

      var thisLink = ($(this).children("a"));

      $(this).on('show', function () {
          $(thisLink).attr('aria-expanded', 'true');
          $(thisLink).removeClass("collapsed");
          $(thisLink).addClass("expanded");
      });

      $(this).on('hide', function () {
          $(thisLink).attr('aria-expanded', 'false');
          $(thisLink).addClass("collapsed");
          $(thisLink).removeClass("expanded");
      });

    });

});
