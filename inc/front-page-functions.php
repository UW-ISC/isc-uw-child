<?php
/**
 * Functions used on the front page of the site
 *
 * @author UW-IT AXDD
 * @copyright Copyright (c) 2016, University of Washington
 * @since     0.2.0
 *
 * @global $post
 * @package isc-uw-child
 */

if ( ! function_exists( 'isc_front_get_quicklinks' ) ) :
	/**
	 * Displays the quicklinks by querying the metadata of
	 * the homepage
	 */
	function isc_front_get_quicklinks() {
		$custom = get_post_meta( get_the_ID() );
		$html = '';
		if ( array_key_exists( 'isc-hero-quicklinks', $custom ) ) {
			$string = $custom['isc-hero-quicklinks'];
			$result = implode( $string );
			$data = unserialize( $result );
			$dataCount = count( $data );
			if ( $dataCount < 3 && $dataCount > 0 ) {
				for ( $i = 0; $i < $dataCount; $i++ ) {
					$html .= '<li><a class="btn-sm uw-btn" href="' . $data[ $i ]['isc-hero-quicklink-url'] . '">' . $data[ $i ]['isc-hero-quicklink-text'] . '</a></li>';
				}
			} elseif ( $dataCount >= 3 ) {
				for ( $i = 0; $i < 3; $i++ ) {
					$html .= '<li><a class="btn-sm uw-btn" href="' . $data[ $i ]['isc-hero-quicklink-url'] . '">' . $data[ $i ]['isc-hero-quicklink-text'] . '</a></li>';
				}
			} else {
				$html = 'No quicklinks found.';
			}
		}
		echo $html;
	}
endif;
