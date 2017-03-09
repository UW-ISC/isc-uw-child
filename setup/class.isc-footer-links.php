<?php
/**
 * ISC_FooterLinks
 *
 * This installs the footer menu location.
 *
 * @package isc-uw-child
 */

/**
 * ISC_FooterLinks
 */
class ISC_FooterLinks {


	const NAME              = 'Footer Links';
	const LOCATION       = 'footer-links';

	/**
	 * Constructor method
	 */
	function __construct() {
		$this->menu_items = array();
		add_action( 'after_setup_theme', array( $this, 'register_footer_links' ) );
	}

	/**
	 * Registration method
	 */
	function register_footer_links() {
		register_nav_menu( self::LOCATION, __( 'self::NAME' ) );
	}

}
