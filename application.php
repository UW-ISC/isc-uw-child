<?php get_header(); ?>
<div class="container uw-body">

  <div class="row">

    <div class="uw-content" role='main'>

      <?php uw_site_title(); ?>

      <div class="uw-body-copy">


        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            $type = get_post_mime_type(get_the_ID());

            if($type === 'application/pdf')
             {
              get_template_part( 'content', 'pdf' );
            }
            else {
              get_template_part( 'content', 'doc' );
            }
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
              comments_template();
            }

          endwhile;
        ?>

      </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
