<?php
/**
 * Template for the Blog Posts Index page (news in ISC's case) to list the post items.
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
$url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$sidebar = get_post_meta($post->ID, 'sidebar');
?>

<div role="main">
	<div class="full-screen-mask-dark" hidden>
		<div class="lds-dual-ring"></div>
	</div>

	
	<?php
		$post_type = get_post_type_object( get_post_type() );

		if(isset($post_type->labels->blog_display)){
			$page_title = $post_type->labels->blog_display;
		}
		else{
			$page_title = get_the_title(get_option('page_for_posts', true));
		}
		uw_site_title();
		get_template_part( 'menu', 'mobile' );
		the_page_header([
			'use_date' => false,
			'title' =>  $page_title
		]);
	?>

	<div class="container uw-body">
		
		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console('home.php'); ?>

					<form method="GET" id="filter" style="margin-bottom:15px">
						<input type="hidden" name="taxonomy" value="category">
						<label for="categorySelectInput">Filter News Posts:</label>
						<?php
							if ($terms = get_terms('category', 'orderby=name')) {
								echo '<select class="isc-select" id="categorySelectInput" name="tag_ID"><option value="select" hidden>Select category...</option>';

								foreach ($terms as $term) {
									echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
								}
								echo '</select>';
							}
						?>
						<button hidden="true" class ="isc-border-less-button" id="clearFilter" onclick="clearCategoryFilter();"> <i class="fa fa-close isc-btn-icon"></i> clear filter</button>
					</form>

					<script type="text/javascript">
							clearCategoryFilter = function(){
								$('#clearFilter').hide();
								var firstPage = window.location.href.replace(/news.*/g,'news');
								var form = $('#filter');
								form.attr('action', firstPage);
								$('#categorySelectInput').val('select');
								$('.full-screen-mask-dark').show();
								$('#filter').submit();

							}
							window.onload = function(){
								var urlString = window.location.href;
								var queryParams = 'taxonomy=category&tag_ID=';
								var queryEndLocation = urlString.indexOf(queryParams);
								if( queryEndLocation != -1){
									var tagIDValue = urlString.split(queryParams)[1];
									if(Number.isInteger(Number.parseInt(tagIDValue))){
										$('#categorySelectInput').val(tagIDValue);
										$('#clearFilter').show();
									}
								}

								$('.nav-previous').click(function(){
									$('.full-screen-mask-dark').show();
								})

								$('.nav-next').click(function(){
									$('.full-screen-mask-dark').show();
								})

								$('.isc-news-category-tag').click(function(){
									$('.full-screen-mask-dark').show();
								})
							}

							jQuery(function($){
								$('#categorySelectInput').change(function(){
									var firstPage = window.location.href.replace(/page.*\?/g,'?');
									var form = $('#filter');
									form.attr('action', firstPage);
									$('.full-screen-mask-dark').show();
									$('#filter').submit();
								});
						});
						</script>

					<div id="newsPosts">

						<?php
							$category_id = $_GET['tag_ID'];

							if ($category_id == 'select' || $category_id == '') {
								print_news();
							} else {
								$args = array(
									'posts_per_page' => '10',
									'tax_query' => array(
										array(
											'taxonomy' => 'category',
											'field' => 'term_id',
											'terms' => $category_id,
										),
									),
								);
								$args['paged'] = get_query_var('paged') ? get_query_var('paged') : 1;
								$query = new WP_Query($args);

								$temp_query = $wp_query;
								$wp_query = null;
								$wp_query = $query;

								print_news($query);

								wp_reset_postdata();

							}

						?>

					</div>
                    <!-- pagination functions -->
                    <div class="nav-previous alignleft"><?php previous_posts_link('Previous');?></div>
					<div class="nav-next alignright"><?php next_posts_link('Next', $query ? $query->max_num_pages : '');?></div>

					<?php
					if ($category_id != 'select' && $category_id != '') 
						{
							$wp_query = null;
							$wp_query = $temp_query;
						}
					?>

				</div>

			</div>

		</div>

	</div>

</div>

<?php get_footer();?>
