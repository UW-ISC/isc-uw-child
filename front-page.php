<?php
/**
  * Template Name: Big Hero
  */
?>

<?php get_header();
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


<div class="uw-hero-image hero-height <?php echo $hasmobileimage ?>" style="background-image: url(<?php echo $url ?>);">
    <?php if( !empty($mobileimage) ) { ?>
    <div class="mobile-image" style="background-image: url(<?php echo $mobileimage ?>);"></div>
    <?php } ?>
    <div id="hero-bg">
      <div id="hero-container" class="container">
      <?php if(!empty($banner) && $banner[0]){ ?>
        <div id="hashtag"><span><span><?php echo $banner[0] ? $banner[0] : ''; ?></span></span></div>
      <?php } ?>
        <h1 class="uw-site-title"><?php the_title(); ?></h1>
        <span class="udub-slant"><span></span></span>
      <?php if(!empty($buttontext) && $buttontext[0]){ ?>
        <a class="uw-btn btn-sm btn-none" href="<?php echo $buttonlink[0] ? $buttonlink[0] : ''; ?>"><?php echo $buttontext[0] ? $buttontext[0] : ''; ?></a>
      <?php } ?>
      </div>
    </div>
</div>

<div class="container uw-body">

  <div class="row">

    <div class="hero-content col-md-<?php echo (($sidebar[0]!="on") ? "8" : "12" ) ?> uw-content" role='main'>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>
      <!--<?php get_template_part( 'breadcrumbs' ); ?>-->

      <div id='main_content' class="uw-body-copy" tabindex="-1">

          <h1>Featured stuff</h1>

          <p><?php
              // News Section
              // this query finds all of the posts and lists them based on
              // their publishing date (newest in front)
              $args = array ('numberposts' => 4); // limits only x news posts to display
              $recent_posts = wp_get_recent_posts($args);
              ?>
              <?php $news = wp_get_single_post(960) ?>
              <a href="<?php echo get_page_link($news->ID); ?>">
              <?php echo get_the_title($news->ID); ?></a>
              <?php foreach($recent_posts as $recent) { ?>
                    <a href="<?php echo get_post_permalink($recent['ID']); ?>">
                    <?php echo get_the_title($recent['ID']); ?></a>
                    <?php echo get_the_excerpt($recent['ID']); ?>
            <?php
              }
              wp_reset_query();
            ?>

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
                      <a href="<?php echo get_page_link($page->ID); ?>">
                      <?php echo get_the_title($page->ID); ?></a>
                      <?php echo $summary;
                    }
              }?>
            <?php endif; ?>

          </p>

      </div>

    </div>

  </div>

</div>

<?php get_footer(); ?>
