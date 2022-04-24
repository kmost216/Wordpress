<?php
/**
 * Care includes
 */
$care_includes = array(
	'lib/supplement.php',
	'lib/utils.php',
	'lib/entry-meta.php',
	'lib/integrations/layout-blocks.php',
	'lib/integrations/wp-bakery/functions.php',
	'lib/extras.php',
	'lib/css-classes.php',
	'lib/init.php',
	'lib/config.php',
	'lib/activate-plugins.php',
	'lib/titles.php',
	'lib/cleanup.php',
	'lib/comments.php',
	'lib/scripts.php',
	'lib/class-mobile-menu-walker.php',
	'lib/integrations/metaboxes.php',
	'lib/integrations/redux/redux-settings.php',
	'lib/integrations/redux/options.php', 
	'woocommerce/custom/init.php',
	'lib/integrations/envato_setup/envato_setup_init.php',
	'lib/integrations/envato_setup/envato_setup.php',
);
foreach ( $care_includes as $file ) {
	$filepath = get_template_directory() . '/' . $file;
	if ( ! file_exists( $filepath ) ) {
		trigger_error( sprintf( esc_html__( 'Error locating %s for inclusion', 'care' ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
unset( $file, $filepath );
