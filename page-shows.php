<?php
/**
 * Template Name: Shows
 *
 * This template shows the shows on the network based on the category naming scheme.
 */

get_header(); // Loads the header.php template. ?>

    <div id="content-container">
        <div id="content-wrapper">
            <div id="content" class="hfeed content shows">

            	<?php if (get_the_excerpt() != ""): ?>
            	<p class="show-promo">
            		<?php echo get_the_excerpt(); ?>
            	</p>
            	<?php endif; ?>

            	<div class="show-shelf">
		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php
			$arguments = array(
				'orderby' => 'name',
			);
			$categories = get_categories();
			$query = new WP_Query();
		?>

		<?php if ( $categories ): foreach ($categories as $category):
			$query->query(array('posts_per_page' => 1, 'cat' => $category->term_id));
			if ( $query->have_posts() ): $query->the_post();
			// the loop is open
		?>

			<div id="post-<?php the_ID(); ?>" class="episode-block <?php hybrid_entry_class() ?>">

				<div class="block">
				  <a href="<?php echo get_category_link($category->term_id); ?>"><?php get_the_image(array('size'=>'thumbnail', 'link_to_post' => false)); ?></a>
				  
				  <div class="meta">
					  <h2 class="show-name">
					    <span class="name"><?php echo $category->name ?></span>
					  </h2>
					  <h4 title="View the latest episode of <?php echo $category->name; ?>">		<span><?php convergence_new_episode(7); ?><span> <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>">Latest &raquo;</a>
					  </h3>
				  </div>
				</div>
			  
			</div><!-- .episode -->

		<?php endif; endforeach; endif; wp_reset_postdata(); ?>

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

				</div><!-- .show-shelf -->
            </div><!-- .content .hfeed -->
        </div><!-- #content-wrapper -->
    </div><!-- #content-container -->

<?php get_footer(); // Loads the footer.php template. ?>