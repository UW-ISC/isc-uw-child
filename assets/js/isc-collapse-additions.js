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
        $(this).find('.children').show();
      });

      $(this).on('hide', function () {
        $(currentLink).attr('aria-expanded', 'false');
        $(this).find('.children').hide();
      });

    });

    // user guide collapse content
    $(".isc-expander").each( function () {

      var thisLink = ($(this).children("a"));

      $(this).on('show', function () {
          $(thisLink).attr('aria-expanded', 'true');
          // find the nearest content container and show it (display:block)
          $(this).find('.isc-expander-content').show();
      });

      $(this).on('hide', function () {
          $(thisLink).attr('aria-expanded', 'false');
          // find the nearest content container and hide it (display:none)
          $(this).find('.isc-expander-content').hide();
      });

    });

});
