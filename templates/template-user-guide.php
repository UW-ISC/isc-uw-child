<?php
/**
 * Template Name: User Guide
 *
 * Template that displays a user guide (step by step tutorials)
 * additionally with a table of contents automatically generated
 * from the headers
 *
 * @author Kevin Zhao <zhaok24@uw.edu>
 * @author Abhishek Chauhan <abhi3@uw.edu>
 */

get_header();
?>

<?php uw_site_title(); ?>
<?php get_template_part( 'menu', 'mobile' ); ?>

<section class="uw-body container" id="toc">

        <div class="row">
            <div class="col-md-12">
                <?php get_template_part( 'breadcrumbs' ); ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <?php user_guide_menu(); ?>
            </div>

            <article class="uw-content float-content col-md-8">

                xxxx this is a user guide template xxxx

                <?php
                    while ( have_posts() ) : the_post();
                        the_title( '<h2 class="title">', '</h2>' );
                        the_content();
                    endwhile
                ?>

            </article>
        </div>

</section>

<?php get_footer();
