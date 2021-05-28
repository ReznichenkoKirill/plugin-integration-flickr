<?php
/**
 * Plugin Name: My Test Plugin flickr
 * Description: Plugin for integration with flickr service.
 * Version: 1.0
 * Author: Reznichenko Kirill
 */

defined( 'ABSPATH' ) || wp_die( 'Go away!' );
define('FLICKR_PLUGIN_SCRIPTS_DIR_URL', plugin_dir_url(__FILE__));

include_once  'inc/classes/Scripts.php';
include_once 'inc/classes/Admin_menu.php';
include_once 'inc/classes/Flickr.php';
use Inc\Classes\Scripts;
use Inc\Classes\Admin_menu;
use Inc\Classes\Flickr;



register_activation_hook( __FILE__, 'my_plugin_activation_hook' );
function my_plugin_activation_hook() {
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'my_plugin_deactivation_hook' );
function my_plugin_deactivation_hook() {
	flush_rewrite_rules();
}

register_uninstall_hook( __FILE__, 'my_plugin_uninstall_hook' );
function my_plugin_uninstall_hook() {
	//TODO
}


add_action('wp_enqueue_scripts', 'my_plugin_add_styles');
function my_plugin_add_styles() {
	wp_enqueue_style('my_plugin_styles',plugin_dir_url( __FILE__ ).'assets/css/style.css','','0.1');
}

/**
 * Activate Classes
 */
new Scripts();
new Admin_menu();
new Flickr();
