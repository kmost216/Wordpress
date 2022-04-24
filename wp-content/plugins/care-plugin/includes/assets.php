<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'Care_Plugin_Assets::parse_post_content_shortcodes', 1000 );

class Care_Plugin_Assets {

	public static function parse_post_content_shortcodes() {
		global $post;
		if ( $post ) {
			self::parse_shortcodes( $post->post_content );
		}

		$top_bar_use = care_plugin_get_theme_option( 'top-bar-use', false );
		if ( $top_bar_use ) {
			$top_bar_text = care_plugin_get_theme_option( 'top-bar-text', false );
			if ( $top_bar_text ) {
				self::parse_shortcodes( $top_bar_text );
			}
		}

		$top_bar_additional_use = care_plugin_get_theme_option( 'top-bar-additional-use', false );
		if ( $top_bar_additional_use ) {
			$top_bar_additional_text = care_plugin_get_theme_option( 'top-bar-additional-text', false );
			if ( $top_bar_additional_text ) {
				self::parse_shortcodes( $top_bar_additional_text );
			}
		}

		// Layout Blocks
		if ( function_exists( 'care_get_layout_block_content' ) 
			&& function_exists( 'care_get_registered_layout_blocks' ) ) {
			foreach ( care_get_registered_layout_blocks() as $layout_block ) {
				$layout_block_content = care_get_layout_block_content( $layout_block );
				if ( $layout_block_content ) {
					self::parse_shortcodes( $layout_block_content );
				}
			}
		}
	}

	public static function parse_shortcodes( $content ) {
		if ( ! $content ) {
			return;
		}
		global $shortcode_tags;
		preg_match_all( '/' . get_shortcode_regex() . '/', $content, $shortcodes );
		foreach ( $shortcodes[2] as $index => $tag ) {
			$attr_array = shortcode_parse_atts( trim( $shortcodes[3][ $index ] ) );
			if ( isset( $shortcode_tags[$tag] ) ) {
				do_action( "scp_load_styles_{$tag}", $attr_array );
			}
		}
		foreach ( $shortcodes[5] as $shortcode_content ) {
			Care_Plugin_Assets::parse_shortcodes( $shortcode_content );
		}
	}

	public static function get_uid( $namespace, $atts ) {
		$class = '';
		if ( is_array( $atts ) ) {
			$class = implode('', $atts);
			$class = hash('md5', $class);
		}
		return "{$namespace}-{$class}";
	}
}
