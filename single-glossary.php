<?php
/**
 * Template used for page if template is not specified
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );   ?>

<?php uw_site_title(); ?>
<?php get_template_part( 'menu', 'mobile' ); ?>

<div class="container uw-body">

	<div class="row">
		<div class="col-md-12">
			<?php get_template_part( 'breadcrumbs' ); ?>
		</div>
	</div>

	<div class="row">

	<div class="uw-content col-md-9" role='main'>

		<div id='main_content' class="uw-body-copy" tabindex="-1">

			<?php log_to_console( 'single-glossary.php' ) ?>

			<h2><?php the_title(); ?></h2>

			<div>
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post(); ?>
						<div class='post-content'><?php the_content() ?></div>
					<?php endwhile;
				  else :
						echo '<h3 class=\'no-results\'>Sorry, no results matched your criteria.</h3>';
				  endif; ?>
			</div>

		</div>

	</div>

	</div>

</div>

<?php get_footer(); ?>
