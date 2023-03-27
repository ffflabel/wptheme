<?php

namespace FFFlabel\Inc;

use FFFlabel\Services\Traits\Singleton;

defined('ABSPATH') || exit;

class AssetsController extends Singleton {

    private $_styles = [];

    private function __construct() {

    }

    public function loadStyle($handle, $src, $deps = [], $ver = false, $media = 'all') {

    }
}

AssetsController::instance();