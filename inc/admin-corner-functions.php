<?php

 /**
  * This private function returns a ul of quicklinks. It should be called via
  * wrapper functions below.
  *
  * @author    Craig M. Stimmel <cstimmel@uw.edu>
  * @author    Charlon Palacay <charlon@uw.edu>
  * @copyright Copyright (c) 2016, University of Washington
  * @since     0.2.0
  */

if (! function_exists('output_quicklinks') ) :
    function output_quicklinks( $post_id, $field, $url_key, $text_key )
    {
        $quicklinks = array();
        $custom = get_post_custom($post_id); // gets custom meta of admin-corner
        if (array_key_exists($field, $custom) ) {
            $quicklinks = unserialize($custom[$field][0]);
        }
        if (isset($quicklinks) && !empty($quicklinks) ) {
            echo "<ul>";
            foreach ( $quicklinks as $link ) {
                $format = "<li><a href='%s'>%s</a></li>";
                echo sprintf($format, $link[$url_key], $link[$text_key]);
            }
            echo "</ul>";
        } else {
            echo "<p>No quicklinks found.</p>";
        }
    }
endif;

/* Wrapper function for 'Workday Support' on Admin's Corner */
if (! function_exists('isc_support_quicklinks') ) :
    function isc_support_quicklinks()
    {
        $post_id = 1594;
        $field = 'workday-support-links';
        $url_key = 'support-url';
        $text_key = 'support-text';
        output_quicklinks($post_id, $field, $url_key, $text_key);
    }
endif;

/* Wrapper function for 'Workday Resources' on Admin's Corner */
if (! function_exists('isc_resource_quicklinks') ) :
    function isc_resource_quicklinks()
    {
        $post_id = 1594;
        $field = 'workday-resource-links';
        $url_key = 'resource-url';
        $text_key = 'resource-text';
        output_quicklinks($post_id, $field, $url_key, $text_key);
    }
endif;
 ?>
