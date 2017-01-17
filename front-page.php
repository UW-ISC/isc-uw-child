<?php
/**
  * Template Name: Front Page
  */
?>

<?php get_header( 'front' );
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      if(!$url){
        $url = get_site_url() . "/wp-content/themes/isc-uw-child/assets/img/milky_way.jpg";
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

      <div style="background: gray url(<?php echo $url ?>); min-height:500px;">
          <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <h2 style="font-size:50px; font-family: "Encode Sans Compressed", sans-serif;">One Place.<br>All your HR &amp; Payroll Questions</h2>
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

                  <h2>features</h2>

                  <div class="row">
                       <!-- loop featured pages here -->
                       <div class="col-md-6">
                           <div style="background: #eee; padding: 20px; margin-bottom:30px;">
                               <h3>feature 1</h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                               <p><a class="uw-btn btn-sm" href="#">learn more</a></p>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div style="background: #eee; padding: 20px; margin-bottom:30px;">
                               <h3>feature 1</h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                               <p><a class="uw-btn btn-sm" href="#">learn more</a></p>
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div style="background: #eee; padding: 20px; margin-bottom:30px;">
                               <h3>feature 1</h3>
                               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                               <p><a class="uw-btn btn-sm" href="#">learn more</a></p>
                           </div>
                       </div>
                       <!-- end loop -->
                  </div>

              </div>
              <div class="col-md-4">
                  <h2>news</h2>

                  <!-- loop featured pages here -->
                  <div style="background: #fff; padding: 20px;">
                      <?php
                          $args = array( 'numberposts' => '2' );
                          $recent_posts = wp_get_recent_posts( $args );
                          if(!$recent_posts) { ?>
                              <h3>Oops!</h3>
                              <p>No recent posts found!</p>
                          <?php } else {
                              foreach ($recent_posts as $recent) { ?>
                                  <h3><?php echo $recent['post_title'] ?></h3>
                                  <p><?php echo $recent['post_modified_gmt'] ?></p>
                                  <p><?php echo $recent['post_content'] ?></p>
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
