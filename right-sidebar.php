<?php
$html = '';
if ($post->post_type == 'page') {

	 $post_roles = get_the_terms($post->post_ID, 'sec_role');
 
		if ( $post_roles ) {
			$html .= '<h3>Relevant Security Roles</h3>';
			$html .= '<ul class="tags">';
		    foreach( $post_roles as $role ) {
		    $html .= '<li class="tag-ctr">'. $role->name . '</li>'; 
		    }
		    $html .= '</ul>';
		}


        $post_tags = get_the_terms($post->post_ID, 'md-tags');
 
		if ( $post_tags ) {
			$html .= '<h3>Tags</h3>';
			$html .= '<ul class="tags">';
		    foreach( $post_tags as $tag ) {
		    $html .= '<li class="tag-ctr">'. $tag->name . '</li>'; 
		    }
		    $html .= '</ul>';
		}

		// $html .= get_post_custom($post->post_ID)['cta'][0];

		$html .= '<h3>Contact Us</h3>';

		$html .= '<i class="fa fa-envelope padded-i" aria-hidden="true"></i><a href="mailto:ischelp@uw.edu">ischelp@uw.edu</a>';
		$html .= '<br><i class="fa fa-phone padded-i" aria-hidden="true"></i>206-543-8000';

}
echo $html;
?>