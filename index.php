<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
      $sidebar = get_post_meta($post->ID, "sidebar");   ?>

<?php uw_site_title(); ?>
<?php get_template_part('menu', 'mobile'); ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

  <div class="row">

    <div class="uw-content col-md-9" role='main'>

        <div id='main_content' class="uw-body-copy" tabindex="-1">

            xxxx this template uses index.php xxxx

            <h2>News Archive</h2>

            <?php while ( have_posts() ) : the_post(); ?>

                <h3><?php the_title() ?></h3>
                <div class="update-date"><?php echo get_the_date() ?> </div>
                <div class='post-content'><?php the_excerpt() ?></div>

            <?php endwhile ?>

        </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
