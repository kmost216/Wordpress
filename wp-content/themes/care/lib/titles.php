<?php
/**
 * Page titles
 */
function care_title() {

	$post_id = get_the_ID();

	if ( is_home() ) {
		if ( get_option( 'page_for_posts', true ) ) {
			return get_the_title( get_option( 'page_for_posts', true ) );
		} else {
			return esc_html__( 'Latest Posts', 'care' );
		}
	} elseif ( is_archive() ) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ( $term ) {
			return apply_filters( 'single_term_title', $term->name, $post_id );
		} elseif ( is_post_type_archive() ) {
			if ( property_exists( get_queried_object(), 'labels' ) ) {
				return apply_filters( 'the_title', get_queried_object()->labels->name, $post_id );
			} else {
				if ( class_exists( 'WooCommerce' ) ) {
					return apply_filters( 'the_title', woocommerce_page_title( false ), $post_id );
				} else {
					return apply_filters( 'the_title', post_type_archive_title( '',false ), $post_id );
				}
			}
		} elseif ( is_day() ) {
			return sprintf( esc_html__( 'Daily Archives: %s', 'care' ), get_the_date() );
		} elseif ( is_month() ) {
			return sprintf( esc_html__( 'Monthly Archives: %s', 'care' ), get_the_date( 'F Y' ) );
		} elseif ( is_year() ) {
			return sprintf( esc_html__( 'Yearly Archives: %s', 'care' ), get_the_date( 'Y' ) );
		} elseif ( is_author() ) {
			$author = get_queried_object();
			return sprintf( esc_html__( 'Author: %s', 'care' ), $author->display_name );
		} elseif ( function_exists( 'care_is_search_courses' ) && care_is_search_courses() ) {
			return esc_html__( 'Search Courses', 'care' );
		} else {
			return single_cat_title( '', false );
		}
	} elseif ( is_search() ) {
		return sprintf( esc_html__( 'Search Results for %s', 'care' ), get_search_query() );
	} elseif ( function_exists( 'care_is_search_courses' ) && care_is_search_courses() ) {
		return esc_html__( 'Search Courses', 'care' );
	} elseif ( is_404() ) {
		return esc_html__( 'Not Found', 'care' );
	} elseif ( get_post_type() == 'tribe_events' && !is_single() ) {
		return tribe_get_events_title();
	} else {
		return get_the_title();
	}
}
