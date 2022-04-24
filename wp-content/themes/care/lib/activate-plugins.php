<?php
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'care_register_required_plugins' );

function care_register_required_plugins() {

    $plugins = array(
        // Include a plugin pre-packaged with a theme
        array(
            'name'               => esc_html__( 'Care Plugin', 'care' ),
            'slug'               => 'care-plugin',
            'source'             => get_template_directory() . '/extensions/care-plugin.zip',
            'required'           => true,
            'version'            => '2.7.0',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => '',
        ),
        array(
            'name'               => esc_html__( 'WPBakery Page Builder', 'care' ),
            'slug'               => 'js_composer',
            'source'             => get_template_directory() . '/extensions/js_composer.zip',
            'required'           => true,
            'version'            => '6.8.0',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => '',
        ),
	    array(
            'name'               => 'Layer Slider',
            'slug'               => 'LayerSlider',
            'source'             => get_template_directory() . '/extensions/layersliderwp.zip',
            'required'           => true,
            'version'            => '7.0.7',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => '',
        ),
        array(
            'name'               => esc_html__( 'Smart Grid Gallery', 'care' ),
            'slug'               => 'smart-grid-gallery',
            'source'             => get_template_directory() . '/extensions/smart-grid-gallery.zip',
            'required'           => false,
            'version'            => '1.4.5',
            'force_activation'   => false,
            'force_deactivation' => false,
            'external_url'       => '',
        ),
        array(
            'name'     => esc_html__( 'Meta Box', 'care' ),
            'slug'     => 'meta-box',
            'required' => true,
        ),
        array(
            'name'     => esc_html__( 'Redux Framework', 'care' ),
            'slug'     => 'redux-framework',
            'required' => true,
        ),
        array(
            'name'     => esc_html__( 'The Events Calendar', 'care' ),
            'slug'     => 'the-events-calendar',
            'required' => false,
        ),
        array(
            'name'     => esc_html__( 'Contact Form 7', 'care' ),
            'slug'     => 'contact-form-7',
            'required' => false,
        ),
        array(
            'name'     => esc_html__( 'Breadcrumb Trail', 'care' ),
            'slug'     => 'breadcrumb-trail',
            'required' => false,
        ),
        array(
            'name'     => esc_html__( 'Optimize Image', 'care' ),
            'slug'     => 'optimize-images-resizing',
            'required' => false,
        ),
        array(
            'name'        => esc_html__( 'Envato Market', 'care' ),
            'slug'        => 'envato-market',
            'source'      => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
            'required'    => true,
            'recommended' => true,
        ),
    );

	// messages
	$messages = array(
		esc_html__( 'If you are not able to complete plugin installation process due to server issues please install the plugins manually. All required plugins are located in "extensions" folder in your main download from Themeforest.', 'care' ),
		sprintf( esc_html__( 'After you finish installing plugins go back to %s page to complete the installation.', 'care' ), '<a href="' . esc_url( admin_url( 'themes.php?page=theme_activation_options' ) ) . '" title="' . esc_html__( 'Theme Activation', 'care' ) . '">' . esc_html__( 'Theme Activation', 'care' ) . '</a>' ),
	);
	$final_message = '';
	foreach ( $messages as $message ) {
		$final_message .= sprintf( '<div class="updated fade"><p>%s</p></div>', $message );
	}


	/**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'           => 'care', // Text domain - likely want to be the same as your theme.
        'default_path'     => '', // Default absolute path to pre-packaged plugins
        'menu'             => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'      => 'themes.php',
        'has_notices'      => true, // Show admin notices or not
        'is_automatic'     => false, // Automatically activate plugins after installation or not
        'message'          => $final_message, // Message to output right before the plugins table

    );

    tgmpa( $plugins, $config );
}
