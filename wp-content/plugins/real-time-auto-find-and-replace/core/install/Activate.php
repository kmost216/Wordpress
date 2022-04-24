<?php namespace RealTimeAutoFindReplace\install;

/**
 * Installation
 *
 * @package Install
 * @since 1.0.0
 * @author M.Tuhin <info@codesolz.com>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	exit;
}

use RealTimeAutoFindReplace\admin\functions\Masking;

class Activate {


	/**
	 * Install DB
	 *
	 * @return void
	 */
	public static function on_activate() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		$sqls = array(
			"CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rtafar_rules`(
				`id` int(11) NOT NULL auto_increment,
				`find` text,
				`replace` mediumtext,
				`type` varchar(56),
				`delay` float,
				`where_to_replace` varchar(128),
				PRIMARY KEY ( `id`)
				) $charset_collate",
		);

		foreach ( $sqls as $sql ) {
			if ( $wpdb->query( $sql ) === false ) {
				continue;
			}
		}

		// add db version to db
		add_option( 'rtafar_db_version', CS_RTAFAR_DB_VERSION );
		add_option( 'rtafar_plugin_version', CS_RTAFAR_VERSION );
		add_option( 'rtafar_plugin_install_date', date( 'Y-m-d H:i:s' ) );
	}

	/**
	 * Check DB Status
	 *
	 * @return void
	 */
	public static function check_db_status() {
		$import_old_settings          = false;
		$get_installed_db_version     = get_site_option( 'rtafar_db_version' );
		$get_installed_plugin_version = get_site_option( 'rtafar_plugin_version' );
		if ( empty( $get_installed_db_version ) ) {
			self::on_activate();
			$import_old_settings = true;
		} elseif ( \version_compare( $get_installed_db_version, CS_RTAFAR_DB_VERSION, '!=' ) ) {

			global $wpdb;

			$update_sqls = array();

			if ( \version_compare( $get_installed_db_version, '1.0.1', '<' ) ) {
				$update_sqls = array(
					"ALTER TABLE `{$wpdb->prefix}rtafar_rules` ADD COLUMN delay FLOAT DEFAULT 0 AFTER type",
					"ALTER TABLE `{$wpdb->prefix}rtafar_rules` ADD COLUMN tag_selector mediumtext AFTER delay",
				);
			}

			if ( \version_compare( $get_installed_db_version, '1.0.2', '<' ) ) {
				$update_sqls = array_merge_recursive(
					$update_sqls,
					array(
						"ALTER TABLE `{$wpdb->prefix}rtafar_rules` DROP COLUMN tag_selector",
					)
				);
			}

			// update db
			if ( ! empty( $update_sqls ) ) {
				foreach ( $update_sqls as $sql ) {
					if ( $wpdb->query( $sql ) === false ) {
						continue;
					}
				}
			}

			// update plugin db version
			update_option( 'rtafar_db_version', CS_RTAFAR_DB_VERSION );

		}

		if ( true === $import_old_settings ) {
			self::import_old_settings();
		}

		// update plugin version
		update_option( 'rtafar_plugin_version', CS_RTAFAR_VERSION );

	}

	/**
	 * Import old settings
	 *
	 * @return void
	 */
	private static function import_old_settings() {
		$get_Rtfar = get_option( 'rtafar_settings' );
		if ( ! empty( $get_Rtfar ) && is_array( $get_Rtfar ) ) {
			$Masking = new Masking();
			foreach ( $get_Rtfar as $find => $replace ) {
				$Masking->insert_masking_rules( $find, $replace, 'plain', 'all', '' );
			}
			delete_option( 'rtafar_settings' );
		}

		return true;
	}


	/**
	 * Remove custom urls on deactivate
	 *
	 * @return void
	 */
	public static function on_deactivate() {
		// remove notice status
		delete_option( CS_NOTICE_ID . 'ed_Activated' );
		delete_option( CS_NOTICE_ID . 'ed_Feedback' );
		return true;
	}

	/**
	 * show notices
	 *
	 * @return void
	 */
	public static function onUpgrade() {
		// remove notice status
		if ( ! get_option( CS_NOTICE_ID . 'ed_Feedback_offPerm' ) ) {
			delete_option( CS_NOTICE_ID . 'ed_Feedback' );
		}

		return true;
	}


}
