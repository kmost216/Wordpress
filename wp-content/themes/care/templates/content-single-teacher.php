<?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ): ?>
			<div class="thumbnail">
				<?php echo wp_kses_post( care_get_thumbnail( array( 'thumbnail' => 'wh-square' ) ) ); ?>
			</div>
		<?php endif; ?>
		<?php if ( ! care_get_option( 'archive-single-use-page-title', false ) ) : ?>
			<?php the_title( '<h1>', '</h1>' ); ?>
		<?php endif; ?>
		<div class="teacher-meta-data">

			<?php $location = care_get_rwmb_meta( 'location', $post->ID ); ?>
			<?php if ( $location ) : ?>
				<div class="location">
					<i class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'teacher_location' ) ); ?>"></i>
					<?php echo esc_html( $location ); ?>
				</div>
			<?php endif; ?>
			<?php $job_title = care_get_rwmb_meta( 'job_title', $post->ID ); ?>
			<?php if ( $job_title ) : ?>
				<div class="job-title">
				<i class="<?php echo esc_attr( apply_filters( 'care_icon_class', 'teacher_job_title' ) ); ?>"></i>
					<?php echo esc_html( $job_title ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php the_content(); ?>

		<?php $social_icons = care_get_rwmb_meta( 'social_icons', $post->ID ); ?>
		<?php if ( ! empty( $social_icons ) ): ?>
			<div class="social">
				<div class="text"><?php esc_html_e( 'Meet me on', 'care' ); ?></div>
				<?php foreach ( $social_icons as $social_icon ): ?>
					<?php $link_target = isset( $social_icon[2] ) && strtolower( trim( $social_icon[2] ) ) === 'yes' ? '_blank' : '_self';  ?>
					<a href="<?php echo esc_url( $social_icon[1] ); ?>"
						target="<?php echo esc_attr( $link_target ); ?>">
						<i class="<?php echo esc_attr( $social_icon[0] ); ?>"></i>
					</a>
				<?php endforeach ?>
			</div>
		<?php endif ?>
	</div>
<?php endwhile; ?>
