<?php
namespace AudioPlaylistWoo\Functionality;

use AudioPlaylistWoo\Includes\BladeLoader;

class Playlist
{

	protected $plugin_name;
	protected $plugin_version;

	private $blade;

	public function __construct($plugin_name, $plugin_version)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_version = $plugin_version;
		$this->blade = BladeLoader::getInstance();
		
		pb_script(
			'audio-playlist-woo', AUDIOPLAYLISTWOO_URL . 'dist/app.js',
			[$this, 'playlist_is_visible'], 
			['jquery'],
			[
				'name' => 'AudioPlaylistForWoocommerceStrings',
				'args' =>
				[
					'open_playlist' => __( 'Open Playlist', 'audio-playlist-for-woocommerce' ),
					'close_playlist' => __( 'Close Playlist', 'audio-playlist-for-woocommerce' ),
					'view' => __( 'Go to product', 'audio-playlist-for-woocommerce' ),
					'remove' => __( 'Remove song', 'audio-playlist-for-woocommerce' )
				]
			]
		);

		pb_style('audio-playlist-woo', AUDIOPLAYLISTWOO_URL . 'dist/app.css', [$this, 'playlist_is_visible']);

		add_action('woocommerce_after_shop_loop_item', [$this, 'show_product_playlist'], 8);
		add_action('woocommerce_single_product_summary', [$this, 'show_full_product_playlist'], 25);
		add_action('wp_footer', [$this, 'show_audio_playlist_woocommerce']);

		
	}

	public function playlist_is_visible()
	{
		// == Pages not visible
		$pages_not_visible = carbon_get_theme_option( 'apfw_pages_not_visible' );
		$pages = [];

		if ( $pages_not_visible ) {
			$pages = array_map( function($v) {
				return $v['id'];
			}, $pages_not_visible );

		}

		if ( is_front_page() && carbon_get_theme_option( 'apfw_hide_front_page' ) == '1' ) return false;
		if ( is_singular( 'post' ) && carbon_get_theme_option( 'apfw_hide_posts' ) == '1' ) return false;
		
		return ( array_search( get_the_ID(), $pages ) !== false ) ? false : true;
	}

	public function show_product_playlist() {
		echo $this->product_playlist();
	}

	public function show_full_product_playlist() {
		echo $this->full_product_playlist();
	}

	public function product_playlist() {
	    global $product;
	    if ( $product ) {
	      $post_id = $product->get_id();
	      $playlist = carbon_get_post_meta( $post_id, 'crb_product_playlist' );

	      if ( $playlist ) {

	        $data = array();

	        foreach ($playlist as $song) {
	          $data[] = array(
	            'title'   => get_the_title($song),
	            'url'     => wp_get_attachment_url($song),
	            'productUrl' => get_permalink($post_id)
	          );
	        }
	        $json_data = json_encode( $data );
	        return '<a class="add-product-playlist play-all pb-my-1.5 pb-inline-block pb-text-black pb-font-bold hover:pb-no-underline" href="#" title="' . __( 'Play All', 'audio-playlist-for-woocommerce' ) . '" data-json=\'' . $json_data . '\'>' . __( 'Play All', 'audio-playlist-for-woocommerce' ) . '</a>';
	      }
	    }
	    return false;
	}

	function full_product_playlist() {

	    global $product;
	    if ( $product ) {
	      $post_id = $product->get_id();
	      $playlist = carbon_get_post_meta( $post_id, 'crb_product_playlist' );

	      if ( $playlist ) {

	        $data = array();
	        $list_songs = '<ul id="sirvelia-songs-list">';

	        foreach ($playlist as $song) {

	          $song_title = get_the_title($song);
	          $song_url = wp_get_attachment_url($song);
	          $data_song = array(
	            'title'   => $song_title,
	            'url'     => $song_url,
	            'productUrl' => get_permalink($post_id)
	          );
	          $data[] = $data_song;

	          $json_song = json_encode( array($data_song) );
	          $list_songs .= '<li class="single-song pb-border-solid pb-border-0 pb-border-b pb-border-b-gray-200 pb-list-none"><a class="add-product-playlist pb-flex pb-items-center pb-gap-1 pb-no-underline pb-text-black hover:pb-text-gray-800" href="#" title="' . $song_title . '" data-json=\'' . $json_song . '\'><svg class="pb-h-5 pb-w-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			  <path clip-rule="evenodd" fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z"></path>
			</svg> ' . $song_title . '</a></li>';
	        }

	        $list_songs .= '</ul>';

	        $json_data = json_encode( $data );
	        $btn = '<a class="add-product-playlist play-all pb-my-1.5 pb-inline-block pb-text-black pb-font-bold hover:pb-no-underline" href="#" title="' . __( 'Play All', 'audio-playlist-for-woocommerce' ) . '" data-json=\'' . $json_data . '\'>' . __( 'Play All', 'audio-playlist-for-woocommerce' ) . '</a>';

	        if( is_product() ) return $btn . $list_songs;
	        else return $btn;
	      }
	    }
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

	function lighten( $hexcolor, $percent ) {
	  if ( strlen( $hexcolor ) < 6 ) {
	    $hexcolor = $hexcolor[0] . $hexcolor[0] . $hexcolor[1] . $hexcolor[1] . $hexcolor[2] . $hexcolor[2];
	  }
	  $hexcolor = array_map('hexdec', str_split( str_pad( str_replace('#', '', $hexcolor), 6, '0' ), 2 ) );

	  foreach ($hexcolor as $i => $color) {
	    $from = $percent < 0 ? 0 : $color;
	    $to = $percent < 0 ? $color : 255;
	    $pvalue = ceil( ($to - $from) * $percent );
	    $hexcolor[$i] = str_pad( dechex($color + $pvalue), 2, '0', STR_PAD_LEFT);
	  }

		return '#' . implode($hexcolor);
	}

	public function show_audio_playlist_woocommerce()
	{
		if ( $this->playlist_is_visible() ) {
			$playlist = '';
			$color = carbon_get_theme_option( 'apfw_background_color' );
	
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
				'bg_color' => esc_attr( $color ),
				'alt_color' => esc_attr( $this->lighten( $color, 0.4 ) ),
				'active_color' => esc_attr( $color, 0.1 )
			]);
		  }
	}
}
