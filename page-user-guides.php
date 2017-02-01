<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>

      <?php uw_site_title(); ?>
      <?php get_template_part( 'menu', 'mobile' ); ?>

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
                        Topic: tbd
                    </div>
                    <div class="col-md-4">
                        Security Role: tbd
                    </div>
                    <div class="col-md-4">
                        Updated: tbd
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

                  <?php $args = array(
                          'parent' => get_the_ID(),
                          'hierarchical' => 0,
                          'sort_column' => 'menu_order',
                          'sort_order' => 'asc'
                        );
                        $children_pages = get_pages($args);

                        $html = '';

                        foreach ($children_pages as $child) {
                            //log_to_console(get_object_taxonomies($child));
                            $security_role = wp_get_post_terms($child->ID, 'sec_role');
                            if (empty($security_role)) {
                                $security_role = "---";
                            } else {
                                $security_role = $security_role[0]->name;
                            }
                            //log_to_console($security_role);

                            $topics = wp_get_post_terms($child->ID, 'ug-topic');
                            if (empty($topics)) {
                                $topics = "---";
                            } else {
                                $topics = $topics[0]->name;
                            }
                            //log_to_console($topics);

                            $url = get_permalink($child);
                            $html .= '<tr>';
                            $html .= '<td><a href="'. $url .'">';
                            $html .= $child->post_title;
                            $html .= '</a></td>';

                            $date_updated = new DateTime($child->post_modified_gmt);
                            $html .= '<td>' . $topics . '</td>';
                            $html .= '<td>' . $security_role . '</td>';
                            $html .= '<td>' . date_format($date_updated, 'm.d.y') . '</td>';

                            $html .= '</tr>';
                        }
                        echo $html;
                    ?>

                </tbody>

            </table>

            <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#user_guide_lib').DataTable();
            });
            </script>

        </div>
    </div>

</div>

<?php get_footer(); ?>
