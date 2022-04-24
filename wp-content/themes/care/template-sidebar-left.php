<?php
/**
 * @package WordPress
 * @subpackage Care
 *
 * Template Name: Sidebar - Left
 */
get_header();
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo esc_attr( care_class( 'main-wrapper' ) ) ?>">
	<div class="<?php echo esc_attr( care_class( 'container' ) ) ?>">
		<div class="<?php echo esc_attr( care_class( 'sidebar' ) ) ?>">
			<?php get_sidebar(); ?>
		</div>
		<div class="<?php echo esc_attr( care_class( 'content' ) ) ?>">
			<?php get_template_part( 'templates/content-page' ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
