<?php
/**
 * Plugin Name: JSM's Force HTTP to HTTPS
 * Text Domain: jsm-force-ssl
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/jsm-force-ssl/
 * Assets URI: https://jsmoriss.github.io/jsm-force-ssl/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: No setup required - simply activate to force HTTP URLs to HTTPS using native WordPress filters and permanent redirects for best SEO.
 * Requires PHP: 7.2
 * Requires At Least: 5.2
 * Tested Up To: 5.9.3
 * Version: 3.4.1
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes and/or incompatible API changes (ie. breaking changes).
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2017-2022 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

/**
 * Define some standard WordPress constants, if not already defined. These constants can be pre-defined as false in wp-config.php
 * to turn disable a specific forced SSL feature.
 */
if ( ! defined( 'FORCE_SSL' ) ) {

	define( 'FORCE_SSL', true );
}

if ( ! defined( 'FORCE_SSL_ADMIN' ) ) {

	define( 'FORCE_SSL_ADMIN', true );
}

if ( ! defined( 'FORCE_SSL_LOGIN' ) ) {

	define( 'FORCE_SSL_LOGIN', true );
}

if ( ! class_exists( 'JsmForceSsl' ) ) {

	class JsmForceSsl {

		private static $instance = null;	// JsmForceSsl class object.

		public function __construct() {

			$min_int = defined( 'PHP_INT_MIN' ) ? PHP_INT_MIN : -2147483648;    // Since PHP v7.0.0.
			$max_int = defined( 'PHP_INT_MAX' ) ? PHP_INT_MAX : 2147483647;     // Since PHP 5.0.2.

			add_action( 'plugins_loaded', array( $this, 'init_textdomain' ) );

			/**
			 * If WordPress is hosted behind a reverse proxy that provides SSL, but is hosted itself without SSL, these
			 * options will initially send any requests into an infinite redirect loop. To avoid this, you may
			 * configure WordPress to recognize the HTTP_X_FORWARDED_PROTO header (assuming you have properly
			 * configured the reverse proxy to set that header). 
			 */
			self::maybe_set_server_https_on();

			/**
			 * WordPress should redirect back-end / admin URLs just fine, but the front-end may need some help. Hook
			 * the 'init' action and check the protocol if FORCE_SSL is true.
			 */
			if ( FORCE_SSL ) {

				add_filter( 'home_url', array( __CLASS__, 'update_single_url' ), $max_int, 4 );

				add_action( 'init', array( __CLASS__, 'force_ssl_redirect' ), $min_int );
			}

			if ( FORCE_SSL_ADMIN ) {

				add_filter( 'site_url', array( __CLASS__, 'update_single_url' ), $max_int, 4 );
			}

			/**
			 * Make sure URLs from the upload directory - like images in the Media Library - use the correct protocol.
			 */
			add_filter( 'upload_dir', array( __CLASS__, 'upload_dir_urls' ), $max_int, 1 );


			/**
			 * Adjust the URL returned by the WordPress plugins_url() function.
			 */
			add_filter( 'plugins_url', array( __CLASS__, 'update_single_url' ), $max_int, 1 );

			/**
			 * Check the content for http images.
			 */
			add_filter( 'the_content', array( __CLASS__, 'filter_content_text' ), $max_int, 1 );

			add_filter( 'widget_text', array( __CLASS__, 'filter_content_text' ), $max_int, 1 );
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init_textdomain() {

			load_plugin_textdomain( 'jsm-force-ssl', false, 'jsm-force-ssl/languages/' );
		}

		/**
		 * Redirect from HTTP to HTTPS if the current webpage URL is not HTTPS. A 301 redirect is considered a best
		 * practice when moving from HTTP to HTTPS. See https://en.wikipedia.org/wiki/HTTP_301 for more info.
		 */
		public static function force_ssl_redirect() {

			/**
			 * Make sure web server variables exist in case WP is being used from the command line.
			 */
			if ( isset( $_SERVER[ 'HTTP_HOST' ] ) && isset( $_SERVER[ 'REQUEST_URI' ] ) ) {

				if ( ! self::is_https() ) {

					wp_redirect( 'https://' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ], 301 );

					exit();
				}
			}
		}

		/**
		 * Make sure URLs from the upload directory - like images in the Media Library - use the correct protocol. Adjusts
		 * the 'url' and 'baseurl' array keys to match the current protocol being used (HTTP or HTTPS).
		 */
		public static function upload_dir_urls( $param ) {

			foreach ( array( 'url', 'baseurl' ) as $key ) {

				$param[ $key ] = self::update_single_url( $param[ $key ] );
			}

			return $param;
		}

		/**
		 * update_single_url() may be used to filter a single URL, or a filter for the get_home_url() and get_site_url()
		 * functions.
		 *
		 * $scheme can be null, 'http', 'https', 'login', 'login_post', 'admin', or 'relative'.
		 */
		public static function update_single_url( $url, $path = '', $scheme = null, $blog_id = null ) {

			if ( 0 === strpos( $url, '/' ) ) {	// Skip relative URLs.

				return $url;
			}

			if ( null === $scheme ) {

				$prot_slash = self::get_prot() . '://';

			} elseif ( 'http' === $scheme || 'https' === $scheme ) {

				$prot_slash = $scheme . '://';

			} else {	// $scheme is not http or https.

				return $url;
			}

			if ( 0 === strpos( $url, $prot_slash ) ) {	// Skip correct URLs.

				return $url;
			}

			return preg_replace( '/^([a-z]+:\/\/)/', $prot_slash, $url );
		}

		public static function filter_content_text( $content ) {

			$http_home_url = get_home_url( $blog_id = null, $path = '/', $scheme = 'http' );

			if ( false !== strpos( $content, $http_home_url ) ) {	// Optimize.

				$https_home_url = self::update_single_url( $http_home_url );

				if ( $http_home_url !== $https_home_url ) {	// Just in case.

					$content = str_replace( $http_home_url, $https_home_url, $content );
				}
			}

			return $content;
		}

		/**
		 * If WordPress is hosted behind a reverse proxy that provides SSL, but is hosted itself without SSL, these options
		 * will initially send any requests into an infinite redirect loop. To avoid this, you may configure WordPress to
		 * recognize the HTTP_X_FORWARDED_PROTO header (assuming you have properly configured the reverse proxy to set that
		 * header). 
		 */
		private static function maybe_set_server_https_on() {

			if ( ! isset( $_SERVER[ 'HTTPS' ] ) || 'on' !== $_SERVER[ 'HTTPS' ] ) {

				if ( isset( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] ) && false !== strpos( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ], 'https' ) ) {

					$_SERVER[ 'HTTPS' ] = 'on';
				}
			}
		}

		private static function get_prot( $url = '' ) {

			if ( ! empty( $url ) ) {

				return self::is_https( $url ) ? 'https' : 'http';

			} elseif ( self::is_https() ) {

				return 'https';

			} elseif ( is_admin() )  {

				if ( FORCE_SSL_ADMIN ) {

					return 'https';
				}

			} elseif ( FORCE_SSL ) {

				return 'https';
			}

			return 'http';
		}

		/**
		 * Extend the WordPress is_ssl() capabilities by also checking for proxy / load-balancing 'HTTP_X_FORWARDED_PROTO'
		 * and 'HTTP_X_FORWARDED_SSL' web server values.
		 */
		private static function is_https( $url = '' ) {

			static $local_cache = array();

			if ( isset( $local_cache[ $url ] ) ) {

				return $local_cache[ $url ];
			}

			if ( ! empty( $url ) ) {

				if ( strpos( $url, '://' ) && 'https' === parse_url( $url, PHP_URL_SCHEME ) ) {

					return $local_cache[ $url ] = true;
				}

				return $local_cache[ $url ] = false;

			} else {

				if ( is_ssl() ) {

					return $local_cache[ $url ] = true;

				/**
				 * In some environments, HTTP_X_FORWARDED_PROTO might contain a comma-separated list (ie.
				 * "http,https"), so use strpos() to check for "https" within a possible comma-separated list.
				 */
				} elseif ( isset( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] ) && false !== strpos( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ], 'https' ) ) {

					return $local_cache[ $url ] = true;

				} elseif ( isset( $_SERVER[ 'HTTP_X_FORWARDED_SSL' ] ) && 'on' === strtolower( $_SERVER[ 'HTTP_X_FORWARDED_SSL' ] ) ) {

					return $local_cache[ $url ] = true;
				}
			}

			return $local_cache[ $url ] = false;
		}
	}

	JsmForceSsl::get_instance();
}
