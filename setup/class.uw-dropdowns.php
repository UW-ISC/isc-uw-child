<?php
/**
 * UW_Dropdowns
 *
 * This installs the default dropdowns for the UW Theme
 *
 * @package isc-uw.child
 */

/**
 * UW_Dropdowns
 */
class UW_Dropdowns {

	const LOCATION       = 'purple-bar';

	/**
	 * Constructor method
	 */
	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_purple_bar_menu' ) );
	}

	/**
	 * Menu registration method
	 */
	function register_purple_bar_menu() {
		register_nav_menu( self::LOCATION, __( 'Purple Bar' ) );
	}

}
