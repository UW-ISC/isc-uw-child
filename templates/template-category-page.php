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
        <div class="col-md-12">
            <?php get_template_part( 'menu', 'mobile' ); ?>
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    <div class="row">

        <article class="uw-content col-md-8">

            <?php
            while ( have_posts() ) : the_post();
                the_title( '<h2 class="title">', '</h2>' );
                the_content();
            endwhile;

            display_child_pages();
            ?>

        </article>

        <aside class="col-md-4">
            this is a category page
        </aside>

    </div>
</section>

<?php get_footer(); ?>
