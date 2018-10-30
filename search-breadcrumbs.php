<?php
$html = '<div class="search-breadcrumbs"><span class="crumb">ISC</span>';

if ($post->post_type == 'page')
	{
	$parents = get_post_ancestors($post->ID);
	$parents = array_reverse($parents);
	foreach($parents as $parent)
		{
		$html.= '<span class="crumb"> <a href="' . get_permalink($parent) . '">' . get_the_title($parent) . '</a></span>';
		}
	}
  else
if ($post->post_type == 'post')
	{
		$year = get_the_date('Y', $post->post_ID);
		$month = get_the_date('F', $post->post_ID);
		$month_number = get_the_date('m', $post->post_ID);
		$day = get_the_date('j', $post->post_ID);
		$html.= '<span class="crumb"><a href="news">News</a></span><span class="crumb"><a href="'.get_year_link($year,$month_number,$day).'">' . $year . '</a></span><span class="crumb"><a href="'.get_month_link($year,$month_number,$day).'">' . $month . '</a></span><span class="crumb"><a href="'.get_day_link($year,$month_number,$day).'">' . $day . '</a></span>';
	}
  else
if ($post->post_type == 'glossary')
	{
	$html.= '<span class="crumb"> <a href="glossary"> HR/Payroll Glossary </a> </span>';
	}

$html.= '<span class="crumb" style="color: #3a3a3a;">' . get_the_title($post->post_ID) . '</span>';
$html.= '</div>';
echo $html;
?>