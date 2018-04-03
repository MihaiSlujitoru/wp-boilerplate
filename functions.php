<?php

if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js", false, null);
	wp_enqueue_script('jquery');
}
function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}

add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
remove_action('wp_head', 'wp_generator');

/**
 * Template Functions
 */
//require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/mobile-nav-walker.php';



// Add default posts and comments RSS feed links to head.
add_theme_support( 'automatic-feed-links' );
/*
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 */
add_theme_support( 'title-tag' );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
) );

add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(   
			'master_menu' 		=> __('Master Menu'),
			'personal_menu' 	=> __('Personal Menu'),
			'commercial_menu' 	=> __('Commercial Menu'),
			'about_menu'	 	=> __('About Us Menu'),
			'social_menu'	 	=> __('Social Menu'),
			'footer_menu_left' 	=> __('Footer Menu Left'),
			'footer_menu_right' => __('Footer Menu Right'),
			'error_menu' 		=> __('Error Menu')
		)
	);
}

//Add excertp support 
add_post_type_support( 'page', 'excerpt' );

/*ADD SUPPORT FOR THUMBNAILS*/
add_theme_support( 'post-thumbnails' );
the_post_thumbnail( 'thumbnail' );     // Thumbnail (150 x 150 hard cropped)
the_post_thumbnail( 'medium' );        // Medium resolution (300 x 300 max height 300px)
the_post_thumbnail( 'medium_large' );  // Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
the_post_thumbnail( 'large' );         // Large resolution (1024 x 1024 max height 1024px)
the_post_thumbnail( 'full' );          // Full resolution (original size uploaded)

//add_image_size( '80-80-false', 80, 80 ); //
//add_image_size( '290-220', 290, 220, array('center', 'center')); //
