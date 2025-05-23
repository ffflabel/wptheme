<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$container_class = apply_filters('fff/templates/class', 'container', 'content-page.php');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="<?php print $container_class; ?>">

        <?php if ( ! is_front_page() ) : ?>
            <header class="entry-header alignwide">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header><!-- .entry-header -->
        <?php endif; ?>

        <div class="entry-content">

            <?php
            the_content();

            wp_link_pages(
                array(
                    'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
                    'after'    => '</nav>',
                    /* translators: %: Page number. */
                    'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
                )
            );
            ?>

        </div><!-- .entry-content -->

    </div><!-- .container -->
</article><!-- #post-<?php the_ID(); ?> -->
