<?php
$footer_layout_block = care_get_layout_block_content( 'footer-layout-block' );
?>
<?php if ( $footer_layout_block ): ?>
	<div class="<?php echo esc_attr( care_class( 'footer' ) ) ?>">
		<div class="<?php echo esc_attr( care_class( 'container_home_content' ) ) ?>">
			<?php echo do_shortcode( $footer_layout_block ); ?>
		</div>
	</div>
<?php else: ?>
	<div class="<?php echo esc_attr( care_class( 'footer' ) ) ?>">
		<?php if ( is_active_sidebar( 'wheels-sidebar-footer' ) ) : ?>
			<div class="<?php echo esc_attr( care_class( 'footer-widgets-wrap' ) ) ?>">
				<div class="<?php echo esc_attr( care_class( 'container' ) ) ?>">
					<?php dynamic_sidebar( 'wheels-sidebar-footer' ); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>
