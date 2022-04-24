<?php namespace RealTimeAutoFindReplace\actions;

/**
 * Class: Register custom menu
 *
 * @package Action
 * @since 1.0.0
 * @author M.Tuhin <info@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	die();
}

use RealTimeAutoFindReplace\admin\functions\ProActions;

class RTAFAR_Hooks {

	function __construct() {

		/*** update url options */
		add_filter( 'bfrp_urlOptions', array( $this, 'getAllProUrlOptions' ), 10 );

		/*** table list options */
		add_filter( 'bfrp_selectTables', array( $this, 'getAllTblList' ), 10 );

	}

	/**
	 * Get url types
	 *
	 * @param [type] $args
	 * @return void
	 */
	public function getAllProUrlOptions( $args ) {
		return ProActions::getAllProUrlOptions( $args, 'selectOptions' );
	}

	/**
	 * Get all table list
	 *
	 * @param [type] $args
	 * @return void
	 */
	public function getAllTblList( $args ) {
		return ProActions::getAllTblList( $args );
	}

}


