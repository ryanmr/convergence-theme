<?php

	$who_ids = C::get_people_ids();
	if ( count($who_ids) <= 0 ) return;
	// if there are no people set (or found), skip this setup 

	// we leave the main loop from here temporarily
	$args = array(
		'post__in' => $who_ids, // round about
		'post_type' => array('person')
	);
	$query = new WP_Query($args);	
?>
	<div class="people">
			<h3>In This Episode</h3>
			<div>
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<div class="person promo">
						
						<div class="avatar"><a href="<?php the_permalink(); ?>"><?php echo C::get_person_gravatar(75); ?></a></div>
						<div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
						
					</div>
				<?php endwhile; ?>
				
			</div>
	</div>
	
<?php
	// restores the main loop
	wp_reset_postdata();
?>
