<?php

namespace FFFlabel\Inc;

use FFFlabel\Services\Traits\Singleton;

defined('ABSPATH') || exit;

class AssetsController {
    use Singleton;

    private $_styles = [];
    private $_critical_bundle = [];
    private $_lock = [];
    private $_media = [
        'sm' => 500,
        'mds' => 720,
        'md' => 1020,
        'lgs' => 1200,
        'lg' => 1400,
        'lgl' => 1650,
    ];
    private $_bundle_folder_dir;
    private $_bundle_folder_url;
    private $_bundle_folder_subdirectories = ['css', 'js'];

    private function __construct() {

        $this->addStyle(FFF_TEXTDOMAIN . '-style', FFF_THEMEURL . '/style.css', 'critical', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-xs', FFF_THEMEURL . '/style.xs.css', 'xs', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-sm', FFF_THEMEURL . '/style.sm.css', 'sm', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-mds', FFF_THEMEURL . '/style.mds.css', 'mds', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-md', FFF_THEMEURL . '/style.md.css', 'md', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-lgs', FFF_THEMEURL . '/style.lgs.css', 'lgs', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-lg', FFF_THEMEURL . '/style.lg.css', 'lg', []);
        $this->addStyle(FFF_TEXTDOMAIN . '-style-lgl', FFF_THEMEURL . '/style.lgl.css', 'lgl', []);

        add_action('wp_head', function() {
            AssetsController::instance()->bundleStyles();
        }, 999999);

        add_action('wp_footer', function() {
            AssetsController::instance()->bundleStyles();
        }, 999999);

        $this->registerBundleFolders();

        $hooks_needs_clear_bundle_folders = [
            'wp_insert_post',
            'after_delete_post',
            'saved_term',
            'delete_term'
        ];
        foreach ($hooks_needs_clear_bundle_folders as $hooks_needs_clear_bundle_folder) {
            add_action($hooks_needs_clear_bundle_folder, [$this, 'clearBundleFolders']);
        }
    }

    // region file

    /**
     * checks is $src is a local file
     * @var @src - url to the file
     */
    private function isLocalFile($src) : bool {
        if (mb_substr($src, 0, 1, "UTF-8") === '/' && !str_contains($src, '//')) {
            return true;
        }
        if (strpos($src, home_url('')) === 0) {
            return true;
        }
        return false;
    }

    /**
     * converts local file $src to local file $path
     * @var $src - url to the file
     * https://home.url/my_file -> /var/www/html/home.url/my_file
     */
    private function convertLocalFileSrcToLocalFilePath($src) : ?string {
        if ($this->isLocalFile($src)) {
            if (strpos($src, '/') === 0) {
                return ABSPATH . $src;
            }
            return str_replace(home_url(''), ABSPATH, $src);
        }
        return null;
    }

    /**
     * register the bundle folder and creates subfolders
     */
    private function registerBundleFolders() {
        $upload_dir = wp_upload_dir();
        $this->_bundle_folder_dir = $upload_dir['basedir'] . '/bundle';
        $this->_bundle_folder_url = $upload_dir['baseurl'] . '/bundle';
        if (!file_exists($this->_bundle_folder_dir)) {
            mkdir($this->_bundle_folder_dir, 0777, true);
        }
        foreach ($this->_bundle_folder_subdirectories as $dir) {
            if (!file_exists($this->_bundle_folder_dir . '/' . $dir)) {
                mkdir($this->_bundle_folder_dir . '/' . $dir, 0777, true);
            }
        }
    }

    /**
     * removes the subfolders of the bundle folder
     */
    public function clearBundleFolders() {
        foreach ($this->_bundle_folder_subdirectories as $dir) {
            rmdir($this->_bundle_folder_dir . '/' . $dir);
        }
        $this->registerBundleFolders();
    }

    // endregion

    // region globals

    /**
     * returns the media query value or array of the values
     * @param string $s
     * @return int|int[]
     */
    public function getMedia($s='') {
        return empty($s) ? $this->_media : (isset($this->_media[$s]) ? $this->_media[$s] : 0);
    }
    // endregion

    // region css

    /**
     * add the styles to the bundle to render on the final step
     * @var $handle - unique string
     * @var $src - url or path
     * @var $media - media query for the css file. Can also has 'critical' value, that means, this file will be bundled to the one of critical calls
     * @var $depend - array of the other styles handles required for this style
     */
    public function addStyle(string $handle, string $src, string $media = 'all', array $deps = []) {
        if (isset($this->_styles[$handle])) {
            return $this->_styles[$handle];
        }
        $path = $this->convertLocalFileSrcToLocalFilePath($src);
        $is_exists = ( $path ? file_exists($path) : true);
        $is_empty = ( $path && $is_exists ? (filesize($path) === 0) : false);
        $critical = $media === 'critical';

        if ($is_exists && !$is_empty) {
            switch ($media) {
                case 'critical':
                case 'xs':
                    $media = 'all';
                    break;
                case 'sm':
                case 'mds':
                case 'md':
                case 'lgs':
                case 'lg':
                case 'lgl':
                    $media = 'min-width: ' . $this->getMedia($media) . 'px';
                    break;
            }

            $this->_styles[$handle] = [
                'is_local'  => $path !== null,
                'path'      => $path,
                'src'       => $src,
                'media'     => $media,
                'deps'      => $deps,
                'critical'  => $critical,
                'added_time'=> microtime(),
                'bundled_time' => 0
            ];

            return $this->_styles[$handle];

        }

        return null;
    }

    /**
     * bundles the single style file
     */
    private function bundleStyle($handle) {
        if (!isset($this->_styles[$handle])) return;

        $model = $this->_styles[$handle];

        if ($model['bundled_time'] > 0) return;

        foreach ($model['deps'] as $deps_handle) {
            $this->renderStyle($deps_handle);
        }

        if ($model['critical']) {
            if ($model['is_local']) {
                $this->_critical_bundle[$handle] = file_get_contents($model['path']);
            } else {
                $this->_critical_bundle[$handle] = file_get_contents($model['src']);
            }
        } else {
            wp_enqueue_style(
                $handle,
                $model['src'],
                [],
                FFF_ASSETS_VERSION,
                $model['media']
            );
        }

        $this->_styles[$handle]['bundled_time'] = microtime();

    }

    /**
    * bundles the hall current scope of the styles
    */
    public function bundleStyles() {

        foreach ($this->_styles as $handle => $model) {
            $this->bundleStyle($handle);
        }

        if (!empty($this->_critical_bundle)) {

            $hash = array_keys($this->_critical_bundle);
            asort($hash);
            $hash = md5(implode($hash));
            $filepath = $this->_bundle_folder_dir . '/css/' . $hash . '.css';
            $fileurl = $this->_bundle_folder_url . '/css/' . $hash . '.css';
            if (!file_exists($filepath)) {
                $bundle = '';
                foreach ($this->_critical_bundle as $handle => $css) {
                    $buffer = preg_replace("/_COMSTART.*?COMEND_/s","",str_replace("*/","COMEND_", str_replace("/*","_COMSTART",
                        $css
                    )));

                    $bundle .= "\n/* " . $handle . " */\n" . str_replace([' )', ') '], ')',
                        str_replace([' (', '( '], '(',
                            str_replace([' ;', '; '], ';',
                                str_replace([' :', ': '], ':',
                                    str_replace([' }', '} ', ';}'], '}',
                                        str_replace([' {', '{ '], '{',
                                            str_replace([' ,', ', '], ',',
                                                str_replace('  ', ' ',
                                                    str_replace([' =', '= ', ' = '], '=',
                                                        trim(preg_replace('/\s\s+/', ' ', str_replace([
                                                                    "\n",
                                                                    "\t",
                                                                    "\r"
                                                                ], ' ',
                                                                    $buffer
                                                                )
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        )
                    ) . "\n";
                }
                file_put_contents($filepath, $bundle);
            } else {
                $bundle = file_get_contents($filepath);
            }
            echo '<style data-style_type="critical">' . $bundle . '</style>';

            $this->_critical_bundle = [];
        }

    }
    // endregion

    // region js
    // endregion

    // region icon
    // endregion

    // region image
    // endregion
}