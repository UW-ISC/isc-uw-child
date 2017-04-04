/**
 * This on-click function allow us to add additional
 * functionality to the bootstrap-collapse.js functions
 *
 * @author Mason Gionet <mgionet@uw.edu>
 */

$(document).ready(function() {

    $(".has-children").each( function () {

      var currentLink = ($(this).children("a"));

      $(this).on('show', function () {
        $(this).attr('aria-expanded', 'true');
        $(currentLink).attr('aria-expanded', 'true');
      })

      $(this).on('hide', function () {
        $(this).attr('aria-expanded', 'false');
        $(currentLink).attr('aria-expanded', 'false');
      })

    })
})
