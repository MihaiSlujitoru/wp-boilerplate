 <?php

function my_assets() {
    // wp_enqueue_style( 'js_composer_front' );
    // wp_enqueue_style( 'js_composer_custom_css' );

    wp_enqueue_style('theme-custom', get_template_directory_uri() . '/assets/css/style.css', array(), null, 'all' );
    wp_enqueue_style('theme', get_template_directory_uri() . '/style.css' , array(), null, 'all' );
    

	//wp_enqueue_style('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css', array(), 'all' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        wp_enqueue_script( 'comment-reply' ); 
    }

	//wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array( 'jquery' ), false, true );
	//wp_enqueue_script( 'jquery-modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js' , array('jquery'), false, true );

    wp_enqueue_script( 'wpb_composer_front_js' );

	wp_enqueue_script( 'main', get_template_directory_uri()."/assets/js/main.js",  array('jquery'), false, true );
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
    Load Template from plugins
******************/
function load_template_part($template_name, $part_name=null) {
    ob_start();
    get_template_part($template_name, $part_name);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

/*****************
    Add Search Support
******************/

// add_filter('wp_nav_menu_items','add_search_box_to_primary_menu', 10, 2);
// function add_search_box_to_primary_menu( $items, $args ) {
//     if( $args -> theme_location == 'master_menu_helper' ) { 
//         $items .= '<li class="menu-item menu-item-search cf">';
//         $items .= '<div class="search-toggle"><i class="fo-icon-search"></i></div>';
//         $items .= '<form role="search" method="get" class="search-form" action="' .  home_url( '/' ) . '">';
//         $items .= '<span class="visually-hidden">' . _x( 'Search for:', 'label' ) . '</span>';
//         $items .= '<input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search Terminus.com', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" title="' . esc_attr_x( 'Search Terminus.com', 'label' ) . '" />';
//         $items .= '<button type="submit" class="search-submit"><i class="fo-icon-search"></i><span class="visually-hidden">Search</span></button>';
//         $items .= '</form>';
//         $items .= '</li>'; 
//     }
//     return $items; 
// }

/*<div class='menu-search'>
    <button class='search-toggle' type='button' aria-label="Open search form" aria-controls="search" aria-expanded="false" ><span class='sr-text'>Open search form</span></button>
    <form role='search' method='get' class='search-form' id='search' action='<?php echo home_url( '/' ) ?>'>
        <span class='sr-text'><?php echo _x( 'Search for:', 'label' ) ?></span>
        <input type='search' class='search-field' placeholder='<?php echo esc_attr_x( 'Search...', 'placeholder' ) ?>' value='<?php get_search_query(); ?>' name='s' title='<?php echo esc_attr_x( 'Search...', 'label' ) ?>' />
        <button type='submit' class='search-submit'><span class='sr-text'>Search</span></button>
    </form>
</div>*/


/*****************
    Display Categories
******************/
function show_categories( $post_type, $list_style )  {
    if(empty($list_style)) {
        $list_style = 'list';
    }
    $categories_args= array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 0,
        'echo'                => 1,
        'exclude'             => '',
        'exclude_tree'        => '',
        'feed'                => '',
        'feed_image'          => '',
        'feed_type'           => '',
        'hide_empty'          => 1,
        'hide_title_if_empty' => true,
        'hierarchical'        => true,
        'order'               => 'ASC',
        'orderby'             => 'name',
        'separator'           => ', ',
        'show_count'          => 0,
        'show_option_all'     => '',
        'show_option_none'    => __( 'No categories' ),
        'style'               => $list_style,
        'taxonomy'            => $post_type,
        'title_li'            => __( '' ),
        'use_desc_for_title'  => 1,
    ); 

    wp_list_categories( $categories_args );

}

/*****************
    Display Archives
******************/
function show_monthly_archive( $post_type ) 
{
    $current_year_args = array(
        'type'               => 'monthly',
        'limit'              => '4',
        'format'             => 'html',
        'before'             => '',
        'after'              => '',
        'show_post_count'    => false,
        'echo'               => 1,
        'order'              => 'DESC',
        'post_type'          => $post_type,
        'wpse__current_year' => true
    );

    wp_get_archives( $current_year_args );
}

function show_yearly_archive( $post_type )  {
    $previous_years_args = array(
        'type'              => 'yearly',
        'limit'             => '3',
        'format'            => 'html', 
        'before'            => '',
        'after'             => '',
        'show_post_count'   => false,
        'echo'              => 1,
        'order'             => 'DESC',
        'post_type'         => $post_type,
        'wpse__current_year' => false

    );
    
    wp_get_archives( $previous_years_args );
}

function filter_monthly_archives( $text, $r )  {
    // Check if our custom parameter is set, if not, bail early
    if ( !isset( $r['wpse__current_year'] ) )
        return $text;

    // If wpse__current_year is set to true
    if ( true === $r['wpse__current_year'] )
        return $text . " AND YEAR(post_date) = YEAR (CURRENT_DATE)";

    // If wpse__current_year is set to false
    if ( false === $r['wpse__current_year'] )
        return $text . " AND YEAR(post_date) < YEAR (CURRENT_DATE)";

    return $text;
}

add_filter( 'getarchives_where', 'filter_monthly_archives', 10, 2 );



/*****************
    Adds CSS class to currently selected archive
******************/

function theme_get_archives_link ( $link_html ) {
   preg_match ("/href='(.+?)'/", $link_html, $url);

    global $wp;
    static $current_url;
    if( empty( $current_url ) ) {
        $current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request.'/' ) );
    }

    if ($current_url == $url[1]) {
        $link_html = str_replace("<li>", "<li class='current-cat'>", $link_html);
    }
      return $link_html;
}
add_filter("get_archives_link", "theme_get_archives_link");


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

/*****************
    Pagination
******************/


function pagination($pages = '', $range = 2 ) {  
    $showitems = ($range * 2)+1;  
    global $paged;
    if(empty($paged)) $paged = 1;
    if($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages) {
            $pages = 1;
        }
    }   
    $html = "";
    if(1 != $pages) {
        $html .= "<nav class='wrap-pagination' id='paginglabel' aria-label='Pagination Navigation'>";
        $html .= "<ol class='pagination' aria-labelledby='paginglabel'>";
            // /if($paged > 1 && $showitems < $pages){
                $html .= "<li class='pagination-previous' " . ( (($paged >= 1 || $showitems < $pages) && $paged != 1 )  ? 'aria-disabled="false"' : ' aria-disabled="true" data-disabled="true" ' ) . ">";
                $html .= "<a href='".get_pagenum_link($paged - 1)."' aria-label='Previous Page' >";
                $html .= "<span class='sr-text'>Previous Page</span>";
                $html .= "</a>";
                $html .= "</li>"; 
            // }
            for ($i=1; $i <= $pages; $i++) {
                if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                    if($paged == $i) {
                        $html .= "<li class='page-active'><span  aria-label='Current Page, Page ${i}' aria-current='true' >${i}</span></li>";
                    } else {
                        $html .= "<li class='page-link'><a href='".get_pagenum_link($i)."' aria-label='Go to Page ${i}'>${i}</a></li>";    
                    }
                }
            }
            // if ($paged < $pages && $showitems < $pages) {
                $html .= "<li  class='pagination-next ${paged} ${pages} ${showitems}'  " . ((($paged <= $pages || $showitems <= $pages) && $paged != $pages  ) ? 'aria-disabled="false"' : ' aria-disabled="true" data-disabled="true" ' ) . ">";
                $html .= "<a href='".get_pagenum_link($paged + 1)."' aria-label='Next Page'>";
                $html .= "<span class='sr-text'>Next Page</span>";
                $html .= "</a>";
                $html .= "</li>";
            // }
        $html .= "</ol>";
        $html .= "</nav>\n";
        return $html;
    }
}


/*****************
    WPBakery - Visual Composer
******************/
// Remove “Edit with Visual Composer” from WordPress Admin Bar
function vc_remove_wp_admin_bar_button() {
    remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'vc_remove_wp_admin_bar_button' );


// Remove “Edit with WPBakery Page Builder” link
function vc_remove_frontend_links() {
    vc_disable_frontend();
}
add_action( 'vc_after_init', 'vc_remove_frontend_links' );