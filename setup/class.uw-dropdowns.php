<?php

/**
 * UW Dropdowns
 * This installs the default dropdowns for the UW Theme
 */

// TODO: remove unused functions!
class UW_Dropdowns
{

    const NAME              = 'Purple Bar';
    const LOCATION       = 'purple-bar';

    function __construct()
    {
        $this->menu_items = array();
        add_action('after_setup_theme', array( $this, 'register_purple_bar_menu'));
    }

    function register_purple_bar_menu()
    {
        register_nav_menu(self::LOCATION, __(self::NAME));
    }

}
