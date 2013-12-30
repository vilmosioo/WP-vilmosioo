<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php the_content(); ?>
<?php endwhile; ?>

<div id='actionbuttons'>
	<a class='button large blue' href='<?php echo get_post_type_archive_link('portfolio-item'); ?>'>View my portfolio</a>
	<a class='button large orange' href='<?php echo get_permalink( get_page_by_title( 'Contact' )->ID ); ?>'>Available for freelance work</a>
</div>

<?php dynamic_sidebar( 'Home page' ); ?>

<?php get_footer(); ?>
