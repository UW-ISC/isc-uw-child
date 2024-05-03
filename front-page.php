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
	<!--  <div class="isc-homepage-hero" style="background-image: url('<php echo esc_url( $url );?>');"> -->
	  <div class="isc-homepage-hero">
		  <div class="container">
				<div class="row">
					<div class="col-md-8 col-xs-12">
						<!-- <h1 class="hero-title"><?php echo get_the_title( $ID ); ?></h1>
						<span class="under-line-title"></span> -->
						<?php
							$page = get_page_by_path('featured-headline');
							$imagePath = get_the_post_thumbnail_url($page->ID);
							$permalink = get_permalink($page->ID);

						?>
						<section class="isc-hero-main mt-3" >
							<img class="isc-hero-main-content-img" src="<?php echo esc_url( $imagePath ) ?>" alt="<?php echo $page->post_title ?>">
							<div class="isc-hero-main-content">
								<h1><?php echo $page->post_title ?></h1>
								<div class="isc-hero-bar">
									<?php
										$content = $page->post_content;
										$content = str_replace(['<p>', '</p>'], '', $content);
									?>
									<p>
										<?php echo $content; ?>
										<?php //echo $content . " <a href='".$permalink."'> read more >></a>"; ?>
									</p>
									<a class="light-color uw-btn btn-sm" title="read more" href="<?php echo esc_url( $permalink ); ?>">
										Read More
										<span class="sr-only">: <?php echo get_the_title( $featured_page->ID ); ?></span>
									</a>
								</div>
							</div>
						</section>
					</div>
					<div class="col-md-4 col-xs-12 pt-3">
						<div class="isc-homepage-quicklinks">
							<h2 class="quicklinks-maintitle ml-3">Employee Quick Links</h2>
							<section class="options-employee text-center row">
								<a title="Getting paid"
									href="/your-pay-taxes/paydays/"
									id="home-btn-1-1"
									target="_blank"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Getting paid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_GettingPaid.png" alt="">
									<h4 class="text-uppercase">Getting paid</h4>
								</a>
								<a
									title="Entering Time"
									href="/your-time-absence/time-entry/"
									id="home-btn-1-2"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Entering Time" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_EnteringTime.png" alt="">
									<h4 class="text-uppercase">Entering Time</h4>
								</a>
								<a
									title="Taking Time off"
									href="/your-time-absence/time-off/"
									id="home-btn-2-1"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Taking Time off" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_TakingTimeOff.png" alt="">
									<h4 class="text-uppercase">Taking Time off</h4>
								</a>
								<a
									title="Enrolling in benefits"
									href="/your-benefits/newly-eligible/"
									id="home-btn-2-2"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Enrolling in benefits" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_Enrolling.png" alt="">
									<h4 class="text-uppercase">Enrolling in benefits</h4>
								</a>
								<a
									title="Changing Your benefits"
									href="/your-benefits/changing/"
									id="home-btn-3-1"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Changing Your benefits" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_ChangeBenefits.png" alt="">
									<h4 class="text-uppercase">Changing Your benefits</h4>
								</a>
								<a
									title="Managing Your Workday Profile"
									href="/using-workday/managing-your-personal-and-work-information/"
									id="home-btn-3-2"
									class="options-employee-item col-md-6 col-xs-4">
									<img alt="Managing Your Workday Profile" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/icon_ManageBenefits.png" alt="">
									<h4 class="text-uppercase">Managing Your Workday Profile</h4>
								</a>
							</section>
						</div>
					</div>
				</div><!--END ROW -->

				<div class="row">
					<div class="col-md-8 col-xs-12">
					<span class="under-line-title"></span>
						<section class="slide-home-featureds">
							<h2  class="slide-home-featureds-maintitle">Here and now</h2>
							<?php
								$args = array(
									'hierarchical'	=> false,
									'post_type'	=> 'page',
									'post_status'	=> 'publish',
									'meta_key'	=> 'isc-featured',
									'meta_value'	=> 'Homepage',
									'sort_column'  => 'post_date',
									'sort_order'   => 'desc');

								$featured = get_pages( $args );
								if ( ! $featured ):
									echo "<div class='col-md-8'>No featured pages found!</div>";
								else: ?>
								<div class="owl-dots">
									<div class="owl-dot active"><span></span></div>
									<div class="owl-dot"><span></span></div>
									<div class="owl-dot"><span></span></div>
								</div>
								<div class="owl-carousel owl-theme owl-loaded">

								<?php	foreach ( $featured as $featured_page ) : ?>

										<div class="isc-homepage-card-v2">
											<?php
												$custom = get_post_custom( $featured_page->ID );
												if ( has_post_thumbnail( $featured_page->ID ) ) :
													$image = get_the_post_thumbnail_url( $featured_page->ID );
											?>
												<div class="isc-homepage-image">
													<div class="warpper-isc-homepage-image">
														<img alt="Here and now image" src="<?php echo $image; ?>" />
													</div>
											<?php else: // Use the default image. ?>
												<div class="isc-homepage-image">
											<?php endif; ?>
												</div>

											<div class="isc-homepage-card-body">
												<h3>
													<?php echo get_the_title( $featured_page->ID ); ?>
												</h3>
												<?php
													$description = $custom['isc-featured-description'][0];
													if ( '' === $description ) {
														$description = '[No description found]';
													}
												?>
												<p class="isc-homepage-excerpt-card-v2">
													<?php echo esc_textarea( $description ); ?>
													<a title="<?php echo get_the_title( $featured_page->ID ); ?>"
														href="<?php echo esc_url( get_permalink( $featured_page->ID ) ); ?>">
														Learn more
													</a>
												</p>
											</div><!--END isc-homepage-card-body-->
										</div><!--END isc-homepage-card-v2-->
									<?php endforeach; ?>

								</div> <!-- END owl-carousel -->
								<div class="slider_nav owl-nav">
									<a title="Next item" class="am-next">
										<img alt="Left arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/LeftArrow.png" alt="LeftArrow" />
									</a>
									<a title="Previous item" class="am-prev">
										<img alt="Right arrow" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/RightArrow.png" alt="RightArrow" />
									</a>
								</div>

							<?php endif; ?>
							<script>
								$('.owl-carousel').owlCarousel({
									items: 1,
									margin:10,
									loop:false,
									rewind:true,
									nav:true,
									navText: [$('.am-next'),$('.am-prev')],
								});
							</script>
						</section>

						<div class="hidden-xs isc-content-body">
							<?php
								$args = array(
									'category_name' => 'additional-information',
									'numberposts' => 1,
									'order'=> 'ASC',
								);
								$posts = get_posts($args);
							?>
							<section class="isc-card-content">
								<?php foreach( $posts as $post ): setup_postdata($post);  ?>

								<h2 class="isc-card-content-maintitle"><?php the_title(); ?></h2>
								<!-- <span class="under-line-card-title"></span> -->
								<div class="isc-card-body mt-1">
									<?php
										if ( has_post_thumbnail( $post->ID ) ):
											$haveImg = true;
											$url = get_the_post_thumbnail_url( $post->ID );
									?>
										<img alt="<?php echo get_the_title(); ?>" src="<?php echo $url ?>" alt="">
										<?php
										else:
											$url = get_site_url() . '/wp-content/themes/isc-uw-child/assets/images/img-dummy.jpg';
											$haveImg = false;
										endif;
										?>
									<!--  -->
									<div class="<?php echo $haveImg ? 'ml-2' : '' ?>">
										<?php the_excerpt(); ?>
									</div>
								</div>
								<?php endforeach; ?>
							</section>
						</div>
					</div><!--END col-md-8-->

					<aside class="col-md-4 col-xs-12 pt-1 mb-3">
						<div class="isc-homepage-sidebar-v2 mt-3">
							<h2 class="homepage-sidebar-v2-maintitle ml-3">Announcements</h2>
							<div class="isc-homepage-sidebar-v2-content px-2">
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
						</div>
					</aside>

					<div class="col-md-8 col-xs-12 visible-xs isc-content-body">
						<?php
							$args = array(
								'category_name' => 'additional-information',
								'numberposts' => 1,
								'order'=> 'ASC',
							);
							$posts = get_posts($args);
						?>
						<section class="isc-card-content">
							<?php foreach( $posts as $post ): setup_postdata($post);  ?>

							<h2 class="isc-card-content-maintitle"><?php the_title(); ?></h2>
							<!-- <span class="under-line-card-title"></span> -->
							<div class="isc-card-body mt-1">
								<?php
									if ( has_post_thumbnail( $post->ID ) ):
										$haveImg = true;
										$url = get_the_post_thumbnail_url( $post->ID );
								?>
									<img alt="<?php echo get_the_title(); ?>" src="<?php echo $url ?>" alt="">
									<?php
									else:
										$url = get_site_url() . '/wp-content/themes/isc-uw-child/assets/images/img-dummy.jpg';
										$haveImg = false;
									endif;
									?>
								<!--  -->
								<div class="<?php echo $haveImg ? 'ml-2' : '' ?>">
									<?php the_excerpt(); ?>
								</div>
							</div>
							<?php endforeach; ?>
						</section>
					</div>
				</div><!--End Row-->
			</div>
	  </div>

	</div>
</div>
<?php get_footer(); ?>
