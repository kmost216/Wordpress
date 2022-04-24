<?php

function care_get_registered_layout_blocks() {

	$layout_blocks = apply_filters( 'care_registered_layout_blocks', array(
		'header-layout-block',
		'header-layout-block-mobile',
		'footer-layout-block',
		'quick-sidebar-layout-block',
	) );
	return is_array( $layout_blocks) ? $layout_blocks : array();
}

function care_get_layout_block_id( $key ) {

	global $post;
	$layout_block_id = null;

	if ( $post ) {
		$layout_block_id = care_get_rwmb_meta( str_replace( '-', '_', $key ), $post->ID );
	}
	if ( ! $layout_block_id ) {
		$layout_block_id = care_get_option( $key, false );
	}

	// WPML
	$curr_lang = apply_filters( 'wpml_current_language', null );
    $layout_block_id = apply_filters( 'wpml_object_id', $layout_block_id, 'layout_block', true, $curr_lang );

	return (int) $layout_block_id;
}


function care_get_layout_block( $key ) {

	$layout_block_id = care_get_layout_block_id( $key );
	if ( $layout_block_id ) {
		$layout_block = get_post( $layout_block_id );
		return $layout_block;
	}
}

function care_get_layout_block_content( $key ) {

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		$post_id = care_get_layout_block_id( $key );

		if ( \Elementor\Plugin::instance()->db->is_built_with_elementor( $post_id ) ) {
			return \Elementor\Plugin::instance()
				->frontend->get_builder_content_for_display( $post_id );
		}
	}

	$layout_block = care_get_layout_block( $key );
	$content      = false;
	if ( $layout_block ) {

		$content = $layout_block->post_content;

		if ( defined( 'WPB_VC_VERSION' ) ) {
			$search  = array(
				'vc_basic_grid',
				'vc_media_grid',
				'vc_masonry_grid',
				'vc_masonry_media_grid'
			);
			$replace = array();
			foreach ( $search as $val ) {
				$replace[] = $val . ' page_id="' . $layout_block->ID . '"';
			}
			$content = str_replace( $search, $replace, $content );
		}
	}
	return $content;
}
