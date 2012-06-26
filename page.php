<?php
/**
 * Singular Template
 * 
 */

get_header(); // Loads the header.php template. ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content">
    
                <h1 class="show-title"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h1>            
                <div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', hybrid_get_textdomain() ), 'after' => '</p>' ) ); ?>
					<div class="edit"><?php edit_post_link( 'Edit' ); ?></div>
				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

			</div><!-- .hentry -->

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

			<?php comments_template( '/comments.php', true ); // Loads the comments.php template ?>

            </div><!-- .content .hfeed -->
            
        </div><!-- #content-wrapper -->
    </div><!-- #content-container -->
    
    <?php endwhile; ?>
    <?php else : ?>

        <?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

    <?php endif; ?>

    <?php //do_atomic( 'after_content' ); // hybrid_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>
