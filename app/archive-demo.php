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
	
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('grid-4'); ?>>
			<a title='<?php the_title();?>' href='<?php the_permalink();?>' class='preview'>
				<?php the_post_thumbnail('demo'); ?>
			</a>
			<h2>
				<a title='<?php the_title();?>' href='<?php the_permalink();?>'>
					<?php the_title(); ?>
				</a>
			</h2>			
			<?php the_excerpt(); ?>
		</article>
	<?php endwhile; ?>      
</section>


<?php get_footer(); ?>