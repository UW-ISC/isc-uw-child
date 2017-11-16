<?php
/**
 * Unique template for building up the white bar of
 * the header which displays on all pages
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

?>

<header class="uw-thinstrip">

	<div class="container">

		<div class="pull-left isc-logo">
			  <a aria-hidden="true" href="<?php echo esc_url( get_site_url() ); ?>" title="ISC Home"><?php  bloginfo( 'name' ); ?></a>
		</div>

	</div>

	 <div style="position:absolute; right:30px; top: 20px;">
		  <nav class="uw-thin-strip-nav" role='navigation' aria-label='audience based'>
			  <ul class="uw-thin-links">
				<?php
				wp_nav_menu(
					array(
					'theme_location' => 'white-bar-links',
					'fallback_cb'    => false,
					)
				);
				?>
			  </ul>

			  <script>
			  $(function(){
				 $("a:contains('Sign in to Workday')").addClass("work-day-link");
				 $("a:contains('Sign in to Workday')").attr('target', '_blank');
			  });
			  </script>

		  </nav>
		  <nav id='search-quicklinks' role='navigation' aria-label='search and quick links'>
		  <button class='uw-search' aria-owns='uwsearcharea' aria-controls='uwsearcharea' aria-expanded='false' aria-label='open search area' aria-haspopup='true'>
	<!--[if gt IE 8]><!-->
			  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				   width="19px" height="51px" viewBox="0 0 18.776 51.062" enable-background="new 0 0 18.776 51.062" xml:space="preserve" focusable="false">
			  <g>
				  <path fill="#4b2e83" d="M3.537,7.591C3.537,3.405,6.94,0,11.128,0c4.188,0,7.595,3.406,7.595,7.591
					c0,4.187-3.406,7.593-7.595,7.593C6.94,15.185,3.537,11.778,3.537,7.591z M5.245,7.591c0,3.246,2.643,5.885,5.884,5.885
					c3.244,0,5.89-2.64,5.89-5.885c0-3.245-2.646-5.882-5.89-5.882C7.883,1.71,5.245,4.348,5.245,7.591z"/>

				  <rect x="2.418" y="11.445" transform="matrix(0.7066 0.7076 -0.7076 0.7066 11.7842 2.0922)" fill="#4b2e83" width="1.902" height="7.622"/>
			  </g>
			  <path fill="#4b2e83" d="M3.501,47.864c0.19,0.194,0.443,0.29,0.694,0.29c0.251,0,0.502-0.096,0.695-0.29l5.691-5.691l5.692,5.691
				  c0.192,0.194,0.443,0.29,0.695,0.29c0.25,0,0.503-0.096,0.694-0.29c0.385-0.382,0.385-1.003,0-1.388l-5.692-5.691l5.692-5.692
				  c0.385-0.385,0.385-1.005,0-1.388c-0.383-0.385-1.004-0.385-1.389,0l-5.692,5.691L4.89,33.705c-0.385-0.385-1.006-0.385-1.389,0
				  c-0.385,0.383-0.385,1.003,0,1.388l5.692,5.692l-5.692,5.691C3.116,46.861,3.116,47.482,3.501,47.864z"/>
			  </svg>
	<!--<![endif]-->
		  </button>
		  </nav>
	  </div>

</header>

<?php
$alert_args = array(
	'hierarchical' => false,
	'posts_per_page' => '1',
	'post_status'	=> 'publish',
	'meta_key'		=> 'isc_alert',
	'meta_value'    => 1,
);
$alert_news_posts = get_posts( $alert_args );

if ( $alert_news_posts ) :
	$alert_news_post = get_post( $alert_news_posts[0]->ID ) ?>
    <?php setup_postdata( $GLOBALS['post'] =& $alert_news_post ); ?>
	<div id="uwalert-alert-message" class="advisories  uwalert-steel">
		<div class="container">
			<h1><?php echo get_the_title( $alert_news_post ); ?></h1>
			<p></p>
            <?php custom_wp_trim_excerpt(the_excerpt()); ?>
            <?php wp_reset_postdata() ?>
			<p></p>
		</div>
	</div>
<?php endif; ?>
