<?php
/**
 * Functions used for rendering Workday Course Catalog page
 *
 * @author Prasad Thakur
 * @package isc-uw-child
 */

 function custom_post_archive_title ( $title ){
	if( is_post_type_archive() ){
		$title = post_type_archive_title('', false);
	}
	return $title;
}

add_filter('get_the_archive_title', 'custom_post_archive_title');
add_action('isc_request_ajax_courseFilter', 'course_filter');
add_action('isc_request_ajax_nopriv_courseFilter', 'course_filter');

function course_filter(){
	
	trigger_course_fitler_with_params_from($_POST);
	die();
}

function trigger_course_fitler_with_params_from ($param_source){
	
	$tax_query_base = array(
		'relation' => 'AND',
	);
	
	$args = array(
		'post_type' => 'workday_course',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => $tax_query_base
	);

	$taxonomies = get_object_taxonomies( 'workday_course', 'objects' );

	$selected_taxonomy_ids = array();
	
	foreach ($taxonomies as $each_taxonomy ){

		if(array_key_exists($each_taxonomy->name, $param_source)){

			$selected_taxonomy_ids = array_merge($selected_taxonomy_ids, $param_source[$each_taxonomy->name] );

			array_push($args['tax_query'],  array(
				'taxonomy' => $each_taxonomy->name,
				'field' => 'id',
				'terms' => $param_source[$each_taxonomy->name]
			  ));
		}
	}


	if( $args['tax_query']  == $tax_query_base ){
		// echo "resetting";
		$args = array(
			'post_type' => 'workday_course',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);
	}

	
	$args = set_sorting_params($args,$param_source);
	print_workday_course_catalog($args, $selected_taxonomy_ids);

	
}

function set_sorting_params($args, $param_source = []){
	$args['orderby'] = 'title';
	
	if(equate_if_exists('sortBy',$param_source,'date-updated')){
		$args['orderby'] = 'meta_value';
		$args['meta_key'] = 'course-update-date';
		$args['meta_type'] = 'DATE';
	}
	

	$args['order'] = get_if_exists('sortOrder',$param_source,'ASC');

	return $args;
}

function print_workday_course_catalog($post_args, $selected_taxonomy_ids = array()){

	$page_size = 10;
	$page_value = get_if_exists('page', $_POST, 0);

	
		
	echo '<div class="col-md-4 course-filter-form">';
		print_course_filter_form($post_args, $selected_taxonomy_ids);
	echo '</div>';
	echo '<div class="col-md-8"> <div class="filter-and-sort-bar"> <div class="row">';
	
	print_filter_status_bar($selected_taxonomy_ids);
	print_sort_bar();

	echo '</div></div>';

	echo '<div  id="coursePosts">';
	
	$post_query = new WP_Query( $post_args );

	
	if( $post_query->have_posts()) {
		
		
		$found_num = $post_query->found_posts;
		$plural = $found_num > 1 ? 's' : '';

		$start_at = 0;
		$possible_pages = intval($found_num / $page_size);

		if(($found_num % $page_size)>0) {
			$possible_pages++;
		}

		if($page_value< 0){
			$page_value = 0;
		}
		else if( $page_value > $possible_pages){
			$page_value = $possible_pages;
		}

		if($found_num > $page_size){
			$start_at = $page_size * $page_value;
		}

		if(count($selected_taxonomy_ids) > 0){	
			echo '<h4> Found ' . $found_num . ' Course'.$plural.'</h4>';
		} else{

			$end_num = $start_at + $page_size;
			
			if($end_num >= $found_num ){
				$end_num = $found_num;
			}
			echo '<h4> Showing  ' . ($start_at + 1) . '-'. $end_num . ' of '. $found_num.' Course'.$plural.'</h4>';
		}
		
		$counter = 0;

		while ( $post_query->have_posts() ) {
			$post_query->the_post();
			
			if($counter >= ($start_at + $page_size) ){
				break;
			}

			if( $counter >= $start_at)
			{
				print_workday_course_item();
			}
			
			$counter ++;
		} //end while
		if( $start_at > 0 ) {
			echo '<div class="nav-previous alignleft"><a  onclick="handlePrevClick(this)" class="uw-btn btn-sm btn-left">Previous</a></div>';
			
		}
		if( ($start_at + $page_size) < $found_num) {
			echo '<div class="nav-next alignright"><a  onclick="handleNextClick(this)" class="uw-btn btn-sm">Next</a></div>';
		}
	} // end if
	else{
		echo "<h3> No Workday Courses </h3>";
	}
	echo '</div>';
	echo '</div>';
}

function print_sort_bar(){
	echo '<div class="col-md-4">';
		print_sort_by_dropdown();
		print_sort_order_toggle();
	echo '</div>';
}

function print_sort_by_dropdown(){
	$sort_by_title = 'selected';
	$sort_by_update_date = '';

	if(equate_if_exists('sortBy',$_POST, 'date-updated')){
		$sort_by_title = '';
		$sort_by_update_date = 'selected';
	}

	$sort_by_html = <<<askdnaknckascnkan
			<label>Sort by: </label>
			<select id="sortByDropdown" onchange="handleSortByChange(this)">
				<option value="title" $sort_by_title>Title</option>
				<option value="date-updated" $sort_by_update_date >Date Updated</option>
			</select>
askdnaknckascnkan;
	echo $sort_by_html;
}

function print_sort_order_toggle(){
	$icon_html = '<i class="fa fa-arrow-up control-icon" aria-hidden="true" onclick="handleSortOrderChange(this)" data-sort-order="ASC" ></i>';
	
	if(equate_if_exists('sortOrder',$_POST,'DESC')){
		$icon_html = '<i class="fa fa-arrow-down control-icon" aria-hidden="true" onclick="handleSortOrderChange(this)" data-sort-order="DESC" ></i>';
	}
	
	 echo $icon_html;
}

function print_course_filter_form($args, $selected_taxonomy_ids){

	$post_ids = wp_list_pluck( get_posts($args) , 'ID' );

	// echo "post ids count: ";
	// print_r(count($post_ids));

	// echo "<br><br>args<br>";
	// print_r($args);

	$term_args = array(
		'object_ids' => $post_ids,
		'hide_empty' => true
	);
	
	echo  '<form action="'.site_url().'/wp-content/themes/isc-uw-child/isc_request.php" method="POST" id="courseFilterForm">';

	$taxonomies = get_object_taxonomies( 'workday_course', 'objects' );

	$print_order = get_filter_order();

	$keyed_taxonomies = array();

	foreach ($taxonomies as $each_taxonomy ){
		$keyed_taxonomies[$each_taxonomy->name] = $each_taxonomy;
	}
									
	foreach ($print_order as $taxonomy_name ){
		print_filter_section( $keyed_taxonomies[$taxonomy_name], $term_args, $selected_taxonomy_ids, $post_ids);
	}
	echo  '<input type="hidden" name="page" value="0">';

	$sort_by_value = 'title';
	if(equate_if_exists('sortBy',$_POST,'date-updated')){
		$sort_by_value = 'date-updated';
	}
	
	
	$sort_order_value = 'ASC';
	if(equate_if_exists('sortOrder',$_POST,'DESC')){
		$sort_order_value = 'DESC';
	}
		
	echo  '<input type="hidden" name="sortBy" value="'.$sort_by_value.'">';
	echo  '<input type="hidden" name="sortOrder" value="'.$sort_order_value.'">';

	echo  '<input type="hidden" name="action" value="courseFilter"> </form>';
}

/**
* This function renders the taxonomy terms
**/
function print_filter_section($taxonomy, $term_args, $selected_taxonomy_ids, $post_ids) {
	
	
	$term_args['taxonomy'] = $taxonomy->name;
	$my_term_query = new WP_Term_Query($term_args);

	if(count( $my_term_query->get_terms()) > 0){
		echo '<h5>'.$taxonomy->label.'</h5>';
	}

	foreach ( $my_term_query->get_terms() as $term ) {

		$checked_status = ( in_array($term->term_id, $selected_taxonomy_ids) == 1 ) ? "checked" : "" ;
		print_filter_item( $taxonomy , $term, $checked_status, $post_ids);
	}
}

function print_filter_item($taxonomy, $term, $checked_status, $post_ids) {
	echo '<label> <input onchange="handleCourseFilterChange()" type="checkbox" name="'.$taxonomy->name.'[]" value="' . $term->term_id . '" id="' . $term->term_id . '" '. $checked_status .' /> ' . $term->name .' ('.get_term_count($term, $post_ids, $taxonomy).')</label><br>'; 
}



function get_term_count($term, $post_ids, $taxonomy){
        
    $count = 0;
    foreach ($post_ids as $id){

        $post = get_post($id);
        $terms = get_the_terms($post, $taxonomy->name);

        if($terms && in_array($term, $terms)) {
            $count++;
        }
    }
    return $count;
}

function print_filter_status_bar($selected_taxonomy_ids){
	echo '<div class="col-md-8">';
	if(count($selected_taxonomy_ids) > 0) {
		echo '<ul  id="filterStatus" class="h-list"><label>Filters Applied:</label>';
		foreach ($selected_taxonomy_ids as $taxonomy_id){
			$filter_term = get_term($taxonomy_id);
				echo '<li class="no-stylist">';
					echo '<button class="isc-simple-button small-chip" data-term-id="'.$filter_term->term_id.'" onclick="handleFilterClear(this)">';
						echo  $filter_term->name . '<i class="fa fa-close isc-btn-icon-right"></i>';
					echo '</button>';
				echo '</li>';
			
		}
		if(count($selected_taxonomy_ids) > 1) {
			echo '<li class="no-stylist">';
					echo '<button class="isc-simple-button small-chip" onclick="handleFilterClearAll(this)" style="border:none">';
						echo  'clear all';
					echo '</button>';
				echo '</li>';
		}
		echo '</ul>';
	}
	echo '</div>';
}

function get_workday_course_metadata(){

	$course_metadata = array();

	$course_metadata['post_title'] = get_the_title();

	$course_metadata['url'] = get_post_meta(get_the_ID(), 'course-url', true);

	$course_metadata['post_excerpt'] = get_the_excerpt();
	

	$course_metadata['post_image_url'] = wp_get_attachment_url(get_post_meta(get_the_ID(), 'course-image', true));
	$course_metadata['duration'] = get_post_meta(get_the_ID(), 'course-duration', true);

	// $release_date = get_post_meta(get_the_ID(), 'course-release-date', true);
	// $release_date = date_create_from_format('m/d/Y', $release_date);
	// $release_date = $release_date->format('M j, Y');

	$update_date = get_post_meta(get_the_ID(), 'course-update-date', true);
	$update_date = date_create_from_format('Y-m-d', $update_date);
	$course_metadata['update_date'] = $update_date->format('M j, Y');

	$course_metadata['skill_level'] = get_the_terms(get_the_ID(), 'course-skill-level')[0];
	

	$course_metadata['read_more'] = esc_url(get_permalink());

	return $course_metadata;
}


function print_workday_course_page(){
	$course_metadata = get_workday_course_metadata();
	extract($course_metadata);

	$taxonomies = get_object_taxonomies( 'workday_course', 'objects' );
	$tax_fields_html = '';

	foreach ($taxonomies as $each_taxonomy ){
		
		$tax_terms_for_post = wp_get_post_terms(get_the_id(), $each_taxonomy->name );

		if(count( $tax_terms_for_post) > 0){
			$tax_fields_html .= '<tr>';
			$tax_fields_html .= '<td class="table-cell-label"><b>'.$each_taxonomy->label.':</b></tb>';
			$tax_fields_html .= '<td> <ul class="line no-stylist">';

			foreach ( $tax_terms_for_post as $term ) {

				$tax_fields_html .= '<li class="table-cell-list-item">'.$term->name . '</li>';
			}

			$tax_fields_html .= '</ul></td>';

			$tax_fields_html .= '</tr>';
		}
	}

	$post_html = <<<ojaefnjeafksmjf
	<p>$post_excerpt</p>
	<table class="no-stylist-table">
		<tbody>
			<tr>
				<td class="table-cell-label"><b>Updated On:</b></td>
				<td>$update_date</td>
			</tr>
			<tr>
				<td class="table-cell-label"><b>Duration:</b></td>
				<td>$duration mins</td>
			</tr>
			$tax_fields_html
		<tbody>
	</table>
	<a class="uw-btn post-cta" href="$url">Go</a>
ojaefnjeafksmjf;

	echo $post_html;
}

/**
* This function renders the current post as if it was a workday course listing.
**/
function print_workday_course_item(){
	if(get_post_type() != 'workday_course'){
		echo "Not a workday course!";
		return;
	}

	$course_metadata = get_workday_course_metadata();
	extract($course_metadata);

	$post_html = <<<dnfndaskfn
	<div class="workday-course-item" onclick="handleCourseClick('$url')">

		<table class="workday-layout-table">
			<tr>
				<td class="workday-course-cover-image-container-portrait" style="background-image: url($post_image_url)"></td>
			</tr>
			<tr>
				<td class="workday-course-cover-image-container" style="background-image: url($post_image_url)"></td>

				<td class="workday-course-cover-content-container">
					<h2>{$post_title}</h2>
					<p>{$post_excerpt}</p>
					<ul class="workday-item-post-metadata">
						<li> <b> Duration: </b> {$duration} mins</li>
						<li>| <b> Skill Level: </b> {$skill_level->name}</li>
						<li>| <b> Updated On: </b> {$update_date}</li>
					</ul>
				</td>
			</tr>
		</table>
	</div>
dnfndaskfn;
	
	//<li>| <a href="{$read_more}"> more </a> </li>
	echo $post_html;
}

function get_filter_order(){
	return ['course-employee-population', 'course-skill-level', 'course-security-role-involved', 'course-type', 'business-process', 'course-scenario'];
}
