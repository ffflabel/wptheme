<?php
/**
 * Displays the footer widget area.
 *
 */

if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>

	<aside class="widget-area">
		<?php dynamic_sidebar( 'sidebar-footer' ); ?>
	</aside><!-- .widget-area -->

<?php endif; ?>
