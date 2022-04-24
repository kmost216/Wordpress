<?php namespace RealTimeAutoFindReplace\admin\options\functions;

/**
 * Class: DB replacer
 *
 * @package Admin
 * @since 1.3.1
 * @author M.Tuhin <info@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	die();
}

use RealTimeAutoFindReplace\lib\Util;

class DbFuncReplaceInDb {

	/**
	 * Get tables list
	 *
	 * @param array $user_input
	 * @return json
	 */
	public function get_tables_in_select_options( $user_input = array() ) {
		$tables = \apply_filters( 'bfrp_selectTables', array() );

		return wp_send_json( array( 'tables' => $tables ) );

	}

	/**
	 * Get urls
	 *
	 * @param array $user_input
	 * @return json
	 */
	public function get_urls_in_select_options( $user_input = array() ) {
		$urls = \apply_filters(
			'bfrp_urlOptions',
			array(
				'all'          => __( 'Select All', 'real-time-auto-find-and-replace' ),
				'unselect_all' => __( 'Unselect All', 'real-time-auto-find-and-replace' ),
				'post'         => __( 'Post URLs', 'real-time-auto-find-and-replace' ),
				'page'         => __( 'Page URLs', 'real-time-auto-find-and-replace' ),
				'attachment'   => __( 'Media URLs (images, attachments etc..)', 'real-time-auto-find-and-replace' ),
			)
		);

		return wp_send_json( array( 'urls' => $urls ) );
	}



}
