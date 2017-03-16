<?php
/**
 * UW_Page_Attributes_Meta_Box
 *
 * The UW_Page_Attributes_Meta_Box class configures the metaboxes on wp-admin
 * adding in custom meta boxes and removing unneeded boxes.
 *
 * @package isc-uw-child
 */

/**
 * UW_Page_Attributes_Meta_Box
 */
class UW_Page_Attributes_Meta_Box {


	const ID = 'pageparentdiv';
	const TITLE = 'Page Attributes';
	const POSTTYPE = 'page';
	const POSITION = 'side';
	const PRIORITY = 'core';

	/**
	 * Configures the metaboxes for the theme
	 */
	function __construct() {
		$this->HIDDEN = array( 'No Sidebar' );
		add_action( 'add_meta_boxes', array( $this, 'replace_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_postdata' ) );
		add_action( 'admin_head', array( $this, 'custom_style' ) );

	}

	/**
	 * Denotes meta boxes to remove from wp_admin as well as adding a new meta box
	 */
	function replace_meta_box() {
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		remove_meta_box( 'postcustom', 'post', 'normal' ); // wck custom fields editor meta box
		remove_meta_box( 'formatdiv', 'post', 'side' ); // format meta box
		remove_meta_box( 'categorydiv', 'post', 'side' ); // categories meta box
		remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' ); // tags meta box
		remove_meta_box( 'postimagediv', 'post', 'side' ); // featured image meta box.
		add_meta_box( 'uwpageparentdiv', 'Page Attributes', array( $this, 'page_attributes_meta_box' ), 'page', 'side', 'core' );
	}

	/**
	 * Creating the page attributes meta box which allows the user to
	 * select a template, parent page, as well setting the ordering field of the page
	 *
	 * @param Object $post Post object for which this attribute box will be generated.
	 */
	function page_attributes_meta_box( $post ) {

		$post_type_object = get_post_type_object( $post->post_type );

		if ( $post_type_object->hierarchical ) {
			$dropdown_args = array(
			'post_type'        => $post->post_type,
			'exclude_tree'     => $post->ID,
			'selected'         => $post->post_parent,
			'name'             => 'parent_id',
			'show_option_none' => __( '(no parent)' ),
			'sort_column'      => 'menu_order, post_title, sidebar, parent',
			'echo'             => 0,
			);

			  $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
			  $pages = wp_dropdown_pages( $dropdown_args );

			if ( ! empty( $pages ) ) { ?>

			<p><strong><?php esc_html_e( 'Parent' ) ?></strong></p>
			<label class="screen-reader-text" for="parent_id"><?php esc_html_e( 'Parent' ) ?></label>

			<?php
			$allowed_els = array(
					'select' => array(
			  'name' => array(),
			  'id'   => array(),
			),
					'option' => array(
			  'class' => array(),
			  'value' => array(),
			  'selected' => array(),
			),
				  );
			echo wp_kses( $pages, $allowed_els );
				$parent = get_post_meta( $post->ID, 'parent', true );
				wp_nonce_field( 'parent_nonce', 'parent_name' );
			?>

			<p><input type="checkbox" id="parent_id" name="parentcheck" value="on" <?php if ( ! empty( $parent ) ) { ?>checked="checked"<?php
} ?> /><?php esc_html_e( 'Hide from menu' ) ?></p>

			<?php
			} // end empty pages check
		} // end hierarchical check.

		if ( 'page' === $post->post_type && 0 !== count( get_page_templates( $post ) ) ) {
			$template = ! empty( $post->page_template ) ? $post->page_template : 'default';
			?>


		  <p><strong><?php esc_html_e( 'Template' ) ?></strong></p>

		  <label class="screen-reader-text" for="page_template"><?php esc_html_e( 'Page Template' ) ?></label>

			<?php $this->page_template_dropdown( $template, $post ); ?>

		<?php }
		$sidebar = get_post_meta( $post->ID, 'sidebar', true );
		wp_nonce_field( 'sidebar_nonce', 'sidebar_name' );
		?>

		<p><strong><?php esc_html_e( 'Sidebar' ) ?></strong></p>

	  <label class="screen-reader-text" for="sidebar"><?php esc_html_e( 'Sidebar' ) ?></label>

	  <p><input type="checkbox" id="sidebar_id" name="sidebarcheck" value="on" <?php if ( ! empty( $sidebar ) ) { ?>checked="checked"<?php
} ?> /><?php esc_html_e( 'No Sidebar' ) ?></p>

	  <p><strong><?php esc_html_e( 'Order' ) ?></strong></p>

	  <p><label class="screen-reader-text" for="menu_order"><?php esc_html_e( 'Order' ) ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr( $post->menu_order ) ?>" /></p>

	  <p><?php if ( 'page' === $post->post_type ) { esc_html_e( 'Need help? Use the Help tab in the upper right of your screen.' );
} ?></p>

		<?php
	}

	/**
	 * Displays a menu of the page templates which a user can then select from
	 *
	 * @param string $default the Default template which should be selected initially.
	 * @param Object $post Post object of the current page.
	 */
	function page_template_dropdown( $default = '', $post ) {

		$previews = array( 'Big Hero' => '/assets/images/template-big-hero.jpg', 'Small Hero' => '/assets/images/template-small-hero.jpg', 'No image' => '/assets/images/template-no-image.jpg', 'No title/image' => '/assets/images/template-no-title.jpg', 'Default Template' => '/assets/images/template-default.jpg' );

		$templates = get_page_templates( get_post() );

		ksort( $templates );

		echo "<div class='uw-admin-template'>";
		$checked = checked( $default, 'default', false );
		echo "<p><input type='radio' name='page_template' value='default' " . esc_attr( $checked ) . "  >Default Template</input> (<a id='enchanced-preview' href='#'>preview<span><img src='" . esc_attr( get_stylesheet_directory_uri() ) . esc_attr( $previews['Default Template'] ) . "' alt='' width='300px' height='' />
</span></a>)</p>";
		foreach ( array_keys( $templates ) as $template ) {
			if ( in_array( $template, $this->HIDDEN, true ) ) {
				continue;
			}

			$checked = checked( $default, $templates[ $template ], false );
			echo "<p><input type='radio' name='page_template' value='" . esc_attr( $templates[ $template ] ) . "' " . esc_attr( $checked ) . ' >' . esc_html( $template ) . '</input> ' . ( array_key_exists( $template, $previews ) ? "(<a id='enchanced-preview' href='#'>preview<span><img src='" . esc_attr( get_stylesheet_directory_uri() ) . $previews[ $template ] . "' alt='' width='300px' height='' />
</span></a>)" : '') . '</p>';
		}
		echo '</div>';
		if ( 'templates/template-big-hero.php' === $default || 'templates/template-small-hero.php' === $default ) {
			if ( is_super_admin() ) {
				$banner = get_post_meta( $post->ID, 'banner', true );
				wp_nonce_field( 'banner_nonce', 'banner_name' );

				$buttontext = get_post_meta( $post->ID, 'buttontext', true );
				wp_nonce_field( 'buttontext_nonce', 'buttontext_name' );

				$buttonlink = get_post_meta( $post->ID, 'buttonlink', true );
				wp_nonce_field( 'buttonlink_nonce', 'buttonlink_name' );

				$mobileimage = get_post_meta( $post->ID, 'mobileimage', true );
				wp_nonce_field( 'mobileimage_nonce', 'mobileimage_name' );

				echo "<p><b>Banner</b></br><input type='text' name='bannertext' value='" . esc_attr( $banner ) . "'></p>";
				echo "<p><b>Button</b></br>Text</br><input type='text' name='buttontext' value='" . esc_attr( $buttontext ) . "'></br>Link</br><input type='text' name='buttonlink' value='" . esc_attr( $buttonlink ) . "'></p>";
				echo "<p><b>Mobile Header Image</b></br><input type='text' name='mobileimagetext' value='" . esc_attr( $mobileimage ) . "'></p>";
			}
		}
	}

	/**
	 * Enqueues a custom style to the uw admin template
	 */
	function custom_style() {
		wp_enqueue_style( 'uw-admin-template', get_template_directory_uri() . '/assets/admin/css/uw.admin.template.css' );
	}

	/**
	 * Saves the fields of the page attributes meta box to the given post id
	 *
	 * @param int $post_id post id of the post of which this data should saved under.
	 */
	function save_postdata( $post_id = 0 ) {
		$post_id = (int) $post_id;
		$post_type = get_post_type( $post_id );
		$post_status = get_post_status( $post_id );
		if ( ! isset( $post_type ) || 'page' !== $post_type ) {
			return $post_id;
		}

		if ( isset( $_POST['banner_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'banner_nonce', 'banner_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['bannertext'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'banner', sanitize_text_field( wp_unslash( $_POST['bannertext'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'banner', null );
					}
				}
			}
		}

		if ( isset( $_POST['buttontext_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'buttontext_nonce', 'buttontext_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['buttontext'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'buttontext', sanitize_text_field( wp_unslash( $_POST['buttontext'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'buttontext', null );
					}
				}
			}
		}

		if ( isset( $_POST['buttonlink_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'buttonlink_nonce', 'buttonlink_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['buttonlink'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'buttonlink', sanitize_text_field( wp_unslash( $_POST['buttonlink'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'buttonlink', null );
					}
				}
			}
		}

		if ( isset( $_POST['mobileimage_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'mobileimage_nonce', 'mobileimage_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['mobileimagetext'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'mobileimage', sanitize_text_field( wp_unslash( $_POST['mobileimagetext'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'mobileimage', null );
					}
				}
			}
		}

		if ( isset( $_POST['sidebar_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'sidebar_nonce', 'sidebar_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['sidebarcheck'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'sidebar', sanitize_text_field( wp_unslash( $_POST['sidebarcheck'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'sidebar', null );
					}
				}
			}
		}

		if ( isset( $_POST['parent_name'] ) ) { // Input var okay.
			if ( ! empty( $_POST ) && check_admin_referer( 'parent_nonce', 'parent_name' ) ) { // limit to only pages. Input var okay.
				if ( $post_type ) {
					if ( isset( $_POST['parentcheck'] ) ) { // Input var okay.
						update_post_meta( $post_id, 'parent', sanitize_text_field( wp_unslash( $_POST['parentcheck'] ) ) ); // Input var okay.
					} else {
						update_post_meta( $post_id, 'parent', null );
					}
				}
			}
		}

		return $post_id;
	}

}

new UW_Page_Attributes_Meta_Box;
