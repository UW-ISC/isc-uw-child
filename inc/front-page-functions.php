<?php

/**
 * Displays the quicklinks by querying the metadata of
 * the homepage
 *
 * @author    Mason Gionet <mgionet@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since     0.2.0
 *
 * @global $post
 */

if (! function_exists('isc_front_get_quicklinks') ) :
    function isc_front_get_quicklinks()
    {
        $custom = get_post_meta(450);
        $html = "";
        if (array_key_exists("isc-hero-quicklinks", $custom)) {
            $string = $custom["isc-hero-quicklinks"];
            $result = implode($string);
            $data = unserialize($result);
            if (sizeOf($data) < 3 && sizeOf($data) > 0) {
                for ($i = 0; $i < sizeOf($data); $i++) {
                    $html .= '<li><a class="btn-sm uw-btn" href="' . $data[$i]["isc-hero-quicklink-url"] . '">'. $data[$i]["isc-hero-quicklink-text"] . '</a></li>';
                }
            } else if (sizeOf($data) >= 3) {
                for ($i = 0; $i < 3; $i++) {
                    $html .= '<li><a class="btn-sm uw-btn" href="' .  $data[$i]["isc-hero-quicklink-url"] . '">' . $data[$i]["isc-hero-quicklink-text"] . '</a></li>';
                }
            } else {
                $html = "No quicklinks found.";
            }
        }
        echo $html;
    }
endif;

?>
