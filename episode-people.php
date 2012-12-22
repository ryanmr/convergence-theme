<?php

	$who_ids = C::get_people_ids();
	if ( count($who_ids) <= 0 ) return;
	// if there are no people set (or found), skip this setup 

	// we leave the main loop from here temporarily
	$args = array(
		'post__in' => $who_ids, // round about
		// luckily, this filters out multiple entries
		'post_type' => array('person')
	);
	$query = new WP_Query($args);	
?>
	<div class="people">
			<h3>In This Episode</h3>
			<div>
				<?php
					$no_gravatar = array();

					while ( $query->have_posts() ): $query->the_post();
					$person_name = get_the_title();
					$person_gravatar = C::get_person_gravatar_raw();

					/*
						Save any Person with an empty $gravatar.
					*/
					if ( '' == trim($person_gravatar) ) {
						$no_gravatar[] = $post;
						continue;
					}

				?>
					<div class="person promo">
						
						<div class="avatar"><a href="<?php the_permalink(); ?>"><?php echo C::get_person_gravatar(75); ?></a></div>
						<div class="name"><a href="<?php the_permalink(); ?>"><?php echo $person_name; ?></a></div>
						
					</div>
				<?php endwhile; ?>
				
			</div>
			<br class="clearfix" />
			<div class="auxillary-people">
				<?php
					/*
						Displays any Person without a gravatar in a single comma deliminated list with an "and" for the last element.
					*/
					$alterted = array();
					global $post;
					foreach ($no_gravatar as $post) {
						setup_postdata( $post ); 
						$alterted[] = '<span class="name"><a href="'.get_permalink().'">'.get_the_title().'</a></span>';
					}
				?>
				
				<p>Along with <?php echo _implode_and($alterted); ?>.</p>
			</div>
			
	</div>
	
<?php
	// restores the main loop
	wp_reset_postdata();
?>
