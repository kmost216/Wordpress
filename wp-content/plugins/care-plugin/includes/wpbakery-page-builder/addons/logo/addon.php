<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// if plugin activates before VC
if ( ! class_exists( 'WPBakeryShortCode' ) ) {
	return;
}

class Care_Plugin_VC_Addon_Logo extends WPBakeryShortCode {

	protected $shortcode_name = 'st_logo';

	public function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->shortcode_name, array( $this, 'render' ) );
	}

	public function integrateWithVC() {

		vc_map( array(
			'name'        => esc_html__( 'Logo', 'care-plugin' ),
			'description' => esc_html__( 'Uses logo image set in Theme Options', 'care-plugin' ),
			'base'        => $this->shortcode_name,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => 'Aislin',
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Image alignment', 'js_composer' ),
					'param_name'  => 'alignment',
					'value'       => array(
						esc_html__( 'Left', 'js_composer' )   => 'left',
						esc_html__( 'Right', 'js_composer' )  => 'right',
						esc_html__( 'Center', 'js_composer' ) => 'center',
					),
					'description' => esc_html__( 'Select image alignment.', 'js_composer' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'js_composer' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'js_composer' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
			),
		) );
	}

	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'alignment'      => 'left',
			'css'            => '',
			'el_class'       => '',
		), $atts ) );

		$class_to_filter = 'wh-logo wpb_single_image wpb_content_element vc_align_' . $alignment;
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

		$logo_url = '';
		if ( function_exists( 'care_get_logo_url' ) ) {
			$logo_url = care_get_logo_url();
		}

		ob_start();
		?>
		<?php if ( $logo_url ): ?>
			<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">
	      		<figure class="wpb_wrapper vc_figure">
	      			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	      				<img class="vc_single_image-img" src="<?php echo esc_url( $logo_url ); ?>" alt="logo"/>
	      			</a>
	      		</figure>
	      	</div>
		<?php else: ?>
			<div class="wh-logo">
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				</h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
		<?php endif ?>
      	<?php
      	return ob_get_clean();
	}

}

new Care_Plugin_VC_Addon_Logo();
