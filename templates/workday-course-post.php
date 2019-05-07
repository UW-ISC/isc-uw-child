<?php
/*
 * Template Name: Wokday Course
 * Template Post Type: workday_course
 * 
 * @author Prasad Thakur
 * @package isc-uw-child
 */
  
 get_header();  
 ?>

 <div>
    <script>
        window.onload = function(){
            // window.location.replace("");
            <?php echo get_post_custom_values('course-url')[0];?>
        }
    </script>
    <div class="container uw-body">
        <?php print_workday_course_item(); ?>
    </div>
</div>

<?php get_footer();

 