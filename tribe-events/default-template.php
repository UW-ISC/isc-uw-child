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

                xxxx this template uses default-template.php (inside tribe-events directory) xxxx
                <h2>Upcoming Events</h2>

                <div id="tribe-events-pg-template">
                    <ol>
        <?php
        //tribe_get_view();
        //'post_type' => 'tribe_events'

        $args = array(
        'post_type' => 'tribe_events',
        'post_status' => 'publish'
        );
        //if ()
        //log_to_console($events);
        $events = get_posts($args);
        //log_to_console($events);
        if (empty($events)) {
            echo "<div class='col-md-6'>No events found!</div>";
        } else {
            foreach ($events as $event) {
                $title = $event->post_title;
                $html = "<li>";
                $html .= '<h3>' . $title . '</h3>';
                $html .= "<p>" . tribe_get_start_date($event) . "</p>";
                if (tribe_has_venue($event->ID)) {
                    $details = tribe_get_venue_details($event->ID);
                    $html .= "<p>" . $details["linked_name"] . "</p>";
                    $html .= "<p>" . $details["address"] . "</p>";
                } else {
                    $html .= "<p>Location to be determined.</p>";
                }
                $html .= "<p>" . $event->post_content . "</p>";
                         $html .= '<p><a href="' . get_post_permalink($event->ID) . '">read more</a></p>';
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
