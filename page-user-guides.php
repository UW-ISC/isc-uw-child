<?php
/**
 * Unique template for User guides page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>

<div role="main">

		<?php uw_site_title(); ?>
		<?php get_template_part( 'menu', 'mobile' ); ?>

		<?php $user_guides = isc_get_user_guides(); // grabs all the user guides. ?>

	<div class="container uw-body">

		<div class="row">
			<div class="col-md-12">
				<?php get_template_part( 'breadcrumbs' ); ?>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12" id="main_content">

				<?php isc_title(); ?>

				
				<div style="margin-bottom:1em; font-size: 14px;">
					<div class="row">
						<div class="col-md-9 form-inline">
							<label>Filter by Keyword:</label>
							<input id="myInputTextField" type="text" class="form-control" style="width:inherit;border-radius:0px;" >
						</div>
						<div style="float: right">
								<button id="clearFiltersBtn" class="isc-simple-button">
									<i class="fa fa-close isc-btn-icon"></i>clear filters
								</button>
						</div>
					</div>
				</div>

				<h2 class="sr-only">User Guides</h2>

				<table id="user_guide_lib" class="table primary-isc-table table-striped-alt" style="border:none !important;">
					<thead style="font-size:14px;">
						<tr>
							<th>User Guide</th>
							<th>Topic</th>
							<th>Security Role</th>
						</tr>
					</thead>
					<thead style="font-size:14px;">
						<tr>
							<th></th>
							<th><select class="form-control input-sm" id="topic-dropdown">
									  <option value="---"> (Select a topic) </option>
										<?php
										  $topics = (isc_get_all_topics( $user_guides ));
										foreach ( $topics as $topic ) {
											echo '<option value = "' . esc_attr( sanitize_title( $topic ) ) . '"> ' . esc_html( $topic ) . ' </option>';
										}
										?>
									</select></th>
							<th><select class="form-control input-sm" id="role-dropdown">
									  <option value="---"> (Select a role) </option>
										<?php
										  $roles = (isc_get_all_roles( $user_guides ));
										foreach ( $roles as $role ) {
											echo '<option value = "' . esc_attr( sanitize_title( $role ) ) . '"> ' . esc_html( $role ) . ' </option>';
										}
										?>
									</select></th>
						</tr>
					</thead>
					<tbody>
						<?php isc_user_guide_table( $user_guides ); ?>
					</tbody>

				</table>

				<script type="text/javascript" charset="utf-8">
				var table;
				$(document).ready(function() {
					table = $('#user_guide_lib').DataTable( {
						"paging":   false,
						"order": [[ 0, "asc" ]], // order user guide list by user guide name (newest on top)
					});

					$('#myInputTextField').keyup(function(){
						  table.search($(this).val()).draw() ;
					});

					//clear all filter fields when this button is clicked
					$("#clearFiltersBtn").on("click", function() {
						$("#myInputTextField").val('');
						$("#myInputTextField").trigger('keyup');
						$("#topic-dropdown").val('---');
						$("#topic-dropdown").trigger('change');
						$("#role-dropdown").val('---');
						$("#role-dropdown").trigger('change');
	    			});
					
					//split url to check if it has params
					var urlArray = window.location.href.split('?');

					//if it has prams only then try to extract these
					if(urlArray.length > 0 ){

						var filterParams = new URLSearchParams(urlArray[1]);
						
						//if params contain '_topic' key/value use its value to set the Topic select dropdown and trigger change 
						if(filterParams.has("_topic")){
							let topicValue = filterParams.get("_topic");
							
							if(optionExistsInSelect("topic-dropdown",topicValue)){
								$("#topic-dropdown").val(topicValue);
								$("#topic-dropdown").trigger('change');
							}
						}
						
						//if params contain '_role' key/value use its value to set the Role select dropdown and trigger change 
						if(filterParams.has("_role")){
							let roleValue = filterParams.get("_role");

							if(optionExistsInSelect("role-dropdown",roleValue)){
								$("#role-dropdown").val(roleValue);
								$("#role-dropdown").trigger('change');
							}
						}

						//if params contain '_filter' key/value use its value to set the Filter textfield and trigger change 
						if(filterParams.has("_filter")){
							let filterValue = filterParams.get("_filter");

							$("#myInputTextField").val(filterValue);
							$("#myInputTextField").trigger('keyup');
						}

					}

					//returns true only if passed option value exists in a <select> element's <option>s
					function optionExistsInSelect(selectId, option) {
						return $("#"+selectId+" option[value='" + option + "']").length !== 0;
					}
					
				});
				$("#topic-dropdown, #role-dropdown").change(function() {
					var topic_value = $("#topic-dropdown").val();
					var role_value = $("#role-dropdown").val();
					var user_guides = $("[id=user-guide]");
					$.fn.dataTable.ext.search.pop();
					$.fn.dataTable.ext.search.push(
					  function(settings, data, dataIndex) {
						var topics = $(table.row(dataIndex).node()).attr('data-topics');
						var roles = $(table.row(dataIndex).node()).attr('data-roles');
						if (topics == undefined) {
						  topics = "";
						}
						if (roles == undefined) {
						  roles = "";
						}
						topics = topics.split(" ");
						roles = roles.split(" ");
						if (role_value == "---" && topic_value == "---") {
						  // return everything
						  return true;
						} else if (role_value == "---") {
						  // filter by topic
						  return topics.indexOf(topic_value) != -1;
						} else if (topic_value == "---") {
						  // filter by role
						  return roles.indexOf(role_value) != -1;
						} else {
						  // filter by both
						  return topics.indexOf(topic_value) != -1 && roles.indexOf(role_value) != -1;
						}
					  }
					);
					table.draw();
				});
				</script>

			</div>
		</div>

	</div>

</div>

<?php get_footer(); ?>
