<?php
/**
 * Singular Template
 * 
 */

get_header(); // Loads the header.php template. ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<div id="content-container">
				<div id="content-wrapper">
						<div id="content" class="hfeed content people">
		
							<div class="person-avatar">
								<?php get_the_image( array('default_image' => get_template_directory_uri()."/images/unknown-avatar.png", 'size'=>'person-medium') ); ?>
							</div>

							<h1 class="person-name"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h1>

							<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

								<div class="entry-content">

									<?php the_content(); ?>

									<div class="edit"><?php edit_post_link( 'Edit Person' ); ?></div>

								</div><!-- .entry-content -->

								<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

							</div><!-- .hentry -->

							<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>


						</div><!-- .content .hfeed -->
				</div><!-- #content-wrapper -->
		</div><!-- #content-container -->
		
		<?php endwhile; ?>
		<?php endif; ?>

		<?php //do_atomic( 'after_content' ); // hybrid_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
