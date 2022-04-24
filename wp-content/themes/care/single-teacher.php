<?php
/**
 */
$boxed = care_get_option( 'single-post-is-boxed', false) : 'boxed' : null;

get_header( $boxed );
?>
<?php get_template_part('templates/title'); ?>
<div class="<?php echo esc_attr( care_class('main-wrapper') ) ?>">
	<div class="<?php echo esc_attr( care_class('container') ) ?>">
		<?php if ( care_get_option( 'single-post-sidebar-left', false ) ): ?>
			<div class="<?php echo esc_attr( care_class( 'sidebar' ) ) ?>">
				<?php get_sidebar(); ?>
			</div>
			<div class="<?php echo esc_attr( care_class( 'content' ) ) ?>">
				<?php get_template_part( 'templates/content-single-teacher' ); ?>
			</div>
		<?php else: ?>
			<div class="<?php echo esc_attr( care_class( 'content' ) ) ?>">
				<?php get_template_part( 'templates/content-single-teacher' ); ?>
			</div>
			<div class="<?php echo esc_attr( care_class( 'sidebar' ) ) ?>">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer( $boxed );

