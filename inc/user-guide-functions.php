<?php

class user_guide
{
    public $name;
    public $url;
    public $topics;
    public $roles;
    public $last_updated;

    function __construct($name, $url, $topics, $roles, $last_updated) 
    {
        $this->name = $name;
        $this->url = $url;
        $this->topics = $topics;
        $this->roles = $roles;
        $this->last_updated = $last_updated;
    }
}

if (! function_exists('sanitize_array') ) :
    function sanitize_array($elements) 
    {
        $sanitized = array();
        foreach($elements as $el) {
            array_push($sanitized, sanitize_title($el));
        }
        return $sanitized;
    }
endif;
// simply gets the child pages of the current page
// when called on the user guide library page
// will return all the user guides
if (! function_exists('get_user_guides') ) :
    function get_user_guides() 
    {
          $args = array(
            'parent' => get_the_ID(),
            'hierarchical' => 0,
            'sort_column' => 'menu_order',
            'sort_order' => 'asc'
          );
          $children_pages = get_pages($args);
          $user_guides = array();
        foreach ($children_pages as $child) {
            //log_to_console(get_object_taxonomies($child));
            $security_query = wp_get_post_terms($child->ID, 'sec_role');
            $sec_roles = array();
            foreach($security_query as $role) {
                array_push($sec_roles, $role->name);
            }
            //log_to_console($security_role);

            $topic_query = wp_get_post_terms($child->ID, 'ug-topic');
            $topics = array();
            foreach($topic_query as $topic) {
                array_push($topics, $topic->name);
            }
            $url = get_permalink($child);
            $date_updated = new DateTime($child->post_modified_gmt);
            $temp_user_guide = new user_guide($child->post_title, $url, $topics, $sec_roles, $date_updated);

            array_push($user_guides, $temp_user_guide);
        }
          return $user_guides;
    }
endif;


if (! function_exists('user_guide_table') ) :
    function user_guide_table($user_guides) 
    {

            $html = '';
        foreach ($user_guides as $guide) {
            $sanitized_topics = sanitize_array($guide->topics);
            $sanitized_roles = sanitize_array($guide->roles);
            $data_roles = empty($sanitized_roles) ? "" : 'data-roles="' . implode(" ", $sanitized_roles) . '"';
            $data_topics = empty($sanitized_topics) ? "" : 'data-topics="' . implode(" ", $sanitized_topics) . '"';
            $topics = count($guide->topics) == 0 ? ("---") : (implode(", ", $guide->topics));
            $roles = count($guide->roles) == 0 ? ("---") : (implode(", ", $guide->roles));

            $html .= '<tr id="user-guide" ' . $data_roles . $data_topics . '>';
            $html .= '<td><a href="'. $guide->url .'">';
            $html .= $guide->name;
            $html .= '</a></td>';
            $html .= '<td>' . $topics . '</td>';
            $html .= '<td>' . $roles . '</td>';
            $html .= '<td>' . date_format($guide->last_updated, 'm.d.y') . '</td>';
            $html .= '</tr>';
        }
            echo $html;
    }
endif;


if (! function_exists('get_all_topics') ) :
    function get_all_topics($user_guides) 
    {
        $topics = array();
        foreach($user_guides as $guide) {
            foreach($guide->topics as $topic) {
                array_push($topics, $topic);
            }
        }
        return array_unique($topics);
    }
endif;

if (! function_exists('get_all_roles') ) :
    function get_all_roles($user_guides) 
    {
        $topics = array();
        foreach($user_guides as $guide) {
            foreach($guide->roles as $role) {
                array_push($topics, $role);
            }
        }
        return array_unique($topics);
    }
endif;
