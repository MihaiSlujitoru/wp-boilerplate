<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* Testimonials 				*/
/*******************************/

vc_map( array(
	'name' 							=> __( 'Testimonials', TCM_VC ),				
	'base' 							=> 'testimonials',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'testimonial',
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
			'param_name' 	=> 'testimonials_header',
			'value' 		=> __( 'What Our Customers Are Saying', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
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
/* Testimonial Slide */
/*******************************/
vc_map( array(
	'name' 					=> __('Testimonial', TCM_VC),
	'base'					=> 'testimonial',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'testimonials'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	'js_view' 				=> 'VcTestimonialTitle',				
	'admin_enqueue_js' 		=> array(plugin_dir_url( __FILE__ ).'../js/testimonial_content.js'),	
	'params' => array(
		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Company Logo', TCM_VC),
			'param_name' 	=> 'company_logo',
			'description' 	=> __( 'Transparent Background Logo. Image Size: 300px x 300px.', TCM_VC ),
		),

		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Person Image', TCM_VC),
			'param_name' 	=> 'person_image',
			'description' 	=> __( 'Image Size: 300px x 300px.', TCM_VC ),
		),		

		array(
			'type' 			=> 'textarea',
			'heading' 		=> __( 'Quote', TCM_VC ),
			'param_name' 	=> 'quote',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Citation', TCM_VC ),
			'param_name' 	=> 'citation',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
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
/* Short Code for Testimonials */
/*******************************/

function render_testimonials_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$testimonials_header =	$atts['testimonials_header'];

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-testimonials ${extra_class}' id='${element_id}' >";
	if( ! empty($testimonials_header)) {
		$output .= "<div class='testimonials-header'>";
		$output .= "<h2 class='text-center'>${testimonials_header}</h2>";
		$output .= "</div><!--testimonials-header-->";
	}
	$output .= "<div class='testimonials slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	$output .= "</div>";
	return $output;
}



/*******************************/
/* Short code for Resource */
/*******************************/


function render_testimonial_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);


	$company_logo			= wp_get_attachment_image( $atts['company_logo']  , 'medium', "", array( "class" => "img-responsive" ) );	
	$person_image			= wp_get_attachment_image( $atts['person_image']  , 'medium', "", array( "class" => "img-responsive" ) );	

	$quote			= $atts['quote'];
	$citation 		= $atts['citation'];

	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 

   	$output = "";

	$output .= "<div class='slick-slide slick-slide-testimonial ${extra_class}' id='${id}' itemscope itemtype='http://schema.org/Person'>";

	$output .= "<div class='cite-content'>";
	$output .= "<blockquote>";
	$output .= "<p class='blockquote'>\"${quote}\"</p>";
	$output .= "<cite class='cite' itemprop='name'>- ${citation}</cite>";
	$output .= "</blockquote>";
	$output .= "</div>";
	$output .= "<div class='cite-cloud'>";
	$output .= "<div class='company-logo'>${company_logo}</div>";
	$output .= "<div class='person-image'>${person_image}</div>";
	$output .= "</div>";	

	$output .= "</div>";

	return $output;
}

add_shortcode( 'testimonials', 'render_testimonials_shortcode' ) ;
add_shortcode( 'testimonial', 'render_testimonial_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_testimonials extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_testimonial extends WPBakeryShortCode {};
}