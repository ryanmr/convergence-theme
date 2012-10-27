<div id="post-<?php the_ID(); ?>" class="episode-block <?php hybrid_entry_class() ?>">

  <?php get_the_image(array('size'=>'thumbnail')); ?>
  
  <h3 class="show-title"><a href="<?php echo get_permalink() ?>">
      <?php the_title(); ?>
  </a></h3>
  
  
  <h4 class="show-name">
    <span class="name">
    <?php the_category(' '); ?></span>
    
    <span class="sep">#</span><span class="number"><?php echo( get_episode_number( get_permalink() ) ); ?></span>
  </h4>
  
  
  <h5 class="show-date"><a href="<?php echo get_permalink() ?>">
      <?php echo get_the_date("F j") ?>
      <?php
        if ( strtotime($date) > strtotime("-7 days") ) {
            echo('<span class="new">New</span>');
        }
      ?>
  </a></h5>
  
  
</div><!-- .episode -->