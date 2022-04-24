<?php
add_action( 'after_setup_theme', 'care_setup' );

if ( ! function_exists( 'care_setup' ) ) {

	function care_setup() {

		add_filter( 'care_alt_buttons', 'care_add_to_alt_button_list' );

		load_theme_textdomain( 'care', get_template_directory() . '/languages' );

		care_register_nav_menus();

		set_post_thumbnail_size( 150, 150, false );

		care_add_image_sizes();

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
			'chat'
		) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		
	}
}

function care_add_to_alt_button_list( $alt_button_arr ) {
	$alt_button_arr[] = '.yith-wcwl-add-button a';
	return $alt_button_arr;
}
