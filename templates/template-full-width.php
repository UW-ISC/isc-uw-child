<?php
/**
 * Template Name: Full Width
 *
 * A full-width template without the sidebar menu and right rail.
 *
 * @author Steven Speicher <stvns@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.7.0
 * @package UWHR
 */

get_header();

get_template_part( 'partials/hero', 'normal' );

?>

<section class="container uw-body">
    <div class="row">

        <?php get_template_part( 'breadcrumbs' ); ?>

        <article class="uw-body-copy col-lg-12">

            <?php
                while ( have_posts() ) : the_post();
                    the_title( '<h3 class="title">', '</h3>' );
                    the_content();
                    edit_post_link();
                endwhile;
            ?>

        </article>

    </div>
</section>

<?php get_footer();
