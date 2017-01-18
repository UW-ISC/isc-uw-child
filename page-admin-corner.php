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
                    <form class="uwhr-search" role="search" method="POST" action="<?php get_home_url(1, '/') ?>">
                        <div class="form-group search-wrapper" style="margin-bottom:0px !important;">
                            <label class="sr-only" for="s">Enter search text: </label>
                            <input class="search-input form-control search-filed" type="search" placeholder="Get answers" data-swplive="true" value="" name="s" title="Search for:" autocomplete="off">
                            <div class="search-icons">
                                <div class="icon erase-icon hide">
                                    <i class="fa fa-close"></i>
                                </div>
                                <div class="icon search-icon">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="search-suggestions">
                        Popular searches: "User guide topic1" | "FAQ topic1" | "FAQ topic2"
                    </div>
                </div>
            </div>
        <div class="row no-margin">

            <div class="col-lg-7">

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
                                 <div class='post-content'><?php the_content() ?></div>

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

                           $admin_args = array('taxonomy' => 'updates');
                           $hr_admin_guides = new WP_Query($admin_args);

                           $initatior_2s_args = array('category_name' => 'updates');
                           $initiator_2s_guides = new WP_Query($initatior_2s_args);

                           $approver_args = array('category_name' => 'updates');
                           $approver_guides = new WP_Query($approver_args);

                           $coordinator_args = array('category_name' => 'updates');
                           $coordinator_guides = new WP_Query($coordinator_args);

                           $initiator_1s_args = array('category_name' => 'updates');
                           $initiator_1s_guides = new WP_Query($initiator_1s_args);
                        ?>

                        <a class="work-guide no-margin row">
                            For HR Admins: view <?php echo $hr_admin_guides->post_count; ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view <?php echo $initiator_2s_guides->post_count; ?> User guides
                        </a>


                        <a class="work-guide no-margin row">
                            For Approvers: View all <?php echo $approver_guides->post_count; ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For On-boarding coordinators: view all <?php echo $coordinator_guides->post_count; ?> User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 1s: view all <?php echo $initiator_1s_guides->post_count; ?> User guides
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

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card col-lg-12">

                        <h3>Seasonal Topics<h3>

                        <?php

                           $seasonal_args = array('category_name' => 'seasonal_topics');
                           $seasonal_posts = new WP_Query($seasonal_args);

                           if($category_posts->have_posts()) :
                                 $category_posts->the_post();
                        ?>

                             <h3><?php the_title() ?></h3>
                             <div class="update-date"><?php echo get_the_date() ?> </div>
                             <div class='post-content'><?php the_content() ?></div>

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
