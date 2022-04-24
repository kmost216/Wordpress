<?php
add_action( 'widgets_init', 'care_widgets_init' );
add_filter( 'care_icon_class', 'care_filter_icon_class' );
add_filter( 'care_registered_layout_blocks', 'care_filter_registered_layout_blocks' );

function care_filter_registered_layout_blocks( $layout_blocks ) {
	$layout_blocks[] = 'top-bar-layout-block';

	return $layout_blocks;
}

function care_add_image_sizes() {
	add_image_size( 'wh-featured-image', 895, 430, true );
	add_image_size( 'wh-medium', 768, 600, true );
	add_image_size( 'wh-square', 768, 768, true );
}

function care_enqueue_third_party_styles() {
	wp_enqueue_style( 'groundwork-grid', get_template_directory_uri() . '/assets/css/groundwork-responsive.css', false );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', false );
	wp_enqueue_style( 'js_composer_front' );
}

function care_enqueue_third_party_scripts() {
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', array(), null, false );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/assets/js/plugins/fitvids.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/assets/js/plugins/superfish.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'hoverintent', get_template_directory_uri() . '/assets/js/plugins/hoverintent.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'scrollup', get_template_directory_uri() . '/assets/js/plugins/scrollup.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/assets/js/plugins/jquery.sticky.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'natural-width-height', get_template_directory_uri() . '/assets/js/plugins/natural-width-height.js', array( 'jquery' ), null, true );
}

function care_enqueue_default_fonts() {
	wp_enqueue_style( 'care-fonts', 'https://fonts.googleapis.com/css?family=Karla:400|Nunito:300,400,700', false );
	wp_enqueue_style( CARE_THEME_OPTION_NAME . '_style', get_template_directory_uri() . '/assets/css/wheels_options_style.css', false );
}

function care_filter_icon_class( $namespace ) {
	$map = array(
		'user'               => 'fa fa-user',
		'folder'             => 'fa fa-folder',
		'tag'                => 'fa fa-tag',
		'comments'           => 'fa fa-comment',
		'cart'               => 'fa fa-shopping-cart',
		'shopping_bag'       => 'theme-icon-shopping-cart-black-shape',
		'calendar'           => 'fa fa-calendar',
		'post_list_calendar' => 'icon-Calendar-New',
		'bars'               => 'fa fa-bars',
		'close'              => 'fa fa-close',
		'previous_post_link' => 'icon-left-arrow',
		'next_post_link'     => 'icon-right-arrow',
		'facebook'           => 'fa fa-facebook',
		'twitter'            => 'fa fa-twitter',
		'google-plus'        => 'fa fa-google-plus',
		'pinterest'          => 'fa fa-pinterest',
		'linkedin'           => 'fa fa-linkedin',
        'check'              => 'theme-icon-checked',
        'search'             => 'fa fa-search',
        'arrow_down'         => 'fa fa-angle-down',
	);
	if ( array_key_exists( $namespace, $map ) ) {
		return $map[$namespace];
	}
	return $namespace;
}

function care_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary', 'care' ),
		'id'            => 'wheels-sidebar-primary',
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Child Pages', 'care' ),
		'id'            => 'wheels-sidebar-child-pages',
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}

function care_register_nav_menus() {

	register_nav_menus( array(
		'primary_navigation' => esc_html__( 'Primary Navigation', 'care' ),
	) );
	register_nav_menus( array(
		'secondary_navigation' => esc_html__( 'Secondary Navigation', 'care' ),
	) );
	register_nav_menus( array(
		'mobile_navigation' => esc_html__( 'Mobile Navigation', 'care' ),
	) );
	register_nav_menus( array(
		'top_navigation' => esc_html__( 'Top Navigation', 'care' ),
	) );
	register_nav_menus( array(
		'one_page_navigation_1' => esc_html__( 'One Page Navigation 1', 'care' ),
	) );
	register_nav_menus( array(
		'one_page_navigation_2' => esc_html__( 'One Page Navigation 2', 'care' ),
	) );
	register_nav_menus( array(
		'one_page_navigation_3' => esc_html__( 'One Page Navigation 3', 'care' ),
	) );
}


