<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

      <?php $user_guides = get_user_guides(); // grabs all the user guides ?>

<div class="container uw-body">

    <div class="row">
        <div class="col-md-12">
            <?php get_template_part( 'breadcrumbs' ); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <h2><?php the_title(); ?></h2>

            <div style="background:#e9e9e9; padding: 20px; margin-bottom:1em;">
                <h3 style="margin-top:0;">Filter by:</h3>
                <div class="row">
                    <div class="col-md-4">
                        Topic: parent topics only
                        <select class="form-control input-sm" id="topic-dropdown">
                          <option value="---"> --- </option>
                            <?php
                              $topics = (get_all_topics($user_guides));
                              foreach($topics as $topic) {
                                echo '<option value = "' . sanitize_title($topic) .'"> ' . $topic . ' </option>';
                              }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        Security Role: child roles only
                        <select class="form-control input-sm" id="role-dropdown">
                          <option value="---"> --- </option>
                            <?php
                              $roles = (get_all_roles($user_guides));
                              foreach($roles as $role) {
                                echo '<option value = "' . sanitize_title($role) .'"> ' . $role . ' </option>';
                              }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        Last Updated: tbd - can't do
                    </div>
                </div>

            </div>

            <h3 class="sr-only">User Guides</h3>

            <table id="user_guide_lib" class="table table-condensed table-striped table-bordered table-hovered">
                <thead style="background:#4b2e83; color:#fff;">
                    <tr>
                        <th>User Guide</th>
                        <th>Topic</th>
                        <th>Security Role</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>

                  <?php
                    user_guide_table($user_guides);
                  ?>

                </tbody>

            </table>

            <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#user_guide_lib').DataTable( {
                    "paging":   false,
                    "order": [[ 3, "desc" ]] // order user guide list by updated date (newest on top)
                });
            });
            $("#topic-dropdown").change(function() {
                var value_selected = $("#topic-dropdown").val();
                var user_guides = $("[id=user-guide]");
                for (i = 0; i < user_guides.length; i++) {
                  var guide = $(user_guides[i]);
                  var topics = guide.attr("data-topics");
                  if (value_selected == "---") {
                    guide.show();
                  } else if (topics != undefined) {
                    topics = topics.split(" ");
                    if (topics.indexOf(value_selected) == -1) {
                      guide.hide();
                    } else {
                      guide.show();
                    }
                  } else {
                    guide.hide();
                  }
                }
            });
            $("#role-dropdown").change(function() {
                var value_selected = $("#role-dropdown").val();
                var user_guides = $("[id=user-guide]");
                for (i = 0; i < user_guides.length; i++) {
                  var guide = $(user_guides[i]);
                  var topics = guide.attr("data-roles");
                  if (value_selected == "---") {
                    guide.show();
                  } else if (topics != undefined) {
                    topics = topics.split(" ");
                    if (topics.indexOf(value_selected) == -1) {
                      guide.hide();
                    } else {
                      guide.show();
                    }
                  } else {
                    guide.hide();
                  }
                }
            });


            </script>

        </div>
    </div>

</div>

<?php get_footer(); ?>
