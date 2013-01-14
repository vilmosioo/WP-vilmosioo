<?php get_header(); ?>

<div id='main' role="main">
	<div class='container'>
		<section class='clearfix'>
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry entry article clearfix' ); ?>>
					<header>
						<h2 class='entry-title'><a href='<?php the_permalink(); ?>' rel='canonical'><?php the_title();?></a></h2>
					</header>
					<div class='entry-content'>
						<?php Utils::post_thumbnail( 'thumbnail' );?>
						<?php the_content(); ?> 
					</div>
					<a href='<?php the_permalink(); ?>' rel='canonical'>Continue reading &rarr;</a>
				</article>
			<?php endwhile; ?>
			<aside class='aside' id='post-navigation'>
				<span class='fleft'><?php previous_posts_link(); ?></span> 
				<span class='fright'><?php next_posts_link(); ?></span> 
				<div class='clear'></div>
			</aside>
		</section>
	</div>
</div>

<?php get_footer(); ?>
