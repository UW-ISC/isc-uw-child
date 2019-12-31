
<script>
    // JS code for JIRA ISC-16652
    // this code creates a expland all or close all button for a group of accordian menus
	$(document).ready(function() {
		$(".isc-expander-wrapper").each(function(i) {
			let id = "button_" + i;
			let button_html = '<span role="button" class="isc-expander-wrapper-button" id="' + id + '" value="Open All">Open All<span/>'
			let button = $(button_html).click(function(){
				let childrens = button.parent().children(".isc-expander");

				if (button.attr('value') == "Open All") {
					
					childrens.each(function(i) {
						let child = $(this);
						if (!child.children('.isc-expander-content').hasClass("show")) {
							child.children('a[role="button"]').click();
						}
					});
					
					
					button.attr('value', 'Close All');
					button[0].innerHTML = 'Close All';
					button.removeClass("open");
					button.addClass("close");
				} else {

					childrens.each(function(i) {
						let child = $(this);
						if (child.children('.isc-expander-content').hasClass("show")) {
							child.children('a[role="button"]').click();
						}
					});
					
					button.attr('value', 'Open All');
					button[0].innerHTML = 'Open All';
					button.removeClass("close");
					button.addClass("open");
				}
				
			});
			$(this).prepend(button);
		});
	})
</script>