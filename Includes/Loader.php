<?php
namespace AudioPlaylistWoo\Includes;

class Loader
{
	protected $plugin_name;
	protected $plugin_version;

	public function __construct()
	{
		$this->plugin_version = defined('AUDIOPLAYLISTWOO_VERSION') ? AUDIOPLAYLISTWOO_VERSION : '1.0.0';
		$this->plugin_name = 'audio-playlist-woo';
		$this->load_dependencies();

		add_action('plugins_loaded', [$this, 'load_plugin_textdomain']);
	}

	private function load_dependencies()
	{
		foreach (glob(AUDIOPLAYLISTWOO_PATH . 'Functionality/*.php') as $filename) {
			$class_name = '\\AudioPlaylistWoo\Functionality\\'. basename($filename, '.php');
			if (class_exists($class_name)) {
				try {
					new $class_name($this->plugin_name, $this->plugin_version);
				}
				catch (\Throwable $e) {
					pb_log($e);
					continue;
				}
			}
		}
	}

	public function load_plugin_textdomain()
	{
		load_plugin_textdomain('audio-playlist-woo', false, AUDIOPLAYLISTWOO_BASENAME . '/languages/');
	}
}
