<?php
/**
 * ISC_WhiteBarLinks
 *
 * This installs the white bar menu location.
 *
 * @package isc-uw-child
 */

/**
 * ISC_WhiteBarLinks
 */
class ISC_WhiteBarLinks {

	const LOCATION       = 'white-bar-links';

	/**
	 * Constructor method
	 */
	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_white_bar_links' ) );
	}

	/**
	 * Registration method
	 */
	function register_white_bar_links() {
		register_nav_menu( self::LOCATION, __( 'White Bar Links' ) );
	}

}
