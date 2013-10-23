<?php
/*========================================
Demo archive template
===========================================*/
get_header();
?>
<section class='content full clearfix'>
	<header>
		<h1>Demos</h1>
	</header>
	
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); 
		$img = wp_get_attachment_image_src ( get_post_thumbnail_id(), 'nivo' );
	?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2>
				<a target='_blank' title='<?php the_title();?>' href='<?php the_permalink();?>'>
					<?php the_title(); ?>
				</a>
			</h2>
			
			<div class='grid-2'>
				<aside>
					<a target='_blank' title='<?php the_title();?>' href='<?php the_permalink();?>'>
						<?php the_post_thumbnail('large'); ?>
					</a>
				</aside>
			</div>
			<div class='grid-2'>
				<h3>Description</h3>
				<?php the_excerpt(); ?>
				<h3>Tags</h3>
			</div>
			<div class='clear'></div>
		</article>
	<?php endwhile; ?>      
</section>


<?php get_footer(); ?>