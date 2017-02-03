<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");
      $seasonal =  get_post_meta($post->ID); ?>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

<div class="isc-admin-hero">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php the_title(); ?></h2>

                <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_site_url() ?>">
                    <div>
                        <label class="screen-reader-text" for="s">Search for:</label>
                        <input type="text" value="" name="s" id="s" placeholder="Search for:" autocomplete="off">
                        <input type="submit" id="searchsubmit" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8 uw-content isc-content" role='main'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <div class="isc-admin-block">

                    <h3 class="isc-admin-header">Admins' News</h3>

                      <?php

                         $args = array(
                                  'tax_query' => array(
                                      array(
                                          'taxonomy' => 'location',
                                          'field'    => 'slug',
                                          'terms'    => 'admin-corner-news',
                                      ),
                                  ),
                                'post_status' => 'published');
                         $category_posts = new WP_Query($args);

                         if ($category_posts->have_posts()) :
                            while ($category_posts->have_posts()) :
                               $category_posts->the_post();
                      ?>

                               <h4><?php the_title() ?></h4>
                               <div class="update-date"><?php echo get_the_date() ?> </div>
                               <div class='post-content'><?php the_excerpt() ?></div>

                      <?php
                            endwhile;
                        endif;
                      ?>

                    <p><a href="<?php echo get_site_url() . '/user-guides/?foo=bar'?>">Read more news</a></p>

                  </div>

                  <div class="isc-admin-block">
                      <h3 class="isc-admin-header">Workday Resources</h3>
                      <ul>
                          <li><a href="<?php echo get_site_url() . '/user-guides/'?>">User Guides</a></li>
                          <li>Link</li>
                          <li>Link</li>
                      </ul>
                  </div>

                  <div class="isc-admin-block">
                      <h3 class="isc-admin-header">Workday Support</h3>
                      <ul>
                          <li>Link</li>
                          <li>Link</li>
                          <li>Link</li>
                      </ul>
                  </div>

              </div>

            </div>

        <div class="col-md-4 uw-sidebar isc-sidebar" role="">

            <div class="contact-widget-inner isc-widget-tan isc-admin-block">
                <h3 class="isc-admin-header">Events</h3>
                <div>
                    <?php
                       $workshop_args = array(
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'location',
                                        'field'    => 'slug',
                                        'terms'    => 'admin-corner-workshops',
                                    ),
                                ),
                                'post_status' => 'published');
                       $workshop_posts = new WP_Query($workshop_args);

                       if ($workshop_posts->have_posts()) :
                             $workshop_posts->the_post();
                    ?>
                     <h4><?php the_title() ?></h4>
                     <div class='post-content'><?php the_excerpt(); ?></div>

                    <?php
                      endif;
                      ?>

                    <p><a href="<?php echo get_site_url() . '/admin-events'?>">See all Events</a></p>
                </div>
            </div>

            <div class="contact-widget-inner isc-widget-white isc-admin-block">
                <h3 class="isc-admin-header">Seasonal Topics</h3>
                <div class='post-content'>
                    <?php
                    $summary_content = "No description found";
                    if (array_key_exists("summary-text", $seasonal) && !$seasonal["summary-text"][0] == "") {
                      $summary_content = $seasonal["summary-text"][0];
                    }
                    echo $summary_content;
                    ?>
                    <?php echo the_cfc_field('hl-seasonal', 'body') ?>
                </div>
                <p><a href="<?php echo get_site_url() . "/seasonal-topics"?>">See all Seasonal Topics</a></p>
            </div>

            <div class="contact-widget-inner isc-widget-gray isc-admin-block">
                <h3 class="isc-admin-header">Help for Admins</h3>
                <ul>
                    <li>Link</li>
                    <li>Link</li>
                    <li>Link</li>
                </ul>
            </div>


        </div>

    </div>

</div>

<?php get_footer(); ?>
