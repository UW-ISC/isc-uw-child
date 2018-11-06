<?php 
/**
 * This is a template to display categorized news items (posts).
 * All news articles of selected category (or ANDed categories i.e. if two categories are selected this page would disply news items that math BOTH the categories)
 * should be displayed in descending order of their publish date.
 * 
 * Requries WordPress Plugin: Search & Filter by Designs & Code https://www.designsandcode.com/wordpress-plugins/search-filter/
 * 
 * @package isc-uw-child
 * @author Prasad Thakur <prasadt@uw.edu>
 */

get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<div class="container uw-body">

  <div class="row">

    <div class='uw-content' role='main'>

      <?php uw_site_title(); ?>

      <?php get_template_part( 'menu', 'mobile' ); ?>

      <div id='main_content' class="uw-body-copy" tabindex="-1">

      <h1>News</h1><hr>
      <div class="row">
        <div class="col-md-12">
          <?php echo do_shortcode('[searchandfilter empty_search_url="'.get_permalink( get_option( 'page_for_posts' ) ).'" submit_label="Filter" fields="category,post_date" types="checkbox,daterange" headings="Category,Posted Between"]'); ?>
        </div>
      </div>

        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'content', 'archive' );


          endwhile;
        ?>
        </br>
        <!-- pagination functions -->
        <div class="nav-previous alignleft"><?php previous_posts_link( 'Previous' ); ?></div>
        <div class="nav-next alignright"><?php next_posts_link( 'Next' ); ?></div>

      </div>

    </div>

    

  </div>

</div>

<?php get_footer(); ?>
