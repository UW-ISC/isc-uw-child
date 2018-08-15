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

<div class="container uw-body" role="main">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part('breadcrumbs'); ?>
        </div>
    </div>

    <div class="row">

        <div class="uw-content col-md-9">

            <div id='main_content' class="uw-body-copy" tabindex="-1">

                <?php log_to_console("tribe-events/single-event.php") ?>

                <div id="tribe-events-content" class="isc-events">

		<?php if(have_posts()) {
			while ( have_posts() ) {
				the_post();
				$event_id = get_the_ID();
				$html = isc_title();
				$html = the_modified_date('l, F j, Y', '<div class="isc-updated-date">Last updated ', '</div>');
				$html .= "<div class='event-date'>" . tribe_get_start_date($event_id) . "</div>";
				if (tribe_has_venue($event_id)) {
					$details = tribe_get_venue_details($event_id);
					$html .= "<div class='event-location'><i class='fa fa-map-marker' aria-hidden='true'></i> " . $details["linked_name"];
					if (tribe_show_google_map_link($event_id)){
						$html .= "<br/>" . tribe_get_map_link_html($event_id);
					}
					$html .= "</div>";
				} else {
					$html .= "<div class='event-location'>Location : TBD</div>";
				}
				$html .= "<div class='event-content'>";
				echo $html;
				the_content();
				echo "</div>";
			}
		}?>
                </div>

            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
