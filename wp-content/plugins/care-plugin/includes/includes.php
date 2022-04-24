<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'widgets_init', 'care_plugin_register_wp_widgets' );

$care_plugin_includes = array(
	'includes/functions.php',
	'includes/shortcodes.php',
	'includes/theme-icons.php',
	'includes/assets.php',
	'includes/layout-blocks/init.php',
);

if ( defined( 'WPB_VC_VERSION' ) ) {
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/init.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/content-box/addon.php';
	// older version
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/events/events.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/logo/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/menu/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/post-list/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/pricing-plan/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/embellishment/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/theme-button/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/theme-icon/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/theme-map/addon.php';
	$care_plugin_includes[] = 'includes/wpbakery-page-builder/addons/video-popup/addon.php';
}

foreach ( $care_plugin_includes as $file ) {
	$filepath = plugin_dir_path( dirname( __FILE__ ) ) . $file;
	if ( ! file_exists( $filepath ) ) {
		trigger_error( sprintf( esc_html__( 'Error locating %s for inclusion', 'tyre-dealer-plugin' ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
unset( $file, $filepath );

function care_plugin_register_wp_widgets() {
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-widgets/latest-posts.php';
	require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-widgets/banner.php';
}
