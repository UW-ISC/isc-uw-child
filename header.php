<?php
/**
 * Header that is used across the site
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

	?>
<!DOCTYPE html>
<html class="no-js">
	<head>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-W85QNZR');</script>
		<!-- End Google Tag Manager -->

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title> <?php 
					$prefix = get_the_title();

					if('post' == get_post_type()){
						$prefix = get_post_type_object(get_post_type())->labels->name;
					}
					else if ('workday_course' == get_post_type()){
						$prefix = get_the_archive_title();
					}
					
					echo $prefix . " | "; bloginfo( 'name' ); 
					?> </title>
		<meta charset="utf-8">
		<meta name="description" content="<?php bloginfo( 'description', 'display' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="vQxLCtJqEqcWtnoJ6kpuxDN52HbONpgCTKpE6UWwv8U" />

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<?php wp_head(); ?>

		<!--[if lt IE 9]>
				<script src="<?php bloginfo( 'template_directory' ); ?>/assets/ie/js/html5shiv.js" type="text/javascript"></script>
				<script src="<?php bloginfo( 'template_directory' ); ?>/assets/ie/js/respond.js" type="text/javascript"></script>
				<link rel='stylesheet' href='<?php bloginfo( 'template_directory' ); ?>/assets/ie/css/ie.css' type='text/css' media='all' />
		<![endif]-->

		<?php
		get_post_meta( get_the_ID(), 'javascript', 'true' );
		get_post_meta( get_the_ID(), 'css', 'true' );
	?>

		<script type="text/javascript">
			var ISC_URL = "<?php echo esc_url( get_site_url() ); ?>";
		</script>

	</head>
	<!--[if lt IE 9]> <body <?php body_class( 'lt-ie9' ); ?>> <![endif]-->
	<!--[if gt IE 8]><!-->
	<body <?php body_class(); ?> >
	<!--<![endif]-->
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W85QNZR" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div id="uwsearcharea" aria-hidden="true" class="uw-search-bar-container"></div>

	<a id="main-content" href="#main_content" class='screen-reader-shortcut'>Skip to main content</a>

	<div id="uw-container">

	<div id="uw-container-inner">


	<?php get_template_part( 'thinstrip' ); ?>

	<?php require get_template_directory() . '/inc/template-functions.php';
		  uw_dropdowns(); ?>

<script>
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