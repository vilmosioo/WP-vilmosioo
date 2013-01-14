<?php

/*
* Main theme class
* 
* Loads default settings for the Hyperion theme 
*/
class Hyperion{
	
	function __construct() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );
		add_theme_support( 'menus' );
		add_theme_support( 'custom-header' );
		add_custom_background();
		add_editor_style();
	    
	    add_filter( 'post_thumbnail_html', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'image_send_to_editor', array( &$this, 'remove_thumbnail_dimensions' ), 10 );
		add_filter( 'the_content', array( &$this, 'remove_thumbnail_dimensions' ), 10 );	
		add_filter( 'the_content', array( &$this, 'filter_ptags_on_images' ));
		add_action( 'login_head', array( &$this, 'registerLoginCSS' ));
		add_filter( 'admin_footer_text', array( &$this, 'remove_footer_admin' ));
		add_action( 'admin_head', array( &$this, 'registerAdminCSS' ));
		add_filter( "pre_update_option_category_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_tag_base", array( &$this, "remove_blog_slug" ));
		add_filter( "pre_update_option_permalink_structure", array( &$this, "remove_blog_slug" ));
	}

	// just check if the current structure begins with /blog/ remove that and return the stripped structure 
	function remove_blog_slug($tag_cat_permalink){
		if(!preg_match("/^\/blog\//",$tag_cat_permalink))
		return $tag_cat_permalink;
		$new_permalink=preg_replace ("/^\/blog\//","/",$tag_cat_permalink );
		return $new_permalink;
	}

	// Custom CSS for the login page	
	function registerLoginCSS() {
		echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/wp-login.css"/>';
	}

	// Customise the footer in admin area
	function remove_footer_admin () {
		echo get_avatar('cool.villi@gmail.com' , '40' );
		echo 'Theme designed and developed by <a href="http://vilmosioo.co.uk" target="_blank">Vilmos Ioo</a>';
	}

	// Custom CSS for the whole admin area (use to customise the theme options page)
	// Create wp-admin.css in your theme folder
	function registerAdminCSS() {
    	echo '<link rel="stylesheet" type="text/css" href="'.THEME_PATH.'/admin/wp-admin.css"/>';
	}
	
	// stop images getting wrapped up in p tags when they get dumped out with the_content() for easier theme styling
	function filter_ptags_on_images( $content ){
		return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}

	
	// remove attached image sizes 
	function remove_thumbnail_dimensions( $html ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
}
?>