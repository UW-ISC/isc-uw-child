<?php
/**
 * Template used for page if template is not specified
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
	  $sidebar = get_post_meta( $post->ID, 'sidebar' );
?>

<div role="main">

	<?php
		uw_site_title();
		get_template_part( 'menu', 'mobile' );
		the_page_header();
	?>

	<div class="container uw-body">

		<div class="row">

			<div class="uw-content col-md-9">

				<div id='main_content' class="uw-body-copy" tabindex="-1">

					<?php log_to_console( 'single.php' ) ?>

					<div class="post-content">
						<?php
						  
						the_post();

						the_content();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}

						
						?>
					</div>

				</div>
				
				<ul class="isc-news-category-tag-container">
					<label>Categories:</label>
					<?php
						
						$post_categories = get_the_terms(get_the_ID(),'category');
						$site_url = esc_url( get_site_url() );
						
						foreach($post_categories as $category_item){
							$category_item_id = $category_item->term_id;
							echo '<li class="isc-news-category-tag"> <a href="'. get_permalink( get_option( 'page_for_posts' ) ) .'?taxonomy=category&tag_ID='.$category_item_id.'"> '.$category_item->name.' </a> </li>';
						}
					?>
				</ul>

			</div>

		</div>

	</div>

</div>


<?php get_footer(); ?>
