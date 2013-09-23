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
    $args = array( 'post_type' => 'portfolio-item', 'posts_per_page' => -1 );
    $the_query = new WP_Query( $args );
    while ( $the_query->have_posts() ) : $the_query->the_post();
    $custom_fields = get_post_custom();
    $url = $custom_fields['url'];
      $attachments = get_posts( array(
        'post_type' => 'attachment',
        'numberposts'     => 1,
        'post_parent' => $post->ID,
        'exclude'     => get_post_thumbnail_id()
      ) );

      if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
          $href = wp_get_attachment_image_src( $attachment->ID, 'full');
        }
      }
      $img = wp_get_attachment_image_src ( get_post_thumbnail_id(), 'nivo' );
  ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-item'); ?>>
    <h2><?php the_title(); ?></h2>
    <?php
      echo "<aside><a target='_blank' title='".get_the_title()."' rel='lightbox' href='".$href[0]."' class='img'><img src='".$img[0]."' /></a></aside>";
    ?>
    <div class='content full'>
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
    </div>
    <div class='clear'></div>
  </article>
  <?php endwhile; wp_reset_postdata(); ?>      
</section>


<?php get_footer(); ?>