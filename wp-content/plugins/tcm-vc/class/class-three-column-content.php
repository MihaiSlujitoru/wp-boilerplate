<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* 3 Column Content */
/*******************************/

vc_map( array(
	'name' 							=> __( '3 Column Content', TCM_VC ),				
	'base' 							=> 'three_column_content',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'column_content',
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
/* Column Content */
/*******************************/
vc_map( array(
	'name' 					=> __('Column Content', TCM_VC),
	'base'					=> 'column_content',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'three_column_content'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Choose Color',  TCM_VC ),
			'param_name' => 'choose_color',
			'value' => array(
				__( 'Color Orange',  TCM_VC  ) => 'orange',
				__( 'Color Green',  TCM_VC  ) => 'green',
				__( 'Color Blue',  TCM_VC  ) => 'blue',
				__( 'Color Purple',  TCM_VC  ) => 'purple',
			),
			"description" => __( "It will affect the icon border and title sub-line.", TCM_VC )	,
		),

		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Icon', TCM_VC),
			'param_name' 	=> 'icon',
			'description' 	=> __( 'Icon Size: 64px x 64px.', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Column Title', TCM_VC ),
			'param_name' 	=> 'column_title',
			'value' 			=> __( 'Eg: Product Resources', TCM_VC ),
			'description' 	=> __( 'Enter the title. Usually 1 line of text. This will be the H3.', TCM_VC ),
		),

		array(
			"type" => "textarea",
        	"holder" => "div",
        	"class" => "",						
			"heading" => __( "Content", TCM_VC ),
			"param_name" => "column_content",
			"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
			"description" => __( "", TCM_VC )
		),

		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __( "CTA Link", TCM_VC ),
			"param_name" => "cta_link",
			"description" => __( "Add Link and Title.", TCM_VC )				
		),					

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
/* Short Code for 3 Column Content */
/*******************************/

function render_three_column_content_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-three-column-content ${extra_class}' id='${element_id}' >";
	$output .= "<div class='three-column-content slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	$output .= "</div>";
	return $output;
}


/*******************************/
/* Short code for Gallery Slide */
/*******************************/


function render_column_content_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);


	$choose_color	= $atts['choose_color'];

	$image			= wp_get_attachment_image( $atts['icon']  , '64-64', "", array( "class" => "img-responsive" ) );	

	$column_title 	= $atts['column_title'];
	$content 		= wpb_js_remove_wpautop($atts['column_content'], true);		

	$href 			= vc_build_link( $atts['cta_link'] );
	$url 			= esc_url( $href["url"] );
	$linkTitle 		= $href["title"];
	$target  		= $href['target'];
	$rel 			= $href['rel'];

	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 
   	$output = "";


	$output .= "<div class='slick-slide slick-slide-column-content ${extra_class}' data-color=${choose_color} id='${id}'>";
	$output .= "<div class='column-content color-${choose_color}'>";
	if( ! empty($image)) {
	$output .= "<div class='icon'>";
	$output .= $image;
	$output .= "</div>";
	}
	$output .= "<div class='content text-center'>";
	if( ! empty($column_title ) && !doing_filter( 'the_excerpt' )) {
	$output .= 	"<h3 class='sub-line sub-line-${choose_color} sub-line-center'>${column_title}</h3>";
	}
	if( ! empty($content)) {
	$output .= 	$content;
	}			
	if( ! empty($url)) {
	$output .= "<div class='wrap-btn'><a class='btn btn-orange margin-bottom-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></div>";
	}
	$output .= "</div>";
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}

add_shortcode( 'three_column_content', 'render_three_column_content_shortcode' ) ;
add_shortcode( 'column_content', 'render_column_content_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_three_column_content extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_column_content extends WPBakeryShortCode {};
}