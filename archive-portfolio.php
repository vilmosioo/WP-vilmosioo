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
			<header>
				<h1>Portfolio</h1>
			</header>
			<?php 
			query_posts(array(
				post_type => 'portfolio', 
				paged => 0, 
				max_no_posts => -1
			)); 
			?>
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry entry article clearfix' ); ?>>
					<?php 
						$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
						if($url){
							echo '<img src="'.$url.'" alt="'.get_the_title($post->ID).'">';
						}
					?>
		
					<div class='grid-2'>
						<header>
							<h2 class='entry-title'><?php the_title();?></h2>
						</header>
						<div class='entry-content'>
							<?php echo get_the_content(); ?> 
						</div>
					</div>
					<div class='grid-2'>
					</div>
		
				</article>
			<?php endwhile; ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>