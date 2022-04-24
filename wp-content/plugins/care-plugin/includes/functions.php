<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_init', 'care_plugin_vc_editor_set_post_types' );
add_action( 'social_share_icons', 'care_plugin_social_share' );
add_action( 'woocommerce_share', 'care_plugin_social_share' );

add_filter( 'pre_get_posts', 'care_plugin_portfolio_posts' );
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'pll_get_post_types', 'care_plugin_add_cpt_to_pll', 10, 2 );

function care_plugin_get_theme_option( $option_name, $default = false ) {
	if ( function_exists( 'care_get_option' ) ) {
		return care_get_option( $option_name, $default );
	}
	return $default;
}

function care_plugin_portfolio_posts( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( is_tax() && isset( $query->tax_query ) && $query->tax_query->queries[0]['taxonomy'] == 'portfolio_category' ) {
		$query->set( 'posts_per_page', 10 );
		return;
	}
}

function care_plugin_vc_editor_set_post_types() {
	if ( is_admin()
		&& function_exists( 'vc_editor_set_post_types' )
		&& function_exists( 'vc_set_default_editor_post_types') ) {

		$post_types = array(
			'page', 'layout_block', 'project', 'events', 'msm_mega_menu'
		);

		$new_post_types = array();
		$current_post_types = vc_editor_post_types();

		foreach ( $post_types as $post_type ) {
			if ( ! in_array( $post_type, $current_post_types ) ) {
				$new_post_types[] = $post_type;
			}
		}

		// this will work when Role Manager/Post Types is set to Custom
		if ( count( $new_post_types ) ) {
			$current_post_types = array_merge( $current_post_types, $new_post_types );
			vc_editor_set_post_types( $current_post_types );
		}

		// this will work when Role Manager/Post Types is set to Pages Only
		vc_set_default_editor_post_types( $post_types );
	}
}

function care_plugin_is_plugin_activating( $plugin ) {
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'activate' && isset( $_GET['plugin'] ) ) {
		if ( $_GET['plugin'] == $plugin ) {
			return true;
		}
	}
	return false;
}

function care_plugin_sanitize_size( $value, $default = 'px' ) {
	return preg_match( '/(px|em|rem|\%|pt|cm)$/', $value ) ? $value : ( (int) $value ) . $default;
}

function care_plugin_add_cpt_to_pll( $post_types, $is_settings ) {

	$post_types['layout_block'] = 'layout_block';
	$post_types['msm_mega_menu'] = 'msm_mega_menu';
	return $post_types;
}

function care_plugin_get_thumbnail_sizes() {
	global $_wp_additional_image_sizes;
	$thumbnail_sizes = array();
	foreach ( $_wp_additional_image_sizes as $name => $settings ) {
		$thumbnail_sizes[$name] = $name . ' (' . $settings['width'] . 'x' . $settings['height'] . ')';
	}
	return $thumbnail_sizes;
}

function care_plugin_get_thumbnail_sizes_vc() {
	global $_wp_additional_image_sizes;
	$thumbnail_sizes = array();
	foreach ( $_wp_additional_image_sizes as $name => $settings ) {
		$thumbnail_sizes[ $name . ' (' . $settings['width'] . 'x' . $settings['height'] . ')' ] = $name;
	}
	return $thumbnail_sizes;
}

function care_plugin_social_share() {
	?>
	<div class="share-this">
		<!-- http://simplesharingbuttons.com/ -->
		<ul class="share-buttons">
			<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( site_url() ); ?>&t="
			       target="_blank" title="Share on Facebook"
			       onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(document.URL) + '&t=' + encodeURIComponent(document.URL)); return false;"><i
						class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'facebook' ) ); ?>"></i></a></li>
			<li>
				<a href="https://twitter.com/intent/tweet?source=<?php echo urlencode( site_url() ); ?>&text=:%20<?php echo urlencode( site_url() ); ?>"
				   target="_blank" title="Tweet"
				   onclick="window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(document.title) + ':%20' + encodeURIComponent(document.URL)); return false;"><i
						class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'twitter' ) ); ?>"></i></a></li>
			<li>
				<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( site_url() ); ?>&description="
				   target="_blank" title="Pin it"
				   onclick="window.open('http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(document.URL) + '&description=' +  encodeURIComponent(document.title)); return false;"><i
						class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'pinterest' ) ); ?>"></i></a></li>
			<li>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode( site_url() ); ?>&title=&summary=&source=<?php echo urlencode( site_url() ); ?>"
				   target="_blank" title="Share on LinkedIn"
				   onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(document.URL) + '&title=' +  encodeURIComponent(document.title)); return false;"><i
						class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'linkedin' ) ); ?>"></i></a></li>
		</ul>
	</div>

<?php
}
