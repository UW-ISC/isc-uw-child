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

<?php uw_site_title(); ?>
<?php get_template_part( 'menu', 'mobile' ); ?>


<div class="uw-body container">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    <div class="row">
        <article class="uw-content col-md-offset-1 col-md-10">

            xxxx this is a category page template xxxx
            <?php
            while ( have_posts() ) : the_post();
                the_title( '<h2 class="title">', '</h2>' );
                the_content();
            endwhile;

            display_child_pages();
            ?>

        </article>

    </div>

</div>

<?php get_footer(); ?>
