<?php
/**
 * Plugin Name: Care Plugin
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Care theme helper plugin
 * Version:     2.7.0
 * Author:      Aislin Themes
 * Author URI:  http://themeforest.net/user/Aislin/portfolio
 * License:     GPLv2+
 * Text Domain: care-plugin
 * Domain Path: /languages
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CARE_PLUGIN_NAME', 'Care' );
define( 'CARE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CARE_PLUGIN_PATH', dirname( __FILE__ ) . '/' );

register_activation_hook( __FILE__, 'care_plugin_activate' );
register_deactivation_hook( __FILE__, 'care_plugin_deactivate' );

add_action( 'plugins_loaded', 'care_plugin_init' );

function care_plugin_init() {
	care_plugin_load_textdomain();

	require_once CARE_PLUGIN_PATH . 'includes/includes.php';

	add_option( 'tribe_events_calendar_options', array(
		'tribeEventsTemplate' => 'template-fullwidth.php',
	) );
}

function care_plugin_activate() {
	care_plugin_init();
	flush_rewrite_rules();
}

function care_plugin_deactivate() {

}

function care_plugin_load_textdomain() {
	load_plugin_textdomain( 'care-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
