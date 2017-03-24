<?php

/********************
Display Categories (Taxonomy) of Products and Resources 
*********************/
function renderTaxonomies($postId, $taxonomy, $title ) {

	$term  = wp_get_post_terms($postId , $taxonomy,	array("fields" => "names"));
	
	if(count($term) > 0 ) {
		echo "<p class='wrap-product-cat'><span class='product-cat'>" . $title . "</span>";
			foreach ($term as $term1) {
				echo "<span class='product-name'>" . $term1 . " "; 
				if(count($term) > 1) {
					echo "<span class='tooltip tooltip-span' title='";
					break;
				} 
			}
			if(count($term) > 1) {
				echo "<ul>";
				foreach (array_slice($term, 1) as $term2) {
					echo "<li>" . esc_attr($term2) . "</li>";
				}
				echo "</ul>";
				echo " '>more...</span>";
			}
			if(count($term) > 0){
				echo "</span>";
			}
		echo "</p>";
	}
}

function isFilteredBy($taxonomy, $slug) {
	$qv = get_query_var($taxonomy);
	if (!is_array($qv)) {
		$qv = [$qv];
	}
	return in_array($slug, $qv);
}

function __renderTaxonomyFilter($taxonomy, $title, $terms) {
    $qv = get_query_var($taxonomy);
    if (!is_array($qv)) {
        $qv = [$qv];
    }
    $fieldName = $taxonomy.'[]';
    echo "<select name='$fieldName' id='$taxonomy'>";
    echo "<option value=''>$title</option>";
    foreach ($terms as $term) {
        $selected = in_array($term->slug, $qv) ? 'selected' : '';
        echo "<option $selected value='" . $term->slug .  "'>" .$term->name . "</option>";
    }
    echo "</select>";
}

function renderTaxonomyFilter($taxonomy, $title) {
	$args = array( 'taxonomy' => $taxonomy, 'hide_empty' => false );
	$terms = get_categories($args);
    __renderTaxonomyFilter($taxonomy, $title, $terms);
}

function renderNeighborTaxonomyFilter($taxonomy, $title, $filterTaxonomy, $postType) {
    $filterQueryVars = get_query_var($filterTaxonomy);
    if (!is_array($filterQueryVars)) {
        $filterQueryVars = [$filterQueryVars];
    }

    $args = array( 'taxonomy' => $taxonomy, 'hide_empty' => false );
    $postQueryArgs = array(
        'post_type'=> $postType,
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            "relation" => "AND",
            array(
                "taxonomy" => $filterTaxonomy,
                "field" => "slug",
                "terms" => $filterQueryVars
            ),
            array(
                "taxonomy" => $taxonomy,
                "field" => "slug",
                "terms" => wp_list_pluck(get_categories($args), 'slug')
            )
        )
    );

    $postIds = get_posts($postQueryArgs);

    $terms = wp_get_object_terms($postIds, $taxonomy);

    __renderTaxonomyFilter($taxonomy, $title, $terms);
}

function renderSidebarTaxonomyFilter($taxonomy, $title) {
	$args = array( 'taxonomy' => $taxonomy );
	$terms = get_categories($args);
	$qv = get_query_var($taxonomy);
	if (!is_array($qv)) {
		$qv = [$qv];
	}
	$fieldName = $taxonomy.'[]';

	echo "<div class='sidebar-cat'>";
	echo "<p class='title'>$title</p>";
	echo "<div class='wrap-filters'>";
	foreach ($terms as $term) {
		$selected = in_array($term->slug, $qv) ? 'checked' : '';
		echo "<label for='$term->term_id'><input type='checkbox' name='$fieldName' value='$term->slug' $selected id='$term->term_id'>$term->name</label><br>";
	}
	echo "</div>";
	echo "</div>";
}