<?php
/**
 * Displays the child pages of the current page as well as presenting a
 * table of contents that links to each individual child page's content
 *
 * @author Kevin Zhao <zhaok24@uw.edu>
 * @author Abhishek Chauhan <abhi3@uw.edu>
 */

if ( ! function_exists( 'display_child_pages_with_toc' ) ) :
    function display_child_pages_with_toc() {
      // The following lines grab all the children pages of the current page
      $args = array(
        'parent' => get_the_ID(),
        'hierarchical' => 0,
        'sort_column' => 'menu_order',
        'sort_order' => 'asc'
      );
      $children_pages = get_pages($args);
      $toc = count($children_pages) > 0;
      $html = '';
      if ($toc) {
        // Fancy title of Table of Contents
        $html = '<div class="isc-toc" id="toc"><p class="h4 beefy gold">Table of Contents</p><span class="slant xs short gold"></span>';

        // Echoing each children page's title
        foreach ($children_pages as $child) {
            $html .= '<div><a href="#'.$child->post_name.'">';
            $html .= $child->post_title;
            $html .= '</a></div>';
        }
        // Ending the Table of Contents
        $html .= '</div>';
      }
      foreach ($children_pages as $child) {
          // Displaying the title of a child page
          $url = get_permalink($child);
          $html .= '<h4 class="title" id="'.$child->post_name.'"> <a href="'.$url.'">';
          $html .= $child->post_title;
          $html .= '</a> </h4>';
          // Displaying the date the page was last updated
          $date_updated = new DateTime($child->post_modified_gmt);
          $html .= '<div id="date_updated"> Updated: ';
          $html .= date_format($date_updated, 'm.d.y');
          $html .= '</div>';
          // Displaying the tags of a child page
          $posttags = get_the_tags($child->ID);
          if ($posttags) {
            $html .= '<div id="tags"> Tags: ';
            for ($x = 0; $x < count($posttags) - 1; $x++) {
              $tag =  $posttags[$x];
              $link = get_tag_link($tag);
              $html .= '<a id="tag" href='.$link.'>'.$tag->name.', </a>';
            }
            $finaltag = $posttags[count($posttags) - 1];
            $html .= '<a id="tag" href='.get_tag_link($finaltag).'>'.$finaltag->name.' </a>';
            $html .= '<br>';
          }
          // Displaying the content
          $html .= $child->post_content;
          $html .= '<br>';
          if ($toc) {
            $html .= '<p class="isc-toc-top-btn"><a href="#toc">Return to top</a></p>';
          }
      }
      echo $html;
    }
endif;

/**
 * User Guide Menu
 *
 * Lists all User Guides in the sidebar and also builds an
 * in-page navigation.
 *
 * @author Abhishek Chauhan <abhi3@uw.edu>
 */
 if ( ! function_exists( 'user_guide_menu' ) ) :
    function user_guide_menu( $return = false ) {

        // $exclude_ids = get_menu_excluded_ids();
        // grabs all the headers in the content
        $headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
        $pages = '';
        $subarray = array();
        $temp_storage = array();
        $headarray = array();

        // filters the content to add ids to the headers so that the menu will work
        add_filter( 'the_content', 'add_ids_to_header_tags_auto');

        // parse through all the headers and sift/sort headers/subheaders
        if (!empty($headers)) {
         foreach ($headers as $slug=>$header) {
           $content = substr($header, 1, strlen($header));
           $heading_type = substr($header, 0, 1);
           if ($heading_type == '3') {
             // it is a header!
             array_push($subarray, $temp_storage);
             // reset the temp_storage array to gather new subheaders under the new header
             $temp_storage = array();
             // add the header to the headarray
             array_push($headarray, array($slug, $content));
           } else {
             // it is a subheader, store it until we see the next header... or the content ends
             array_push($temp_storage, array($slug, $content));
           }
         }
       }

       // pushing on the subheaders under the last header
       array_push($subarray, $temp_storage);
       // ignoring all the subheaders that occured before the first header
       array_shift($subarray);

       // iterate through the headers
       for ($i = 0; $i < sizeof($headarray); $i++){
          // the subheaders (if any) under the current header
          $subheaders = $subarray[$i];
          // slug of the current header
          $slug = $headarray[$i][0];
          // title of the current header
          $title = $headarray[$i][1];
          if (sizeof($subheaders) > 0) {
            // means there are subheaders under the current header
            $pages .= '<li class="nav-item has-children"> <button class="nav-link children-toggle collapsed" data-toggle="collapse" data-target="#'.$slug.'" aria-controls="#'.$slug.'" aria-expanded="false">'.$title.'<i class="fa fa-2x"></i></button>';
            $pages .= '<ul class="children depth-1 collapse" id="'.$slug.'" aria-expanded="false" style="height: 0px;">';
            // iterate through the subheaders under the current header
            for ($j = 0; $j < sizeof($subheaders); $j++) {
              // slug of the current subheader
              $subslug = $subheaders[$j][0];
              // title of the current subtitle
              $subtitle = $subheaders[$j][1];
              // Append the subheaders
              $pages .= '<li class="nav-item"> <a class="nav-link" title="'.$subtitle.'" href="#'.$subslug.'">'.$subtitle.'</a></li>';
            }
            $pages .= "</ul></li>";
          } else {
            // if there are no subheaders under the current header, just put the header link
            $pages .= '<li class="nav-item"> <a class="nav-link" title="'.$title.'" href="#'.$slug.'">'.$title.'</a></li>';
          }
        }

        // add the title of the table of contents (first element)
        $first_li = $return ? '' : '<li class="nav-item"><a class="nav-link first" href="#top" title="Permanent Link to ' . get_bloginfo('name') . '"> Table of Contents </a></li>';

        $html = sprintf( '<ul>%s%s</ul>',
            $first_li,
            $pages
        );

        if ( empty($pages) ) {
            if ( $return ) {
                return false;
            } else {
                echo '';
            }
        } else {
            $menu = '<nav class="uw-accordion-menu float-menu" id="pageNav toc" aria-label="Site Menu" tabindex="-1" >' . $html . '</nav>';
            if ( $return ) {
                return $menu;
            } else {
                echo $menu;
            }
        }
    }
endif;

/**
 * Displays the child pages of the current page along with their body contents
 *
 * @author Kevin Zhao <zhaok24@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.2.0
 *
 * @global $post
 */

if ( ! function_exists( 'display_child_pages' ) ) :
    function display_child_pages() {
        // The following lines grab all the children pages of the current page
        $args = array(
          'parent' => get_the_ID(),
          'hierarchical' => 0,
          'sort_column' => 'menu_order',
          'sort_order' => 'asc'
        );
        $children_pages = get_pages($args);
        $html = "";
        // Echoing/displaying each child page along with their body content
        foreach ($children_pages as $article) {
            $page_url = get_permalink($article);
            // the content of the child
            $body = $article->post_content;
            $html .= '<div class="isc-content-block">';
            $html .= '<h3 class="title"><a href="'.$page_url.'">';
            $html .= $article->post_title;
            $html .= '</a></h3>';

            if ($body != '') {
              // displaying the body of the child content
              $html .= '<p> ' . $body . ' </p>';
            }
            $html .= '<a class="uw-btn btn-sm" href="'.$page_url.'">Read More</a>';
            $html .= '</div>';
        }
        echo $html;
    }
endif;

function build_page_navigation( $post_id ) {
        // Grab the post and post_content
        $page_data = get_post($post_id);
        $page_content = $page_data ? $page_data->post_content : '';

        $links = array();
        $results = '';
        // the header types we want to look for (3:header and 4:subheader)
        $options = "([34])";
				$regex = '/<h'. $options . '.*?>(.*?)<\/h\1>/';

        if ( preg_match_all($regex, $page_content, $matches) ) {
            $results = $matches[2];
						$results2 = $matches[0];
						for ($i = 0; $i < sizeof($results); $i++) {
							$header_type = substr($results2[$i], 2, 1);
							$heading = $results[$i];
							$slug = sanitize_title($heading);
							$links[$slug] = $header_type . $heading;
						}
        } else {
            $results = '';
        }

        // Slugs are added to the h3s and h4s in a filter on the_content function
        update_post_meta( $post_id, '_uwhr_page_anchor_links', $links );
}

function add_ids_to_header_tags_auto( $content) {
  // making sure the headers have been gathered first
  build_page_navigation(get_the_ID());

  // _uwhr_page_anchor_links represents if a post contains these anchor links, so if there
  // are no links we don't want to bother with this method...
  $headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
  if (empty($headers)) {
      return $content;
  }
  // the header types we want to look for (h3 and h4)
  $look_for = "(h3|h4)";
  $pattern = '#(?P<full_tag><(?P<tag_name>'. $look_for .')>(?P<tag_contents>[^<]*)</'. $look_for .'>)#i';
  if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
      $find = array();
      $replace = array();
      $top = '';
      foreach( $matches as $match ) {
          $find[]    = $match['full_tag'];
          $id        = sanitize_title( $match['tag_contents'] );
          $id_attr   = sprintf( ' id="%s"', $id );
          $replace[] = sprintf( '%1$s<%2$s%3$s>%4$s</%2$s>', $top, $match['tag_name'], $id_attr, $match['tag_contents']);
      }
      $content = str_replace( $find, $replace, $content );
  }
  return $content;
}

/**
 * Displays the quicklinks by querying the metadata of
 * the homepage
 *
 * @author Mason Gionet <mgionet@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.2.0
 *
 * @global $post
 */

 if ( ! function_exists( 'get_quicklinks' ) ) :
     function get_quicklinks() {
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
          $html = "No quicklinks found!";
        }
      }
      echo $html;
    }
endif;

/**
 * Allow tags in excerpts
 *
 * @author Ethan Turner <ezturner@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.2.0
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
