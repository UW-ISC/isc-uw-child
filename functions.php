<?php
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// Remove any templates from the UW Marketing theme that will not be used

function tfc_remove_page_templates( $templates ) {
    unset( $templates['templates/template-no-title.php'] );
    return $templates;
}

add_filter( 'theme_page_templates', 'tfc_remove_page_templates' );

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

?>
