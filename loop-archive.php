<?php if ( is_post_type_archive('person') ): ?>

		<div class="person promo">
			
			<div class="avatar"><a href="<?php the_permalink(); ?>"><?php echo C::get_person_gravatar(175); ?></a></div>
			<div class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
			
		</div>

<?php else: ?>
	<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

		<?php get_the_image( array( 'size' => 'thumbnail' ) ); ?>

		<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>
        
		<div class="entry-summary">
			<?php the_excerpt(); ?>
            
		</div><!-- .entry-summary -->

		<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

	</div><!-- .hentry -->
<?php endif; ?>