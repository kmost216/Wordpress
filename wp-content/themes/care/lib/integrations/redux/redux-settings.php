<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

$care_option_name = CARE_THEME_OPTION_NAME;

add_action( 'init', 'care_redux_remove_demo_mode_link' );
add_action( 'admin_notices', 'care_admin_notice_error' );
add_action( 'admin_init', 'care_add_default_redux_settings' );

add_filter( 'redux/options/care_options/defaults', 'care_redux_filter_default_options' );
add_filter( 'redux/options/care_options/reset', 'care_redux_reset_default_logo' );

require_once get_template_directory() . '/lib/integrations/redux/compiler.php';

function care_admin_notice_error() {

	$current_screen = get_current_screen();
	if ( $current_screen->id != 'toplevel_page__options' ) {
		return;
	}

	global $wp_filesystem;
    if ( $wp_filesystem || WP_Filesystem() ) {
        return;
    }
    
	$class = 'notice notice-error';
    $message = esc_html__('Theme has no direct access to the file system. Therefore, custom css file from Theme Options cannot be generated. Please try to insert the following code at the bottom of wp-config.php: define( "FS_METHOD", "direct" );', 'care' );
    
	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message ); 
}

function care_redux_remove_demo_mode_link() {
	if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
		remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), '_admin_notices' ) );
	}
}

function care_redux_reset_default_logo() {
	set_theme_mod( 'custom_logo', '' );
}

function care_add_default_redux_settings() {
	$redux_options = care_get_default_redux_settings();
	if ( $redux_options ) {
		add_option( CARE_THEME_OPTION_NAME, $redux_options );
		add_option( CARE_THEME_OPTION_NAME . '-transients', array( 'run_compiler' => 1 ) );
	}
}

function care_redux_filter_default_options( $default_options ) {
	$redux_options = care_get_default_redux_settings();
	if ( $redux_options ) {
		return $redux_options;
	}
	return $default_options;
}

function care_get_default_redux_settings() {
	$redux_options = false;
	$file = apply_filters( 'care_filter_redux_default_settings_path', get_template_directory() . '/lib/integrations/envato_setup/content/style1/redux.json' );

	if ( file_exists( $file ) ) {

		global $wp_filesystem;
	    if ( ! $wp_filesystem ) {
	    	require_once ( ABSPATH . '/wp-admin/includes/file.php' );
	        if ( ! WP_Filesystem() ) {
	        	return;
	        }
	    }

		$settings = json_decode( $wp_filesystem->get_contents( $file ), true );
		if ( is_array( $settings ) ) {
			$settings['logo'] = array( 'url' => '' );
			$settings['logo-sticky'] = array( 'url' => '' );
			$settings['respmenu-logo'] = array( 'url' => '' );
			$redux_options = apply_filters( 'care_filter_default_redux_settings', $settings );
		}
	}

	return $redux_options;
}


$theme = wp_get_theme();

$care_redux_args = array(
	'opt_name'             => $care_option_name,
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => $theme->get( 'Version' ),
	'menu_type'            => 'menu',
	'allow_sub_menu'       => false,
	'menu_title'           => esc_html__( 'Theme Options', 'care' ),
	'page_title'           => esc_html__( 'Theme Options', 'care' ),
	'google_api_key'       => 'AIzaSyBETK1Pd_dt2PYIGteFgKS25rp6MmQFErw',
	'google_update_weekly' => false,
	'async_typography'     => false,
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-portfolio',
	'admin_bar_priority'   => 50,
	'dev_mode'             => false,
	'customizer'           => true,
	'page_parent'          => 'themes.php',
	'page_permissions'     => 'manage_options',
	'page_slug'            => '_options',
	'save_defaults'        => false,
	'default_show'         => false,
	'show_import_export'   => true,
	'output'               => true,
	'output_tag'           => true,
);

if ( isset( $_GET['debug'] ) ) {
	$care_redux_args['ajax_save'] = false;
}

Redux::setArgs( $care_option_name, $care_redux_args );