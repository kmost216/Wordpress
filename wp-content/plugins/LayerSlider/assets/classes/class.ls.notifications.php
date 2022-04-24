<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

/**
 * LayerSlider Notification Manager Class
 *
 *
 * @package LS_Notifications
 * @since 7.0.0
 * @author John Gera
 * @copyright Copyright (c) 2021  John Gera, George Krupa, and Kreatura Media Kft.
 */


class LS_Notifications {

	private static $data = [];
	private static $notifications = [];
	private static $inlineNotifications = [];


	private function __construct() {}


	public static function init() {

		add_action('admin_init', function() {
			add_action( 'wp_ajax_ls_clear_notifications', function() { self::markAllAsRead(); });
		});
	}

	public static function gatherNotifications() {

		// Get last read date. Falls back to the date of installation.
		if( ! $date = get_user_meta( get_current_user_id(), 'ls-read-notifications-date', true ) ) {

			if( ! $date = get_option('ls-date-installed', false ) ) {
				LS_Notifications::markAllAsRead();
				$date = time();
			}
		}

		self::$data['unread-count'] 	= 0;
		self::$data['last-read-date'] 	= $date;

		// Gather notifications
		self::_gatherRemoteNotifications();
		self::_gatherDynamicNotifications();
	}


	public static function inlineNotifications() {
		return self::$inlineNotifications;
	}


	public static function bellNotifications() {
		return self::$notifications;
	}


	public static function unreadCount() {
		return self::$data['unread-count'];
	}


	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

	private static function markAllAsRead() {
		update_user_meta( get_current_user_id(), 'ls-read-notifications-date', time() );
	}


	private static function _gatherRemoteNotifications() {


		$notifications = LS_RemoteData::get('notifications');

		if( ! empty( $notifications ) && is_array( $notifications ) ) {

			foreach( $notifications as $notification ) {
				if( ! empty( $notification['bell'] ) ) {

					if( self::_filterNotification( $notification['bell'] ) ) {
						if( $data = self::_processNotification( $notification['bell'] ) ) {
							self::$notifications[] = $data;
						}
					}
				}

				if( ! empty( $notification['inline'] ) ) {
					if( self::_filterNotification( $notification['inline'] ) ) {
						if( $data = self::_processNotification( $notification['inline'], 'inline' ) ) {
							self::$inlineNotifications[] = $data;
						}
					}
				}
			}
		}
	}


	private static function _gatherDynamicNotifications() {

		self::_checkForAutoActivation();
		self::_checkForPluginUpdate();
		self::_checkForSystemIssues();


		if( get_option('ls-show-canceled_activation_notice', 0) ) {
			self::_checkForLicenseIssues();

		} else {
			self::_checkForPromotions();
		}

	}

	private static function _checkForAutoActivation() {

		$date = get_option('ls-auto-activation-date', 0 );

		if( ! empty( $date ) ) {

			self::prependBellNotification([
				'date' 			=> $date,
				'icon' 			=> 'key',
				'title' 		=>  __('Your license was registered', 'LayerSlider'),
				'message' 		=> __('We’ve automatically registered your license to this site for your convenience, so you don’t have to bother with license keys. You can freely migrate your license if you’d like to use it somewhere else by de-registering it or visiting our account management site.', 'LayerSlider')
			]);
		}
	}


	private static function _checkForPluginUpdate() {

		$update = get_option( 'layerslider_update_info', false );

		if( ! empty( $update ) ) {

			$updateVersion 		= $update->basic->version;
			$updateVersionDate 	= get_option( 'ls-latest-version-date', date('Y-m-d') );
			$inlineMessages 	= [];

			if( version_compare( $updateVersion, LS_PLUGIN_VERSION, '>' ) ) {

				// Error checking
				$php_version 	= phpversion();
				$requires_php 	= $update->basic->requires_php;

				$wp_version  	= get_bloginfo('version');
				$requires_wp 	= $update->basic->requires;

				$php_issue 		= version_compare( $php_version, $requires_php, '<' );
				$wp_issue 		= version_compare( $wp_version, $requires_wp, '<' );
				$any_issue 		= ( $php_issue || $wp_issue );

				if( $any_issue ) {
					if( $php_issue ) {
						$inlineMessages[] = sprintf( __('This update requires PHP %s or greater. You have PHP %s. %sLearn more about updating PHP%s', 'LayerSlider'), $requires_php, $php_version, '<a href="https://wordpress.org/support/update-php/" target="_blank">', '</a>' );
					}

					if( $wp_issue ) {
						$inlineMessages[] = sprintf( __('This update requires WordPress %s or greater. You have WordPress %s. %sLearn more about updating WordPress%s', 'LayerSlider'), $requires_wp, $wp_version, '<a href="https://wordpress.org/about/requirements/" target="_blank">', '</a>' );
					}
				} else {
					$inlineMessages[] = $update->basic->upgrade_notice;
				}

				// Bell notification
				self::prependBellNotification([
					'date' 			=> $updateVersionDate,
					'icon' 			=> 'sync-alt',
					'selectable' 	=> $any_issue ? false : true,
					'class' 		=> $any_issue ? '' : 'ls-install-plugin-update',
					'title' 		=>  __('New Version Available', 'LayerSlider'),
					'message' 		=> sprintf( __('Update LayerSlider to the latest version to receive new features, improvements, bug and security fixes. You have version %s. The latest release is %s.', 'LayerSlider'), LS_PLUGIN_VERSION, $updateVersion ),
					'url' 			=> $any_issue ? '' : wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin='.LS_PLUGIN_BASE), 'upgrade-plugin_'.LS_PLUGIN_BASE)
				]);

				// Inline notification
				self::prependInlineNotification([
					'date' 			=> $updateVersionDate,
					'icon' 			=> 'sync-alt',
					'title' 		=> __('An update is available for LayerSlider!', 'LayerSlider'),
					'message' 		=> implode('<br>', $inlineMessages ),
					'buttons' 		=> [[
						'text' 		=> __('Install Now', 'LayerSlider'),
						'class' 	=> $any_issue ? 'ls-button-disabled' : 'ls-install-plugin-update',
						'href' 		=> $any_issue ? '' : wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin='.LS_PLUGIN_BASE), 'upgrade-plugin_'.LS_PLUGIN_BASE)
					]]
				]);

				$GLOBALS['LS_hasPluginUpdate'] = true;
			}

		}
	}


	private static function _checkForSystemIssues() {


		if( ! class_exists('DOMDocument') ) {

			// Inline notification
			self::prependInlineNotification([
				'icon' 			=> 'exclamation-triangle',
				'title' 		=> __('Server configuration issues detected!', 'LayerSlider'),
				'message' 		=> sprintf(__('LayerSlider requires PHP’s DOM extension. Please contact with your server hosting provider to resolve this issue as it will likely prevent LayerSlider from functioning properly. %sThis issue could result a blank page in slider builder.%s Check System Status for more information and comprehensive test about your server environment.', 'LayerSlider'), '<strong>', '</strong>' ),
				'fixed'			=> true,
				'buttons' 		=> [[
					'text' 		=> __('System Status', 'LayerSlider'),
					'href' 		=> admin_url('admin.php?page=layerslider&section=system-status')
				]]
			]);
		}
	}


	private static function _checkForLicenseIssues() {

		// Inline notification
		self::prependInlineNotification([
			'icon' 		=> 'key',
			'title' 	=> __('Re-register your license key on this site', 'LayerSlider'),
			'message' 	=> __('You’ve previously used your license key on this site to receive live plugin updates, add-ons, exclusive features, premium templates, and more. However, it seems that your license is now registered to a different site or is no longer valid. These benefits are unavailable until you re-enter a valid license key.', 'LayerSlider'),
			'fixed'		=> true,
			'buttons' 	=> [
				[
					'text' 	=> __('What’s this?', 'LayerSlider'),
					'class' => 'ls-show-canceled-activation-modal'
				],[
					'text' 	=> __('OK, I understand', 'LayerSlider'),
					'href' 	=> wp_nonce_url( admin_url('admin.php?page=layerslider&action=hide-canceled-activation-notice' ), 'hide-canceled-activation-notice')
				]
			]
		]);

		update_user_meta( get_current_user_id(), 'ls-show-support-notice-timestamp', time() - WEEK_IN_SECONDS * 3 );
	}


	private static function _checkForPromotions() {

		if( LS_Config::get('notices') && ! LS_Config::isActivatedSite() ) {

			// Make sure to set an initial timestamp for the notice.
			if( ! $lastCheck = get_user_meta( get_current_user_id(), 'ls-show-support-notice-timestamp', true ) ) {
				$lastCheck = time() - WEEK_IN_SECONDS * 3;
				update_user_meta( get_current_user_id(), 'ls-show-support-notice-timestamp', $lastCheck );
			}

			if( time() - ( DAY_IN_SECONDS * 31 ) > $lastCheck ) {

				// Inline notification
				self::prependInlineNotification([
					'icon' 		=> 'unlock-alt',
					'title' 	=> __('Unlock the full potential of LayerSlider', 'LayerSlider'),
					'message' 	=> __('Register your LayerSlider license to unlock Add-Ons, premium features, project templates, and other exclusive content & services. Receive live plugin updates with 1-Click installation (including optional early access releases) and premium support.', 'LayerSlider'),
					'fixed'		=> true,
					'buttons' 	=> [
						[
							'text' 	=> __('Learn More', 'LayerSlider'),
							'href' 	=> 'https://layerslider.com/documentation/#activation',
							'target' => '_blank'
						],[
							'text' 	=> __('Dismiss', 'LayerSlider'),
							'href' 	=> wp_nonce_url( admin_url( 'admin.php?page=layerslider&action=hide-support-notice' ), 'hide-support-notice')
						]
					]
				]);
			}
		}

	}


	private static function _filterNotification( $data ) {

		// Check min version (if any)
		if( ! empty( $data['min_version'] ) ) {
			if( version_compare( LS_PLUGIN_VERSION, $data['min_version'], '<' ) ) {
				return;
			}
		}

		// Check max version (if any)
		if( ! empty( $data['max_version'] ) ) {
			if( version_compare( LS_PLUGIN_VERSION, $data['max_version'], '>' ) ) {
				return;
			}
		}

		// Check activation state
		if( ! empty( $data['unactivated'] ) ) {
			if( LS_Config::isActivatedSite() ) {
				return;
			}
		}

		// Check license key
		if( ! empty( $data['license_key'] ) ) {
			if( false === strpos( $data['license_key'], LS_Config::getLicenseKey() ) ) {
				return;
			}
		}

		// Check theme
		if( ! empty( $data['theme'] ) ) {
			if( $data['theme'] !==  get_template() ) {
				return;
			}
		}


		// Passed all tests, return the notification object
		return $data;
	}


	private static function _isUnreadNotification( $data ) {
		return ( $data['date'] > self::$data['last-read-date'] );
	}


	private static function _processNotification( $data, $type = 'bell' ) {

		$data['icon'] = ! empty( $data['icon'] ) ? $data['icon'] : 'info-circle';
		$data['icon'] = ( strlen( $data['icon'] ) > 50 ) ? $data['icon'] : lsGetSVGIcon( $data['icon'] );

		if( ! empty( $data['date'] ) ) {
			if( ! is_numeric( $data['date'] ) ) {
				$data['date'] = strtotime( $data['date'] );
			}
		} else {
			$data['date'] = 0;
		}

		// Bell notification
		if( $type === 'bell' ) {

			if( self::_isUnreadNotification( $data  ) ) {
				self::$data['unread-count']++;
				$data['unread'] = true;
			}

			if( ! empty( $data['url'] ) ) {
				$data['selectable'] = true;
			}

		// Inline notification
		} elseif( ! empty( $data['date'] ) ) {

			if( ! self::_isUnreadNotification( $data  ) ) {
				return false;
			}
		}


		return $data;
	}

	private static function prependBellNotification( $data ) {

		if( $notification = self::_processNotification( $data, 'bell' ) ) {
			array_unshift( self::$notifications, $notification );
		}
	}

	private static function prependInlineNotification( $data ) {

		if( $notification = self::_processNotification( $data, 'inline' ) ) {
			array_unshift( self::$inlineNotifications, $notification );
		}
	}

}