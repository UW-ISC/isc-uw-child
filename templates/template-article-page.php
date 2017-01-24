<?php
/**
 * Template Name: Article Page
 *
 * A full-width template, that displays the description of a specific article
 * as well as listing the children pages within it
 *
 * @author Abhishek Chauhan <abhi3@uw.edu>
 */

get_header();
?>

<section class="uw-body container">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'menu', 'mobile' ); ?>
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    <div class="row">
        <article id='main_content' class="uw-body-copy col-lg-12" tabindex="-1">

            <?php
            while ( have_posts() ) : the_post();
                the_title( '<h3 class="title">', '</h3>' );
                the_content();
            endwhile;

            display_child_pages_with_toc();
            ?>

        </article>

    </div>

</section>

<?php get_footer();
