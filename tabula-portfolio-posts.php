<?php
/*
Plugin Name: Tabula Porfolio Posts
Plugin URI:  http://leonewball.com
Description: This plugin creates the custom post "Portfolio" and the "Skill" and "Work" Taxonomies. Currently designed to be used with the Tabula series of themes.
Version:     1.0
Author:      Leo Newball
Author URI:  http://leonewball.com
*/

if (is_admin()) {
	add_action('init', array('TabulaPorfolio_Admin', 'init'));
}

require_once('custom-posts.php'); // Custom Posts 
require_once('custom-taxonomy.php'); // Custom Taxonomies

class TabulaPorfolio_Admin {
	
	private static $initiated = false;
	
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}
		
	public static function init_hooks() {
		self::$initiated = true;
	}
	
	public static function load_menu() {
		
	}
		
}

add_action( 'init', 'tabula_portfolio' );
add_action( 'add_meta_boxes', 'trpremier_add_item_information' );
add_action( 'save_post', 'trpremier_save_item_information' );
add_action('init', 'tabula_create_skill_taxonomy', 0);
add_action('init', 'tabula_create_work_taxonomy', 0);

