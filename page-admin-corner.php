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

                    </div>

                </div>

                <div class="row no-margin">

                    <div class="col-lg-12 card">

                        <h3>Workday User Guides</h3>

                        <a class="work-guide no-margin row">
                            For HR Admins: view 115 User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 2s: view 70 User guides
                        </a>


                        <a class="work-guide no-margin row">
                            For Approvers: View all 22 User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For On-boarding coordinators: view all 20 User guides
                        </a>

                        <a class="work-guide no-margin row">
                            For Initiator 1s: view all 52 User guides
                        </a>

                        <a class="row" style="color: blue !important;">
                            Go to the User guides library for other security roles >
                        </a>
                    </div>

                </div>

            </div>

            <div class="col-lg-4 ">

                <div class="row no-margin">

                    <div class="side-card">

                        <div class="card_title">Workshops</div>

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card">

                        <div class="card_title">Seasonal Topics</div>

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card question">

                        Got a complex question? Need HR Experts?

                        <br>
                        <br>

                        Contact Tier 2 support team

                    </div>
                </div>

                <div class="row no-margin">
                    <div class="side-card">

                        <div class="card_title">Workday Security Roles</div>

                        <a>Read about Workday Security roles and request the change -></a>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php get_footer();
