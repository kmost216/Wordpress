<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'envato_setup_logo_image', 'care_envato_setup_logo_image' );
function care_envato_setup_logo_image( $old_image_url ) {
	return get_parent_theme_file_uri( '/lib/integrations/envato_setup/images/aislin.png' );
}

// 

// Will be called from envato_setup.php
function envato_theme_setup_wizard() {

	if ( ! class_exists( 'Envato_Theme_Setup_Wizard' ) ) {
		return;
	}

	class Care_Envato_Theme_Setup_Wizard extends Envato_Theme_Setup_Wizard {

		private static $instance = null;

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public $installation_video_link = 'https://www.youtube.com/watch?v=l50bHg4Ig7A';

		public $site_styles = array(
			'style1' => array(
				'title'            => 'Nutrition',
				'use_layer_slider' => true,
			),
			'style2' => array(
				'title'            => 'Yoga',
				'use_layer_slider' => true,
			),
			'style3' => array(
				'title'            => 'Pet Sitter',
				'use_layer_slider' => true,
			),
			'style4' => array(
				'title'            => 'Nannie',
				'use_layer_slider' => true,
			),
			'style5' => array(
				'title'            => 'Nurse',
				'use_layer_slider' => true,
			),
		);

	}

	Care_Envato_Theme_Setup_Wizard::get_instance();
}
