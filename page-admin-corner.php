<?php
/**
 * Unique template for Admin Corner page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );
	  $seasonal = get_post_meta( $post->ID ); ?>

		<?php uw_site_title(); ?>
		<?php get_template_part( 'menu', 'mobile' ); ?>

<div role="main">

	<div class="isc-admin-hero">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><?php the_title(); ?></h2>

					<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( get_site_url() ); ?>">
						<div role="search">
							<label class="screen-reader-text" for="s">Search the ISC:</label>
							<input type="text" value="" name="s" id="s" placeholder="Search the ISC:" autocomplete="off">
							<input type="submit" id="searchsubmit" value="Search">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="container uw-body">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="col-md-8 uw-content isc-content" role='main'>

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<div class="row">
						<div class="col-md-12" style="margin-bottom: 2em;">
							<?php
							wp_nav_menu(
								array(
								'theme_location' => 'admin-corner-links',
								'fallback_cb'    => false,
								)
							);
							?>
						</div>
					</div>

					<h3 class="isc-admin-header">Admins' News</h3>
					<div class="isc-admin-block">

							<?php

							 $args = array(
									  'tax_query' => array(
										  array(
											  'taxonomy' => 'location',
											  'field'    => 'slug',
											  'terms'    => 'admin-corner-news',
										  ),
									  ),
									  'posts_per_page' => 5,
									  'post_status' => 'publish',
							 );
							 $category_posts = new WP_Query( $args );

							 if ( $category_posts->have_posts() ) :
								 while ( $category_posts->have_posts() ) :
									 $category_posts->the_post();
							?>

								   <h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h4>
								   <div class="update-date"><?php echo get_the_date() ?> </div>
										<?php
										$excerpt = esc_html( get_the_excerpt() );
										if ( '' === $excerpt ) {
											$excerpt .= 'No promotional text available.';
										}
										?>
								   <div class='post-content'><?php echo esc_html( $excerpt ); ?></div>
							<?php
								 endwhile;
								?>
								<a class="uw-btn btn-sm" href="<?php echo esc_url( get_site_url() . '/news' );?>">Read older news</a>
						<?php
							else :
								echo '<p>No admin news available.</p>';
							endif;
							?>

					  </div>

				  </div>

				</div>

			<div class="col-md-4 uw-sidebar isc-sidebar" role="">

				<h3 class="isc-admin-header">Upcoming Event</h3>
				<div class="contact-widget-inner isc-widget-tan isc-admin-block">
				  <div class='post-content isc-events'>
					<?php
					if ( function_exists( 'tribe_get_events' ) ) {
						$events = tribe_get_events(
							array(
							'posts_per_page' => 1,
							'start_date' => date( 'Y-m-d H:i:s' ),
							)
						);
						if ( empty( $events ) ) {
							echo 'No events found.';
						} else {
							$current = $events[0];
							$title = $current->post_title;
							$html = '<h4><a href="' . get_post_permalink( $current->ID ) . '">' . $title . '</a> </h4>';
							$html .= "<div class='event-date'>" . tribe_get_start_date( $current ) . '</div>';

							if ( tribe_has_venue( $current->ID ) ) {
								$details = tribe_get_venue_details( $current->ID );
								$html .= "<div class='event-location'><i class='fa fa-map-marker' aria-hidden='true'></i> " . $details['linked_name'];
								$html .= $details['address'];

								if ( tribe_show_google_map_link( $current ) ) {
									$html .= tribe_get_map_link_html( $current );
								}

								$html .= '</div>';

							} else {
								$html .= "<div class='event-location'>Location: TBD</div>";
							}

							if ( has_excerpt( $current->ID ) ) {
								$html .= "<div class='event-content'>" . $current->post_excerpt . '</div>';
							} else {
								$html .= "<div class='event-content'>No description found.</div>";
							}
							echo $html;
						}
					} else {
						// we cannot find the plugin as the function tribe_get_events does not exist.
						echo 'The Event Calendar plugin cannot be found!';
					}// End if().
					?>
				  </div>

					<?php
					if ( ! empty( $events ) ) {
						// we only want to show the See All Events button if a future event exists.
						$events_url = get_site_url() . '/events/';
						echo '<a class="uw-btn btn-sm" href="' . esc_url( $events_url ) . '"?>See All Events</a>';
					}
					?>
				</div>


				<h3 class="isc-admin-header">Seasonal Topic</h3>
				<div class="contact-widget-inner isc-widget-gray isc-admin-block">
					<div class='post-content'>
						<?php
						$args = array(
						 'hierarchical' => false,
						 'post_type'    => 'page',
						 'post_status'  => 'publish',
						 'meta_key'     => 'isc-featured',
						 'meta_value'   => 'seasonal',
						);
						$seasonal_featured = get_pages( $args );
						if ( ! $seasonal_featured ) {
							echo '<p>No featured seasonal topics found.</p>';
						} else {
							foreach ( $seasonal_featured as $featured_page ) {
								$html = '<h4><a href="' . get_post_permalink( $featured_page->ID ) . '">' . get_the_title( $featured_page->ID ) . '</a></h4>';
								$html .= "<p style='margin-bottom:1.5em;'>";
								$custom = get_post_custom( $featured_page->ID );
								$description = $custom['isc-featured-description'][0];
								if ( '' !== $description ) {
									$html .= $description;
								} else {
									$html .= 'No promotional text available.';
								}
								$html .= '</p>';
								echo $html;
							}
						}
						?>
					</div>
					<a class="uw-btn btn-sm" href="<?php echo esc_url( get_site_url() . '/seasonal-topics' ); ?>">See all Topics</a>
				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
