<?php
/*========================================
Single template: blog posts, default template for custom posts 
===========================================*/
get_header();
?>

<section class='content clearfix'>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', get_post_format() ); ?>
	<?php endwhile; ?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>