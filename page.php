<?php
/**
 * Default page template
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

	get_header();
	$url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	$sidebar = get_post_meta( $post->ID, 'sidebar' );
?>
<div role="main">

	<div class="print-only user-guide-print-note">
		<p><strong>Note:</strong> This is a printed version of <?php global $wp; echo home_url( $wp->request )?>. Please visit this page on the ISC website to ensure you're referencing the most current information.</p>
	</div>	

	<?php
		uw_site_title();
		get_template_part( 'menu', 'mobile' );
		the_page_header();
	?>

	<div class="container uw-body">

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

				<script>
						$(document).ready(function() {
							let p_tag = $("div.card-box-33 > div.card-grid-decription > p");
							p_tag.addClass("card-decription-p");
						});
					</script>

					<?php
					log_to_console( 'page.php' );
					
					// Start the Loop.
					while ( have_posts() ){
						the_post();
						the_content();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							  comments_template();
						}

					}
					?>

				</div>

			</div>
			
			
			<?php
				$show_right_sidebar = get_post_meta( $post->ID, 'show_right_sidebar',true);
				$right_side_bar = '';
				$side_bar_title = get_post_meta( $post->ID, 'sidebar_title',true);

				if($show_right_sidebar == 'Yes'){
				$right_side_bar = get_post_meta( $post->ID, 'custom_html',true);
				echo '<div class="col-md-3 isc-dark-grey default-page-right-sidebar">';
					if(isset($side_bar_title)){
						echo '<h2 class="isc-right-sidebar-title">'.$side_bar_title.'</h2>';
					}
					echo $right_side_bar;
				echo '</div>';
				}
			?>
			

		</div>

	</div>

	<script>
		$(document).keydown(function(event){
			// cntrl-f or command-f
				if((event.ctrlKey || event.metaKey) && event.which == 70) {
					$(".collapse.isc-expander-content").attr( "aria-expanded", "true" );
					$(".collapse.isc-expander-content").removeClass( "collapse" );

				};
			});
	</script>
</div>

<?php get_footer(); ?>
