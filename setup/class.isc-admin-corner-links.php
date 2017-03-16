<?php
/**
 * ISC_AdminCornerLinks
 *
 * This installs the front page quicklinks location.
 *
 * @package isc-uw-child
 */

/**
 * ISC_AdminCornerLinks
 */
class ISC_AdminCornerLinks {

	const LOCATION       = 'admin-corner-links';

	/**
	 * Constructor method
	 */
	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_admin_corner_links' ) );
	}

	/**
	 * Menu registration method
	 */
	function register_admin_corner_links() {
		register_nav_menu( self::LOCATION, __( 'Admin Corner Links' ) );
	}

}
