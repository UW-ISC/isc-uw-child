<?php get_header();
      $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
      $sidebar = get_post_meta($post->ID, "sidebar");
      $seasonal =  get_post_meta($post->ID); ?>

        <?php uw_site_title(); ?>
        <?php get_template_part('menu', 'mobile'); ?>

<div class="isc-admin-hero">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php the_title(); ?></h2>

                <form role="search" method="get" id="searchform" class="searchform" action="<?php echo get_site_url() ?>">
                    <div>
                        <label class="screen-reader-text" for="s">Search for:</label>
                        <input type="text" value="" name="s" id="s" placeholder="Search for:" autocomplete="off">
                        <input type="submit" id="searchsubmit" value="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-8 uw-content isc-content" role='main'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <h3 class="isc-admin-header">Admins' News</h3>
                <div class="isc-admin-block">

                        <?php

                         $args = array(
                                  'tax_query' => array(
                                      array(
                                          'taxonomy' => 'location',
                                          'field'    => 'slug',
                                          'terms'    => 'admin-corner-news',
                                      ),
                                  ),
                                'post_status' => 'published');
                         $category_posts = new WP_Query($args);

                         if ($category_posts->have_posts()) :
                             while ($category_posts->have_posts()) :
                                 $category_posts->the_post();
                        ?>

                               <h4><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></h4>
                               <div class="update-date"><?php echo get_the_date() ?> </div>
                               <div class='post-content'><?php the_excerpt() ?></div>
                        <?php
                             endwhile;
                            ?>
                            <a class="uw-btn btn-sm" href="<?php echo get_site_url() . '/news'?>">Read older news</a>
                    <?php
                        else:
                            echo "<p>No admin news available.</p>";
                        endif;
                        ?>

                  </div>

              </div>

            </div>

        <div class="col-md-4 uw-sidebar isc-sidebar" role="">

            <h3 class="isc-admin-header">Next Event</h3>
            <div class="contact-widget-inner isc-widget-tan isc-admin-block">
              <div class='post-content isc-events'>
                <?php
                $event = tribe_get_events(
                    array(
                    'posts_per_page' => 1,
                    'start_date' => date('Y-m-d H:i:s')
                    )
                );
                // if $event is an empty array then
                if (empty($event)) {
                    echo "No events found.";
                } else {
                    $current = $event[0];
                    $title = $current->post_title;
                    $html = '<h4><a href="' . get_post_permalink($current->ID) . '">' . $title . '</a> </h4>';
                    $html .= "<div class='event-date'>" . tribe_get_start_date($current) . "</div>";

                    if (tribe_has_venue($current->ID)) {
                        $details = tribe_get_venue_details($current->ID);
                        $html .= "<div class='event-location'><i class='fa fa-map-marker' aria-hidden='true'></i> " . $details["linked_name"];
                        $html .= $details["address"];

                        if (tribe_show_google_map_link($current)){
                            $html .= tribe_get_map_link_html($current);
                        }

                        $html .= "</div>";

                    } else {
                        $html .= "<div class='event-location'>Location: TBD</div>";
                    }
                    $html .= "<div class='event-content'>" . $current->post_excerpt . "</div>";
                    echo $html;
                }
                ?>
                 </div>

                 <a class="uw-btn btn-sm" href="<?php echo get_site_url() . "/events"?>">Upcoming Events</a>
            </div>


            <h3 class="isc-admin-header">Seasonal Topic</h3>
            <div class="contact-widget-inner isc-widget-white isc-admin-block">
                <div class='post-content'>
                    <h4><a href="#">This is a seasonal topic title that links to its itself</a></h4>
                    <div>this is the featured seasonal topic description... Nullam vitae leo sodales ipsum vehicula hendrerit ut porttitor ex. Fusce finibus lectus et enim dapibus, at auctor risus consectetur.</div>
                    <!--<p><?php get_seasonal_description(); ?></p>-->
                </div>
                <a class="uw-btn btn-sm" href="<?php echo get_site_url() . "/seasonal-topics"?>">See all Topics</a>
            </div>

            <h3 class="isc-admin-header">Workday Support</h3>
            <div class="contact-widget-inner isc-widget-gray isc-admin-block">
                    <?php
                    support_quicklinks();
                    ?>
            </div>

            <h3 class="isc-admin-header">Workday Resources</h3>
            <div class="contact-widget-inner isc-widget-white isc-admin-block">
                    <?php
                    resource_quicklinks();
                    ?>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
