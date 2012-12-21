<?php
/**
 * Single Person Template
 */

get_header(); // Loads the header.php template. ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div id="content-container">
				<div id="content-wrapper">
						<div id="content" class="hfeed content person">
		
							<h1 class="person-name"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h1>

							<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

								<div class="person-aside">
									
									<div class="avatar">
										<?php echo C::get_person_gravatar(); ?>
									</div>
									
									<?php
										$website = C::get_person_website();
										$social_website = C::get_person_social();
									?>
									<ul class="meta">
										<?php if ($website != ""):?>
											<li class="person-website"><a href="<?php echo esc_attr($website); ?>">Website</a></li>
										<?php endif; ?>
										<?php if ($social_website != ""):?>
											<li class="person-social"><a href="<?php echo esc_attr($social_website); ?>">Social</a></li>
										<?php endif; ?>
									</ul>
									
								</div>

								<div class="entry-content">
								
									<!-- content -->
									<?php the_content(); ?>

									<div class="edit"><?php edit_post_link( 'Edit Person' ); ?></div>

								</div><!-- .entry-content -->

								<div class="person-listings">

									<?php
										$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
										$episode_listing_args = array(
											'post_type' => 'episode',
											'posts_per_page' => 20,
											'paged' => $paged,
											'meta_value' => $post->post_name
										);
										$episodes = query_posts($episode_listing_args);
										if ( have_posts() ):
									?>
									<h3>Episodes with <?php echo get_the_title(); ?></h3>
									<ul>
									<?php
										while ( have_posts() ) : the_post();
									?>

									<div class="episode-listing">
										<li><a href="<?php the_permalink(); ?>"><?php echo convergence_episode_title($post); ?></a></li>
									</div>

									<?php
										endwhile;
										get_template_part('loop', 'nav');
										endif;
										wp_reset_query();
										wp_reset_postdata();
									?>
									</ul>
								</div>

								<?php do_atomic( 'after_entry' ); ?>

							</div><!-- .hentry -->

							<?php do_atomic( 'after_singular' ); ?>


						</div><!-- .content .hfeed -->
						
				</div><!-- #content-wrapper -->
		</div><!-- #content-container -->
		
		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); // Loads the footer.php template. ?>
