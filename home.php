<?php
/**
 * Template Name: News Corner
 * 
 * This is a template to display and filter all news items (all posts).
 * All news articles should be displayed in descending order of their publish date and there should be options to filter the news posts based on their categories, date.
 * 
 * Requries WordPress Plugin: Search & Filter by Designs & Code https://www.designsandcode.com/wordpress-plugins/search-filter/
 * 
 * @package isc-uw-child
 * @author Prasad Thakur <prasadt@uw.edu>
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
				<?php echo do_shortcode('[searchandfilter empty_search_url="'.get_permalink( get_option( 'page_for_posts' ) ).'" submit_label="Filter" fields="category,post_date" types="checkbox,daterange" headings="Category,Posted Between"]'); ?>
			</div>
		</div>
		

		<div class="row">
			

			<div class="uw-content">

				<div id="main_content corner" class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'home.php' ) ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h2>
						<div class="update-date"><?php echo get_the_date() ?> </div>
						<div class='post-content'><?php the_excerpt() ?></div>

					<?php endwhile ?>

                    <!-- pagination functions -->
                    <div class="nav-previous alignleft"><?php previous_posts_link( 'Previous' ); ?></div>
                    <div class="nav-next alignright"><?php next_posts_link( 'Next' ); ?></div>

				</div>

			</div>
			<div class="isc-homepage-body">
			
		  </div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
