<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'HeroTextGreen' ) ) {
	class HeroTextGreen {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'hero_text_green', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Hero Text Green', TCM_VC ),				
				'base' 			=> 'hero_text_green',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(
					array(
						'type' 			=> 'attach_image',
						'heading' 		=> __( 'Image', TCM_VC),
						'param_name' 	=> 'image',
						'description' 	=> __( 'Max Image Size: 768px x 768px.', TCM_VC ),
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Hero Sub Title', TCM_VC ),
						'param_name' 	=> 'hero_subtitle',
						'value' 			=> __( 'Eg: Resources', TCM_VC ),
						'description' 	=> __( 'Enter the subtitle for the hero. Usually 1 line of text. This will show up above the H1.', TCM_VC ),
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Hero Title', TCM_VC ),
						'param_name' 	=> 'hero_title',
						'value' 			=> __( 'Eg: Product Resources', TCM_VC ),
						'description' 	=> __( 'Enter the title for the Hero. Usually 1 line of text. This will be the H1.', TCM_VC ),
					),

					array(
						"type" => "textarea_html",
		            	"holder" => "div",
		            	"class" => "",						
						"heading" => __( "Content", TCM_VC ),
						"param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
						"value" => __( "<p>I am test text block. Click edit button to change this text.</p>", TCM_VC ),
						"description" => __( "Enter your content for the hero.", TCM_VC )
					),

					array(
						"type" => "vc_link",
						"class" => "",
						"heading" => __( "CTA Link", TCM_VC ),
						"param_name" => "cta_link",
						"description" => __( "Add Link and Title.", TCM_VC )				
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

			$image_id		= $atts['background_image'];
			$image			= wp_get_attachment_image( $atts['image']  , '768-768', "", array( "class" => "img-responsive" ) );	

			$hero_subtitle	= $atts['hero_subtitle'];
			$hero_title 	= $atts['hero_title'];
			$content 		= wpb_js_remove_wpautop($content, true);		

			$href 			= vc_build_link( $atts['cta_link'] );
			$url 			= esc_url( $href["url"] );
			$linkTitle 		= $href["title"];
			$target  		= $href['target'];
			$rel 			= $href['rel'];

			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 

			//Output HTML
			$output = '';

			$output .= 	"<div class='hero-text hero-text-green vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-equal-height vc_row-o-content-middle vc_row-flex ${extra_class}' id='${element_id}'>";
			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-7'>";
			$output .= 	"<div class='vc_column-inner'>";
			$output .= 	"<div class='wpb_wrapper'>";

			$output .= 	"<div class='wpb_wrapper-title'>";
			if( ! empty($hero_subtitle ) && !doing_filter( 'the_excerpt' )) { $output .= 	"<p class='subtitle text-green'>${hero_subtitle}</p>"; }
			if( ! empty($hero_title ) && !doing_filter( 'the_excerpt' )) { $output .= 	"<h1 class='sub-line sub-line-green'>${hero_title}</h1>"; }
			$output .= 	"</div>";	
			if( ! empty($content)) {
				$output .= 					"<div class='wpb_wrapper-content'>";
				$output .= 						$content;
				if(!empty($url)) {	
				$output .= 						"<a class='btn btn-green margin-bottom-0 margin-top-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a>";
				}
				$output .= 					"</div>";			
			}				
			$output .= 	"</div><!--wpb_wrapper-->";
			$output .= 	"</div><!--vc_column-inner-->";
			$output .= 	"</div><!--wpb_column-->";			

			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-5'>";
			$output .= 	"<div class='vc_column-inner '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	$image;
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";

			return $output;
		}
	}
	new HeroTextGreen();
}