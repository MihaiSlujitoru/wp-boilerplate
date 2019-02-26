<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'Location' ) ) {
	class Location {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'location', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Location', TCM_VC ),				
				'base' 			=> 'location',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						'type' 			=> 'textarea_raw_html',
						'heading' 		=> __( 'Map embed iframe', TCM_VC),
						'param_name' 	=> 'google_maps',
						'description' 	=> __( 'Visit <a href="https://www.google.com/maps" target="_blank">Google maps</a> to create your map (Step by step: 1) Find location 2) Click the cog symbol in the lower right corner and select "Share or embed map" 3) On modal window select "Embed map" 4) Copy iframe code and paste it).', TCM_VC ),
					),

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
						"description" => __( "It will affect the border and location title", TCM_VC ),		
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Location Title', TCM_VC ),
						'param_name' 	=> 'location_title',
						'value' 		=> __( 'Eg: Terminus HQ', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),		
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Location Address', TCM_VC ),
						'param_name' 	=> 'location_address',
						'value' 		=> __( 'Text Only', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),		
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Location Phone Number', TCM_VC ),
						'param_name' 	=> 'location_phone_number',
						'value' 		=> __( 'Text Only', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),		
					),

					array(
						"type" => "textarea",
		            	"holder" => "div",
		            	"class" => "",						
						"heading" => __( "Content", TCM_VC ),
						"param_name" => "location_content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
						"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
						"description" => __( "", TCM_VC ),								
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

			$google_maps 	= rawurldecode(base64_decode( $atts['google_maps'] ));

			$choose_color			= $atts['choose_color'];
			$location_title			= $atts['location_title'];
			$location_address 		= $atts['location_address'];
			$location_phone_number 	= $atts['location_phone_number'];
			$content 				= wpb_js_remove_wpautop($atts['location_content'], true);		


			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';


			$output .= 	"<div class='wpb_text_column wpb_content_element'>";

			$output .= "<div class='location'>";

			$output .= "<div class='location-image border-${choose_color}'>";
			$output .= "<div class='wpb_gmaps_widget vc_map_responsive'>";
			$output .= "<div class='wpb_wrapper'>";
			$output .= "<div class='wpb_map_wraper'>";
			$output .= $google_maps;
			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "<div class='location-info'>";
			$output .= "<p class='subtitle text-${choose_color}'>${location_title}</p>";
			$output .= "<p class='lead'>${location_address}<br>${location_phone_number}</p>";
			$output .= "<div class='location-content'>${content}</div>";
			$output .= "</div>";

			$output .= 	"</div>";
			$output .= 	"</div>";
			return $output;
		}
	}
	new Location();
}