<?php
/*
* WordPress MetaBox
* 
* Creates a metabox for a custom post 
*/

class MetaBox{
	
	private $id, $title, $page, $context, $priority, $fields;

	function __construct($args = array()) {
		$args = array_merge( array(
			"title" => 'Custom Meta Box',
			"page" => 'post',
			"context" => 'normal',
			"priority" => 'high',
			"fields" => array(
	    		array(
	    			'name' => 'Text',
					'default' => '',
					'description' => '',
					'type' => 'text',
	    		)
	      	)
	    ), $args );

		$this->id = Utils::generate_slug($args['title']);
		$this->title = $args['title'];
		$this->page = $args['page'];
		$this->context = $args['context'];
		$this->priority = $args['priority'];		
		$this->fields = $args['fields'];	

		add_action( 'save_post', array(&$this, 'save') ); 
		add_action( 'add_meta_boxes', array(&$this,'display') );
	}

	function display(){
		add_meta_box( $this->id, $this->title, array(&$this, 'render'), $this->page, $this->context, $this->priority, array() );
	}

	function save(){	
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    	if( !current_user_can( 'edit_post' ) ) return;

		$allowed_html_tags = array(
		    'a' => array(
		        'href' => array(),
		        'title' => array()
		    )
		);

		global $post; 
		foreach($this->fields as $field){
			$id = Utils::generate_slug($field['name']);
			if( isset( $_POST[$id] ) )  {
		        update_post_meta( $post->ID, $id, wp_kses( $_POST[$id], $allowed_html_tags ) );  
		    }
		}
    
	}

	function render($post, $args){
		$values = get_post_custom( $post->ID );  
		foreach($this->fields as $field){
			$id = Utils::generate_slug($field['name']);
			$value = isset( $values[$id] ) ? esc_attr( $values[$id][0] ) : "";  
			//$selected = isset( $values['my_meta_box_select'] ) ? esc_attr( $values['my_meta_box_select'][0] ) : ”;  
			//$check = isset( $values['my_meta_box_check'] ) ? esc_attr( $values['my_meta_box_check'][0] ) : ”;  
			switch ($field['type']) {
			    case "textarea":
			        echo "
					    <label for=\"$id\">$field[name]</label>  
					    <textarea class='wp-editor-area' name=\"$id\" id=\"$id\" >$value</textarea><br>
					    <span>$field[description]</span>
				    ";
				    break;
			    default:
			        echo "
					    <label for=\"$id\">$field[name]</label>  
					    <input type=\"$field[type]\" name=\"$id\" id=\"$id\" value=\"$value\"><br>
					    <span>$field[description]</span>
				    ";
			        break;
			}
			
		}
	}
}

?>