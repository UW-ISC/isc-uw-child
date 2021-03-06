<?php
/**
 * Template used for page if template is not specified
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );
?>
	  
<div role="main">

	<?php 
		uw_site_title();
		get_template_part( 'menu', 'mobile' );
		the_page_header();
	?>

	<div class="container uw-body">

	<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'single-glossary.php' ) ?>

					<div>
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post(); ?>
								<div class='post-content'><?php the_content() ?></div>
							<?php endwhile;
						  else :
								echo '<h2 class=\'no-results\'>Sorry, no results matched your criteria.</h2>';
						  endif; ?>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
