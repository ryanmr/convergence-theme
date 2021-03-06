<?php
/**
 * Template Name: Latest
 *
 * If you want to set up an alternate blog page, just use this template for your page.
 * This template shows your latest posts.
 */

get_header(); // Loads the header.php template. ?>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content latest">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php
			$latest_arguments = array( 'post_type' => 'episode', 'posts_per_page' => get_option( 'posts_per_page' ), 'paged' => $paged );
			$lastest_arguments['tax_query'] = array(convergence_exclude_episode_attributes('hidden'));
			$wp_query = new WP_Query($latest_arguments);
			$more = 0;
		?>

		<?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php get_the_image( array( 'size' => 'thumbnail' ) ); ?>

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>
                
				<div class="entry-summary">
					<?php the_excerpt(); ?>
                    
				</div><!-- .entry-summary -->

				<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

            </div><!-- .content .hfeed -->
        </div><!-- #content-wrapper -->
    </div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>