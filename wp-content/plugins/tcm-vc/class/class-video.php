<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}
if ( ! class_exists( 'Video' ) ) {
	class Video {
		/**
		 * Hook into WordPress.
		 *
		 * @return	void
		 * @since	1.0
		 */
		function __construct() {
			// Initialize plugin.
			add_shortcode( 'video', array( $this, 'render_shortcode' ) );
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
				'name' 			=> __( 'Video', TCM_VC ),				
				'base' 			=> 'video',
				'description' 	=> __( '', TCM_VC ),
				'category'		=> __( 'TCM Modules', TCM_VC),
				// All the attributes, define as many as we need.
				'params' => array(

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Video URL', TCM_VC ),
						'param_name' 	=> 'video_url',
						'value' 			=> __( '', TCM_VC ),
						"description" 	=> __( "Enter link to video (Note: read more about available formats at WordPress <a href='http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F' target='_blank'>codex page</a>. <br>If is Vidyard video use https://embed.vidyard.com/share/{ADD VIDEO ID}", TCM_VC ),
						"group"			=> 'Video',
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Sub Title', TCM_VC ),
						'param_name' 	=> 'subtitle',
						'value' 			=> __( 'Eg: Resources', TCM_VC ),
						'description' 	=> __( 'This will show up above the title.', TCM_VC ),
						"group"			=> 'Content',
					),

					array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Title', TCM_VC ),
						'param_name' 	=> 'title',
						'value' 			=> __( 'Eg: Product Resources', TCM_VC ),
						'description' 	=> __( '', TCM_VC ),
						"group"			=> 'Content',						
					),

					array(
						"type" => "vc_link",
						"class" => "",
						"heading" => __( "CTA Link", TCM_VC ),
						"param_name" => "cta_link",
						"description" => __( "Add Link and Title.", TCM_VC ),	
						"group"			=> 'Content',															
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


			$video_url 		= esc_url( $atts['video_url'] );
			

			$subtitle		= $atts['subtitle'];
			$title 			= $atts['title'];

			$href 			= vc_build_link( $atts['cta_link'] );
			$url 			= esc_url( $href["url"] );
			$linkTitle 		= $href["title"];
			$target  		= $href['target'];
			$rel 			= $href['rel'];

			//Class and Id
			$extra_class	= $atts['extra_class'];
			$id 			= $atts['element_id']; 


			global $wp_embed;
			$embed = '';
			if ( is_object( $wp_embed ) ) {
				$embed = $wp_embed->run_shortcode( '[embed]' . $video_url . '[/embed]' );
			}

			//Output HTML
			$output = '';
			$output .= 	"<div class='wrap-video-content inverse-md vc_row wpb_row vc_row-fluid vc_row-o-equal-height vc_row-o-equal-height vc_row-o-content-middle vc_row-flex ${extra_class}' id='${element_id}'>";
			
			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-4 content-column'>";
			$output .= 	"<div class='vc_column-inner '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<div class='wpb_text_column wpb_content_element '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<p class='subtitle text-orange'>${subtitle}</p>";
			$output .= 	"<h2>${title}</h2>";
			if(!empty($url)) {
				$output .= 	"<p><a class='btn btn-orange margin-bottom-0 margin-top-0' href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>${linkTitle}</a></p>";
			}
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div><!--wpb_column-->";

			$output .= 	"<div class='wpb_column vc_column_container vc_col-sm-12 vc_col-md-8 video-column'>";
			$output .= 	"<div class='vc_column-inner '>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<div class='wpb_video_widget wpb_content_element vc_clearfix vc_video-aspect-ratio-169 vc_video-el-width-100 vc_video-align-center'>";
			$output .= 	"<div class='wpb_wrapper'>";
			$output .= 	"<div class='wpb_video_wrapper'>${embed}</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div>";
			$output .= 	"</div><!--wpb_column-->";

			$output .= 	"</div>";

			return $output;
		}
	}
	new Video();
}