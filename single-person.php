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
									<div class="meta">
										<?php if ($website != ""):?>
											<p class="person-website"><a href="<?php echo esc_attr($website); ?>">Website</a></p>
										<?php endif; ?>
										<?php if ($social != ""):?>
											<p class="person-social"><a href="<?php echo esc_attr($social); ?>">Social</a></p>
										<?php endif; ?>
									</div>
									
								</div>

								<div class="entry-content">
								
									<!-- content -->
									<?php the_content(); ?>

									<div class="edit"><?php edit_post_link( 'Edit Person' ); ?></div>

								</div><!-- .entry-content -->

								<?php do_atomic( 'after_entry' ); ?>

							</div><!-- .hentry -->

							<?php do_atomic( 'after_singular' ); ?>


						</div><!-- .content .hfeed -->
						
				</div><!-- #content-wrapper -->
		</div><!-- #content-container -->
		
		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); // Loads the footer.php template. ?>
