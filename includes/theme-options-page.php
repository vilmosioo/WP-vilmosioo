<?php

class Theme_Options{

	private $tabs;
	private $current;

	function __construct(){
		$this->current = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); 

		$this->tabs['general'] = array(
			'name' => 'General',
			'options' => array(
				'option1' => 'Option 1',
				'option2' => 'Option 2'
			)
		);
		$this->tabs['help'] = array(
			'name' => 'Help',
			'options' => array(
				'option3' => array(
					'name' => 'Option 3',
					'desc' => 'Some description'
					),
				'option4' => 'Option 4'
			)
		);
		foreach($this->tabs as $slug => $tab){
			if(!get_option('hyperion_options_'.$slug)){
				$defaults = array();
				
				foreach( $tab['options'] as $id => $option){
					$defaults[$id] = $option;
				}
			
				update_option( 'hyperion_options_'.$slug, $defaults );
			}	
		}
		
	}

	// Parameters : slug, name, description, tab
	function addField($args){
		if(!$args['tab']) $args['tab'] = 'general';

        $this->tabs[$args['tab']]['options'][$args['slug']] = array(
        	'name' => $args['name'],
        	'desc' => $args['desc']
        );
	    
	}

	function render(){
		add_action('admin_menu', array(&$this, 'init'));
		add_action( 'admin_init', array(&$this, 'register_mysettings') );
	}

	/*
	* Init function
	* 
	* Initializes the theme's options. Called on admin menu action.
	*/
	function init(){
		add_theme_page('Theme Options', 'Theme Options', 'administrator', 'hyperion', array(&$this, 'settings_page_setup'));
	}

	/*
	* Settings page set up
	*
	* Handles the display of the Theme Options page (under Appearance)
	*/
	function settings_page_setup() {
		echo '<div class="wrap">';
		$this->page_tabs() ;
		if ( isset( $_GET['settings-updated'] ) ) {
			echo "<div class='updated'><p>Theme settings updated successfully.</p></div>";
		} 
		?>
		<form method="post" action="options.php">
			<?php settings_fields( 'hyperion_options_'.$this->current ); ?>
			<?php do_settings_sections( 'hyperion' ); ?>
	    	<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
		</div>
		<?php 
	} 

	/*
	* Page tabs
	*
	* Prints out the naviagtion for page tabs
	*/
	function page_tabs(){		
		
     	$links = array();

     	foreach( $this->tabs as $slug => $tab ){
          	if ( $slug == $this->current ){
               	$active_class = "nav-tab-active";
           	} else {
           		$active_class = "";
           	}
       		$links[] = "<a class='nav-tab $active_class' href='?page=hyperion&tab=$slug'>$tab[name]</a>";
       	}

		echo '<div id="icon-themes" class="icon32"><br /></div>'.
			'<h2 class="nav-tab-wrapper">';
     	foreach ( $links as $link ){
          	echo $link;
      	}
     	echo '</h2>';
	}

	/*
	* Register settings
	* 
	* Register all settings and setting sections
	*/
	function register_mysettings() {		
		foreach($this->tabs as $slug=>$tab){
			register_setting( 'hyperion_options_'.$slug, 'hyperion_options_'.$slug );
			if($slug != $this->current) continue;
			add_settings_section( 'options_section_'.$slug, '', array(&$this, 'section_handler'), 'hyperion' ); 
			foreach($tab['options'] as $name => $option){
				$title = $option;
				$desc = '';
				if(is_array($option)){
					$title = $option['name'];
					$desc = $option['desc'];
				}

				add_settings_field( $name, $title, array(&$this, 'input_handler'), 'hyperion', 'options_section_'.$slug, array("name" => $name, 'section' => $slug, 'desc' => $desc) );
			}
		}
	}

	function section_handler($args){
		$id = substr($args['id'], 16); // 16 is the length of the section prefix: hyperion_options_
		echo "<h2 class='section'>".$this->tabs[$id]['name']." Settings</h2>"; 
	}

	function input_handler($args){
		$id = $args['name'];
		$name = 'hyperion_options_'.$args['section']."[$id]";
		$value = get_option("hyperion_options_".$args['section']);
		$value = $value[$id];
		echo "<input type='text' id='$id' name='$name' value='$value'>"; 
		if ( $args['desc'] != '' )
		echo '<br /><span class="description">' . $args['desc'] . '</span>';
	}
}
?>