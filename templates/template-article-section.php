<?php
/**
 * Template Name: Article Section
 *
 * A full-width template, that displays the description of a specific article
 *
 * @author Abhishek Chauhan <abhi3@uw.edu>
 */

get_header();
?>

<section class="uw-body container">
    <div class="row">

        <?php get_template_part( 'menu', 'mobile' ); ?>
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
