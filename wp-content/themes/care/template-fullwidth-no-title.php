<?php
/**
 * @package WordPress
 * @subpackage Care
 *
 * Template Name: Full Width - No Title
 */
get_header();
?>
<div class="<?php echo esc_attr( care_class( 'main-wrapper' ) ) ?>">
	<div class="<?php echo esc_attr( care_class( 'container' ) ) ?>">
		<div class="<?php echo esc_attr( care_class( 'content-fullwidth' ) ) ?>">
			<?php get_template_part( 'templates/content-page' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
