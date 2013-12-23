 <?php
/*========================================
Single demo template
===========================================*/
get_header();
?>
<section class='content full clearfix'>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<?php the_content(); ?>
		<?php 
			$custom_fields = get_post_custom();
			$url = $custom_fields['url'];
			$demo = $custom_fields['demo-link'];
			echo '<div class="tcenter">';
			if(!empty($url) && !empty($url[0])) echo "<a href='$url[0]' class='button large blue'>View on github</a>";
			if(!empty($demo) && !empty($demo[0])) echo "<a href='$demo[0]' class='button large orange'>Demo</a>";
			echo '</div>';
		?>
		<?php if(get_the_title() == 'Tumbleblog') get_template_part('tumbleblog'); ?>		
	<?php endwhile; ?>
</section>
<?php get_footer(); ?>