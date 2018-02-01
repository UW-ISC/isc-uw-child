<?php
$html = '<div class="search-breadcrumbs"><span class="crumb">ISC</span>';

if ($post->post_type == 'page') {
	$parents = get_post_ancestors($post->ID);
	$parents = array_reverse($parents);

	foreach ($parents as $parent) {
		$html .= '<span class="crumb">' . get_the_title($parent) . '</span>';
	}
} 
$html .= '</div>';
echo $html;
?>