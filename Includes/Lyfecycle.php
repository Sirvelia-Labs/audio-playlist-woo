<?php

namespace AudioPlaylistWoo\Includes;

class Lyfecycle
{
	public static function activate()
	{
		do_action('AudioPlaylistWoo/setup');
	}

	public static function deactivate()
	{
	}

	public static function uninstall()
	{
		do_action('AudioPlaylistWoo/cleanup');
	}
}
