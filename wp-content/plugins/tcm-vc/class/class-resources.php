<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* Resources_x4 (2 Rows) */
/*******************************/

vc_map( array(
	'name' 							=> __( 'Resources_x4 (2 Rows)', TCM_VC ),				
	'base' 							=> 'resources',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'resource',
	), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
	'content_element' 				=> true,
	'show_settings_on_create' 		=> false,
	'is_container' 					=> false,
	"js_view" 						=> 'VcColumnView',
	// All the attributes, define as many as we need.
	'params' => array(	

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Header', TCM_VC ),
			'param_name' 	=> 'resources_header',
			'value' 		=> __( 'Eg. More ABM Resources', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __( "CTA Link", TCM_VC ),
			"param_name" => "resources_cta",
			"description" => __( "Add Link.", TCM_VC )				
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
/* Gallery Slide */
/*******************************/
vc_map( array(
	'name' 					=> __('Resource', TCM_VC),
	'base'					=> 'resource',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'resources'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	
	'js_view' 				=> 'VcResourcesTitle',				
	'admin_enqueue_js' 		=> array(plugin_dir_url( __FILE__ ).'../js/resource_content.js'),	
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Resource Type',  TCM_VC ),
			'param_name' => 'resource_type',
			'value' => array(
				__( 'Blog Post',  TCM_VC  ) 	=> 'blog',
				__( 'Case Study',  TCM_VC  ) 	=> 'case-study',
				__( 'Webinar',  TCM_VC  ) 		=> 'webinar',
				__( 'Video',  TCM_VC  ) 		=> 'video',
				__( 'Worksheets',  TCM_VC  ) 	=> 'worksheet',
				__( 'E-Book',  TCM_VC  ) 		=> 'ebook',
				__( 'Product News',  TCM_VC  ) 	=> 'product-news',
			),
			"description" => __( "Choose resource type.", TCM_VC )	,
		),

		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Image', TCM_VC),
			'param_name' 	=> 'image',
			'description' 	=> __( 'Image Size: 680px x360px.', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Title', TCM_VC ),
			'param_name' 	=> 'title',
			'value' 			=> __( 'Eg: 7 Steps to Getting Started with Account-Based Marketing', TCM_VC ),
			'description' 	=> __( 'Enter the title.', TCM_VC ),
		),

		array(
			"type" => "vc_link",
			"class" => "",
			"heading" => __( "CTA Link", TCM_VC ),
			"param_name" => "cta_link",
			"description" => __( "Add Link.", TCM_VC )				
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
/* Short Code for Resources */
/*******************************/

function render_resources_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$resources_header =	$atts['resources_header'];

	$href 			= vc_build_link( $atts['resources_cta'] );
	$url 			= esc_url( $href["url"] );
	$linkTitle 		= $href["title"];
	$target  		= $href['target'];
	$rel 			= $href['rel'];	

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-resources ${extra_class}' id='${element_id}' >";
	if( ! empty($resources_header)) {
		$output .= "<div class='resources-header'>";
		$output .= "<h2 class='text-center'>${resources_header}</h2>";
		$output .= "</div><!--resources-header-->";
	}
	$output .= "<div class='resources arrow-bottom-sm slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	if( ! empty($url)) {
		$output .= "<div class='resources-footer'>";
		$output .= "<p class='text-center'><a class='btn btn-orange'href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
		$output .= "</div><!--resources-footer-->";
	}	
	$output .= "</div>";
	return $output;
}


/*******************************/
/* Short code for Resource */
/*******************************/


function render_resource_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$resource_type	= $atts['resource_type'];

	$image			= wp_get_attachment_image( $atts['image']  , '680-360', "", array( "class" => "img-responsive" ) );	

	$hero_title 	= $atts['title'];

	$href 			= vc_build_link( $atts['cta_link'] );
	$url 			= esc_url( $href["url"] );
	$linkTitle 		= esc_html( $href["title"] );
	$target  		= $href['target'];
	$rel 			= $href['rel'];

	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 

	$choose_color 			= '';
	$sub_title 		= '';
	if($resource_type == 'blog') {
		$choose_color 	= 'dark-blue';
		$sub_title		= 'Blog';
	} else if ($resource_type == 'case-study') {
		$choose_color 	= 'blue';
		$sub_title		= 'Case Study';
	} else if ($resource_type == 'webinar') {
		$choose_color 	= 'purple';
		$sub_title		= 'Webinar';
	} else if ($resource_type == 'video') {		
		$choose_color 	= 'purple';
		$sub_title		= 'Video';
	} else if ($resource_type == 'worksheet') {
		$choose_color 	= 'green';
		$sub_title		= 'Worksheet';
	} else if ($resource_type == 'ebook') {
		$choose_color 	= 'green';
		$sub_title		= 'E-Book';
	} else if ($resource_type == 'product-news') {
		$choose_color 	= 'purple';
		$sub_title		= 'Product News';
	}


   	$output = "";

	$output .= "<div class='slick-slide slick-slide-resource ${extra_class}' data-color=${choose_color} id='${id}'>";
	$output .= "<div class='resource color-${choose_color}'>";
	if( ! empty($url)) { $output .= "<a href='${url}' title=' ${linkTitle} ' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>"; }	

	if( ! empty($image)) {
		$output .= "<div class='resource-image'>";
		$output .= $image;
		$output .= "</div>";
	}

	$output .= "<div class='content'>";

	if( ! empty($sub_title ) && !doing_filter( 'the_excerpt' )) {
		$output .= 	"<p class='subtitle text-${choose_color}'>${sub_title}</h3>";
	}
	if( ! empty($hero_title ) && !doing_filter( 'the_excerpt' )) {
		$output .= 	"<h4 class=''>${hero_title}</h4>";
	}	
	$output .= "</div>";

	if( ! empty($url)) { $output .= "</a>"; }

	$output .= "</div>";
	$output .= "</div>";

	return $output;
}

add_shortcode( 'resources', 'render_resources_shortcode' ) ;
add_shortcode( 'resource', 'render_resource_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_resources extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_resource extends WPBakeryShortCode {};
}