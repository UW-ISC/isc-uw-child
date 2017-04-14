<?php
/**
 * This template is unique to the front page of the site
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header( 'front' );
	$url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
if ( ! $url ) {
	$url = get_site_url() . '/wp-content/themes/isc-uw-child/assets/images/service-team_final.jpg';
}
$mobileimage = get_post_meta( $post->ID, 'mobileimage' );
$hasmobileimage = '';
if ( ! empty( $mobileimage ) && '' !== $mobileimage[0] ) {
	$mobileimage = $mobileimage[0];
	$hasmobileimage = 'hero-mobile-image';
}
$banner = get_post_meta( $post->ID, 'banner' );
$buttontext = get_post_meta( $post->ID, 'buttontext' );
$buttonlink = get_post_meta( $post->ID, 'buttonlink' );   ?>

<div class="uw-body" style="padding:0;">

	<div class="uw-content" role='main'>

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	  <div class="isc-homepage-hero" style="background-image: url('<?php echo esc_url( $url );?>');">
		  <div class="container">
			<div class="row">
				<div class="col-md-4 col-md-offset-8">
					<div class="isc-homepage-shortcuts hero-header-container">

                        <h1 class="sr-only"><?php wp_title( ' | ', true, 'right' );
                		bloginfo( 'name' ); ?></h1>

                        <div class="isc-homepage-title"><?php the_title(); ?></div>
						<span class="udub-slant"><span></span></span>

						<h2 class="sr-only">Quicklinks</h2>

						<?php
						wp_nav_menu(
							array(
							'theme_location' => 'hero-quicklinks',
							'fallback_cb'    => false,
							)
						);
							?>

					</div>

				</div>
			</div>
		</div>
	  </div>

	  <div id='main_content' class="container uw-body-copy isc-homepage-body" tabindex="-1">

		  <div class="row">

			  <div class="col-md-8 isc-homepage-featured">

				  <div class="row">

					   <h2 class="col-md-12">Featured articles</h2>
						<?php
						// Featured Pages
						// Query finds the published pages marked featured page and lists their
						// title and description on a card.
						$args = array(
						 'hierarchical' => false,
						 'post_type'    => 'page',
						 'post_status' => 'publish',
						 'meta_key'        => 'isc-featured',
						 'meta_value'    => 'Homepage',
						);

						$featured = get_pages( $args );

						if ( ! $featured ) {
							echo "<div class='col-md-6'>No featured pages found!</div>";
						} else {
							foreach ( $featured as $featured_page ) { ?>
								<div class="col-md-6">
								  <div class="isc-homepage-card">

										<?php
										$custom = get_post_custom( $featured_page->ID );
										if ( has_post_thumbnail( $featured_page->ID ) ) {
											$image = get_the_post_thumbnail_url( $featured_page->ID );
										?>
									  <div class="isc-homepage-image" style="background-image:url('<?php echo esc_url( $image ); ?>')">
										<?php
										} else {
											// Use the default image.
											?>
										  <div class="isc-homepage-image">
											<?php
										}
										?>
									  &nbsp;
									  </div>

									<div style="padding:40px;">
										<h3>
										  <a href="<?php echo esc_url( get_permalink( $featured_page->ID ) ); ?>">
											<?php echo get_the_title( $featured_page->ID ); ?></a>
										</h3>
										<?php
										$description = $custom['isc-featured-description'][0];
										if ( '' === $description ) {
											$description = '[No description found]';
										}
										if ( array_key_exists( 'cta', $custom ) ) {
											$description_text = $custom['cta'][0];
											if ( '' === $description_text ) {
												$description_text = 'Learn More';
											}
										} else {
											$description_text = 'Learn More';
										}
										?>
										<p class="isc-homepage-excerpt"><?php echo esc_textarea( $description ); ?></p>
										<p><a class="uw-btn btn-sm" href="<?php echo esc_url( get_permalink( $featured_page->ID ) ); ?>"><?php echo esc_textarea( $description_text ); ?><span class="sr-only">: <?php echo get_the_title( $featured_page->ID ); ?></span></a></p>
									</div>

								  </div>
							  </div>
								<?php
							}
						}
						?>

						<script>
							$(function(){
								$('.isc-homepage-excerpt').succinct({
									size: 200
								});
							});
						</script>

					</div>

			  </div>
			  <div class="col-md-4 isc-homepage-news">
				  <h2>News</h2>

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
								  'terms'    => 'homepage',
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
								<div class="update-date"><?php echo get_the_date() ?></div>
								<div class="post-content"><?php echo wp_strip_all_tags( get_the_content() ) ?></div>
								<p><a class="more" href="<?php echo esc_url( get_permalink() ); ?>">Read more</a></p>
						<?php
							endwhile;
					  else :
							echo 'No news posts found.';
					  endif;
					?>
					  <div><a class="uw-btn btn-sm" href="<?php echo esc_url( get_site_url() ) . '/news'?>">See all news</a></div>

					  <script>
						  $(function(){
							  $('.isc-homepage-news-content .post-content').succinct({
								  size: 250
							  });
						  });
					  </script>

				  </div>

				  <!-- end loop -->

			  </div>
		  </div>
	  </div>

	</div>

	</div>

<?php get_footer(); ?>
