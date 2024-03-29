<?php
/**
 * Functions used for defining and registering custom short codes.
 *
 * @author Prasad Thakur
 * @package isc-uw-child
 */

 

/**
* Short code for long button -- divs with images and text that act as hyperlinks.
* 
* This button has 3 attributes:
*     1. url: Hyperlink to destination
*     2. title: Title
*     3. img: Url of the image from media library
* 
* The content enclosed in the short code will be displayed after the title.
* 
* Usage eg.
*     [long_button
* 			title="HCM Initiate 2"
* 			img="http://localhost/hrp-portal/wp-content/uploads/2018/10/HCMInitiate2Icon.png"
* 			url="http://localhost/hrp-portal/user-guides/long-button-security-roles-page/"]
*		
* 		The primary initiators of staffing and hiring processes.
*
*     [/long_button]
*
* @param string $atts Img Url, title, description, CTA label and CTA link attributes.
* @param string $content The content to show when expanded.
*/
function isc_long_button( $atts, $content = '' ) {

	extract(shortcode_atts(array(
		'url' => '',
		'title' => '',
		'img' => ''
	),$atts));

	$img = wp_get_attachment_image(attachment_url_to_postid($img));

	$out = <<<akisujancdkan
		<div class="long-button">
			<a class="long-button-link" href="$url">
				<div class="long-button-body">
					<div class="row">
						<div class="long-button-img col-md-2">
						$img
						</div>
						<div class="long-button-main col-md-9">
							<div class="long-button-title">
								<h4 id="2-hcm-initiate-2">$title</h4>
								<div class="fa fa-external-link fa-lg hover-link"></div>
							</div>
							<p>$content</p>
						</div>
					</div>
				</div>
			</a>
		</div>
akisujancdkan;

	return $out;

}
add_shortcode( 'long_button', 'isc_long_button' );

 
/**
 * ISC card Shortcode
 * This card will create a card (similar to a material design cards) with boxed shadow.
 * Cards can be arranged in responsive grids for better page navigation.
 * This card has 4 sections:
 *     1. url: Image or Icon Url
 *     2. title: Card title text
 *     3. description (HTML enclosed with the shortcode): short excerpt or description of concept housed in this card.
 *     4. button_text: Label for the bottom call-to-action or link button.
 *     5. button_link: Url for call-to-action button or link.
 * 	   6. auto_height: if any value except "false" is specified card will have heigh:auto, if attribute is not present card will have fixed height.
 *
 * Usage eg.
 *     [card url="http://localhost/hrp-portal/wp-content/uploads/2019/02/wd-applet-career.png" title="Employee" button_text="Employee Training" button_link="https://isc.uw.edu/support-resources/workday-training/workday-training-for-employees/"]
 *  I am looking for guidance to help me use Workday to add, make changes to, or take action on my own account.
 *  [/card]
 * @param string $atts Img Url, title, description, CTA label and CTA link attributes.
 */
function isc_card($atts, $content = null)
{
    extract(shortcode_atts(array(
        'url' => '',
        'title' => '',
        'button_link' => '',
		'button_text' => '',
		'open_in_same' => '',
		'auto_height' => 'false'
    ),
		$atts));
	
	$apply_auto_height = strcmp($auto_height, 'false') !== 0;

	if(strcmp($open_in_same, 'true') == 0) {
		$button_open = "";
	} else {
		$button_open = "_blank";
	}
	$height_class= '';
	if( $apply_auto_height){
		$height_class= 'auto-height-card';
	}

    $out = '<div class="card-box-33 col-md-3 '.$height_class.'">
		<img src="' . $url . '" class="card-grid-icon">
		<h5 class="card-grid-title" >' . $title . '</h5>
		<div class="card-grid-decription" >' . $content . '</div>
		<h4 class="card-grid-link" title="' . $button_text . '">
			<a class="uw-btn btn-sm" href="' . $button_link . '" target="'.$button_open .'" rel="noopener noreferrer">' . $button_text . '</a>
		</h4>
		</div>
		';
    return $out;
}
add_shortcode( 'card', 'isc_card' );

/**
 * ISC Expand Shortcode
 *
 * @param string $atts Title and alt tag values for the link.
 * @param string $content The content to show when expanded.
 */
function isc_expander( $atts, $content = null ) {

	$atts = shortcode_atts(
		array(
			'title' => 'replace this text w/ descriptive title',
			'alt' => 'same text as title',
		),
		$atts
	);

	static $i = 1;

	$out = '<div class="isc-expander">
		<a role="button" data-toggle="collapse" class="expanded collapsed" title="' . $atts['alt'] . '" href="#isc_expand_' . $i . '" aria-expanded="false" aria-controls="isc_expand_' . $i . '">' . $atts['title'] . '</a>
		<div class="collapse in isc-expander-content" id="isc_expand_' . $i . '"><div  class="isc-expander-inner">' . $content . '</div></div>
	</div>';

	$i++;

	return $out;

}
add_shortcode( 'expand', 'isc_expander' );

// Milestones - start

/**
 * ISC Milestone Shortcode
 * This shortcode should be used for consistent presentation of milestones inside content or articles.
 * This milestone has an icon (associated with its type) and user defined content.
 * It will be wrapped between two horizontal lines with appropriate padding and margins to seperate it from page content.
 * 
 * Valid value for type attribute: done, routing, important, pause, qq ("quick question")
 * 
 * Usage eg.
 *     [isc-milestone type="done"]
 *          At this point the process has been fully approved.
 *     [/isc-milestone]
 * 
 * @param string $atts type.
 */
function isc_milestone($atts, $content = null)
{
    extract(shortcode_atts(array(
        'type' => 'done',
    ),
        $atts));
    
    $content = html_entity_decode($content);
    
    $out = <<<oahfnmnfjhnfu
    <hr>
    <ul class="line no-stylist isc-milestone">
        <li class="bullet line-height-proper">
            <i class="fa isc-milestone-icon isc-milestone-$type" ></i>
        </li>
		<li class="line-height-proper right-padding" >
			<p>$content</p>
		</li>
    </ul>
    <hr style="margin-top:0 !important">
oahfnmnfjhnfu;

    return $out;
}
add_shortcode( 'isc-milestone', 'isc_milestone' );

/**
 * Hide email from Spam Bots using a shortcode.
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 * @return string The obfuscated email address. 
 */
function wpdocs_hide_email_shortcode( $atts , $content = null ) {

	extract(shortcode_atts(array(
		'subject' => ''
	),$atts));

    if ( ! is_email( $content ) ) {
        return;
	}
	$email = esc_html(antispambot( $content, 1));
	if ($subject != '') {
		$email .= '?subject=' . $subject;
	}

	return '<a href="mailto:' . $email . '">' . esc_html( antispambot( $content, 0 ) ) . '</a>';
   
}
add_shortcode( 'email', 'wpdocs_hide_email_shortcode' );