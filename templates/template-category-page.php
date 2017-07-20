<?php
/**
 * Template Name: Category Page
 *
 * A full-width template, that displays the description of a specific category
 * as well as listing the children pages within it
 *
 * @package isc-uw-child
 */

get_header();

?>

<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<div class="uw-body container">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">
			<article class="uw-content col-md-9" id="main_content">

				<?php log_to_console( 'template-category-page.php' ) ?>

				<?php
				while ( have_posts() ) : the_post();
					isc_title();
					the_content();
				endwhile;

				isc_display_child_pages();
				?>

			</article>

		</div>

	</div>

</div>

<?php get_footer(); ?>
