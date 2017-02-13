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

<?php uw_site_title(); ?>
<?php get_template_part('menu', 'mobile'); ?>

<section class="uw-body container">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <article id='main_content' class="uw-body-copy col-md-9" tabindex="-1">

            xxxx this is an article page template xxxx

            <?php

            while ( have_posts() ) : the_post();
                the_title('<h2 class="title">', '</h2>');
                the_content();
            endwhile;

                display_child_pages_with_toc();
            ?>

        </article>

    </div>

</section>

<?php get_footer();
