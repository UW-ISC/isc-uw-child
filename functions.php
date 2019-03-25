<?php
/**
 * Set up the child / parent relationship and customize the UW object.
 *
 * @package isc-uw-child
 */

if ( ! function_exists( 'setup_uw_object' ) ) {
	/**
	 * Initialize the UW object.
	 */
	function setup_uw_object() {
		include get_stylesheet_directory() . '/setup/class.uw.php';
		$UW = new UW();
		do_action( 'extend_uw_object', $UW );
		return $UW;
	}
}

/**
 * Remove any templates from the UW Marketing theme that will not be used
 *
 * @param array $templates Array of all the page templates.
 **/
function isc_remove_page_templates( $templates ) {
	unset( $templates['templates/template-no-title.php'] );
	unset( $templates['templates/template-big-hero.php'] );
	unset( $templates['templates/template-no-hero.php'] );
	unset( $templates['templates/template-no-sidebar.php'] );
	unset( $templates['templates/template-small-hero.php'] );
	return $templates;
}

add_filter( 'theme_page_templates', 'isc_remove_page_templates' );

/**
 * Remove unwanted metaboxes from special pages.
 **/
function isc_remove_special_page_template_metabox() {
	global $post;
	$specials = array( 'homepage', 'user-guides', 'admin-corner' );
	if ( isset( $post ) && 'page' === $post->post_type && in_array( $post->post_name, $specials ) ) {
		// I guess its a hacky way!
		remove_meta_box( 'uwpageparentdiv', 'page', 'side' );
		remove_meta_box( 'sec_rolediv', 'page', 'side' );
		remove_meta_box( 'ug-topicdiv', 'page', 'side' );
		remove_meta_box( 'md-tagsdiv', 'page', 'side' );
	}
}
add_action( 'admin_head', 'isc_remove_special_page_template_metabox' );

/**
 * Rename Posts to News
 */
function isc_change_post_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
	$submenu['edit.php'][16][0] = 'News Tags';
}
/**
 * Rename Post labels for News
 */
function isc_change_post_object() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
	$labels->all_items = 'All News';
	$labels->menu_name = 'News';
	$labels->name_admin_bar = 'News';
}

if ( current_user_can( 'edit_posts' ) ) {
	add_action( 'admin_menu', 'isc_change_post_label' );
	add_action( 'init', 'isc_change_post_object' );
}

/**
 * Developer function for logging to the browser console. Do not leave log statements lying around!
 * We might want to remove this when we're done with development. (Will only work if WP_DEBUG === true)
 *
 * @param mixed $debug_output String, array, int, bool, or object to print to the javascript console.
 */
function log_to_console( $debug_output ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// only echo if WP_DEBUG exists and is True.
		$cleaned_string = '';
		if ( ! is_string( $debug_output ) ) {
			$debug_output = print_r( $debug_output, true );
		}
		$str_len = strlen( $debug_output );
		for ( $i = 0; $i < $str_len; $i++ ) {
			$cleaned_string .= '\\x' . sprintf( '%02x', ord( substr( $debug_output, $i, 1 ) ) );
		}
		$javascript_ouput = "<script>console.log('Debug Info: " . $cleaned_string . "');</script>";
		echo $javascript_ouput;
	}
}

add_filter( 'the_excerpt', 'isc_excerpt_more' );

/**
 * Adds a title element to the read more
 * links, to achieve better accessiblilty
 *
 * @param String $excerpt is the excerpt from the post object.
 */
function isc_excerpt_more( $excerpt ) {
		$post = get_post();
		$excerpt .= '<p> <a class="more" title="' . get_the_title() . '" href="' . get_permalink( $post->ID ) . '"> Read more</a> </p>';
		return $excerpt;
}

/**
 * Echoes the title of a page in an h2
 * (removing any potential html elements)
 *
 * @param boolean $echo if true then echoes the title, else returns the title.
 */
function isc_title( $echo = true ) {
	 $title = '<h1 class="title">' . esc_html( get_the_title() ) . '</h1>';
	if ( $echo ) {
		echo $title;
	} else {
		return $title;
	}
}

add_filter( 'the_title', 'esc_html_title' );

if ( ! function_exists( 'esc_html_title' ) ) :
	/**
	 * Escape html from the title function.
	 *
	 * @param String $title from which to escape html.
	 */
	function esc_html_title( $title ) {
		return esc_html( $title );
	}
endif;

add_filter( 'relevanssi_remove_punctuation', 'savehyphens_1', 9 );
/**
 * Hack around relevanssi dropping punctuation from search queries.
 * Part 1 of 2.
 *
 * @param String $a The search query.
 */
function savehyphens_1( $a ) {
	$a = str_replace( '-', 'HYPHEN', $a );
	return $a;
}

add_filter( 'relevanssi_remove_punctuation', 'savehyphens_2', 11 );
/**
 * Hack around relevanssi dropping punctuation from search queries.
 * Part 2 of 2.
 *
 * @param String $a The search query.
 */
function savehyphens_2( $a ) {
	$a = str_replace( 'HYPHEN', '-', $a );
	return $a;
}

// Function determines the tags that custom_wp_trim_excerpt will allow
function allowedtags() {
// Add custom tags to this string
    return '<strong>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<pre>';
}

// This function allows HTML tags within the excerpt
// Based off of this solution: https://wordpress.stackexchange.com/questions/141125/allow-html-in-excerpt/141136
if ( ! function_exists( 'custom_wp_trim_excerpt' ) ) :

    function custom_wp_trim_excerpt($excerpt) {
    global $post;
    $raw_excerpt = $excerpt;
        if ( '' == $excerpt ) {
            $excerpt = get_the_content('');
            $excerpt = strip_shortcodes( $excerpt );
            $excerpt = apply_filters('the_content', $excerpt);
            $excerpt = str_replace(']]>', ']]>', $excerpt);
            $excerpt = strip_tags($excerpt, allowedtags());
            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 55;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
                $tokens = array();
                $excerptOutput = '';
                $count = 0;
                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);
                foreach ($tokens[0] as $token) {
                    if ($count >= $excerpt_word_count && preg_match('/[\?\.\!]\s*$/uS', $token)) {
                    // Limit reached, continue until , ; ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }
                    $count++;
                    $excerptOutput .= $token;
                }
            $excerpt = trim(force_balance_tags($excerptOutput));
            return $excerpt;
        }
        return apply_filters('custom_wp_trim_excerpt', $excerpt, $raw_excerpt);
    }
endif;

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');

/**
* Adds classes to body tag for CSS specificity over parent theme
*/
add_filter('body_class', 'isc_body_classes');
function isc_body_classes($classes) {
    $classes[] = 'isc';
    return $classes;
}

function theme_enqueue_scripts() {
    $dependencies = array('jquery');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/vendor/js/bootstrap.min.js', $dependencies, '4.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );


/* Relevanssi Search Results Filtering*/
add_filter('query_vars', 'relevanssi_qvs');
function relevanssi_qvs($qv) {
    $qv[] = 'type';
    return $qv;
}

add_filter('relevanssi_hits_filter', 'relevanssi_type_filter');
function relevanssi_type_filter($hits)
{
    global $wp_query;
    // echo '<br>query vars: ';
    // print_r($wp_query->query_vars);
    if (isset($wp_query->query_vars['type']))
    {
    	/*echo '<br>query types: ';
    	print_r($wp_query->query_vars['type']);*/
    	$filters = $wp_query->query_vars['type'];
    	$to_show = array();
    	if(in_array('all', $filters) || empty($filters))
    	{
    		return $hits;
    	}

    	$admin_corner_id = get_page_by_title("Administrators' Corner")->ID;
		$user_guide_id = get_page_by_title("User Guide Library")->ID;

		/*echo 'adminCorner: ' . $admin_corner_id;
		echo 'userGuide: ' . $user_guide_id;*/

    	foreach ($hits[0] as $hit)
    	{
    	if(in_array('adminCorner', $filters) && is_ancestor($hit,$admin_corner_id))
    		{
    			$to_show[] = $hit;
    			continue; 
    		}
    		else if(in_array('userGuide', $filters) && is_ancestor($hit,$user_guide_id))
    		{
    			$to_show[] = $hit;
    			continue; 
    		}
    		else if(in_array('news', $filters) && get_post_type($hit) === 'post' )
    		{
    			$to_show[] = $hit;
    			continue; 
    		}
    		else if(in_array('glossary', $filters) && get_post_type($hit) === 'glossary' )
    		{
    			$to_show[] = $hit;
    			continue; 
    		}
    		else if(in_array('others', $filters)
    				&& get_post_type($hit) !== 'glossary'
                	&& get_post_type($hit) !== 'post'
                	&& is_ancestor($hit, $user_guide_id) === false
                	&& is_ancestor($hit, $admin_corner_id) === false)
    		{
    			$to_show[] = $hit;
    		}

    	}
    	$hits[0] = $to_show;
    }
    return $hits;
}

function is_ancestor($post,$ansector_id){
    return in_array($ansector_id, get_post_ancestors( $post ));
}

add_filter('post_limits', 'postsperpage');
function postsperpage($limits) {
	if (is_search()) {
		global $wp_query;
		$wp_query->query_vars['posts_per_page'] = 20;
	}
	return $limits;
}

function get_filter_description(){
	global $wp_query;
	if (isset($wp_query->query_vars['type']))
	{
		$filters = $wp_query->query_vars['type'];
		if(in_array('all', $filters))
		{
			return '.';
		}

		$desc = ' in ';
	    if(in_array('userGuide', $filters) ){
	        $desc .= '<span class="filter-tag">User Guides</span>';
	    }
	    if(in_array('adminCorner', $filters) ){
	        $desc .= '<span class="filter-tag">Admins\' Corner pages</span>';
	    }
	    if(in_array('news', $filters) ){
	        $desc .= '<span class="filter-tag">News posts</span>';
	    }
	    if(in_array('glossary', $filters) ){
	        $desc .= '<span class="filter-tag">Glossary terms</span>';
	    }
	    if(in_array('others', $filters) ){
	        $desc .= '<span class="filter-tag">Pages</span>';
	    }
	    return $desc;
	}
	else
	{
		return '.';
	}
}



add_action('isc_request_ajax_adminNewsFilter', 'admin_news_filter_function');
add_action('isc_request_ajax_nopriv_adminNewsFilter', 'admin_news_filter_function');
function admin_news_filter_function(){

	//show all for default selection
	if($_POST['categoryfilter'] == 'select'){
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
	}
	//apply taxonomy query if category filter is not default
	else {

		$args = array(
				'tax_query' => array(
						'relation' => 'AND',
						array(
						  'taxonomy' => 'location',
						  'field'    => 'slug',
						  'terms'    => 'admin-corner-news',
					  	),
					  	array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => $_POST['categoryfilter']
						)
					),
				  'posts_per_page' => 5,
				  'post_status' => 'publish'
		 );
	}
	$query = new WP_Query( $args );
	print_admin_corner_news($query);
	die();
}

function print_admin_corner_news($admin_corner_news){
	echo $count_hide_script = <<<aijsruksjdf
	<script type="text/javascript">
		$()
	</script>
aijsruksjdf;

	$html = '';
	if ( $admin_corner_news->have_posts() ) {
		$news_stale_after = get_post_custom_values('news_stale_after_days', get_the_ID())[0];
		$new_news_count = 0;
		if (!is_int(news_stale_after)) {
			$news_stale_after = 3;
		}
		 while ( $admin_corner_news->have_posts() ) {
			 $admin_corner_news->the_post();
		 
	 
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
		   $post_link = esc_url( get_permalink() );
		   $post_title = get_the_title();
		   $post_date = get_the_date();
		   $post_excerpt = get_the_excerpt();



		   $html = <<<afwfqwafc
		   	<div class="line">
		   		<h4><a href="$post_link">$post_title</a>
afwfqwafc;
			$html .= $new_label;
			$html .= <<<rqfafaesfe
				</h4>
								   	</div><br>
								   <div class="line">
								   	<div class="update-date">$post_date</div>
								   	<div class="date-diff">$diff_display</div>
								   </div>
								   <div class='post-content'>$post_excerpt</div>
rqfafaesfe;
		   echo $html;
		}
		 echo '<a class="uw-btn btn-sm" href="'.get_site_url().'/news">View All News</a>';
	}
	else {
		echo 'No news items in this category' ;
	}
}

/**
* This function returns the URL string of the latest media post with the given title string.
*
* @param string $title Title of the media post.
* @return string  URL string of the latest media post. Empty String if no media with given title.
*
**/
function get_media_url_from_title($title){
	$args = array(
		'post_type' => 'attachment',
		'title' => sanitize_title($title),
		'posts_per_page' => 1,
		'sort_column'  => 'post_date',
		'sort_order'   => 'desc',
		'post_status' => 'inherit',
	  );
	  $query_results = get_posts( $args );
	  $attachment = $query_results ? array_pop($query_results) : null;
	return $attachment ? wp_get_attachment_url($attachment->ID) : '';
}


add_filter('get_the_archive_title', custom_post_archive_title);

function custom_post_archive_title ( $title ){
	if( is_post_type_archive() ){
		$title = post_type_archive_title('', false);
	}
	return $title;
}

add_action('wp_ajax_courseFilter', 'course_filter');
add_action('wp_ajax_nopriv_courseFilter', 'course_filter');

function course_filter(){
	
	// echo "POST: ";
	// print_r($_POST);
	// echo "<br>";
	$tax_query_base = array(
		'relation' => 'AND',
	);

	$args = array(
		'post_type' => 'workday_course',
		'posts_per_page' => -1,
		'tax_query' => $tax_query_base
	);

	$taxonomies = get_object_taxonomies( 'workday_course', 'objects' );

	$selected_taxonomy_ids = array();
	
	foreach ($taxonomies as $each_taxonomy ){

		if(isset($_POST[$each_taxonomy->name])){

			$selected_taxonomy_ids = array_merge($selected_taxonomy_ids, $_POST[$each_taxonomy->name] );

			array_push($args['tax_query'],  array(
				'taxonomy' => $each_taxonomy->name,
				'field' => 'id',
				'terms' => $_POST[$each_taxonomy->name]
			  ));
		}
	}

	// echo "args: ";
	// print_r( ($args['tax_query'] == $tax_query_base) == 1);

	if( $args['tax_query']  == $tax_query_base ){
		// echo "resetting";
		$args = array(
			'post_type' => 'workday_course',
			'posts_per_page' => -1,
		);
	}

	$page_value = 0;
	if(isset($_POST['page'])){
		$page_value = $_POST['page'];
	}

	print_workday_course_catalog($args, $page_value, $selected_taxonomy_ids);
	// $query = new WP_Query( $args );

	// if( $query->have_posts()) {
		// echo "<br> have posts: ";
		// $counter = 0;
		// echo"<br>";
		// while ( $query->have_posts() ) {
			// echo ++$counter;
	// 		$query->the_post();
	// 		print_workday_course_item();
	// 	}
	// }
	die();
}

function print_workday_course_catalog($post_args, $page_value = 0,  $selected_taxonomy_ids = array()){

	$page_size = 10;
	
	echo '<div class="col-md-4 course-filter-form">';
		print_course_filter_form($post_args, $selected_taxonomy_ids);
	echo '</div>';
	echo '<div class="col-md-8">';
		echo '<div class="div-overlay-white" hidden></div>';
		print_filter_status_bar($selected_taxonomy_ids);
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
					echo '<h4> Showing  ' . ($start_at + 1) . '-'. ($start_at + $page_size) . ' of '. $found_num.' Course'.$plural.'</h4>';
				}
				
				
				// echo "<br>start at:". $start_at;
				// echo "<br>page_size:". $page_size;
				// echo "<br>page_value:". $page_value;
				// echo "<br>possible_pages:". $possible_pages;

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
					// echo  '<a onclick="handlePrevClick(this)"> << prev </a>';
				}
				if( ($start_at + $page_size) < $found_num) {
					// echo  '<a onclick="handleNextClick(this)"> next >> </a>';
					echo '<div class="nav-next alignright"><a  onclick="handleNextClick(this)" class="uw-btn btn-sm">Next</a></div>';
				}
			} // end if
			else{
				echo "<h3> No Workday Courses </h3>";
			}
		echo '</div>';
	echo '</div>';
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

	echo  '<form action="'.site_url().'/wp-admin/admin-ajax.php" method="POST" id="courseFilterForm">';

	$taxonomies = get_object_taxonomies( 'workday_course', 'objects' );
									
	foreach ($taxonomies as $each_taxonomy ){
		
		print_filter_section( $each_taxonomy, $term_args, $selected_taxonomy_ids);
	}
		echo  '<input type="hidden" name="page" value="0">';
	echo  '<input type="hidden" name="action" value="courseFilter"> </form>';
}

/**
* This function renders the taxonomy terms
**/
function print_filter_section($taxonomy, $term_args, $selected_taxonomy_ids) {
	
	
	$term_args['taxonomy'] = $taxonomy->name;
	$my_term_query = new WP_Term_Query($term_args);

	if(count( $my_term_query->get_terms()) > 0){
		echo '<h5>'.$taxonomy->label.'</h5>';
	}

	foreach ( $my_term_query->get_terms() as $term ) {

		$checked_status = ( in_array($term->term_id, $selected_taxonomy_ids) == 1 ) ? "checked" : "" ;
		print_filter_item( $taxonomy->name , $term, $checked_status);
	}
}

function print_filter_item($name, $term, $checked_status) {
	echo '<label> <input onchange="handleCourseFilterChange()" type="checkbox" name="'.$name.'[]" value="' . $term->term_id . '" id="' . $term->term_id . '" '. $checked_status .' /> ' . $term->name .' ('.$term->count.')</label><br>'; 
}

function print_filter_status_bar($selected_taxonomy_ids){
	if(count($selected_taxonomy_ids) > 0) {
		echo '<ul  id="filterStatus" class="h-list">';
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
}

/**
* This function renders the current post as if it was a workday course listing.
**/
function print_workday_course_item(){
	if(get_post_type() != 'workday_course'){
		echo "Not a workday course!";
		return;
	}
	$post_title = get_the_title();

	$url = get_post_meta(get_the_ID(), 'course-url', true);

	$post_excerpt = get_the_excerpt();

	$duration = get_post_meta(get_the_ID(), 'course-duration', true);

	$release_date = get_post_meta(get_the_ID(), 'course-release-date', true);
	$release_date = date_create_from_format('m/d/Y', $release_date);
	$release_date = $release_date->format('M j, Y');

	$update_date = get_post_meta(get_the_ID(), 'course-update-date', true);
	$update_date = date_create_from_format('m/d/Y', $update_date);
	$update_date = $update_date->format('M j, Y');

	$read_more = esc_url(get_permalink());
	
	$post_html = <<<dnfndaskfn
	<h2><a target="_blank" href="$url"> {$post_title} </a></h2>
	<p>{$post_excerpt}</p>
	<ul class="post-metadata">
	<li> <b> Duration: </b> {$duration} mins</li>
		<li>| <b> Released On: </b> {$release_date}</li>
		<li>| <b> Updated On: </b> {$update_date}</li>
		<li>| <a href="{$read_more}"> more </a> </li>
	</ul>
dnfndaskfn;
	echo $post_html;
}

?>
