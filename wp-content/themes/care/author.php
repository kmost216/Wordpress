<?php
/**
 * The template for displaying Author archive pages.
 *
 * @package WordPress
 * @subpackage Care
 */
get_header();
?>
<?php get_template_part( 'templates/title' ); ?>
	<div class="<?php echo esc_attr( care_class( 'main-wrapper' ) ) ?>">
		<div class="<?php echo esc_attr( care_class( 'container' ) ) ?>">
			<div class="<?php echo esc_attr( care_class( 'content' ) ) ?>">
				<?php if ( have_posts() ) : ?>
					<?php
					/* Queue the first post, that way we know
					 * what author we're dealing with (if that is the case).
					 *
					 * We reset this later so we can run the loop
					 * properly with a call to rewind_posts().
					 */
					the_post();
					?>
					<?php
					/* Since we called the_post() above, we need to
					 * rewind the loop back to the beginning that way
					 * we can run the loop properly, in full.
					 */
					rewind_posts();
					?>
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<?php get_template_part( 'templates/author-bio' ); ?>
					<?php endif; ?>
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'templates/content', get_post_format() ); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'templates/content', 'none' ); ?>
				<?php endif; ?>
				<div class="<?php echo esc_attr( care_class( 'pagination' ) ) ?>">
					<?php the_posts_pagination(); ?>
				</div>
			</div>
			<div class="<?php echo esc_attr( care_class( 'sidebar' ) ) ?>">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
