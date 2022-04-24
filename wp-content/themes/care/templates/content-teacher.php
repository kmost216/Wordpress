<?php global $post_id; ?>
<div class="teacher one third wh-padding">
	<div class="inner-wrap">
		<?php if ( has_post_thumbnail() ): ?>
			<div class="thumbnail">
				<?php echo wp_kses_post( care_get_thumbnail( array( 'thumbnail' => 'wh-medium' ) ) ); ?>
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
					class="summary"><?php echo wp_trim_words( do_shortcode( $summary ), apply_filters( 'care_teacher_summary_word_count', 10 ) ); ?></div>
			<?php else: ?>
				<div class="summary"><?php echo do_shortcode( get_the_excerpt() ); ?></div>
			<?php endif; ?>
			<?php $social_icons = care_get_rwmb_meta( 'social_icons', $post->ID ); ?>
			<?php if ( ! empty( $social_icons ) ): ?>
				<div class="social">
					<div class="text"><?php esc_html_e( 'Meet me on', 'care' ); ?></div>
					<?php foreach ( $social_icons as $social_icon ): ?>
						<a href="<?php echo esc_url( $social_icon[1] ); ?>">
							<i class="<?php echo esc_attr( $social_icon[0] ); ?>"></i>
						</a>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>
