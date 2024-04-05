<?php

namespace FFFlabel\Inc;

use FFFlabel\Services\Traits\Singleton;

class General {
	use Singleton;

	private function __construct() {

		################################################################################
		# setup theme
		################################################################################
		add_action('init', [$this, 'startSession'], 1);

		add_action('init', [$this, 'registerStyles']);
		add_action('init', [$this, 'registerScripts']);

		add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);

		add_action( 'widgets_init', [$this, 'registerSidebars'] );

		add_theme_support('title-tag');
		add_theme_support( 'align-wide' );
		add_theme_support( 'align-full' );


		################################################################################
		# Settings
		################################################################################

		//create settings page
		if (function_exists('acf_add_options_page')) {

			acf_add_options_page([
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			]);
		}

		################################################################################
		# Image
		################################################################################
		add_action('after_setup_theme', [$this, 'initImageSizes']);

		################################################################################
		# Nav
		################################################################################

		add_theme_support('menus');
		register_nav_menus(['primary' => 'Primary menu', 'footer' => 'Footer menu', 'mobile-menu' => 'Mobile menu']);

		################################################################################
		# Blocks
		################################################################################

		if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
			add_filter( 'block_categories_all', [$this, 'registerLayoutCategory'] );
		} else {
			add_filter( 'block_categories', [$this, 'registerLayoutCategory'] );
		}

	}

	public function startSession()
	{
		if (!session_id()) {
			session_start();
		}
	}

	/**
	 * register styles for the theme
	 */
	public function registerStyles()
	{
		wp_register_style(FFF_TEXTDOMAIN . '-style', FFF_THEMEURL . '/style.css', '', FFF_ASSETS_VERSION);
	}

	/**
	 * register js scripts for the theme
	 */
	public function registerScripts()
	{
		wp_register_script(FFF_TEXTDOMAIN . '-main', FFF_ASSETSURL . '/js/main.js', ['jquery'], FFF_ASSETS_VERSION, true);
	}


	/**
	 *  enqueue all styles and scripts
	 */
	public function enqueueScripts()
	{
		wp_enqueue_style(FFF_TEXTDOMAIN . '-style');
//		wp_enqueue_style(TEXTDOMAIN . '-style_sm');
//		wp_enqueue_style(TEXTDOMAIN . '-style_lg');

		wp_enqueue_script(FFF_TEXTDOMAIN . '-main');
		wp_localize_script(FFF_TEXTDOMAIN . '-main', 'variables', [
			'ajaxurl'      => admin_url('admin-ajax.php'),
			'locale'       => get_locale(),
			'post_id'      => get_the_ID(),
			'template_uri' => get_stylesheet_directory_uri(),
		]);
	}

	public function registerSidebars() {

		$sidebars = apply_filters('ffflabel/general/sidebars', [
			[
				'name'          => esc_html__( 'Footer', 'twentytwentyone' ),
				'id'            => 'sidebar-footer',
				'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'twentytwentyone' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			]
		]);

		if (!empty($sidebars)) {
			foreach ($sidebars as $sidebar) {
				register_sidebar($sidebar);
			}
		}
	}

	public function registerLayoutCategory($categories)
	{
		$categories[] = array(
			'slug'  => 'fffblocks',
			'title' => 'White Label Blocks'
		);

		return $categories;
	}

	public function initImageSizes()
	{
		add_theme_support('post-thumbnails');
		add_theme_support('custom-logo', [
			'height'      => 20,
			'width'       => 86,
			'flex-width'  => true,
			'flex-height' => true,
		]);
	}

}
