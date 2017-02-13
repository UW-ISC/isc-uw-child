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

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

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

                xxxx this is tribe-events/single-event.php xxxx

                <div id="tribe-events-content" class="tribe-events-single">



                	<!-- Notices -->
                	<?php tribe_the_notices() ?>

                	<?php the_title( '<h2 class="tribe-events-single-event-title">', '</h2>' ); ?>

                	<div class="tribe-events-schedule tribe-clearfix">
                		<?php echo tribe_events_event_schedule_details( $event_id, '<h3>', '</h3>' ); ?>
                		<?php if ( tribe_get_cost() ) : ?>
                			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
                		<?php endif; ?>
                	</div>

                	<?php while ( have_posts() ) :  the_post(); ?>
                		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                			<!-- Event featured image, but exclude link -->
                			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

                			<!-- Event content -->
                			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                			<div class="tribe-events-single-event-description tribe-events-content">
                				<?php the_content(); ?>
                			</div>

                			<!-- Event meta -->
                			<?php tribe_get_template_part( 'modules/meta' ); ?>

                		</div> <!-- #post-x -->
                	<?php endwhile; ?>


                </div><!-- #tribe-events-content -->

            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
