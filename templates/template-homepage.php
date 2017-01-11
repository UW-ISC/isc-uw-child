<?php
/**
 * Template Name: Homepage
 *
 * The template the homepage.
 *
 * @author Mason Gionet <mgionet@uw.edu>
 * @copyright Copyright (c) 2016, University of Washington
 * @since 0.4.0
 * @package UWHR
 */

get_header('homepage');

get_template_part( 'partials/hero', 'normal' );

?>

<section class="uwhr-body">
    <div class="search_bar">
      <div class="row p-t-1">
        <div class="col-md-2">
        </div>
        <div class="col-md-6">
          <p style="font-size:36px;">Got HR and Payroll Questions?</p>
          <?php
          global $UWHR; $UWHR->Search->UI->render_search_form( 'widefat' );
          ?>
        </div>
        <div class="col-md-2">
        </div>
        <div class="col-md-2">
          <a href="https://depts.washington.edu/isceval/contact-help-desk/"> Contact the Help Desk</a>
          <a href="https://workday.uw.edu/"> Login to Workday</a>
          <a href="https://axweb.cac.washington.edu/sites/DynamicsAx/EmployeeServices/Timesheets/Enterprise%20Portal/TSTimesheetsListPageEP.aspx?WMI=TsTimeSheetList&WP=4&WCMP=1000&WDPK=initial"> Submit your Timesheet</a>
          <a href="https://depts.washington.edu/isceval/employee-profile/manage-profile-information/"> Manage your Profile</a>
        </div>
      </div>
    </div>

    <div class ="featured_pages">
          <div class="uwhr-unit-featured-pages">
            <div class="news_area">
                  <?php
                    $args = array ('numberposts' => 3); // limits only 10 news posts to display
                    $recent_posts = wp_get_recent_posts($args);
                    ?>
                    <a href="http://localhost:8080/hrp-portal/news">
                      <p style="font-size:26px;">News</p>
                    </a>
                    <?php foreach($recent_posts as $recent) { ?>
                        <div class="news_posts">
                          <a href="<?php echo get_post_permalink($recent['ID']); ?>">
                          <?php echo get_the_title($recent['ID']); ?></a>
                            <article class="card">
                              <div class="post_details">
                                <?php
                                echo get_the_excerpt($recent['ID']);
                                ?>
                              </div>
                            </article>
                        </div>
                  <?php
                    }
                    wp_reset_query();
                  ?>
            </div>
          <?php if ( has_featured_pages() ) { ?>
              <?php uwhr_unit_featured_pages();?>
          </div>
      <?php } else {
          get_template_part( 'partials/hero', 'slim' );
      } ?>
    </div>

</section>

<?php get_footer(); ?>
