<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* People Tiles 				*/
/*******************************/

vc_map( array(
	'name' 							=> __( 'People Tiles', TCM_VC ),				
	'base' 							=> 'people_tiles',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'person_tile',
	), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	'content_element' 				=> true,
	'show_settings_on_create' 		=> false,
	'is_container' 					=> false,
	"js_view" 						=> 'VcColumnView',
	// All the attributes, define as many as we need.
	'params' => array(	
		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Element ID', TCM_VC ),
			'param_name' 	=> 'element_id',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( 'Enter element ID (Note: make sure it is unique and valid).', TCM_VC ),
		),

		array(
			'type'			=> 'textfield',
			'heading' 		=> __( 'Extra class name', TCM_VC ),
			'param_name' 	=> 'extra_class',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', TCM_VC ),
		),					
	),
));

/*******************************/
/* Person Tile			*/
/*******************************/

vc_map( array(
	'name' 					=> __('Person Tile', TCM_VC),
	'base'					=> 'person_tile',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'people_tiles'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	
	'js_view' 				=> 'VcPeopleTile',				
	'admin_enqueue_js' 		=> array(plugin_dir_url( __FILE__ ).'../js/people_tile_content.js'),		

	'params' => array(
		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Person Image', TCM_VC),
			'param_name' 	=> 'person_image',
			'description' 	=> __( 'Icon Size: 342px x 342px.', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Person Name', TCM_VC ),
			'param_name' 	=> 'person_name',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Person Position', TCM_VC ),
			'param_name' 	=> 'person_position',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),		

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Person LinkedIn Link', TCM_VC ),
			'param_name' 	=> 'person_linkedin_link',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),			

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Person Twitter Link', TCM_VC ),
			'param_name' 	=> 'person_twitter_link',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),		

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Element ID', TCM_VC ),
			'param_name' 	=> 'element_id',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( 'Enter element ID (Note: make sure it is unique and valid).', TCM_VC ),
		),

		array(
			'type'			=> 'textfield',
			'heading' 		=> __( 'Extra class name', TCM_VC ),
			'param_name' 	=> 'extra_class',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', TCM_VC ),
		),				
	),
));

/*******************************/
/* Short Code for 3 Column Content */
/*******************************/

function render_people_tiles_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-people-tiles ${extra_class}' id='${element_id}' >";
	$output .= "<div class='people-tiles slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	$output .= "</div>";
	return $output;
}

/*******************************/
/* Short code for Person Tile */
/*******************************/


function render_person_tile_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);



	$image			= wp_get_attachment_image( $atts['person_image']  , '342-342', "", array( "class" => "img-responsive", "itemprop" => "image" ) );	

	$person_name			= $atts['person_name'];
	$person_position		= $atts['person_position'];
	$person_linkedin_link	= esc_url($atts['person_linkedin_link']);
	$person_twitter_link	= esc_url($atts['person_twitter_link']);

	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 


   	$output = "";
	$output .= "<div class='slick-slide slick-slide-person-tile ${extra_class}' id='${id}'>";
	$output .= "<div class='person-tile' itemscope itemtype='http://schema.org/Person'>";
	$output .= "<div class='person-image'>";
	$output .= $image;
	$output .= "</div>";
	$output .= "<div class='person-info'>";
	$output .= "<div class='person-header'>";
	$output .= "<span class='person-name' itemprop='name'>${person_name}</span>";
	$output .= "<span class='person-social'>";
	if( ! empty($person_linkedin_link)) { $output .= "<a href='${person_linkedin_link}' target='_blank' itemprop='sameAs'><i class='fo-icon-linkedin'></i></a>"; }
	if( ! empty($person_twitter_link)) {$output .= "<a href='${person_twitter_link}' target='_blank' itemprop='sameAs'><i class='fo-icon-twitter'></i></a>"; }
	$output .= "</span>";
	$output .= "</div>";
	$output .= "<div class='person-footer'>";
	$output .= "<p class='subtitle text-dark-blue' itemprop='jobTitle'>${person_position}</p>";
	$output .= "</div>";
	$output .= "</div>";	
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}


add_shortcode( 'people_tiles', 'render_people_tiles_shortcode' ) ;
add_shortcode( 'person_tile', 'render_person_tile_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_people_tiles extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_person_tile extends WPBakeryShortCode {};
}