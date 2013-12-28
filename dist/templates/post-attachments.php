<?php
/*
Template to display single post attachments.
*/
$attachments = get_posts(array(	
	'post_type' => 'attachment',
	'numberposts'     => -1,
	'post_parent' => get_the_ID()
));

if ( $attachments ) {
	echo "<h3>Screenshots</h3>";
	foreach ( $attachments as $attachment ) {
		$href = wp_get_attachment_image_src( $attachment->ID, 'thumbnail'); 
		$full = wp_get_attachment_image_src( $attachment->ID, 'full');
		echo "<a class='screenshot cutout' href='".$full[0]."' target=\"_blank\" rel=\"lightbox\">";
		echo "<img src='".$href[0]."' alt='".get_the_title()."'/>"; 
		echo "</a>";
	}
	echo '<div class="clear"></div>';
}