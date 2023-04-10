<?php

namespace AudioPlaylistWoo\Includes;

class Lyfecycle
{
	public static function activate()
	{
		do_action('AudioPlaylistWoo/setup');
		add_option( '_apfw_background_color', '#000000' );
	}

	public static function deactivate()
	{
	}

	public static function uninstall()
	{
		do_action('AudioPlaylistWoo/cleanup');
		delete_option( '_apfw_background_color' );
	}
}
