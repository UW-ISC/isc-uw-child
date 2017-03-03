<?php
/**
 * UW
 *
 * This is the UW object that contains all the classes for our back-end functionality
 * All classes should be accessible by UW::ClassName
 *
 * @package isc-uw-child
 */

/**
 * UW
 */
class UW {


	/**
	 * Constructor method
	 */
	function __construct() {
		$this->includes();
		$this->initialize();
	}

	/**
	 * Defines all the classes to be included, and whether to get them from the
	 * parent theme or the child.
	 * This overrides a method in the parent theme.
	 */
	private function includes() {
		$parent = get_template_directory() . '/setup/';
		$child  = get_stylesheet_directory() . '/setup/';
		include_once $parent . 'class.install.php';
		include_once $child . 'class.uw-scripts.php';
		include_once $child . 'class.uw-styles.php';
		include_once $child . 'class.uw-dropdowns.php';
		include_once $parent . 'class.images.php';
		include_once $parent . 'class.squish_bugs.php';
		include_once $parent . 'class.filters.php';
		include_once $parent . 'class.uw-oembeds.php';
		include_once $parent . 'class.googleapps.php';
		include_once $parent . 'class.mimes.php';
		include_once $child . 'class.users.php';
		// no initialization needed because it extends a WP class.
		include_once $parent . 'class.dropdowns_walker.php';
		// no initialization needed unless a child theme makes one.
		include_once $parent . 'class.uw-basic-custom-post.php';
		// sidebar menu will initialize for us.
		include_once $parent . 'class.uw-sidebar-menu-walker.php';
		include_once $parent . 'class.uw-iframes.php';
		include_once $parent . 'class.uw-shortcodes.php';
		include_once $parent . 'class.uw-media-credit.php';
		include_once $parent . 'class.uw-media-caption.php';
		include_once $parent . 'class.uw-replace-media.php';
		include_once $parent . 'class.uw-tinymce.php';
		// require_once($parent . 'class.uw-documentation-dashboard-widget.php' );
		include_once $parent . 'class.uw-enclosure.php';
		include_once $parent . 'class.uw-carousel.php';
		include_once $parent . 'class.uw-settings.php';
		include_once $child . 'class.uw-page-attributes-meta-box.php';
		include_once $child . 'class.isc-admin-corner-links.php';
		include_once $child . 'class.isc-footer-links.php';
		include_once $child . 'class.isc-hero-quicklinks.php';
		include_once $child . 'class.isc-white-bar-links.php';

		include_once get_stylesheet_directory() . '/inc/child-template-functions.php';
		include_once get_stylesheet_directory() . '/inc/user-guide-functions.php';
		include_once get_stylesheet_directory() . '/inc/front-page-functions.php';
		include_once get_stylesheet_directory() . '/inc/admin-corner-functions.php';
		include_once get_stylesheet_directory() . '/inc/footer-fields.php';
		include_once get_stylesheet_directory() . '/inc/breadcrumbs.php';
		include_once get_template_directory() . '/inc/template-functions.php';
		include_once get_template_directory() . '/docs/class.uw-documentation.php';

		foreach ( glob( get_template_directory() . '/widgets/*.php' ) as $filename ) {
			include $filename;
		}
	}

	/**
	 * Initializes the theme.
	 */
	private function initialize() {
		$this->Install           = new UW_Install_Theme;
		$this->Scripts           = new UW_Scripts;
		$this->Styles            = new UW_Styles;
		$this->Images            = new UW_Images;
		$this->SquishBugs        = new UW_SquishBugs;
		$this->Filters           = new UW_Filters;
		$this->OEmbeds           = new UW_OEmbeds;
		$this->Mimes             = new UW_Mimes;
		$this->Users             = new UW_Users;
		$this->SidebarMenuWalker = new UW_Sidebar_Menu_Walker;
		$this->Dropdowns         = new UW_Dropdowns;
		$this->Shortcodes        = new UW_Shortcodes;
		$this->MediaCredit       = new UW_Media_Credit;
		$this->MediaCaption      = new UW_Media_Caption;
		$this->ReplaceMedia      = new UW_Replace_Media;
		$this->TinyMCE           = new UW_TinyMCE;
		// $this->Documentation     = new UW_Documentation_Dashboard_Widget;
		$this->IFrames           = new UW_Iframes;
		$this->GoogleApps        = new UW_GoogleApps;
		$this->Enclosure         = new UW_Enclosure;
		$this->Carousel          = new UW_Carousel;
		$this->Settings          = new UW_Settings;
		$this->WhiteBarLinks     = new ISC_WhiteBarLinks;
		$this->FooterLinks       = new ISC_FooterLinks;
		$this->HeroQuickLinks    = new ISC_HeroQuicklinks;
		$this->AdminCornerLinks  = new ISC_AdminCornerlinks;

	}
}
