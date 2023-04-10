<?php

/**
 *
 * @wordpress-plugin
 * Plugin Name:       Audio Playlist for WooCommerce
 * Plugin URI:        https://github.com/Sirvelia/Audio-Playlist-for-WooCommerce
 * Description:       Audio player with playlist for WooCommerce products.
 * Version:           1.1.0
 * Author:            Sirvelia
 * Author URI:        https://sirvelia.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       audio-playlist-for-woocommerce
 * Domain Path:       /languages
 */

// Direct access, abort.
if (!defined('WPINC')) {
	die('YOU SHALL NOT PASS!');
}

define('AUDIOPLAYLISTWOO_VERSION', '1.1.0');
define('AUDIOPLAYLISTWOO_PATH', plugin_dir_path(__FILE__));
define('AUDIOPLAYLISTWOO_BASENAME', plugin_basename(__FILE__));
define('AUDIOPLAYLISTWOO_URL', plugin_dir_url(__FILE__));

require_once AUDIOPLAYLISTWOO_PATH . 'vendor/autoload.php';

register_activation_hook(__FILE__, [AudioPlaylistWoo\Includes\Lyfecycle::class, 'activate']);
register_deactivation_hook(__FILE__, [AudioPlaylistWoo\Includes\Lyfecycle::class, 'deactivate']);
register_uninstall_hook(__FILE__, [AudioPlaylistWoo\Includes\Lyfecycle::class, 'uninstall']);

//LOAD ALL PLUGIN FILES
$loader = new AudioPlaylistWoo\Includes\Loader();