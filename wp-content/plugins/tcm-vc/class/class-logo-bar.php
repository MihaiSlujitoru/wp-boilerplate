<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'LogoBar' ) ) {
	class LogoBar {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'logo_bar', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Logo Bar', TCM_VC ),				
				'base' 			=> 'logo_bar',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(

					array(
						'type' 			=> 'attach_images',
						'heading' 		=> __( 'Logo Images', TCM_VC),
						'param_name' 	=> 'logo_images',
						'description' 	=> __( 'This is the promo image. Image Size: 300px x 300px.', TCM_VC ),
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


			$logo_images= explode(',',  $atts['logo_images']);

			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';
			$output .= 	"<div class='wrap-logo-bar'>";
			foreach( $logo_images as $logo_image ){
				$output .= "<div class='logo-image'>";
				$output .= wp_get_attachment_image( $logo_image ,'medium' , array( "class" => "img-responsive" ) );
				$output .= "</div>";
			}
			$output .= 	"</div>";

			return $output;
		}
	}
	new LogoBar();
}