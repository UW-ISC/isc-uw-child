<?php
/**
 * Template Name: Article Section
 *
 * A full-width template, that displays the description of a specific article
 * as well as listing the children pages within it
 *
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

            ?>

        </article>

    </div>
</section>

<?php get_footer();
