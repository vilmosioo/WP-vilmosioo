<?php
// define constants
define( 'THEME_PATH', get_bloginfo( 'stylesheet_directory' ) );
define( 'HOME_URL', home_url() );
if ( ! isset( $content_width ) ) $content_width = 1280;

require_once 'includes/Hyperion.php';
require_once 'includes/Utils.php';
// TO DO Make this a class too
require_once 'includes/theme-options-page.php';

class VilmosIoo extends Hyperion{
	private $theme_options;
	/*
	The class constructor, fired after setup theme event.
	Will load all settings of the theme 
	*/
	function __construct(){	
		add_shortcode('shortcode', array( &$this, 'some_shortcode' ));
		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );
		add_action('init', array(&$this, 'register_post_types'));

		$this->theme_options = new Theme_Options();
		$this->theme_options->addField(array(
			'slug' => 'test-option',
			'name' => 'Test Option',
			'desc' => 'Desctiption of option'
		));
		$this->theme_options->render();
	}

	// create custom shortcodes
	function some_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array('attribute' => 'default_value'), $atts));
		return "<div $attribute>".do_shortcode($content)."</div>";
	}

	// register post types
	function register_post_types(){
		$labels = array(
		    'name' => 'Portfolio',
		    'singular_name' => 'Portfolio',
		    'add_new' => 'Add New',
		    'add_new_item' => 'Add New Item',
		    'edit_item' => 'Edit Portfolio',
		    'new_item' => 'New Portfolio',
		    'all_items' => 'All Items',
		    'view_item' => 'View Item',
		    'search_items' => 'Search Portfolio',
		    'not_found' =>  'No items found',
		    'not_found_in_trash' => 'No items found in Trash', 
		    'parent_item_colon' => '',
		    'menu_name' => 'Portfolio'
		  );

		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => array( 'slug' => 'portfolio' ),
		    'capability_type' => 'post',
		    'has_archive' => 'portfolio', 
		    'hierarchical' => false,
		    'menu_position' => null,
		    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields')
		  ); 

		  register_post_type( 'portfolio', $args );
	}

	/*
	* Register theme sidebars.
	*
	* Will register the main sidebar used for the blog,
	* the front page sidebar and the footer sidebar. 
	*/
	function register_sidebars(){
		if ( function_exists('register_sidebar') ) {
			register_sidebar(array(
				'name' => 'Main',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
			register_sidebar(array(
				'name' => 'Footer',
				'before_widget' => '<div id="%1$s" class="widget grid-3 %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4>',
				'after_title' => '</h4>',
			));
			register_sidebar(array(
				'name' => 'Front Page',
				'before_widget' => '<div id="%1$s" class="widget grid-3 %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}
	}
}

// Initialize the above class after theme setup
add_action( 'after_setup_theme', create_function( '', 'global $theme; $theme = new VilmosIoo();' ) );

?>