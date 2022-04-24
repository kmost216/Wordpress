<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Theme_Map {

	protected $namespace = 'scp_theme_map';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		// Load scripts only if shortcode is used.
		add_action( "scp_load_styles_{$this->namespace}", array( $this, 'loadCssAndJs' ) );

		add_shortcode( $this->namespace, array( $this, 'render' ) );
	}

	public function integrateWithVC() {

		vc_map( array(
			'name'        => esc_html( 'Theme Map', 'care-plugin' ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => 'Aislin',
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Map Height', 'care-plugin' ),
					'param_name'  => 'height',
					'value'       => '400',
					'description' => esc_html__( 'Value in px. Enter number only.', 'care-plugin' ),

				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Latitude', 'care-plugin' ),
					'param_name'  => 'latitude',
					'value'       => '40.7143528',
					'description' => sprintf( esc_html__( 'Visit %s to get coordinates.', 'care-plugin' ), '<a href="http://www.mapcoordinates.net/en" target="_blank">' . esc_html__( 'this site', 'care-plugin' ) . '</a>' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Longitude', 'care-plugin' ),
					'param_name'  => 'longitude',
					'value'       => '-74.0059731',
					'description' => sprintf( esc_html__( 'Visit %s to get coordinates.', 'care-plugin' ), '<a href="http://www.mapcoordinates.net/en" target="_blank">' . esc_html__( 'this site', 'care-plugin' ) . '</a>' ),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Zoom Level', 'care-plugin' ),
					'param_name' => 'zoom',
					'value'      => '10',
				),
				array(
					'type'        => 'textarea_safe',
					'heading'     => esc_html__( 'Snazzy Maps Style', 'care-plugin' ),
					'param_name'  => 'snazzy_style',
					'description' => sprintf( esc_html__( 'Visit %s to create your map style. Copy JavaScript Style Array and paste here.', 'care-plugin' ), '<a href="https://snazzymaps.com/style/15/subtle-grayscale" target="_blank">' . esc_html__( 'Example', 'care-plugin' ) . '</a>' ),
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Disable Map Zoom Scroll', 'care-plugin' ),
					'param_name' => 'disable_scroll',
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

	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'height'         => '400',
			'latitude'       => '40.7143528',
			'longitude'      => '-74.0059731',
			'zoom'           => '10',
			'snazzy_style'   => 'false',
			'disable_scroll' => '',
			'el_class'       => '',
		), $atts ) );

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $el_class, $this->namespace, $atts );

		$uid = uniqid( 'theme-map-' );

		$snazzy_style = trim( vc_value_from_safe( $snazzy_style ) );
		$snazzy_style = str_replace( '`', '', $snazzy_style );
		// make sure it is properly formated
		$snazzy_style = $snazzy_style ? $snazzy_style : '[]';

		$scroll_wheel = $disable_scroll === 'true' ? 'false' : 'true';
		$zoom         = absint( $zoom );
		$longitude    = floatval( $longitude );
		$latitude     = floatval( $latitude );

		$height = (int) $height;

		$inline_js = "
		jQuery(function ($) {
			if (google) {

				var el = '{$uid}';
				var zoom = {$zoom};
				var latitude = {$latitude};
				var longitude = {$longitude};
				var snazzyStyle = {$snazzy_style};
				var scrollwheel = {$scroll_wheel};

				$('#{$uid}').width('100%').height('{$height}px');

				google.maps.event.addDomListener(window, 'load', function () {
					var mapOptions = {
						zoom: zoom,
						center: new google.maps.LatLng(latitude, longitude),
						scrollwheel: scrollwheel,
						styles: snazzyStyle
					};
					var mapElement = document.getElementById(el);
					var map = new google.maps.Map(mapElement, mapOptions);
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(latitude, longitude),
						map: map,
						title: ''
					});
				});
			}
		});
		";

		wp_enqueue_script( 'gmaps' );
		wp_add_inline_script( 'gmaps', $inline_js );

		ob_start();
		?>
		<div id="<?php echo esc_attr( $uid ); ?>"
		     class="<?php echo esc_attr( $css_class ); ?>"></div>
		<?php
		return ob_get_clean();
	}

	public function loadCssAndJs() {
		$url          = 'https://maps.googleapis.com/maps/api/js';
		$user_api_key = care_plugin_get_theme_option( 'gmaps_api_key' );
		if ( $user_api_key ) {
			$url = $url . '?key=' . $user_api_key;
		}
		wp_register_script( 'gmaps', $url, array( 'jquery' ) );
	}

}

new Care_Plugin_VC_Addon_Theme_Map();
