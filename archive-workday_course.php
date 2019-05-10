<?php
/**
 * The template for displaying workday course archive pages
 *
 */

get_header();?>
<div class="full-screen-mask-dark" hidden><div class="lds-dual-ring"></div></div>
<div class="uw-body-overlay" hidden >

    <div class="uw-body-overlay-dialog" >
        <i class="fa fa-close fa-2x uw-body-overlay-dialog-close" onclick="$('.uw-body-overlay').hide()" ></i>
        <div class="uw-body-overlay-dialog-header">
            <h1> Redirecting to Bridge...</h1>
        </div>
        
        <div class="uw-body-overlay-dialog-main">
            <div class="row">
                <?php
                    $img_url = get_media_url_from_title("Workday Redirection Image");
                    $text_col_size = 'col-md-12';
                    if(wp_http_validate_url($img_url)){
                        $text_col_size = 'col-md-6';
                        echo '<img class="col-md-6 uw-body-overlay-dialog-img" src="'.wp_http_validate_url($img_url).'" />';
                    }
                ?>
                <div class="<?php echo $text_col_size ?>"> 
                    <p>You are about to leave the Workday Learning Library for our Learning Management System, Bridge.</p>
                    <ol>
                        <li>Log in to Bridge using your UWNetID and password.</li>
                        <li>If prompted to enroll in the course, select Enroll.</li>
                        <li>Once you are enrolled, you will be able to log in to Bridge at any time to register for live training sessions and access eLearning modules. Bridge will track and save your progress as you complete each course.</li>
                    </ol>
                    <p>Questions, concerns, or feedback?
                    <a href="<?php echo esc_url( get_site_url())?>/contact-us">Contact us</a> with "Training" in the subject.</p>
                </div>
            </div>
        </div>  
        
        <div class="uw-body-overlay-dialog-footer">
            <a href="www.isc.uw.edu" target="_blank" class="uw-btn uw-body-overlay-primary-action"> continue </a>
        </div>
    </div>
    
    <div class="uw-body-overlay-mask" onclick="handleMaskClick()">
    </div>

</div>

<div class="container uw-body">
    
    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>


    <div class="row">
        <div class="uw-content col-md-12">
            <div id='main_content' class="uw-body-copy" tabindex="-1">
                <section>
                    <header class="page-header">
                        <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );

                        $post_args =array(
                            'post_type' => 'workday_course',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            );

                        ?>
                    </header>
                    <p>
                        Use the filters below to find the courses in the library that best suit your needs.<br>
                        <br>
                        For anyone seeking a security role where training is required (HCM Initiate 2, HR Partner, Academic Partner, and/or Time & Absence Initiate), follow these steps using the filters below:
                        <ol>
                            <li>Select the employee population(s) you will support in your new role.</li>
                            <li>Select the name(s) of the security role(s) you are seeking.</li>
                            <li>Complete all Level 1, 2, and 3 courses displayed in order to be eligible. If you have already completed the course(s) for another role, you do not need to retake them.</li>
                        </ol>
                    </p>
                </section>
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
                $('.full-screen-mask-dark').show();
                // $('.div-overlay-white').show();
            },
            success:function(data){
                $('.full-screen-mask-dark').hide();
                // $('.div-overlay-white').hide();
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
        
        $('.uw-body-overlay').show();
        $('.uw-body-overlay-primary-action').attr('href', url);
        
    }

    function handleMaskClick(){
        $('.uw-body-overlay').hide();
    }

    function drawerHandleClick(){
        if($('#drawer').is(':visible')){
            $('#drawer').hide();
        }
        else{
            $('#drawer').show();
        }
    }
</script>

<?php get_footer();
