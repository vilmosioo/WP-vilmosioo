<?php 
/*
Template Name: Comics
*/
include_once(ABSPATH . WPINC . '/feed.php');
get_header();
?>
<div id='main' role="main">
  <div class='container'>
    <section class='content full clearfix'>
      <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <header>
          <h1><?php the_title(); ?></h1>
        </header>
        <?php the_content();?>
      <?php endwhile; ?>
      <?php
      $feed = array();
      $feed += add('http://www.xkcd.com/rss.xml', 'comic');
      $feed += add('http://feeds.feedburner.com/smbc-comics/PvLb', 'comic');
      $feed += add('http://thecodinglove.com/rss', 'comic');
      
      krsort($feed);

      echo "<hr/><div class='tumblog'>";

      foreach($feed as $item){
        switch ($item['type']) {
          case 'comic': 
            echo "<article class='tumblog-item comic'><h3><a href='".$item['link']."'>".$item['title'].'</a></h3>'.$item['description'].'</article>';
            break;
        }
      }

      echo "</div>";

      function add($url, $type){
        // Get a SimplePie feed object from the specified feed source.
        $rss = fetch_feed($url); // specify the source feed
        $no =15;
        if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
              $rss->set_cache_duration(1);
          // Figure out how many total items there are, but limit it to 5. 
              $maxitems = $rss->get_item_quantity($no); 
              // Build an array of all the items, starting with element 0 (first element).
          $rss_items = $rss->get_items(0, $maxitems); 
        endif;

        if ($maxitems == 0) {
          echo '<li>There are no items to show for '.$url.'.</li><pre>';
          print_r($rss);
          echo '</pre>';
        } else {
              // Loop through each feed item and display each item as a hyperlink.
          foreach ( $rss_items as $item ) : 
            $wp = array('type' => $type);
            $wp['time'] = strtotime($item->get_date());
            $wp['link'] = $item->get_link();
            $wp['description'] = $item->get_description();
            $wp['title'] = $item->get_title();
            $feed[ $wp['time'] ] = $wp;
          endforeach; 
        }
        return $feed;
      }

      ?>
    </section>
  </div>
</div>

<?php get_footer(); ?>