<?php
/**
 * Unique template for User guides page
 *
 * @package isc-uw-child
 * @author UW-IT AXDD
 */

get_header();
	  $url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>

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
		<div class="col-md-12">
			<h2><?php the_title(); ?></h2>

			<div style="background:#f9f9f9; padding: 20px; margin-bottom:1em; font-size: 14px;">

				<div class="row">

					<div class="col-md-8">
						<h3 class="sr-only">Filter by:</h3>
						<div class="row">
							<div class="col-md-6">
								<label>Topic:</label>
								<select class="form-control input-sm" id="topic-dropdown">
								  <option value="---"> --- </option>
									<?php
									  $topics = (isc_get_all_topics( $user_guides ));
									foreach ( $topics as $topic ) {
										echo '<option value = "' . esc_html( $topic ) . '"> ' . esc_html( $topic ) . ' </option>';
									}
									?>
								</select>
							</div>
							<div class="col-md-6">
								<label>Security Role:</label>
								<select class="form-control input-sm" id="role-dropdown">
								  <option value="---"> --- </option>
									<?php
									  $roles = (isc_get_all_roles( $user_guides ));
									foreach ( $roles as $role ) {
										echo '<option value = "' . esc_html( $role ) . '"> ' . esc_html( $role ) . ' </option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<h3 class="sr-only">Search by:</h3>
						<label>Keyword:</label>
						<input class="form-control input-sm" type="text" id="myInputTextField">
					</div>
				</div>

			</div>

			<h3 class="sr-only">User Guides</h3>

			<table id="user_guide_lib" class="table table-striped" style="border:none !important;">
				<thead style="font-size:14px;">
					<tr>
						<th>User Guide</th>
						<th>Topic</th>
						<th>Security Role</th>
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

<?php get_footer(); ?>
