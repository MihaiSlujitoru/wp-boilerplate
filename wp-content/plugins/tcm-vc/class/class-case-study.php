<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'CaseStudy' ) ) {
	class CaseStudy {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'case_study', array( $this, 'render_shortcode' ) );
			// Create as a Visual Composer addon.
	      	add_action( 'init', array( $this, 'create_shortcode' ), 999 );
		}

		/**
		 * Creates the necessary shortcode.
		 *
		 * @since 1.0
		 */
		public function create_shortcode() {
			if ( ! function_exists( 'vc_map' ) ) { return; }

			vc_map( array(
				'name' 			=> __( 'Case Study', TCM_VC ),				
				'base' 			=> 'case_study',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Image', TCM_VC),
						'param_name' 	=> 'image',
						'description' 	=> __( 'Max Image Size: 300px x 300px.', TCM_VC ),						
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Title', TCM_VC ),
						'param_name' 	=> 'title',
						'value' 			=> __( '', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),						
					),

					array(
						"type" 			=> "textarea",
		            	"holder" 		=> "div",
		            	"class" 		=> "",						
						"heading" 		=> __( "Blockquote", TCM_VC ),
						"param_name" 	=> "blockquote",
						"description" 	=> __( "", TCM_VC ),
					),	

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Cite', TCM_VC ),
						'param_name' 	=> 'cite',
						'value' 		=> __( '', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),		
					),

					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Person Image', TCM_VC),
						'param_name' 	=> 'person_image',
						'description' 	=> __( 'Max Image Size: 300px x 300px.', TCM_VC ),						
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Bubble Stats', TCM_VC),
						'param_name' 	=> 'bubble_stats',
						'description' 	=> __( '', TCM_VC ),						
					),	
					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Bubble Text', TCM_VC),
						'param_name' 	=> 'bubble_text',
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
			$atts 					= vc_map_get_attributes($tag, $atts);

			$content 				= wpb_js_remove_wpautop($content, true);		

			$image					= wp_get_attachment_image( $atts['image']  , 'medium', "", array( "class" => "img-responsive" ) );	
			$title 					= $atts['title'];

			$blockquote 			= $atts['blockquote'];
			$cite 					= $atts['cite'];


			$person_image			= wp_get_attachment_image( $atts['person_image']  , 'medium', "", array( "class" => "img-responsive" ) );	
			$bubble_stats			= $atts['bubble_stats'];
			$bubble_text			= $atts['bubble_text'];

			$href 					= vc_build_link( $atts['cta_link'] );
			$url 					= esc_url( $href["url"] );
			$linkTitle 				= $href["title"];
			$target  				= $href['target'];
			$rel 					= $href['rel'];
			
			//Class and Id
			$extra_class			= $atts['extra_class'];
			$id 					= $atts['element_id']; 

			//Output HTML
			$output = '';

			$output .= "<div class='wrap-content-case-study vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-content-middle vc_row-flex ${$extra_class}' id='${id}'>";
			
			$output .= "<div class='wpb_column vc_column_container vc_col-md-6 '>";
			$output .= "<div class='vc_column-inner'>";
			$output .= "<div class='wpb_wrapper wrap-content wrap-content'>";

			$output .= "<div class='wrap-image'>${image}</div>";
			$output .= "<h2 class='sub-line sub-line-blue sub-line-top-30'>${title}</h2>";
			$output .= "<blockquote itemscope itemtype='http://schema.org/Person'>";
			$output .= "<p>\"${blockquote}\"</p>";
			if(!empty($cite)) {
			$output .= "<cite class='cite' itemprop='name'>- ${cite}</cite>";
			}
			$output .= "</blockquote>";


			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";

			$output .= "<div class='wpb_column vc_column_container vc_col-md-5 vc_col-md-offset-1'>";
			$output .= "<div class='vc_column-inner'>";
			$output .= "<div class='wpb_wrapper'>";

			$output .= "<div class=' wrap-bubbles'>";
       		$output .= "<div class='wrap-bubble-text'><p><span>${bubble_stats}</span> ${bubble_text}</p></div>";
       		$output .= "<div class='wrap-person-img'>${person_image}</div>";
       		$output .= "</div>";

			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";

			if(!empty($url)) {	
				$output .= "<div class='wpb_column vc_column_container vc_col-sm-12 '>";
				$output .= "<div class='vc_column-inner'>";
				$output .= "<div class='wpb_wrapper wrap-content wrap-cta'>";
				$output .= "<p><a class='btn btn-orange margin-bottom-0 margin-top-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
				$output .= "</div>";
				$output .= "</div>";
				$output .= "</div>";
			}

			$output .= "</div>";

			return $output;
		}
	}
	new CaseStudy();
}