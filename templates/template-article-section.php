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

<?php uw_site_title(); ?>
<?php get_template_part('menu', 'mobile'); ?>

<section class="uw-body container">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <article class="uw-body-copy col-md-9">

            <?php log_to_console("template-article-section.php") ?>

            <?php
            while ( have_posts() ) : the_post();
                the_title('<h2 class="title">', '</h2>');
                // echoing the tags
                echo isc_get_tags(get_queried_object());
                the_content();
                edit_post_link();
            endwhile;

            ?>
        </article>

    </div>
</section>

<?php get_footer();
