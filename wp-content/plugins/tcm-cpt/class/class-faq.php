<?php 

// Register Custom Post Type for FAQ
function custom_post_type_faq() {

	$labels = array(
		'name'                  => 'FAQ\'s',
		'singular_name'         => 'FAQ',
		'menu_name'             => 'FAQ\'s',
		'name_admin_bar'        => 'FAQ\'s',
		'archives'              => 'FAQ\'s Archives',
		'attributes'            => 'FAQ\'s Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New FAQ',
		'new_item'              => 'New Item FAQ',
		'edit_item'             => 'Edit Item FAQ',
		'update_item'           => 'Update Item FAQ',
		'view_item'             => 'View Item FAQ',
		'view_items'            => 'View Items FAQ',
		'search_items'          => 'Search Item FAQ',
		'not_found'             => 'Not FAQ found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'FAQ\'s list',
		'items_list_navigation' => 'FAQ\'s list navigation',
		'filter_items_list'     => 'Filter FAQ\'s list',
	);
	$rewrite = array(
		'slug'                  => 'faq',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => false,
	);
	$args = array(
		'label'                 => 'FAQ',
		'description'           => 'FAQ Post Type',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'faq-category' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
	);
	register_post_type( 'faq', $args );

}
add_action( 'init', 'custom_post_type_faq', 0 );



function create_faq_taxonomies() {

	$labels = array(
		'name'              => _x( 'FAQ Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'FAQ Categories', 'taxonomy singular name' ),
		'search_items'      => __( 'Search FAQ Categories' ),
		'all_items'         => __( 'All FAQ Categories' ),
		'parent_item'       => __( 'Parent FAQ Categories' ),
		'parent_item_colon' => __( 'Parent FAQ Categories:' ),
		'edit_item'         => __( 'Edit FAQ Categories' ),
		'update_item'       => __( 'Update FAQ Categories' ),
		'add_new_item'      => __( 'Add New FAQ Categories' ),
		'new_item_name'     => __( 'New FAQ Categories Name' ),
		'menu_name'         => __( 'FAQ Categories' ),
	);

	$rewrite = array(
		'slug'                  => 'faq-category',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => false,
	);	

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => $rewrite,
	);

	register_taxonomy( 'faq-category', array( 'faq' ), $args );
}

add_action( 'init', 'create_faq_taxonomies', 0 );
