<?php
/**
 * Template for User guides Library page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
?>
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
                    <?php echo get_site_option_value('user_guide_library_intro','',true); ?>
                </section>
                <hr/>


                <div class="row">
                    <div class="col-md-4 filter-wrapper">

                    

                        <?php

                            // $populations = array(
                            //     "Academic Personnel",
                            //     "Medical Centers",
                            //     "Postdocs",
                            //     "Staff Campus",
                            //     "Students"
                            // );
                            $security_roles_names = array(
                                "HCM Initiate 1",
                                "HCM Initiate 2",
                                "Time & Absence Initiate",
                                "Time & Absence Approver",
                                "HR Partner",
                                "Academic Partner"
                            );

                            // $topics = array(
                            //     "Benefits",
                            //     "Time & Absence",
                            //     "Pay/Compensation",
                            //     "Hire"
                            // );

                            $topics = get_terms( 'ug-topic' );
                            $topics_names = array();
                            $populations_names = array();
                            $populations = get_terms('ug-population');

                            echo "<h3>Population</h3>";
                            foreach($populations as $i) {
                                $i = $i->name;
                                array_push($populations_names, sanitize_title($i));
                                echo "<label><input type='checkbox' name='population' value='" . sanitize_title($i) . "'> " . $i . " </label> <br>";
                            }
                            echo "<h3>Security role</h3>";
                            foreach($security_roles_names as $i) {
                                echo "<label><input type='checkbox' name='security' value='" . sanitize_title($i) . "'> " . $i . " </label> <br>";
                            }
                            echo "<h3>Topic</h3>";
                            foreach($topics as $i) {
                                $i = $i->name;
                                array_push($topics_names, sanitize_title($i));
                                echo "<label><input type='checkbox' name='topic' value='" . sanitize_title($i) . "'> " . $i . "</label> <br>";
                            }
                        ?>
                        <button id="user-guide-clear-filter-button" class="user-guide-clear-filter hidden">Clear all filters</button>
                    </div>
                    <div class="col-md-8">
                        <?php echo do_shortcode("[table id=777 /]"); ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>

<?php 

    $page_id = 
    $user_guides = get_user_guides(); // grabs all the user guides. 
    function get_user_guides() {
        $args = array(
            // 'parent' => get_the_ID(),
            'parent' => url_to_postid(get_site_url() . '/user-guides/'),
            // 'parent' => 541,
            'hierarchical' => 0,
            'sort_column' => 'menu_order',
            'sort_order' => 'asc',
        );
        $children_pages = get_pages( $args );
        $user_guides_return = array();
        foreach ( $children_pages as $child ) {
            $security_query = get_the_terms( $child->ID, 'sec_role' );
            $sec_roles = array();
            if ( ! empty( $security_query ) ) {
                foreach ( $security_query as $role ) {
                    array_push( $sec_roles, $role->name );
                }
            }

            $topic_query = get_the_terms( $child->ID, 'ug-topic' );
            $topics = array();
            if ( ! empty( $topic_query ) ) {
                foreach ( $topic_query as $topic ) {
                    array_push( $topics, $topic->name );
                }
            }
            

            $population_query = get_the_terms( $child->ID, 'ug-population' );
            $populations = array();
            if ( ! empty( $population_query ) ) {
                foreach ( $population_query as $population ) {
                    array_push( $populations, $population->name );
                }
            }
            
            $url = get_permalink( $child );
            $temp_user_guide = array();
            $temp_user_guide["name"] = $child->post_title;

            
            $sanitized_topics = array();
            foreach ( $topics as $el ) {
                array_push( $sanitized_topics, sanitize_title( $el ) );
            }
            $sanitized_roles = array();
            foreach ( $sec_roles as $el ) {
                array_push( $sanitized_roles, sanitize_title( $el ) );
            }
            $sanitized_populations = array();
            foreach ( $populations as $el ) {
                array_push( $sanitized_populations, sanitize_title( $el ) );
            }
            $data_pop = empty( $sanitized_populations ) ? '' : implode( ' ', $sanitized_populations );
            $data_topics = empty( $sanitized_topics ) ? '' : implode( ' ', $sanitized_topics );
            $data_roles = empty( $sanitized_roles ) ? '' : implode( ' ', $sanitized_roles );
            $populations = count( $populations ) === 0 ? ('') : (implode( ', ', $populations ));
            $topics = count( $topics ) === 0 ? ('') : (implode( ', ', $topics ));
            $roles = count( $roles ) === 0 ? ('') : (implode( ', ', $roles ));

            
            $temp_user_guide["url"] = $url;
            $temp_user_guide["population"] = $sanitized_populations;
            $temp_user_guide["topics"] = $sanitized_topics;
            $temp_user_guide["roles"] = $sanitized_roles;
            $temp_user_guide["data_pop"] = $data_pop;
            $temp_user_guide["data_topics"] = $data_topics;
            $temp_user_guide["data_roles"] = $data_roles;
            $user_guides_return[substr($url, strpos($url,"user-guides"))] = $temp_user_guide;
        }
        return $user_guides_return;
    }
?>

<script>
    let table = "";
    
    $(document).ready(function() {
        datetableSetup().then(function() {
            urlSetup();
        });
    });

    async function datetableSetup() {
        $("table tbody td.column-1 a").each(function () {
            let s = $(this).attr("href");
            let user_guides = <?php echo json_encode($user_guides); ?>;
            s = s.substring(s.indexOf("user-guides"));
            ($(this).parent().parent().attr("id", "user-guide"));
            if (user_guides[s]) {
                ($(this).parent().parent().attr("data-pop", user_guides[s].data_pop));
                ($(this).parent().parent().attr("data-topics", user_guides[s].data_topics));
                ($(this).parent().parent().attr("data-roles", user_guides[s].data_roles));
            }
        });

        $("table tbody td.column-3").each(function () {
            let link = $(this).html();
            if (link.length != 0) {
                $(this).html("");
                $(this).append('<a class="user-guide-video-icon" target="_blank" href="' + link + '"/>');
            }
        });

        
        $("table tbody td.column-4").each(function () {
            let link = $(this).html();
            if (link.length != 0) {
                $(this).html("");
                $(this).append('<a class="user-guide-pdf-icon" target="_blank" href="' + link + '"/>');
            }
        });

        $('#main_content').css('visibility', 'hidden');
        table =  $('table.tablepress').DataTable( {
            "paging":   false,
            orderCellsTop: true,
            fixedHeader: true
        } );
        $('#main_content').css('visibility', 'visible');

        let role_values = [];
        let topic_values = [];
        let pop_values = [];

        $("#user-guide-clear-filter-button").click(function () {
            $('input[type="checkbox"]:checked').each(function(i) {
                $(this).prop("checked", false);
            });
            role_values = [];
            topic_values = [];
            pop_values = []
            filterClicked();
            $("#user-guide-clear-filter-button").addClass("hidden");
        });

        $('input[type="checkbox"]').click(function() {
            filterClicked();
            
        });



        $(".dataTables_wrapper .dataTables_filter label input").detach().prependTo("#main_content .col-md-4").attr('id', 'datatable_search');;
        $("<h3>User Guide Name or Keyword</h3>").detach().prependTo("#main_content .col-md-4");
        $("<h2 style='margin:0;'>Filter by:</h2>").detach().prependTo("#main_content .col-md-4");
        $(".dataTables_wrapper .dataTables_filter").remove();
        
        
        center_icon(".user-guide-video-icon");
        center_icon(".user-guide-pdf-icon");
        function center_icon(className) {
            $(className).each(function() {
                let i = $(this).parent();
                let w = i.outerWidth();
                let h = i.outerHeight();
                $(this).width(w + "px");
                $(this).height(h + "px");
                let ml = w/2;
                let mt = h/2;
                $(this).css("margin-left", -ml + "px");
                $(this).css("margin-top", -mt + "px");
            });
        }
    }

    function filterClicked() {
        role_values = [];
        topic_values = [];
        pop_values = []
        let filter_count = 0;
        $('input[type="checkbox"]:checked').each(function(i) {
            filter_count++;
            if ($(this).attr("name") == "security") {
                role_values.push($(this).val());
            }
            if ($(this).attr("name") == "topic") {
                topic_values.push($(this).val());
            }
            if ($(this).attr("name") == "population") {
                pop_values.push($(this).val());
            }
        });

        if (filter_count >= 1) {
            $("#user-guide-clear-filter-button").removeClass("hidden");
        } else {
            $("#user-guide-clear-filter-button").addClass("hidden");
        }
        
        table.draw();

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var topics = $(table.row(dataIndex).node()).attr('data-topics');
                var roles = $(table.row(dataIndex).node()).attr('data-roles');
                var populations = $(table.row(dataIndex).node()).attr('data-pop');

                if (topics == undefined) { topics = ""; }
                if (roles == undefined) { roles = ""; }
                if (populations == undefined) { populations = ""; }


                topics = topics.split(" ");
                roles = roles.split(" ");
                populations = populations.split(" ");

                if (pop_values.length != 0 && role_values.length != 0 && topic_values.length != 0) {
                    return (populations.some(i => pop_values.includes(i))) &&
                        (roles.some(i => role_values.includes(i))) &&
                        (topics.some(i => topic_values.includes(i)));
                }

                else if (pop_values.length != 0 && role_values.length != 0) {
                    return (populations.some(i => pop_values.includes(i))) && (roles.some(i => role_values.includes(i)));
                } else if (pop_values.length != 0 && topic_values.length != 0) {
                    return (populations.some(i => pop_values.includes(i))) && (topics.some(i => topic_values.includes(i)));
                } else if (role_values.length != 0 && topic_values.length != 0) {
                    return (roles.some(i => role_values.includes(i))) && (topics.some(i => topic_values.includes(i)));
                }

                else if (pop_values.length != 0) {
                    return populations.some(i => pop_values.includes(i));
                } else if (topic_values.length != 0) {
                    return topics.some(i => topic_values.includes(i));
                } else if (role_values.length != 0) {
                    return roles.some(i => role_values.includes(i));
                }
                else {
                    return true;
                }
            }
        );
    }

    async function urlSetup() {
        //split url to check if it has params
        var urlArray = window.location.href.split('?');

        //if it has prams only then try to extract these
        if(urlArray.length > 0 ){

            var filterParams = new URLSearchParams(urlArray[1]);
            
            //if params contain '_topic' key/value use its value to set the Topic select dropdown and trigger change 
            if(filterParams.has("_topic")){
                let topicValue = sanitize_str(filterParams.get("_topic"));
                $("input[name='topic']:checkbox").each(function() {
                    if ($(this).attr("value") == topicValue) {
                        $(this).trigger('click');
                        filterClicked();
                    }
                });
            }
            
            //if params contain '_role' key/value use its value to set the Role select dropdown and trigger change 
            if(filterParams.has("_role")) {
                let roleValue = sanitize_str(filterParams.get("_role"));
                $("input[name='security']:checkbox").each(function() {
                    if ($(this).attr("value") == roleValue) {
                        $(this).trigger('click');
                        filterClicked();
                    }
                });
            }
            
            //if params contain '_pop' key/value use its value to set the Population select dropdown and trigger change 
            if(filterParams.has("_pop")) {
                let popValue = sanitize_str(filterParams.get("_pop"));
                $("input[name='population']:checkbox").each(function() {
                    if ($(this).attr("value") == popValue) {
                        $(this).trigger('click');
                        filterClicked();
                    }
                });
            }

            //if params contain '_filter' key/value use its value to set the Filter textfield and trigger change 
            if(filterParams.has("_filter")) {
                let filterValue = filterParams.get("_filter");
                $("#datatable_search").val(filterValue);
                $("#datatable_search").trigger('keyup');
            }

        }

        function sanitize_str(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñçěščřžýúůďťň·/_,:;";
            var to   = "aaaaeeeeiiiioooouuuuncescrzyuudtn------";

            for (var i=0, l=from.length ; i<l ; i++)
            {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace('.', '-') // replace a dot by a dash 
                .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by a dash
                .replace(/-+/g, '-') // collapse dashes
                .replace( /\//g, '' ); // collapse all forward-slashes

            return str;
        }
    }

</script>