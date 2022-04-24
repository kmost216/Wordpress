<?php global $post_id; ?>
<div class="teacher one third wh-padding">
	<?php if ( has_post_thumbnail() ): ?>
		<div class="thumbnail">
			<?php echo wp_kses_post( care_get_thumbnail( array( 'thumbnail' => 'wh-featured-image' ) ) ); ?>
		</div>
	<?php endif; ?>
	<div class="item">
		<h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
		<?php $job_title = care_get_rwmb_meta( 'job_title', $post_id ); ?>
		<?php if ( $job_title ) : ?>
			<div class="job-title"><?php echo esc_html( $job_title ); ?></div>
		<?php endif; ?>
		<?php $summary = care_get_rwmb_meta( 'summary', $post_id ); ?>
		<?php if ( $summary ) : ?>
			<div
				class="summary"><?php echo wp_trim_words( do_shortcode( $summary ), apply_filters( 'care_project_summary_word_count', 10 ) ); ?></div>
		<?php else: ?>
			<div class="summary"><?php echo do_shortcode( get_the_excerpt() ); ?></div>
		<?php endif; ?>
		<?php $social = care_get_rwmb_meta( 'social_meta', $post_id ); ?>
		<?php if ( $social ) : ?>
			<div class="social">
				<div class="text"><?php esc_html_e( 'Meet us on:', 'care' ); ?></div>
				<?php echo do_shortcode( $social ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
