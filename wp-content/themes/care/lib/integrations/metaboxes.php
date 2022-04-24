<?php


add_filter( 'rwmb_meta_boxes', 'care_register_meta_boxes' );

function care_register_meta_boxes( $meta_boxes ) {
	$prefix     = 'care_';

	/**
	 * Pages
	 */
	$menus       = get_registered_nav_menus();
	$menus_array = array();

	foreach ( $menus as $location => $description ) {
		$menus_array[ $location ] = $description;
	}

	$layout_blocks = get_posts( array( 'post_type' => 'layout_block', 'posts_per_page' => -1 ) );
	$layout_blocks_array = array();
	foreach ( $layout_blocks as $layout_block ) {
		$layout_blocks_array[ $layout_block->ID ] = $layout_block->post_title;
	}


	$meta_boxes[] = array(
		'title'  => 'Page Settings',
		'pages'  => array( 'page' ), // can be used on multiple CPTs
		'fields' => array(
			array(
				'id'   => $prefix . 'use_one_page_menu',
				'type' => 'checkbox',
				'name' => esc_html__( 'Use One Page Menu', 'care' ),
				'desc' => esc_html__( 'When using one page menu functionality you need to add an extra class on each vc row you want to link to a menu item. Also you need to create a menu in Appearance/Menus and create custom links where each link url has the same name as the row class prefixed with # sign',
					'care' ),
			),
			array(
				'id'          => $prefix . 'one_page_menu_location',
				'type'        => 'select',
				'name'        => esc_html__( 'Select One Page Menu Location', 'care' ),
				'desc'        => esc_html__( 'Used only if Use One Page Menu is checked.', 'care' ),
				'options'     => $menus_array,
				'placeholder' => 'Select Menu Location',
			),
			array(
				'id'               => $prefix . 'custom_logo',
				'type'             => 'image_advanced',
				'name'             => esc_html__( 'Custom Logo', 'care' ),
				'desc'             => esc_html__( 'Used it to override the logo from theme options. This works well when using Transparent Header Template.', 'care' ),
				'max_file_uploads' => 1,
			),
			array(
				'id'          => $prefix . 'top_bar_layout_block',
				'type'        => 'select',
				'name'        => esc_html( 'Top Bar Layout Block', 'wheels' ),
				'desc'        => esc_html( 'Override Theme Options settings.', 'wheels' ),
				'options'     => $layout_blocks_array,
				'placeholder' => esc_html( 'Default' ),
			),
			array(
				'id'          => $prefix . 'footer_layout_block',
				'type'        => 'select',
				'name'        => esc_html( 'Footer Layout Block', 'wheels' ),
				'desc'        => esc_html( 'Override Theme Options settings.', 'wheels' ),
				'options'     => $layout_blocks_array,
				'placeholder' => esc_html( 'Default' ),
			),
		)
	);

	return $meta_boxes;
}
