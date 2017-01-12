<?php
/**
 * Template Name: Category Page
 *
 * A full-width template, that displays the description of a specific category
 * as well as listing the children pages within it
 *
 */

get_header();

get_template_part( 'partials/hero', 'normal' );
?>

<section class="uw-body container">
    <div class="row">

        <article class="uw-content col-lg-12">

            <?php
            while ( have_posts() ) : the_post();
                //the_title( '<h3 class="title">', '</h3>' );
                //uwhr_toc();
                get_template_part( 'content', 'page' );

                //edit_post_link();
            endwhile;

            display_child_pages();
            ?>

        </article>

    </div>
</section>

<?php get_footer(); ?>
