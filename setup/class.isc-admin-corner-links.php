<?php

/**
 * ISC Admin Corner links
 * This installs the front page quicklinks location.
 */

class ISC_AdminCornerLinks
{

    const NAME              = 'Admin Corner Links';
    const LOCATION       = 'admin-corner-links';

    function __construct()
    {
        $this->menu_items = array();
        add_action('after_setup_theme', array( $this, 'register_admin_corner_links'));
    }

    function register_admin_corner_links()
    {
        register_nav_menu(self::LOCATION, __(self::NAME));
    }

}
