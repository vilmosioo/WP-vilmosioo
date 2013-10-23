<?php
/*========================================
Portfolio archive template
===========================================*/
get_header();
?>
<section class='content full clearfix'>
	<header>
		<h1>Portfolio</h1>
	</header>
	
	<?php  
	if ( have_posts() ) while ( have_posts() ) : the_post(); 
		$custom_fields = get_post_custom();
		$url = $custom_fields['url'];
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'numberposts'     => 1,
			'post_parent' => get_the_ID(),
			'exclude'     => get_post_thumbnail_id()
		) );

		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$href = wp_get_attachment_image_src( $attachment->ID, 'full');
			}
		}
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<h2><?php the_title(); ?></h2>
		<?php
			echo "<aside><a target='_blank' title='".get_the_title()."' rel='lightbox' href='".$href[0]."' class='img'>"; 
			the_post_thumbnail('nivo');
			echo "</a></aside>";
		?>
		<div class='grid-2'>
			<h3>Description</h3>
			<?php the_content(); ?>
			<?php if( $url[0] != '' ) echo "<a class='button blue' href='".$url[0]."'>Visit site</a>"; ?>
		</div>
		<div class='grid-2'>
			<h3>What I did</h3>
			<ol class='rectangle-list'>
			<?php 
				foreach($custom_fields['features'] as $feature){
					echo "<li><a>$feature</a></li>";
				}
			?>
			</ol>
		</div>
		<div class='clear'></div>
	</article>
	<?php endwhile; ?>      
</section>

<?php get_footer(); ?>