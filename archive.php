<?php
/**
 * Archive Template
 *
 * The archive template is basically a placeholder for archives that don't have a template file. 
 * Ideally, all archives would be handled by a more appropriate template according to the current
 * page context.
 *
 * @package Hybrid
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

    <div id="hero-container">
        <div id="hero-wrapper">
            <div id="hero">
            
            		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>
                    
            </div>
        </div>
    </div>    

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content archive">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php get_template_part('loop-archive'); ?>

		<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

        </div><!-- .content .hfeed -->
    </div><!-- #content-wrapper -->
</div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>