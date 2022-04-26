<?php
/**
 * This class contains methods used to interact with the scripts of the
 * child theme
 * This is where all the JS files are registered
 *    - bloginfo('template_directory')  gives you the url to the parent theme
 *    - bloginfo('stylesheet_directory')  gives you the url to the child theme
 *
 * @package isc-uw-child
 */

	/**
	 * This file overrides that of the parent theme
	 *
	 * @author UW-IT AXDD
	 */
class UW_Scripts {

	/**
	 * This variable is used to to store the scripts to use
	 *
	 * @var $SCRIPTS
	 */
	public $SCRIPTS;

	/**
	 * This method constructs the scripts of the theme
	 */
	function __construct() {

		$multi = is_multisite();
		$parent = get_bloginfo( 'template_url' );
		$child = get_stylesheet_directory_uri();

		$this->SCRIPTS = array_merge(
			array(

			'jquery' => array(
			'id'      => 'jquery',
			'url'     => 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
			'deps'    => array(),
			'version' => '1.12.4',
			'admin'   => false,
			),

			'site'   => array(
			'id'        => 'site',
			'url'       => $parent . '/js/site' . $this->dev_script() . '.js',
			'deps'      => array( 'backbone' ),
			'version'   => '1.0.3',
			'admin'     => false,
			'style_dir' => site_url(),
			),

			'admin' => array(
			'id'      => 'wp.admin',
			'url'     => $parent . '/assets/admin/js/admin.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.0',
			'admin'   => true,
			),

			'sticky' => array(
			'id'      => 'sticky',
			'url'     => $child . '/assets/js/sticky.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.0',
			'admin'   => false,
			),

			'jquery-datatables' => array(
			'id'      => 'jquery-datatables',
			'url'     => 'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.10.13',
			'admin'   => false,
			),

			'datatables-bootstrap' => array(
			'id'      => 'datatables-bootstrap',
			'url'     => 'https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.10.13',
			'admin'   => false,
			),

			'bootstrap-collapse' => array(
			'id'      => 'bootstrap-collapse',
			'url'     => $child . '/vendor/js/bootstrap-collapse.js',
			'deps'    => array( 'jquery' ),
			'version' => '2.0.4',
			'admin'   => false,
			),

			'owl-carousel' => array(
				'id'      => 'owl-carousel',
				'url'     => $child . '/vendor/js/owl.carousel.min.js',
				'deps'    => array( 'jquery' ),
				'version' => '2.3.4',
				'admin'   => false,
			),

			'isc-collapse-additions' => array(
			'id'      => 'isc-collapse-additions',
			'url'     => $child . '/assets/js/isc-collapse-additions.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.0.0',
			'admin'   => false,
			),

			'jquery-succinct' => array(
			'id'      => 'jquery-succinct',
			'url'     => $child . '/vendor/js/jquery.succinct.min.js',
			'deps'    => array( 'jquery' ),
			'version' => '1.1.0',
			'admin'   => false,
			),

			'isc-js' => array(
			'id'      => 'isc-js',
			'url'     => $child . '/assets/js/isc.js',
			'deps'    => array(),
			'version' => '1.0.0',
			'admin'   => false,
			),

			// Disabling as part of switch to GTM code	
			// 'isc-analytics-js' => array(
			// 'id'      => 'isc-analytics-js',
			// 'url'     => $child . '/assets/js/isc-analytics.js',
			// 'deps'    => array(),
			// 'version' => '1.0.0',
			// 'footer'  => true,
			// 'admin'   => false,
			// ),

			), $this->get_child_theme_scripts()
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'uw_register_default_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'uw_localize_default_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'uw_enqueue_default_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'uw_enqueue_admin_scripts' ) );
		add_action( 'customize_controls_init', array( $this, 'uw_customizer_preview' ) );

	}

	/**
	 * This function creates a customizer preview (??)
	 */
	function uw_customizer_preview() {
		wp_enqueue_script( 'uw-themecustomize', get_bloginfo( 'template_directory' ) . '/js/uw.themecustomizer.js', array( 'jquery', 'customize-controls' ), false, true );
	}

	/**
	 * This functions reverts the scripts to their default
	 * condition
	 */
	function uw_register_default_scripts() {
		wp_deregister_script( 'jquery' );

		foreach ( $this->SCRIPTS as $script ) {
			$script = (object) $script;

			wp_register_script(
				$script->id,
				$script->url,
				$script->deps,
				$script->version
			);

		}

	}

	/**
	 * This function localizes the default scripts
	 * with data for a javascript variable
	 */
	function uw_localize_default_scripts() {
		$uw_localization = array();
		foreach ( $this->SCRIPTS as $script ) {
			$script = (object) $script;
			if ( isset( $script->style_dir ) ) {
				wp_localize_script( $script->id, 'style_dir', $script->style_dir ); // error line.
			}
		}
	}

	/**
	 * This function registers and enqueues
	 * the default scripts
	 */
	function uw_enqueue_default_scripts() {
		foreach ( $this->SCRIPTS as $script ) {
			$script = (object) $script;

			if ( ! $script->admin ) {
				wp_enqueue_script( $script->id );
			}
		}
	}

	/**
	 * If user is logged in as an admin this will
	 * register and enqueue all scripts
	 */
	function uw_enqueue_admin_scripts() {
		if ( ! is_admin() ) {
			return;
		}

		foreach ( $this->SCRIPTS as $script ) {
			$script = (object) $script;

			if ( $script->admin ) {

				wp_register_script(
					$script->id,
					$script->url,
					$script->deps,
					$script->version
				);

				wp_enqueue_script( $script->id );

			}
		}

	}

	/**
	 * This function returns scripts unique
	 * to the child theme
	 */
	private function get_child_theme_scripts() {
		return is_array( $this->SCRIPTS ) ? $this->SCRIPTS : array();
	}

	/**
	 * This function returns true if dev user
	 * is logged in, otherwise false
	 */
	public function dev_script() {
		return is_user_logged_in() ? '.dev' : '';
	}

}
