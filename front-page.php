<?php
/**
  * Template Name: Big Hero
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

      <div style="background: gray url('/wp-content/themes/isc-uw-child/assets/img/milky_way.jpg'); min-height:300px;">
          <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <h2>got hr and payroll questions?</h2>
                </div>
                <div class="col-md-4">
                    <h2>shortcuts</h2>
                    <ul>
                        <li><a class="uw-btn" href="#">Call to action</a></li>
                        <li><a class="uw-btn" href="#">Call to action</a></li>
                        <li><a class="uw-btn" href="#">Call to action</a></li>
                        <li><a class="uw-btn" href="#">Call to action</a></li>
                    </ul>
                </div>
            </div>

          </div>
      </div>

      <div id='main_content' class="container uw-body-copy" tabindex="-1">
          <h2>features</h2>
          <div class="row">
              <div class="col-md-4">
                  <h3>feature 1</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                  <p><a class="uw-btn btn-sm" href="#">Smaller Button</a></p>
              </div>
              <div class="col-md-4">
                  <h3>feature 2</h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                   <p><a class="uw-btn btn-sm" href="#">Smaller Button</a></p>
              </div>
              <div class="col-md-4">
                  <h3>feature 3</h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
                   <p><a class="uw-btn btn-sm" href="#">Smaller Button</a></p>
              </div>
          </div>
      </div>

    </div>

</div>

<?php get_footer(); ?>
