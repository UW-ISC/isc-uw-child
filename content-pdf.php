<h1 class="entry-title"><?php the_title(); ?></h1>
<a class="uw-btn btn-sm btn-download" href="<?php echo wp_get_attachment_url(get_the_ID());?>" title="<?php the_title(); ?>" target="_blank">Download<i class="fa fa-download download-icon"></i></a>
<p>
	<?php the_content(); ?>
</p>

<div class="embed-responsive embed-responsive-21by9">
	<iframe class="embed-responsive-item uw-pdf-view"  src="<?php echo wp_get_attachment_url(get_the_ID()); ?>?<?php echo time() ?>"></iframe>
</div> 
