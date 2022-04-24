<?php
add_action( 'wp_enqueue_scripts', 'care_scripts', 100 );
add_action( 'wp_enqueue_scripts', 'care_add_compiled_style', 999 );

function care_scripts() {
	care_enqueue_third_party_styles();
	wp_enqueue_style( 'care-theme-icons', get_template_directory_uri() . '/assets/css/theme-icons.css', false );
	wp_enqueue_style( 'care-style', get_stylesheet_uri(), false );

	wp_add_inline_style( 'care-style', care_responsive_menu_scripts() );

	if ( function_exists( 'is_rtl' ) && is_rtl() ) {
		wp_enqueue_style( 'care_rtl', get_template_directory_uri() . '/assets/css/rtl.css', false );
	}

	if ( is_single() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	care_enqueue_third_party_scripts();
	wp_enqueue_script( 'care-scripts', get_template_directory_uri() . '/assets/js/wheels-main.min.js', array( 'jquery' ), null, true );
	wp_localize_script( 'care-scripts', 'wheels', care_set_js_global_var() );
}

if ( ! function_exists( 'care_add_compiled_style' ) ) {

	function care_add_compiled_style() {
		$opt_name   = CARE_THEME_OPTION_NAME;
		$upload_dir = wp_upload_dir();

		if ( class_exists( 'Redux' ) && file_exists( $upload_dir['basedir'] . '/' . $opt_name . '_style.css' ) ) {
			$upload_url = $upload_dir['baseurl'];
			if ( strpos( $upload_url, 'https' ) !== false ) {
				$upload_url = str_replace( 'https:', '', $upload_url );
			} else {
				$upload_url = str_replace( 'http:', '', $upload_url );
			}
			wp_enqueue_style( "{$opt_name}_style", "{$upload_url}/{$opt_name}_style.css", false );
		} else {
			care_enqueue_default_fonts();
		}

		wp_add_inline_style( $opt_name . '_style', care_custom_css() );

		if ( function_exists( 'care_get_layout_blocks_css' ) ) {
			wp_add_inline_style( $opt_name . '_style', care_get_layout_blocks_css() );
		}
		if ( function_exists( 'care_get_vc_default_post_css' ) ) {
			wp_add_inline_style( $opt_name . '_style', care_get_vc_default_post_css() );
		}
	}
}

function care_set_js_global_var() {
	return array(
		'siteName' => get_bloginfo( 'name', 'display' ),
		'data'     => array(
			'useScrollToTop'                    => filter_var( care_get_option( 'use-scroll-to-top', false ), FILTER_VALIDATE_BOOLEAN ),
			'useStickyMenu'                     => (bool) care_is_sticky_menu_enabled(),
			'scrollToTopText'                   => esc_html( care_get_option( 'scroll-to-top-text', '' ) ),
			'isAdminBarShowing'                 => is_admin_bar_showing() ? true : false,
			'initialWaypointScrollCompensation' => care_get_option( 'main-menu-initial-waypoint-compensation', 120 ),
			'preloaderSpinner'                  => (int) care_get_option( 'preloader', 0 ),
			'preloaderBgColor'                  => care_get_option( 'preloader-bg-color', '#304ffe' ),
		)
	);
}
