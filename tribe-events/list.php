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

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <div class="uw-content col-md-9 " role='main'>

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                xxxx this template uses tribe-events/list.php xxxx


                <?php
                if( tribe_is_event() && is_single() ) { // Single Events
                    echo '<h2>Name of Event Goes Here</h2>';
                }
                else {
                    echo '<h2>Upcoming Events</h2>';
                }
                ?>

                <div id="tribe-events-pg-template" class="isc-events">
                    <ol>
                        <?php
                        //tribe_get_view();
                        //'post_type' => 'tribe_events'

                        $args = array(
                        'post_type' => 'tribe_events',
                        'post_status' => 'publish'
                        );

                        $events = get_posts($args);

                        if (empty($events)) {
                            echo "<div class='col-md-6'>No events found!</div>";
                        } else {
                            foreach ($events as $event) {
                                $title = $event->post_title;
                                $html = "<li>";
                                $html .= '<h3>' . $title . '</h3>';
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
                                //$html .= "<div class='event-content'>" . $event->post_content . "</div>";
                                $html .= "<div class='event-content'>" . $event->post_excerpt . "</div>";
                                $html .= '<p><a class="more" href="' . get_post_permalink($event->ID) . '">read more</a></p>';
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
