<?php
/*========================================
Demo archive template
===========================================*/
get_header();
?>
<section class='content full clearfix'>
	<header>
		<h1>Projects</h1>
	</header>
	
	<?php  
	if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2><a title='<?php the_title(); ?>' rel='lightbox' href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h2>
		<?php
			echo "<aside><a title='".get_the_title()."' rel='lightbox' href='".get_permalink()."' class='img'>"; 
			the_post_thumbnail('nivo');
			echo "</a></aside>";
		?>
		<div class='grid-2'>
			<h3>Description</h3>
			<?php the_excerpt(); ?>
		</div>
		<div class='grid-2'>
			<h3>What I did</h3>
			<ol class='rectangle-list'>
			<?php
				foreach(get_the_terms(get_the_ID(), 'features') as $feature){
					echo "<li><a>".$feature->name."</a></li>";
				}
			?>
			</ol>
		</div>
		<div class='clear'></div>
	</article>
	<?php endwhile; ?>      
</section>

<?php get_footer(); ?>