<?php
$mobile_header_layout_block = care_get_layout_block_content( 'header-layout-block-mobile' );
?>
<?php if ( $mobile_header_layout_block ): ?>
	<div class="<?php echo esc_attr( care_class( 'header-mobile' ) ) ?>">
		<?php echo do_shortcode( $mobile_header_layout_block ); ?>
	</div>
<?php else: ?>
	<div class="<?php echo esc_attr( care_class( 'header-mobile-default' ) ) ?>">
		<?php get_template_part('templates/menu-mobile'); ?>
	</div>
<?php endif; ?>
