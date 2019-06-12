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
                    <?php echo get_site_option_value('workday_learning_library_redirection_message','',true); ?>
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

<?php
		uw_site_title();
        get_template_part( 'menu', 'mobile' );
		the_page_header([
            'title' => get_the_archive_title(),
            'use_date' => false,
            'breadcrumbs_options' => array(
                'insert_after_root' => true,
                'type' => 'relative',
                'trail' => array(
                    'Support Resources' => 'support-resources',
                    'Workday Training' => 'support-resources/workday-training',
                )
            )
        ]);
	?>

<div class="container uw-body">
    <div class="row">
        <div class="uw-content col-md-12">
            <div id='main_content' class="uw-body-copy" tabindex="-1">
                <section>
                    <header class="isc-page-header">
                        <?php

                        //Support for URL based filtering.
                        $valid_params = get_filter_order();
                        $filter_param_array = array();

                        //for each valid taxonomy item
                        foreach($valid_params as $param_name){

                            //check if url has this taxonomy item and get its term slugs
                            $term_slugs = get_if_exists('_'.$param_name, $_GET, array());
                            $filter_param_values = array();

                            foreach($term_slugs as $term_slug){
                                $term_obj = get_term_by('slug',$term_slug, $param_name, OBJECT);
                                
                                if(!empty($term_obj)){
                                    $term_id = $term_obj->term_id;
                                    array_push($filter_param_values, $term_id);
                                }
                                
                            }

                            if(!empty($filter_param_values)){
                                $filter_param_array[$param_name] = $filter_param_values;
                            }
                        }

                        $post_args =array(
                            'post_type' => 'workday_course',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            );

                        ?>
                    </header>
                    <?php echo get_site_option_value('workday_learning_library_intro','',true); ?>
                </section>
                <hr/>
                <div class="row" id="courseCatalog">
                    <?php
                        if(!empty($filter_param_array)){
                            trigger_course_fitler_with_params_from($filter_param_array);
                        }
                        else {
                            $post_args = set_sorting_params($post_args);
                            print_workday_course_catalog($post_args);
                        }
                     ?>
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

    function handleCourseFilterChange(){
        getResultsFromStart();
    }

    function handleFilterClear(clearButton){
        $(clearButton).hide();
        var termId = clearButton.getAttribute('data-term-id');
        $('#courseFilterForm').find('[value='+ termId +']').prop("checked",false);
        getResultsFromStart();
    }

    function handleFilterClearAll(clearAllButton){
        $('#filterStatus').hide();
        $.each($("input[type='checkbox']:checked"),function (){
            $(this).prop("checked",false)
        });
        getResultsFromStart();
    }

    function handleSortByChange(sel){
        $("[name='sortBy']").attr('value',sel.value);
        getResultsFromStart();
    }

    function handleSortOrderChange(icon){
        let sortOrderValue = $(icon).attr('data-sort-order');
        
        switch(sortOrderValue){
            case 'DESC':
                $(icon).removeClass('fa-arrow-down');
                $(icon).addClass('fa-arrow-up');
                $(icon).attr('data-sort-order', 'ASC');
                $("[name='sortOrder']").attr('value','ASC');
                break;
            default:
                $(icon).removeClass('fa-arrow-up');
                $(icon).addClass('fa-arrow-down');
                $(icon).attr('data-sort-order', 'DESC');
                $("[name='sortOrder']").attr('value','DESC');
        }
        getResultsFromStart();
        
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

    function getResultsFromStart () {
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
