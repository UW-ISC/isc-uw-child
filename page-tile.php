<?php
/**
 Template Name: Page with Tiles
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );   ?>

<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<div class="container uw-body">

		<div class="row">
			<div class="col-md-12">

				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="uw-content">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'page.php' ) ?>

					<?php isc_title(); ?>

					<?php 

					the_modified_date('l, F j, Y', '<div class="isc-updated-date">Last updated ', '</div>');

					?>

					<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						the_content();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							  comments_template();
						}

					endwhile;
					?>

				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
