<div id="post-<?php the_ID(); ?>" class="episode-block <?php hybrid_entry_class() ?>">

  <?php
    $image = get_the_image(array('size'=>'thumbnail', 'link_to_post'=>false, 'format'=>'array' ));
    $image_url = convergence_villain_photon_image($image['url']);
  ?>
  <a href="<?php echo get_permalink(); ?>" title="<?php echo $image['alt']; ?>">
    <img src="<?php echo $image_url; ?>" alt="<?php echo $image['alt']; ?>" class="<?php echo $image['class']; ?>" />
  </a>
  
  <h3 class="show-title"><a href="<?php echo get_permalink(); ?>">
      <?php the_title(); ?>
  </a></h3>
  
  
  <h4 class="show-name">
    <span class="name">
    <?php the_category(' '); ?></span>
    
    <span class="sep">#</span><span class="number"><?php echo( get_episode_number( get_permalink() ) ); ?></span>
  </h4>
  
  
  <h5 class="show-date">
      <?php echo get_the_date("F j");
      convergence_new_episode(7);
      ?>
  </h5>
  
  
</div><!-- .episode -->