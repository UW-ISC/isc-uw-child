<?php

/**
 * Set up the child / parent relationship and customize the UW object.
 */
if (!function_exists('setup_uw_object')) {
    function setup_uw_object() 
    {
        include get_stylesheet_directory() . '/setup/class.uw.php';
        $UW = new UW();
        do_action('extend_uw_object', $UW);
        return $UW;
    }
}

/**
 * Remove any templates from the UW Marketing theme that will not be used
 **/
function tfc_remove_page_templates( $templates ) 
{
    unset($templates['templates/template-no-title.php']);
    return $templates;
}

add_filter('theme_page_templates', 'tfc_remove_page_templates');


/**
 * Developer function for logging to the browser console. Do not leave log statements lying around!
 * We might want to remove this when we're done with development.
 */
function log_to_console($debug_output) 
{
    $cleaned_string = '';
    if (!is_string($debug_output)) {
        $debug_output = print_r($debug_output, true);
    }
    $str_len = strlen($debug_output);
    for($i = 0; $i < $str_len; $i++) {
        $cleaned_string .= '\\x' . sprintf('%02x', ord(substr($debug_output, $i, 1)));
    }
    $javascript_ouput = "<script>console.log('Debug Info: " .$cleaned_string. "');</script>";
    echo $javascript_ouput;
}
?>
