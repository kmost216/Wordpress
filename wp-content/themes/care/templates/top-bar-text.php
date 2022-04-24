<?php $top_bar_text = care_get_option( 'top-bar-text', '' ); ?>
<?php if ( $top_bar_text ): ?>
	<div class="<?php echo esc_attr( care_class( 'top-bar-text' ) ) ?>">
		<?php echo do_shortcode( $top_bar_text ); ?>
	</div>
<?php endif; ?>
