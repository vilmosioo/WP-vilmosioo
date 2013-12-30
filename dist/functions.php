<?php
require_once 'inc/Utils.php';
require_once 'inc/Hyperion.php';

class VilmosIoo extends Hyperion{	
	/*
	The class constructor, fired after setup theme event.
	Will load all settings of the theme 
	*/
	function __construct(){	
		parent::__construct();
		
		// add actions and filters
		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_scripts_and_styles') );
		add_action( 'login_enqueue_scripts', array( &$this, 'login_styles'));
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_styles'));
		add_filter( 'admin_footer_text', array( &$this, 'remove_footer_admin'));
		add_filter('widget_text', 'do_shortcode');

		// add image sizes
		add_image_size( 'single', 780, 500); 
		add_image_size( 'nivo', 1040, 300, true ); //(cropped)
		add_image_size( 'demo', 390, 390, true); 
	}
	
	// Customise the footer in admin area
	function remove_footer_admin () {
		echo get_avatar('cool.villi@gmail.com' , '40' );
		echo 'Theme designed and developed by <a href="http://vilmosioo.co.uk" target="_blank">Vilmos Ioo</a> and powered by <a href="http://wordpress.org" target="_blank">WordPress</a>. Version v1.3.7';
	}
	
	// add custom admin styles
	function admin_styles() {
		wp_enqueue_style( 'vilmosioo-admin-css', THEME_PATH.'/css/wp-admin.css' );
	}

	// add custom login styles
	function login_styles() {
		wp_enqueue_style( 'vilmosioo-login-css', THEME_PATH.'/css/wp-login.css' );
	}

	// add additional scripts and styles
	function add_scripts_and_styles(){
		// register scripts and styles
		wp_register_script( 'default', THEME_PATH.'/js/script.js', array(), '1.3.7', true ); 
		wp_register_script( 'modernizr', THEME_PATH.'/js/vendor/modernizr/modernizr.js', array(), '2.6.2', true ); 
		wp_register_script( 'webgl', THEME_PATH.'/js/webgl.js', array('default'), '1.3.7', true);
		wp_register_script( 'play', THEME_PATH.'/js/play.js', array('default'), '1.3.7', true);
		wp_register_script( 'gameoflife', THEME_PATH.'/js/gameoflife.js', array('default'), '1.3.7', true);

		// enqueue scripts and styles
		wp_enqueue_script( 'modernizr' );
		
		if(is_singular('project')){
			if(get_the_title() == 'WebGL Demo' ) wp_enqueue_script( 'webgl' );
		}
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
				'name' => 'Home page',
				'before_widget' => '<div id="%1$s" class="widget grid-3 service %2$s">',
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