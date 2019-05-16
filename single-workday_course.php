<?php
/**
 * Template for workday course post items.
 *
 * @package isc-uw-child
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );   ?>

<div role="main">

	<?php 
		uw_site_title();
		get_template_part( 'menu', 'mobile' );
		the_page_header([
			'use_date' => false
		]);
	?>

	<div class="container uw-body">

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'single-workday_course.php' ) ?>
					
					<div class="post-content">
						<?php
						  
						while ( have_posts() ){
							the_post();

							print_workday_course_page();

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						}
						?>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>


<?php get_footer(); ?>
