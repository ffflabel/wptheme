<?php

namespace FFFlabel\Inc;


use FFFlabel\Services\Traits\Singleton;

class Ajax {
	use Singleton;

	private function __construct()
	{
		self::add('test', [$this, 'ajaxTest']);
	}

	public static function add($action, callable $callback, $type='both', $priority = 10)
	{
		if ($type=='both') {
			add_action('wp_ajax_' . $action, $callback, $priority);
			add_action('wp_ajax_nopriv_' . $action, $callback, $priority);
		} elseif ($type=='nopriv') {
			add_action('wp_ajax_nopriv_' . $action, $callback, $priority);
		} else {
			add_action('wp_ajax_' . $action, $callback, $priority);
		}
	}

	public function ajaxTest(): void
	{
		$return = [
			'success' => false,
			'data' => [],
			'errors' => []
		];

		wp_send_json($return);
	}
}