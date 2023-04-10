<?php

namespace AudioPlaylistWoo\Functionality;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class CustomFields
{

	protected $plugin_name;
	protected $plugin_version;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_action('after_setup_theme', [$this, 'load_cf']);
		add_action('carbon_fields_register_fields', [$this, 'register_fields']);
	}

	public function load_cf()
	{
		\Carbon_Fields\Carbon_Fields::boot();
	}

	public function register_fields()
	{
		Container::make('post_meta', __('Playlist', 'audio-playlist-for-woocommerce'))
			->where('post_type', '=', 'product')
			->add_fields(array(
				Field::make('media_gallery', 'crb_product_playlist', __('Samples', 'audio-playlist-for-woocommerce'))
					->set_type(array('audio'))
			));

		Container::make('theme_options', __('Audio Playlist for WooCommerce Options',  'audio-playlist-for-woocommerce'))
			->set_icon('data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9JzEwMHB4JyB3aWR0aD0nMTAwcHgnICBmaWxsPSIjMUExQTFBIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB2ZXJzaW9uPSIxLjEiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgMTAwIDEwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTAwIDEwMCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZD0iTTgwLjY3Myw1MS4wMzFoLTRjMC0xNC4xNy0xMS45NjYtMjUuNjk4LTI2LjY3My0yNS42OThTMjMuMzI4LDM2Ljg2MSwyMy4zMjgsNTEuMDMxaC00ICBjMC0xNi4zNzUsMTMuNzYtMjkuNjk4LDMwLjY3Mi0yOS42OThDNjYuOTEzLDIxLjMzMyw4MC42NzMsMzQuNjU2LDgwLjY3Myw1MS4wMzF6Ij48L3BhdGg+PHBhdGggZD0iTTMwLjQ0MSwzMS40NDFjLTEuMjk5LTEuMjk5LTEuMTAyLTMuNjQsMC42NDItNC45ODVjMTEuMTA0LTguNTcsMjYuNzI5LTguNTcsMzcuODMzLDAuMDAxICBjMS43NDYsMS4zNDYsMS45MzksMy42ODUsMC42NDMsNC45ODRjLTEuMjk5LDEuMjk5LTMuNTk5LDEuMDU1LTUuMzg5LTAuMjI5Yy04LjQzOC02LjA0OS0xOS45MDQtNi4wNDktMjguMzQsMCAgQzM0LjAzOCwzMi40OTYsMzEuNzM5LDMyLjc0LDMwLjQ0MSwzMS40NDF6Ij48L3BhdGg+PGc+PGc+PHBhdGggZD0iTTE0Ljc5OSw3NC44MjJjMCwyLjg0MiwyLjU3NSw1LjE0Nyw1Ljc1Miw1LjE0N2wwLDBjMy4xNzcsMCw1Ljc1Mi0yLjMwNyw1Ljc1Mi01LjE0N1Y0Ny40MTggICAgYzAtMi44NDMtMi41NzUtNS4xNDgtNS43NTItNS4xNDhsMCwwYy0zLjE3NywwLTUuNzUyLDIuMzA1LTUuNzUyLDUuMTQ4Vjc0LjgyMnoiPjwvcGF0aD48ZWxsaXBzZSBjeD0iMTUuNTk1IiBjeT0iNjEuMTIxIiByeD0iOS40NjkiIHJ5PSIxMS4wMDgiPjwvZWxsaXBzZT48L2c+PHBhdGggZD0iTTI5LjU5OSw3Mi4yNzFjMCwxLjA3NC0wLjY2LDEuOTQ2LTEuNDc0LDEuOTQ2bDAsMGMtMC44MTMsMC0xLjQ3My0wLjg3Mi0xLjQ3My0xLjk0NlY0OS45NyAgIGMwLTEuMDc1LDAuNjYtMS45NDcsMS40NzMtMS45NDdsMCwwYzAuODE0LDAsMS40NzQsMC44NzIsMS40NzQsMS45NDdWNzIuMjcxeiI+PC9wYXRoPjwvZz48Zz48Zz48cGF0aCBkPSJNODUuMjAxLDc0LjgyMmMwLDIuODQyLTIuNTc1LDUuMTQ3LTUuNzUyLDUuMTQ3bDAsMGMtMy4xNzgsMC01Ljc1Mi0yLjMwNy01Ljc1Mi01LjE0N1Y0Ny40MTggICAgYzAtMi44NDMsMi41NzQtNS4xNDgsNS43NTItNS4xNDhsMCwwYzMuMTc3LDAsNS43NTIsMi4zMDUsNS43NTIsNS4xNDhWNzQuODIyeiI+PC9wYXRoPjxlbGxpcHNlIGN4PSI4NC40MDQiIGN5PSI2MS4xMjEiIHJ4PSI5LjQ3IiByeT0iMTEuMDA4Ij48L2VsbGlwc2U+PC9nPjxwYXRoIGQ9Ik03MC40LDcyLjI3MWMwLDEuMDc0LDAuNjYsMS45NDYsMS40NzUsMS45NDZsMCwwYzAuODEzLDAsMS40NzMtMC44NzIsMS40NzMtMS45NDZWNDkuOTdjMC0xLjA3NS0wLjY2LTEuOTQ3LTEuNDczLTEuOTQ3ICAgbDAsMGMtMC44MTQsMC0xLjQ3NSwwLjg3Mi0xLjQ3NSwxLjk0N1Y3Mi4yNzF6Ij48L3BhdGg+PC9nPjxwYXRoIGQ9Ik00MS45NDYsNTUuODM3djcuOTM2djcuOTM2YzAsMi4wNzgsMS44OSwyLjc0Miw0LjIxNywxLjQ4NmwxMy4zMTQtNy4xNTJjMi4zMjQtMS4yNTYsMi4zMjQtMy4yODUsMC00LjUzOWwtMTMuMzE0LTcuMTU4ICBDNDMuODM2LDUzLjA5OSw0MS45NDYsNTMuNzU5LDQxLjk0Niw1NS44Mzd6Ij48L3BhdGg+PHBhdGggZD0iTTUwLDgxLjYwM2MtMTAuMDUxLDAtMTguMjI5LTgtMTguMjI5LTE3LjgzYzAtOS44MzIsOC4xNzgtMTcuODMsMTguMjI5LTE3LjgzYzEwLjA1MiwwLDE4LjIyOSw3Ljk5OCwxOC4yMjksMTcuODMgIEM2OC4yMjksNzMuNjAzLDYwLjA1Miw4MS42MDMsNTAsODEuNjAzeiBNNTAsNDkuOTY4Yy03Ljc4MiwwLTE0LjExMyw2LjE5My0xNC4xMTMsMTMuODA1UzQyLjIxOCw3Ny41NzUsNTAsNzcuNTc1ICBzMTQuMTEyLTYuMTkxLDE0LjExMi0xMy44MDNTNTcuNzgyLDQ5Ljk2OCw1MCw0OS45Njh6Ij48L3BhdGg+PC9zdmc+')
			->set_page_menu_title(__('Audio Playlist',  'audio-playlist-for-woocommerce'))
			->set_page_file('apfw-options')
			->add_fields(array(
				Field::make('color', 'apfw_background_color', __('Playlist Background Color', 'audio-playlist-for-woocommerce'))
					->set_default_value('#000'),
				Field::make( 'association', 'apfw_pages_not_visible', __( 'Pages NOT showing the Playlist', 'audio-playlist-for-woocommerce' )  )
				->set_types( array(
					array(
						'type'=> 'post',
						'post_type' => 'page'
					)
				) ),
				Field::make( 'checkbox', 'apfw_hide_front_page', __( 'Hide Playlist on Front Page', 'audio-playlist-for-woocommerce' ) ),
				Field::make( 'checkbox', 'apfw_hide_posts', __( 'Hide Playlist on Posts', 'audio-playlist-for-woocommerce' ) )


			));
	}
}
