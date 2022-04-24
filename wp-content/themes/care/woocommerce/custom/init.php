<?php
add_filter( 'loop_shop_columns', 'care_loop_shop_columns' );
add_filter( 'woocommerce_related_products_columns', 'care_loop_shop_columns' );
add_filter( 'wp_nav_menu_items', 'care_wcmenucart', 10, 2 );

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );


function care_is_shop() {
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return true;
	}
	return false;
}

function care_get_shop_page_id() {
	if ( function_exists( 'wc_get_page_id' ) ) {
		return wc_get_page_id( 'shop' );
	}
	return 0;
}

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	care_wc_print_mini_cart();

	$fragments['.wh-minicart'] = ob_get_clean();

	return $fragments;
}

function care_loop_shop_columns() {
	return 3;
}

/**
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
function care_wcmenucart( $menu, $args ) {

	global $woocommerce;
	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( ! $woocommerce || !in_array( $args->theme_location, array( 'primary_navigation', 'mobile_navigation' ) )
	) {
		return $menu;
	}
	global $woocommerce;

	if ( ! $woocommerce->cart ) {
		return $menu;
	}
	$shop_page_url       = get_permalink( wc_get_page_id( 'shop' ) );
	$cart_contents_count = $woocommerce->cart->cart_contents_count;
	$cart_contents       = sprintf( _n( '%d', '%d', $cart_contents_count, 'care' ), $cart_contents_count );
	$cart_total          = $woocommerce->cart->get_cart_total();
	
	ob_start();
	?>
	<?php if ( $cart_contents_count > 0 ): ?>
		<?php if ( $cart_contents_count == 0 ): ?>
			<li class="menu-item"><a class="wcmenucart-contents" href="<?php  echo esc_url( $shop_page_url ); ?>" title="<?php esc_attr_e( 'Start shopping', 'care' ) ?>">
		<?php else:  ?>
			<li class="menu-item"><a class="wcmenucart-contents" href="<?php echo esc_url( wc_get_cart_url() );  ?>" title="<?php esc_attr_e( 'View your shopping cart', 'care' ) ?>">
		<?php endif; ?>
		<i class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'cart' ) ); ?>"></i>
		<?php echo wp_kses_post( "{$cart_contents} - {$cart_total}" ); ?>
		</a></li>
	<?php endif ?>

	<?php

	$cart_menu_item = ob_get_clean();
	return $menu . $cart_menu_item;
 }

/* Custom Shoping Cart in the top */
function care_wc_print_mini_cart() {

	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	$count = 0;
	if ( property_exists('WC', 'cart') ) {
		$count = sizeof( WC()->cart->get_cart() );
	}
	?>
	<div class="wh-minicart">
		<i class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'shopping_bag' ) ); ?>"></i>
		<span class="count"><?php echo esc_html( $count ); ?></span>

		<div id="wh-minicart-top">
			<?php woocommerce_mini_cart(); ?>
		</div>
	</div>
<?php
}
