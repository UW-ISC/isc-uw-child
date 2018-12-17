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

add_filter('relevanssi_hits_filter', 'rlv_gather_tags', 99);
/* Gets relevant Tags for Search Result Filtering
https://www.relevanssi.com/knowledge-base/category-filter-search-results-pages/
*/
function rlv_gather_tags($hits) {
    global $rlv_tags_present;
    $rlv_tags_present = array();
    $posts_match = false;
    $glossary_match = false;
    foreach ( $hits[0] as $hit ) {
        $terms = get_the_terms( $hit->ID, 'md-tags' );
        
        if(! $posts_match && $hit->post_type === 'post'){
        	$rlv_tags_present['news'] = 'matched';
        	$posts_match = true;
        	// echo '<p>NEWS'.$hit->post_type.'</p>';
        }
        if(! $glossary_match && $hit->post_type === 'glossary'){
        	$rlv_tags_present['glossary'] = 'matched';
        	$glossary_match - true;
        	// echo '<p>GLOSS'.$hit->post_type.'</p>';
        }
        else
        {
        	if(is_array($terms)) {
	            foreach ( $terms as $term ) {
	                $rlv_tags_present[ $term->term_id ] = $term->name;
	                // echo '<p>'.$hit->post_type.'</p>';
	            }
        	}
    	}
    }
    asort( $rlv_tags_present );
    return $hits;
}

function rlv_tag_dropdown() {
    global $rlv_tags_present, $wp_query;
    $query_values = $wp_query->query_vars['post_type'];
    $url ='';
    if ( !empty($query_values) ) {   	
    	$url = esc_url(remove_query_arg('post_type'));
            if(strpos($query_values, "post") !== false)
            {
                echo "<a class='isc-simple-button clear-filter-link' href='$url'><i class='fa fa-close isc-btn-icon'></i>News</a>";
                return;
            }
            if(strpos($query_values, "glossary") !== false)
            {
                echo "<a class='isc-simple-button clear-filter-link' href='$url'><i class='fa fa-close isc-btn-icon'></i>Glossary</a>";
                return;   
            }
        
    }
    $query_values = $wp_query->query_vars['md-tags'];
    
    if (!empty($query_values)) {
        foreach ( $rlv_tags_present as $tag_id => $tag_name ) {
            if(strpos($query_values, strval($tag_id) ) !== false)
            {
                
                $url = esc_url(remove_query_arg('md-tags'));
                echo "<a class='isc-simple-button clear-filter-link' href='$url'><i class='fa fa-close isc-btn-icon'></i>". $tag_name."</a>";
            }
        }
        
    }
    else {
        $select = "<select class='filter-dd' id='rlv_tag' name='rlv_tag'><option value=''>All</option>";
        // $select = "";
        $news_added = false;
        $glossary_added = false;
        foreach ( $rlv_tags_present as $tag_id => $tag_name ) {
        	// echo '<p>'.$tag_id.' : '. $tag_name. '</p>';
            if(strval($tag_id) !== 'news' && strval($tag_id) !== 'glossary' )
            	{
            		$select .= "<option value='$tag_id'>$tag_name</option>";
            	}
           else if ( strval($tag_id) === 'news' && !$news_added){
            		$select .= "<option value='post'>News</option>";	
            		$news_added = true;
            	}
            else if ( strval($tag_id) === 'glossary' && !$glossary_added){
            		$select .= "<option value='glossary'>Glossary</option>";	
            		$glossary_added =true;
            	}
        }
        $select .= "</select>";
        $url = esc_url(remove_query_arg('paged'));
        if (strpos($url, 'page') !== false) {
            $url = preg_replace('/page\/\d+\//', '', $url);
        }
        $select .= <<<EOH
 
<script>
<!--
    var dropdown = document.getElementById("rlv_tag");
    function onTagChange() {
    	if ( dropdown.options[dropdown.selectedIndex].value == 'post' ) {
            location.href = "$url"+"&post_type=post";
        }
        else if ( dropdown.options[dropdown.selectedIndex].value  == 'glossary' ) {
            location.href = "$url"+"&post_type=glossary";
        }
        else if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
            location.href = "$url"+"&md-tags="+dropdown.options[dropdown.selectedIndex].value;
        }
    }
    dropdown.onchange = onTagChange;
-->
</script>
EOH;
 
        echo $select;
    }
}

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

function get_breadcrumbs($post){
    $html = '<div class="search-breadcrumbs"><span class="crumb">ISC</span>';

    if (get_post_type($post) == 'page')
        {
        $parents = get_post_ancestors($post->ID);
        $parents = array_reverse($parents);
        foreach($parents as $parent)
            {
            $html.= '<span class="crumb"> <a href="' . get_permalink($parent) . '">' . get_the_title($parent) . '</a></span>';
            }
        }
      else
    if (get_post_type($post) == 'post')
        {
            $year = get_the_date('Y', $post->post_ID);
            $month = get_the_date('F', $post->post_ID);
            $month_number = get_the_date('m', $post->post_ID);
            $day = get_the_date('j', $post->post_ID);
            $html.= '<span class="crumb"><a href="news">News</a></span><span class="crumb"><a href="'.get_year_link($year,$month_number,$day).'">' . $year . '</a></span><span class="crumb"><a href="'.get_month_link($year,$month_number,$day).'">' . $month . '</a></span><span class="crumb"><a href="'.get_day_link($year,$month_number,$day).'">' . $day . '</a></span>';
        }
      else
    if (get_post_type($post) == 'glossary')
        {
        $html.= '<span class="crumb"> <a href="glossary"> HR/Payroll Glossary </a> </span>';
        }

    $html.= '<span class="crumb" style="color: #3a3a3a;">' . get_the_title($post->post_ID) . '</span>';
    $html.= '</div>';
    return  $html;  
}

function all_or_nothing($filter_args){
    if($filter_args['all'] === 'on' || 
        (!isset($filter_args['all']) &&
        !isset($filter_args['userGuide']) &&
        !isset($filter_args['adminCorner']) &&
        !isset($filter_args['adminCorner']) &&
        !isset($filter_args['news']) &&
        !isset($filter_args['glossary']) &&
        !isset($filter_args['others']) )){
        return true;
    }
    else return false;
}

function is_ancestor($post,$ansector_id){
    /*echo '<br>';
    print_r(get_the_title($post));
    echo ':';
    print_r(get_post_ancestors( $post ));*/
    return in_array($ansector_id, get_post_ancestors( $post ));
}

function show_search_result($filter_args,$result_post){
   /* echo '<br>post_type :';
    print_r(get_post_type($result_post) );
    echo '<br>filter:';
    print_r($filter_args );
    echo '<br>parent:';
    print_r(wp_get_post_parent_id($result_post->post_ID));*/
    
    if(all_or_nothing($filter_args) ){
        return true;
    }
    else if($filter_args['userGuide'] === 'on' && is_ancestor($result_post, 541) ){ //if parent is User Guide Library.
            return true;
    }
    else if($filter_args['adminCorner'] === 'on' && is_ancestor($result_post, 1594) ){ //if parent is Admin's Corner.
            return true;
    }
     else if($filter_args['news'] === 'on' && get_post_type($result_post) === 'post' ){ //if its a news post.
            return true;
    }
    else if($filter_args['glossary'] === 'on' && get_post_type($result_post) === 'glossary' ){ //if its a glossary item.
            return true;
    }
    else if($filter_args['others'] === 'on' && (
        get_post_type($result_post) !== 'glossary' &&
        get_post_type($result_post) !== 'post' &&
        wp_get_post_parent_id($result_post->post_ID) !== 1594 &&
        wp_get_post_parent_id($result_post->post_ID) !== 541) ) { //other things.
            return true;
        }
    else {
        
        return false;
    }
}

function get_filter_description($filter_args){
    if(all_or_nothing($filter_args)){
        return '';
    }else {
        $desc = ' in ';
        if($filter_args['userGuide'] === 'on'){
            $desc .= '<span class="filter-tag">User Guides</span>';
        }
        if($filter_args['adminCorner'] === 'on'){
            $desc .= '<span class="filter-tag">Admin\'s Corner</span>';
        }
        if($filter_args['news'] === 'on'){
            $desc .= '<span class="filter-tag">News</span>';
        }
        if($filter_args['glossary'] === 'on'){
            $desc .= '<span class="filter-tag">Glossary</span>';
        }
        if($filter_args['others'] === 'on'){
            $desc .= '<span class="filter-tag">Others</span>';
        }
        return $desc;
    }
}

function relevanssi_search_results($filter_args){
    global $wp_query;
    // $wp_query->query_vars['posts_per_page'] = -1
    /*echo '<br> get search query: ';
    print_r(get_search_query());

    echo '<br> filter_args: ';
    print_r($filter_args);*/

    if(null==get_search_query() && isset($filter_args['query'])){
        $search_query = $filter_args['query'] ;
        $args = array(
            's'=> $search_query,
            'posts_per_page' => -1
        );
        $wp_query = new WP_Query($args);
    }
    else {
        $search_query = get_search_query();
    }

   /* echo '<br>Posts per Page: ';
    print_r($wp_query);*/

    /*echo '<br> wp query: ';
    print_r($wp_query);*/

    
    $total_results = $wp_query->found_posts;
    $results_content ='';

    
    

    if ( function_exists( 'relevanssi_didyoumean' ) ) {
        relevanssi_didyoumean( $search_query, '<p>Did you mean: ', '</p>', 3 );
    }
        
    $i = 0;
    $terms = rawurlencode( $search_query );
    $url = 'http://www.washington.edu/search/?q=' . $terms;
    $search_status = '';
    $post_content ='';
    $recommendation = '';

    remove_filter('get_the_excerpt', 'wp_trim_excerpt');
    add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');

    if ( have_posts() ) {
        while ( have_posts() ) : the_post();
                {
                    // echo '<br><br>';
                    if(show_search_result($filter_args,$the_post)){
                        $post_content .= '<div class="search-result">';
                        $post_content .= '<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                        $post_content .= get_breadcrumbs($the_post);
                        // echo $post_content;
                        $excerpt = get_the_excerpt($the_post->ID);
                        if(stripos($excerpt,'e8e3d3') === false)
                        {
                            $keys = implode('|', explode(' ', $search_query));
                            $excerpt = preg_replace('/(' . $keys .')/iu', '<span style="background-color: #e8e3d3">\0</span>', $excerpt);
                        }
                        $post_content .= '<div class="post-content">'.$excerpt;
                        $post_content .= '<a class="more" title="'.get_the_title($the_post).'" href="'.get_the_permalink($the_post).'"><br>Read more</a></div>';
                        $post_content .='</div>';
                        $i++;
                    }
                    else{
                        // echo '<br>Nope';
                    }
                }
            endwhile;

        $search_status =  'Showing <b> ' . $i .'</b> results for <i>"' . $search_query . '"</i>'.get_filter_description($filter_args);

        if ( $i <= 1 ) {
                $recommendation .= '<p class="little-results">';
                $recommendation .= 'Try searching for ';
                $recommendation .= '<a href="'.$url.'"> '. $search_query .'</a>';
                $recommendation .= ' across all of the UW for additional results.</p>';
            }
        }
        else {
            $recommendation .= '<p class="no-results">';
            $recommendation .= 'Sorry, no results matched your criteria. Try searching for ';
            $recommendation .= '<a href="'.$url.'"> '. $search_query .'</a>';
            $recommendation .= ' across all of the UW.</p>';
        } 
    $html =  $search_status.$post_content.$recommendation;
    $html = substr($html, 0,-1); 

    echo $html;
}

function search_results_filter_function(){
    relevanssi_search_results($_POST);
}


function postsperpage($limits) {
    if (is_search()) {
        global $wp_query;
        $wp_query->query_vars['posts_per_page'] = -1;
    }
    return $limits;
}

add_filter('post_limits', 'postsperpage');
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts' );
add_action('wp_ajax_searchResultFilter', 'search_results_filter_function'); 
add_action('wp_ajax_nopriv_searchResultFilter', 'search_results_filter_function');
?>
