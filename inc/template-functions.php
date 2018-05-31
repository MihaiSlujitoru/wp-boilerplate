<?php

function my_assets() {
    wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/css/style.css', array(), null, all );
    wp_enqueue_style('theme-css', bloginfo('stylesheet_url') , array(), null, all );
    
    //wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array() );

	//wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array() );
	//wp_enqueue_script( 'slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array( 'jquery' ), false, true );
	//wp_enqueue_script( 'jquery-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js' , array('jquery'), false, true );


	wp_enqueue_script( 'main-js', get_stylesheet_directory_uri()."/js/main.js",  array('jquery'), false, true );
}
add_action( 'wp_enqueue_scripts', 'my_assets' );


/*****************
	Easy Excerpts -> use <?php echo excerpt(25); ?> 
******************/
function generate_excerpt() {
    $content = get_post_field('post_content', get_post());
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return strip_tags($content);
}

function excerpt($limit) {
    $content = get_the_excerpt();
    if (empty($content)) {
        $content = generate_excerpt();
    }
    $excerpt = explode(' ', $content, $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

/*****************
	Add Widget Support
******************/

// function widgets_init() {
//     register_sidebar( array(
//         'name'          => 'Add Name',
//         'id'            => 'add-id',
//         'before_widget' => '',
//         'after_widget'  => '',
//         'before_title'  => '',
//         'after_title'   => '',
//     ));
// }
// add_action( 'widgets_init', 'widgets_init' );

// if ( is_active_sidebar( 'add-id' ) ) : 
// 	echo "<div class='add-class' id='add-unique-id'>";
// 	dynamic_sidebar( 'add-id' );
// 	echo "</div>";
// endif;


