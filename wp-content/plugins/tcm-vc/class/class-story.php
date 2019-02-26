<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* Story Line 				*/
/*******************************/

vc_map( array(
	'name' 							=> __( 'Story Line', TCM_VC ),				
	'base' 							=> 'story_line',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'story',
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
			'param_name' 	=> 'story_line_header',
			'value' 		=> __( 'Begin Your ABM Journey with Terminus', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			"type" 			=> "vc_link",
			"class" 		=> "",
			"heading" 		=> __( "CTA Link", TCM_VC ),
			"param_name" 	=> "cta_link",
			"description" 	=> __( "Add Link and Title.", TCM_VC ),				
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
/* Short Code for Story Line */
/*******************************/

function render_story_line_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$story_line_header =	$atts['story_line_header'];

	$href 					= vc_build_link( $atts['cta_link'] );
	$url 					= esc_url( $href["url"] );
	$linkTitle 				= $href["title"];
	$target  				= $href['target'];
	$rel 					= $href['rel'];

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-story-line ${extra_class}' id='${element_id}' >";
	if( ! empty($story_line_header)) {
		$output .= "<div class='story-line-header'>";
		$output .= "<h2 class='text-center text-semibold'>${story_line_header}</h2>";
		$output .= "</div><!--story-line-header-->";
	}
	$output .= "<div class='story-line slick-slider'>" . apply_filters('the_content', $content). "</div>";	

	if( ! empty($url)) {
		$output .= "<div class='story-line-footer'>";
		$output .= 	"<p class='text-center'><a class='btn btn-green margin-bottom-0 top-bottom-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
		$output .= "</div><!--story-line-header-->";
	}

	$output .= "</div>";
	return $output;
}

add_shortcode( 'story_line', 'render_story_line_shortcode' ) ;

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_story_line extends WPBakeryShortCodesContainer {};
}
// Element Class 
class Story extends WPBakeryShortCodesContainer {
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_story' ) );
        add_shortcode( 'story', array( $this, 'render_story_shortcode' ) );
    }
    // Element Mapping
    public function vc_story() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
		vc_map( array(
			'name' 					=> __('Story', TCM_VC),
			'base'					=> 'story',
			'content_element' 		=> true,
			'as_child' 				=> array('only' => 'story_line'), // Use only|except attributes to limit parent (separate multiple values with comma)				
			'js_view' 				=> 'VcStoryTitle',				
			//'admin_enqueue_js' 		=> array(plugin_dir_url( __FILE__ ).'../js/testimonial_content.js'),	
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Choose Color',  TCM_VC ),
					'param_name' => 'choose_color',
					'value' => array(
						__( 'Color Orange',  TCM_VC  ) 	=> 'orange',
						__( 'Color Green',  TCM_VC  ) 	=> 'green',
						__( 'Color Blue',  TCM_VC  ) 	=> 'blue',
						__( 'Color Purple',  TCM_VC  ) 	=> 'purple',
					),
					"description" => __( "It will affect the icon border and title sub-line.", TCM_VC )	,	
				),		
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> __( 'Icon', TCM_VC),
					'param_name' 	=> 'story_icon',
					'description' 	=> __( 'Icon Size: 150px x 150px.', TCM_VC ),
				),	

				array(
					'type' 			=> 'textarea',
					'heading' 		=> __( 'Title', TCM_VC ),
					'param_name' 	=> 'story_title',
					'value' 		=> __( '', TCM_VC ),
					'description' 	=> __( '', TCM_VC ),
				),

				array(
					'type' 			=> 'textarea',
					'heading' 		=> __( 'Content', TCM_VC ),
					'param_name' 	=> 'story_content',
					'value' 		=> __( '', TCM_VC ),
					'description' 	=> __( '', TCM_VC ),
				),				

		            array(
		                'type' => 'animation_style',
		                'heading' => __( 'Animation Style', 'text-domain' ),
		                'param_name' => 'animation',
		                'description' => __( 'Choose your animation style', 'text-domain' ),
		                'admin_label' => false,
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
                          
    }
     
    // Element HTML
	function render_story_shortcode($atts, $content, $tag) {
		$atts 			= vc_map_get_attributes($tag, $atts);


		$story_icon		= wp_get_attachment_image( $atts['story_icon']  , 'thumbnail', "", array( "class" => "img-responsive" ) );	
		$choose_color	= $atts['choose_color'];


		$story_title	= $atts['story_title'];
		$story_content 	= wpb_js_remove_wpautop($atts['story_content'], true);

		$animation_classes = $this->getCSSAnimation($atts['animation']);

		//Class and Id
		$extra_class	= $atts['extra_class'];
		$id 			= $atts['element_id']; 

	   	$output = "";
		$output .= "<div class='slick-slide slick-slide-story ${extra_class} ${animation_classes}' data-color='${choose_color}' id='${id}'>";
		$output .= "<div class='wrap-story'>";
		$output .= "<div class='content sub-line sub-line-${choose_color} sub-line-top-20'>";
		$output .= "<h3>${story_title}</h3>";
		$output .= $story_content;
		$output .= "</div>";

		$output .= "<div class='wrap-icon'><div class='icon'>${story_icon}</div></div>";	

		$output .= "</div><!--wrap-story-->";	
		$output .= "</div>";

		return $output;
	}

         
} // End Element Class
// Element Class Init
new Story();    