<?php
//Footer Options
add_action('admin_menu', 'isc_custom_footer_fields');
add_action('admin_init', 'isc_build_footer_settings');

function isc_custom_footer_fields() {
    add_options_page('Footer Content', 'Footer Content', 'manage_options', "isc_footer_content", 'isc_build_options_page');
}

function isc_build_options_page() {
   ?>
   <div>
    <h2>Footer Content</h2>
    <p>Edit fields which appear within the footer</p>
    <form method="POST" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('isc_footer_fields'); ?>
        <?php do_settings_sections("isc_footer_content"); ?>
        <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form>
   </div>
   <?php
}?>
<?php

function isc_build_footer_settings() {
  register_setting('isc_footer_fields', 'isc_footer_fields', 'isc_validate_options');
  add_settings_section('main_section', 'Options', 'isc_cb', 'isc_footer_content');
  add_settings_field('footer_email', 'Email <br/><em style="font-weight: 300;">Example: user@uw.edu</em>', 'isc_display_email', 'isc_footer_content', 'main_section');
  add_settings_field('footer_phone', 'Phone <br/><em style="font-weight: 300;">Example: 999-999-9999</em>', 'isc_display_phone', 'isc_footer_content', 'main_section');
  add_settings_field('footer_location', 'Location Name <br/><em style="font-weight: 300;">Example: UW Tower</em> ', 'isc_display_location', 'isc_footer_content', 'main_section');
  add_settings_field('footer_map', 'Map URL <br/><em style="font-weight: 300;">A link to a map showing the location of the given name </em>', 'isc_display_map', 'isc_footer_content', 'main_section');
}

function isc_validate_options($isc_footer_fields) {
    return $isc_footer_fields;
}

function isc_cb() {
//empty callback, just needed for function argument
}

function isc_display_map() {
    $options = get_option('isc_footer_fields');
    log_to_console($options);
    $url_pattern = '(http|https|ftp):\/\/[a-zA-Z0-9_\-\.\+]+\.[a-zA-Z0-9]+([\/a-zA-z0-9_\-\.\+\?=%@,!:]*)?';
    $warning = 'Example: http://example.com/page';
    echo "<input name='isc_footer_fields[map]' pattern='$url_pattern' title='$warning' type='text' size='45' value='{$options['map']}' />";
}

function isc_display_location() {
    $options = get_option('isc_footer_fields');
    $url_pattern = '.*';
    $warning = 'Example: UW Tower';
    echo "<input name='isc_footer_fields[location]' pattern='$url_pattern' title='$warning' type='text' size='45' value='{$options['location']}' />";
}

function isc_display_email() {
    $options = get_option('isc_footer_fields');
    $email_pattern = '[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9_\.\-]+\.[a-zA-Z0-9]+)';
    $warning = 'Example: user@uw.edu';
    echo "<input name='isc_footer_fields[email]' pattern='$email_pattern' title='$warning'type='text' value='{$options['email']}' />";
}

function isc_display_phone() {
    $options = get_option('isc_footer_fields');
    $phone_pattern = '(\d{3}?-?\d{3}-?\d{4})';
    $warning = 'Example: 999-999-9999';
    echo "<input name='isc_footer_fields[phone]' pattern='$phone_pattern' title='$warning' type='text'  value='{$options['phone']}' />";
}
?>
