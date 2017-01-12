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
 * Displays the child pages of the current page along with their excerpts
 *
 * @author Kevin Zhao <zhaok24@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.2.0
 * @package UWHR
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

        // Echoing/displaying each child page along with their excerpt
        // and a list of "grandchildren" pages
        // (If we call this method on the category page it would display the...
        // 1) Article Page Title, 2) Article Page Excerpt 3) List of Article Sections under that Article Page)
        foreach ($children_pages as $article) {
            $page_url = get_permalink($article);
            $metadata = get_post_meta($article->ID);
            $summary = '';
            if (array_key_exists('summary-content', $metadata)) {
              $summary = $metadata['summary-content'][0];
            }
            echo '<div>';
            echo '<h4 class="title"> <a href="'.$page_url.'">';
            echo $article->post_title;
            echo '</a></h4>';

            if ($summary != '') {
              echo '<p>';
              echo $summary;
              echo '</p>';
            }

            // grabbing the "grandchildren" pages
            $args2 = array(
              'parent' => $article->ID,
              'hierarchical' => 0,
              'sort_column' => 'menu_order',
              'sort_order' => 'asc'
            );
            $article_sections = get_pages($args2);
            // displaying them
            foreach($article_sections as $section) {
              $section_url = get_permalink($section);
              echo '<p><a href="'.$section_url.'">';
              echo $section->post_title;
              echo '</a></p>';
            }
            echo '</div>';
        }
    }
endif;
?>
