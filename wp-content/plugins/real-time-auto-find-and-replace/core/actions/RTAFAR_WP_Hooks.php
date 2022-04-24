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

use RealTimeAutoFindReplace\lib\Util;
use RealTimeAutoFindReplace\admin\functions\Masking;
use RealTimeAutoFindReplace\install\Activate;

class RTAFAR_WP_Hooks {

	private $WP_Ins;

	function __construct() {

		/*** add settings link */
		add_filter( 'plugin_action_links_' . CS_RTAFAR_PLUGIN_IDENTIFIER, array( __class__, 'rtafarSettingsLink' ) );

		add_action( 'template_redirect', array( $this, 'rtafar_filter_contents' ) );

		/*** add function after upgrade process complete */
		add_action( 'upgrader_process_complete', array( __class__, 'rtafarAfterUpgrade' ), 10, 2 );
	}

	/**
	 * Filter content
	 *
	 * @return void
	 */
	public function rtafar_filter_contents() {
		$replace_rules = Masking::get_rules( 'all' );

		return ob_start(
			function( $buffer ) use ( $replace_rules ) {
				return $this->get_filtered_content( $buffer, $replace_rules );
			}
		);
	}

	/**
	 * Filter content
	 *
	 * @param [type] $buffer
	 * @return void
	 */
	private function get_filtered_content( $buffer, $replace_rules ) {
		if ( $replace_rules ) {
			foreach ( $replace_rules as $item ) {
				// check bypass filter rule
				if ( has_filter( 'bfrp_add_bypass_rule' ) && isset( $item->type ) && $item->type == 'plain' ) {
					$buffer = apply_filters( 'bfrp_add_bypass_rule', $item, $buffer, false );
				}

				$buffer = $this->replace( $item, $buffer );

				if ( has_filter( 'bfrp_remove_bypass_rule' ) && isset( $item->type ) && $item->type == 'plain' ) {
					$buffer = apply_filters( 'bfrp_remove_bypass_rule', $item, $buffer, false );
				}
			}
		}

		return $buffer;
	}


	/**
	 * Replace
	 *
	 * @param [type]  $item
	 * @param [type]  $buffer
	 * @param boolean $find
	 * @return void
	 */
	private function replace( $item, $buffer, $find = false ) {
		$find = false !== $find ? $find : $item->find;

		if ( $item->type == 'regex' ) {
			if ( \has_filter( 'bfrp_masking_plain_filter' ) ) {
				return \apply_filters( 'bfrp_masking_plain_filter', $item, $find, $buffer );
			} else {
				$find    = '#' . Util::cs_stripslashes( $find ) . '#';
				$replace = Util::cs_stripslashes( $item->replace );
				return preg_replace( $find, $replace, $buffer );
			}
		} elseif ( $item->type == 'advance_regex' ) {
			if ( \has_filter( 'bfrp_advance_regex_mask' ) ) {
				return \apply_filters( 'bfrp_advance_regex_mask', $find, $item->replace, $buffer );
			} else {
				return $buffer;
			}
		} else {
			if ( \has_filter( 'bfrp_masking_plain_filter' ) ) {
				return \apply_filters( 'bfrp_masking_plain_filter', $item, $find, $buffer );
			} else {
				return \str_replace( Util::cs_stripslashes( $find ), Util::cs_stripslashes( $item->replace ), $buffer );
			}
		}

	}

	/**
	 * Add settings links
	 *
	 * @param [type] $links
	 * @return void
	 */
	public static function rtafarSettingsLink( $links ) {
		$links[] = '<a href="' .
		Util::cs_generate_admin_url( 'cs-all-masking-rules' ) .
		'">' . __( 'All Rules' ) . '</a>';
		$links[] = '<a href="' .
		Util::cs_generate_admin_url( 'cs-add-replacement-rule' ) .
		'">' . __( 'Add New Rule' ) . '</a>';

		return $links;
	}

	/**
	 * Add function after
	 * plugin upgrade
	 *
	 * @return void
	 */
	public static function rtafarAfterUpgrade( $upgrader_object, $options ) {
		if ( isset( $options['action'] ) && $options['action'] == 'update' &&
			 isset( $options['type'] ) && $options['type'] == 'plugin' &&
			 isset( $options['plugins'] )
			 ) {

			foreach ( $options['plugins'] as $eachPlugin ) {
				if ( $eachPlugin == CS_RTAFAR_PLUGIN_IDENTIFIER ) {
					Activate::onUpgrade();
				}
			}
		}
	}

}

