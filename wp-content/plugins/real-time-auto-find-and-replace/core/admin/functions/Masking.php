<?php namespace RealTimeAutoFindReplace\admin\functions;

/**
 * Masking Class
 *
 * @package Funcitons
 * @since 1.0.0
 * @author M.Tuhin <info@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	exit;
}

use RealTimeAutoFindReplace\lib\Util;


class Masking {

	private static $bypassID = '$buffer = ';

	/**
	 * Add Masking Rules
	 *
	 * @param [type] $user_query
	 * @return void
	 */
	public function add_masking_rule( $user_query ) {

		$res_type 	   = isset( $user_query['res_no_json'] ) ? $user_query['res_no_json'] : '';
		$user_query    = $user_query['cs_masking_rule'];
		$find          = isset( $user_query['find'] ) ? $user_query['find'] : '';
		$replace       = isset( $user_query['replace'] ) ? $user_query['replace'] : '';
		$type          = isset( $user_query['type'] ) ? $user_query['type'] : '';
		$replace_where = isset( $user_query['where_to_replace'] ) ? $user_query['where_to_replace'] : '';
		$delay_time    = isset( $user_query['delay'] ) ? (float) $user_query['delay'] : '';

		$id = isset( $user_query['id'] ) ? $user_query['id'] : '';
		$msg = $this->insert_masking_rules( $find, $replace, $type, $replace_where, $id, $delay_time, $user_query );

		if( true === $res_type ){
			return array(
					'status'       => true,
					'action_type'  => trim( $msg ),
				);
		}

		return wp_send_json(
			array(
				'status'       => true,
				'title'        => 'Success!',
				'text'         => __( "Thank you! replacement rule {$msg} successfully.", 'real-time-auto-find-and-replace' ),
				'redirect_url' => admin_url( 'admin.php?page=cs-all-masking-rules' ),
			)
		);
	}

	/**
	 * Add Masking Rules
	 *
	 * @return void
	 */
	public function insert_masking_rules( $find, $replace, $type, $replace_where, $id = '', $delay_time, $user_query ) {
		global $wpdb;

		if ( $type == 'regex' || $type == 'advance_regex' ) {
			$find    = Util::cs_addslashes( $find );
			$replace = Util::cs_addslashes( $replace );
		} else {
			$find    = Util::check_evil_script( $find );
			$replace = Util::check_evil_script( $replace );
		}

		$userData = array(
			'find'             => $find,
			'replace'          => $replace,
			'type'             => Util::check_evil_script( $type ),
			'where_to_replace' => Util::check_evil_script( $replace_where ),
			'delay'            => $delay_time,
		);

		$isExists = $wpdb->get_var(
			$wpdb->prepare(
				"select id from {$wpdb->prefix}rtafar_rules where find = '%s' and type = '%s'",
				$find,
				$type
			)
		);

		$msg = ' added ';
		if ( $isExists || ! empty( $id ) ) {
			$isExists = $id;
			$msg      = ' updated ';
			$wpdb->update( "{$wpdb->prefix}rtafar_rules", $userData, array( 'id' => $isExists ) );
		} else {
			$wpdb->insert( "{$wpdb->prefix}rtafar_rules", $userData );
			$isExists = $wpdb->insert_id;
		}

		// add action
		do_action( 'bfrp_save_masking_rule', $isExists, $user_query );

		return $msg;
	}

	/**
	 * Get rules
	 *
	 * @return void
	 */
	public static function get_rules( $where_to_replace = 'all', $id = '', $rule_type = false, $adminCall = false ) {
		global $wpdb;

		$where_id = '';
		if ( $id ) {
			$where_id = "and id = {$id}";
		}

		$ruleType = '';

		if ( false === $adminCall ) {
			if ( $rule_type ) {
				$ruleType = " and type = '{$rule_type}' ";
			} else {
				$ruleType = " and type != 'ajaxContent' and type != 'filterShortCodes' and type != 'filterComment' and type != 'filterOldComments' and type != 'filterAutoPost' "; // get all but not ajaxRules
			}
		}

		$sql = "SELECT * from `{$wpdb->prefix}rtafar_rules` as r where where_to_replace = '{$where_to_replace}' {$where_id} {$ruleType} order by id asc";

		if ( has_filter( 'bfrp_get_rules_sql' ) && ! is_admin() ) {
			$fsql = apply_filters(
				'bfrp_get_rules_sql',
				array(
					'where_to_replace' => $where_to_replace,
					'where_id'         => $where_id,
					'ruleType'         => $ruleType,
				)
			);

			$sql = false === $fsql ? $sql : $fsql;
		}

		$get_rules = $wpdb->get_results( $sql );

		if ( $get_rules ) {
			return $get_rules;
		}
		return false;
	}



}


