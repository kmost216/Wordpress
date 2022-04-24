<?php namespace RealTimeAutoFindReplace\lib;

/**
 * Util Functions
 *
 * @package Library
 * @since 1.0.0
 * @author CodeSolz <customer-service@codesolz.com>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	exit;
}


class Util {

	/**
	 * Encode Html Entites
	 *
	 * @param type $str
	 * @return type
	 */
	public static function encode_html_chars( $str ) {
		return esc_html( $str );
	}

	/**
	 * markup tagline
	 *
	 * @param type $tagline
	 */
	public static function markup_tag( $tagline ) {
		 echo sprintf( "\n<!--%s - %s-->\n", CS_RTAFAR_PLUGIN_NAME, $tagline );
	}

	/**
	 * Check Evil Script Into User Input
	 *
	 * @param array|string $user_input
	 * @return type
	 */
	public static function check_evil_script( $user_input, $textarea = false ) {
		if ( is_array( $user_input ) ) {
			$user_input = self::cs_sanitize_recursive( $user_input, $textarea );
		} else {
			$user_input = self::cs_sanitize_field( $user_input, $textarea );
		}
		return $user_input;
	}

	/**
	 * Sanitize recursive array
	 *
	 * @param [type]  $user_input
	 * @param boolean $textarea
	 * @return void
	 */
	public static function cs_sanitize_recursive( $user_input, $textarea = false ) {
		foreach ( $user_input as $key => $value ) {
			if ( is_array( $value ) ) {
				$value = self::cs_sanitize_recursive( $value, $textarea );
			} else {
				$value = self::cs_sanitize_field( $value, $textarea );
			}
		}

		return $user_input;
	}

	/**
	 * Sanitize field
	 *
	 * @param [type] $user_input
	 * @param [type] $textarea
	 * @return void
	 */
	public static function cs_sanitize_field( $user_input, $textarea = false ) {
		if ( $textarea === true ) {
			$user_input = \sanitize_textarea_field( $user_input );
		} else {
			$user_input = \sanitize_text_field( $user_input );
		}
		return self::cs_stripslashes( $user_input );
	}

	/**
	 * Add slashes
	 *
	 * @param [type] $value
	 * @return void
	 */
	public static function cs_addslashes( $value ) {
		return \wp_slash( \stripslashes_deep( trim( $value ) ) );
	}

	/**
	 * Strip slashes
	 *
	 * @param [type] $value
	 * @return void
	 */
	public static function cs_esc_html( $value ) {
		return \esc_html( \stripslashes_deep( trim( $value ) ) );
	}

	/**
	 * Print strings
	 *
	 * @param [type] $value
	 * @return void
	 */
	public static function cs_sanitize_prnt_str( $value ) {
		return \esc_attr( self::cs_esc_html( $value ) );
	}

	/**
	 * Strip slashes
	 *
	 * @param [type] $value
	 * @return void
	 */
	public static function cs_stripslashes( $value ) {
		return \stripslashes_deep( trim( $value ) );
	}

	/**
	 * generate admin page url
	 *
	 * @return string
	 */
	public static function cs_generate_admin_url( $page_name ) {
		if ( empty( $page_name ) ) {
			return '';
		}

		return \admin_url( "admin.php?page={$page_name}" );
	}

	/**
	 * Get back to link / button
	 */
	public static function generate_back_btn( $back_to, $class ) {
		$back_url = self::cs_generate_admin_url( $back_to );
		return "<a href='{$back_url}' class='{$class}'>" . __( '<< Back', 'real-time-auto-find-and-replace' ) . '</a>';
	}

	/**
	 * Insert Word in a speific position
	 *
	 * @param [type] $val
	 * @param [type] $pos
	 * @param [type] $newWord
	 * @return void
	 */
	public static function insertWordInStringPos( $val, $newWord, $pos ) {
		return \substr_replace( $val, $newWord, $pos, 0 );
	}

	/**
	 * Char Count
	 *
	 * @param [type] $word
	 * @return void
	 */
	public static function charCount( $word ) {
		return (int) \strlen( $word );
	}

	/**
	 * Sanitize external link
	 *
	 * @param [type] $link
	 * @return void
	 */
	public static function cs_get_pro_link( $link ) {
		static $theme_name = false;

		if ( ! $theme_name ) {
			$theme_obj = wp_get_theme();
			if ( $theme_obj->parent() ) {
				$theme_name = $theme_obj->parent()->get( 'Name' );
			} else {
				$theme_name = $theme_obj->get( 'Name' );
			}

			$theme_name = \sanitize_key( $theme_name );
		}

		$link = \add_query_arg( 'utm_term', $theme_name, $link );

		return $link;
	}

	/**
	 * Check has pro or not
	 *
	 * @return boolean
	 */
	public static function has_pro() {
		$v = \get_option( 'bfarp_plugin_version' );
		return empty( $v ) ? false : true;
	}

	/**
	 * Wp remote call
	 *
	 * @param type $url
	 * @param type $method
	 * @return type
	 */
	public static function remote_call( $url, $method = 'GET', $params = array() ) {
		if ( $method == 'GET' ) {
			$response = \wp_remote_get(
				$url,
				array(
					'timeout'     => 120,
					'httpversion' => '1.1',
				)
			);
		} elseif ( $method == 'POST' ) {
			$response = \wp_remote_post(
				$url,
				array(
					'method'      => 'POST',
					'timeout'     => 120,
					'httpversion' => '1.1',
					'body'        => isset( $params['body'] ) ? $params['body'] : '',
				)
			);
		}

		if ( is_wp_error( $response ) ) {
			return array(
				'error'    => true,
				'response' => $response->get_error_message(),
			);
		}

		return \wp_remote_retrieve_body( $response );
	}

	/**
	 * Special char wrap
	 *
	 * @return void
	 */
	public static function bfar_special_chars() {
		return array(
			'chars' => array(
				'#',
				'$',
				'',
				'^',
				'*',
				'+',
				'\\',
				"'",
				'?',
				'[',
				'(',
				')',
				'.',
			),
			'flags' => array(
				'~hash~',
				'~dollar~',
				'~&nbsp;~',
				'~caret~',
				'~star~',
				'~plus~',
				'~bslash~',
				'~squote~',
				'~ques~',
				'~ltbrace~',
				'~lfbrace~',
				'~rfbrace~',
				'~dot~',
			),
		);
	}

	/**
	 * Str replacer
	 *
	 * @param [type]  $find
	 * @param [type]  $replace
	 * @param [type]  $str
	 * @param boolean $is_preg
	 * @param boolean $is_regular
	 * @param boolean $is_case_in_sensitive
	 * @return void
	 */
	public static function bfar_replacer( $find, $replace, $str, $is_preg = false, $is_regular = false, $is_case_in_sensitive = false ) {
		if ( false !== $is_preg ) {
			return \preg_replace( $find, $replace, $str );
		} elseif ( false !== $is_regular ) {
			if ( false !== $is_case_in_sensitive ) {
				return \str_ireplace( $find, $replace, $str );
			} else {
				return \str_replace( $find, $replace, $str );
			}
		}

		return false;
	}

}

