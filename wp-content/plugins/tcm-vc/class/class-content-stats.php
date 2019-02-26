<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'ContentStats' ) ) {
	class ContentStats {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'content_stats', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Content Stats', TCM_VC ),				
				'base' 			=> 'content_stats',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						"type" 			=> "textarea_html",
		            	"holder" 		=> "div",
		            	"class" 		=> "",						
						"heading" 		=> __( "Content", TCM_VC ),
						"param_name" 	=> "content",
						"value" 		=> __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
						"description" 	=> __( "", TCM_VC ),
						"group"			=> __( 'Content', TCM_VC),								
					),	


					array(
						'type' 			=> 'dropdown',
						'heading' 		=> __( 'Choose Gradient Color',  TCM_VC ),
						'param_name' 	=> 'choose_color',
						'value' 		=> array(
							__( 'Gradient Blue',  TCM_VC  ) 	=> 'gradient-blue-purple',
							__( 'Gradient Green',  TCM_VC  )	=> 'gradient-blue-green',
							__( 'Gradient Purple',  TCM_VC  )	=> 'gradeint-purple-blue',
						),
						"description" 	=> __( "It will affect the background gradient.", TCM_VC ),		
						"group"			=> __( 'Stats', TCM_VC),														
					),

					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Background Image', TCM_VC),
						'param_name' 	=> 'background_image',
						'description' 	=> __( 'Max Image Size: 1024px x 512px.', TCM_VC ),
						"group"			=> __( 'Stats', TCM_VC),								
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Stats %', TCM_VC ),
						'param_name' 	=> 'stats_percentage',
						'value' 		=> __( 'Eg: 20%', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),		
						"group"			=> __( 'Stats', TCM_VC),														
					),

					array(
						'type' 			=> 'textarea',
						'heading' 		=> __( 'Stats Description', TCM_VC ),
						'param_name' 	=> 'stats_description',
						'value' 		=> __( 'Text Only', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),	
						"group"			=> __( 'Stats', TCM_VC),																					
					),

					array(
						"type" 			=> "vc_link",
						"class" 		=> "",
						"heading" 		=> __( "CTA Link", TCM_VC ),
						"param_name" 	=> "cta_link",
						"description" 	=> __( "Add Link and Title.", TCM_VC ),
						"group"			=> __( 'Stats', TCM_VC),						
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

			$content 				= wpb_js_remove_wpautop($content, true);		


			$choose_color			= $atts['choose_color'];
			$image_url 				= wp_get_attachment_image_src(  $atts['background_image'] , '1440-700' , true );
			$image_url 				= esc_url( $image_url[0] );	

			$stats_percentage		= $atts['stats_percentage'];
			$stats_description 		= $atts['stats_description'];

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

			$output .= "<div class='wrap-content-stats vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-content-middle vc_row-flex ${$extra_class}' id='${id}'>";
			$output .= "<div class='wpb_column vc_column_container vc_col-sm-8 '>";
			$output .= "<div class='vc_column-inner'>";
			$output .= "<div class='wpb_wrapper wrap-content'>";
			$output .= $content;
			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "<div class='wpb_column vc_column_container vc_col-sm-4'>";
			$output .= "<div class='vc_column-inner'>";
			$output .= "<div class='wpb_wrapper wrap-stats ${choose_color}' style='background-image:url(${image_url})'>";
            $output .= "<p class='stats-p'><span class='stats'>${stats_percentage}</span> <span class='description'>${stats_description}</span></p>";
			if(!empty($url)) {	
				$output .= 	"<p><a class='btn btn-orange margin-bottom-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
			}            
			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";
			$output .= "</div>";

			return $output;
		}
	}
	new ContentStats();
}