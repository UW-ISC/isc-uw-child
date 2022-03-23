<?php
/**
 * Child theme style class
 *
 * Install stylesheets
 *    - bloginfo('template_directory')  gives you the url to the parent theme
 *    - bloginfo('stylesheet_directory')  gives you the url to the child theme
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

/**
 * Child theme styles
 */
class UW_Styles {

	/**
	 * Stores theme style data
	 *
	 * @var $STYLES is an array of
	 * theme style arrays
	 */
	public $STYLES;

	/**
	 * This function constructs the styles for the theme
	 */
	function __construct() {
		$ver = wp_get_theme( 'isc-uw-child' )->version;

		$this->STYLES = array(

		'google-font-open' => array(
		  'id'      => 'google-font-open',
		  'url'     => '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700',
		  'deps'    => array(),
		  'version' => '3.6',
		  'admin'   => true,
		),

		'font-awesome' => array(
		'id'       => 'font-awesome',
		'url'      => '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
		'deps'     => array(),
		'version'  => '4.7.0',
		),

		'uw-master' => array(
		'id'      => 'uw-master',
		'url'     => get_bloginfo( 'template_url' ) . '/style' . $this->dev_stylesheet() . '.css',
		'deps'    => array(),
		'version' => '3.6',
		),

		'datatables-bootstrap' => array(
		'id'       => 'datatables-bootstrap',
		'url'      => '//cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css',
		'deps'     => array(),
		'version'  => '1.10.13',
		),

		 'isc-styles' => array(
		 'id'       => 'isc-styles',
		 'url'      => get_stylesheet_directory_uri() . '/isc-styles.css',
		 'deps'     => array(),
		 'version'  => $ver,
		 ),

		'owl-carousel' => array(
			'id'       => 'owl-carousel',
			'url'      => get_stylesheet_directory_uri() . '/owl.carousel.min.css',
			'deps'     => array(),
			'version'  => '2.3.4',
		),

		'owl-theme' => array(
			'id'       => 'owl-theme',
			'url'      => get_stylesheet_directory_uri() . '/owl.theme.default.css',
			'deps'     => array(),
			'version'  => '2.3.4',
		),

		'uw-style' => array(
		  'id'      => 'uw-style',
		  'url'     => get_bloginfo( 'stylesheet_url' ),
		  'deps'    => array( 'uw-master' ),
		  'version' => '3.6',
		  'child'   => true,
		),

		);

		add_action( 'wp_enqueue_scripts', array( $this, 'uw_register_default_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'uw_enqueue_default_styles' ) );
		add_action( 'admin_head', array( $this, 'uw_enqueue_admin_styles' ) );

	}

	/**
	 * Registers the styles within the STYLES array
	 */
	function uw_register_default_styles() {
		foreach ( $this->STYLES as $style ) {
			$style = (object) $style;

			wp_register_style(
				$style->id,
				$style->url,
				$style->deps,
				$style->version
			);

		}

	}

	/**
	 * This method enqueses the default styles
	 * of front-end pages, overwriting the default
	 * parent theme behavior if there is a specific
	 * child theme option
	 */
	function uw_enqueue_default_styles() {
		wp_enqueue_style( 'uw-master' );
		foreach ( $this->STYLES as $style ) {
			$style = (object) $style;

			if ( array_key_exists( 'child', $style )
				&& $style->child && ! $this->is_child_theme()
			) {
				continue;
			}

			wp_enqueue_style( $style->id );

		}

	}

	/**
	 * This method is used to emnqueue styles
	 * if a user is attemping to access an admin page
	 */
	function uw_enqueue_admin_styles() {
		if ( ! is_admin() ) {
			return;
		}

		foreach ( $this->STYLES as $style ) {

			$style = (object) $style;

			if ( array_key_exists( 'admin', $style )
				&& $style->admin
			) {
				wp_register_style(
					$style->id,
					$style->url,
					$style->deps,
					$style->version
				);

				wp_enqueue_style( $style->id );
			}
		}

	}

	/**
	 * Returns a boolean value of whether the current
	 * theme is a child theme(true) or not(false)
	 */
	function is_child_theme() {
		return get_bloginfo( 'template_directory' ) !== get_bloginfo( 'stylesheet_directory' );
	}

	/**
	 * This function returns a boolean value of whether
	 * a .dev user is logged in(true) or not(false)
	 */
	function dev_stylesheet() {
		return is_user_logged_in() ? '.dev' : '';
	}

}
