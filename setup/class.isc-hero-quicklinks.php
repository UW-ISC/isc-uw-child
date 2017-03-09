<?php
/**
 * ISC_HeroQuicklinks
 *
 * This installs the front page quicklinks location.
 *
 * @package isc-uw-child
 */

/**
 * ISC_HeroQuicklinks
 */
class ISC_HeroQuicklinks {


	const NAME              = 'Hero Quick Links';
	const LOCATION       = 'hero-quicklinks';

	/**
	 * Constructor method
	 */
	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_hero_quicklinks' ) );
	}

	/**
	 * Registration method
	 */
	function register_hero_quicklinks() {
		register_nav_menu( self::LOCATION, __( 'self::NAME' ) );
	}

}
