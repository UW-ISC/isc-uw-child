<?php
/**
 * Unique template for search page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header(); ?>

<?php uw_site_title(); ?>
<?php get_template_part( 'menu', 'mobile' ); ?>

<div class="container uw-body" role="main">

	<div class="row">
		<div class="col-md-12">
			<?php get_template_part( 'breadcrumbs' ); ?>
		</div>
	</div>

	<div class="row">

	<div class="uw-content col-md-9">

		<div id='main_content' class="uw-body-copy" tabindex="-1">

			<?php log_to_console( 'search.php' ) ?>

			<h1>Search Results</h1>

			<div>

				<?php
				$i = 0;
				$terms = rawurlencode( get_search_query() );
				$url = 'http://www.washington.edu/search/?q=' . $terms;
				if ( have_posts() ) {
					while ( have_posts() ) : the_post();?>
						<h2><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title() ?></a></h2>
						<div class='post-content'><?php the_excerpt() ?></div>
						<?php
						$i++;
					endwhile;
					if ( $i <= 1 ) {
						$html = "<h2 class=\'little-results\'>";
						$html .= 'Try searching ';
						$html .= "<a href ='$url'>" . get_search_query() . ' on uw.edu</a>';
						$html .= ' for additional results.</h2>';
						echo $html;
					}
				} else {
					$html = "<h2 class=\'no-results\'>";
					$html .= 'Sorry, no results matched your criteria. Try searching ';
					$html .= "<a href ='$url'>" . get_search_query() . ' on uw.edu</a>';
					$html .= ' .</h2>';
					echo $html;
				} ?>

				<div><?php posts_nav_link( ' ' ); ?></div>

			</div>

		</div>

	</div>

	</div>

</div>

<?php get_footer(); ?>
