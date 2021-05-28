<?php


namespace Inc\Classes;


class Scripts {

	public function __construct() {
		add_action('wp_enqueue_scripts', [$this, 'register_front_scripts']);
//		add_action('enqueue_scripts', [$this, 'register_admin_scripts']);
	}

	public function register_front_scripts() {
		wp_enqueue_style('slick-slider',FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/css/slick-slider/slick.css','',null,'');
		//wp_enqueue_style('slick-slider-theme',FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/css/slick-slider/slick-theme.css', [ 'slick-slider' ],null,'');
		wp_enqueue_style('slick-slider',FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/css/style.css','',null,'');

		wp_enqueue_script('jQuery', FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/js/jquery/jquery.js', '', null,true);
		wp_enqueue_script('slick-slider-script', FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/js/slick-slider/slick.min.js', [ 'jQuery' ], null,true);
		wp_enqueue_script('plugin-integration-flickr-script', FLICKR_PLUGIN_SCRIPTS_DIR_URL.'assets/js/main.js', [ 'jQuery', 'slick-slider-script' ], null,true);
	}
}