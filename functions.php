<?php
// define constants
define( 'THEME_PATH', get_bloginfo( 'stylesheet_directory' ) );
define( 'HOME_URL', home_url() );
if ( ! isset( $content_width ) ) $content_width = 1280;

require_once 'includes/Hyperion.php';
require_once 'includes/Utils.php';
require_once 'includes/Theme_Options.php';
require_once 'includes/Metabox.php';
require_once 'includes/Custom_Post.php';
require_once 'includes/Gist_Manager.php';
require_once 'includes/Github_API.php';
require_once 'includes/Custom_Widget.php';

class VilmosIoo extends Hyperion{
	private $theme_options;
	private $metaboxes, $custom_posts, $events;
	/*
	The class constructor, fired after setup theme event.
	Will load all settings of the theme 
	*/
	function __construct(){	
		parent::__construct();
		
		// add_shortcode('shortcode', array( &$this, 'register_shortcode' ));
		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );
		// add_action( 'widgets_init', array( &$this, 'register_widgets' ) );

		add_action( 'init', array(&$this, 'register_post_types'));
		add_action( 'init', array(&$this, 'register_metaboxes') );
		add_action( 'init', array(&$this, 'special_scripts') );
		add_action( 'init', array(&$this, 'register_events') );
		
		add_image_size( 'portfolio-item', '300', '190', true ); 

		$this->create_theme_options();
	}
	
	function register_events(){
		$this->events['gists'] = new GIST_MANAGER('vilmosioo');
	}

	function special_scripts(){
		wp_register_script( 'game-of-life', THEME_PATH.'/js/game-of-life.js', array( 'jquery' ), '1.0', true ); 
		wp_register_script( 'arcball', THEME_PATH.'/js/arcball.js', array( 'jquery' ), '1.0', true ); 
	}

	function register_post_types(){
		$this->custom_posts['experiment'] = new Custom_Post(array('name' => 'Experiment'));
		$this->custom_posts['portfolio'] = new Custom_Post(array('name' => 'Portfolio Item', 'labels' => array('menu_name' => 'Portfolio')));
	}

	function register_metaboxes(){
		//TODO use default value in fields
		$this->metaboxes['testimonial'] = new MetaBox(array(
			"title" => 'Testimonial',
			"page" => 'portfolio-item',
			"fields" => array(
	    		'Authors name',
	    		array(
	    			'name' => 'Testimonial text',
					'type' => 'textarea'
	    		),
	    		'URL'
	      	)
	    ));
	}

	// create theme options page
	function create_theme_options(){
		$this->theme_options = new Theme_Options();
		$this->theme_options->addTab(array(
			'name' => 'General',
			'options' => array('Option 1', 'Option 2')
		));

		$this->theme_options->addTab(array(
			'name' => 'Help',
			'options' => array(
				array(
					'name' => 'Option 3',
					'desc' => 'Some description'
				), 
				'Option 4'
			)
		));
		$this->theme_options->render();
	}

	// create custom shortcodes
	function register_shortcode( $atts, $content = null ) {
		extract(shortcode_atts(array('id' => ''), $atts));
		return $id ? "<script src=\"http://gist.github.com/$id.js\"></script>" : "";
	}

	function register_widgets(){
	    register_widget( 'Custom_Widget' ); 
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