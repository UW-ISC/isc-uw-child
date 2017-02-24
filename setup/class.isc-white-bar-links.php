<?php

/**
 * ISC WhiteBarLinks
 * This installs the white bar menu location.
 */

// TODO: remove unused functions!
class ISC_WhiteBarLinks
{

    const NAME              = 'White Bar Links';
    const LOCATION       = 'white-bar-links';

    function __construct()
    {
        $this->menu_items = array();
        add_action('after_setup_theme', array( $this, 'register_white_bar_links'));
    }

    function register_white_bar_links()
    {
        register_nav_menu(self::LOCATION, __(self::NAME));
    }

}
