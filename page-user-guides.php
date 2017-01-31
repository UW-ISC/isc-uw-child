<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");
      $seasonal =  get_post_meta($post->ID); ?>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">

            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    user guide table goes here

</div>

<?php get_footer(); ?>
