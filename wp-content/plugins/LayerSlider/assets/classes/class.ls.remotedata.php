<?php

class LS_RemoteData {

	private static $data;
	private static $sources;


	private function __construct() {

	}


	public static function init() {


		self::$sources = [

			'general' 	=> [
				'url' 		=> LS_REPO_BASE_URL.'/data/ls-wp/',
				'dataKey' 	=> 'ls-remote-data',
				'updateKey' => 'ls-remote-data-updated',
				'interval' 	=> HOUR_IN_SECONDS * 6
			],

			'fonts' 	=> [
				'url' 		=> 'https://repository.kreaturamedia.com/googlefonts/fonts.json',
				'dataKey' 	=> 'ls-google-fonts-data',
				'updateKey' => 'ls-google-fonts-data-updated',
				'interval' 	=> WEEK_IN_SECONDS

			]
		];

		self::checkData();
	}


	public static function get( $handle = '', $default = '', $source = 'general' ) {

		// Get data if not present
		if( empty( self::$data[ $source ] ) ) {
			self::$data[ $source ] = get_option( self::$sources[ $source ]['dataKey'], [] );
		}

		// Send back data by handle
		if( ! empty( $handle ) && isset( self::$data[ $source ][ $handle ] ) ) {
			return self::$data[ $source ][ $handle ];
		}

		return $default;
	}


	public static function update( $source = 'general' ) {

		self::updateSource( self::$sources[ $source ] );
	}


	public static function lastUpdated( $source = 'general' ) {
		return get_option( self::$sources[ $source ]['updateKey'], 0 );
	}



	public static function getAvailableVersion() {

		$updateVersion = get_option( 'ls-latest-version', LS_PLUGIN_VERSION );
		$remoteVersion = self::get( 'latest-version', LS_PLUGIN_VERSION );

		if( version_compare( $remoteVersion, $updateVersion, '>=' ) ) {
			return $remoteVersion;
		}

		return $updateVersion;
	}


	// ------------------------------------

	private static function checkData() {

		if( ! empty( self::$sources ) ) {
			foreach( self::$sources as $source ) {

				$lastUpdated = get_option( $source['updateKey'], 0 );

				if( $lastUpdated < time() - $source['interval'] ) {
					self::updateSource( $source );
				}
			}
		}
	}

	private static function updateSource( $source ) {

		$data 	= wp_remote_retrieve_body( wp_remote_get( $source['url'] ) );
		$data 	= ! empty( $data ) ? $data : '{}';
		$json 	= json_decode( $data, true );

		if( ! empty( $json ) ) {

			update_option( $source['dataKey'], $json, false );
			update_option( $source['updateKey'], time(), false );
		}
	}

}