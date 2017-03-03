<?php
/**
 * UW_Users
 *
 * Adds Affiliations, Office, Twitter, and Facebook to user profiles
 * Removes yim, aim and jabber from user profiles
 *
 * @package isc-uw-child
 */

/**
 * UW_Users
 */
class UW_Users {


	/**
	 * Constructor method
	 */
	function __construct() {
		add_filter( 'user_contactmethods', array( $this, 'additional_contact_fields' ), 10, 1 );
		$role = get_role( 'editor' );
		$role->add_cap( 'edit_theme_options' );
		add_action( 'admin_menu', array( $this, 'custom_admin_menu' ) );

	}

	/**
	 * Modify the contact fields in user's profiles.
	 * This comes from the parent theme.
	 *
	 * @param array $contactmethods an array of field labels.
	 */
	function additional_contact_fields( $contactmethods ) {
		// Add Twitter, Facebook and Affiliation.
		$contactmethods['affiliation'] = 'Affiliation';
		$contactmethods['phone'] = 'Phone Number';
		$contactmethods['office'] = 'Office';
		$contactmethods['twitter'] = 'Twitter';
		$contactmethods['facebook'] = 'Facebook';
		unset( $contactmethods['yim'] );
		unset( $contactmethods['aim'] );
		unset( $contactmethods['jabber'] );
		return $contactmethods;
	}

	/**
	 * Customise what logged in editors see in wp-admin.
	 * This overrides custom_admin_menu in the parent theme.
	 */
	function custom_admin_menu() {
		$user = new WP_User( get_current_user_id() );
		if ( ! empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role ) {
				$role = $role;
			}
		}

		if ( isset( $role ) && 'editor' === $role ) {
			 // if the user has an editor role.
			 remove_submenu_page( 'themes.php', 'themes.php' );
			 // disable WCK on the menu.
			 remove_menu_page( 'wck-page' );
			 // removing the custom fields metabox that appears when editing a page.
			 remove_meta_box( 'postcustom', 'page', 'normal' );
			 remove_submenu_page( 'themes.php', 'nav-menus.php' );
			 global $submenu;
			unset( $submenu['themes.php'][6] );
			unset( $submenu['themes.php'][15] );
		}
	}

}
