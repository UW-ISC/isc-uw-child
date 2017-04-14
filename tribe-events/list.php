<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 */

?>
<?php
if (! defined('ABSPATH') ) {
    die('-1');
}

get_header();
?>
<?php uw_site_title(); ?>
<?php get_template_part('menu', 'mobile'); ?>

<div class="container uw-body" role="main">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <div class="uw-content col-md-9'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <?php log_to_console("tribe-events/list.php") ?>

                <h1>Upcoming Events</h1>

                <div id="tribe-events-pg-template" class="isc-events">
                    <ol>
                        <?php
                        //tribe_get_view();
                        //'post_type' => 'tribe_events'

                        $args = array(
                        'post_type' => 'tribe_events',
                        'post_status' => 'publish',
                        'start_date' => date('Y-m-d H:i:s')
                        );

                        $events = tribe_get_events($args);

                        if (empty($events)) {
                            echo "No events found!";
                        } else {
                            foreach ($events as $event) {
                                $title = $event->post_title;
                                $html = "<li>";
                                $html = '<h2><a href="' . get_post_permalink($event->ID) . '">' . $title . '</a> </h2>';
                                $html .= "<div class='event-date'>" . tribe_get_start_date($event) . "</div>";
                                if (tribe_has_venue($event->ID)) {
                                    $details = tribe_get_venue_details($event->ID);
                                    $html .= "<div class='event-location'><i class='fa fa-map-marker' aria-hidden='true'></i> " . $details["linked_name"];
                                    //$html .= $details["address"];
                                    if (tribe_show_google_map_link($event->ID)){
                                        $html .= "<br/>" . tribe_get_map_link_html($event->ID);
                                    }

                                    $html .= "</div>";

                                } else {
                                    $html .= "<div class='event-location'>Location: TBD</div>";
                                }

                                if (has_excerpt($event->ID)) {
                                    $html .= "<div class='event-content'>" . $event->post_excerpt . "</div>";
                                } else {
                                  $html .= "<div class='event-content'>No description found.</div>";
                                }

                                $html .= '<p><a class="more" title="' . $event->post_title . '"href="' . get_post_permalink($event->ID) . '">Read more</a></p>';
                                $html .= "</li>";
                                echo $html;
                            }
                        }
                        ?>
                    </ol>
                </div>

            </div>

        </div>

    </div>

</div>

<?php
get_footer();
?>
