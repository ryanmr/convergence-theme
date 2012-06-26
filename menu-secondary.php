<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/menus
 */

if ( has_nav_menu( 'secondary' ) ) : ?>

	<div id="secondary-menu" class="menu-container">

		<?php do_atomic( 'before_secondary_menu' ); // hybrid_before_secondary_menu ?>

		<?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'menu', 'menu_class' => '', 'fallback_cb' => '' ) ); ?>

		<?php do_atomic( 'after_secondary_menu' ); // hybrid_after_secondary_menu ?>

	</div><!-- #secondary-menu .menu-container -->

<?php endif; ?>