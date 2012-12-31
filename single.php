<?php
/*========================================
Single template: blog posts, default template for custom posts 
===========================================*/
get_header();
?>

<div id='main' role="main">
	<div class='container'>
		<section class='clearfix'>
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h1><?php the_title();?></h1>
				</header>
				<aside class='aside meta'>
					Posted on <?php the_time(get_option('date_format')); ?> in <?php the_category(', '); ?> <?php the_tags(' &#8226; Talking about ', ', '); ?> &#8226; <a href='#comments'><?php comments_number('No Comments :(', 'One Comment', '% Comments' ); ?></a> &#8226; <a title="Permalink to <?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">Permalink</a> 
				</aside>
				<?php the_content();?>				
				<?php get_template_part( 'loop' , 'related' ); ?>
				<aside class='aside' id='post-navigation'>
					<span class='fleft'><?php previous_post_link(); ?></span> 
					<span class='fright'><?php next_post_link(); ?></span> 
					<div class='clear'></div>
				</aside>
				<?php comments_template(); ?>
			</article>
		<?php endwhile; ?>
		</section>
	</div>
</div>
<?php get_footer(); ?>