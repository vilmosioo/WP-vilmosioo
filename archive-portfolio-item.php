<?php
/*========================================
Archive template
Used for: categories, archives, tags, author, taxonomies
===========================================*/
get_header();
?>

<div id='main' role="main">
	<div class='container'>
		<section class='clearfix'>
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry entry portfolio-item clearfix' ); ?>>
					<header>
						<h2 class='entry-title'><a href='<?php the_permalink(); ?>' rel='canonical'><?php the_title();?></a></h2>
					</header>
					<div class='preview'>
						<?php the_post_thumbnail('full');?>
					</div>
					<div class='entry-content'>
						<?php the_content(); ?> 
					</div>
				</article>
			<?php endwhile; ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>