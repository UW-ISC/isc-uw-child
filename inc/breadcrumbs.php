<?php
/**
 * Breadcrumb functions
 *
 * Various functions that output a breadcrumb trail.
 *
 * @package isc-uw-child
 */

if ( ! function_exists( 'get_uw_breadcrumbs' ) ) :
	/**
	 * This is the main breadcrumb function.
	 * Customization Options:
	 * 'insert_after_root' boolean indicating wether to insert custom breadcrumb trail. Default: false
	 * 'trail' array with breadcrumb nodes as label=>slug (absolute from root) to be inserted after root, only if 'insert_after_root' option is true. Default: []
	 * 
	 * @param array $options breadcrumbs customization options
	 */
	function get_uw_breadcrumbs($options=[]) {

		  global $post;
		  $blog_title = get_bloginfo( 'title' );
		  $html = '';
		  $htmlHome = '';
		if ( '' === $blog_title ) {
			$htmlHome .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url( '/' ) . '" title="Home"> Home </a><li>';
		} else {
			$htmlHome .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url( '/' ) . '" title="' . get_bloginfo( 'title' ) . '">' . get_bloginfo( 'title' ) . '</a><li>';
		}

		if(sizeof($options) > 0){
			if($options['insert_after_root'] && $options['trail']){
				foreach($options['trail'] as $each_node_label => $each_node_slug){
					$html .= '<li><a href="' . get_site_url() . '/'. $each_node_slug . '" title="' . $each_node_label . '">' . $each_node_label . '</a></li>';
				}
			}		
		}

		if ( is_404() ) {
			  $html .= '<li class="current"><span>Woof!</span>';
		} elseif ( is_search() ) {
			  $html .= '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
		} elseif ( is_author() ) {
			  $author = get_queried_object();
			  $html .= '<li class="current"><span> Author: ' . $author->display_name . '</span>';
		} elseif ( get_queried_object_id() === (Int) get_option( 'page_for_posts' ) ) {
			  $html .= '<li class="current"><span> ' . get_the_title( get_queried_object_id() ) . ' </span>';
		}

		  // If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
		if ( is_category() || is_single() || is_post_type_archive() || is_tax() ) {
			if ( is_tax() ) {
				$html .= '<li class="current"><span> ' . get_queried_object()->name . ' </span>';
			}
			if ( is_post_type_archive() ) {
				$posttype = get_post_type_object( get_post_type() );
				$html .= '<li class="current"><a href="' . get_post_type_archive_link( $posttype->query_var ) . '" title="' . $posttype->labels->menu_name . '">' . $posttype->labels->menu_name . '</a>';
			}
			
			if ( is_category() ) {
				$category = get_category( get_query_var( 'cat' ) );
				$html .= '<li class="current"><span>' . get_cat_name( $category->term_id ) . '</span>';
			}

			if ( is_single() ) {
				if ( has_category() ) {
					$thecat = get_the_category( $post->ID );
					$category = array_shift( $thecat );
					$category_name = get_cat_name( $category->term_id );
					$category_ID = get_cat_ID($category_name);
					$category_link = get_site_url() . '/news/?taxonomy=category&tag_ID='.$category_ID;
					
          $html .= '<li><a href="' . get_site_url() . '/news' . '" title="Admins\' News">Admins\' News</a></li>';
					$html .= '<li><a href="' . $category_link . '" title="' . $category_name . '">' . $category_name . '</a>';
				}
				if ( uw_is_custom_post_type() ) {
					$posttype = get_post_type_object( get_post_type() );
					$archive_link = get_post_type_archive_link( $posttype->query_var );
					if ( ! empty( $archive_link ) ) {
						$html .= '<li><a href="' . $archive_link . '" title="' . $posttype->labels->menu_name . '">' . $posttype->labels->menu_name . '</a>';
					} elseif ( ! empty( $posttype->rewrite['slug'] ) ) {
						$html .= '<li><a href="' . site_url( '/' . $posttype->rewrite['slug'] . '/' ) . '" title="' . $posttype->labels->menu_name . '">' . $posttype->labels->menu_name . '</a>';
					}
				}
				$html .= '<li class="current"><span>' . get_the_title( $post->ID ) . '</span>';
			}
		} // End if().
		elseif ( is_page() ) {

			if ( ! is_home() || ! is_front_page() ) {
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
			}
			  $ancestors[] = $post->ID;

			if ( ! is_front_page() ) {
				foreach ( array_filter( $ancestors ) as $index => $ancestor ) {
					$class      = $index + 1 === count( $ancestors ) ? ' class="current" ' : '';
					$page       = get_post( $ancestor );
					$url        = get_permalink( $page->ID );
					$title_attr = esc_attr( $page->post_title );
					$title      = esc_html( $page->post_title );
					if ( ! empty( $class ) ) {
						$html .= "<li $class><span>{$title}</span></li>";
					} else {
						$html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$title}</a></li>";
					}
				}
			}
		}

		  return "<nav class='uw-breadcrumbs' role='navigation' aria-label='breadcrumbs'><ul >$htmlHome</ul><ul class='crumbs-trace'><li></li>$html</ul></nav>";
	}

endif;

if ( ! function_exists( 'uw_breadcrumbs' ) ) :
	/**
	 * Returns the breadcrumb html.
	 * This overrides the function in the parent theme.
	 */
	function uw_breadcrumbs() {
		echo get_uw_breadcrumbs();
	}

endif;

/**
 * Check if page is direct child.
 *
 * @param int $page_id The ID of the post.
 */
function is_child( $page_id ) {
	global $post;
	if ( is_page() && ( '' !== $post->post_parent ) ) {
		return true;
	} else {
		return false;
	}
}
