<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

$container_class = apply_filters('fff/templates/class', 'container', 'content-single.php');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="<?php print $container_class; ?>">

        <header class="entry-header alignwide">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </header><!-- .entry-header -->

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

        <footer class="entry-footer default-max-width">

        </footer><!-- .entry-footer -->

        <?php if ( ! is_singular( 'attachment' ) ) : ?>
            <?php get_template_part( 'template-parts/post/author-bio' ); ?>
        <?php endif; ?>

    </div><!-- .container -->

</article><!-- #post-<?php the_ID(); ?> -->
