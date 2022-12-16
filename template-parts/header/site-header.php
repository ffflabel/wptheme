<?php
/**
 * Displays the site header.
 *
 */

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= has_nav_menu( 'primary' ) ? ' has-menu' : '';
?>

<header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">

    <div id="desktop-menu" class="header-row">

        <div class="header-desktop-top">
            <div class="container">
	            <?php get_template_part( 'template-parts/header/site-branding' ); ?>

                <div class="header-desktop-block">
                    <a href="mailto://example@gmail.com" class="header-block-item">
                        <div class="icon-mail"></div>
                        <span>example@gmail.com</span>
                    </a>
                    <a href="tel://+380505005050" class="header-block-item">
                        <div class="icon-phone"></div>
                        <span>+380505005050</span>
                    </a>
                    <a href="https://maps.google.com/?q=Uzhhorod" class="header-block-item location-item">
                        <div class="icon-home"></div>
		                <span>Uzhhorod</span>
                    </a>
                </div>

            </div>
        </div>

        <div class="header-desktop-bottom">
            <div class="container">
	            <?php get_template_part( 'template-parts/header/site-nav' ); ?>
                <div class="header-desktop-block">

                </div>
            </div>
        </div>

    </div>


</header><!-- #masthead -->
