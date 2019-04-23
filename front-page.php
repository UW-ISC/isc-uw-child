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

						<h1 class="isc-homepage-title"><?php the_title(); ?></h1>
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

					   <h2 class="col-md-12">Featured Pages</h2>
						<?php
						// Featured Pages
						// Query finds the published pages marked featured page and lists their
						// title and description on a card.
						$args = array(
						 'hierarchical'	=> false,
						 'post_type'	=> 'page',
						 'post_status'	=> 'publish',
						 'meta_key'	=> 'isc-featured',
						 'meta_value'	=> 'Homepage',
						 'sort_column'  => 'post_date',
						 'sort_order'   => 'desc',
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

									<div class="isc-homepage-card-body">
										<h3>
										  <a href="<?php echo esc_url( get_permalink( $featured_page->ID ) ); ?>">
											<span class="isc-homepage-tile-title">
												<?php echo get_the_title( $featured_page->ID ); ?>
											</span>
											</a>
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
										<p class="isc-homepage-excerpt multi-line-text-block"><?php echo esc_textarea( $description ); ?></p>
										<p><a class="uw-btn btn-sm" title="<?php echo get_the_title( $featured_page->ID ); ?>" href="<?php echo esc_url( get_permalink( $featured_page->ID ) ); ?>"><?php echo esc_textarea( $description_text ); ?><span class="sr-only">: <?php echo get_the_title( $featured_page->ID ); ?></span></a></p>
									</div>

								  </div>
							  </div>
								<?php
							}// End foreach().
						}// End if().
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
			  <div class="col-md-4 isc-homepage-sidebar">
				  <h2>ISC Announcements</h2>

				  <!-- loop news posts here
						Gets numberposts of the posts that have been
						published, and have their location set to homepage
				  -->

				  <div class="isc-homepage-sidebar-content">
						<?php

							$args = array(
								'post_status' => 'publish',
								'post_type' => 'announcement',
								'meta_query' => array(
									array(
										'key'	=> 'announcement_displayed_on',
										'value'	=> 'Homepage'
									),
									array(
										'key'	=> 'announcement_active',
										'value'	=> '1'
									)
								)
							);
							$announcement_posts = new WP_Query( $args );

							if ( $announcement_posts->have_posts() ) {
								
								while ( $announcement_posts->have_posts() ) {
									$announcement_posts->the_post();
									the_announcement();
								}
							}
							else{
								echo '<p>No announcements are currently posted.</p>';
							}
								?>
				  </div>

				  <!-- end loop -->

			  </div>
		  </div>
	  </div>

	</div>

	</div>
<script type="text/javascript">
	var adjustExcerpt = function(title){
		var titleContentHeight = 241;
		var titleHeight = title.offsetHeight;
		var newExcerptHeight = titleContentHeight - titleHeight;
		var excerpt = $($(title.closest('.isc-homepage-card-body')).children('.isc-homepage-excerpt')[0]);
		excerpt.css('height', newExcerptHeight + "px");
	}
	
	$( document ).ready(function() {
		var  titles = $('.isc-homepage-tile-title');
		titles.each(function(){
			adjustExcerpt(this);
		});

		window.addEventListener('resize', function(event){
			var  titles = $('.isc-homepage-tile-title');
				titles.each(function(){
				adjustExcerpt(this);
			});	
		});
	});	
</script>
<?php get_footer(); ?>
