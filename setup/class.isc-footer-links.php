<?php

/**
 * ISC FooterLinks
 * This installs the footer menu location.
 */

// TODO: remove unused functions!
class ISC_FooterLinks
{

    const NAME              = 'Footer Links';
    const LOCATION       = 'footer-links';

    function __construct()
    {
        $this->menu_items = array();
        add_action('after_setup_theme', array( $this, 'register_footer_links'));
    }

    function register_footer_links()
    {
        register_nav_menu(self::LOCATION, __(self::NAME));
    }

}
