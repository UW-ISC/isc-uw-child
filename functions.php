<?php
/**
 * Set up the child / parent relationship and customize the UW object.
 *
 * @package isc-uw-child
 */

if (!function_exists('setup_uw_object')) {
    /**
     * Initialize the UW object.
     */
    function setup_uw_object()
    {
        include get_stylesheet_directory() . '/setup/class.uw.php';
        $UW = new UW();
        do_action('extend_uw_object', $UW);
        return $UW;
    }
}

/**
 * Remove any templates from the UW Marketing theme that will not be used
 *
 * @param array $templates Array of all the page templates.
 **/
function isc_remove_page_templates($templates)
{
    unset($templates['templates/template-no-title.php']);
    unset($templates['templates/template-big-hero.php']);
    unset($templates['templates/template-no-hero.php']);
    unset($templates['templates/template-no-sidebar.php']);
    unset($templates['templates/template-small-hero.php']);
    return $templates;
}

add_filter('theme_page_templates', 'isc_remove_page_templates');

/**
 * Remove unwanted metaboxes from special pages.
 **/
function isc_remove_special_page_template_metabox()
{
    global $post;
    $specials = array('homepage', 'user-guides', 'admin-corner');
    if (isset($post) && 'page' === $post->post_type && in_array($post->post_name, $specials)) {
        // I guess its a hacky way!
        remove_meta_box('uwpageparentdiv', 'page', 'side');
        remove_meta_box('sec_rolediv', 'page', 'side');
        remove_meta_box('ug-topicdiv', 'page', 'side');
        remove_meta_box('md-tagsdiv', 'page', 'side');
    }
}
add_action('admin_head', 'isc_remove_special_page_template_metabox');

/**
 * Rename Posts to News
 */
function isc_change_post_label()
{
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
function isc_change_post_object()
{
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->blog_display = 'Admins\' News';
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

if (current_user_can('edit_posts')) {
    add_action('admin_menu', 'isc_change_post_label');
    add_action('init', 'isc_change_post_object');
}

/**
 * Developer function for logging to the browser console. Do not leave log statements lying around!
 * We might want to remove this when we're done with development. (Will only work if WP_DEBUG === true)
 *
 * @param mixed $debug_output String, array, int, bool, or object to print to the javascript console.
 */
function log_to_console($debug_output)
{
    if (defined('WP_DEBUG') && WP_DEBUG) {
        // only echo if WP_DEBUG exists and is True.
        $cleaned_string = '';
        if (!is_string($debug_output)) {
            $debug_output = print_r($debug_output, true);
        }
        $str_len = strlen($debug_output);
        for ($i = 0; $i < $str_len; $i++) {
            $cleaned_string .= '\\x' . sprintf('%02x', ord(substr($debug_output, $i, 1)));
        }
        $javascript_ouput = "<script>console.log('Debug Info: " . $cleaned_string . "');</script>";
        echo $javascript_ouput;
    }
}

add_filter('the_excerpt', 'isc_excerpt_more');

/**
 * Adds a title element to the read more
 * links, to achieve better accessiblilty
 *
 * @param String $excerpt is the excerpt from the post object.
 */
function isc_excerpt_more($excerpt)
{
    $post = get_post();
    $excerpt .= '<p> <a class="more" title="' . get_the_title() . '" href="' . get_permalink($post->ID) . '"> Read more</a> </p>';
    return $excerpt;
}

/**
 * Echoes the page header based on passed options.
 * Options:
 * 'use_breadcrumbs' boolean to show/hide breadcrumbs. Default: true
 * 'breadcrumbs_options' array breadcrumbns options. Default: empty
 * 'use_date' boolean to hide/show timestamp. Default: true
 * 'use_created_date' boolean indicating to use creation date instead of modification date. Default: false
 * 'use_title' boolean to show/hide page title. Default: true
 * 'title' string value of title. Default: value returned by function call: isc_title(false)
 * 'echo' boolean indicating wether to echo or return. Default: true
 * 
 * @param array $options page header customization options
 */
function the_page_header( $options = []) {

    $use_breadcrumbs = true;
    $breadcrumbs_options =[];
    $use_date = true;
    $use_created_date = false;
    $use_title = true;
    $title ='';
    $echo = true;
    
    extract($options);

	if($use_breadcrumbs){
		$breadcrumbs_html = get_uw_breadcrumbs($breadcrumbs_options);
	}
	else{
		$breadcrumbs_html = ' ';
	}

	
	
	if($use_date) {
		if(! $use_created_date){
			$date_decription = 'Last updated';
			$date = the_modified_date('l, F j, Y', '', '', false);
		}
		else{
			$date_decription = 'Published on';
			$date = get_the_date('l, F j, Y', '', '', false);
		}
	} else {
		$date_decription = '';
		$date = '';
    }

    $title_html = '';
    
    if($use_title){

        if('' == $title){
            $title_value = isc_title(false);
        }
        else{
            $title_value = '<h1 class="title">' . $title  . '</h1>';
        }

        $title_html = <<<ofjakjfnnefniejroa
            <div class="title-n-info">
                $title_value
                <div class="isc-updated-date"> $date_decription  $date </div>
            </div>
ofjakjfnnefniejroa;
    }

    $page_header = <<<djajnokdnvn
	<div class="isc-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					$breadcrumbs_html
				</div>
            </div>
            $title_html
		</div>
	</div>
djajnokdnvn;

    if ($echo) {
        echo $page_header;
    } else {
        return $page_header;
    }
}

/**
 * Echoes the title of a page in an h2
 * (removing any potential html elements)
 *
 * @param boolean $echo if true then echoes the title, else returns the title.
 */
function isc_title($echo = true)
{
    $title = '<h1 class="title">' . esc_html(get_the_title()) . '</h1>';
    if ($echo) {
        echo $title;
    } else {
        return $title;
    }
}

add_filter('the_title', 'esc_html_title');

if (!function_exists('esc_html_title')):
    /**
     * Escape html from the title function.
     *
     * @param String $title from which to escape html.
     */
    function esc_html_title($title)
{
        return esc_html($title);
    }
endif;

/*add_filter('relevanssi_remove_punctuation', 'savehyphens_1', 9);
/**
 * Hack around relevanssi dropping punctuation from search queries.
 * Part 1 of 2.
 *
 * @param String $a The search query.
 */
/*function savehyphens_1($a)
{
    $a = str_replace('-', 'HYPHEN', $a);
    return $a;
}
*/
/*add_filter('relevanssi_remove_punctuation', 'savehyphens_2', 11);
/**
 * Hack around relevanssi dropping punctuation from search queries.
 * Part 2 of 2.
 *
 * @param String $a The search query.
 */
/*function savehyphens_2($a)
{
    $a = str_replace('HYPHEN', '-', $a);
    return $a;
}
*/

// Function determines the tags that custom_wp_trim_excerpt will allow
function allowedtags()
{
// Add custom tags to this string
    return '<strong>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<pre>';
}

// This function allows HTML tags within the excerpt
// Based off of this solution: https://wordpress.stackexchange.com/questions/141125/allow-html-in-excerpt/141136
if (!function_exists('custom_wp_trim_excerpt')):

    function custom_wp_trim_excerpt($excerpt)
{
        global $post;
        $raw_excerpt = $excerpt;
        if ('' == $excerpt) {
            $excerpt = get_the_content('');
            $excerpt = strip_shortcodes($excerpt);
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
function isc_body_classes($classes)
{
    $classes[] = 'isc';
    return $classes;
}

function theme_enqueue_scripts()
{
    $dependencies = array('jquery');
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri() . '/vendor/js/bootstrap.min.js', $dependencies, '4.0.0', true);
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

/* Relevanssi Search Results Filtering*/
add_filter('query_vars', 'relevanssi_qvs');
function relevanssi_qvs($qv)
{
    $qv[] = 'type';
    return $qv;
}

add_filter('relevanssi_hits_filter', 'relevanssi_type_filter');
function relevanssi_type_filter($hits)
{
    global $wp_query;
    // echo '<br>query vars: ';
    // print_r($wp_query->query_vars);
    if (isset($wp_query->query_vars['type'])) {
        /*echo '<br>query types: ';
        print_r($wp_query->query_vars['type']);*/
        $filters = $wp_query->query_vars['type'];
        $to_show = array();
        if (in_array('all', $filters) || empty($filters)) {
            return $hits;
        }

        $admin_corner_id = get_page_by_title("Administrators' Corner")->ID;
        $user_guide_id = get_page_by_title("User Guide Library")->ID;

        /*echo 'adminCorner: ' . $admin_corner_id;
        echo 'userGuide: ' . $user_guide_id;*/

        foreach ($hits[0] as $hit) {
            if (in_array('adminCorner', $filters) && is_ancestor($hit, $admin_corner_id)) {
                $to_show[] = $hit;
                continue;
            } else if (in_array('userGuide', $filters) && is_ancestor($hit, $user_guide_id)) {
                $to_show[] = $hit;
                continue;
            } else if (in_array('news', $filters) && get_post_type($hit) === 'post') {
                $to_show[] = $hit;
                continue;
            } else if (in_array('glossary', $filters) && get_post_type($hit) === 'glossary') {
                $to_show[] = $hit;
                continue;
            } else if (in_array('others', $filters)
                && get_post_type($hit) !== 'glossary'
                && get_post_type($hit) !== 'post'
                && is_ancestor($hit, $user_guide_id) === false
                && is_ancestor($hit, $admin_corner_id) === false) {
                $to_show[] = $hit;
            }

        }
        $hits[0] = $to_show;
    }
    return $hits;
}

function is_ancestor($post, $ansector_id)
{
    return in_array($ansector_id, get_post_ancestors($post));
}

add_filter('post_limits', 'postsperpage');
function postsperpage($limits)
{
    if (is_search()) {
        global $wp_query;
        $wp_query->query_vars['posts_per_page'] = 20;
    }
    return $limits;
}

function get_filter_description()
{
    global $wp_query;
    if (isset($wp_query->query_vars['type'])) {
        $filters = $wp_query->query_vars['type'];
        if (in_array('all', $filters)) {
            return '.';
        }

        $desc = ' in ';
        if (in_array('userGuide', $filters)) {
            $desc .= '<span class="filter-tag">User Guides</span>';
        }
        if (in_array('adminCorner', $filters)) {
            $desc .= '<span class="filter-tag">Admins\' Corner pages</span>';
        }
        if (in_array('news', $filters)) {
            $desc .= '<span class="filter-tag">News posts</span>';
        }
        if (in_array('glossary', $filters)) {
            $desc .= '<span class="filter-tag">Glossary terms</span>';
        }
        if (in_array('others', $filters)) {
            $desc .= '<span class="filter-tag">Pages</span>';
        }
        return $desc;
    } else {
        return '.';
    }
}

/* Filter News by categor changes - start */

/**
 * This function prints the post title (with link), updated date, and post excerpt for the current global post.
 **/
function print_news_item()
{

    $post_link = esc_url(get_permalink());
    $post_title = get_the_title();
    $post_update_date = get_the_date();
    $post_excerpt = get_the_excerpt();
    $post_categories = get_the_terms(get_the_ID(),'category');
    $diff_display = esc_html('(' . human_time_diff(get_the_time('U'), current_time('timestamp'))) . ' ago)';

    $html = <<<igfjsdnokgfnsmf
        <div class="news-post-item">
            <h2><a href="$post_link" title="$post_title" >$post_title</a></h2>
            <div class="line">
                <div class="update-date">$post_update_date</div>
                <div class="date-diff">$diff_display</div>
            </div>
            <div class="news-excerpt">
                <div class='post-content limit-to-4-lines'>$post_excerpt</div>
                <a class="more" title="$post_title" href="$post_link"> Read more</a>
            </div>
igfjsdnokgfnsmf;

    $html .= get_category_tags_list($post_categories);
    $html .= '<hr></div>';

    echo $html;
}

function get_category_tags_list($post_categories)
{
    $tags_list = '<div> <ul class="isc-news-category-tag-container"><label>Categories:</label>';
    $site_url = esc_url( get_site_url() );

    foreach($post_categories as $category_item){
        $category_item_id = $category_item->term_id;
        $tags_list .= '<li class="isc-news-category-tag" > <a href="'. $site_url.'/news?taxonomy=category&tag_ID='.$category_item_id.'"> '.$category_item->name .'</a> </li>';
    }

    $tags_list .= '</ul></div>';

    return $tags_list;
}

/**
 * This function prints news items: their title (with link), updated date, and post excerpt.
 *
 * @param WP_Query $query the query to use when printing posts, will use global query if not specified.
 */
function print_news($query = null)
{
    if (is_null($query)) {

        while (have_posts()) {
            the_post();
            print_news_item();
        }
    } else {

        while ($query->have_posts()) {
            $query->the_post();
            print_news_item();
        }
    }
}

/* Filter News by categor changes - end */

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

function print_admin_corner_news($admin_corner_news)
{
    $category_id = '';
    $category_label = '';
    if (null != $admin_corner_news->get('tax_query')) {
        if (isset($admin_corner_news->get('tax_query')[1])) {
            if (isset($admin_corner_news->get('tax_query')[1]['terms'])) {
                $category_id = $admin_corner_news->get('tax_query')[1]['terms'];
                $category_term = get_term_by('term_taxonomy_id', intval($category_id));
                $category_label = $category_term->name . ' ';
            }
        }
    }

    $html = '';
    if ($admin_corner_news->have_posts()) {
        $news_stale_after = get_post_custom_values('news_stale_after_days', get_the_ID())[0];
        $new_news_count = 0;
        if (!is_int('news_stale_after')) {
            $news_stale_after = 3;
        }
        while ($admin_corner_news->have_posts()) {
            $admin_corner_news->the_post();

            $diff_str = esc_html(human_time_diff(get_the_time('U'), current_time('timestamp')));
            $diff_display = esc_html('(' . human_time_diff(get_the_time('U'), current_time('timestamp'))) . ' ago)';

            $diff_arr = explode(" ", $diff_str);
            $diff_unit = $diff_arr[1];

            $new_post = false;
            $new_label = '';

            if (strpos($diff_unit, 'second') !== false ||
                strpos($diff_unit, 'min') !== false ||
                strpos($diff_unit, 'hour') !== false) {
                $new_post = true;
            } else if (strpos($diff_unit, 'day') !== false) {

                $diff_value = (int) $diff_arr[0];

                if ($diff_value <= $news_stale_after) {
                    $new_post = true;
                    $new_news_count += 1;
                }
            }
            if ($new_post) {
                $new_label = '<span class="new-news-label">new</span>';
            }
            $post_link = esc_url(get_permalink());
            $post_title = get_the_title();
            $post_date = get_the_date();
            $post_excerpt = get_the_excerpt();

            $html = <<<afwfqwafc
            <div class="news-post-item">
                <div class="line">
                    <h4><a href="$post_link">$post_title</a>
                    $new_label
                    </h4>
                </div><br>
                <div class="line">
                    <div class="update-date">$post_date</div>
                    <div class="date-diff">$diff_display</div>
                </div>
                <div class="news-excerpt">
                    <div class='post-content limit-to-4-lines'>$post_excerpt</div>
                    <a class="more" title="$post_title" href="$post_link"> Read more</a>
                </div>
afwfqwafc;
            $html .= get_category_tags_list(get_the_terms(get_the_ID(),'category'));
            $html .= '<hr></div>';
            echo $html;
        }
        echo '<a class="uw-btn btn-sm" href="' . get_site_url() . '/news?taxonomy=category&tag_ID=' . $category_id . '">View All ' . $category_label . 'News</a>';
    } else {
        echo 'No news items in this category';
    }
}

/**
 * This function returns the URL string of the latest media post with the given title string.
 *
 * @param string $title Title of the media post.
 * @return string  URL string of the latest media post. Empty String if no media with given title.
 */
function get_media_url_from_title($title)
{
    $args = array(
        'post_type' => 'attachment',
        'title' => $title,
        'posts_per_page' => 1,
        'sort_column' => 'post_date',
        'sort_order' => 'desc',
        'post_status' => 'inherit',
    );
    $query_results = get_posts($args);
    
    $attachment = $query_results ? array_pop($query_results) : null;
    return $attachment ? wp_get_attachment_url($attachment->ID) : '';
}

/**
 * This function prints (if echo param is not false) the HTML for an announcement item (icon, title, post content)
 * 
 * @param boolean $echo Specify wether to echo (true) or print (false)
 */
function the_announcement($echo = true){
	$announcement_icon = strtolower(get_post_meta(get_the_ID(), 'announcement_type', true ));
									$announcement_permalink = esc_url( get_permalink() );
									$announcement_title = the_title('','',false);
									$announcement_default_excerpt = get_the_excerpt();
									$announcement_excerpt = get_post_meta(get_the_ID(), 'announcement_excerpt', true );
									if(empty($announcement_excerpt)){
										$announcement_excerpt = $announcement_default_excerpt;
									}

									$announcement_html = <<<erhvsfvsfsza
									<div class="isc-announcement-item">
										<style>
											.isc-announcement-icon-$announcement_icon:before {
												content: "\\$announcement_icon";
											}
										</style>
										<i class="fa isc-btn-icon isc-announcement-icon isc-announcement-icon-$announcement_icon"></i>
										<div class="isc-announcement-content">
											<h3 class="isc-announcement-title">
												<a href="$announcement_permalink">$announcement_title</a>
											</h3>
											<div class="post-content isc-announcement-excerpt">$announcement_excerpt</div>
										</div>
									</div>
erhvsfvsfsza;
	if($echo){
		echo $announcement_html;
	}
	else{
		return $announcement_html;
	}
}

/**
 * This function helps you debug php objects by either directly echoing it in the HTML or logging it's value in the browser console.
 * 
 * @param string $label lable to display for object.
 * @param string $obj object to debug.
 * @param boolean $log_in_browser_console if true the object will be logged in the browser's console instead of directly to HTML.
 */
function debug_obj($label, $obj, $log_in_browser_console = true){
    //turn unconditional return on by uncommentinng it if you're not explicitly debugging stuff.
    // return;
    if($log_in_browser_console){
        echo '<script type="text/javascript">console.log("'.$label.'",">>>>'.print_r($obj,true).'<<<<");</script>';
        return;
    }
    echo "<br>====". $label . "=====<br>";
    print_r($obj);
    echo "<br>";
}

/**
 * This function tries to get the value of the option with 'key' from a privately published "Site Content Options" page with slug 'site-content-options'.
 * If the said page or the option with provided key is not found, it will return the 'default' value.
 * 
 * @param string $option_key meta key of the option.
 * @param string $default_value default value to use if Options page or the option with provided key is not found.
 * @param boolean $single If true, returns only the first value for the specified meta key. Default value: false
 */
function get_site_option_value($option_key, $default_value, $single = false){
    $options_page = get_page_by_path('site-content-options');
    if(null != $options_page){
        $option_value = get_post_meta($options_page->ID, $option_key, $single);
        if(!empty($option_value)){

            $field_props = CFS()->get_field_info($option_key, $options_page->ID);
            
            if(equate_if_exists('type',$field_props,'wysiwyg')){
                return do_shortcode($option_value);
            };
                        
            return $option_value;
        }
    }
    return $default_value;
}

/**
 * Returns the value in an array with given key if it exists. If it does not exist, the default value is returned.
 * 
 * @param string $array_key  The key/index to check in the array.
 * @param array $array_to_check_in  The array to check the key's existence in.
 * @param mixed $default_value  The default value to return when key is not present.
 */
function get_if_exists($array_key, $array_to_check_in, $default_value){
	
	if(array_key_exists($array_key, $array_to_check_in)){
		return $array_to_check_in[$array_key];
	}
	else{
		return $default_value;
	}
}

/**
 * Returns a boolean indicating if a given value is equal to the value associated with a given index in a give array.
 * If the given index does not exist in the given array - returns false.
 * 
 * @param string $array_key  The key/index to check in the array.
 * @param array $array_to_check_in  The array to check the key's existence in.
 * @param mixed $value_to_check_equality  The value to check quality with.
 */
function equate_if_exists($array_key, $array_to_check_in, $value_to_check_equality){
	
	if(array_key_exists($array_key, $array_to_check_in)){
		return $array_to_check_in[$array_key] == $value_to_check_equality;
	}
	else {
		return false;
	}
}

/** Disable WP's auto-generated xml sitemap **/

add_filter( 'wp_sitemaps_enabled', '__return_false' );

/** Start Gravity Forms customizations **/

/** Override default notification HTML to remove Subject from msg body **/

add_filter( 'gform_html_message_template_pre_send_email', 'notification_template' );
 
function notification_template( $template ) {
    $template = '
        <html>
            <head>
            </head>
            <body>
                {message}
            </body>
        </html>';
 
    return $template;
}

/** Enable cc in notifications **/
add_filter('gform_notification_enable_cc', 'enable_cc', 10, 3 );
 
function enable_cc( $enable, $notification, $form ){
  return true;
}

?>
