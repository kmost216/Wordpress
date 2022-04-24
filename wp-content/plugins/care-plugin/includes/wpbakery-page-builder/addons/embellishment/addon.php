<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Embellishment {

	protected $shortcode_name = 'scp_embellishment';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->shortcode_name, array( $this, 'render' ) );
	}

	public function integrateWithVC() {
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		vc_map( array(
			"name"        => esc_html( 'Embellishment', 'care-plugin' ),
			"description" => '',
			"base"        => $this->shortcode_name,
			"class"       => "",
			"controls"    => "full",
			"icon"        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			"category"    => 'Aislin',
			"params"      => array(
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html( 'Color', 'care-plugin' ),
					'param_name'  => 'color',
					'description' => esc_html( 'If color is not set, theme accent color will be used.', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html( 'Extra class name', 'care-plugin' ),
					'param_name'  => 'el_class',
					'description' => esc_html( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'care-plugin' ),
				),
			)
		) );
	}

	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'color'    => '',
			'el_class' => '',
		), $atts ) );

		$css_class    = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class, $this->shortcode_name, $atts );
		$accent_color = care_plugin_get_theme_option( 'global-accent-color', '#000' );

		if ( ! $color ) {
			$color = $accent_color;
		}

		$uid = uniqid( 'embellishment-' );

		$out = '';
		$out .= '<div';
		$out .= ' class="' . esc_attr( $css_class ) . '"';
		$out .= ' style="width: 96px;margin: 0 auto;">';
		$out .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 96 24">';
		$out .= '<style type="text/css">';
		$out .= '.' . $uid . '{';
		$out .= 'fill-rule:evenodd;';
		$out .= 'clip-rule:evenodd;';
		$out .= 'fill: ' . $color . ';';
		$out .= '}';
		$out .= '</style>';
		$out .= '<path class="' . esc_attr( $uid ) . '" d="M48 0H0c0 0 14.4 0.4 19 5 5.5 5.5 15.8 18.8 29 19 13.2-0.2 23.5-13.5 29-19 4.6-4.6 19-5 19-5H48z"/>';
		$out .= '</svg>';
		$out .= '</div>';

		return $out;
	}

}

new Care_Plugin_VC_Addon_Embellishment();
