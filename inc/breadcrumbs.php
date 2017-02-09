<?php
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
      log_to_console("hi");
      log_to_console($post );
      $html .=  '<li class="current"><span>EVENTS</span>';
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
        $category_name = get_cat_name( $category->term_id );
        if ( $category_name == 'Uncategorized' )
        {
            $category_name = 'News';
            $category_link = get_site_url() . '/news/';
        }
        $html .=  '<li><a href="'  . $category_link .'" title="'. $category_name .'">'. $category_name . '</a>';
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

// Check if page is direct child
function is_child( $page_id ) {
	global $post;
	if( is_page() && ($post->post_parent != '') ) {
		return true;
	} else {
		return false;
	}
}

// Breadcrumb Logic
function tribe_breadcrumbs() {
	global $post;

	$separator = " &raquo; ";

	echo "<nav class='uw-breadcrumbs' role='navigation' aria-label='breadcrumbs'><ul>";
	echo '<li' . (is_front_page() ? ' class="current"' : '') . '><a href="' . home_url('/') . '" title="Home"> Home </a></li>';

	if( tribe_is_month() && !is_tax() ) { // The Main Calendar Page
		echo $separator;
		echo 'The Events Calendar';
	} elseif( tribe_is_month() && is_tax() ) { // Calendar Category Pages
		global $wp_query;
		$term_slug = $wp_query->query_vars['tribe_events_cat'];
		$term = get_term_by('slug', $term_slug, 'tribe_events_cat');
		get_term( $term_id, 'tribe_events_cat' );
		$name = $term->name;
		echo $separator;
		echo '<a href="'.tribe_get_events_link().'">Events</a>';
		echo $separator;
		echo $name;
	} elseif( tribe_is_event() && !tribe_is_day() && !is_single() ) { // The Main Events List
		echo $separator;
		echo 'Events List';
	} elseif( tribe_is_event() && is_single() ) { // Single Events
		echo '<li> <a href="'.tribe_get_events_link().'">Events</a> </li>';
		echo '<li class="current"> <a>' . get_the_title() . '</a> </li>';
	} elseif( tribe_is_day() ) { // Single Event Days
		global $wp_query;
		echo $separator;
		echo '<a href="'.tribe_get_events_link().'">Events</a>';
		echo $separator;
		echo 'Events on: ' . date('F j, Y', strtotime( $wp_query->query_vars['eventDate']) );
	} elseif( tribe_is_venue() ) { // Single Venues
		echo $separator;
		echo '<a href="'.tribe_get_events_link().'">Events</a>';
		echo $separator;
		the_title();
	} elseif ( is_category() || is_single() ) {
		echo $separator;
		the_category(' &bull; ');

		if ( is_single() ) {
			echo ' '.$separator.' ';
			the_title();
		}
	} elseif ( is_page() ) {
		if( is_child(get_the_ID()) ) {
			echo $separator;
			echo '<a href="' . get_permalink( $post->post_parent ) . '">' . get_the_title( $post->post_parent ) . '</a>';
			echo $separator;
			echo the_title();
		} else {
			echo $separator;
			echo the_title();
		}
	} elseif (is_search()) {
		echo $separator.'Search Results for... ';
		echo '"<em>';
		echo the_search_query();
		echo '</em>"';
	} else {
    echo '<li class="current"> <a> Events </a> </li>';
  }

	echo '</ul></nav>';
}
