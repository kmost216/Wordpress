<?php

function care_get_layout_blocks_css() {
	$css = '';
	foreach ( care_get_registered_layout_blocks() as $layout_block ) {
		$layout_block_id = care_get_layout_block_id( $layout_block );
		$css .= care_get_vc_page_custom_css( $layout_block_id );
		$css .= care_get_vc_shortcodes_custom_css( $layout_block_id );
	}
	return $css;
}

function care_get_vc_page_custom_css( $id ) {
	$out = '';
	if ( $id ) {
		$post_custom_css = get_post_meta( $id, '_wpb_post_custom_css', true );
		if ( ! empty( $post_custom_css ) ) {
			$post_custom_css = strip_tags( $post_custom_css );
			$out .= $post_custom_css;
		}
	}
	return $out;
}

function care_get_vc_shortcodes_custom_css( $id ) {
	$out = '';
	if ( $id ) {
		$shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
		if ( ! empty( $shortcodes_custom_css ) ) {
			$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
			$out .= $shortcodes_custom_css;
		}
	}
	return $out;
}


function care_get_vc_default_post_css() {

		if ( ! defined( 'WPB_VC_VERSION' ) || version_compare( WPB_VC_VERSION, '6.0', '<' ) ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}
		
		$id = get_the_ID();
		$out = '';
		if ( $id ) {
			if ( 'true' === vc_get_param( 'preview' ) ) {
				$latest_revision = wp_get_post_revisions( $id );
				if ( ! empty( $latest_revision ) ) {
					$array_values = array_values( $latest_revision );
					$id = $array_values[0]->ID;
				}
			}
			$shortcodes_custom_css = get_metadata( 'post', $id, '_wpb_post_custom_css', true );
			if ( ! empty( $shortcodes_custom_css ) ) {
				$out = wp_strip_all_tags( $shortcodes_custom_css );
			}
		}

		return $out;
	}
