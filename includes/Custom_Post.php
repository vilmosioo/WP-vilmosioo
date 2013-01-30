<?php
/*
* WordPress Custom Post
* 
* Represents a custom post in WordPress
*/

class Custom_Post{
	
	private $name, $supports, $slug;

	function __construct($args = array()) {
		$args = array_merge( array(
	      "name" => 'Portfolio',
	      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields')
	    ), $args );

		$this->name = $args['name'];
		$this->supports = $args['supports'];
		$this->slug = Utils::generate_slug($args['name']);

		$labels = array(
			'name' => $args['name'],
			'singular_name' => $args['name'],
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Item',
			'edit_item' => 'Edit '. $args['name'],
			'new_item' => 'New'. $args['name'],
			'all_items' => 'All Items',
			'view_item' => 'View Item',
			'search_items' => 'Search '. $args['name'],
			'not_found' =>  'No items found',
			'not_found_in_trash' => 'No items found in Trash', 
			'parent_item_colon' => '',
			'menu_name' => $args['name']
		);

		$type_args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array( 'slug' => $this->slug ),
			'capability_type' => 'post',
			'has_archive' => $this->slug, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => $args['supports']
		); 

		register_post_type( $this->slug, $type_args );
	}

}

?>