<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Theme_Button {

	protected $namespace = 'scp_theme_button';

	public function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->namespace, array( $this, 'render' ) );
		add_action( "scp_load_styles_{$this->namespace}", array( $this, 'load_css' ) );
	}

	public function integrateWithVC() {

		vc_map( array(
			'name'        => esc_html( 'Theme Button', 'care-plugin' ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => 'Aislin',
			'params'      => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Text', 'js_composer' ),
					'param_name' => 'title',
					'holder'     => 'div',
					'value'      => esc_html__( 'Text on the button', 'js_composer' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'URL (Link)', 'js_composer' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to button.', 'js_composer' ),
				),
				array(
					'type'        => 'dropdown',
					'holder'      => '',
					'class'       => '',
					'heading'     => esc_html__( 'Style', 'care-plugin' ),
					'param_name'  => 'style',
					'value'       => array(
						'Default'      => 'wh-button',
						'Alt Button'   => 'wh-alt-button',
						'Alt Button 2' => 'wh-alt-button-2',
					),
					'description' => esc_html__( 'Theme Button Styling form Theme Options/Other Settings.', 'care-plugin' )
				),
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Align', 'care-plugin' ),
					'param_name' => 'align',
					'value'      => array(
						'left'   => 'left',
						'center' => 'center',
						'right'  => 'right',
					),
					'group'      => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Bg Color', 'care-plugin' ),
					'param_name'       => 'custom_background_color',
					'edit_field_class' => 'vc_col-sm-3',
					'group'            => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Text Color', 'care-plugin' ),
					'param_name'       => 'text_color',
					'edit_field_class' => 'vc_col-sm-3',
					'group'      => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Hover Bg Color', 'care-plugin' ),
					'param_name'       => 'bg_color_hover',
					'edit_field_class' => 'vc_col-sm-3',
					'group'      => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'             => 'colorpicker',
					'heading'          => esc_html__( 'Hover Text Color', 'care-plugin' ),
					'param_name'       => 'text_color_hover',
					'edit_field_class' => 'vc_col-sm-3',
					'group'            => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Font Size', 'care-plugin' ),
					'param_name'  => 'font_size',
					'value'       => '',
					'description' => esc_html__( 'Override font size.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Width', 'care-plugin' ),
					'param_name'  => 'width',
					'value'       => '',
					'description' => esc_html__( 'Override button width.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Padding Top', 'care-plugin' ),
					'param_name'  => 'padding_top',
					'value'       => '',
					'description' => esc_html__( 'Override padding top.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Padding Left', 'care-plugin' ),
					'param_name'  => 'padding_left',
					'value'       => '',
					'description' => esc_html__( 'Override padding left.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Padding Bottom', 'care-plugin' ),
					'param_name'  => 'padding_bottom',
					'value'       => '',
					'description' => esc_html__( 'Override padding bottom.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Padding Right', 'care-plugin' ),
					'param_name'  => 'padding_right',
					'value'       => '',
					'description' => esc_html__( 'Override padding right.', 'care-plugin' ),
					'group'       => esc_html__( 'Overrides', 'care-plugin' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'js_composer' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'care-plugin' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'care-plugin' ),
				),
			)
		) );
	}


	public function load_css( $atts ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'align'                   => '',
			'custom_background_color' => '', // had to be named like this because of the confilct with VC
			'bg_color_hover'          => '',
			'text_color'              => '',
			'text_color_hover'        => '',
			'width'                   => '',
			'font_size'               => '',
			'padding_top'             => '',
			'padding_right'           => '',
			'padding_bottom'          => '',
			'padding_left'            => '',
			'link'                    => '',
		), $atts ) );

		$link     = vc_build_link( $link );
		$a_href   = $link['url'];
		$a_title  = $link['title'];
		$a_target = $link['target'];

		$style = '';
		$style_hover = '';

		/**
		 * Custom BG Color
		 */
		if ( $custom_background_color ) {
			$style .= 'background-color:' . $custom_background_color . ';';
		}
		if ( $text_color ) {
			$style .= 'color:' . $text_color . ';';
		}

		if ( $bg_color_hover ) {
			$style_hover .= 'background-color:' . $bg_color_hover . ';';
		}
		if ( $text_color_hover ) {
			$style_hover .= 'color:' . $text_color_hover . ';';
		}

		if ( $font_size ) {
			$style .= 'font-size:' . care_plugin_sanitize_size( $font_size ) . ';';
		}

		if ( $align ) {
			if ( $align == 'left' ) {
				$style .= 'float:left;';
			} elseif ( $align == 'right' ) {
				$style .= 'float:right;';
			} elseif ( $align == 'center' ) {
				if ($a_href) {
					$style .= 'display:inline-block;';
				} else {
					$style .= 'display:block;margin:0 auto;';
				}
			}
		}
		if ( $width ) {
			$style .= 'width:' . care_plugin_sanitize_size( $width ) . ';';
		}
		if ( $padding_top ) {
			$style .= 'padding-top:' . care_plugin_sanitize_size( $padding_top ) . ';';
		}
		if ( $padding_right ) {
			$style .= 'padding-right:' . care_plugin_sanitize_size( $padding_right ) . ';';
		}
		if ( $padding_bottom ) {
			$style .= 'padding-bottom:' . care_plugin_sanitize_size( $padding_bottom ) . ';';
		}
		if ( $padding_left ) {
			$style .= 'padding-left:' . care_plugin_sanitize_size( $padding_left ) . ';';
		}

		$final_style = '';
		if ( $style ) {
			$final_style .= "li.msm-menu-item .msm-submenu a.wh-button.$uid, .$uid{{$style}}";
		}
		if ( $style_hover ) {
			$final_style .= "li.msm-menu-item .msm-submenu a.wh-button.$uid:hover, .$uid:hover{{$style_hover}}";
		}
		if ( $final_style ) {
			wp_add_inline_style( 'care_options_style', $final_style );
		}
	}

	public function render( $atts, $content = null ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'title'                   => 'Text on the button',
			'align'                   => '',
			'custom_background_color' => '', // had to be named like this because of the confilct with VC
			'bg_color_hover'          => '',
			'text_color'              => '',
			'text_color_hover'        => '',
			'style'                   => 'wh-button',
			'width'                   => '',
			'font_size'               => '',
			'padding_top'             => '',
			'padding_right'           => '',
			'padding_bottom'          => '',
			'padding_left'            => '',
			'link'                    => '',
			'css'                     => '',
			'el_class'                => '',
		), $atts ) );

		$class_to_filter = $style;
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter . ' ' . $el_class, $this->namespace, $atts );
		$css_class .= ' ' . $uid;

		$link     = vc_build_link( $link );
		$a_href   = $link['url'];
		$a_title  = $link['title'];
		$a_target = $link['target'];

		$anim = '';
		if ( strstr( $el_class, 'hoverable' ) ) {
			$anim = '<span class="anim"></span>';
		}

		if ( $a_href ) {
			$html = '<a';
			$html .= ' href="' . esc_attr( $a_href ) . '"';
			$html .= ' class="' . esc_attr( trim( $css_class ) ) . '"';
			if ($a_title) {
				$html .= ' title="' . esc_attr( $a_title ) . '"';
			}
			if ( $a_target ) {
				$html .= ' target="' . esc_attr( $a_target ) . '"';
			}
			$html .= '>';
			$html .= $anim;
			$html .= $title;
			$html .= '</a>';


		} else {
			$html = '<button';
			$html .= ' class="' . esc_attr( trim( $css_class ) ) . '"';
			$html .= '>';
			$html .= $anim;
			$html .= $title;
			$html .= '</button>';
		}
		
		if ( $align && $align == 'center' ) {
			$html = '<div class="align-center">' . $html . '</div>';
		}

		return $html;
	}

}

new Care_Plugin_VC_Addon_Theme_Button();
