<?php

// save all options in a single entry as array
// display all options and use javascript to tabulate
// each tab is a setting section

class Theme_Options{

	private $tabs;

	function __construct(){
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
		
		add_action('admin_menu', array(&$this, 'init'));
	}

	/*
	* Init function
	* 
	* Initializes the theme's options. Called on admin menu action.
	*/
	function init(){
		add_theme_page('Theme Options', 'Theme Options', 'administrator', 'hyperion', array(&$this, 'settings_page_setup'));
		add_action( 'admin_init', array(&$this, 'register_mysettings') );
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
		$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); 
		?>
		<form method="post" action="options.php">
			<?php settings_fields( 'hyperion_options_'.$tab ); ?>
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
		
		$current = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'tab1' ); 

		// TO DO Add to variable
     	$links = array();

     	foreach( $this->tabs as $slug => $tab ){
          	if ( $slug == $current ){
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
		$current = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' );
		
		foreach($this->tabs as $slug=>$tab){
			register_setting( 'hyperion_options_'.$slug, 'hyperion_options_'.$slug );
			if($slug != $current) continue;
			add_settings_section( 'options_section_'.$slug, '', function(){ 
				echo "<h2 class='section'>Settings</h2>"; 
			}, 'hyperion' ); 
			foreach($tab['options'] as $name => $option){
				$title = $option;
				$desc = '';
				if(is_array($option)){
					$title = $option['name'];
					$desc = $option['desc'];
				}

				add_settings_field( $name, $title, function($args){ 
					$id = $args['name'];
					$name = 'hyperion_options_'.$args['section']."[$id]";
					$value = get_option("hyperion_options_".$args['section'])[$id];
					echo "<input type='text' id='$id' name='$name' value='$value'>"; 
					if ( $args['desc'] != '' )
					echo '<br /><span class="description">' . $args['desc'] . '</span>';
				}, 'hyperion', 'options_section_'.$slug, array("name" => $name, 'section' => $slug, 'desc' => $desc) );
			}
		}
	}

	function settings_section_setup() { 
		echo '<h3>Settings section</h3>';
	}

	function help_section_setup() { 
		echo '<h3>Help section</h3>';
	}

	function option_1_setup() { 
		echo "<input name='option_name_1' value='".get_option('option_name_1')."'/>";
	}

	function option_2_setup() { 
		echo "<input name='option_name_2' value='".get_option('option_name_2')."'/>";
	}
}

// create theme options menu
/*
add_action('admin_menu', 'hyperion_create_menu');



function hyperion_create_menu() {

	//create new top-level menu

	add_theme_page('Theme Options', 'Theme Options', 'administrator', 'hyperion', 'hyperion_settings_page_setup');

	

	//call register settings function

	add_action( 'admin_init', 'register_mysettings' );

}



function register_mysettings() {

	//register our settings

	register_setting( 'settings-group', 'option_name_1' );

	register_setting( 'settings-group', 'option_name_2' );



	$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'tab1' ); 



	if( $tab == 'tab1'){

		//add_settings_section( $id, $title, $callback, $page ); 

		add_settings_section( 'options_section_1', '', 'settings_section_setup', 'hyperion' ); 

		//add our fields to sections

		add_settings_field('option_name_1', 'Sample option 1', 'option_1_setup', 'hyperion', 'options_section_1');

	}



	if( $tab == 'tab2'){

		//add_settings_section( $id, $title, $callback, $page ); 

		add_settings_section( 'options_section_2', '', 'settings_section_setup', 'hyperion' ); 

		//add our fields to sections

		add_settings_field('option_name_2', 'Sample option 2', 'option_2_setup', 'hyperion', 'options_section_2');

	}

}



function settings_section_setup() { }

function help_section_setup() { }



function option_1_setup() { 

	echo "<input name='option_name_1' value='".get_option('option_name_1')."'/>";

}



function option_2_setup() { 

	echo "<input name='option_name_2' value='".get_option('option_name_2')."'/>";

}

	

function hyperion_settings_page_setup() {

?>



<div class="wrap">



	<?php page_tabs() ?>

	<?php if ( isset( $_GET['settings-updated'] ) ) {

		echo "<div class='updated'><p>Theme settings updated successfully.</p></div>";

	} 

	$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'tab1' ); 

	?>



	<form method="post" action="options.php">



		<?php settings_fields( 'settings-group' ); ?>

		<?php do_settings_sections( 'hyperion' ); ?>

    		<p class="submit">

			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />

		</p>

	</form>

</div>

<?php 

} 



add_action('admin_print_styles-appearance_page_hyperion', 'slider_enqueue_admin_style', 11 );

function slider_enqueue_admin_style() {



    // define admin stylesheet

    $admin_handle = 'hyperion_admin_stylesheet';

    $admin_stylesheet = get_template_directory_uri() . '/admin/admin.css';

    wp_enqueue_style( $admin_handle, $admin_stylesheet );



}



function page_tabs(){			



	if ( isset ( $_GET['tab'] ) ) :

          	$current = $_GET['tab'];

     	else:

         	$current = 'tab1';

     	endif;

     	$tabs = array( 'tab1' => 'Tab 1', 'tab2' => 'Tab 2', 'tab3' => 'Tab 3' );

     	$links = array();

     	foreach( $tabs as $tab => $name ) :

          	if ( $tab == $current ) :

               		$links[] = "<a class='nav-tab nav-tab-active' href='?page=hyperion&tab=$tab'>$name</a>";

          	else :

               		$links[] = "<a class='nav-tab' href='?page=hyperion&tab=$tab'>$name</a>";

          	endif;

	endforeach;

	echo '<div id="icon-themes" class="icon32"><br /></div>';

     	echo '<h2 class="nav-tab-wrapper">';

     	foreach ( $links as $link )

          	echo $link;

     	echo '</h2>';

}
*/
?>