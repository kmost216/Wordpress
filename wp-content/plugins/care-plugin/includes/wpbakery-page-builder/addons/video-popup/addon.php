<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// if plugin activates before VC
if ( ! class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode {
	}
}

class Care_Plugin_VC_Addon_Video_Popup extends WPBakeryShortCode {

	protected $shortcode_name = 'st_video_popup';

	public function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_action( "scp_load_styles_{$this->shortcode_name}", array( $this, 'load_css' ) );
		add_shortcode( $this->shortcode_name, array( $this, 'render' ) );
	}

	public function integrateWithVC() {

		$thumbnail_sizes = array_merge( array( 'Full' => 'full'), care_plugin_get_thumbnail_sizes_vc() );

		vc_map( array(
			'name'        => esc_html__( 'Video Popup', 'care-plugin' ),
			'description' => '',
			'base'        => $this->shortcode_name,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => 'Aislin',
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'js_composer' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'js_composer' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Video Url', 'care-plugin' ),
					'param_name'  => 'video_url',
					'value'       => '',
					'description' => esc_html__( 'Add Youtube/Vimeo video url', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Video Width', 'care-plugin' ),
					'param_name'  => 'video_width',
					'value'       => '',
					'description' => esc_html__( 'Value in px. Enter number only.', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'class'       => '',
					'heading'     => esc_html__( 'Video Height', 'care-plugin' ),
					'param_name'  => 'video_height',
					'value'       => '',
					'description' => esc_html__( 'Value in px. Enter number only.', 'care-plugin' ),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Play Badge Color', 'care-plugin' ),
					'param_name' => 'play_badge_color',
					'value'      => '#fff',
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Thumbnail', 'care-plugin' ),
					'param_name'  => 'image',
					'value'       => '',
					'description' => esc_html__( 'Select image from media library.', 'care-plugin' ),
					'dependency'  => array(
						'value' => 'media_library',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Image Size', 'care-plugin' ),
					'param_name' => 'img_size',
					'value'      => $thumbnail_sizes,
				),
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

	public function load_css( $atts ) {

		$uid = Care_Plugin_Assets::get_uid( $this->shortcode_name, $atts );

		extract( shortcode_atts( array(
			'play_badge_color' => '#fff',
			'img_size'         => 'full',
		), $atts ) );

		if ( $play_badge_color ) {
			$css = ".{$uid} .box{border-color:{$play_badge_color}}";
			$css .= ".{$uid} .tri{border-left-color:{$play_badge_color}}";
			wp_add_inline_style( 'care_options_style', $css );
		}
	}

	public function render( $atts, $content = null ) {

		$uid = Care_Plugin_Assets::get_uid( $this->shortcode_name, $atts );
		extract( shortcode_atts( array(
			'title'            => '',
			'video_url'        => '',
			'video_width'      => '',
			'video_height'     => '',
			'play_badge_color' => '#fff',
			'image'            => '',
			'img_size'         => 'full',
			'alignment'        => 'left',
			'css_animation'    => '',
			'css'              => '',
			'el_class'         => '',
		), $atts ) );

		$default_src = vc_asset_url( 'vc/no_image.png' );
		$img_id      = preg_replace( '/[^\d]/', '', $image );

		$img = wpb_getImageBySize( array(
			'attach_id'  => $img_id,
			'thumb_size' => $img_size,
			'class'      => 'vc_single_image-img',
		) );

		if ( ! $img ) {
			$img['thumbnail'] = '<img class="vc_img-placeholder vc_single_image-img" src="' . esc_url( $default_src ) . '" alt="video-popup-image"/>';
		}

		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );

		$a_attrs['class'] = 'prettyphoto';

		if ( $video_url ) {
			$video_width  = (int) $video_width;
			$video_height = (int) $video_height;
			if ( $video_width && $video_height ) {
				$video_url .= '&width=' . $video_width;
				$video_url .= '&height=' . $video_height;
			}
			$link = $video_url;
		} else {
			$link = wp_get_attachment_image_src( $img_id, 'large' );
			$link = $link[0];
		}

		$wrapperClass = 'vc_single_image-wrapper';

		if ( $link ) {
			$a_attrs['href'] = $link;
			if ( ! empty( $a_attrs['class'] ) ) {
				$wrapperClass .= ' ' . $a_attrs['class'];
				unset( $a_attrs['class'] );
			}

			$play_icon = '<div class="box"><div class="tri"></div></div>';
			$html = '<a ' . vc_stringify_attributes( $a_attrs ) . ' class="' . esc_attr( $wrapperClass ) . '" data-rel="prettyPhoto">' . $img['thumbnail'] . $play_icon . '</a>';
		} else {
			$html = '<div class="' . $wrapperClass . '">' . $img['thumbnail'] . '</div>';
		}

		$class_to_filter = 'wpb_single_image st-video-popup wpb_content_element vc_align_' . $alignment . ' ' . $this->getCSSAnimation( $css_animation );
		$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class );
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
		$css_class .= ' ' . $uid;

		$output = '
      	<div class="' . esc_attr( trim( $css_class ) ) . '">
      		' . wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_singleimage_heading' ) ) . '
      		<figure class="wpb_wrapper vc_figure">
      			' . $html . '
      		</figure>
      	</div>
      ';
		return $output;
	}

}

new Care_Plugin_VC_Addon_Video_Popup();
