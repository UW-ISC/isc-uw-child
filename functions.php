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
    unset($templates['templates/template-big-hero.php']);
    unset($templates['templates/template-no-hero.php']);
    unset($templates['templates/template-no-sidebar.php']);
    unset($templates['templates/template-small-hero.php']);
    return $templates;
}

add_filter('theme_page_templates', 'tfc_remove_page_templates');

/**
* Remove unwanted metaboxes from special pages.
**/
function remove_special_page_template_metabox()
{
    global $post;
    $specials = array('homepage', 'user-guides', 'admin-corner');
    if(isset($post) && $post->post_type == 'page' && in_array($post->post_name, $specials)) {
        // I guess its a hacky way!
        remove_meta_box('uwpageparentdiv', 'page', 'side');
        remove_meta_box('sec_rolediv', 'page', 'side');
        remove_meta_box('ug-topicdiv', 'page', 'side');
        remove_meta_box('md-tagsdiv', 'page', 'side');
    }
}
add_action('admin_head', 'remove_special_page_template_metabox');

/**
 * Rename Posts to News
 */
function isc_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
}
function isc_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}

add_action( 'admin_menu', 'isc_change_post_label' );
add_action( 'init', 'isc_change_post_object' );

/**
 * Developer function for logging to the browser console. Do not leave log statements lying around!
 * We might want to remove this when we're done with development. (Will only work if WP_DEBUG === true)
 */
function log_to_console($debug_output)
{
  if (defined('WP_DEBUG') && WP_DEBUG) {
      // only echo if WP_DEBUG exists and is True
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
}

//Footer Options
add_action('admin_menu', 'custom_footer_fields');

function custom_footer_fields() {
    add_submenu_page('options-general.php','Footer Content', 'Footer Content', 'administrator', __FILE__, 'build_options_page');
}

add_action('admin_init', 'reg_build_options');

function build_options_page() {
   ?>
   <div>
    <h2>Footer Content</h2>
    <p>Change ITConnect footer content here. Please <b>do not</b> enter any HTML in to the fields</p>
    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('footer_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
   </div>
   <?php
}

function reg_build_options() {
    register_setting('footer_options', 'footer_options', 'validate_setting');
    add_settings_section('main_section', 'Options', 'section_cb', __FILE__);
    add_settings_field('onlinea', 'Contact form (URL) <br /><em style="font-weight: 300;">Example: https://www.google.com/maps/</em>', 'set_online_map_url', __FILE__, 'main_section');
    add_settings_field('email', 'Email <br /><em style="font-weight: 300;">Example: user@uw.edu</em>', 'set_email', __FILE__, 'main_section');
    add_settings_field('phone', 'Phone <br /><em style="font-weight: 300;">Example: 999-999-9999', 'set_phone', __FILE__, 'main_section');
}

function validate_setting($footer_options) {
    return $footer_options;
}

function section_cb() {
//empty callback, just needed for function argument
}

function set_online_map_url() {
    $options = get_option('footer_options');
    $url_pattern = '(http|https|ftp)://[a-zA-Z0-9_\-\.\+]+\.[a-zA-Z0-9]+([/a-zA-z0-9_\-\.\+\?=%]*)?';
    $warning = 'Example: http://example.com/page';
    log_to_console($options);
    echo "<input name='footer_options[online]' pattern='$url_pattern' title='$warning' type='text' size='45' value='{$options['onlinea']}' />";
}

function set_email() {
    $options = get_option('footer_options');
    $email_pattern = '[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9_\.\-]+\.[a-zA-Z0-9]+)';
    $warning = 'Example: user@uw.edu';
    echo "<input name='footer_options[email]' pattern='$email_pattern' title='$warning'type='text' value='{$options['email']}' />";
}

function set_phone() {
    $options = get_option('footer_options');
    $phone_pattern = '(\d{3}?\-?\d{3}\-?\d{4})';
    $warning = 'Example: 999-999-9999';
    echo "<input name='footer_options[phone]' pattern='$phone_pattern' title='$warning' type='text'  value='{$options['phone']}' />";
}
//End Footer Options

?>
