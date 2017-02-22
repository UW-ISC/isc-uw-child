<?php get_header('front');
  $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
if(!$url) {
  $url = get_site_url() . "/wp-content/themes/isc-uw-child/assets/images/service-team_final.jpg";
}
$mobileimage = get_post_meta($post->ID, "mobileimage");
$hasmobileimage = '';
if(!empty($mobileimage) && $mobileimage[0] !== "") {
    $mobileimage = $mobileimage[0];
    $hasmobileimage = 'hero-mobile-image';
}
$banner = get_post_meta($post->ID, "banner");
$buttontext = get_post_meta($post->ID, "buttontext");
$buttonlink = get_post_meta($post->ID, "buttonlink");   ?>

<div class="uw-body" style="padding:0;">

  <div class="uw-content" role='main'>

    <?php uw_site_title(); ?>
    <?php get_template_part('menu', 'mobile'); ?>

      <div class="isc-homepage-hero" style="background-image: url('<?php echo $url;?>');">
          <div class="container">
            <div class="row">
                <div class="col-md-6" style="display:none;" aria-hidden="true">
                    <?php $custom = get_post_meta(get_the_ID());?>
                    <div class="isc-homepage-title"> <?php //echo $custom["isc-hero-title"][0]?></div>
                    <span class="udub-slant"><span></span></span>
                    <div style="margin-bottom:2em;"> <?php //echo $custom["isc-hero-description"][0]; ?></div>
                    <p><a class="uw-btn" href="<?php //echo $custom["isc-hero-link-url"][0]; ?>"><?php //echo $custom["isc-hero-link-text"][0];?></a></p>
                </div>
                <div class="col-md-4 col-md-offset-8">


                    <div class="isc-homepage-shortcuts hero-header-container">
                        <div class="isc-homepage-title"><?php the_title(); ?></div>
                        <span class="udub-slant"><span></span></span>

                        <h2 class="sr-only">Quicklinks</h2>
                        <ul>
                            <li><a class="btn-sm uw-btn isc-btn-workday" target="_blank" href="https://wd5.myworkday.com/uw/login.htmld">Sign in to Workday</a></li>
                            <?php
                            isc_front_get_quicklinks();
                             ?>
                        </ul>

                    </div>

                </div>
            </div>
        </div>
      </div>

      <div id='main_content' class="container uw-body-copy isc-homepage-body" tabindex="-1">

          <div class="row">

              <div class="col-md-8 isc-homepage-featured">

                  <div class="row">

                       <h2 class="col-md-12">Featured articles</h2>
                        <?php
                        // Featured Pages
                        // Query finds the published pages marked featured page and lists their
                        // title and description on a card
                        $args = array(
                         'hierarchical' => false,
                         'post_type'    => 'page',
                         'post_status' => 'publish',
                         'meta_key'        => 'isc-featured',
                         'meta_value'    => 'Homepage'
                        );

                        $featured = get_pages($args);

                        if (!$featured) {
                            echo "<div class='col-md-6'>No featured pages found!</div>";
                        } else {
                            foreach ($featured as $featured_page) { ?>
                                <div class="col-md-6">
                                  <div class="isc-homepage-card">
                                      <div style="margin:-40px; height:160px; overflow:hidden; margin-bottom:30px;">
                                            <?php
                                            $custom = get_post_custom($featured_page->ID);
                                            if (has_post_thumbnail($featured_page->ID)) {
                                                $image = get_the_post_thumbnail_url($featured_page->ID);
                                            ?>
                                            <img alt="" class="" src="<?php echo $image; ?>">
                                            <?php
                                            } else {
                                                //default image
                                            ?>
                                            <img alt="" class="" src="<?php echo get_site_url() . '/wp-content/themes/isc-uw-child/assets/images/john_Vidale-1022-X3.jpg';?>">
                                            <?php
                                            }
                                            ?>
                                       </div>

                                    <h3>
                                      <a href="<?php echo get_permalink($featured_page->ID); ?>">
                                        <?php echo get_the_title($featured_page->ID); ?></a>
                                    </h3>
                                    <?php
                                    $description = $custom["isc-featured-description"][0];
                                    if ($description == "") {
                                        $description = "[No description found]";
                                    }
                                    if (array_key_exists("cta", $custom)) {
                                        $description_text = $custom["cta"][0];
                                        if ($description_text == "") {
                                            $description_text = "Learn More";
                                        }
                                    } else {
                                        $description_text = "Learn More";
                                    }
                                    ?>
                                    <p class="isc-homepage-excerpt"><?php echo $description; ?></p>
                                    <p><a class="uw-btn btn-sm" href="<?php echo get_permalink($featured_page->ID); ?>"><?php echo $description_text; ?></a></p>

                                  </div>
                              </div>
                                <?php
                            }
                        }
                        ?>

                        <script>
                            $(function(){
                                $('.isc-homepage-excerpt').succinct({
                                    size: 200
                                });
                            });
                        </script>

                    </div>

              </div>
              <div class="col-md-4 isc-homepage-news">
                  <h2>News</h2>

                  <!-- loop news posts here
                        Gets numberposts of the posts that have been
                        published, and have their location set to homepage
                  -->

                  <div class="isc-homepage-news-content">
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
                                <div class="update-date"><?php echo get_the_date() ?></div>
                                <div class="post-content"><?php echo the_content() ?></div>
                                <p><a class="more" href="">Read more</a></p>
                        <?php
                            endwhile;
                      else:
                            echo "No news posts found.";
                      endif;
                    ?>
                      <div><a class="uw-btn btn-sm" href="<?php echo get_site_url() . '/news'?>">See all news</a></div>

                      <script>
                          $(function(){
                              $('.isc-homepage-news-content .post-content').succinct({
                                  size: 300
                              });
                          });
                      </script>

                  </div>

                  <!-- end loop -->

              </div>
          </div>
      </div>

    </div>

  </div>

<?php get_footer(); ?>
