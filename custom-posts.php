<?php

function tabula_portfolio() {
	// Argument definition for items
	$postTypeArgs = array(
		'labels' => array(
				'name' => __( 'Portfolio' ),
				'singular_name' => __( 'Portfolio' ),
				'add_new' => 'Add New Portfolio Item',
				'all_items' => 'Portfolio',
				'add_new_item' => 'New Item',
				'edit_item' => 'Edit Item',
				'new_item' => 'New Item',
				'view_item' => 'View Item',
				'search_items' => 'Search Portfolio Items',
				'not_found' => 'No Portfolio Items Found',
				'not_found_in_trash' => 'No Portfolio Items Found in Trash',
				'parent_item_colon' => 'Item',
				'menu_name' => 'Portfolio'
				 ),
		'description' => 'Add a portfolio items to the portfolio section',
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-images-alt2',
		'capability_type' => 'post',
		'capabilities' => array('edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts', 'publish_posts', 'read_private_posts'),
		'map_meta_cap' => true,
		'hierarchical' => false,
		'supports' => array('title', 'editor', 'thumbnail'),		
		'register_meta_box_cb' => 'trpremier_add_item_information',
		'taxonomies' => array('work', 'skill'),
		'has_archive' => true,
		'rewrite' => array(
			"slug" => "portfolio",
			'with_front' => 'false',
			'feeds' => 'true',
			'pages' => 'true' ),
		'query_var' => 'string',
		'can_export' => 'true'
		);

        register_post_type( 'tabula-portfolio', $postTypeArgs);
}

/* Metabox Setup for Portfolio Posts */

function trpremier_add_item_information() {
	add_meta_box(
		'trpremier_meta_website',
		__( 'Website Link'),
		'trpremier_meta_box_website',
		'tabula-portfolio',
		'normal',
		'high'
		);
}

/* Metabox Form */

function trpremier_meta_box_website($post){
	// Use nonce for verification
	
	// Noncename needed to verify where the data originated
    wp_nonce_field('website_meta_box', '_nonce_website_link');
	
	$value = get_post_meta($post->ID, 'trpremier_portfolio_link', true);
	
	// Width
	echo '<label for="trpremier_portfolio_link" class="screen-reader-text">';
    _e("Website URL", 'tppremier_text');
    echo '</label>';
  	echo '<input type="text" id="trpremier_portfolio_link" name="trpremier_portfolio_link" value="' . esc_attr($value) . '" class="widefat" />';

}

/* When the post is saved, saves our custom data */
function trpremier_save_item_information( $post_id ) {

	// Check to see if our nonce is set
	if (!isset($_POST['_nonce_website_link'])) {
		return;
	}
	
	// Check to see if our nonce is valid
	if (!wp_verify_nonce($_POST['_nonce_website_link'], 'website_meta_box')) {
		return;
	}
	
	// If this is an autosave, and our form has not been submitted, do nothing
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
    
    // Check for permissions
    if ( isset($_POST['post_type']) && 'tabula-portfolio' == $_POST['post_type']) {
	    if (! current_user_can('edit_page', $post_id) ) {
		    return;
	    }
    } else {
	    if (! current_user_can('edit_post', $post_id) ) {
		    return;
	    }
    }
    
    // Check to see that data is set
    
    if (! isset($_POST['trpremier_portfolio_link'])) {
	    return;
    }
    
    $data = sanitize_text_field ($_POST['trpremier_portfolio_link']);
    
    update_post_meta($post_id, 'trpremier_portfolio_link', $data);
}

