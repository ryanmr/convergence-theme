<?php echo $before_widget; ?>
<h3>The Latest Episode</h3>
<?php while ($query->have_posts()): $query->the_post(); ?>

	<div class="episode-block <?php hybrid_entry_class() ?>">

	  <?php
	    $image = get_the_image(array('size'=>'thumbnail', 'link_to_post'=>false, 'format'=>'array' ));
	    $image_url = convergence_villain_photon_image($image['url']);
	  ?>
	  <a href="<?php echo get_permalink(); ?>" title="<?php echo $image['alt']; ?>">
	    <img src="<?php echo $image_url; ?>" alt="<?php echo $image['alt']; ?>" class="<?php echo $image['class']; ?>" />
	  </a>

	</div><!-- .episode -->

<?php endwhile; ?>

<?php echo $after_widget; ?>