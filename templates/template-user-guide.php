<?php
/**
 * Template Name: User Guide
 *
 * Template that displays a user guide (step by step tutorials)
 * additionally with a table of contents automatically generated
 * from the headers
 *
 * @author UW-IT AXDD
 * @package isc-uw-child
 */

get_header();
?>

<div role="main">

    <?php uw_site_title(); ?>
    <?php get_template_part( 'menu', 'mobile' ); ?>

    <section class="uw-body container" id="toc">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>

		<div class="row">

			<div class="col-md-3">
				<?php isc_user_guide_menu(); ?>
			</div>

			<article class="uw-content float-content col-md-9 isc-user-guide" id="main_content">

				<?php log_to_console( 'template-user-guide.php' ) ?>
				<?php
				while ( have_posts() ) : the_post();
					isc_title();
					the_content();
				endwhile
				?>
			</article>

			<script>
			$(function(){
				$('.isc-user-guide table').each(function() {
					// add responsive table class and clear all other inline styles
					$(this).addClass("table-responsive");
					$(this).addClass("table-condensed");
					$(this).removeProp("style");

					// clean each td by removing all inline styles
					$("td").each(function() {
						$(this).removeProp("style");
					});

					// set img widths (inside of table tds)
					$("td img").each(function() {
						//$(this).removeProp("width");
						$(this).attr('width', '100%');
						$(this).removeProp("height");
					});
				});

				// collapse-o-matic plugin overrides
				$(".isc-expand").before( "<div class='isc-collapse'><a href='#' onclick='return false;' class='collapseall' title='Hide all collapsible page content' role='button'>Collapse All</a><a href='#' onclick='return false;' class='expandall' style='display:none;' title='Show all hidden page content' role='button'>Expand All</a></div>" );

                // set initial aria state
				$(".collapseomatic").each(function() {
					// add a11y stuff
					$(this).attr('role', 'button');
					$(this).attr('aria-controls', 'target-' + $(this).attr('id'));

                    // if expanded (colomat-close)... set to true, else false
                    if ($( this).hasClass( "colomat-close" ) ) {
                        $(this).attr('aria-expanded', 'true');
                    }
                    else {
                        $(this).attr('aria-expanded', 'false');
                    }

				});


				// update state when clicked

				$(".collapseomatic").on( "click", function() {


                    if ($( this).hasClass( "colomat-close" ) ) {

                        console.log("going to close");
                        $(this).attr('aria-expanded', 'false');
                    }
                    else {
                        console.log("going to open");
                        $(this).attr('aria-expanded', 'true');
                    }


				});


                $(".isc-expand a").on( "show", function() {
                    console.log("sadhfkjasdlfj");
                    $(this).attr('aria-expanded', 'true');
                });


				// handle expandall and collapseall
				$(".collapseall").on( "click", function() {
					$(".collapseall").hide();
					$(".expandall").show();
					$(".collapseomatic").attr('aria-expanded', 'false');

				});

				$(".expandall").on( "click", function() {
					$(".expandall").hide();
					$(".collapseall").show();
					$(".collapseomatic").attr('aria-expanded', 'true');
				});

			});

			$(document).on("keydown", function(e){
				// cntrl-f or command-f
				if((event.ctrlKey || event.metaKey) && event.which == 70) {
					$('.uw-accordion-shortcode__header').attr( "aria-expanded", "true" );
					$('.uw-accordion-shortcode__panel').attr( "aria-hidden", "false" );
					$('.uw-accordion-shortcode__title').hide();
					$('.uw-accordion-shortcode__title').attr( "aria-hidden", "true" );
				};
			});

			</script>

		</div>

    </section>

</div>

<?php get_footer();
