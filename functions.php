<?php
// define constants
define( 'THEME_PATH', get_bloginfo( 'stylesheet_directory' ) );
define( 'HOME_URL', home_url() );

if ( ! isset( $content_width ) ) $content_width = 1200;

require_once 'includes/Hyperion.php';
require_once 'includes/Utils.php';
require_once 'includes/Theme_Options.php';
require_once 'includes/Metabox.php';
require_once 'includes/Custom_Post.php';
require_once 'includes/Gist_Manager.php';

/*

get_template_part( 'theme-options-page' ); 

*/
?>
<?php

class HyperionBasedTheme extends Hyperion{
	private $theme_options;
	
	/*
	The class constructor, fired after setup theme event.
	Will load all settings of the theme 
	*/
	function __construct(){	
		parent::__construct();
		
		add_action( 'widgets_init', array( &$this, 'register_sidebars' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_scripts_and_styles') );  
		add_filter( 'twitter_cards_properties', array( &$this, 'twitter_custom' ));
		add_action( 'login_enqueue_scripts', array( &$this, 'login_styles'));
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_styles'));
		add_filter( 'admin_footer_text', array( &$this, 'remove_footer_admin'));
		
		add_image_size( 'single', 780, 500); 

		// TODO: update constructor to take array of tabs
		$this->theme_options = new Theme_Options();
		$this->theme_options->addTab(array(
			'name' => 'Slider',
			'options' => array(
				array('name' => 'Choose projects', 'type' => Theme_Options::PORTFOLIO_SELECT)
			)
		));
		$this->theme_options->render();

		$this->register_post_types(); 
	}
	
	// Customise the footer in admin area
	function remove_footer_admin () {
		echo get_avatar('cool.villi@gmail.com' , '40' );
		echo 'Theme designed and developed by <a href="http://vilmosioo.co.uk" target="_blank">Vilmos Ioo</a> and powered by <a href="http://wordpress.org" target="_blank">WordPress</a>.';
	}
	
	// add custom admin styles
	function admin_styles() {
		wp_enqueue_style( 'flex', THEME_PATH.'/css/wp-admin.css' );
	}

	// add custom login styles
	function login_styles() {
		wp_enqueue_style( 'flex', THEME_PATH.'/css/wp-login.css' );
	}

	// complete the twitter card data from plugin
	function twitter_custom( $twitter_card ) {
		if ( is_array( $twitter_card ) ) {
			$twitter_card['creator'] = '@vilmosioo';
			$twitter_card['creator:id'] = '56978690';
		}
		return $twitter_card;
	}

	// add additional scripts and styles
	function add_scripts_and_styles(){
		wp_enqueue_script( 'flex', THEME_PATH.'/js/flex/jquery.flexslider-min.js', array( 'jquery' ), '1.0', true ); 
		wp_register_style( 'flex', THEME_PATH.'/js/flex/flexslider.css' );
		wp_register_script( 'play', THEME_PATH.'/js/play.js' );
		wp_register_script( 'gameoflife', THEME_PATH.'/js/gameoflife.js' );
		wp_register_script( 'webgl', THEME_PATH.'/js/webgl.js' );
		wp_register_script( 'three', THEME_PATH.'/js/libs/Three.js' );
		wp_register_script( 'trackball', THEME_PATH.'/js/libs/TrackBall.js' );

	}

	// register post types
	function register_post_types(){
		new Custom_Post(array('name' => 'Portfolio item'));
		new Custom_Post(array('name' => 'Testimonial'));
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
add_action( 'after_setup_theme', create_function( '', 'global $theme; $theme = new HyperionBasedTheme();' ) );

?>