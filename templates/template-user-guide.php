<?php
/**
 * Template Name: User Guide
 *
 * Template that displays a user guide (step by step tutorials)
 * additionally with a table of contents automatically generated
 * from the headers
 *
 * @author Kevin Zhao <zhaok24@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.6.0
 * @package UWHR
 */

get_header();

// This previously depended on whether or not the user enabled anchor linking within the admin
// Now we just generate the anchor linking automatically
// $table_of_contents = get_post_meta( $post->ID, '_uwhr_page_anchor_linking_active', true ) ? "True" : "False";
$table_of_contents = "True";
get_template_part( 'partials/hero', 'normal' ); ?>

<section class="uwhr-body container" id="toc">
    <div class="row">

        <?php uwhr_breadcrumbs(); ?>

                <?php
                    get_sidebar();
                    uwhr_site_menu_user_guide();
                ?>
        <article class="uwhr-content float-content col-lg-<?php echo ( ( $table_of_contents == 'True' ) ? 6 : 9 ); ?> pull-lg-3">

            <?php
                while ( have_posts() ) : the_post();
                    the_title( '<h3 class="title">', '</h3>' );
                    the_content();
                endwhile
            ?>

        </article>


    </div>
</section>

<?php get_footer();
