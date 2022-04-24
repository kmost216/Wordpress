<?php

class LS_Uninstaller {

	public function __construct() {}


	public function erasePluginData() {

		$this->removeDBTables();
		$this->removeOptions();
		$this->removeUserMeta();
		$this->removeUploads();
		$this->removeDebugAccount();
	}


	public function removeDBTables() {

		global $wpdb;

		$wpdb->query("DROP TABLE {$wpdb->prefix}layerslider;");
		$wpdb->query("DROP TABLE {$wpdb->prefix}layerslider_drafts;");
		$wpdb->query("DROP TABLE {$wpdb->prefix}layerslider_revisions;");
	}


	public function removeOptions() {

		$options = [

			// Installation
			'ls-installed',
			'ls-date-installed',
			'ls-plugin-version',
			'ls-db-version',
			'layerslider_do_activation_redirect',

			// Plugin settings
			'ls-screen-options',
			'layerslider_custom_capability',
			'ls_custom_locale',
			'ls-google-fonts',
			'ls-google-font-scripts',
			'ls_use_cache',
			'ls_include_at_footer',
			'ls_conditional_script_loading',
			'ls_concatenate_output',
			'ls_load_all_js_files',
			'ls_gsap_sandboxing',
			'ls_defer_scripts',
			'ls_use_loading_attribute',
			'ls_use_custom_jquery',
			'ls_clear_3rd_party_caches',
			'ls_admin_no_conflict_mode',
			'ls_rocketscript_ignore',
			'ls_suppress_debug_info',
			'ls_tinymce_helper',
			'ls_gutenberg_block',
			'ls_elementor_widget',
			'ls_put_js_to_body',
			'ls_ls_scripts_priority',
			'ls_use_srcset',
			'ls_enhanced_lazy_load',

			// Updates & Services
			'ls-share-displayed',
			'ls-last-update-notification',
			'ls-show-support-notice',
			'ls-show-support-notice-timestamp',
			'ls-show-canceled_activation_notice',
			'layerslider_cancellation_update_info',
			'layerslider-release-channel',
			'layerslider-authorized-site',
			'layerslider-purchase-code',
			'layerslider-activation-id',
			'layerslider_update_info',
			'ls-auto-activation-date',
			'ls-disable-auto-activation',
			'ls-latest-version',
			'ls-latest-version-date',
			'ls-store-data',
			'ls-store-last-updated',
			'ls-important-notice',
			'ls-release-log-last-updated',
			'ls-google-fonts-data',
			'ls-google-fonts-data-updated',
			'ls-remote-data-updated',
			'ls-remote-data',
			'ls-p-url',

			// GDPR
			'layerslider-gdpr-consent',
			'layerslider-google-fonts-enabled',
			'layerslider-aviary-enabled',

			// Revisions
			'ls-revisions-enabled',
			'ls-revisions-limit',
			'ls-revisions-interval',

			// Popup Index
			'ls-popup-index',

			// Legacy
			'ls-collapsed-boxes',
			'layerslider-validated',
			'ls-show-revalidation-notice'
		];

		foreach( $options as $key ) {
			delete_option( $key );
		}
	}


	public function removeUserMeta() {

		$entries = [
			'ls-show-support-notice-timestamp',
			'layerslider_help_wp_pointer',
			'layerslider_builder_help_wp_pointer',
			'layerslider_beta_program',
			'ls-sliders-layout',
			'ls-store-last-viewed',
			'ls-pagination-limit',
			'ls-editor-settings',
			'ls-read-notifications-date',
			'ls-v7-welcome-screen-date'
		];

		foreach( $entries as $key ) {
			delete_metadata('user', 0, $key, '', true);
		}
	}


	public function removeUploads() {

		global $wpdb;
		global $wp_filesystem;
		WP_Filesystem();

		$uploads 	= wp_upload_dir();
		$uploadsDir = trailingslashit($uploads['basedir']);

		foreach( glob($uploadsDir.'layerslider/*/*') as $key => $img ) {

			$imgPath  = explode( parse_url( $uploadsDir, PHP_URL_PATH ), $img );
			$attachs = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $imgPath[1] ) );

			if( ! empty( $attachs ) ) {
				foreach( $attachs as $attachID ) {
					if( ! empty($attachID) ) {
						wp_delete_attachment( $attachID, true );
					}
				}
			}
		}


		$wp_filesystem->rmdir( $uploadsDir.'layerslider', true );
		$wp_filesystem->delete( $uploadsDir.'layerslider.custom.css' );
		$wp_filesystem->delete( $uploadsDir.'layerslider.custom.transitions.js' );
	}



	public function removeDebugAccount() {

		if( $userID = username_exists('KreaturaSupport') ) {
			wp_delete_user( $userID );
		}
	}


	public function deactivatePlugin() {
		deactivate_plugins( LS_PLUGIN_BASE, false, false );
	}
}