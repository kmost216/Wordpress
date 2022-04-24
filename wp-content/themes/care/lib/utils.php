<?php
add_filter( 'post_class', 'care_oddeven_post_class' );
add_filter( 'body_class', 'care_filter_body_class' );
add_filter( 'msm_filter_menu_location', 'care_msm_filter_menu_location' );
add_filter( 'msm_filter_load_compiled_style', 'care_msm_filter_load_compiled_style' );
add_filter( 'breadcrumb_trail_labels', 'care_breadcrumb_trail_labels' );

global $wp_version;
if ( version_compare( $wp_version, '5.0', '<' ) ) {
	add_filter( 'wp_link_pages_link', 'care_wp_link_pages_link', 10, 2 );
}

function care_is_element_empty( $element ) {
	$element = trim( $element );
	return empty( $element ) ? true : false;
}

function care_get_thumbnail( $args ) {

	$defaults = array(
		'thumbnail' => 'thumbnail',
		'post_id'   => null,
		'link'      => false,
		'format'    => '',
	);

	$args = wp_parse_args( $args, $defaults );

	if ( $args['post_id'] ) {
		$post_id = $args['post_id'];
	} else {
		global $post_id;
	}

	$img_url = '';
	if ( has_post_thumbnail( $post_id ) ) {
		$img_url = get_the_post_thumbnail( $post_id, $args['thumbnail'], array(
			'class' => $args['thumbnail']
		) );
	}

	if ( '' != $img_url && $args['format'] === 'array' ) {
		/* Set up a default empty array. */
		$out = array();
		/* Get the image attributes. */
		$atts = wp_kses_hair( $img_url, array( 'http', 'https' ) );
		/* Loop through the image attributes and add them in key/value pairs for the return array. */
		foreach ( $atts as $att ) {
			$out[ $att['name'] ] = $att['value'];
		}
		/* Return the array of attributes. */
		return $out;
	}

	$out = '';
	if ( '' != $img_url ) {
		if ( $args['link'] ) {
			$out = '<a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $img_url . '</a>';
		} else {
			$out = $img_url;
		}
	}

	return $out;
}

function care_pagination( $pages = '', $range = 2 ) {
	$showitems = ( $range * 2 ) + 1;

	global $paged;
	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {
		echo "<div class='pagination'>";
		if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
			echo "<a href='" . esc_url( get_pagenum_link( 1 ) ) . "'>&laquo;</a>";
		}
		if ( $paged > 1 && $showitems < $pages ) {
			echo "<a href='" . esc_url( get_pagenum_link( $paged - 1 ) ) . "'>&lsaquo;</a>";
		}

		for ( $i = 1; $i <= $pages; $i ++ ) {
			if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
				if ( $paged == $i ) {
					echo "<span class='current'>" . esc_html( $i ) . "</span>";
				} else {
					echo "<a href='" . esc_url( get_pagenum_link( $i ) ) . "' class='inactive' >" . esc_html( $i ) . "</a>";
				}
			}
		}

		if ( $paged < $pages && $showitems < $pages ) {
			echo "<a href='" . esc_url( get_pagenum_link( $paged + 1 ) ) . "'>&rsaquo;</a>";
		}
		if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
			echo "<a href='" . esc_url( get_pagenum_link( $pages ) ) . "'>&raquo;</a>";
		}
		echo "</div>\n";
	}
}

function care_grid_class_map() {

	return array(
		array( 'one twelfth', 'eleven twelfths' ),  // 1/11
		array( 'one sixth', 'five sixths' ),        // 2/10
		array( 'one fourth', 'three fourths' ),     // 3/9
		array( 'one third', 'two thirds' ),         // 4/8
		array( 'five twelfths', 'seven twelfths' ), // 5/7
		array( 'one half', 'one half' ),            // 6/6
		array( 'seven twelfths', 'five twelfths' ), // 7/5
		array( 'two thirds', 'one third' ),         // 8/4
		array( 'three fourths', 'one fourth' ),     // 9/3
		array( 'five sixths', 'one sixth' ),        // 10/2
		array( 'eleven twelfths', 'one twelfth' ),  // 11/1
		array( 'one whole', 'one whole' ),          // 12/12
	);
}

function care_get_grid_class( $index, $invert = false ) {
	$grid = care_grid_class_map();
	return isset( $grid[ $index ] ) ? $grid[ $index ][ $invert ? 1 : 0 ] : '';
}

function care_get_option( $option_name, $default = false ) {
	$options = isset( $GLOBALS[ CARE_THEME_OPTION_NAME ] ) ? $GLOBALS[ CARE_THEME_OPTION_NAME ] : false;

	if ( $options && is_string( $option_name ) ) {
		return isset( $options[ $option_name ] ) ? $options[ $option_name ] : $default;
	}
	return $default;
}

function care_get_page_template() {

	$post_id = null;
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	} else {
		global $post;
		$post_id = $post->ID;
	}

	if ( $post_id ) {
		return get_post_meta( $post_id, '_wp_page_template', true );
	}
}

function care_is_page_template( $template_file ) {
	return care_get_page_template() == $template_file;
}

function care_custom_css() {
	$custom_css = care_get_option( 'custom-css' );

	// Get custom page title bg
	$custom_page_title_bg_image_url = care_get_rwmb_meta_image_url( 'custom_page_title_background' );
	if ( $custom_page_title_bg_image_url ) {
		$custom_css .= ".wh-page-title-bar{background-image:url({$custom_page_title_bg_image_url})}";
	}

	if ( ! care_is_element_empty( $custom_css ) ) {
		return $custom_css;
	}
}

function care_responsive_menu_scripts() {
	$css = '.header-mobile {display: none;}';
	$respmenu_show_start = (int) care_get_option( 'header-mobile-break-point', 1000 );
	if ( $respmenu_show_start ) {
		$css .= '@media screen and (max-width:' . intval( $respmenu_show_start ) . 'px) {';
		$css .= '.header-left {padding-left: 0;}';
		$css .= '.wh-header, .wh-top-bar {display: none;}';
		$css .= '.header-mobile {display: block;}';
		$css .= '}';
	}
	return $css;
}

function care_filter_array( $filter_name, $default = array() ) {
	$filtered = apply_filters( $filter_name, $default );
	if ( ! is_array( $filtered ) || ! count( $filtered ) ) {
		$filtered = $default;
	}
	return array_unique( $filtered );
}

function care_array_val_concat( $array = null, $postfix = '', $default ) {
	if ( is_array( $array ) ) {
		$res = array();
		foreach ( $array as $val ) {
			$res[] = $val . $postfix;
		}
		return $res;
	}
	return $default;
}

function care_get_rwmb_meta( $key, $post_id, $options = array() ) {
	$prefix = care_get_rwmb_prefix();
	$value  = false;
	if ( function_exists( 'rwmb_meta' ) ) {
		$value = rwmb_meta( $prefix . $key, $options, $post_id );
	}
	return $value;
}

function care_get_rwmb_meta_image_url( $key, $post_id = false ) {
	if ( ! $key ) {
		return '';
	}
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	if ( ! $post_id ) {
		return '';
	}
	$image_url = '';
	$image = care_get_rwmb_meta( $key, $post_id, array( 'type' => 'image' ) );
	if ( is_array( $image ) && count( $image ) ) {
		$image = reset( $image );    // get first element
		$image_url = isset( $image['full_url'] ) ? $image['full_url'] : '';
	}
	return $image_url;
}

if ( ! function_exists( 'care_get_logo_url' )) {

	function care_get_logo_url() {
		$logo_url = '';

		// Get custom page logo
		$logo_url = care_get_rwmb_meta_image_url( 'custom_logo' );
		if ( $logo_url ) {
			return $logo_url;
		}

		// Get default logo
		$logo     = care_get_option( 'logo', array() );
		$logo_url = isset( $logo['url'] ) && $logo['url'] ? $logo['url'] : '';


		return $logo_url;
	}
}

function care_strip_comments( $string ) {

	$regex = array(
		"`^([\t\s]+)`ism"                       => '',
		"`^\/\*(.+?)\*\/`ism"                   => "",
		"`(\A|[\n;]+)/\*.+?\*/`s"               =>"$1", 
		"`(\A|[;\s]+)//.+\R`"                   =>"$1\n", 
		"`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
	);

	return preg_replace( array_keys( $regex ), $regex, $string );
}

function care_get_child_pages() {
	global $post;
	$args = array(
		'child_of'    => $post->ID,
		'sort_column' => 'menu_order',
	);
	$pages = get_pages( $args );
	return count( $pages );
}

function care_get_top_ancestor_id() {
	global $post;
	if ( $post->post_parent ) {
		$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
		return $ancestors[0];
	}
	return $post->ID;
}

function care_page_title_enabled() {
	$page_title_enabled = is_single() ? care_get_option( 'archive-single-use-page-title', true ) : true;
	return apply_filters( 'care_filter_page_title_enabled', $page_title_enabled );
}

function care_get_rwmb_prefix() {
	$prefix = CARE_THEME_PREFIX;
	if ( defined( 'CARE_RWMB_META_PREFIX' ) ) {
		$prefix = CARE_RWMB_META_PREFIX;
	}
	return $prefix;
}

function care_filter_body_class( $body_classes ) {
	$body_classes[] = 'header-' . care_get_option( 'header-location', 'top' );
	if ( care_page_title_enabled() ) {
		$body_classes[] = 'page-title-enabled';
	}
	if ( is_single() ) {
		$body_classes[] = 'single-layout-' . care_get_option( 'blog-single-layout', 'default' );
	}
	return $body_classes;
}

function care_msm_filter_menu_location( $menu_location ) {
	global $post_id;
	$use_custom_menu_location = care_get_rwmb_meta( 'use_custom_menu', $post_id );
	if ( $use_custom_menu_location ) {
		$custom_menu_location = care_get_rwmb_meta( 'custom_menu_location', $post_id );
		if ( ! empty( $custom_menu_location ) ) {
			return $custom_menu_location;
		}
	}
	return $menu_location;
}

function care_msm_filter_load_compiled_style() {
	return false;
}

function care_oddeven_post_class( $classes ) {
	static $current_class;
	$current_class = ( $current_class == 'odd' ) ? 'even' : 'odd';
	$classes[]     = $current_class;

	return $classes;
}

function care_breadcrumb_trail_labels($labels) {

	return wp_parse_args( array(
		'browse'              => esc_html__( 'Browse:',                               'care' ),
		'aria_label'          => esc_attr_x( 'Breadcrumbs', 'breadcrumbs aria label', 'care' ),
		'home'                => esc_html__( 'Home',                                  'care' ),
		'error_404'           => esc_html__( '404 Not Found',                         'care' ),
		'archives'            => esc_html__( 'Archives',                              'care' ),
		// Translators: %s is the search query. The HTML entities are opening and closing curly quotes.
		'search'              => esc_html__( 'Search results for &#8220;%s&#8221;',   'care' ),
		// Translators: %s is the page number.
		'paged'               => esc_html__( 'Page %s',                               'care' ),
		// Translators: Minute archive title. %s is the minute time format.
		'archive_minute'      => esc_html__( 'Minute %s',                             'care' ),
		// Translators: Weekly archive title. %s is the week date format.
		'archive_week'        => esc_html__( 'Week %s',                               'care' ),
	), $labels);

}

function care_wp_link_pages_link( $link, $i ) {
	global $page;

	if ( $i === $page ) {
		$link = '<span class="post-page-numbers current" aria-current="page">' . $link . '</span>';
	}

	return $link;
}

function care_is_post_list() {
	return is_home() || is_archive() || is_search();
}

function care_is_sticky_menu_enabled() {
	return filter_var( care_get_option( 'main-menu-use-menu-is-sticky', false ), FILTER_VALIDATE_BOOLEAN );
}
