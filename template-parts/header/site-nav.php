<?php
/**
 * Displays the site navigation.
 *
 */

?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>
	<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'ffflabel' ); ?>">

        <?php wp_nav_menu([ 'theme_location' => 'primary', 'menu_id' => 'primary']);?>

	</nav><!-- #site-navigation -->
<?php endif; ?>
