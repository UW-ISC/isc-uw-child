<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");   ?>

<?php uw_site_title(); ?>
<?php get_template_part( 'menu', 'mobile' ); ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

  <div class="row">

    <div class="uw-content col-md-offset-1 col-md-10" role='main'>

        <div id='main_content' class="uw-body-copy" tabindex="-1">

            xxxx this template uses index.php xxxx

            <h2>News Archive</h2>

          <?php
              // Start the Loop.
              while ( have_posts() ) : the_post();

                  /*
                   * Include the post format-specific template for the content. If you want to
                   * use this in a child theme, then include a file called called content-___.php
                   * (where ___ is the post format) and that will be used instead.
                   */
                  get_template_part( 'content', get_post_format() );

                  // If comments are open or we have at least one comment, load up the comment template.
                  if ( comments_open() || get_comments_number() ) {
                      comments_template();
                  }

              endwhile;
          ?>

          <span class="next-page"><?php next_posts_link( 'Next page', '' ); ?></span>

        </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
