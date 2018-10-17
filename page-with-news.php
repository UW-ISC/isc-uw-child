<?php
/**
 * Template Name: Page With News
 * 
 * This is simply a copy of the default page template, but with an added section for news.
 * News articles configured for the 'targeted-corner-news' (see below) slug location will be displayed as a list on pages with this template.
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

				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="uw-content col-md-8">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'page-with-news.php' ) ?>

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
			<div class="isc-homepage-body">
			<div class="col-md-4 isc-homepage-news generic-news-bar">
				  <h2 class="generic-title">Related News</h2>

				  <!-- loop news posts here
						Gets numberposts of the posts that have been
						published, and have their location set to homepage
				  -->

				  <div class="isc-homepage-news-content">
						<?php

						$args = array(
							  'posts_per_page' => '3',
							  'post_status' => 'publish',
							  'tax_query' => array(
								array(
								  'taxonomy' => 'location',
								  'field'    => 'slug',
								  'terms'    => 'targeted-corner-news',
								),
							  ),
						);
						$news_posts = new WP_Query( $args );

						if ( $news_posts->have_posts() ) :
							while ( $news_posts->have_posts() ) :
								$news_posts->the_post();
								?>

								<h3>
									<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo the_title(); ?></a>
								</h3>
								<div class="update-date"><?php echo get_the_date(); ?></div>
								<div class="post-content"><?php custom_wp_trim_excerpt(the_excerpt()); ?></div>
						<?php
							endwhile;
					  else :
							echo 'No news posts found.';
					  endif;
					?>
					  <div><a class="uw-btn btn-sm" href="<?php echo esc_url( get_site_url() ) . '/news'?>">See all news</a></div>
				  </div>

				  <!-- end loop -->

			  </div>
			</div>
		  </div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
