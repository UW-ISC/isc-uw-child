<div role="contentinfo" class="uw-footer">

    <h2 class="sr-only">Contact Info &amp; Resource Links</h2>

    <a href="http://www.washington.edu" class="footer-wordmark">University of Washington</a>

    <div class="container isc-footer">
        <div class="row">

            <div class="col-md-5">
              <h3>Contact Information</h3>
              <div class="row  location-container">
              <div class="col-md-6 map-container">
                 <a href="https://goo.gl/maps/koRTixJW8D62" title="ISC location (Google Maps)"><img src="<?php echo get_site_url() . '/wp-content/themes//isc-uw-child/assets/images/map.png'?>" alt="Map of ISC location" ></a>
              </div>
              <div class="col-md-6">
                <ul class="footer-contact-container">
                  <?php $options = get_option("isc_footer_fields"); ?>
                  <li><div class="icon-container"><i class="fa fa-map-marker" aria-hidden="true"></i></div><div class="text-container location-text"><a href="<?php echo $options['map'] ?>">   <?php echo $options['location'] ?></a></div></li>
                  <li><div class="icon-container"><i class="fa fa-phone-square " aria-hidden="true"></i></div><div class="text-container"><a href="<?php echo "tel:1-". $options['phone'] ?>"> <?php echo $options['phone'] ?>   </a></div></li>
                  <li><div class="icon-container icons-stacked"><i class="fa fa-square fa-stack-2x" aria-hidden="true"></i><i class="fa fa-envelope fa-stack-1x" aria-hidden="true"></i></div><div class="text-container"><a href="<?php echo "mailto:" . $options['email'] ?>"> <?php echo $options['email']?> </a></div></li>
                </ul>
              </div>
            </div>
          </div>

            <div class="col-md-7">
                <div class="row">
                  <?php
                  wp_nav_menu(
                    array(
                      'theme_location' => 'footer-links',
                      'fallback_cb'    => false
                    )
                  );
                  ?>

                  <!--
                    <div class="col-md-4">
                        <h3>HR Resources</h3>
                        <ul>
                          <li> <a href="">Forms</a> </li>
                          <li> <a href="">Policies</a> </li>
                          <li> <a href="">Workday FAQ</a> </li>
                          <li> <a href="">Administrator's Corner</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>HR Departments</h3>
                        <ul>
                          <li> <a href="http://hr.uw.edu/">UW HR</a> </li>
                          <li> <a href="http://f2.washington.edu/fm/payroll/home">Payroll</a> </li>
                          <li> <a href="https://ap.washington.edu/ahr/">Academic HR</a> </li>
                          <li> <a href="http://www.uwmedicine.org/uw-medical-center">UW MC</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>UW Resources</h3>
                        <ul>
                          <li> <a href="https://www.washington.edu/uwit/">UW IT</a> </li>
                          <li> <a href="https://www.washington.edu/facilities/transportation/">UW Transportation</a> </li>
                          <li> <a href="http://www.lib.washington.edu/">UW Libraries</a> </li>
                          <li> <a href="https://www.washington.edu/ombud/">Office of the Ombud</a> </li>
                          <li> <a href="http://depts.washington.edu/safecamp/">SafeCampus</a> </li>
                          <li> <a href="http://hr.uw.edu/jobs/">Employment at UW</a> </li>
                          <li> <a href="https://my.uw.edu/">MyUW</a> </li>
                        </ul>
                </div>
              -->
                </div>


            </div>
        </div>
    </div>

    <p>&copy; <?php echo date("Y"); ?> University of Washington  |  Seattle, WA</p>

</div>

</div><!-- #uw-container-inner -->
</div><!-- #uw-container -->

<?php wp_footer(); ?>

</body>
</html>
