<?php
add_filter( 'excerpt_length', 'care_excerpt_length' );
add_filter( 'excerpt_more', 'care_excerpt_more' );
add_filter( 'request', 'care_request_filter' );
add_filter( 'get_search_form', 'care_get_search_form' );
add_filter( 'comments_template', 'care_get_comments_template' );

function care_excerpt_length( $length ) {
	$post_excerpt_length = care_get_option( 'post-excerpt-length', POST_EXCERPT_LENGTH );
	return $post_excerpt_length;
}

function care_excerpt_more( $more ) {
	return '&nbsp;<a href="' . esc_url( get_permalink() ) . '">&hellip;</a>';
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function care_request_filter( $query_vars ) {
	if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && ! is_admin() ) {
		$query_vars['s'] = ' ';
	}
	return $query_vars;
}

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function care_get_search_form( $form ) {
	$form = '';
	include_once get_theme_file_path( '/templates/searchform.php' );
	return $form;
}

function care_get_comments_template( $file ) {
	return get_theme_file_path( '/templates/comments.php' );
}
