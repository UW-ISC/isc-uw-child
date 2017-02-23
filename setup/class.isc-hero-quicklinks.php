<?php

/**
 * ISC Hero Quicklinks
 * This installs the front page quicklinks location.
 */

class ISC_HeroQuicklinks
{

    const NAME              = 'Hero Quick Links';
    const LOCATION       = 'hero-quicklinks';

    function __construct()
    {
        $this->menu_items = array();
        add_action('after_setup_theme', array( $this, 'register_hero_quicklinks'));
    }

    function register_hero_quicklinks()
    {
        register_nav_menu(self::LOCATION, __(self::NAME));
    }

}
