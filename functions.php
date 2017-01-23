<?php

// functions to be used within templates
include get_stylesheet_directory() . '/includes/template_functions.php';
// breadcrumb functions
include get_stylesheet_directory() . '/includes/breadcrumbs.php';

function my_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

function my_theme_enqueue_scripts() {
    wp_enqueue_script( 'bootstrap-collapse', get_stylesheet_directory_uri() . '/assets/js/bootstrap-collapse.js' );
    //wp_enqueue_script( 'sticky', get_stylesheet_directory_uri() . '/assets/js/sticky.js' );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );
// Remove any templates from the UW Marketing theme that will not be used

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

// Remove any templates from the UW Marketing theme that will not be used
function tfc_remove_page_templates( $templates ) {
    unset( $templates['templates/template-no-title.php'] );
    return $templates;
}

add_filter( 'theme_page_templates', 'tfc_remove_page_templates' );
?>
