<?php
/**
 * Unique template for Admin Corner page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
$url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$sidebar = get_post_meta($post->ID, 'sidebar');
	$tasks_this_month = get_post_meta($post->ID);
	$banner = get_post_meta( $post->ID, 'banner-image' );
	$banner_url = wp_get_attachment_url($banner[0]);
	?>

<div role="main">

	<?php uw_site_title();?>
	<?php get_template_part('menu', 'mobile');?>

	<div class="isc-admin-hero" style="background-image: url('<?php echo $banner_url ?>');">
		<div class="container">
			<h1 class="banner-text"><?php the_title(); ?></h1>
		</div>
	</div>

	<div class="container uw-body">

		<!-- adding title JAB 061418 -->
 		<div class="row">
 		<br/>
		<div class="row">

			<div class="col-md-8 uw-content isc-content" role='main'>

				<h3 class="isc-admin-header">Your Tasks This Month </h3>

						<?php

$args = array(
    'hierarchical' => 0,
    'post_type' => 'page',
    'post_status' => 'publish',
    'meta_key' => 'task_list_month',
    'meta_value' => date('n'),
);
$query = new WP_Query($args);
$all_task_posts = $query->posts;
if (!$all_task_posts) {
    echo '<p>No monthly tasks found.</p>';
} else {
    $current_month_tasks = array_shift($all_task_posts);
    echo get_task_html($current_month_tasks);

    $previous_month = date('n') - 1;
    if ($previous_month == 0) {
        $previous_month = 12;
    }
    $args['meta_value'] = $previous_month;
    $query = new WP_Query($args);
    if (!$query->posts) {
        echo '<div style="padding-bottom:30px"></div>';
    } else {
        $previous_month_post = array_shift($query->posts);
        $accordion_html = <<<EOT
								<div class="accordion" id="accordionExample">
								<div class="card-header" id="headingOne" style="position: relative;top: -31px;">
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
if (!is_int('news_stale_after')) {
    $news_stale_after = 3;
}
$news_stale_after_days_plus_one = $news_stale_after + 1;
$after_date = date('Y-m-d', strtotime('- ' . $news_stale_after_days_plus_one . ' days'));

$args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'location',
            'field' => 'slug',
            'terms' => 'admin-corner-news',
        ),
    ),
    'posts_per_page' => 5,
    'post_status' => 'publish',
    'date_query' => array(
        'after' => $after_date,
    ),
);
$category_posts = new WP_Query($args);
$new_news_count = $category_posts->found_posts;
if ($new_news_count > 0) {
    echo '<span id="newNewsCount" class="new-news-count"><span class="new-news-label">' . $category_posts->found_posts . ' new</span></span>';
}?>
						</div>

						<form action="<?php echo site_url() ?>/wp-content/themes/isc-uw-child/isc_request.php" method="POST" id="filter" style="margin-bottom:15px">
								<label for="categorySelectInput">Filter News Posts:</label>
								<?php
if ($terms = get_terms('category', 'orderby=name')) {
    echo '<select class="isc-select" id="categorySelectInput" name="categoryfilter"><option value="select" hidden>Select category...</option>';

    foreach ($terms as $term) {
        echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
    }
    echo '</select>';
}

?>
								<button hidden="true" class ="isc-border-less-button" id="clearFilter" onclick="clearCategoryFilter();"> <i class="fa fa-close isc-btn-icon"></i> clear filter</button>
								<input type="hidden" name="action" value="adminNewsFilter">
						</form>
						<script type="text/javascript">
							clearCategoryFilter = function(){
								$('#categorySelectInput').prop('selectedIndex',0);
								$('#filter').submit();
								$('#clearFilter').hide();
							}
							window.onload = function(){
								if( $('#categorySelectInput').prop('selectedIndex') != 0 ){
									$('#categorySelectInput').trigger('change');
								}
							}
							jQuery(function($){
								$('#categorySelectInput').change(function(){
									$('#filter').submit();
								});
							$('#filter').submit(function(){
								var filter = $('#filter');
								$.ajax({
									url:filter.attr('action'),
									data:filter.serialize(), // form data
									type:filter.attr('method'), // POST
									beforeSend:function(xhr){
										$('#newNewsCount').hide();

										// filter.find('button').text('Applying...'); // changing the button label
									},
									success:function(data){
										// filter.find('button').text('Filter'); // changing the button label back
										$('#adminNewsPosts').html(data); // insert data
										if($('#categorySelectInput').prop('selectedIndex') != 0){
											$('#clearFilter').show();
										}
										else{
											$('#newNewsCount').show();
											$('#clearFilter').hide();
										}

									}
								});
								return false;
							});
						});
						</script>

					<div id="adminNewsPosts">
							<?php
$args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'location',
            'field' => 'slug',
            'terms' => 'admin-corner-news',
        ),
    ),
    'posts_per_page' => 5,
    'post_status' => 'publish',
);
$category_posts = new WP_Query($args);

print_admin_corner_news($category_posts);
?>

					  </div>



				</div>
			</div>

			<div class="col-md-4 uw-sidebar isc-sidebar" role="">
						<div class="service-links"><h4>WORKDAY FINANCE SUPPORT</h4><p>Where to go for Workday support now depends on what you need help with. For questions about Workday Finance processes (procurement, grant management, etc.) visit the <strong>UW Connect Finance Portal</strong>.</p><p><a class="uw-btn btn-sm" href="https://uwconnect.uw.edu/finance" rel="noopener">Go to the Portal</a></p><p>The ISC continues to be your source for Workday HCM (HR and payroll) support.</p>
							<?php
wp_nav_menu(
    array(
        'theme_location' => 'admin-corner-links',
        'fallback_cb' => false,
    )
);
?>
						</div>
			</div>

		</div>

	</div>

</div>

<?php get_footer();

function get_task_html($task)
{
    $html = <<<EOD
	<div class="contact-widget-inner isc-admin-block isc-widget-gray" style="padding-bottom: 0px;">
EOD;
    $html .= '<h4><a href="' . esc_url(get_permalink($task->ID)) . '">' . get_the_title($task->ID) . '</a></h4>';
    $html .= "<p style='margin-bottom:1.5em;'>";
    $custom = get_post_custom($task->ID);
    $description = $custom['isc-featured-description'][0];
    if ('' !== $description) {
        $html .= $description;
    } else {
        $html .= 'No promotional text available.';
    }
    $html .= '</p></div>';
    return $html;
}

?>
