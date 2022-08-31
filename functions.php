<?php


use FFFlabel\Inc\General;

################################################################################
# Constants
################################################################################

define('THEMEURL', get_stylesheet_directory_uri());
define('THEMEDIR', __DIR__);

$theme = wp_get_theme();
$textdomain = $theme->get('TextDomain');
$version = $theme->get('Version');

define('TEXTDOMAIN', $textdomain ?? 'ffflabel');

define('VERSION', $version ?? '0.0.1');
define('ASSETS_VERSION', '0.0.1');

define('ASSETSURL', THEMEURL . '/assets');
define('ASSETSDIR', THEMEDIR . '/assets');

define('INCDIR', THEMEDIR . DIRECTORY_SEPARATOR . 'Inc');
define('VENDORDIR', THEMEDIR . DIRECTORY_SEPARATOR . 'vendor');

################################################################################
# Includes
################################################################################

require_once VENDORDIR . '/autoload.php';


################################################################################
# Init
################################################################################

General::instance();


