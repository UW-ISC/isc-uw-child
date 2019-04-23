<?php
/**
 * Template used for displaying a single Announcement
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );   
	  echo "<br>";
	  the_page_header(false, true, true);
?>

<div role="main">

	<?php get_template_part( 'menu', 'mobile' ); ?>

	<div class="container uw-body">

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'single.php' ) ?>

					<div class="post-content">
						<?php
						  // Start the Loop.
						while ( have_posts() ) : the_post();

							the_content();

						endwhile;
						?>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>


<?php get_footer(); ?>
