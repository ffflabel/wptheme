<?php

use FFFlabel\Inc\SVGIcons;


/**
 * Gets the SVG code for a given icon.
 *
 *
 * @param string $group The icon group.
 * @param string $icon  The icon.
 * @param int    $size  The icon size in pixels.
 * @return string
 */
function fff_get_icon_svg( $group, $icon, $size = 24 ) {
	return SVGIcons::getSvg( $group, $icon, $size );
}
