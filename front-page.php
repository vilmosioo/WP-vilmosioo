<?php get_header(); ?>

<div id='main'>
	<div class='container clearfix'>
		<div class='flexslider-container clearfix'>
			<div id='slideshow-flex' class="flexslider">
				<ul class='slides'>
				<?php	
					$id = get_option('option_name_1'); 

					$the_query = new WP_Query( array( 'post_type' => 'portfolio-item', 'posts_per_page' => -1, 'post__in' => $id ) );
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'nivo' );
						$img = $img[0];
						$wordpress = get_post_custom(); 
						$wordpress = $wordpress['features'];
						if( is_array($wordpress) && in_array('wordpress', $wordpress) ) $wordpress= "<img class='wordpress' src='http://vilmosioo.co.uk/wordpress/wp-content/uploads/2012/02/blue-xl-150x150.png' alt='WordPress'/>"; else $wordpress = "";
						echo "
						<li>
							<img src='$img' />
							<!--<p class='flex-caption'>".get_the_title()."</p>-->
							$wordpress
						</li>";
					endwhile;
				?>
				</ul>
			</div><!--/#slideshow-flex-->
		</div>

		<div id='actionbuttons'>
			<a class='button large blue' href='<?php echo get_permalink( get_page_by_title( 'Portfolio' )->ID ); ?>'>View my portfolio</a>
			<a class='button large orange' href='<?php echo get_permalink( get_page_by_title( 'Contact' )->ID ); ?>'>Available for freelance work</a>
		</div>

		<?php dynamic_sidebar( 'Home page' ); ?>
	</div>
</div><!--/#main-->

<?php get_footer(); ?>
