<?php
/**
  * Template Name: Front Page
  */
?>

<?php get_header( 'front' );
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      if(!$url){
        $url = get_site_url() . "/wp-content/themes/isc-uw-child/assets/images/2759302071_d8cb576f9e_o.jpg";
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

      <div class="" style="background: gray url(<?php echo $url ?>); min-height:530px; background-size:cover; background-position:center center;">
          <div class="container">

            <div class="row">
                <div class="col-md-8">

                    <h2>Search</h2>
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
                    <h2>quicklinks</h2>
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

                  <h2>Featured articles</h2>

                  <div class="row">
                       <!-- loop -->
                       <?php
                       // Featured Pages
                       // this query finds the pages marked featured page and lists their
                       // title and summary on a card
                       $args = array(
                         'post_type'	=> 'page',
                         'meta_key'		=> 'isc-featured',
                         'meta_value'	=> 'YES'
                      );
                      ?>

                      <?php
                      $featured = get_pages( $args );

                      if (!$featured) {
                        echo "No featured pages found!";
                      } else {
                        foreach ($featured as $featured_page) { ?>
                          <div class="col-md-6">
                            <div style="background: #eee; padding: 20px; margin-bottom:30px;">

                              <h3>
                                <a href="<?php echo get_permalink($featured_page->ID); ?>">
                                <?php echo get_the_title($featured_page->ID); ?></a>
                              </h3>

                              <?php
                                $custom = get_post_custom($featured_page->ID);
                                $summary = $custom["summary-text"][0];
                              ?>

                              <p> <?php echo $summary; ?> </p>
                              <p><a class="uw-btn btn-sm" href="<?php echo get_page_link($page->ID); ?>">learn more</a></p>

                            </div>
                        </div>
                          <?php
                        }
                      }
                      ?>

                  </div>

              </div>
              <div class="col-md-4">
                  <h2>News &amp; Events</h2>

                  <!-- loop news posts here
                        Gets numberposts of the posts that have been
                        published, and have their location set to homepage
                  -->

                  <div style="background: #fff; padding: 20px; -webkit-box-shadow: 0 0 4px rgba(164,164,164,.5); box-shadow: 0 0 4px rgba(164,164,164,.5);">
                      <?php

                       $args = array(
                              'numberposts' => '5',
                              'post_status' => 'publish',
                              'tax_query' => array(
                                array(
                                  'taxonomy' => 'location',
                                  'field'    => 'slug',
                                  'terms'    => 'homepage',
                                ),
                              ),);
                       $news_posts = new WP_Query($args);

                       if($news_posts->have_posts()) :
                          while($news_posts->have_posts()) :
                             $news_posts->the_post();
                             ?>

                             <h3>
                               <a href="<?php echo get_post_permalink($recent['ID']); ?>">
                               <?php echo the_title(); ?></a>
                             </h3>
                             <p>
                             <?php echo get_the_date() ?>
                             <p><?php echo
                             the_excerpt() ?></p>
                           </p>

                    <?php
                          endwhile;
                      else:
                        echo "No news posts found.";
                      endif;
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
