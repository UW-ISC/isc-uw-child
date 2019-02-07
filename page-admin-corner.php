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
	  $tasks_this_month = get_post_meta( $post->ID ); ?>

<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<!-- removing search field and title JAB 061418 
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
	-->
	<div class="container uw-body">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<!-- adding title JAB 061418 -->
 		<div class="row">
			<div class="col-md-12">
				<h1><?php the_title(); ?></h1>
			<br/>
			</div>

		<div class="row">

			<div class="col-md-8 uw-content isc-content" role='main'>

				<h3 class="isc-admin-header">Your Tasks This Month </h3> 

						<?php
						
						$args = array(
						 'hierarchical' => 0,
						 'post_type'    => 'page',
						 'post_status'  => 'publish',
						 'meta_key'     => 'task_list_month',
						 'meta_value'   => date('n')
						);
						$query = new WP_Query($args);
						$all_task_posts = $query->posts;
						if ( ! $all_task_posts ) {
							echo '<p>No monthly tasks found.</p>';
						} else {
							$current_month_tasks = array_shift($all_task_posts);
							echo get_task_html($current_month_tasks);

							$previous_month = date('n') - 1;
							if($previous_month == 0 ){
								$previous_month = 12;
							}
							$args['meta_value']  = $previous_month;
							$query = new WP_Query($args);
							if(! $query->posts){
								echo '<div style="padding-bottom:30px"></div>';
							}
							else{
								$previous_month_post = array_shift($query->posts);
								$accordion_html = <<<EOT
								<div class="accordion" id="accordionExample">
								<div class="card-header" id="headingOne" style="position: relative;top: -30px;">
								      <h2 class="mb-0">
								        <button class="see-more-accordion-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								          Last Month's Tasks
								        <i class="accordion-handle fa fa-angle-down"></i></button>
								      </h2>
							    </div>
								  
								  	<div id="collapseOne" class="collapse admin-accordion-drawer" aria-labelledby="headingOne" data-parent="#accordionExample">
EOT;
								  	$accordion_html .= get_task_html($previous_month_post);
								  	$accordion_html .= <<<EOT
								    </div>
							   </div>
							<style>
						        [data-toggle="collapse"][aria-expanded="true"] > .accordion-handle
						        {
						            -webkit-transform: rotate(180deg);
						            -moz-transform:    rotate(180deg);
						            -ms-transform:     rotate(180deg);
						            -o-transform:      rotate(180deg);
						            transform:         rotate(180deg);
						            transform-origin: center center;
						            transition-duration: 0.1s;
						        }
						    </style>
EOT;
							}
							
							echo $accordion_html;
						}
						?>
					


				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<div class="line">
						<h3 class="isc-admin-header">Admins' News</h3>
						<?php 
						 $news_stale_after = get_post_custom_values('news_stale_after_days', get_the_ID())[0];
						 $new_news_count = 0;
						 if (!is_int(news_stale_after)) {
						 	$news_stale_after = 3;
						 }
						 $news_stale_after_days_plus_one = $news_stale_after+1;
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
										  'date_query' => array(
										  	'after' => date('Y-m-d', strtotime('-'.$news_stale_after_days_plus_one.' days'))
										  )
										);
						$category_posts = new WP_Query( $args );
						$new_news_count = $category_posts->found_posts;
						if($new_news_count > 0){
							echo '<div class="new-news-count new-news-label">'.$category_posts->found_posts.' new</div>';
						}
						?>
					</div>
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

								   
								   <?php 
								    $diff_str = esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) );
								    $diff_display =  esc_html( '('.human_time_diff( get_the_time('U'), current_time('timestamp') ) ).' ago)';
								    $diff_arr = explode(" ", $diff_str);
								    $diff_unit = $diff_arr[1];

								    

								    $new_post = false;
								    $new_label = '';
								   
								    if(strpos($diff_unit, 'second') !== false ||
								    	strpos($diff_unit, 'min') !== false ||
								    	strpos($diff_unit, 'hour') !== false){
								    	$new_post = true;
								    }
								    else if(strpos($diff_unit, 'day') !== false){
								    	
								    	$diff_value = (int)$diff_arr[0];

								    	if($diff_value <= $news_stale_after){
								    		$new_post = true;
								    		$new_news_count += 1;
								    	}
								    }
								    if($new_post) {
								   		 $new_label = '<span class="new-news-label">new</span>';
								   	}

								   	?>
								   <div class="line">
								   		<h4><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title()?></a><?php echo $new_label; ?></h4>
								   	</div><br>
								   <div class="line">
								   	<div class="update-date"><?php echo get_the_date(); ?></div>
								   	<div class="date-diff"><?php echo $diff_display; ?></div>
								   </div>
								   <div class='post-content'><?php the_excerpt() ?></div>
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

				<!-- <h3 class="isc-admin-header">At A Glance</h3>
				<div class="contact-widget-inner isc-widget-tan isc-admin-block">
				  <div class='post-content isc-events'>
					<?php
					if ( function_exists( 'tribe_get_events' ) ) {
						$events = tribe_get_events(
							array(
							'posts_per_page' => 1,
							'post_status' => 'publish',
							'start_date' => current_time( 'Y-m-d H:i' ),
							)
						);
						if ( empty( $events ) ) {
							echo 'No events found.';
						} else {
							$current = $events[0];
							$title = $current->post_title;
							$html = '<h4><a href="' . get_post_permalink( $current->ID ) . '">' . $title . '</a> </h4>';
							// Hiding Date - JB 081618 //
							/*
							$html .= "<div class='event-date'>" . tribe_get_start_date( $current ) . '</div>';
							*/

							// Hiding Location info - JB 081518 //
							/*							
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
							*/

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
						// we only want to show the More Info button if a future event exists.
						$events_url = get_site_url() . '/events/';
						echo '<a class="uw-btn btn-sm" href="' . esc_url( $events_url ) . '"?>More Info</a>';
					}
					?>
				</div> -->

				<!-- <div class="row"> -->
						<!-- <div class="col-md-12" style="margin-bottom: 2em;"> -->
						<div>
							<?php
							wp_nav_menu(
								array(
								'theme_location' => 'admin-corner-links',
								'fallback_cb'    => false,
								)
							);
							?>
						</div>
					<!-- </div> -->

	

			</div>

		</div>

	</div>

</div>

<?php get_footer(); 

function get_task_html($task){
	$html = <<<EOD
	<div class="contact-widget-inner isc-admin-block isc-widget-gray" style="padding-bottom: 0px;">
EOD;
	$html .= '<h4><a href="' . esc_url( get_post_permalink( $task->ID ) ) . '">' . get_the_title( $task->ID ) . '</a></h4>';
	$html .= "<p style='margin-bottom:1.5em;'>";
	$custom = get_post_custom( $task->ID );
	$description = $custom['isc-featured-description'][0];
	if ( '' !== $description ) {
		$html .= $description;
	} else {
		$html .= 'No promotional text available.';
	}
	$html .= '</p></div>';
	return $html;
}

?>
