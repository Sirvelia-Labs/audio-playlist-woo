<?php
namespace AudioPlaylistWoo\Functionality;

class Woocommerce
{

	protected $plugin_name;
	protected $plugin_version;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;

		add_action('AudioPlaylistWoo/setup', [$this, 'check_woocommerce']);
	}

	public function check_woocommerce()
	{
		if (!function_exists('is_plugin_active_for_network')) {
			include_once(ABSPATH . '/wp-admin/includes/plugin.php');
		}

		if (current_user_can('activate_plugins') && !class_exists('WooCommerce')) {
			deactivate_plugins(AUDIOPLAYLISTWOO_BASENAME);
			add_action( 'admin_notices', [$this, 'need_woocommerce'] );
 			return; 
		}
	}

	public function need_woocommerce()
	{
		?>
			<div class="notice notice-error is-dismissible">
				<p>
					<?php echo sprintf(
						__('Audio Playlist for WooCommerce requires WooCommerce. Please install and activate the  %sWooCommerce%s plugin', 'audio-playlist-for-woocommerce'),
						'<a href="https://wordpress.org/plugins/woocommerce/">',
						'</a>'
					); ?>
				</p>
			</div>
		<?php
	}
	
}
