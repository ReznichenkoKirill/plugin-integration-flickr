<?php


namespace Plugin_Integration_flickr\Classes;


class Flickr {
	private $api_key;
	private $gallery_id;
	private const FLICKR_API_URL = "https://api.flickr.com/services/rest";
	private const DAY_IN_SECONDS = 86400;

	public function __construct() {
		add_shortcode( 'shortcode_flickr_print_gallery', [ $this, 'get_photos' ] );

		$this->api_key = get_option( 'flickr_setting_key' );;
		$this->gallery_id = get_option( 'flickr_setting_gallery_id' );
	}

	private function get_encode_params() {
		$params = [
			'api_key'        => $this->api_key,
			'method'         => 'flickr.galleries.getPhotos',
			'gallery_id'     => $this->gallery_id,
			'extras'         => 'url_l,url_sq',
			'format'         => 'json',
			'nojsoncallback' => 1,
		];

		$encode_params = [];

		foreach ( $params as $param => $value ) {
			$encode_params[] = urlencode( $param ) . '=' . urlencode( $value );
		}

		return $encode_params;
	}

	private function get_result_api() {
		$params  = $this->get_encode_params();
		$params  = implode( '&', $params );
		$old_url = get_option( 'flickr_API_URL' );
		$url     = $this->check_url( self::FLICKR_API_URL . "/?$params", $old_url ); // need save to data for check

		if ( ! get_transient( 'flickr_api_gallery_result' ) || ( $url !== $old_url ) ) {
			$response = file_get_contents( $url );
			$response = json_decode( $response, 1 );
			set_transient( 'flickr_api_gallery_result', $response, self::DAY_IN_SECONDS );
		} else {
			$response = get_transient( 'flickr_api_gallery_result' );
		}

		return $response;
	}

	private function check_url( $url, $old_url ) {
		if ( empty( $old_url ) ) {
			add_option( 'flickr_API_URL', $url );

			return get_option( 'flickr_API_URL' );
		} else {
			if ( $url === $old_url ) {
				return $old_url;
			} else {
				update_option( 'flickr_API_URL', $url );

				return get_option( 'flickr_API_URL' );
			}
		}
	}

	public function get_photos() {
		delete_transient( 'flickr_api_gallery_result' );
		$api_key    = get_option( 'flickr_setting_key' );
		$gallery_id = get_option( 'flickr_setting_gallery_id' );

		$width  = get_option( 'flickr_wrap_setting_width' );
		$height = get_option( 'flickr_wrap_setting_height' );

		if ( ! empty( $api_key ) && ! empty( $gallery_id ) ) {
			$result = $this->get_result_api();

			$photos = $result['photos']['photo'];
			?>
            <div class="container px-5">
                <div class="flickr-wrap mx-auto <?php echo( ! empty( $width ) ? 'w-' . $width : 'w-100' ) ?>">
                    <div class="container-slick-slider single-slide">
						<?php foreach ( $photos as $photo ) : ?>
							<?php if ( ! empty( $photo['url_l'] ) ) : ?>
                                <div class="item"
                                     style="height: <?php echo( ! empty( $height ) ? $height . 'px' : '400px' ) ?>!important;">
                                    <img src="<?php echo $photo['url_l'] ?>" alt="<?php echo $photo['title'] ?>">
                                </div>
							<?php endif; ?>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}