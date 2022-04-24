<?php
/**
 * @package WordPress
 * @subpackage Care
 */
?>
<?php get_template_part( 'templates/head' ); ?>
<body <?php body_class(); ?>>
<div class="<?php echo esc_attr( care_class( 'main-wrapper' ) ) ?>">
	<div class="<?php echo esc_attr( care_class( 'container' ) ) ?>">
		<div class="<?php echo esc_attr( care_class( 'content-fullwidth' ) ) ?>">
			<div class="entry-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
