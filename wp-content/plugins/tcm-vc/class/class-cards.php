<?php
/**
 *  @package TCM for Visual Composer.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly.
}

/*******************************/
/* Cards 				*/
/*******************************/

vc_map( array(
	'name' 							=> __( 'Cards', TCM_VC ),				
	'base' 							=> 'cards',
	'description' 					=> __( '', TCM_VC ),
	'category'						=> __( 'TCM Modules', TCM_VC),
	'as_parent' 					=> array(
		'only' => 'card',
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
			'param_name' 	=> 'cards_header',
			'value' 		=> __( 'Case Studies', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			'type' 			=> 'textarea',
			'heading' 		=> __( 'Header Description', TCM_VC ),
			'param_name' 	=> 'cards_description',
			'value' 		=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
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
));

/*******************************/
/* Card Slide */
/*******************************/
vc_map( array(
	'name' 					=> __('Card', TCM_VC),
	'base'					=> 'card',
	'content_element' 		=> true,
	'as_child' 				=> array('only' => 'cards'), // Use only|except attributes to limit parent (separate multiple values with comma)				
	'js_view' 				=> 'VcCardTitle',				
	'admin_enqueue_js' 		=> array(plugin_dir_url( __FILE__ ).'../js/card_content.js'),	
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
			"description" => __( "It will affect the content sub-line.", TCM_VC )	,
		),

		array(
			'type' 			=> 'attach_image',
			'heading' 		=> __( 'Image', TCM_VC),
			'param_name' 	=> 'image',
			'description' 	=> __( 'Image. Image Size: 464px x 228px.', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Title', TCM_VC ),
			'param_name' 	=> 'title',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),			

		array(
			'type' 			=> 'textarea',
			'heading' 		=> __( 'Content', TCM_VC ),
			'param_name' 	=> 'card_content',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),		

		array(
			'type' 			=> 'textarea',
			'heading' 		=> __( 'Quote', TCM_VC ),
			'param_name' 	=> 'quote',
			'value' 			=> __( '', TCM_VC ),
			'description' 	=> __( '', TCM_VC ),
		),

		array(
			'type' 			=> 'textfield',
			'heading' 		=> __( 'Citation', TCM_VC ),
			'param_name' 	=> 'citation',
			'value' 			=> __( '', TCM_VC ),
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
/* Short Code for Cards */
/*******************************/

function render_cards_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$cards_header 		=	$atts['cards_header'];
	$cards_description 	=	wpb_js_remove_wpautop($atts['cards_description'], true);

	//Class and Id
	$id 			= $atts['element_id']; 
	$extra_class	= $atts['extra_class'];

	$output = "";
	$output .= "<div class='wrap-cards ${extra_class}' id='${element_id}' >";
	if( ! empty($cards_header)) {
		$output .= "<div class='cards-header'>";
		$output .= "<h2 class='text-center'>${cards_header}</h2>";
		$output .= $cards_description;
		$output .= "</div><!--cards-header-->";
	}
	$output .= "<div class='cards slick-slider'>" . apply_filters('the_content', $content). "</div>";	
	$output .= "</div>";
	return $output;
}


/*******************************/
/* Short code for Card */
/*******************************/
function render_card_shortcode($atts, $content, $tag) {
	$atts 			= vc_map_get_attributes($tag, $atts);

	$choose_color 	= 	$atts['choose_color'];

	$image			= wp_get_attachment_image( $atts['image']  , '464-228', "", array( "class" => "img-responsive" ) );	

	$title 			= $atts['title'];
	$card_content 	= wpb_js_remove_wpautop($atts['card_content'], true);

	$quote			= $atts['quote'];
	$citation 		= $atts['citation'];

	$href 			= vc_build_link( $atts['cta_link'] );
	$url 			= esc_url( $href["url"] );
	$linkTitle 		= $href["title"];
	$target  		= $href['target'];
	$rel 			= $href['rel'];

	//Class and Id
	$extra_class	= $atts['extra_class'];
	$id 			= $atts['element_id']; 

   	$output = "";

	$output .= "<div class='slick-slide slick-slide-card ${extra_class}' data-color='${choose_color}' id='${id}'>";
	$output .= "<div class='card'>";
	if(!empty($url)) {	
	$output .= "<a href='${url}' title='${linkTitle}' target='" . (!empty($target) ? $target : '_self') . "' rel='${rel}'>";
	}
	$output .= "<div class='card-header'>${image}</div>";	
	$output .= "<div class='card-body'>";
	$output .= "<div class='card-content sub-line sub-line-top-20 sub-line-${choose_color}'>";
	$output .= "<h3 class='card-title'>${title}</h3>";
	$output .= $card_content;
	$output .= "</div>";
	$output .= "<blockquote itemscope itemtype='http://schema.org/Person'>";
	$output .= "<p class='blockquote'>\"${quote}\"</p>";
	if(!empty($citation)) {
	$output .= "<cite class='cite text-${choose_color}' itemprop='name'>${citation}</cite>";
	}
	$output .= "</blockquote>";
	$output .= "</div>";
	if(!empty($url)) {	
	$output .= "</a>";
	}	
	$output .= "</div>";
	$output .= "</div>";

	return $output;
}



add_shortcode( 'cards', 'render_cards_shortcode' ) ;
add_shortcode( 'card', 'render_card_shortcode' ) ;		


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
   class WPBakeryShortCode_cards extends WPBakeryShortCodesContainer {};
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_card extends WPBakeryShortCode {};
}