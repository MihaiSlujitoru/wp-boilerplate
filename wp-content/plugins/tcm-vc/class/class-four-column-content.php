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
	'name' 							=> __( '4 Column Content', TCM_VC ),				
	'base' 							=> 'four_column_content',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'f_column_content',
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
	'base'					=> 'f_column_content',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'four_column_content'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	
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
			"description" => __( "It will affect the  sub-line.", TCM_VC )	,
		),

		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Image', TCM_VC),
			'param_name' 	=> 'image',
			'description' 	=> __( 'Icon Size: 1024px x 1024px.', TCM_VC ),
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

function render_four_column_content_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-four-column-content ${extra_class}' id='${element_id}' >";
	$output .= "<div class='four-column-content slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	$output .= "</div>";
	return $output;
}


/*******************************/
/* Short code for Gallery Slide */
/*******************************/


function render_f_column_content_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);


	$choose_color	= $atts['choose_color'];

	$image			= wp_get_attachment_image( $atts['image']  , 'large', "", array( "class" => "img-responsive" ) );	


	$column_title 	= $atts['column_title'];
	$content 		= wpb_js_remove_wpautop($atts['column_content'], true);		


	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 

   	$output = "";


	$output .= "<div class='slick-slide slick-slide-four-column-content ${extra_class}' data-color='${choose_color}' id='${id}'>";
	$output .= "<div class='column-content' >";
	if( ! empty($image)) {
	$output .= "<div class='image'>";
	$output .= $image;
	$output .= "</div>";
	}	
	$output .= "<div class='content text-center sub-line sub-line-${choose_color} sub-line-center sub-line-top-30'>";
	if( ! empty($column_title ) && !doing_filter( 'the_excerpt' )) {
	$output .= 	"<h3>${column_title}</h3>";
	}
	if( ! empty($content)) {
	$output .= 	$content;
	}			
	$output .= "</div>";
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}

add_shortcode( 'four_column_content', 'render_four_column_content_shortcode' ) ;
add_shortcode( 'f_column_content', 'render_f_column_content_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_four_column_content extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_f_column_content extends WPBakeryShortCode {};
}