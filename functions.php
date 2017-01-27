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

/**
 * Allow tags in excerpts
 */
 function isc_allowedtags() {
     // Add custom tags to this string
         return '<p>,<br>,<a>,<strong>,<em>,<hr>';
     }

 if ( ! function_exists( 'isc_custom_wp_trim_excerpt' ) ) :

     function isc_custom_wp_trim_excerpt($isc_excerpt) {
     global $post;
     $raw_excerpt = $isc_excerpt;
         if ( '' == $isc_excerpt ) {

             $isc_excerpt = get_the_content('');
             $isc_excerpt = strip_shortcodes( $isc_excerpt );
             $isc_excerpt = apply_filters('the_content', $isc_excerpt);
             $isc_excerpt = str_replace(']]>', ']]&gt;', $isc_excerpt);
             $isc_excerpt = strip_tags($isc_excerpt, isc_allowedtags()); /*IF you need to allow just certain tags. Delete if all tags are allowed */

             //Set the excerpt word count and only break after sentence is complete.
                 $excerpt_word_count = 55;
                 $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
                 $tokens = array();
                 $excerptOutput = '';
                 $count = 0;

                 // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                 preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $isc_excerpt, $tokens);

                 foreach ($tokens[0] as $token) {

                     if ($count >= $excerpt_word_count && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) {
                     // Limit reached, continue until , ; ? . or ! occur at the end
                         $excerptOutput .= trim($token);
                         break;
                     }

                     // Add words to complete sentence
                     $count++;

                     // Append what's left of the token
                     $excerptOutput .= $token;
                 }

             $isc_excerpt = trim(force_balance_tags($excerptOutput));

                 $excerpt_end = '';
                 $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

                 //$pos = strrpos($isc_excerpt, '</');
                 //if ($pos !== false)
                 // Inside last HTML tag
                 //$isc_excerpt = substr_replace($isc_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                 //else
                 // After the content
                 $isc_excerpt .= $excerpt_end; /*Add read more in new paragraph */

             return $isc_excerpt;

         }
         return apply_filters('isc_custom_wp_trim_excerpt', $isc_excerpt, $raw_excerpt);
     }

 endif;

 remove_filter('get_the_excerpt', 'wp_trim_excerpt');
 add_filter('get_the_excerpt', 'isc_custom_wp_trim_excerpt');
?>
