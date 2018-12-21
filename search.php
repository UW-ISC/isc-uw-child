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

		<script type="text/javascript">

			function toggleAll(value){
				$('#all').prop('checked', value);
				
				$('#adminCorner').prop('checked', value);
				$('#userGuide').prop('checked', value);
				$('#news').prop('checked', value);
				$('#glossary').prop('checked', value);
				$('#others').prop('checked', value);

				$("#adminCorner").attr("disabled", value);
				$("#userGuide").attr("disabled", value);
				$("#news").attr("disabled", value);
				$("#glossary").attr("disabled", value);
				$("#others").attr("disabled", value);
			}

			function checkAllState (allBox){
				console.log(allBox);
				if(allBox.checked){
					toggleAll(true);
				}
				else if(! allBox.checked){
					toggleAll(false);
				}
			}
			 $(document).ready( function (){

			 	var i = document.location.href.lastIndexOf('?');
				var types = document.location.href.substr(i+1).replace(/type%5B%5D=/g,'').split('&');
				$('input[name="type[]"]').prop('checked',function(){
					if($.inArray("all",types) !== -1)
					{
						if(this.id !== "all")
						{
							this.setAttribute("disabled", true);
						}
						return true;
					}

				     return  $.inArray(this.value,types) !== -1;
				 });

				$('#all').change(function(){
						checkAllState(this);
					});

				

			 });
		</script>

		<div class="row search-body">
			<div class="col-md-2 filter-panel">
				<form action="" method="get" id="searchResultsFilterForm">
					<h4>Filter Search Results</h4>
					<div class="result-type-list">
						<label>Type</label>
						  <ul class="no-stylist">
						  	<li><input type="checkbox" name="type[]" id="all" value="all"> <label for="all">All</label></li>
						    <li><input type="checkbox" name="type[]" id="adminCorner" value="adminCorner"> <label for="adminCorner">Admin Corner</label></li>
						    <li><input type="checkbox" name="type[]" id="userGuide" value="userGuide"> <label for="userGuide">User Guide</label></li>
						    <li><input type="checkbox" name="type[]" id="news" value="news"> <label for="news">News</label></li>
						    <li><input type="checkbox" name="type[]" id="glossary" value="glossary"><label for="glossary"> Glossary</label></li>
						    <li><input type="checkbox" name="type[]" id="others" value="others"> <label for="others">Other</label></li>
						  </ul>
					  </div>
						<div class="row panel-actions">
							<input type="hidden" name="s" value="<?php echo get_search_query() ?>" >
							<input class="isc-primary-action-btn" type="submit" value="apply">
						</div>
					</form>
			</div>

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

				echo 'Found <b>' . $total_results . '</b> results for "<i>' . $search_query . '</i>"'. get_filter_description();

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
