<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");   ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'menu', 'mobile' ); ?>
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

  <div class="row">

    <div class="col-md-8 uw-content" role='main'>

        <?php get_template_part( 'menu', 'mobile' ); ?>
        <?php get_template_part( 'breadcrumbs' ); ?>

        <div id='main_content' class="uw-body-copy" tabindex="-1">

            <h2><?php the_title(); ?></h2>

            <?php
              // Start the Loop.
              while ( have_posts() ) : the_post();

                the_content();

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) {
                  comments_template();
                }

              endwhile;
            ?>

        </div>

    </div>

    <div class="col-md-4" role="">
    sidebar asldkfj asdlk ;lksadfj alskdfj
    </div>

  </div>

</div>

<?php get_footer(); ?>
