<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'LeftContentRightImage' ) ) {
	class LeftContentRightImage {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'left_content_right_image', array( $this, 'render_shortcode' ) );
			// Create as a Visual Composer addon.
	      	add_action( 'init', array( $this, 'create_shortcode' ), 999 );
		}

		/**
		 * Creates the necessary shortcode.
		 *
		 * @since 1.0
		 */
		public function create_shortcode() {
			if ( ! function_exists( 'vc_map' ) ) {
			  	return;
		  	}

			vc_map( array(
				'name' 			=> __( 'Left Content Right Image', TCM_VC ),				
				'base' 			=> 'left_content_right_image',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
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
						'group'			=> __( 'Left Content', TCM_VC),		
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Sub Title', TCM_VC ),
						'param_name' 	=> 'subtitle',
						'value' 		=> __( 'Eg: Resources', TCM_VC ),
						'description' 	=> __( 'Enter the subtitle for the hero. Usually 1 line of text. This will show up above the title.', TCM_VC ),
						'group'			=> __( 'Left Content', TCM_VC),		
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Title', TCM_VC ),
						'param_name' 	=> 'title',
						'value' 		=> __( 'Eg: Product Resources', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),
						'group'			=> __( 'Left Content', TCM_VC),		
					),

					array(
						"type" => "textarea_html",
		            	"holder" => "div",
		            	"class" => "",						
						"heading" => __( "Content", TCM_VC ),
						"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
						"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
						"description" => __( "", TCM_VC ),
						'group'			=> __( 'Left Content', TCM_VC),								
					),			

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Element ID', TCM_VC ),
						'param_name' 	=> 'element_id',
						'value' 			=> __( '', TCM_VC ),
						'description' 	=> __( 'Enter element ID (Note: make sure it is unique and valid).', TCM_VC ),
						'group'			=> __( 'Left Content', TCM_VC),						
					),

					array(
						'type'			=> 'textfield',
						'heading' 		=> __( 'Extra class name', TCM_VC ),
						'param_name' 	=> 'extra_class',
						'value' 			=> __( '', TCM_VC ),
						'description' 	=> __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', TCM_VC ),
						'group'			=> __( 'Left Content', TCM_VC),						
					),		

					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Image', TCM_VC),
						'param_name' 	=> 'image',
						'description' 	=> __( 'Max Image Size: 1024px x 1024px.', TCM_VC ),
						'group'			=> __( 'Right Image', TCM_VC),		
					),								
				),
			) );
		}


		/**
		*
		* @param array  $atts - The attributes of the shortcode.
		* @param string $content - The content enclosed inside the shortcode if any.
		* @return string - The rendered html.
		* @since 1.0
		*/
		public function render_shortcode( $atts, $content, $tag ) {
			//Get Attributes
			$atts 			= vc_map_get_attributes($tag, $atts);

			$image			= wp_get_attachment_image( $atts['image']  , 'large', "", array( "class" => "img-responsive" ) );	


			$choose_color	= $atts['choose_color'];
			$hero_subtitle	= $atts['subtitle'];
			$hero_title 	= $atts['title'];
			$content 		= wpb_js_remove_wpautop($content, true);		



			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';

			$output .= 	"<div class='left-content-right-image vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-equal-height vc_row-o-content-middle vc_row-flex ${extra_class}' id='${element_id}'>";
			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-6'>";
			$output .= 	"<div class='vc_column-inner'>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<div class='wpb_text_column wpb_content_element '>";
			if( ! empty($content)) {
			$output .= 	"<div class='wpb_wrapper-content sub-line sub-line-top-30 sub-line-${choose_color}'>";
				if( ! empty($hero_subtitle ) && !doing_filter( 'the_excerpt' )) { $output .= 	"<p class='subtitle text-${choose_color}'>${hero_subtitle}</p>"; }
				if( ! empty($hero_title ) && !doing_filter( 'the_excerpt' )) { $output .= 	"<h3 class='text'>${hero_title}</h3>"; }			
				$output .= 	$content;
			$output .= 	"</div>";			
			}
			$output .= 	"</div>";
			$output .= 	"</div><!--wpb_wrapper-->";
			$output .= 	"</div><!--vc_column-inner-->";
			$output .= 	"</div><!--wpb_column-->";			

			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-6'>";
			$output .= 	"<div class='vc_column-inner '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<div class='wpb_single_image wpb_content_element vc_align_center'>";
			$output .= 	"<figure class='wpb_wrapper vc_figure'>";
			$output .= 	"<div class='vc_single_image-wrapper'>";
			$output .= 	$image;
			$output .= "</div>";
			$output .= 	"</figure>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			return $output;
		}
	}
	new LeftContentRightImage();
}