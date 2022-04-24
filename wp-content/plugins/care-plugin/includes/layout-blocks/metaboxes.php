<?php

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

add_filter( 'rwmb_meta_boxes', 'care_plugin_layout_blocks_register_meta_boxes', 100);

function care_plugin_layout_blocks_register_meta_boxes( $meta_boxes ) {

	$prefix = 'layout_block_'; 

	$meta_boxes[] = array(
		'title'  => 'Layout Block Settings',
		'pages'  => array( 'layout_block' ), // can be used on multiple CPTs
		'fields' => array(

			array(
				'id'   => $prefix . 'google_fonts',
				'type' => 'text',
				'name' => esc_html__( 'Google Fonts', 'care-plugin' ),
				'desc' => sprintf(
						esc_html__( 'Use this field only if you want a different font than the ones already defined in Theme Options. Visit %s and select your font there. Than just copy the url here.', 'care-plugin' ),
						'<a target="_blank" href="https://fonts.google.com/">Google Fonts</a>'
					),
			),

		)
	);

	return $meta_boxes;
}
