<?php
/*========================================
Testimonials archive template
===========================================*/
get_header();
?>

<section class='content full clearfix'>
  <header>
    <h1><?php post_type_archive_title(); ?></h1>
  </header>
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <blockquote id="post-<?php the_ID(); ?>" <?php post_class('hreview'); ?>>
        <p class='description item'><?php the_content(); ?></p>
        <p class='name reviewer'><?php the_title(); ?></p>  
      </blockquote>
  <?php 
    endwhile; 
  ?>      
</section>
  
<?php get_footer(); ?>