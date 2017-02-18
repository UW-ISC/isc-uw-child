<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version  4.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

get_header();
?>
<?php uw_site_title(); ?>
<?php get_template_part('menu', 'mobile'); ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <div class="uw-content col-md-9 " role='main'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <?php log_to_console("tribe-events/single-event.php") ?>

                <div id="tribe-events-content" class="isc-events">

                    <?php

                        $current = tribe_events_get_event();
                        $title = $current->post_title;
                        $html = '<h2>' . $title . '</h2>';
                        $html .= "<div class='event-date'>" . tribe_get_start_date($current) . "</div>";
                        if (tribe_has_venue($current->ID)) {
                            $details = tribe_get_venue_details($current->ID);
                            $html .= "<div class='event-location'><i class='fa fa-map-marker' aria-hidden='true'></i> " . $details["linked_name"];
                            //$html .= $details["address"];
                            if (tribe_show_google_map_link($current->ID)){
                                $html .= "<br/>" . tribe_get_map_link_html($current->ID);
                            }
                            $html .= "</div>";
                        } else {
                            $html .= "<div class='event-location'>Location : TBD</div>";
                        }
                        $html .= "<div class='event-content'>" . $current->post_content . "</div>";
                        echo $html;

                    ?>

                </div><!-- #tribe-events-content -->

            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
