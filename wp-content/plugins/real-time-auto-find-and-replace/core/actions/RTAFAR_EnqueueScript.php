<?php namespace RealTimeAutoFindReplace\Actions;

/**
 * Class: Register Frontend Scripts
 *
 * @package Action
 * @since 1.0.0
 * @author M.Tuhin <tuhin@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	die();
}

use RealTimeAutoFindReplace\admin\functions\Masking;

class RTAFAR_EnqueueScript {

	function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'rtrar_action_admin_enqueue_scripts' ), 10 );

		add_action( 'wp_enqueue_scripts', array( $this, 'rtrarAppRegisterVars' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'rtrarAppEnqueueScripts' ), 90 );

	}

	/**
	 * Enqueue admin scripts
	 *
	 * @return void
	 */
	public function rtrar_action_admin_enqueue_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'admin.app.global', CS_RTAFAR_PLUGIN_ASSET_URI . 'js/rtafar.admin.global.min.js', array(), CS_RTAFAR_VERSION, true );

		wp_enqueue_style( 'rtafar-global', CS_RTAFAR_PLUGIN_ASSET_URI . 'css/rtafar-admin-global-style.min.css', false );

		// register custom data
		wp_localize_script(
			'admin.app.global',
			'rtafr',
			array(
				'is_pro_activate' => is_plugin_active( 'better-find-and-replace-pro/better-find-and-replace-pro.php' ),
				'baT'             => __( 'Bulk Action', 'real-time-auto-find-and-replace' ),
				'rT'              => __( 'Replace', 'real-time-auto-find-and-replace' ),
				'fT'              => __( 'Find', 'real-time-auto-find-and-replace' ),
				'aTp'             => __( 'Apply', 'real-time-auto-find-and-replace' ),
				'aT'              => __( 'Apply - Pro version only', 'real-time-auto-find-and-replace' ),
				'pvt'             => __( 'Pro version required!', 'real-time-auto-find-and-replace' ),
				'rBt'             => __( 'Replace - Pro', 'real-time-auto-find-and-replace' ),
				'drT'             => __( 'Creating Reports..', 'real-time-auto-find-and-replace' ),
				'frBnT'           => __( 'Find & Replace', 'real-time-auto-find-and-replace' ),
				'frDrBnT'         => __( 'Create Reports', 'real-time-auto-find-and-replace' ),
				'fedNotOfPerm'    => add_query_arg(
					array(
						CS_NOTICE_ID => 'Feedback_offPerm',
					),
					admin_url()
				),
			)
		);
	}

	/**
	 * Register locale
	 *
	 * @return void
	 */
	public function rtrarAppRegisterVars() {
		wp_enqueue_script( 'rtrar.appLocal', CS_RTAFAR_PLUGIN_ASSET_URI . 'js/rtafar.local.js', array(), CS_RTAFAR_VERSION, true );

		// get jquery / ajax replace rule
		$rules = Masking::get_rules( 'all', '', 'ajaxContent' );

		// register custom data
		wp_localize_script(
			'rtrar.appLocal',
			'rtafr',
			array( 'rules' => $rules )
		);
	}

	/**
	 * Enqueue app scripts
	 *
	 * @return void
	 */
	public function rtrarAppEnqueueScripts() {
		wp_enqueue_script( 'rtrar.app', CS_RTAFAR_PLUGIN_ASSET_URI . 'js/rtafar.app.min.js', array(), CS_RTAFAR_VERSION, true );
	}

}



