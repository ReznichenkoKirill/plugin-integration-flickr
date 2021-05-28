<?php
/**
 * Plugin Name: The flickr gallery
 * Description: Plugin for integration with flickr service.
 * Version: 1.0
 * Author: Reznichenko Kirill
 */

defined( 'ABSPATH' ) || wp_die( 'Go away!' );
define( 'FLICKR_PLUGIN_SCRIPTS_DIR_URL', plugin_dir_url( __FILE__ ) );

include_once 'inc/classes/Scripts.php';
include_once 'inc/classes/Admin_menu.php';
include_once 'inc/classes/Flickr.php';

use Plugin_Integration_flickr\Classes\Scripts;
use Plugin_Integration_flickr\Classes\Admin_menu;
use Plugin_Integration_flickr\Classes\Flickr;


register_activation_hook( __FILE__, 'integration_flickr_activation_hook' );
function integration_flickr_activation_hook() {
	flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'integration_flickr_deactivation_hook' );
function integration_flickr_deactivation_hook() {
	flush_rewrite_rules();
}

register_uninstall_hook( __FILE__, 'integration_flickr_uninstall_hook' );
function integration_flickr_uninstall_hook() {
	delete_transient( 'flickr_api_gallery_result' );
}

/**
 * Activate Classes
 */
new Scripts();
new Admin_menu();
new Flickr();
