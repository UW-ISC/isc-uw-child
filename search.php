<?php
/**
 * Unique template for search page
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

				<?php 

				log_to_console( 'search.php' );

				get_search_form();

				?>


				<h1>Search Results</h1>

				<?php

				global $wp_query;
				$search_query = get_search_query();
				$total_results = $wp_query->found_posts;

				echo 'Found <b>' . $total_results . '</b> results for "<i>' . $search_query . '</i>".';

				?>

				<div>

					<?php
					if ( function_exists( 'relevanssi_didyoumean' ) ) {
    				relevanssi_didyoumean( get_search_query(), '<p>Did you mean: ', '</p>', 3 );
					}
					?>

					<?php
					$i = 0;
					$terms = rawurlencode( get_search_query() );
					$url = 'http://www.washington.edu/search/?q=' . $terms;
					if ( have_posts() ) {
						while ( have_posts() ) : the_post();?>
							<div class='search-result'>
								<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h2>
								<?php include( locate_template( 'search-breadcrumbs.php' ) ); ?>
								<div class='post-content'><?php the_excerpt(); ?></div>
							</div>
							<?php
							$i++;
						endwhile;
						if ( $i <= 1 ) {
							$html = "<p class=\'little-results\'>";
							$html .= 'Try searching for ';
							$html .= "<a href ='$url'>'" . get_search_query() . "'</a>";
							$html .= ' across all of the UW for additional results.</p>';
							echo $html;
						}
					} else {
						$html = "<p class=\'no-results\'>";
						$html .= 'Sorry, no results matched your criteria. Try searching for ';
						$html .= "<a href ='$url'>'" . get_search_query() . "'</a>";
						$html .= ' across all of the UW.</p>';
						echo $html;
					} ?>

					<div><?php posts_nav_link( ' ' ); ?></div>

				</div>

			</div>

		</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
