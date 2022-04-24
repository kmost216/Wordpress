<?php global $post_id; ?>
<?php $post_class = care_class( 'post-item' ); ?>
<div <?php echo post_class( $post_class ) ?>>
	<div class="one whole">
		<?php if ( has_post_thumbnail() ): ?>
			<div class="thumbnail">
				<?php echo wp_kses_post( care_get_thumbnail( array( 'thumbnail' => 'wh-featured-image', 'link' => true ) ) ); ?>
			</div>
		<?php endif; ?>
		<?php get_template_part( 'templates/entry-meta' ); ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div>
	<div class="item one whole">
		<div class="entry-summary"><?php echo wp_kses_post( strip_shortcodes( get_the_excerpt() ) ); ?></div>
		<a class="wh-button read-more hoverable"
		   href="<?php the_permalink(); ?>"><span class="anim"></span><?php esc_html_e( 'Read more', 'care' ); ?></a>
	</div>
</div>
