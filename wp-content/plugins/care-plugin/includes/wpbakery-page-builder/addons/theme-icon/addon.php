<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Theme_Icon {

	protected $namespace = 'scp_theme_icon';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
		add_action( "scp_load_styles_{$this->namespace}", array( $this, 'load_css' ) );

		add_shortcode( $this->namespace, array( $this, 'render' ) );
	}

	public function integrateWithVC() {

		vc_map( array(
			'name'             => esc_html( 'Theme Icon', 'care-plugin' ),
			'description'      => '',
			'base'             => $this->namespace,
			'class'            => '',
			'controls'         => 'full',
			'icon'             => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'         => 'Aislin',
			'admin_enqueue_js' => array( plugins_url( 'assets/admin-theme-icon.js', __FILE__ ) ),
			'params'           => array(
				array(
					'type'        => 'iconpicker',
					'param_name'  => 'theme_icon',
					'heading'     => esc_html__( 'Icon', 'care-plugin' ),
					'value'       => '', // default value to backend editor admin_label
					'class'       => 'scp-theme-icon-name',
					'holder'      => 'div',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'theme-icons',
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'description' => esc_html__( 'Select icon from library.', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Font Size', 'care-plugin' ),
					'param_name'  => 'icon_font_size',
					'description' => esc_html__( 'Value in px. Enter number only.', 'care-plugin' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Position Absolute?', 'care-plugin' ),
					'param_name' => 'position_absolute',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon alignment', 'js_composer' ),
					'param_name'  => 'alignment',
					'value'       => array(
						esc_html__( 'Left', 'js_composer' )   => 'left',
						esc_html__( 'Right', 'js_composer' )  => 'right',
						esc_html__( 'Center', 'js_composer' ) => 'center',
					),
					'description' => esc_html__( 'Select alignment.', 'js_composer' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'URL (Link)', 'js_composer' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to icon.', 'js_composer' ),
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Icon Color', 'care-plugin' ),
					'param_name'  => 'color',
					'description' => esc_html__( 'If color is not set, theme accent color will be used.', 'care-plugin' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Use Theme Accent Color for Hover', 'care-plugin' ),
					'param_name' => 'hover_accent_color',
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Icon Hover Color', 'care-plugin' ),
					'param_name'  => 'hover_color',
					'description' => esc_html__( 'Will not be used if Use Accent Color is checked.', 'care-plugin' ),
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
			)
		) );
	}

	public function load_css( $atts ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'icon_font_size'     => '',
			'position_absolute'  => '',
			'alignment'          => 'left',
			'color'              => '',
			'hover_color'        => '',
			'hover_accent_color' => '',
		), $atts ) );

		if ( $hover_accent_color == 'true' && function_exists( 'care_get_option' ) ) {
			$theme_accent_color = care_get_option( 'global-accent-color' );
			if ( $theme_accent_color ) {
				$hover_color = $theme_accent_color;
			}
		}

		$final_style = '';
		$css = '';
		$css_hover = '';

		if ( $icon_font_size ) {
			$css .= 'font-size:' . (int) $icon_font_size . 'px !important;';
		}

		if ( $position_absolute == 'true' ) {
			$css .= 'position:absolute;';
		}

		if ( $color ) {
			// needs important to be stronger that theme options
			$css .= "color:{$color} !important;";
		}

		if ( $alignment ) {
			if ( $alignment != 'left' ) {
				$css .= "text-align:{$alignment};";
			}
		}

		/**
		 * Hover
		 */
		if ( $hover_color ) {
			$css_hover .= "color:{$hover_color} !important;";
		}

		if ( $css ) {
			$final_style .= ".{$uid}.wh-theme-icon{{$css}}";
		}
		if ( $css_hover ) {
			$final_style .= ".{$uid}.wh-theme-icon:hover{{$css_hover}}";
		}

		if ( $final_style ) {
			wp_add_inline_style( 'care_options_style', $final_style );
		}
	}

	public function render( $atts, $content = null ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'theme_icon'         => 'Text on the button',
			'icon_font_size'     => '',
			'position_absolute'  => '',
			'link'               => '',
			'alignment'          => 'left',
			'color'              => '',
			'hover_color'        => '',
			'hover_accent_color' => '',
			'css'                => '',
			'el_class'           => '',
		), $atts ) );

		$class_to_filter = 'wh-theme-icon';
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter . ' ' . $el_class, $this->namespace, $atts );
		$css_class .= ' ' . $uid;

		$link     = vc_build_link( $link );
		$a_href   = $link['url'];
		$a_title  = $link['title'];
		$a_target = $link['target'];

		ob_start();
		?>

		<?php if ( $a_href ) : ?>
			<a
				href="<?php echo esc_url( $a_href ); ?>"
				class="<?php echo esc_attr( trim( $css_class ) ); ?>"
				<?php if ( $a_title ) : ?>
					title="<?php echo esc_attr( $a_title ); ?>"
				<?php endif; ?>
				<?php if ( $a_target ) : ?>
					target="<?php echo esc_attr( $a_target ); ?>"
				<?php endif; ?>
				><i class="<?php echo esc_attr( $theme_icon ); ?>"></i></a>
		<?php else: ?>
			<div class="<?php echo esc_attr( $css_class ); ?>">
				<i class="<?php echo esc_attr( $theme_icon ); ?>"></i>
			</div>
		<?php endif; ?>
		<?php
		return ob_get_clean();
	}

	public function loadCssAndJs() {

		if ( is_admin() ) {
			global $pagenow;
			if ( $pagenow != 'post.php' ) {
				return;
			}
		}
		
		wp_register_style( 'care-theme-icons', get_template_directory_uri() . '/assets/css/theme-icons.css', false );
		wp_enqueue_style( 'care-theme-icons' );
	}

}

new Care_Plugin_VC_Addon_Theme_Icon();
