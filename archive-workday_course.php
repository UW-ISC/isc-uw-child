<?php
/**
 * The template for displaying workday course archive pages
 *
 */

get_header();?>

<title>
    Workday Course Catalouge
</title>
<div class="container uw-body">
    
    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>


    <div class="row">
        <div class="uw-content col-md-12">
            <div id='main_content' class="uw-body-copy" tabindex="-1">
                
                <header class="page-header">
                    <?php
                       the_archive_title( '<h1 class="page-title">', '</h1>' );

                       $post_args =array(
                        'post_type' => 'workday_course',
                        'posts_per_page' => -1,
                        );

                       ?>
                </header>
                <div class="loader" hidden></div>
                <div class="row" id="courseCatalog">
                    <?php print_workday_course_catalog($post_args); ?>
                </div>
                
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        function handleSubmit(){

            var filter = $('#courseFilterForm');
            $.ajax({
                url:filter.attr('action'),
                data:filter.serialize(),
                type:filter.attr('method'),
                beforeSend:function(xhr){
                    $('.loader').show();
                    $('.div-overlay-white').show();
                },
                success:function(data){
                    $('.loader').hide();
                    $('.div-overlay-white').hide();
                    $('#courseCatalog').html(data);                 
                }
            });
            return false;
        }

        function handleFilterClear(clearButton){
            $(clearButton).hide();
            var termId = clearButton.getAttribute('data-term-id');
            $('#courseFilterForm').find('[value='+ termId +']').prop("checked",false);
            handleCourseFilterChange();
        }

        function handleFilterClearAll(clearAllButton){
            $('#filterStatus').hide();
            $.each($("input[type='checkbox']:checked"),function (){
                $(this).prop("checked",false)
            });
            handleCourseFilterChange();
        }

        function attachAndSubmit(){
            $('#courseFilterForm').submit( handleSubmit );
            $('#courseFilterForm').submit();
        }

        var pageValue = 0;

        function handleNextClick(nextButton){
            // var pageValue = $("[name='page']").attr('value');
            pageValue++;
            $("[name='page']").attr('value',pageValue);
            attachAndSubmit();
        }

        function handlePrevClick(nextButton){
            // var pageValue = $("[name='page']").attr('value');
            pageValue--;
            $("[name='page']").attr('value',pageValue);
            attachAndSubmit();
        }

        function handleCourseFilterChange () {
            pageValue = 0;
            attachAndSubmit();
        }
        
        
    </script>
</div>

<?php get_footer();
