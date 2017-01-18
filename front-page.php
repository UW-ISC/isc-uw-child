<?php
/**
  * Template Name: Front Page
  */
?>

<?php get_header( 'front' );
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      if(!$url){
        $url = get_site_url() . "/wp-content/themes/isc-uw-child/assets/images/milky_way.jpg";
      }
      $mobileimage = get_post_meta($post->ID, "mobileimage");
      $hasmobileimage = '';
      if( !empty($mobileimage) && $mobileimage[0] !== "") {
        $mobileimage = $mobileimage[0];
        $hasmobileimage = 'hero-mobile-image';
      }
      $banner = get_post_meta($post->ID, "banner");
      $buttontext = get_post_meta($post->ID, "buttontext");
      $buttonlink = get_post_meta($post->ID, "buttonlink");   ?>


<div class="uw-body">

    <div class="uw-content" role='main'>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

      <div class="" style="background: gray url(<?php echo $url ?>); min-height:500px; background-size:cover;">
          <div class="container">

            <div class="row">
                <div class="col-md-8">

                    <div style="font-size:65px; color:#fff; font-weight: 900; font-family:'Encode Sans Compressed', sans-serif; text-transform:uppercase; line-height: 60px; margin: 50px 0;">One Place.<br>All your HR &amp; Payroll Questions</div>

                    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_site_url() ?>">
                    	<div>
                    		<label class="screen-reader-text" for="s">Search for:</label>
                    		<input type="text" value="" name="s" id="s" placeholder="Search for:" autocomplete="off">
                    		<input type="submit" id="searchsubmit" value="Search">
                    	</div>
                    </form>

                </div>
                <div class="col-md-4">
                    <h2>shortcuts</h2>
                    <ul>
                        <li><a class="uw-btn" href="#">Sign in to WorkDay</a></li>
                        <li><a class="uw-btn" href="#">Ask for help!</a></li>
                        <li><a class="uw-btn" href="#">Learn about Timesheets</a></li>
                        <li><a class="uw-btn" href="#">New Hires: Stare here!</a></li>
                    </ul>
                </div>
            </div>

          </div>
      </div>

      <div id='main_content' class="container uw-body-copy" tabindex="-1" style="margin-top: -120px;">

          <div class="row">

              <div class="col-md-8">

                  <h2>Featured</h2>

                  <div class="row">
                       <!-- loop featured pages here -->
                       <?php
                       // Featured Pages
                       // this query finds the pages marked featured page and lists their
                       // title as a link, and their summary

                       $args = array(
                        'post_type' => 'page'
                       );
                       $has_pages = get_pages();?>

                       <?php if( $has_pages):
                         foreach($has_pages as $page) {
                           $custom_fields = get_post_custom($page->ID);
                           $featured = $custom_fields["isc-featured"][0];
                           $summary = $custom_fields["summary-text"][0];
                           if ($featured != NULL) { ?>
                                 <div class="col-md-6">
                                     <div style="background: #eee; padding: 20px; margin-bottom:30px;">
                                         <h3>
                                           <a href="<?php echo get_page_link($page->ID); ?>">
                                           <?php echo get_the_title($page->ID); ?></a>
                                         </h3>
                                         <p> <?php echo $summary; ?> </p>
                                         <p><a class="uw-btn btn-sm" href="<?php echo get_page_link($page->ID); ?>">learn more</a></p>
                                     </div>
                                 </div>
                         <?php }
                         }
                       endif; ?>
                       <!-- end loop -->
                  </div>

              </div>
              <div class="col-md-4">
                  <h2>News</h2>
                  <!-- loop news posts here -->

                  <div style="background: #fff; padding: 20px;">
                      <?php
                          $args = array( 'numberposts' => '5' );
                          $recent_posts = wp_get_recent_posts( $args );
                          if(!$recent_posts) { ?>
                              <h3>Oops!</h3>
                              <p>No recent posts found!</p>
                          <?php } else {
                              foreach ($recent_posts as $recent) { ?>
                                  <h3><a href="<?php echo get_post_permalink($recent['ID']); ?>">
                                  <?php echo get_the_title($recent['ID']); ?></a></h3>
                                  <p><?php echo $recent['post_modified_gmt']; ?></p>
                                  <p><?php echo get_the_excerpt($recent['ID']); ?></p>
                                  <p><a href="<?php echo $recent['guid'] ?>">Read more</a></p>
                              <?php }
                          }
                      ?>

                      <p><a class="uw-btn btn-sm" href="#">See all news</a></p>
                  </div>

                  <!-- end loop -->

              </div>
          </div>
      </div>

    </div>

  </div>

<?php get_footer(); ?>
