<?php
/**
  * Template Name: Big Hero
  */
?>

<?php get_header( 'front' );
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      if(!$url){
        $url = get_site_url() . "/wp-content/themes/uw-2014/assets/headers/suzzallo.jpg";
      }
      $mobileimage = get_post_meta($post->ID, "mobileimage");
      $hasmobileimage = '';
      if( !empty($mobileimage) && $mobileimage[0] !== "") {
        $mobileimage = $mobileimage[0];
        $hasmobileimage = 'hero-mobile-image';
      }
      $sidebar = get_post_meta($post->ID, "sidebar");
      $banner = get_post_meta($post->ID, "banner");
      $buttontext = get_post_meta($post->ID, "buttontext");
      $buttonlink = get_post_meta($post->ID, "buttonlink");   ?>


<div class="uw-body isc-body">


  <div class="row">

    <div class="uw-content" role='main'>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

      <div style="background: lime; height: 300px;">
          <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <h2>got hr and payroll questions?</h2>
                </div>
                <div class="col-md-4">
                    <h2>shortcuts</h2>
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
              </div>
              <div class="col-md-4">
                  <h3>feature 2</h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
              </div>
              <div class="col-md-4">
                  <h3>feature 3</h3>
                   <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus turpis vel tincidunt posuere. Morbi in purus eleifend, imperdiet velit vitae, congue metus. Donec suscipit justo orci, ut accumsan massa sagittis ut. Morbi fringilla aliquam nulla in lacinia.</p>
              </div>
          </div>
      </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
