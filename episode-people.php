<?php
	$who = C::get_people();
	// $args = array(
	// 	'name' => implode(',', $who),
	// 	'post_type' => array('person')
	// );
	// $query = new WP_Query($args);
	
?>
	<div class="people">
			<!--<h3></h3>-->
			<div>
				<?php while ( $query->have_posts() ): $query->the_post(); ?>
					<div class="person promo">
						
						<div class="avatar">
							<?php echo C::get_person_gravatar(100); ?>
						</div>
						<div class="name">
							<?php the_title(); ?>
						</div>
						
					</div>
				<?php endwhile; ?>
				
			</div>
	</div>
