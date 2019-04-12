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
	
	the_page_header();
?>
<div role="main">

	<?php uw_site_title(); ?>
	<?php get_template_part( 'menu', 'mobile' ); ?>

	<div class="container uw-body">

	

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

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

</div>

<?php get_footer(); ?>
