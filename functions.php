<?php


use FFFlabel\Inc\General;

################################################################################
# Constants
################################################################################

define('FFF_THEMEURL', get_template_directory_uri());
define('FFF_THEMEDIR', __DIR__);

$theme = wp_get_theme();
$textdomain = $theme->get('TextDomain');
$version = $theme->get('Version');

define('FFF_TEXTDOMAIN', $textdomain ?? 'ffflabel');

define('FFF_ASSETSURL', FFF_THEMEURL . '/assets');
define('FFF_ASSETSDIR', FFF_THEMEDIR . DIRECTORY_SEPARATOR . 'assets');


define('FFF_VERSION', $version ?? '0.0.1');
define('FFF_ASSETS_VERSION', filemtime(FFF_THEMEDIR . DIRECTORY_SEPARATOR . 'style.css'));

define('FFF_INCDIR', FFF_THEMEDIR . DIRECTORY_SEPARATOR . 'Inc');

if (!defined('FFF_VENDORDIR')) {
	define('FFF_VENDORDIR', FFF_THEMEDIR . DIRECTORY_SEPARATOR . 'vendor');
}

################################################################################
# Includes
################################################################################

require_once FFF_VENDORDIR . DIRECTORY_SEPARATOR . '/autoload.php';
require_once FFF_THEMEDIR . DIRECTORY_SEPARATOR . '/template-functions.php';


################################################################################
# Init
################################################################################

General::instance();


