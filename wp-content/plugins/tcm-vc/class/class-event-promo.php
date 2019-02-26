<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'EventPromo' ) ) {
	class EventPromo {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'event_promo', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Event Promo', TCM_VC ),				
				'base' 			=> 'event_promo',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Event Subtitle', TCM_VC ),
						'param_name' 	=> 'event_subtitle',
						'value' 		=> __( '', TCM_VC ),
						"description" 	=> __( '', TCM_VC ),
					),

					array(
						"type" => "textarea_html",
		            	"holder" => "div",
		            	"class" => "",						
						"heading" => __( "Event Content", TCM_VC ),
						"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
						"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
						"description" => __( "Enter your content.", TCM_VC )
					),


					array(
						"type" => "vc_link",
						"class" => "",
						"heading" => __( "CTA Link", TCM_VC ),
						"param_name" => "cta_link",
						"description" => __( "Add Link and Title.", TCM_VC ),
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
			$atts 			= vc_map_get_attributes($tag, $atts);

			$event_subtitle			= $atts['event_subtitle'];
			$event_content 			= wpb_js_remove_wpautop($content, true);		

			$href 					= vc_build_link( $atts['cta_link'] );
			$url 					= esc_url( $href["url"] );
			$linkTitle 				= $href["title"];
			$target  				= $href['target'];
			$rel 					= $href['rel'];
			

			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';
			$output .= 	"<div class='wpb_wrapper wrap-event-promo'>";
			$output .= 	"<div class='wpb_text_column wpb_content_element '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<p class='subtitle text-orange'>${event_subtitle}</p>";
			$output .= 	$event_content;
			$output .= 	"<p><a class='btn btn-orange margin-bottom-0 margin-top-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";

			return $output;
		}
	}
	new EventPromo();
}