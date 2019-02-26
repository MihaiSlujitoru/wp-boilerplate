<?php 
//https://someweblog.com/wordpress-custom-taxonomy-with-same-slug-as-custom-post-type/

/*
 * Replace Taxonomy slug with Post Type slug in url
 * Version: 1.1
 */
// function taxonomy_slug_rewrite($wp_rewrite) {
//     $rules = array();
//     // get all custom taxonomies
//     $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
//     // get all custom post types
//     $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');
    
//     foreach ($post_types as $post_type) {
//         foreach ($taxonomies as $taxonomy) {
	    
//             // go through all post types which this taxonomy is assigned to
//             foreach ($taxonomy->object_type as $object_type) {
                
//                 // check if taxonomy is registered for this custom type
//                 if ($object_type == $post_type->rewrite['slug']) {
		    
//                     // get category objects
//                     $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));
		    
//                     // make rules
//                     foreach ($terms as $term) {
//                         $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
//                     }
//                 }
//             }
//         }
//     }
//     // merge with global rules
//     $wp_rewrite->rules = $rules + $wp_rewrite->rules;
// }
// add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');


function __getPrimaryTaxonomyTerm($post, $taxonomy) {
   $termsQuery = [
  'parent' => 0,
  'taxonomy' => $taxonomy,
  'hide_empty' => false,
  'object_ids' => $post->ID
   ];
   $terms = get_terms($termsQuery);
   if ($terms) {
       if ( class_exists('WPSEO_Primary_Term') )
       {
           $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post->ID );
           $wpseo_primary_term = $wpseo_primary_term->get_primary_term();
           $term = get_term( $wpseo_primary_term );
           if (!is_wp_error($term)) {
               return $term;
           }
       }
       return $terms[0];
   }
   return null;
}

add_filter('post_type_link', 'products_cat_term_permalink', 10, 4);
function products_cat_term_permalink($post_link, $post, $leavename, $sample)
{
  if ( false !== strpos( $post_link, '%product-category%' ) ) {
  $product_category = __getPrimaryTaxonomyTerm($post, 'product-category');
  $slug = '';
  if ($product_category) {
  $slug = $product_category->slug;
  }
  $post_link = str_replace( '%product-category%', $slug, $post_link );
  }
  return $post_link;
}

function custom_post_type_rewrites() {
add_rewrite_rule( '^products/([^/]*)/([^/]*)/?', 'index.php?product=$matches[2]&product-category=$matches[1]', 'bottom');
}
add_action( 'init', 'custom_post_type_rewrites' );




