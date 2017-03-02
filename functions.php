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
function isc_remove_page_templates( $templates )
{
    unset($templates['templates/template-no-title.php']);
    unset($templates['templates/template-big-hero.php']);
    unset($templates['templates/template-no-hero.php']);
    unset($templates['templates/template-no-sidebar.php']);
    unset($templates['templates/template-small-hero.php']);
    return $templates;
}

add_filter('theme_page_templates', 'isc_remove_page_templates');

/**
* Remove unwanted metaboxes from special pages.
**/
function isc_remove_special_page_template_metabox()
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
add_action('admin_head', 'isc_remove_special_page_template_metabox');

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
add_action('admin_init', 'build_footer_settings');

function custom_footer_fields() {
    add_options_page('Footer Content', 'Footer Content', 'manage_options', "footer_content", 'build_options_page');
}

function build_options_page() {
   ?>
   <div>
    <h2>Footer Content</h2>
    <p>Edit fields which appear within the footer</p>
    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('footer_fields'); ?>
        <?php do_settings_sections("footer_content"); ?>
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
   </div>
   <?php
}?>
<?php

function build_footer_settings() {
  delete_option('footer_options');
  register_setting('footer_fields', 'footer_fields', 'validate_options');
  add_settings_section('main_section', 'Options', 'section_cb', 'footer_content');
  add_settings_field('footer_email', 'Email <br/><em style="font-weight: 300;">Example: user@uw.edu</em>', 'display_email', 'footer_content', 'main_section');
  add_settings_field('footer_phone', 'Phone <br/><em style="font-weight: 300;">Example: 999-999-9999</em>', 'display_phone', 'footer_content', 'main_section');
  add_settings_field('footer_location', 'Location Name <br/><em style="font-weight: 300;">Example: UW Tower</em> ', 'display_location', 'footer_content', 'main_section');
  add_settings_field('footer_map', 'Map URL <br/><em style="font-weight: 300;">A link to a map showing the location of the given name </em>', 'display_map', 'footer_content', 'main_section');
}

function validate_options($footer_fields) {
    return $footer_fields;
}

function section_cb() {
//empty callback, just needed for function argument
}

function display_map() {
    $options = get_option('footer_fields');
    $url_pattern = '(http|https|ftp):\/\/[a-zA-Z0-9_\-\.\+]+\.[a-zA-Z0-9]+([\/a-zA-z0-9_\-\.\+\?\/=%@\/\,]*)?';
    $warning = 'Example: http://example.com/page';
    log_to_console(wp_load_alloptions());
    echo "<input name='footer_fields[map]' pattern='$url_pattern' title='$warning' type='text' size='45' value='{$options['map']}' />";
}

function display_location() {
    $options = get_option('footer_fields');
    $url_pattern = '.*';
    $warning = 'Example: UW Tower';
    log_to_console($options);
    echo "<input name='footer_fields[location]' pattern='$url_pattern' title='$warning' type='text' size='45' value='{$options['location']}' />";
}

function display_email() {
    $options = get_option('footer_fields');
    $email_pattern = '[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9_\.\-]+\.[a-zA-Z0-9]+)';
    $warning = 'Example: user@uw.edu';
    log_to_console(wp_load_alloptions());

    echo "<input name='footer_fields[email]' pattern='$email_pattern' title='$warning'type='text' value='{$options['email']}' />";
}

function display_phone() {
    $options = get_option('footer_fields');
    $phone_pattern = '(\d{3}?-?\d{3}-?\d{4})';
    $warning = 'Example: 999-999-9999';
    echo "<input name='footer_fields[phone]' pattern='$phone_pattern' title='$warning' type='text'  value='{$options['phone']}' />";
}
?>
