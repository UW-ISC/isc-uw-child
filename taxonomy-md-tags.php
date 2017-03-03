
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

            <?php log_to_console("you are using the template: taxonomy-md-tags.php"); ?>

            <h2><?php the_title(); ?></h2>

            <div class="update-date"><?php echo get_the_date() ?></div>
            <div class="post-content">
                <?php
                  // Start the Loop.
                while ( have_posts() ) : the_post();

                    the_content();

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number() ) {
                        comments_template();
                    }

                endwhile;
                ?>
            </div>

        </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
