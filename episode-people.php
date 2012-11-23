<?php

	$who_ids = C::get_people_ids();
	if ( count($who_ids) <= 0 ) return; 

	// we leave the main loop from here temporarily
	$args = array(
		'post__in' => $who_ids, // round about
		'post_type' => array('person')
	);
	$query = new WP_Query($args);	
?>
	<div class="people">
			<!--<h3></h3>-->
			<div>
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<div class="person promo">
						
						<div class="avatar">
							<?php echo C::get_person_gravatar(85); ?>
						</div>
						<div class="name">
							<?php the_title(); ?>
						</div>
						
					</div>
				<?php endwhile; ?>
				
			</div>
	</div>
	
<?php
	// restores the main loop
	wp_reset_postdata();
?>
