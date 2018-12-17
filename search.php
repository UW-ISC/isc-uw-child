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

		<div class="row search-body">
		<div class="col-md-2 filter-panel">
			<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="searchResultsFilterForm">
			<h4>Filter Search Results</h4>
			<div class="result-type-list">
				<label>Type</label>
				  <ul class="no-stylist">
				  	<li><input type="checkbox" name="all" id="all" autocomplete="off"> <label for="all">All</label></li>
				    <li><input type="checkbox" name="adminCorner" id="adminCorner" autocomplete="off"> <label for="adminCorner">Admin Corner</label></li>
				    <li><input type="checkbox" name="userGuide" id="userGuide" autocomplete="off"> <label for="userGuide">User Guide</label></li>
				    <li><input type="checkbox" name="news" id="news" autocomplete="off"> <label for="news">News</label></li>
				    <li><input type="checkbox" name="glossary" id="glossary" autocomplete="off"><label for="glossary"> Glossary</label></li>
				    <li><input type="checkbox" name="others" id="others" autocomplete="off"> <label for="others">Other</label></li>
				  </ul>
			  </div>
			  
				<div class="row panel-actions">
					<button class="isc-primary-action-btn">apply</button>
					<input type="hidden" name="action" value="searchResultFilter">
					<input type="hidden" name="query" value="<?php echo get_search_query() ?>">
				</div>
			</form>
			</div>
			<script type="text/javascript">
				

				jQuery(function($){
					$('#all').change(function(){
						if(this.checked){
							$('#all').prop('checked', true);
							
							$('#adminCorner').prop('checked', true);
							$('#userGuide').prop('checked', true);
							$('#news').prop('checked', true);
							$('#glossary').prop('checked', true);
							$('#others').prop('checked', true);

							$("#adminCorner").attr("disabled", true);
							$("#userGuide").attr("disabled", true);
							$("#news").attr("disabled", true);
							$("#glossary").attr("disabled", true);
							$("#others").attr("disabled", true);
						}
						else if(! this.checked){
							
							$('#all').prop('checked', false);
							
							$('#adminCorner').prop('checked', false);
							$('#userGuide').prop('checked', false);
							$('#news').prop('checked', false);
							$('#glossary').prop('checked', false);
							$('#others').prop('checked', false);

							$("#adminCorner").attr("disabled", false);
							$("#userGuide").attr("disabled", false);
							$("#news").attr("disabled", false);
							$("#glossary").attr("disabled", false);
							$("#others").attr("disabled", false);
						}
					});



					$('#searchResultsFilterForm').submit(function(){
						var filter = $('#searchResultsFilterForm');
						$.ajax({
							url:filter.attr('action'),
							data:filter.serialize(), // form data
							type:filter.attr('method'), // POST
							beforeSend:function(xhr){
								filter.find('button').text('wait...'); // changing the button label
							},
							success:function(data){
								filter.find('button').text('filter'); // changing the button label back
								$('#response').html(data); // insert data
							}
						});
						return false;
					});
				});
			</script>
			
		<div class="uw-content col-md-10">

			<div id='main_content' class="uw-body-copy" tabindex="-1">

				<?php 

				log_to_console( 'search.php' );

				get_search_form();

				?>
				<div class="filter-title">
					<h1>Search Results</h1>
				</div>

				<div id="response">
					<?php relevanssi_search_results(get_search_query(),'')?>
				</div>
				
			</div>

		</div>

		</div>

	</div>

</div>

<?php get_footer(); ?>
