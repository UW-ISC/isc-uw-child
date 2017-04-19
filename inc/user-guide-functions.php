<?php
/**
 * User Guide Functions
 *
 * Miscellaneous user guide template functions
 *
 * @package isc-uw-child
 */

	/**
	 * Object representing a Header on the user guide page
	 */
class Header {
	/**
	 * Header name
	 *
	 * @var string The name of the Header.
	 */
	public $name;
	/**
	 * Header slug
	 *
	 * @var string The slug of the Header.
	 */
	public $slug;
	/**
	 * The subheaders under the current Header
	 *
	 * @var array The subheaders under the current Header.
	 */
	public $subheaders;
	/**
	 * Constructor method
	 *
	 * @param string $name The name of the current Header.
	 * @param string $slug The slug of the current Header.
	 * @param array  $subheaders An array of subheaders (name mapped to the slug) under the current Header.
	 */
	function __construct( $name, $slug, $subheaders = array() ) {
		$this->name = $name;
		$this->slug = $slug;
		$this->subheaders = $subheaders;
	}
}

/**
 * ISC User Guide
 */
class ISCUserGuide {

	/**
	 * User Guide title
	 *
	 * @var string The title of the User Guide.
	 */
	public $name;

	/**
	 * User Guide permalink
	 *
	 * @var string The permalink of the User Guide
	 */
	public $url;

	/**
	 * Topics taxonomy
	 *
	 * @var array Taxonomy terms representing the topics that apply to the User Guide.
	 */
	public $topics;

	/**
	 * Security Role taxonomy
	 *
	 * @var array Taxonomy terms representing the security roles that apply to the User Guide.
	 */
	public $roles;

	/**
	 * Last Updated DateTime
	 *
	 * @var \DateTime The last modified date and time of the User Guide.
	 */
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


// Filters the content to add ids to the headers so that the menu will work.
add_filter( 'content_save_pre', 'isc_add_ids_to_header_tags_auto' );

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
			$temp_user_guide = new ISCUserGuide( $child->post_title, $url, $topics, $sec_roles, $date_updated );

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
	 * @param boolean $return If true, returns the html of the user guide menu. If false, echoes it instead.
	 */
	function isc_user_guide_menu( $return = false ) {

		// Gather all the headers within the isc_anchor_links metafield of the current page
		// which we will use to make the user guide menu.
		$headers = get_post_meta( get_the_ID(), 'isc_anchor_links', true );
		$pages = '';

		if ( empty( $headers ) || ! array_key_exists( 0, $headers ) ) {
			return;
		}
		// Iterate through the headers.
		$header_count = count( $headers );
		for ( $i = 0; $i < $header_count; $i++ ) {
			$cur = $headers[ $i ];
			// slug of the current header.
			$slug = $cur->slug;
			// name of the current header.
			$name = $cur->name;

			if ( count( $cur->subheaders ) > 0 ) {
				// This means there are subheaders under the current header.
				$pages .= '<li class="nav-item has-children"><a href="javascript:void();" class="nav-link children-toggle collapsed" role="button" data-toggle="collapse" data-target="#' . $slug . '" aria-controls="#' . $slug . '" aria-expanded="false">' . $name . '<i class="fa fa-2x"></i></a>';
				$pages .= '<ul class="children depth-1 collapse" id="' . $slug . '" style="height: 0px;">';
				// Iterate through the subheaders under the current header.
				foreach ( $cur->subheaders as $subname => $subslug ) {
					$pages .= '<li class="nav-item"><a class="nav-link" title="' . stripslashes( $subname ) . '" href="#' . $subslug . '">' . stripslashes( $subname ) . '</a></li>';
				}
				$pages .= '</ul></li>';
			} else {
				// If there are no subheaders under the current header, just put the header link.
				$pages .= '<li class="nav-item"> <a class="nav-link" title="' . $name . '" href="#' . $slug . '">' . $name . '</a></li>';
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
 * Add CSS ids to every <h2> and <h3> node. Saves the headers it finds
 * as a metadata field for the current page.
 *
 * @param string $content HTML content to be modified.
 */
function isc_add_ids_to_header_tags_auto( $content ) {
		$header_list = array();
		// The header types we want to look for (2:header, and 3:subheader).
		$look_for = '(h2|h3)';
		$regex = '#(?P<full_tag><(?P<tag_name>' . $look_for . ').*>(?P<tag_contents>[\s\S]*)<\/' . $look_for . '>)#Ui';

	if ( preg_match_all( $regex, $content, $matches ) ) {
		$header_type = $matches['tag_name']; // header or subheader.
		$header_name = $matches['tag_contents']; // name of the header.
		$current_header = null;
		$results_count = count( $header_name );
		// html tags we need to replace.
		$find = array();
		// the replacements with an added id slug.
		$replace = array();
		$top = '';
		for ( $i = 0; $i < $results_count; $i++ ) {
			$type = $header_type[ $i ];
			$name = wp_strip_all_tags( $header_name[ $i ] );
			$slug = '';
			if ( 'h2' === $type ) {
				$slug = wp_strip_all_tags( strval( count( $header_list ) + 1 ) . '-' . sanitize_title( $name ) );
				$current_header = new Header( $name, $slug );
				array_push( $header_list, $current_header );
			} elseif ( 'h3' === $type && null !== $current_header ) {
				$slug = wp_strip_all_tags( strval( count( $header_list ) ) . '-' . sanitize_title( $name ) );
				$current_header->subheaders[ $name ] = $slug;
			}
			$find[]    = $matches['full_tag'][ $i ];
			$id_attr   = sprintf( ' id="%s"', $slug );
			$replace[] = sprintf( '%1$s<%2$s%3$s>%4$s</%2$s>', $top, $type, $id_attr, $matches['tag_contents'][ $i ] );
		}

		$header_count = count( $find );
		for ( $i = 0; $i < $header_count; $i++ ) {
			$pos = strpos( $content, $find[ $i ] );
			if ( false !== $pos ) {
					// replacing only the first instance that we find (in case of duplicate headers/subheaders).
			    $content = substr_replace( $content, $replace[ $i ], $pos, strlen( $find[ $i ] ) );
			}
		}
	}// End if().
	// Update the isc_anchor_links metafield to store these headers under the current page.
	update_post_meta( get_the_ID(), 'isc_anchor_links', $header_list );
	return $content;
}
