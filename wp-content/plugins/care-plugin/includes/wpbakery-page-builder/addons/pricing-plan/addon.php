<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Pricing_Plan {

	protected $namespace = 'pricing_plan';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->namespace, array( $this, 'render' ) );
		add_action( "scp_load_styles_{$this->namespace}", array( $this, 'load_css' ) );
	}

	public function integrateWithVC() {
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		vc_map( array(
			"name"        => esc_html__( 'Pricing Plan', 'care-plugin' ),
			"description" => '',
			"base"        => $this->namespace,
			"class"       => "",
			"controls"    => "full",
			"icon"        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			"category"    => esc_html__( 'Aislin', 'js_composer' ),
			"params"      => array(
				array(
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Plan Title', 'care-plugin' ),
					'param_name' => 'title',
					'value'      => esc_html__( '', 'care-plugin' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Price', 'care-plugin' ),
					'param_name' => 'price',
					'value'      => esc_html__( '', 'care-plugin' ),
				),
				array(
					'type'       => 'textfield',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Currency Symbol', 'care-plugin' ),
					'param_name' => 'currency_symbol',
					'value'      => esc_html__( '', 'care-plugin' ),
				),
				array(
					'type'        => 'textarea',
					'holder'      => '',
					'class'       => '',
					'heading'     => esc_html__( 'Features', 'care-plugin' ),
					'param_name'  => 'features',
					'value'       => esc_html__( '', 'care-plugin' ),
					'description' => esc_html__( 'Pipe separated list (Feature 1 | Feature 2 | Feature 3).', 'care-plugin' )
				),
				array(
					'type'       => 'textarea',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Footnote', 'care-plugin' ),
					'param_name' => 'footnote',
					'value'      => esc_html__( '', 'care-plugin' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Background Color', 'care-plugin' ),
					'param_name' => 'bg_color',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Separator Color', 'care-plugin' ),
					'param_name' => 'separator_color',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Title/Price Color', 'care-plugin' ),
					'param_name' => 'price_color',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Feature Color', 'care-plugin' ),
					'param_name' => 'feature_color',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Icon Color', 'care-plugin' ),
					'param_name' => 'icon_color',
				),
			)
		) );
	}

	public function load_css( $atts ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'bg_color'        => '',
			'separator_color' => '',
			'price_color'     => '',
			'feature_color'   => '',
			'icon_color'      => '',
		), $atts ) );

		$style = '';

		/**
		 * Price Box CSS
		 */
		$price_box_css = '';
		if ( $price_color ) {
			$price_box_css .= 'color:' . $price_color . ';';
		}

		if ( $separator_color ) {
			$price_box_css .= 'border-right:2px solid ' . $separator_color . ';';
		}

		if ( $price_box_css ) {
			$style .= ".$uid .price-box{{$price_box_css}}";
		}

		/**
		 * BG CSS
		 */
		if ( $bg_color ) {
			$style .= ".$uid{background-color:{$bg_color}}";
		}

		/**
		 * Feature Box CSS
		 */
		if ( $feature_color ) {
			$style .= ".$uid .feature-box{color:{$feature_color}}";
		}

		/**
		 * Icon CSS
		 */
		if ($icon_color) {
			$style .= ".$uid i{color:{$icon_color}}";
		}

		if ( $style ) {
			wp_add_inline_style( 'care_options_style', $style );
		}
	}

	public function render( $atts, $content = null ) {

		$uid = Care_Plugin_Assets::get_uid( $this->namespace, $atts );

		extract( shortcode_atts( array(
			'title'           => '',
			'price'           => '',
			'currency_symbol' => '',
			'features'        => '',
			'footnote'        => '',
			'bg_color'        => '',
			'separator_color' => '',
			'price_color'     => '',
			'feature_color'   => '',
			'icon_color'      => '',
			'css'             => '',
		), $atts ) );

		$class_to_filter = 'wh-pricing-plan';
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter , $this->namespace, $atts );
		$css_class .= ' ' . $uid;

		$features = explode('|', $features);

		ob_start();
		?>
		<div class="<?php echo esc_attr( $css_class ); ?>">
			<div class="price-box">
				<div class="title"><?php echo esc_html($title); ?></div>
				<div class="price">
					<small><?php echo esc_html( $currency_symbol ); ?></small>
					<span><?php echo esc_html( $price ); ?></span>
				</div>
			</div>
			<div class="feature-box">
				<ul>
					<?php foreach ( $features as $feature ) : ?>
						<li><i class="icon-check-icon"></i> <?php echo wp_kses_post( trim( esc_html( $feature ) ) ) ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="footnote">
					<?php echo esc_html( $footnote ); ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

new Care_Plugin_VC_Addon_Pricing_Plan();
