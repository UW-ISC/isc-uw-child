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
		$excerpt .= '<a class="more" title="' . get_the_title() . '" href="' . get_permalink( $post->ID ) . '"> Read more</a>';
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
