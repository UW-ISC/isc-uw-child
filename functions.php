<?php

/**
 * Set up the child / parent relationship and customize the UW object.
 */
if (!function_exists('setup_uw_object')){
    function setup_uw_object() {
        require( get_stylesheet_directory() . '/setup/class.uw.php' );
        $UW = new UW();
        do_action('extend_uw_object', $UW);
        return $UW;
    }
}

/**
 * Remove any templates from the UW Marketing theme that will not be used
 **/
function tfc_remove_page_templates( $templates ) {
    unset( $templates['templates/template-no-title.php'] );
    return $templates;
}

add_filter( 'theme_page_templates', 'tfc_remove_page_templates' );

add_action( 'wp_enqueue_scripts', 'add_isc_js' );
function add_is_js(){
  wp_enqueue_script('isc-scripts', get_stylesheet_directory_uri() .'/assets/js/isc.js', array('jquery'), null,  true);
}

?>
