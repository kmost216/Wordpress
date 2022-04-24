<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

$lsPriority = (int) get_option('ls_scripts_priority', 3);
$lsPriority = ! empty($lsPriority) ? $lsPriority : 3;


if( get_option('ls_gutenberg_block', true ) ) {
	add_action('enqueue_block_editor_assets', 'ls_enqueue_slider_library');
	add_action('init', 'layerslider_register_gutenberg_block');
}

add_action('wp_enqueue_scripts', 'layerslider_enqueue_content_res', $lsPriority);
add_action('wp_footer', 'layerslider_footer_scripts', ($lsPriority+1));

add_action('admin_enqueue_scripts', 'layerslider_enqueue_admin_res', $lsPriority);
add_action('admin_enqueue_scripts', 'ls_load_google_fonts', $lsPriority);
add_action('wp_enqueue_scripts', 'ls_load_google_fonts', ($lsPriority+1));
add_action('wp_head', 'ls_meta_generator', 9);

// Fix for CloudFlare's Rocket Loader
add_filter('script_loader_tag', 'layerslider_script_attributes', 10, 3);
function layerslider_script_attributes( $tag, $handle, $src ) {


	if(
		$handle === 'layerslider' ||
		$handle === 'layerslider-utils' ||
		$handle === 'layerslider-transitions' ||
		$handle === 'layerslider-origami' ||
		$handle === 'layerslider-popup' ||
		$handle === 'ls-user-transitions' ||
		$handle === 'layerslider-timeline'
	) {

		if( get_option('ls_rocketscript_ignore', false ) ) {
			$tag =  str_replace( "type='text/javascript' src=", 'data-cfasync="false" src=', $tag );
		}

		if( get_option('ls_defer_scripts', false ) ) {
			$tag = str_replace( '></script>', ' defer></script>', $tag);
		}
	}


	return $tag;
}


// No conflict mode
// Removes extraneous scripts and styles from 3rd parties on LayerSlider admin pages
// to reduce the chance of incompatibility and conflicts with plugins and themes.
if( is_admin() && ! empty( $_GET['page'] ) && strpos( $_GET['page'], 'layerslider' ) !== false ) {

	if( get_option('ls_admin_no_conflict_mode', false ) ) {
		add_action('wp_print_scripts', 'ls_exclude_3rd_party_scripts', 1 );
		add_action('admin_print_footer_scripts', 'ls_exclude_3rd_party_scripts', 1 );
		add_action('wp_print_styles', 'ls_exclude_3rd_party_styles', 1 );
		add_action('admin_print_styles', 'ls_exclude_3rd_party_styles', 1 );
		add_action('admin_print_footer_scripts', 'ls_exclude_3rd_party_styles', 1 );
		add_action('admin_footer', 'ls_exclude_3rd_party_scripts', 1 );
	}
}


function ls_exclude_3rd_party_styles() {

	global $wp_styles;

	foreach( $wp_styles->queue as $key => $handle ) {

		if( ! empty( $wp_styles->registered[ $handle ] ) ) {
			if( ls_is_3rd_party_asset( $wp_styles->registered[ $handle ]->src ) ) {
				wp_deregister_style( $handle );
			}
		}
	}

	foreach( $wp_styles->registered as $handle => $style ) {

		if( ! empty( $wp_styles->registered[ $handle ] ) ) {
			if( ls_is_3rd_party_asset( $wp_styles->registered[ $handle ]->src ) ) {
				wp_deregister_style( $handle );
			}
		}
	}
}


function ls_exclude_3rd_party_scripts() {

	global $wp_scripts;

	foreach( $wp_scripts->queue as $key => $handle ) {

		if( ! empty( $wp_scripts->registered[ $handle ] ) ) {
			if( ls_is_3rd_party_asset( $wp_scripts->registered[ $handle ]->src ) ) {
				wp_deregister_script( $handle );
			}
		}
	}

	foreach( $wp_scripts->registered as $handle => $script ) {

		if( ! empty( $wp_scripts->registered[ $handle ] ) ) {
			if( ls_is_3rd_party_asset( $wp_scripts->registered[ $handle ]->src ) ) {
				wp_deregister_script( $handle );
			}
		}
	}
}


function ls_is_3rd_party_asset( $url ) {

	if( stripos( $url, '/plugins/' ) !== false && stripos( $url, 'layerslider' ) === false ) {
		return true;
	}

	if( stripos( $url, '/themes/' ) !== false && stripos( $url, 'layerslider' ) === false ) {
		return true;
	}

	return false;
}


function ls_enqueue_slider_library() {

	// Dependencies: LS Utils & Kreatura Modal Window
	wp_enqueue_script('layerslider-utils', LS_ROOT_URL.'/static/layerslider/js/layerslider.utils.js', ['jquery'], LS_PLUGIN_VERSION );
	wp_enqueue_style('kreatura-modal-window', LS_ROOT_URL.'/static/kmw/css/kmw.css', false, LS_PLUGIN_VERSION );
	wp_enqueue_style('kreatura-modal-window-utils', LS_ROOT_URL.'/static/kmw/css/kmw-utils.css', false, LS_PLUGIN_VERSION );
	wp_enqueue_script('kreatura-modal-window', LS_ROOT_URL.'/static/kmw/js/kmw.js', ['jquery'], LS_PLUGIN_VERSION );

	// Slider Library files
	wp_enqueue_style('layerslider-slider-library', LS_ROOT_URL.'/static/admin/css/project-library.css', false, LS_PLUGIN_VERSION );
	wp_enqueue_script('layerslider-slider-library', LS_ROOT_URL.'/static/admin/js/project-library.js', ['jquery'], LS_PLUGIN_VERSION );

	// Slider Library Localization
	include LS_ROOT_PATH.'/wp/slider_library_l10n.php';
	wp_localize_script('layerslider-slider-library', 'LS_SLibrary_l10n', $l10n_ls_slider_library);
}


function layerslider_register_gutenberg_block() {

	if( function_exists('register_block_type') ) {

		include LS_ROOT_PATH.'/wp/gutenberg_l10n.php';
		wp_register_script('layerslider-gutenberg', LS_ROOT_URL.'/static/admin/js/gutenberg.js', [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ], LS_PLUGIN_VERSION );
		wp_localize_script('layerslider-gutenberg', 'LS_GB_l10n', $l10n_ls_gutenberg);

		wp_register_style('layerslider-gutenberg', LS_ROOT_URL.'/static/admin/css/gutenberg.css', false, LS_PLUGIN_VERSION );


		register_block_type('kreatura/layerslider', [
			'editor_style' => 'layerslider-gutenberg',
			'editor_script' => 'layerslider-gutenberg',
			'render_callback' => 'layerslider_render_gutenberg_block'
		]);
	}
}


function layerslider_render_gutenberg_block( $attributes )  {

	if( ! empty( $attributes['id'] ) ) {
		return LS_Shortcode::handleShortcode( $attributes );
	}
}


function layerslider_enqueue_content_res() {

	// Include in the footer?
	$condsc = get_option( 'ls_conditional_script_loading', false );
	$condsc = apply_filters( 'ls_conditional_script_loading', $condsc );

	$always = get_option( 'ls_load_all_js_files', false );
	$always = apply_filters( 'ls_load_all_js_files', $always );

	$footer = get_option( 'ls_include_at_footer', false );
	$footer = apply_filters( 'ls_include_at_footer', $footer );

	$footer = $condsc ? true : $footer;

	// Use Gogole CDN version of jQuery
	if(get_option('ls_use_custom_jquery', false)) {
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', [], '1.8.3');
	}

	// Enqueue front-end assets
	if( current_user_can(get_option('layerslider_custom_capability', 'manage_options')) ) {
		wp_enqueue_style('layerslider-front', LS_ROOT_URL.'/static/public/front.css', false, LS_PLUGIN_VERSION );
	}

	// Register LayerSlider resources
	wp_register_script('layerslider-utils', LS_ROOT_URL.'/static/layerslider/js/layerslider.utils.js', ['jquery'], LS_PLUGIN_VERSION, $footer );
	wp_register_script('layerslider', LS_ROOT_URL.'/static/layerslider/js/layerslider.kreaturamedia.jquery.js', ['jquery'], LS_PLUGIN_VERSION, $footer );
	wp_register_script('layerslider-transitions', LS_ROOT_URL.'/static/layerslider/js/layerslider.transitions.js', false, LS_PLUGIN_VERSION, $footer );
	wp_enqueue_style('layerslider', LS_ROOT_URL.'/static/layerslider/css/layerslider.css', false, LS_PLUGIN_VERSION );

	// LayerSlider Origami plugin
	wp_register_script('layerslider-origami', LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.js', ['jquery'], LS_PLUGIN_VERSION, $footer );
	wp_register_style('layerslider-origami', LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.css', false, LS_PLUGIN_VERSION );

	// LayerSlider Popup plugin
	wp_register_script('layerslider-popup', LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.js', ['jquery'], LS_PLUGIN_VERSION, $footer );
	wp_register_style('layerslider-popup', LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.css', false, LS_PLUGIN_VERSION );

	// 3rd-party: Font Awesome 4
	wp_register_style('ls-font-awesome-4', LS_ROOT_URL.'/static/font-awesome-4/css/font-awesome.min.css', false, '4.7.0' );

	// Build LS_Meta object
	$LS_Meta = [];

	if( ! get_option('ls_suppress_debug_info', false ) ) {
		$LS_Meta['v'] = LS_PLUGIN_VERSION;
	}

	if( get_option('ls_gsap_sandboxing', true ) ) {
		$LS_Meta['fixGSAP'] = true;
	}

	// Print LS_Meta object
	if( ! empty( $LS_Meta ) ) {
		wp_localize_script('layerslider-utils', 'LS_Meta', $LS_Meta);
	}

	// User resources
	$uploads = wp_upload_dir();
	$uploads['baseurl'] = set_url_scheme( $uploads['baseurl'] );

	if(file_exists($uploads['basedir'].'/layerslider.custom.transitions.js')) {
		wp_register_script('ls-user-transitions', $uploads['baseurl'].'/layerslider.custom.transitions.js', false, LS_PLUGIN_VERSION, $footer );
	}

	if(file_exists($uploads['basedir'].'/layerslider.custom.css')) {
		wp_enqueue_style('ls-user', $uploads['baseurl'].'/layerslider.custom.css', false, LS_PLUGIN_VERSION );
	}

	if( ! $footer || $always ) {
		wp_enqueue_script('layerslider-utils');
		wp_enqueue_script('layerslider');
		wp_enqueue_script('layerslider-transitions');
		wp_enqueue_script('ls-user-transitions');
	}

	// If the "Always load all JS files" option is enabled
	// load all LayerSlider plugin files as well.
	if( $always ) {
		wp_enqueue_style( 'layerslider-origami' );
		wp_enqueue_script( 'layerslider-origami' );

		wp_enqueue_style( 'layerslider-popup' );
		wp_enqueue_script( 'layerslider-popup' );
	}
}



function layerslider_footer_scripts() {

	$condsc = get_option( 'ls_conditional_script_loading', false );
	$condsc = apply_filters( 'ls_conditional_script_loading', $condsc );

	$always = get_option( 'ls_load_all_js_files', false );
	$always = apply_filters( 'ls_load_all_js_files', $always );

	if( ! $condsc || ! empty( $GLOBALS['lsSliderInit'] ) || $always ) {

		// Enqueue scripts
		wp_enqueue_script('layerslider-utils');
		wp_enqueue_script('layerslider');
		wp_enqueue_script('layerslider-transitions');

		if( wp_script_is('ls-user-transitions', 'registered') ) {
			wp_enqueue_script('ls-user-transitions');
		}
	}

	// Conditionally load LayerSlider plugins
	if( ! empty( $GLOBALS['lsLoadPlugins'] ) ) {

		// Filter out duplicates
		$GLOBALS['lsLoadPlugins'] = array_unique($GLOBALS['lsLoadPlugins']);

		// Load plugins
		foreach( $GLOBALS['lsLoadPlugins'] as $item ) {
			wp_enqueue_script('layerslider-'.$item);
			wp_enqueue_style('layerslider-'.$item);
		}
	}

	// If the "Always load all JS files" option is enabled
	// load all LayerSlider plugin files as well.
	if( $always ) {
		wp_enqueue_style( 'layerslider-origami' );
		wp_enqueue_script( 'layerslider-origami' );

		wp_enqueue_style( 'layerslider-popup' );
		wp_enqueue_script( 'layerslider-popup' );
	}


	// Always load Font Awesome in Elementor Preview:
	// Elementor loads modules individually and we can't
	// gather information about the fonts being used in
	// embedded sliders.
	if( ! empty( $_GET['elementor-preview'] ) ) {
		$GLOBALS['lsLoadIcons'] = ['font-awesome-4'];
	}


	// Load used fonts
	if( ! empty( $GLOBALS['lsLoadIcons'] ) ) {

		// Filter out duplicates
		$GLOBALS['lsLoadIcons'] = array_unique($GLOBALS['lsLoadIcons']);

		// Load fonts
		foreach( $GLOBALS['lsLoadIcons'] as $item ) {
			wp_enqueue_style('ls-'.$item);
		}
	}

	if( ! empty( $GLOBALS['lsSliderInit'] ) ) {
		wp_add_inline_script( 'layerslider', implode('', $GLOBALS['lsSliderInit']) );
	}

}



function layerslider_enqueue_admin_res() {

	// Load global LayerSlider CSS
	wp_enqueue_style('ls-global', LS_ROOT_URL.'/static/admin/css/global.css', false, LS_PLUGIN_VERSION );

	// Load global LayerSlider JS
	include LS_ROOT_PATH.'/wp/tinymce_l10n.php';
	wp_enqueue_script('ls-global', LS_ROOT_URL.'/static/admin/js/ls-global.js', false, LS_PLUGIN_VERSION );
	wp_localize_script('ls-global', 'LS_MCE_l10n', $l10n_ls_mce);


	// Use Google CDN version of jQuery
	if( get_option( 'ls_use_custom_jquery', false ) ) {
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', [], '1.8.3');
	}

	// Load LayerSlider-only resources
	$screen = get_current_screen();

	if( strpos( $screen->base, 'layerslider' ) !== false ) {

		// New Media Library
		if( function_exists( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}

		// Load some bundled WP resources
		wp_enqueue_script('wp-pointer');
		wp_enqueue_style('wp-pointer');
		wp_enqueue_script('jquery-ui-droppable');

		// Global scripts & stylesheets
		wp_enqueue_script('layerslider-utils', LS_ROOT_URL.'/static/layerslider/js/layerslider.utils.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_register_script('popper', LS_ROOT_URL.'/static/popper/popper.min.js', false, '2.6.0' );
		wp_register_script('kreaturamedia-ui', LS_ROOT_URL.'/static/admin/js/km-ui.js', ['jquery', 'popper'], LS_PLUGIN_VERSION );
		wp_enqueue_script('kreatura-modal-window', LS_ROOT_URL.'/static/kmw/js/kmw.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('km-tabs', LS_ROOT_URL.'/static/kmw/js/km-tabs.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('ls-common', LS_ROOT_URL.'/static/admin/js/ls-common.js', ['jquery', 'updates'], LS_PLUGIN_VERSION, true );

		wp_enqueue_style('kreatura-modal-window', LS_ROOT_URL.'/static/kmw/css/kmw.css', false, LS_PLUGIN_VERSION );
		wp_enqueue_style('kreatura-modal-window-utils', LS_ROOT_URL.'/static/kmw/css/kmw-utils.css', false, LS_PLUGIN_VERSION );
		wp_enqueue_style('km-tabs', LS_ROOT_URL.'/static/kmw/css/km-tabs.css', false, LS_PLUGIN_VERSION );
		wp_enqueue_style('kreatura-tabs', LS_ROOT_URL.'/static/admin/css/km-tabs.css', false, LS_PLUGIN_VERSION );

		// Check if Google Fonts is enabled as per the new privacy
		// settings introduced in version 6.7.6
		if( get_option('layerslider-google-fonts-enabled', true ) ) {
			wp_enqueue_style('ls-admin-google-fonts', LS_ROOT_URL.'/static/admin/css/google-fonts.css', false, LS_PLUGIN_VERSION );
		}

		// 3rd-party: Font Awesome 4
		wp_enqueue_style('ls-font-awesome-4', LS_ROOT_URL.'/static/font-awesome-4/css/font-awesome.min.css', false, LS_PLUGIN_VERSION );

		// 3rd-party: CodeMirror
		wp_enqueue_style('codemirror', LS_ROOT_URL.'/static/codemirror/lib/codemirror.css', false, LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror', LS_ROOT_URL.'/static/codemirror/lib/codemirror.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_style('codemirror-solarized', LS_ROOT_URL.'/static/codemirror/theme/solarized.mod.css', false, LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-syntax-css', LS_ROOT_URL.'/static/codemirror/mode/css/css.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-syntax-javascript', LS_ROOT_URL.'/static/codemirror/mode/javascript/javascript.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-foldcode', LS_ROOT_URL.'/static/codemirror/addon/fold/foldcode.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-foldgutter', LS_ROOT_URL.'/static/codemirror/addon/fold/foldgutter.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-brace-fold', LS_ROOT_URL.'/static/codemirror/addon/fold/brace-fold.js', ['jquery'], LS_PLUGIN_VERSION );
		wp_enqueue_script('codemirror-active-line', LS_ROOT_URL.'/static/codemirror/addon/selection/active-line.js', ['jquery'], LS_PLUGIN_VERSION );

		// Localize admin scripts
		include LS_ROOT_PATH.'/wp/scripts_l10n.php';
		wp_localize_script('ls-common', 'LS_l10n', $l10n_ls);
		wp_localize_script('ls-common', 'LS_ENV', [
			'base' => LS_PLUGIN_BASE,
			'slug' => LS_PLUGIN_SLUG
		]);

		$section = ! empty( $_GET['section'] ) ? $_GET['section'] : false;


		// LS Admin Pages
		if( empty( $_GET['id'] ) ) {
			wp_enqueue_script('kreaturamedia-ui');
			wp_enqueue_style('ls-admin', LS_ROOT_URL.'/static/admin/css/admin.css', false, LS_PLUGIN_VERSION );

		// LS Project Editor
		} else {
			wp_deregister_style('wp-admin');
			wp_dequeue_style('ls-global');
		}


		//
		// LOAD PAGE-SPECIFIC FILES
		//

		if( $section ) {

			switch( $section ) {

				case 'about':
					ls_require_slider_assets();
					wp_enqueue_script('ls-about-page', LS_ROOT_URL.'/static/admin/js/ls-about.js', ['jquery'], LS_PLUGIN_VERSION, true );
					break;


				case 'transition-builder':
					ls_require_slider_assets();
					wp_enqueue_script('layerslider-tr-builder', LS_ROOT_URL.'/static/admin/js/ls-transition-builder.js', ['jquery'], LS_PLUGIN_VERSION, true );
					break;
			}


		// Dashboard
		} elseif( empty( $_GET['action'] ) ) {

			wp_enqueue_script('ls-dashboard', LS_ROOT_URL.'/static/admin/js/ls-dashboard.js', ['jquery'], LS_PLUGIN_VERSION, true );
			wp_enqueue_script('layerslider', LS_ROOT_URL.'/static/layerslider/js/layerslider.kreaturamedia.jquery.js', ['jquery'], LS_PLUGIN_VERSION );
			wp_enqueue_style('layerslider', LS_ROOT_URL.'/static/layerslider/css/layerslider.css', false, LS_PLUGIN_VERSION );

			ls_enqueue_font_library();

		// Project Editor
		} else {
			ls_require_builder_assets();
			ls_enqueue_font_library();
		}
	}
}


function ls_enqueue_font_library() {

	wp_enqueue_script('ls-font-loader', LS_ROOT_URL.'/static/admin/js/webfontloader.js', ['jquery'], '1.6.28', true );

	wp_enqueue_style('ls-font-library', LS_ROOT_URL.'/static/admin/css/ls-font-library.css', false, LS_PLUGIN_VERSION );

	wp_enqueue_script('ls-font-library', LS_ROOT_URL.'/static/admin/js/ls-font-library-min.js', ['jquery'], LS_PLUGIN_VERSION, true );

	wp_localize_script('ls-font-library', 'LS_FontData', [
		'languages' => LS_RemoteData::get('languages', [], 'fonts'),
		'fonts' => LS_RemoteData::get('fonts', [], 'fonts')
	]);
}


function ls_require_slider_assets() {

	// LayerSlider includes for preview
	wp_enqueue_script('layerslider', LS_ROOT_URL.'/static/layerslider/js/layerslider.kreaturamedia.jquery.js', ['jquery'], LS_PLUGIN_VERSION );
	wp_enqueue_script('layerslider-transitions', LS_ROOT_URL.'/static/layerslider/js/layerslider.transitions.js', false, LS_PLUGIN_VERSION );
	wp_enqueue_style('layerslider', LS_ROOT_URL.'/static/layerslider/css/layerslider.css', false, LS_PLUGIN_VERSION );

	// LayerSlider Timeline plugin
	wp_enqueue_script('layerslider-timeline', LS_ROOT_URL.'/static/admin/js/layerslider.timeline-min.js', ['jquery'], LS_PLUGIN_VERSION );
	// wp_enqueue_style('layerslider-timeline', LS_ROOT_URL.'/static/timeline/layerslider.timeline.css', false, LS_PLUGIN_VERSION );

	// LayerSlider Origami plugin
	wp_enqueue_script('layerslider-origami', LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.js', ['jquery'], LS_PLUGIN_VERSION );
	wp_enqueue_style('layerslider-origami', LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.css', false, LS_PLUGIN_VERSION );

	// LayerSlider Popup plugin
	wp_enqueue_script('layerslider-popup', LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.js', ['jquery'], LS_PLUGIN_VERSION );
	wp_enqueue_style('layerslider-popup', LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.css', false, LS_PLUGIN_VERSION );
}


function ls_require_builder_assets() {

	// Load some bundled WP resources
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-selectable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('jquery-ui-slider');

	ls_require_slider_assets();

	wp_register_script('ls-project-editor', LS_ROOT_URL.'/static/admin/js/ls-project-editor-min.js', ['jquery', 'json2'], LS_PLUGIN_VERSION, true );

	wp_register_script('ls-project-editor-new', LS_ROOT_URL.'/static/admin/js/ls-project-editor-new-min.js', ['jquery', 'json2'], LS_PLUGIN_VERSION, true );
	wp_register_script('ls-ui-overrides', LS_ROOT_URL.'/static/admin/js/jquery-ui-overrides.js', ['jquery', 'json2'], LS_PLUGIN_VERSION, true );
	wp_register_script('ls-project-editor-search', LS_ROOT_URL.'/static/admin/js/ls-project-editor-search.js', ['jquery'], LS_PLUGIN_VERSION, true );
	wp_register_script('ls-project-editor-buttons', LS_ROOT_URL.'/static/admin/js/ls-button-presets-min.js', ['jquery'], LS_PLUGIN_VERSION, true );

	wp_register_style('ls-project-editor', LS_ROOT_URL.'/static/admin/css/editor.css', false, LS_PLUGIN_VERSION );



	wp_enqueue_script('ls-project-editor');
	wp_enqueue_script('ls-project-editor-new');
	wp_enqueue_script('ls-ui-overrides');
	wp_enqueue_script('ls-project-editor-search');
	wp_enqueue_script('ls-project-editor-buttons');
	wp_enqueue_style('ls-project-editor');

	// 3rd party: GSAP Morph SVG Plugin
	wp_enqueue_script('ls-gsap-morph-svg', LS_ROOT_URL.'/static/admin/js/MorphSVGPlugin.min.js', ['jquery'], LS_PLUGIN_VERSION, true );


	// 3rd-party: MiniColor
	wp_enqueue_script('minicolor', LS_ROOT_URL.'/static/minicolors/jquery.minicolors.min.js', ['jquery'], LS_PLUGIN_VERSION );
	wp_enqueue_style('minicolor', LS_ROOT_URL.'/static/minicolors/jquery.minicolors.css', false, LS_PLUGIN_VERSION );

	// 3rd-party: angle-input
	wp_enqueue_script('angle-input', LS_ROOT_URL.'/static/angle-input/angle-input.jquery.js', ['jquery'], '0.0.1', true );


	// 3rd-party: Air Datepicker
	wp_enqueue_style('air-datepicker', LS_ROOT_URL.'/static/air-datepicker/datepicker.min.css', false, '2.1.0' );
	wp_enqueue_script('air-datepicker', LS_ROOT_URL.'/static/air-datepicker/datepicker.min.js', ['jquery'], '2.1.0' );
	wp_enqueue_script('air-datepicker-en', LS_ROOT_URL.'/static/air-datepicker/i18n/datepicker.en.js', ['jquery'], '2.1.0' );

	// 3rd party: html2canvas
	wp_enqueue_script('html2canvas', LS_ROOT_URL.'/static/html2canvas/html2canvas.min.js', ['jquery'], '1.0.0rc7' );

	// 3rd party: iGuider
	wp_enqueue_style('iguider', LS_ROOT_URL.'/static/iguider/iGuider.css', false, '4.5' );
	wp_enqueue_script('iguider', LS_ROOT_URL.'/static/iguider/jquery.iGuider.js', ['jquery'], '4.5' );
	wp_enqueue_script('iguider-theme', LS_ROOT_URL.'/static/iguider/iGuider-theme-neon.js', ['jquery'], '4.5' );

	// User CSS
	$uploads = wp_upload_dir();
	$uploads['baseurl'] = set_url_scheme( $uploads['baseurl'] );

	if(file_exists($uploads['basedir'].'/layerslider.custom.transitions.js')) {
		wp_enqueue_script('ls-user-transitions', $uploads['baseurl'].'/layerslider.custom.transitions.js', false, LS_PLUGIN_VERSION );
	}

	// User transitions
	if(file_exists($uploads['basedir'].'/layerslider.custom.css')) {
		wp_enqueue_style('ls-user', $uploads['baseurl'].'/layerslider.custom.css', false, LS_PLUGIN_VERSION );
	}
}



function ls_load_google_fonts() {

	// Check if Google Fonts is enabled as per the new privacy
	// settings introduced in version 6.7.6
	if( ! get_option('layerslider-google-fonts-enabled', true ) ) {
		return;
	}

	// Get font list
	$fonts = get_option('ls-google-fonts', []);

	// Check fonts if any
	if(!empty($fonts) && is_array($fonts)) {
		$lsFonts = [];
		foreach($fonts as $item) {
			$fontParams = explode(':', $item['param']);
			$fontName 	= urldecode( $fontParams[0] );
			$GLOBALS['lsLoadedFonts'][] = $fontName;
			$lsFonts[] = urlencode( $fontName ).':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
		}

		if( ! empty( $lsFonts ) ) {
			$lsFonts = implode('%7C', $lsFonts);
			$query_args = [
				'family' => $lsFonts
			];

			wp_enqueue_style('ls-google-fonts',
				add_query_arg($query_args, "https://fonts.googleapis.com/css" ),
				[], null
			);
		}
	}
}

function ls_meta_generator() {

	if( get_option('ls_suppress_debug_info', false ) ) {
		return;
	}


	$str = '<meta name="generator" content="Powered by LayerSlider '.LS_PLUGIN_VERSION.' - Multi-Purpose, Responsive, Parallax, Mobile-Friendly Slider Plugin for WordPress." />' . NL;
	$str.= '<!-- LayerSlider updates and docs at: https://layerslider.com -->' . NL;

	echo apply_filters('ls_meta_generator', $str);
}
