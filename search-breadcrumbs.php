<?php
$html = '<div class="search-breadcrumbs"><span class="crumb">ISC</span>';
if ($post->post_type == 'page') {
        $parents = get_post_ancestors($post->ID);
        $parents = array_reverse($parents);

        foreach ($parents as $parent) {
                $html .= '<span class="crumb">' . get_the_title($parent) . '</span>';
        }
} else if ($post->post_type == 'post') {
        $html .= '<span class="crumb">News</span><span class="crumb">' . get_the_date('Y',$post->post_ID) . '</span><span class="crumb">' . get_the_date('F',$post->post_ID) . '</span><span class
="crumb">' . get_the_date('j',$post->post_ID) . '</span>';
} else if ($post->post_type == 'glossary') {
		$html .= '<span class="crumb">HR/Payroll Glossary</span>';
}
$html .= '<span class="crumb" style="color: #3a3a3a;">' . get_the_title($post->post_ID) . '</span>'; 
$html .= '</div>';
echo $html;
?>