<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'IconText' ) ) {
	class IconText {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'icon_text', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Icon Text', TCM_VC ),				
				'base' 			=> 'icon_text',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Icon', TCM_VC),
						'param_name' 	=> 'icon',
						'description' 	=> __( 'Icon Size: 150px x 150px.', TCM_VC ),
					),					

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Text', TCM_VC ),
						'param_name' 	=> 'text',
						'value' 		=> __( '', TCM_VC ),
						"description" 	=> __( '', TCM_VC ),
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

			$icon			= wp_get_attachment_image( $atts['icon']  , 'thumbnail', "", array( "class" => "img-responsive" ) );	
			$text 			= $atts['text'];

			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';

			$output .= 	"<div class='wrap-icon-text ${extra_class}' id='${element_id}'>";
			$output .=  "<div class='icon'>${icon}</div>";
			$output .=  "<div class='text'><p>${text}</p></div>";
			$output .= 	"</div><!--wrap-icon-text-->";

			return $output;
		}
	}
	new IconText();
}