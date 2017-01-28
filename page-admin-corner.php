<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");
      $seasonal =  get_post_meta($post->ID); ?>


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
            <?php get_template_part( 'menu', 'mobile' ); ?>
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8 uw-content isc-content" role='main'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <div class="isc-admin-block">

                    <h3 class="widgettitle">Updates</h3>

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

                         if($category_posts->have_posts()) :
                            while($category_posts->have_posts()) :
                               $category_posts->the_post();
                      ?>

                               <h4><?php the_title() ?></h4>
                               <div class="update-date"><?php echo get_the_date() ?> </div>
                               <div class='post-content'><?php the_excerpt() ?></div>

                      <?php
                            endwhile;
                        endif;
                      ?>

                    <p><a href="">Read more news</a></p>

                  </div>

                  <div class="isc-admin-block">
                      <h3 class="widgettitle">Workday User Guides</h3>

                      <?php

                          function get_guide_count($name){

                             $args = array(
                                  	'tax_query' => array(
                                  		array(
                                  			'taxonomy' => 'security-role',
                                  			'field'    => 'slug',
                                  			'terms'    => $name,
                                  		),
                                  	),
                                    'post_status' => 'published');

                             $guides = new WP_Query($args);
                             return $guides->post_count;
                          }

                      ?>

                      <h4>General</h4>

                      <ul>
                          <li>For Employee as Self: <a href="">view <?php echo get_guide_count('employee-as-self'); ?> User guides</a></li>
                          <li>For I-9 Coordinators: <a href="">view <?php echo get_guide_count('i-9-coordinator'); ?> User guides</a></li>
                      </ul>

                      <h4>Time and Absence</h4>

                      <ul>
                          <li>For Initiator 2s: <a href="">view <?php echo get_guide_count(''); ?> User guides</a></li>
                          <li>For Approvers: <a href="">view all <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <h4>HCM</h4>

                      <ul>
                          <li>For Time and Absence Approvers: <a href="">view <?php echo get_guide_count('ta-approver'); ?> User guides</a></li>
                          <li>For Time and Abesence Initiates: <a href="">view all <?php echo get_guide_count('ta-initiate'); ?> User guides</a></li>
                          <li>For On-boarding coordinators: <a href="">view all <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <h4>Academic Specific</h4>

                      <ul>
                          <li>For Position and Job Requisition Initiates: <a href="">view all <?php echo get_guide_count('pj-req-initiate'); ?> User guides</a></li>
                          <li>For HCM Initiate 1s: <a href="">view all <?php echo get_guide_count('hcm-initiate-1'); ?> User guides</a></li>
                          <li>For HCM Initiate 2s: <a href="">view <?php echo get_guide_count('hcm-initiate-2'); ?> User guides</a></li>
                          <li>For HR Partners: <a href="">view <?php echo get_guide_count('hr-partner'); ?> User guides</a></li>
                          <li>For Additional Approver 1s: <a href="">view <?php echo get_guide_count('addl-approver-1'); ?> User guides</a></li>
                          <li>For Additional Approver 2s: <a href="">view <?php echo get_guide_count('addl-approver-2'); ?> User guides</a></li>
                          <li>For Costing Allocations Coordinators: <a href="">view <?php echo get_guide_count('costing-allocations-coord'); ?> User guides</a></li>
                          <li>For Academic Partners: <a href="">view <?php echo get_guide_count('academic-partner'); ?> User guides</a></li>
                          <li>For Academic Chair / Chair’s Delegates: <a href="">view <?php echo get_guide_count('academic-chair'); ?> User guides</a></li>
                          <li>For Academic Dean / Dean’s Delegates: <a href="">view <?php echo get_guide_count('academic-dean'); ?> User guides</a></li>
                      </ul>

                      <h4>Medical Center Specific</h4>

                      <ul>
                          <li>For Initiator 2s: <a href="">view <?php echo get_guide_count(''); ?> User guides</a></li>
                          <li>For Initiator 2s: <a href="">view <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <ul>
                          <li>For Medical Centers Job Requisitions Approvers 1s: <a href="">view <?php echo get_guide_count('med-cent-job-req-approver-1'); ?> User guides</a></li>
                          <li>For Medical Centers Job Requisitions Approvers 2s: <a href="">view <?php echo get_guide_count('med-cent-job-req-approver-2'); ?> User guides</a></li>
                          <li>For Medical Centers Job Requisitions Approvers 3s: <a href="">view <?php echo get_guide_count('med-cent-job-req-approver-3'); ?> User guides</a></li>
                          <li>For Medical Centers Managers: <a href="">view <?php echo get_guide_count('medical-centers-manager'); ?> User guides</a></li>
                      </ul>

                      <p><a href="">See full list of all User Guides...</a></p>
                  </div>

              </div>

            </div>

        <div class="col-md-4 uw-sidebar isc-sidebar" role="">

            <div class="contact-widget-inner isc-widget-tan">
                <h3 class="widgettitle">Workshops</h3>
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

                       if($workshop_posts->have_posts()) :
                             $workshop_posts->the_post();
                    ?>
                     <h4><?php the_title() ?></h4>
                     <div class='post-content'><?php the_excerpt(); ?></div>

                    <?php
                      endif;
                      ?>

                    <p><a href="">See previous Workshops</a></p>
                </div>
            </div>

            <div class="contact-widget-inner isc-widget-white">
                <h3 class="widgettitle">Seasonal Topics</h3>
                <div>
                      <div class='post-content'><?php echo the_cfc_field('hl-seasonal', 'body') ?></div>
                      <?php 
                      $summary_content = "No description found";
                      if (array_key_exists("summary-text", $seasonal) && !$seasonal["summary-text"][0] == "") {
                          $summary_content = $seasonal["summary-text"][0];
                      }
                      echo $summary_content;
                      ?>
                      <p><a href="<?php echo get_site_url() . "/seasonal-topics"?>">See all Seasonal Topics</a></p>
                </div>
            </div>

            <div class="contact-widget-inner isc-widget-gray">
                <h3 class="widgettitle">Got a complex question? Need HR Experts?</h3>
                <div>
                    Contact Tier 2 support team
                </div>
            </div>

            <div class="contact-widget-inner isc-widget-white">
                <h3 class="widgettitle">Workday Security Roles</h3>
                <div>
                    <a href="">Read about Workday Security roles and request the change</a>
                </div>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
