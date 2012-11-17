<?php
/**
 * Single Episode Template
 */

get_header(); // Loads the header.php template. ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div id="hero-container">
				<div id="hero-wrapper">
						<div id="hero">
								
								<div class="hero-meta">
									<h1 class="show-name">
										<span class="name"><?php the_category(' '); ?></span>
									</h1>
									<div class="show-description">
										<?php convergence_show_description(); ?>
									</div>
								</div>
								
								<div class="hero-image">
										<?php get_the_image( array('size' => 'medium') ); ?>
								</div>
								
						</div>
				</div>
		</div>

		<div id="content-container">
				<div id="content-wrapper">
						<div id="content" class="hfeed content episode">
		
							<h1 class="show-title"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h1>
							<?php convergence_episode(); ?>
							<?php convergence_posted(); ?>

							<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

								<div class="entry-content">

									<?php if (get_the_excerpt() != ''): ?>
										<div class="entry-meta">
											<?php echo get_the_excerpt(); ?>
										</div>
									<?php endif; ?>

									<!-- nsfw? -->
									<?php if (C::get_nsfw() != ''): ?>
										<div class="episode-nsfw">
											<p>This episode has been flagged as <span class="nsfw" title="Not Safe For Work">NSFW</span>. Please be advised.</p>
										</div>
									<?php endif; ?>

									<!-- content -->
									<?php the_content(); ?>

									<div class="edit"><?php edit_post_link( 'Edit Episode' ); ?></div>

								</div><!-- .entry-content -->

								<?php do_atomic( 'after_entry' ); ?>

							</div><!-- .hentry -->

							<?php do_atomic( 'after_singular' ); ?>


						</div><!-- .content .hfeed -->
						
						<div id="content-sidebar">
							<?php get_template_part('episode-file'); ?>
								
							<?php get_template_part('episode-subscribe'); ?>
								
							<?php get_template_part('episode-share'); ?>
							
							<?php get_template_part('episode-navigation'); ?>
						
						</div><!-- #content-sidebar -->
						
				</div><!-- #content-wrapper -->
		</div><!-- #content-container -->
		
		<?php endwhile; ?>
		<?php endif; ?>

<?php get_footer(); // Loads the footer.php template. ?>
