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
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title> <?php echo get_the_title() . " | "; echo bloginfo( 'name' ); ?> </title>
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

	<div id="uwsearcharea" aria-hidden="true" class="uw-search-bar-container"></div>

	<a id="main-content" href="#main_content" class='screen-reader-shortcut'>Skip to main content</a>

	<div id="uw-container">

	<div id="uw-container-inner">


	<?php get_template_part( 'thinstrip' ); ?>

	<?php require get_template_directory() . '/inc/template-functions.php';
		  uw_dropdowns(); ?>
