<?php
/**
```` * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

$container_class = apply_filters('fff/templates/class', 'container', 'content.php');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="<?php print $container_class; ?>">

        <header class="entry-header">
            <?php if ( is_singular() ) : ?>
                <?php the_title( '<h1 class="entry-title default-max-width">', '</h1>' ); ?>
            <?php else : ?>
                <?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php endif; ?>

        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'ffflabel' ) . '">',
                    'after'    => '</nav>',
                    /* translators: %: Page number. */
                    'pagelink' => esc_html__( 'Page %', 'ffflabel' ),
                )
            );

            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer default-max-width">

        </footer><!-- .entry-footer -->

    </div><!-- .container -->

</article><!-- #post-<?php the_ID(); ?> -->
