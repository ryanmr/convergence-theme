<?php
/**
 * Archive People Template
 *
 */

get_header(); // Loads the header.php template. ?>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content archive-people">

		<?php do_atomic( 'before_content' ); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<div class="person-avatar">
					<?php get_the_image( array('default_image' => get_template_directory_uri()."/images/unknown-avatar.png", 'size'=>'post-thumbnail') ); ?>
				</div>

				<?php do_atomic( 'before_entry' ); ?>
                
				<div class="entry-summary">
					<?php the_excerpt(); ?>
                    
				</div><!-- .entry-summary -->

				<?php do_atomic( 'after_entry' ); ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); ?>

        </div><!-- .content .hfeed -->
    </div><!-- #content-wrapper -->
</div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>