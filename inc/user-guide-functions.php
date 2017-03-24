<?php
/**
 * User Guide Functions
 *
 * Miscellaneous user guide template functions
 *
 * @package isc-uw-child
 */

/**
 * ISC User Guide
 */
class isc_user_guide {

	/** @var string The title of the User Guide. */
	public $name;
	/** @var string The permalink of the User Guide */
	public $url;
	/** @var array Taxonomy terms representing the topics that apply to the User Guide. */
	public $topics;
	/** @var array Taxonomy terms representing the security roles that apply to the User Guide. */
	public $roles;
	/** @var \DateTime The last modified date and time of the User Guide. */
	public $last_updated;

	/**
	 * Constructor method
	 *
	 * @param string    $name The title of the User Guide.
	 * @param string    $url The permalink of the User Guide.
	 * @param array     $topics Taxonomy terms representing the topics that apply to the User Guide.
	 * @param array     $roles Taxonomy terms representing the security roles that apply to the User Guide.
	 * @param \DateTime $last_updated The last modified date and time of the User Guide.
	 */
	function __construct( $name, $url, $topics, $roles, $last_updated ) {
		$this->name = $name;
		$this->url = $url;
		$this->topics = $topics;
		$this->roles = $roles;
		$this->last_updated = $last_updated;
	}
}

if ( ! function_exists( 'sanitize_array' ) ) :
	/**
	 * Sluggifies an array of taxonomy terms.
	 *
	 * @param array $elements An array of taxonomy terms assigned to the Post.
	 */
	function sanitize_array( $elements ) {
		$sanitized = array();
		foreach ( $elements as $el ) {
			array_push( $sanitized, sanitize_title( $el ) );
		}
		return $sanitized;
	}
endif;
if ( ! function_exists( 'isc_get_user_guides' ) ) :
	/**
	 * Simply gets the child pages of the current page when called on the user guide library page, and returns all of the user guides.
	 */
	function isc_get_user_guides() {
		  $args = array(
			'parent' => get_the_ID(),
			'hierarchical' => 0,
			'sort_column' => 'menu_order',
			'sort_order' => 'asc',
		  );
		  $children_pages = get_pages( $args );
		  $user_guides = array();
		foreach ( $children_pages as $child ) {
			$security_query = get_the_terms( $child->ID, 'sec_role' );
			$sec_roles = array();
			if ( ! empty( $security_query ) ) {
				foreach ( $security_query as $role ) {
					array_push( $sec_roles, $role->name );
				}
			}

			$topic_query = get_the_terms( $child->ID, 'ug-topic' );
			$topics = array();
			if ( ! empty( $topic_query ) ) {
				foreach ( $topic_query as $topic ) {
					array_push( $topics, $topic->name );
				}
			}

			$url = get_permalink( $child );
			$date_updated = new DateTime( $child->post_modified_gmt );
			$temp_user_guide = new isc_user_guide( $child->post_title, $url, $topics, $sec_roles, $date_updated );

			array_push( $user_guides, $temp_user_guide );
		}
		  return $user_guides;
	}
endif;


if ( ! function_exists( 'isc_user_guide_table' ) ) :
	/**
	 * Generates HTML for the table of User Guides on the User Guide index.
	 *
	 * @param array $user_guides An array of User Guide Posts.
	 */
	function isc_user_guide_table( $user_guides ) {
		$html = '';
		foreach ( $user_guides as $guide ) {
			$sanitized_topics = sanitize_array( $guide->topics );
			$sanitized_roles = sanitize_array( $guide->roles );
			$data_roles = empty( $sanitized_roles ) ? '' : 'data-roles="' . implode( ' ', $sanitized_roles ) . '"';
			$data_topics = empty( $sanitized_topics ) ? '' : 'data-topics="' . implode( ' ', $sanitized_topics ) . '"';
			$topics = count( $guide->topics ) === 0 ? ('---') : (implode( ', ', $guide->topics ));
			$roles = count( $guide->roles ) === 0 ? ('---') : (implode( ', ', $guide->roles ));

			$html .= '<tr id="user-guide" ' . $data_roles . $data_topics . '>';
			$html .= '<td width="33%"><a href="' . $guide->url . '">';
			$html .= $guide->name;
			$html .= '</a></td>';
			$html .= '<td width="33%">' . $topics . '</td>';
			$html .= '<td width="33%">' . $roles . '</td>';
			$html .= '</tr>';
		}
			echo $html;
	}
endif;


if ( ! function_exists( 'isc_get_all_topics' ) ) :
	/**
	 * Gets all of the taxonomy terms for Topics.
	 *
	 * @param array $user_guides An array of User Guide Posts.
	 */
	function isc_get_all_topics( $user_guides ) {
		$topics = array();
		foreach ( $user_guides as $guide ) {
			foreach ( $guide->topics as $topic ) {
				array_push( $topics, $topic );
			}
		}
		return array_unique( $topics );
	}
endif;

if ( ! function_exists( 'isc_get_all_roles' ) ) :
	/**
	 * Gets all of the taxonomy terms for Security Roles.
	 *
	 * @param array $user_guides An array of User Guide Posts.
	 */
	function isc_get_all_roles( $user_guides ) {
		$topics = array();
		foreach ( $user_guides as $guide ) {
			foreach ( $guide->roles as $role ) {
				array_push( $topics, $role );
			}
		}
		return array_unique( $topics );
	}
endif;


if ( ! function_exists( 'isc_user_guide_menu' ) ) :
	/**
	 * User Guide Menu
	 *
	 * Lists all User Guides in the sidebar and also builds an
	 * in-page navigation.
	 *
	 * @author Abhishek Chauhan <abhi3@uw.edu>
	 */
	function isc_user_guide_menu( $return = false ) {

		// Grabs all the headers in the content.
		$headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
		$pages = '';
		$subarray = array();
		$temp_storage = array();
		$headarray = array();

		// Filters the content to add ids to the headers so that the menu will work.
		add_filter( 'the_content', 'isc_add_ids_to_header_tags_auto' );

		// Parse through all the headers and sift/sort headers/subheaders.
		if ( ! empty( $headers ) ) {
			foreach ( $headers as $slug => $header ) {
				 $content = substr( $header, 1, strlen( $header ) );
				 $heading_type = substr( $header, 0, 1 );
				if ( '3' === $heading_type ) {
					// It is a header!
					array_push( $subarray, $temp_storage );
					// Reset the temp_storage array to gather new subheaders under the new header.
					$temp_storage = array();
					// Add the header to the headarray.
					array_push( $headarray, array( $slug, $content ) );
				} else {
					// It is a subheader, store it until we see the next header... or the content ends.
					array_push( $temp_storage, array( $slug, $content ) );
				}
			}
		}

		// Push the subheaders under the last header.
		array_push( $subarray, $temp_storage );
		// Ignoring all the subheaders that occured before the first header.
		array_shift( $subarray );

		// Iterate through the headers.
		$headarray_count = count( $headarray );
		for ( $i = 0; $i < $headarray_count; $i++ ) {
			// The subheaders (if any) under the current header.
			$subheaders = $subarray[ $i ];
			// The slug of the current header.
			$slug = wp_strip_all_tags( $headarray[ $i ][0] );
			// Title of the current header.
			$title = wp_strip_all_tags( $headarray[ $i ][1] );
			if ( count( $subheaders ) > 0 ) {
				// This means there are subheaders under the current header.
				$pages .= '<li class="nav-item has-children"> <button class="nav-link children-toggle collapsed" data-toggle="collapse" data-target="#' . $slug . '" aria-controls="#' . $slug . '" aria-expanded="false">' . $title . '<i class="fa fa-2x"></i></button>';
				$pages .= '<ul class="children depth-1 collapse" id="' . $slug . '" aria-expanded="false" style="height: 0px;">';
				// Iterate through the subheaders under the current header.
				$subheaders_count = count( $subheaders );
				for ( $j = 0; $j < $subheaders_count ; $j++ ) {
					// The slug of the current subheader.
					$subslug = wp_strip_all_tags( $subheaders[ $j ][0] );
					// The title of the current subtitle.
					$subtitle = wp_strip_all_tags( $subheaders[ $j ][1] );
					// Append the subheaders.
					$pages .= '<li class="nav-item"> <a class="nav-link" title="' . $subtitle . '" href="#' . $subslug . '">' . $subtitle . '</a></li>';
				}
				$pages .= '</ul></li>';
			} else {
				// If there are no subheaders under the current header, just put the header link.
				$pages .= '<li class="nav-item"> <a class="nav-link" title="' . $title . '" href="#' . $slug . '">' . $title . '</a></li>';
			}
		}

		// Add the title of the table of contents, this is the first element.
		$first_li = $return ? '' : '<li class="nav-item"><a class="nav-link first" href="#top" title="Permanent Link to ' . get_bloginfo( 'name' ) . '"> Table of Contents </a></li>';

		$html = sprintf(
			'<ul>%s%s</ul>',
			$first_li,
			$pages
		);

		if ( empty( $pages ) ) {
			if ( $return ) {
				return false;
			} else {
				echo '';
			}
		} else {
			$menu = '<nav class="uw-accordion-menu float-menu" id="pageNav toc" aria-label="Site Menu" tabindex="-1" >' . $html . '</nav>';
			if ( $return ) {
				return $menu;
			} else {
				echo $menu;
			}
		}
	}
endif;


	/**
	 * Build an array of <h3> and <h4> nodes from the Post content.
	 *
	 * @param int $post_id The ID of the Post.
	 */
function isc_build_page_navigation( $post_id ) {
		// Grab the post and post_content.
		$page_data = get_post( $post_id );
		$page_content = $page_data ? $page_data->post_content : '';

		$links = array();
		$results = '';
		// The header types we want to look for (3:header, and 4:subheader).
		$options = '([34])';
				$regex = '/<h' . $options . '.*?>(.*?)<\/h\1>/';

	if ( preg_match_all( $regex, $page_content, $matches ) ) {
		$results = $matches[2];
		$results2 = $matches[0];
		$results_count = count( $results );
		for ( $i = 0; $i < $results_count; $i++ ) {
			$header_type = substr( $results2[ $i ], 2, 1 );
			$heading = $results[ $i ];
			$slug = sanitize_title( $heading );
			$links[ $slug ] = $header_type . $heading;
		}
	} else {
		$results = '';
	}

		// Slugs are added to the h3s and h4s in a filter on the_content function.
		update_post_meta( $post_id, '_uwhr_page_anchor_links', $links );
}

/**
 * Add CSS ids to every <h3> and <h4> node.
 *
 * @param string $content HTML content to be modified.
 */
function isc_add_ids_to_header_tags_auto( $content ) {
	// Making sure the headers have been gathered first.
	isc_build_page_navigation( get_the_ID() );

	// _uwhr_page_anchor_links represents if a post contains these anchor links, so if there are no links we don't want to bother with this method...
	$headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
	if ( empty( $headers ) ) {
		return $content;
	}
	// the header types we want to look for (h3 and h4).
	$look_for = '(h3|h4)';
	$pattern = '#(?P<full_tag><(?P<tag_name>' . $look_for . ')>(?P<tag_contents>.*)<\/' . $look_for . '>)#i';
	if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
		$find = array();
		$replace = array();
		$top = '';
		foreach ( $matches as $match ) {
			$find[]    = $match['full_tag'];
			$id        = sanitize_title( $match['tag_contents'] );
			$id_attr   = sprintf( ' id="%s"', $id );
			$replace[] = sprintf( '%1$s<%2$s%3$s>%4$s</%2$s>', $top, $match['tag_name'], $id_attr, $match['tag_contents'] );
		}
		$content = str_replace( $find, $replace, $content );
	}
	return $content;
}


