<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

$container_class = apply_filters('fff/templates/class', 'container', 'footer.php');

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

	<footer id="colophon" class="site-footer">
        <div class="<?php print $container_class; ?>">
            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav aria-label="<?php esc_attr_e( 'Footer menu', 'ffflabel' ); ?>" class="footer-navigation">
                    <ul class="footer-navigation-wrapper">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'items_wrap'     => '%3$s',
                                'container'      => false,
                                'depth'          => 1,
                                'link_before'    => '<span>',
                                'link_after'     => '</span>',
                                'fallback_cb'    => false,
                            )
                        );
                        ?>
                    </ul><!-- .footer-navigation-wrapper -->
                </nav><!-- .footer-navigation -->
            <?php endif; ?>

            <div class="site-info">
                <div class="site-name">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="site-logo"><?php the_custom_logo(); ?></div>
                    <?php else : ?>
                        <?php if ( get_bloginfo( 'name' ) ) : ?>
                            <?php if ( is_front_page() && ! is_paged() ) : ?>
                                <?php bloginfo( 'name' ); ?>
                            <?php else : ?>
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-name -->


                <div class="powered-by">
                    <?php
                    printf(
                        esc_html__( 'Proudly powered by %s.', 'ffflabel' ),
                        '<a href="' . esc_url( __( 'https://ffflabel.com/', 'ffflabel' ) ) . '">White Label</a>'
                    );
                    ?>
                </div><!-- .powered-by -->

            </div><!-- .site-info -->

        </div><!-- .container -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
