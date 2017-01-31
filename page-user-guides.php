<?php
/**
 * Template Name: No image
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      $sidebar = get_post_meta($post->ID, "sidebar");
      $seasonal =  get_post_meta($post->ID); ?>

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


            <div class="row">
                <div class="col-md-4" style="background:#e9e9e9;margin-bottom:1em;">
                    asfdasdf
                </div>
                <div class="col-md-4" style="background:#e9e9e9;margin-bottom:1em;">
                    asdfasdf
                </div>
                <div class="col-md-4" style="background:#e9e9e9;margin-bottom:1em;">
                    asdfas
                </div>
            </div>

            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead style="background:#4b2e83; color:#fff;">
                    <tr>
                        <th>User Guide</th>
                        <th>Topic</th>
                        <th>Security Role</th>
                        <th>Last Updated</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- loop through all user guides -->
                    <tr>
                        <td><a href="<?php echo get_site_url() . '/user-guides/phil-demo/'?>">phil demo</a></th>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                    </tr>
                    <tr>
                        <td>xxxxx</th>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                    </tr>
                    <tr>
                        <td>xxxxx</th>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                    </tr>
                    <tr>
                        <td>xxxxx</th>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                    </tr>
                    <tr>
                        <td>xxxxx</th>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                        <td>xxxxx</td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?php get_footer(); ?>
