<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Content_Box {

	protected $namespace = 'scp_content_box';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->namespace, array( $this, 'render' ) );
		add_action( "scp_load_styles_{$this->namespace}", array( $this, 'load_css' ) );
	}

	public function integrateWithVC() {
		vc_map( array(
			'name'        => esc_html__( 'Content Box', 'care-plugin' ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'js_view'     => 'VcColumnView',
			'as_parent'   => array( 'except' => $this->namespace ),
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => 'Aislin',
			'params'      => array(
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'URL (Link)', 'care_plugin' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to icon.', 'care_plugin' ),
				),
				array(
					'type'       => 'dropdown',
					'param_name' => 'use_overlay',
					'heading'    => esc_html__( 'Use Overlay', 'care-plugin' ),
					'value'      => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'overlay_title',
					'heading'    => esc_html__( 'Overlay Title', 'care-plugin' ),
					'dependency'  => array( 'element' => 'use_overlay', 'value' => 'yes' ),
				),
				array(
					'type'        => 'textfield',
					'param_name'  => 'el_class',
					'heading'     => esc_html__( 'Extra class name', 'care-plugin' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'care-plugin' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'js_composer' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Bg Color', 'care-plugin' ),
					'param_name' => 'custom_background_color',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Hover Bg Color', 'care-plugin' ),
					'param_name' => 'hover_bg_color',
					'group'      => esc_html__( 'Design Options', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_top',
					'heading'    => esc_html__( 'Top', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_left',
					'heading'    => esc_html__( 'Left', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_spread',
					'heading'    => esc_html__( 'Spread', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Box Shadow Color', 'care-plugin' ),
					'param_name' => 'box_shadow_color',
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_top_hover',
					'heading'    => esc_html__( 'Top Hover', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_left_hover',
					'heading'    => esc_html__( 'Left Hover', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'textfield',
					'param_name' => 'box_shadow_spread_hover',
					'heading'    => esc_html__( 'Spread Hover', 'care-plugin' ),
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Box Shadow Color Hover', 'care-plugin' ),
					'param_name' => 'box_shadow_color_hover',
					'group'      => esc_html__( 'Box Shadow', 'care_plugin' ),
				),
			)
		) );
	}

	public function load_css( $atts ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'custom_background_color' => '', // bg_color name is vc default
			'hover_bg_color'          => '',
			'box_shadow_color'        => '',
			'box_shadow_top'          => '',
			'box_shadow_left'         => '',
			'box_shadow_spread'       => '',
			'box_shadow_color_hover'  => '',
			'box_shadow_top_hover'    => '',
			'box_shadow_left_hover'   => '',
			'box_shadow_spread_hover' => '',
		), $atts ) );

		$style = '';
		$style_hover = '';

		/**
		 * Custom BG Color
		 */
		if ( $custom_background_color ) {
			$style .= 'background-color:' . $custom_background_color . ';';
		}
		if ( $hover_bg_color ) {
			$style_hover .= 'background-color:' . $hover_bg_color . ';';
		}

		/**
		 * Box Shadow
		 */
		$box_shadow = '';
		if ( $box_shadow_color ) {
			$box_shadow_top    = $box_shadow_top ? (int) $box_shadow_top . 'px' : '0px';
			$box_shadow_left   = $box_shadow_left ? (int) $box_shadow_left . 'px' : '0px';
			$box_shadow_spread = $box_shadow_spread ? (int) $box_shadow_spread . 'px' : '5px';
			$box_shadow        = $box_shadow_top . ' ' . $box_shadow_left . ' ' . $box_shadow_spread . ' ' . $box_shadow_color;

			$style .= 'box-shadow:' . $box_shadow . ';';
		}

		/**
		 * Box Shadow Hover
		 */
		$box_shadow_hover = '';
		if ( $box_shadow_color_hover ) {
			$box_shadow_top_hover    = $box_shadow_top_hover ? (int) $box_shadow_top_hover . 'px' : '0px';
			$box_shadow_left_hover   = $box_shadow_left_hover ? (int) $box_shadow_left_hover . 'px' : '0px';
			$box_shadow_spread_hover = $box_shadow_spread_hover ? (int) $box_shadow_spread_hover . 'px' : '5px';
			$box_shadow_hover        = $box_shadow_top_hover . ' ' . $box_shadow_left_hover . ' ' . $box_shadow_spread_hover . ' ' . $box_shadow_color_hover;
			
			$style_hover .= 'box-shadow:' . $box_shadow_hover . ';';
		}

		
		$final_style = '';
		if ( $style ) {
			$final_style .= ".$uid{{$style}}";
		}
		if ( $style_hover ) {
			$final_style .= ".$uid:hover{{$style_hover}}";
		}
		if ( $final_style ) {
			wp_add_inline_style( 'care_options_style', $final_style );
		}
	}

	public function render( $atts, $content = null ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'link'                    => '',
			'use_overlay'             => 'no',
			'overlay_title'           => '',
			'custom_background_color' => '', // bg_color name is vc default
			'hover_bg_color'          => '',
			'box_shadow_color'        => '',
			'box_shadow_top'          => '',
			'box_shadow_left'         => '',
			'box_shadow_spread'       => '',
			'box_shadow_color_hover'  => '',
			'box_shadow_top_hover'    => '',
			'box_shadow_left_hover'   => '',
			'box_shadow_spread_hover' => '',
			'css'                     => '',
			'el_class'                => '',
		), $atts ) );
		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		$class_to_filter = 'wh-content-box';
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter . ' ' . $el_class, $this->namespace, $atts );
		$css_class .= ' ' . $uid;
 
		$link     = vc_build_link( $link );
		$a_href   = $link['url'];
		$a_title  = $link['title'];
		$a_target = $link['target'];

		ob_start();
		?>
		<div class="<?php echo esc_attr( $css_class ); ?>">
			<?php if ( strstr( $el_class, 'hoverable' ) ): ?>
				<span class="anim"></span>
			<?php endif ?>
			<?php if ( $use_overlay === 'yes' ) : ?>
				<div class="overlay"><?php echo esc_html( $overlay_title ); ?></div>
			<?php endif; ?>
			<?php if ( $a_href ) : ?>
				<a class="wh-content-box-link"
				   href="<?php echo esc_attr( $a_href ); ?>"
					<?php if ( $a_title ) : ?>
						title="<?php echo esc_attr( $a_title ); ?>"
					<?php endif; ?>
					<?php if ( $a_target ) : ?>
						target="<?php echo esc_attr( $a_target ); ?>"
					<?php endif; ?>
					></a>
			<?php endif; ?>
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php
		return ob_get_clean();
	}
}

new Care_Plugin_VC_Addon_Content_Box();

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_scp_content_box extends WPBakeryShortCodesContainer {
	}
}
