<?php
/**
 * Template Name: Category Page
 *
 * A full-width template, that displays the description of a specific category
 * as well as listing the children pages within it
 *
 * @author Steven Speicher <stvns@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.7.0
 * @package UWHR
 */

get_header();

get_template_part( 'partials/hero', 'normal' );

?>

<section class="uwhr-body container">
    <div class="row">

        <?php uwhr_breadcrumbs(); // info that tells user where they are in the current page directory ?>

        <article class="uwhr-content col-lg-12">

            <?php
            while ( have_posts() ) : the_post();
                the_title( '<h3 class="title">', '</h3>' );
                uwhr_toc();
                the_content();
                edit_post_link();
            endwhile;

            display_child_pages();
            ?>

        </article>

    </div>
</section>

<?php get_footer();
