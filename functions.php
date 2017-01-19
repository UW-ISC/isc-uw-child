<?php
/**
 * Set up the child / parent relationship and customize the UW object.
 */
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
        // grabs all the h4s in the content
        build_page_navigation(get_the_ID());
        $headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
        $pages = '';

        // filters the content to add ids to the headers so that the menu will work
        add_filter( 'the_content', 'add_ids_to_header_tags_auto');

        if (!empty($headers)) {
          foreach ($headers as $slug=>$header) {
            $pages .= '<li class="nav-item"> <a class="nav-link" title="'.$header.'" href="#'.$slug.'">'.$header.'</a></li>';
          }
        }

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
 * Displays the child pages of the current page along with their excerpts
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

        // Echoing/displaying each child page along with their excerpt
        // and a list of "grandchildren" pages
        // (If we call this method on the category page it would display the...
        // 1) Article Page Title, 2) Article Page Excerpt 3) List of Article Sections under that Article Page)
        foreach ($children_pages as $article) {
            $page_url = get_permalink($article);
            $metadata = get_post_custom($article->ID);
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

if ( ! function_exists( 'get_uw_breadcrumbs' ) ) :
function get_uw_breadcrumbs()
{

  global $post;
  $blog_title = get_bloginfo('title');
  $html = "";
  if ($blog_title == "") {
    $html .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url('/') . '" title="Home"> Home </a><li>';
  } else {
    $html .= '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url('/') . '" title="' . get_bloginfo('title') . '">' . get_bloginfo('title') . '</a><li>';
  }

  if ( is_404() )
  {
      $html .=  '<li class="current"><span>Woof!</span>';
  } else

  if ( is_search() )
  {
      $html .=  '<li class="current"><span>Search results for ' . get_search_query() . '</span>';
  } else

  if ( is_author() )
  {
      $author = get_queried_object();
      $html .=  '<li class="current"><span> Author: '  . $author->display_name . '</span>';
  } else

  if ( get_queried_object_id() === (Int) get_option('page_for_posts')   ) {
      $html .=  '<li class="current"><span> '. get_the_title( get_queried_object_id() ) . ' </span>';
  }

  // If the current view is a post type other than page or attachment then the breadcrumbs will be taxonomies.
  if( is_category() || is_single() || is_post_type_archive() )
  {

    if ( is_post_type_archive() )
    {
      $posttype = get_post_type_object( get_post_type() );
      //$html .=  '<li class="current"><a href="'  . get_post_type_archive_link( $posttype->query_var ) .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
      $html .=  '<li class="current"><span>'. $posttype->labels->menu_name  . '</span>';
    }

    if ( is_category() )
    {
      $category = get_category( get_query_var( 'cat' ) );
      //$html .=  '<li class="current"><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
      $html .=  '<li class="current"><span>'. get_cat_name($category->term_id ) . '</span>';
    }

    if ( is_single() )
    {
      if ( has_category() )
      {
        $thecat = get_the_category( $post->ID  );
        $category = array_shift( $thecat ) ;
        $html .=  '<li><a href="'  . get_category_link( $category->term_id ) .'" title="'. get_cat_name( $category->term_id ).'">'. get_cat_name($category->term_id ) . '</a>';
      }
      if ( uw_is_custom_post_type() )
      {
        $posttype = get_post_type_object( get_post_type() );
        $archive_link = get_post_type_archive_link( $posttype->query_var );
        if (!empty($archive_link)) {
          $html .=  '<li><a href="'  . $archive_link .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
        }
        else if (!empty($posttype->rewrite['slug'])){
          $html .=  '<li><a href="'  . site_url('/' . $posttype->rewrite['slug'] . '/') .'" title="'. $posttype->labels->menu_name .'">'. $posttype->labels->menu_name  . '</a>';
        }
      }
      $html .=  '<li class="current"><span>'. get_the_title( $post->ID ) . '</span>';
    }
  }

  // If the current view is a page then the breadcrumbs will be parent pages.
  else if ( is_page() )
  {

    if ( ! is_home() || ! is_front_page() )
      $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
      $ancestors[] = $post->ID;

    if ( ! is_front_page() )
    {
      foreach ( array_filter( $ancestors ) as $index=>$ancestor )
      {
        $class      = $index+1 == count($ancestors) ? ' class="current" ' : '';
        $page       = get_post( $ancestor );
        $url        = get_permalink( $page->ID );
        $title_attr = esc_attr( $page->post_title );
        if (!empty($class)){
          $html .= "<li $class><span>{$page->post_title}</span></li>";
        }
        else {
          $html .= "<li><a href=\"$url\" title=\"{$title_attr}\">{$page->post_title}</a></li>";
        }
      }
    }

  }

  return "<nav class='uw-breadcrumbs' role='navigation' aria-label='breadcrumbs'><ul>$html</ul></nav>";
}

endif;

if ( ! function_exists('uw_breadcrumbs') ) :

  function uw_breadcrumbs()
  {
    echo get_uw_breadcrumbs();
  }

endif;

function build_page_navigation( $post_id ) {

    // Grab the post and post_content
    $page_data = get_post($post_id);
    $page_content = $page_data ? $page_data->post_content : '';

    $links = array();
    $results = '';
    $regex = '/<h4.*?>(.*?)<\/h4>/';

    if ( preg_match_all($regex, $page_content, $matches) ) {
        $results = $matches[1];
        // Build out links named array with slug and title
        foreach ($results as $heading) {
            // Sluggify the heading
            $slug = sanitize_title($heading);

            // Store it in $links for saving
            $links[$slug] = $heading;
        }
    } else {
        $results = '';
    }
    // saving this in the metadata of the post so that we can use this later on
    update_post_meta( $post_id, '_uwhr_page_anchor_links', $links );
}

function add_ids_to_header_tags_auto( $content ) {

  // _uwhr_page_anchor_links represents if a post contains these anchor links, so if there
  // are no links we don't want to bother with this method...
  $headers = get_post_meta( get_the_ID(), '_uwhr_page_anchor_links', true );
  if (empty($headers)) {
      return $content;
  }

  $pattern = '#(?P<full_tag><(?P<tag_name>h4)>(?P<tag_contents>[^<]*)</h4>)#i';
  if ( preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) {
      $find = array();
      $replace = array();
      $top = '';
      foreach( $matches as $match ) {
          $find[]    = $match['full_tag'];
          $id        = sanitize_title( $match['tag_contents'] );
          $id_attr   = sprintf( ' id="%s"', $id );
          $replace[] = sprintf( '%1$s<%2$s%3$s>%4$s</%2$s>', $top, $match['tag_name'], $id_attr, $match['tag_contents']);
          $top = '<p class="uwhr-toc-top-btn"><a href="#top">Return to top</a></p>';
      }
      $content = str_replace( $find, $replace, $content ) . '<p class="uwhr-toc-top-btn"><a href="#top">Return to top</a></p>';
  }
  return $content;
}
?>
