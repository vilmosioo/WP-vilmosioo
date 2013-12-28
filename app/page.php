 <?php
/*========================================
Page template
===========================================*/
get_header();
?>
<section class='content full clearfix'>
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', get_post_format() ); ?>
	<?php endwhile; ?>
</section>
<?php get_footer(); ?>