<?php namespace RealTimeAutoFindReplace\admin\functions;

/**
 * Pro Action Class
 *
 * @package Funcitons
 * @since 1.0.6
 * @author M.Tuhin <info@codesolz.net>
 */

if ( ! defined( 'CS_RTAFAR_VERSION' ) ) {
	exit;
}

use RealTimeAutoFindReplace\lib\Util;
use RealTimeAutoFindReplace\lib\RTAFAR_DB;


class ProActions {

	/**
	 * Get  All Pro url Options
	 *
	 * @return void
	 */
	public static function getAllProUrlOptions( $args, $type ) {
		global $wpdb;

		$taxConfig = array(
			'public'   => true,
			'_builtin' => true,

		);
		$output     = 'objects'; // or objects
		$operator   = 'or'; // 'and' or 'or'
		$taxonomies = \get_taxonomies( $taxConfig, $output, $operator );

		if ( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				if ( $type == 'selectOptions' ) {
					$args[ 'tblp_taxonomy_' . $taxonomy->name . '_disabled' ] = sprintf( __( 'Taxonomy URLs ( %s ) - Pro version only!', 'real-time-auto-find-and-replace' ), $taxonomy->label );
				}
			}
		}

		$getPosts = $wpdb->get_results( "SELECT DISTINCT post_type from `{$wpdb->base_prefix}posts` order by post_type ASC " );
		if ( $getPosts ) {
			foreach ( $getPosts as $post ) {
				if ( $type == 'selectOptions' ) {
					if ( isset( $args[ $post->post_type ] ) ) {
						continue;
					}
					$args[ $post->post_type . '_disabled' ] = \str_replace( '_', ' ', \ucwords( $post->post_type ) ) . ' URLs - Pro version only!';
				}
			}
		}

		return $args;
	}

	/**
	 * Get all Pro table list
	 *
	 * @param [type] $args
	 * @return void
	 */
	public static function getAllTblList( $args ) {
		global $wpdb;
		$tables = RTAFAR_DB::get_sizes( 'free' );
		return $tables;
	}



}
