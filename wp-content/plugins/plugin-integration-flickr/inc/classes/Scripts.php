<?php


namespace Plugin_Integration_flickr\Classes;


class Scripts {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_front_scripts' ] );
//		add_action('enqueue_scripts', [$this, 'register_admin_scripts']);
	}

	public function register_front_scripts() {
		wp_enqueue_style( 'slick-slider', FLICKR_PLUGIN_SCRIPTS_DIR_URL . 'assets/css/slick-slider/slick.css', '', null,
			'' );
		wp_enqueue_style( 'integration-flickr-styles', FLICKR_PLUGIN_SCRIPTS_DIR_URL . 'assets/css/style.css', '', null,
			'' );

		wp_enqueue_script( 'slick-slider-script', FLICKR_PLUGIN_SCRIPTS_DIR_URL . 'assets/js/slick-slider/slick.min.js',
			'jquery-core-js', null, true );
		wp_enqueue_script( 'plugin-integration-flickr-script', FLICKR_PLUGIN_SCRIPTS_DIR_URL . 'assets/js/main.js',
			'slick-slider-script', null, true );
	}
}