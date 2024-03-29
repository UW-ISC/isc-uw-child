<?php
/**
 * This template is used to generate the
 * footer on all pages
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

	?>

<div role="contentinfo" class="uw-footer">

	<h2 class="sr-only">Contact Info &amp; Resource Links</h2>

	<a href="http://www.washington.edu" class="footer-wordmark">University of Washington</a>

	<div class="container isc-footer">
		<div class="row">

			<?php $options = get_option( 'isc_footer_fields' );?>

			<!-- Start ISC-40331 Remove Contact Information section from footer -->
			<!-- <div class="col-md-6">
			  <h3>Contact Information</h3>
			  <div class="row  location-container">
			  <div class="col-md-6 map-container">
				 <a href="<?php echo esc_url( $options['map'] ) ?>" title="<?php echo esc_html( $options['location'] ) ?>"><img src="<?php echo esc_url( get_site_url() . '/wp-content/themes/isc-uw-child/assets/images/map.png' ) ?>" alt="Map of ISC location" ></a>
			  </div>
			  <div class="col-md-6">
				<ul class="footer-contact-container">
				  <li><div class="icon-container">
				      <i class="fa fa-map-marker" aria-hidden="true"></i>
				      </div>
				      <div class="text-container"><a href="<?php echo esc_url( $options['map'] ) ?>">   <?php echo esc_html( $options['location'] ) ?></a>
				      </div>
				  </li>
				  <li>
				  	<div class="icon-container"><i class="fa fa-phone-square " aria-hidden="true"></i>
				  	</div>
				  	<div class="text-container"><a href="<?php echo esc_html( 'tel:1-' . $options['phone'] ) ?>"> <?php echo esc_html( $options['phone'] ) ?>   </a>
				  	</div>
				  </li>
				  <li><div class="icon-container icons-stacked"><i class="fa fa-square fa-stack-2x" aria-hidden="true"></i><i class="fa fa-envelope fa-stack-1x" aria-hidden="true"></i>
				  </div>
				  <div class="text-container"><a href="<?php echo esc_url( 'mailto:' . $options['email'] ) ?>"> <?php echo esc_html( $options['email'] ) ?> </a>
				  </div></li>
				</ul>
			  </div>
			  </div>
		    </div> -->
		    <!-- End ISC-40331 Remove Contact Information section from footer -->

			<div style="text-align:center;">
				<span style="padding-right:13px; margin-right:10px;">
				<div class="row">
					<?php
					wp_nav_menu(
						array(
						'theme_location' => 'footer-links',
						'fallback_cb'    => false,
						)
					);
					?>
				</span>
				</div>
			</div>
		</div>
		<div style="text-align:center; font-size:13px;">
			<div><span style="display:inline-block; border-right:solid 1px #999; padding-right:13px; margin-right:10px;"><a href="http://www.washington.edu/online/privacy/" target="_blank">Privacy</a></span> <span><a href="http://www.washington.edu/online/terms/" target="_blank">Terms</a></span></div>
			<div>&copy; <?php echo esc_html( current_time( 'Y' ) ); ?> University of Washington, Seattle, WA</div>
		</div>
	</div>



</div>

</div><!-- #uw-container-inner -->
</div><!-- #uw-container -->

<?php wp_footer(); ?>

</body>
</html>
