<?php get_header(); ?>

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

            xxxx this template uses search.php xxxx

            <h2>Search Results</h2>

            <div>

                <?php
                  if ( have_posts() ) :
                    while ( have_posts() ) : the_post(); ?>

                        <h3><?php the_title() ?></h3>
                        <div class="update-date"><?php echo get_the_date() ?> </div>
                        <div class='post-content'><?php the_excerpt() ?></div>

                    <?php endwhile;
                  else :
                    echo '<h3 class=\'no-results\'>Sorry, no results matched your criteria.</h3>';
                  endif; ?>

                <div><?php posts_nav_link(' '); ?></div>

            </div>

        </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
