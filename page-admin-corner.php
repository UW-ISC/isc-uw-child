<?php get_header(); ?>

<?php get_template_part( 'header', 'image' ); ?>

<section class="container uw-body">

    <div class="row no-margin">

              <?php uw_site_title(); ?>

              <?php get_template_part('menu', 'mobile'); ?>

              <?php get_template_part( 'breadcrumbs' ); ?>

            <div class="col-lg-12 card" style="height:150px;display:flex;align-items:center;">

                <div class="col-lg-4">

                    <h3>
                        HR Administrators' Corner
                    </h3>

                    Friendly positioning statement will go here
                </div>

                <div class="col-lg-7 push-lg-1">
                    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_site_url() ?>">
                        <div>
                            <label class="screen-reader-text" for="s">Search for:</label>
                            <input type="text" value="" name="s" id="s" placeholder="Search for:" autocomplete="off">
                            <input type="submit" id="searchsubmit" value="Search">
                        </div>
                    </form>
                    <div class="search-suggestions">
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
        <div class="row no-margin">

            <div class="col-lg-8">

                <div class="row no-margin">

                    <div class="col-lg-12 card">

                        <h3>Updates</h3>

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

                </div>

                <div class="row no-margin">

                    <div class="col-lg-12 card">

                        <h3>Workday User Guides</h3>

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

                        <a class="work-guide no-margin row">
                            For HR Admins: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <h3>Time and Absence</h3>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Approvers: View all <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <h3>HCM</h3>

                        <a class="work-guide no-margin row">
                            For On-boarding coordinators: view all <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 1s: view all <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <h3>Academic Specific</h3>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <h3>Medical Center Specific</h3>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo get_guide_count(''); ?> User guides
                        </a>

                        <a class="row" style="color: blue !important;">
                            Go to the User guides library for other security roles >
                        </a>
                    </div>

                </div>

            </div>

            <div class="col-lg-4 ">

                <div class="row no-margin">

                    <div class="side-card col-lg-12">

                        <h3>Workshops</h3>

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
                             <div class='post-content'><?php the_excerpt() ?></div>

                        <?php
                          endif;

                          ?>

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card col-lg-12">

                        <h3>Seasonal Topics<h3>

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
                             <div class='post-content'><?php the_excerpt() ?></div>

                        <?php
                          endif;

                          ?>

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card question col-lg-12">

                        Got a complex question? Need HR Experts?

                        <br>
                        <br>

                        Contact Tier 2 support team

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card col-lg-12">

                        <h3>Workday Security Roles</h3>

                        <a>Read about Workday Security roles and request the change -></a>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php get_footer();
