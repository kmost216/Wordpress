<?php

if ( ! function_exists( 'care_entry_meta' ) ) {

	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * @return void
	 */
	function care_entry_meta() {
		$meta = '';
		if ( is_sticky() && is_home() && ! is_paged() ) {
			$meta .= '<span class="featured-post">' . esc_html__( 'Featured', 'care' ) . '</span>';
		}

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() ) {
			$meta .= care_entry_date();
		}

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( esc_html__( ', ', 'care' ) );
		if ( $categories_list ) {
			$meta .= sprintf(
				'<span class="categories-links"><i class="%1$s"></i>%2$s</span>',
				esc_attr( apply_filters( 'care_icon_class', 'folder' ) ),
				$categories_list
			);
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', esc_html__( ', ', 'care' ) );
		if ( $tag_list ) {
			$meta .= sprintf(
				'<span class="tags-links"><i class="%1$s"></i>%2$s</span>',
				esc_attr( apply_filters( 'care_icon_class', 'tag' ) ),
				$tag_list
			);
		}

		// Post author
		if ( 'post' == get_post_type() ) {
			global $post;
			$author_display_name = get_the_author_meta( 'display_name', $post->post_author );
			$meta .= sprintf(
				'<span class="author vcard"><i class="%1$s"></i>%2$s <a class="url fn n" href="%3$s" title="%4$s" rel="author">%5$s</a></span>',
				esc_attr( apply_filters( 'care_icon_class', 'user' ) ), 
				esc_html__( 'by', 'care' ), 
				esc_url( get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ) ),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'care' ), $author_display_name ) ), 
				$author_display_name
			);

			$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

			if ( $num_comments == 0 ) {

			} else {

				if ( $num_comments > 1 ) {
					$comments = $num_comments . esc_html__( ' Comments', 'care' );
				} else {
					$comments = esc_html__( '1 Comment', 'care' );
				}
				$meta .= sprintf(
					'<span class="comments-count"><i class="%1$s"></i><a href="%2$s">%3$s</a></span>',
					esc_attr( apply_filters( 'care_icon_class', 'comments' ) ),
					esc_url ( get_comments_link() ),
					$comments
				);
			}

		}

		if ( $meta ) {
			echo wp_kses_post( '<div class="entry-meta">' . $meta . '</div>' );
		}

	}
}

if ( ! function_exists( 'care_entry_date' ) ) {

	/**
	 * Prints HTML with date information for current post.
	 *
	 * @return string The HTML-formatted post date.
	 */
	function care_entry_date() {
		if ( has_post_format( array( 'chat', 'status' ) ) ) {
			$format_prefix = esc_html_x( '%1$s on %2$s', '1: post format name. 2: date', 'care' );
		} else {
			$format_prefix = '%2$s';
		}

		$date = sprintf(
			'<span class="date"><i class="%1$s"></i><a href="%2$s" title="%3$s" rel="bookmark"><time class="entry-date" datetime="%4$s">%5$s</time></a></span>',
			esc_attr( apply_filters( 'care_icon_class', 'calendar' ) ),
			esc_url( get_permalink() ),
			esc_attr( sprintf( esc_html__( 'Permalink to %s', 'care' ), the_title_attribute( 'echo=0' ) ) ), 
			esc_attr( get_the_date( 'c' ) ), 
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		return $date;
	}

}
