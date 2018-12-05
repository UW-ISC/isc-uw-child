<?php
/**
 * Template Name: User Guide with Feedback
 *
 * Template that displays a user guide (step by step tutorials)
 * additionally with a table of contents automatically generated
 * from the headers. Template also has a feedback section, driven
 * by Contact Form 7 WordPress Plugin, for the User Guide article.
 *
 * @author UW-IT AXDD
 * @package isc-uw-child
 */

get_header();
?>

<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<section class="uw-body container" id="toc">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="col-md-3">
				<?php isc_user_guide_menu(true); ?>
			</div>

			<article class="uw-content float-content col-md-9 isc-user-guide" id="main_content">

				<?php log_to_console( 'template-user-guide.php' ) ?>
				<?php
				while ( have_posts() ) : the_post();
					isc_title();
					the_modified_date('l, F j, Y', '<div class="isc-updated-date">Last updated ', '</div>');
					the_content();
				endwhile
				?>
			</article>
			<div class="col-md-3">
			</div>
			<script>
			$(function(){

				$('.isc-user-guide table').each(function() {
					// add responsive table class and clear all other inline styles
					$(this).addClass("table-responsive");
					$(this).addClass("table-condensed");
					$(this).removeProp("style");

					// clean each td by removing all inline styles
					$("td").each(function() {
						$(this).removeProp("style");
					});

					// set img widths (inside of table tds)
					$("td img").each(function() {
						//$(this).removeProp("width");
						$(this).attr('width', '100%');
						$(this).removeProp("height");
					});
				});

							});

			$(document).on("keydown", function(e){
				// cntrl-f or command-f
				if((event.ctrlKey || event.metaKey) && event.which == 70) {
					$('.uw-accordion-shortcode__header').attr( "aria-expanded", "true" );
					$('.uw-accordion-shortcode__panel').attr( "aria-hidden", "false" );
					$('.uw-accordion-shortcode__title').hide();
					$('.uw-accordion-shortcode__title').attr( "aria-hidden", "true" );
				};
			});

			</script>

		</div>

	</section>

</div>

<?php get_footer();
