<?php get_header(); ?>

<div id='preview'>
<?php
	$portfolio = get_posts(array('post_type' => 'portfolio'));
	foreach ($portfolio as $key => $value) {
		echo '<h2>'.get_the_title($value->ID).'</h2>';
		echo '<p>'.get_the_content($value->ID).'</p>';
		echo get_the_post_thumbnail('full', $value->ID);
		 
		$url = wp_get_attachment_url( get_post_thumbnail_id($value->ID) ); 
		if($url){
			echo '<img src="'.$url.'" alt="'.get_the_title($value->ID).'">';
		}	
			
	}
?>
</div>

<div id='main'>
	<div class='container'>
		<?php dynamic_sidebar( 'Front Page' ); ?>
		<div class='clear'></div>
	</div>
</div>

<?php get_footer(); ?>
