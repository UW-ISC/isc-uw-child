<?php
/**
 * Fall back template if one is not specified
 * and single.php does not exist
 *
 * @package isc-uw-child
 * @author UW-IT AXDD +parallelpublicworks
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );   ?>

<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<div class="container uw-body">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'index.php' ) ?>

					<h1><?php echo get_the_title( get_option( 'page_for_posts', true ) );?></h1>

					<?php while ( have_posts() ) : the_post(); ?>

						<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h2>
						<div class="update-date"><?php echo get_the_date() ?> </div>
						<div class='post-content'><?php the_excerpt() ?></div>

					<?php endwhile ?>

                    <!-- pagination functions -->
                    <div class="nav-previous alignleft"><?php previous_posts_link( 'Previous' ); ?></div>
                    <div class="nav-next alignright"><?php next_posts_link( 'Next' ); ?></div>

				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
