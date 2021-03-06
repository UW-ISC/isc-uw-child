<?php
/**
 * Unique template to view article sections that
 * share the same tag
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header(); ?>

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

					<?php log_to_console( 'taxonomy-md-tags.php' ); ?>

					<h1><?php single_term_title() ?></h1>

					<div>
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post(); ?>
								<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h2>
								<div class='post-content'><?php the_excerpt() ?></div>

							<?php endwhile;
						  else :
								echo '<h2 class=\'no-results\'>Sorry, no results matched your criteria.</h2>';
						  endif; ?>

						<div><?php posts_nav_link( ' ' ); ?></div>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
