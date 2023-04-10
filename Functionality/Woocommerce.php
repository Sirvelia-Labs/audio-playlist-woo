<?php
namespace AudioPlaylistWoo\Functionality;

use AudioPlaylistWoo\Includes\BladeLoader;

class Woocommerce
{

	protected $plugin_name;
	protected $plugin_version;

	private $blade;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;
		$this->blade = BladeLoader::getInstance();

		add_action('wp_footer', [$this, 'show_audio_playlist_woocommerce']);
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

	function getPlaylistTime( $time ) {
		if ( is_string( $time ) ) {
			$minutes = floor($time / 60);
			$minutes = ($minutes >= 10) ? $minutes : "0" . $minutes;
			$seconds = floor($time % 60);
			$seconds = ($seconds >= 10) ? $seconds : "0" . $seconds;
			return $minutes . ':' . $seconds;
		}
		
		return false;
	}

	public function show_audio_playlist_woocommerce()
	{
		if ( !is_cart() && !is_checkout() ) {
			$playlist = '';
	
			if( isset( $_COOKIE["sirvelia-player-playlist"] ))  {
			  $playlist_cookie = wp_kses_post( $_COOKIE["sirvelia-player-playlist"] );
			  $playlist = json_decode( html_entity_decode( stripslashes ( $playlist_cookie ) ) );
			}
	
			$time_cookie = isset( $_COOKIE["sirvelia-player-time"] ) ? wp_kses_post( $_COOKIE["sirvelia-player-time"] ) : 0;
	
			$active_song = '';
	
			if( $playlist ) {
			  $key = array_search('true', array_column($playlist, 'isActive'));
			  $active_song = $playlist[$key];
			}
	
		   	echo $this->blade->template('audio-player', [
				'active_song' 		=> $active_song,
				'time_cookie' 		=> $time_cookie,
				'playlist'			=> $playlist,
				'getPlaylistTime'	=> [$this, 'getPlaylistTime'],
			]);
		  }
	}
}
