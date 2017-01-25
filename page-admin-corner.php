<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");   ?>


<div class="isc-admin-hero" style="background-image:url('http://curry.aca.uw.edu:8080/hrp-portal/wp-content/themes/uw-2014/assets/headers/suzzallo.jpg');">

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

                <div style="padding: 30px 0;">
                    <?php

                    global $wpdb;

                    $query = "SELECT DISTINCT query, COUNT('query') AS 'query_occurence'
                        FROM " . $wpdb->prefix . "relevanssi_log GROUP BY query ORDER BY query_occurence DESC " .
                        "LIMIT 3 ;";
                    $queries = $wpdb->get_results($query, ARRAY_N);
                     ?>
                    Popular searches:
                    <a href="<?php echo get_site_url(); echo "?s=" .$queries[0][0] ?>"><?php echo $queries[0][0] ?> </a> |
                    <a href="<?php echo get_site_url(); echo "?s=" .$queries[1][0] ?>"><?php echo $queries[1][0] ?> </a>|
                    <a href="<?php echo get_site_url(); echo "?s=" .$queries[2][0] ?>"><?php echo $queries[2][0] ?> </a>
                </div>

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
                              	),);
                         $category_posts = new WP_Query($args);

                         if($category_posts->have_posts()) :
                            while($category_posts->have_posts()) :
                               $category_posts->the_post();
                      ?>

                               <h3><?php the_title() ?></h3>
                               <div class="update-date"><?php echo get_the_date() ?> </div>
                               <div class='post-content'><?php the_excerpt() ?></div>

                      <?php
                            endwhile;
                        else:
                        endif;
                      ?>
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
                                  	),);

                             $guides = new WP_Query($args);
                             return $guides->post_count;
                          }

                      ?>

                      <h3>General</h3>

                      <ul>
                          <li><a class="">For Employee as Self: view <?php echo get_guide_count('employee-as-self'); ?> User guides</a></li>
                          <li><a class="">For I-9 Coordinators: view <?php echo get_guide_count('i-9-coordinator'); ?> User guides</a></li>
                      </ul>

                      <h3>Time and Absence</h3>

                      <ul>
                          <li><a class=" ">For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides</a></li>
                          <li><a class=" ">For Approvers: View all <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <h3>HCM</h3>

                      <ul>
                          <li><a class="">For Time and Absence Approvers: view <?php echo get_guide_count('ta-approver'); ?> User guides</a></li>
                          <li><a class="">For Time and Abesence Initiates: View all <?php echo get_guide_count('ta-initiate'); ?> User guides</a></li>
                          <li><a class="">For On-boarding coordinators: view all <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <h3>Academic Specific</h3>

                      <ul>
                          <li><a class="">For Position and Job Requisition Initiates: view all <?php echo get_guide_count('pj-req-initiate'); ?> User guides</a></li>
                          <li><a class="">For HCM Initiate 1s: view all <?php echo get_guide_count('hcm-initiate-1'); ?> User guides</a></li>
                          <li><a class="">For HCM Initiate 2s: view <?php echo get_guide_count('hcm-initiate-2'); ?> User guides</a></li>
                          <li><a class="">For HR Partners: view <?php echo get_guide_count('hr-partner'); ?> User guides</a></li>
                          <li><a class="">For Additional Approver 1s: view <?php echo get_guide_count('addl-approver-1'); ?> User guides</a></li>
                          <li><a class="">For Additional Approver 2s: view <?php echo get_guide_count('addl-approver-2'); ?> User guides</a></li>
                          <li><a class="">For Costing Allocations Coordinators: view <?php echo get_guide_count('costing-allocations-coord'); ?> User guides</a></li>
                          <li><a class="">For Academic Partners: view <?php echo get_guide_count('academic-partner'); ?> User guides</a></li>
                          <li><a class="">For Academic Chair / Chair’s Delegates: view <?php echo get_guide_count('academic-chair'); ?> User guides</a></li>
                          <li><a class="">For Academic Dean / Dean’s Delegates: view <?php echo get_guide_count('academic-dean'); ?> User guides</a></li>
                      </ul>

                      <h3>Medical Center Specific</h3>

                      <ul>
                          <li><a class="">For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides</a></li>
                          <li><a class="">For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides</a></li>
                      </ul>

                      <ul>
                          <li><a class="">For Medical Centers Job Requisitions Approvers 1s: view <?php echo get_guide_count('med-cent-job-req-approver-1'); ?> User guides</a></li>
                          <li><a class="">For Medical Centers Job Requisitions Approvers 2s: view <?php echo get_guide_count('med-cent-job-req-approver-2'); ?> User guides</a></li>
                          <li><a class="">For Medical Centers Job Requisitions Approvers 3s: view <?php echo get_guide_count('med-cent-job-req-approver-3'); ?> User guides</a></li>
                          <li><a class="">For Medical Centers Managers: view <?php echo get_guide_count('	medical-centers-manager'); ?> User guides</a></li>
                      </ul>

                      <a class="row" style="color: blue !important;">Go to the User guides library for other security roles ></a>
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
                                ),);
                       $workshop_posts = new WP_Query($workshop_args);

                       if($workshop_posts->have_posts()) :
                             $workshop_posts->the_post();
                    ?>

                         <h3><?php the_title() ?></h3>
                         <div class="update-date"><?php echo get_the_date() ?> </div>
                         <div class='post-content'><?php
                             $texdt = the_excerpt();
                             wp_trim_words($texdt, 5, '...');
                             echo $texdt;
                          ?></div>

                    <?php
                      endif;

                      ?>
                </div>
            </div>

            <div class="contact-widget-inner isc-widget-white">
                <h3 class="widgettitle">Seasonal Topics</h3>
                <div>
                    <?php

                       $seasonal_args = array(
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'location',
                                        'field'    => 'slug',
                                        'terms'    => 'admin-corner-seasonal',
                                    ),
                                ),);
                       $seasonal_posts = new WP_Query($seasonal_args);

                       if($seasonal_posts->have_posts()) :
                             $seasonal_posts->the_post();
                    ?>

                         <h3><?php the_title() ?></h3>
                         <div class="update-date"><?php echo get_the_date() ?> </div>
                         <div class='post-content'><?php echo wp_trim_words(the_excerpt(), 5, '...')  ?></div>

                    <?php
                      endif;
                      ?>
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