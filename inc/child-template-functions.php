<?php
/**
 * Displays the child pages of the current page as well as presenting a
 * table of contents that links to each individual child page's content
 *
 * @author UW-IT AXDD
 * @package isc-uw-child
 */

if ( ! function_exists( 'isc_display_child_pages_with_toc' ) ) :
	/**
	 * Display table of contents and child pages within the Page.
	 */
	function isc_display_child_pages_with_toc() {
		// The following lines grab all the children pages of the current page.
		$args = array(
		'parent' => get_the_ID(),
		'hierarchical' => 0,
		'sort_column' => 'menu_order',
		'sort_order' => 'asc',
		);
		$children_pages = get_pages( $args );
		$toc = count( $children_pages ) > 0;
		$html = '';
		if ( $toc ) {
			// Fancy title of Table of Contents.
			$html .= "<h2 class='isc-admin-header sr-only'>Table of Contents</h2>";
			$html .= "<div class='contact-widget-inner isc-widget-tan isc-toc' id='toc'>";
			$html .= '<ul>';
			// Echoing each children page's title.
			foreach ( $children_pages as $child ) {
				$html .= '<li><a href="#' . esc_attr( $child->post_name ) . '">';
				$html .= esc_html( $child->post_title );
				$html .= '</a></li>';
			}
			$html .= '</ul>';

			// Ending the Table of Contents.
			$html .= '</div>';
		}
		foreach ( $children_pages as $child ) {
			// Displaying the title of a child page.
			$url = get_permalink( $child );
			$html .= '<h2 class="title" id="' . esc_attr( $child->post_name ) . '"> <a href="' . $url . '">';
			$html .= esc_html( $child->post_title );
			$html .= '</a> </h2>';
			// Displaying the tags.
			$html .= isc_get_tags( $child );
			// Displaying the content.
			$html .= '<div class="isc-article-content">';
			// Making sure paragraphs are added in place of double line breaks.
			$html .= wpautop( $child->post_content );
			$html .= '</div>';

			if ( $toc ) {
				$html .= '<p class="isc-toc-top-btn"><a class="more" href="#top">Return to top</a></p>';
			}
		}
		echo $html;
	}
endif;

if ( ! function_exists( 'isc_display_child_pages' ) ) :
	/**
	 * Displays the child pages of the current page along with their body contents
	 *
	 * @author    Kevin Zhao <zhaok24@uw.edu>
	 * @copyright Copyright (c) 2016, University of Washington
	 * @since     0.2.0
	 *
	 * @global $post
	 */
	function isc_display_child_pages() {
		// The following lines grab all the children pages of the current page.
		$args = array(
		  'parent' => get_the_ID(),
		  'hierarchical' => 0,
		  'sort_column' => 'menu_order',
		  'sort_order' => 'asc',
		);
		$children_pages = get_pages( $args );
		$html = '';
		// Echoing/displaying each child page along with their body content.
		foreach ( $children_pages as $article ) {
			$page_url = get_permalink( $article );
			// Getting the content of the article.
			$body = $article->post_content;
			$html .= '<div class="isc-content-block">';
			$html .= '<h2 class="title"><a href="' . $page_url . '">';
			$html .= esc_html( $article->post_title );
			$html .= '</a></h2>';
			if ( '' !== $body ) {
				// Display the body of the child content.
				$html .= '<p> ' . $body . ' </p>';
			}
			$html .= '<a class="uw-btn btn-sm" title="' . esc_attr( $article->post_title ) . '" href="' . $page_url . '">Read More</a>';
			$html .= '</div>';
		}
		echo $html;
	}
endif;

if ( ! function_exists( 'isc_get_tags' ) ) :
	/**
	 * Get the tags of the given page object and return all the tags within a isc-toc-tags div in a elements with id tag.
	 *
	 * @author    Kevin Zhao <zhaok24@uw.edu>
	 * @copyright Copyright (c) 2017, University of Washington
	 * @since     0.7.0
	 * @param object $child The child Page to get associated tags from.
	 */
	function isc_get_tags( $child ) {
		$html = '';
		$posttags = get_the_terms( $child->ID, 'md-tags' );
		if ( ! is_wp_error( $posttags ) && ! empty( $posttags ) ) {
			$html .= '<div class="isc-toc-tags" id="tags">';
			$num_posttags = count( $posttags );
			for ( $x = 0; $x < $num_posttags - 1; $x++ ) {
				$tag = $posttags[ $x ];
				$link = get_term_link( $tag );
				$html .= '<a id="tag" href=' . $link . '>' . $tag->name . '</a>';
			}
			$finaltag = $posttags[ count( $posttags ) - 1 ];
			$html .= '<a id="tag" href=' . get_tag_link( $finaltag ) . '>' . $finaltag->name . ' </a>';
			$html .= '</div>';
		}
		return $html;
	}
	endif;

/**
 * Allow tags in excerpts
 *
 * @author    Ethan Turner <ezturner@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since     0.2.0
 */
function isc_allowedtags() {
	// Add custom tags to this string.
	   return '<p>,<br>,<a>,<strong>,<em>,<hr>';
}

if ( ! function_exists( 'isc_custom_wp_trim_excerpt' ) ) :
	/**
	 * Customize the excerpt that is returned for the Page content.
	 *
	 * @param string $isc_excerpt string HTML representing trimmed content of the Page.
	 */
	function isc_custom_wp_trim_excerpt( $isc_excerpt ) {
		global $post;
		$raw_excerpt = $isc_excerpt;
		if ( '' === $isc_excerpt ) {

			$isc_excerpt = get_the_content( '' );
			$isc_excerpt = strip_shortcodes( $isc_excerpt );
			$isc_excerpt = apply_filters( 'the_content', $isc_excerpt );
			$isc_excerpt = str_replace( ']]>', ']]&gt;', $isc_excerpt );
			$isc_excerpt = strip_tags( $isc_excerpt, isc_allowedtags() ); /*IF you need to allow just certain tags. Delete if all tags are allowed */

			// Set the excerpt word count and only break after sentence is complete.
				$excerpt_word_count = 55;
				$excerpt_length = apply_filters( 'excerpt_length', $excerpt_word_count );
				$tokens = array();
				$excerptOutput = '';
				$count = 0;

				// Divide the string into tokens; HTML tags, or words, followed by any whitespace.
				preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $isc_excerpt, $tokens );

			foreach ( $tokens[0] as $token ) {

				if ( $count >= $excerpt_word_count && preg_match( '/[\,\;\?\.\!]\s*$/uS', $token ) ) {
					// Limit reached, continue until , ; ? . or ! occur at the end.
					$excerptOutput .= trim( $token );
					break;
				}

				// Add words to complete sentence.
				$count++;

				// Append what's left of the token.
				$excerptOutput .= $token;
			}

			$isc_excerpt = trim( force_balance_tags( $excerptOutput ) );

				$excerpt_end = '';
				$excerpt_more = apply_filters( 'excerpt_more', ' ' . $excerpt_end );
				$isc_excerpt .= $excerpt_end; /*Add read more in new paragraph */

			return $isc_excerpt;

		}// End if().
		return apply_filters( 'isc_custom_wp_trim_excerpt', $isc_excerpt, $raw_excerpt );
	}

endif;

	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	add_filter( 'get_the_excerpt', 'isc_custom_wp_trim_excerpt' );

/**
 * Used for mobile navigation.
 * This overrides the function in the parent theme.
 */

if ( ! function_exists( 'uw_site_title' ) ) :
	/**
	 * Output title HTML for the header.
	 */
	function uw_site_title() {
		$classes = 'uw-site-title';
		if ( get_option( 'overly_long_title' ) ) {
			$classes .= ' long-title';
		}
		echo '<a aria-hidden="true" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo() ) . '"><div class="' . esc_attr( $classes ) . '">' . get_bloginfo() . '</div></a>';
	}

endif;
