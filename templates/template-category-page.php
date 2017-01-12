<?php
/**
 * Template Name: Category Page
 *
 * A full-width template, that displays the description of a specific category
 * as well as listing the children pages within it
 *
 */

get_header();

?>

<section class="uw-body container">
    <div class="row">

       <?php get_template_part( 'menu', 'mobile' ); ?>
       <?php get_template_part( 'breadcrumbs' ); ?>

        <article class="uw-content col-lg-12">

            <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'content', 'page' );

            endwhile;

            display_child_pages();
            ?>

        </article>

    </div>
</section>

<?php get_footer(); ?>
