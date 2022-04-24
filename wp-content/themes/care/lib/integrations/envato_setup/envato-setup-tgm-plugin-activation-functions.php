<?php
/**
 * Taken from TGM Activation
 */
function care_setup_wizard_get_plugins() {
	
	$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	$plugins  = array(
		'all'      => array(), // Meaning: all plugins which still have open actions.
		'install'  => array(),
		'update'   => array(),
		'activate' => array(),
	);

	foreach ( $instance->plugins as $slug => $plugin ) {
		if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
			// No need to display plugins if they are installed, up-to-date and active.
			continue;
		} else {
			$plugins['all'][ $slug ] = $plugin;

			if ( ! $instance->is_plugin_installed( $slug ) ) {
				$plugins['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $instance->does_plugin_have_update( $slug ) ) {
					$plugins['update'][ $slug ] = $plugin;
				}

				if ( $instance->can_plugin_activate( $slug ) ) {
					$plugins['activate'][ $slug ] = $plugin;
				}
			}
		}
	}

	return $plugins;
}