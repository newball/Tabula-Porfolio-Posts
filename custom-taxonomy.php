<?php
    
// - Work Taxonomy
// -- For categorizing the type of work each portfolio item falls under


function tabula_create_work_taxonomy() {
	$labels = array(
		'name'				=> _x('Work', 'Work'),
		'singular_name' 	=> _x('Work', 'Work'),
		'search_name'		=> __('Search Work'),
		'all_items'			=> __('All Work'),
		'parent_item'		=> __('Parent Work'),
		'parent_item_colon'	=> __('Parent Work'),
		'edit_item'			=> __('Edit Work'),
		'update_item'		=> __('Update Work'),
		'add_new_item'		=> __('Add New Work'),
		'new_item_name'		=> __('New Work'),
		'menu_name'			=> __('Work')
	);
	
	register_taxonomy('work', array('work'),
		array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'work' )
		)
	);
}

// - Skill Taxonomy
// -- For categorizing the type of skills each item requires


function tabula_create_skill_taxonomy() {
	$labels = array(
		'name'				=> _x('Skills', 'Skills'),
		'singular_name' 	=> _x('Skill', 'Skill'),
		'search_name'		=> __('Search Skills'),
		'all_items'			=> __('All Skills'),
		'parent_item'		=> __('Parent Skill'),
		'parent_item_colon'	=> __('Parent Skill'),
		'edit_item'			=> __('Edit Skill'),
		'update_item'		=> __('Update Skill'),
		'add_new_item'		=> __('Add New Skill'),
		'new_item_name'		=> __('New Skill'),
		'menu_name'			=> __('Skill')
	);
	
	register_taxonomy('skill', array('skill'),
		array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'skill' )
		)
	);
}

// get taxonomies terms links
function custom_taxonomies_terms_links(){
  // get post by post id
  $post = get_post( $post->ID );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post->ID, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      $out[] = "<li><strong>" . $taxonomy->label . ":</strong> ";
      foreach ( $terms as $term ) {
        $out[] =
          '  <a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a>";
      }
      $out[] = "</li>";
    }
  }

  return implode('', $out );
}
