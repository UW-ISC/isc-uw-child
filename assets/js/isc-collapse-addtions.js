/**
 * This on-click function allow us to add additional
 * functionality to the bootstrap-collapse.js functions
 *
 * @author Mason Gionet <mgionet@uw.edu>
 */

$(document).ready(function() {

    $(".has-children").each( function () {

      var currentButton = ($(this).children("button"));
      var currentUl = ($(this).children("ul"));

      $(this).on('show', function () {
        $(this).attr('aria-expanded', 'true');
        $(currentButton).attr('aria-expanded', 'true');
        $(currentUl).attr('aria-expanded', 'true');
      })

      $(this).on('hide', function () {
        $(this).attr('aria-expanded', 'false');
        $(currentButton).attr('aria-expanded', 'false');
        $(currentUl).attr('aria-expanded', 'false');
      })

    })
})
