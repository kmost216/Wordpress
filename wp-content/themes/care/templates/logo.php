<?php
$logo_url   = care_get_logo_url();
$logo_width = care_get_option( 'logo-width-exact', '' );

if ( $logo_width && isset( $logo_width['width'] ) ) {
	$logo_width = (int) $logo_width['width'] ? (int) $logo_width['width'] : '';
}
?>
<?php if ( $logo_url ): ?>
	<div class="<?php echo esc_attr( care_class( 'logo' ) ) ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img width="<?php echo esc_attr( $logo_width ); ?>" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Logo', 'care' ); ?>">
		</a>
	</div>
<?php else: ?>
	<div class="<?php echo esc_attr( care_class( 'logo' ) ) ?>">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	</div>
<?php endif; ?>
