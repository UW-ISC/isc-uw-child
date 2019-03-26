<?php
/**
 * The template for displaying workday course archive pages
 *
 */

get_header();?>
<div class="uw-body-overlay" hidden >
    <div class="uw-body-overlay-dialog col-md-4" >
        <i class="fa fa-close fa-2x uw-body-overlay-dialog-close"
        onclick="$('.uw-body-overlay').hide()" ></i>
        <h1> Redirecting to an external website...</h1>
        <div class="row">
            <img style="width:200px" class="col-md-5" src="http://localhost/hrp-portal/wp-content/uploads/2019/03/workday-screenshot.png" />
            <p class="col-md-7"> 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nibh ac erat blandit convallis a ac ex. Donec sapien est, rhoncus vel porttitor lobortis, suscipit vel tortor. Fusce luctus sollicitudin justo eget ultrices. Vivamus sapien nunc.
                <a href="www.isc.uw.edu" target="_blank" class="uw-btn uw-body-overlay-primary-action"> take me </a>
            </p>
            
        </div>
        
    </div>
    <div class="uw-body-overlay-mask" onclick="handleMaskClick()">
    </div>
</div>
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
    
    function handleCourseClick(url){
        // console.log("overlay!");
        $('.uw-body-overlay').show();
        $('.uw-body-overlay-dialog').css('top', getCenterY('.uw-body-overlay-dialog') + document.documentElement.scrollTop );
        $('.uw-body-overlay-dialog').css('left', getCenterX('.uw-body-overlay-dialog'));
        $('.uw-body-overlay-primary-action').attr('href', url);
        
    }

    function handleWindowScroll(){
        $('.uw-body-overlay-dialog').css('top', getCenterY('.uw-body-overlay-dialog') + document.documentElement.scrollTop );
    }

    function getCenterX(query){
        let centerX =  Math.floor ( ($( window ).width() - $(query).width() ) / 2);
        return centerX;
    }

    function getCenterY(query){
        let centerY =  Math.floor ( ($( window ).height() - $(query).height() ) / 2);
        return centerY;
    }

    function handleMaskClick(){
        $('.uw-body-overlay').hide();
    }

    window.onload = function (){
            $(window).scroll(handleWindowScroll);
    }
    
    
</script>

<?php get_footer();
