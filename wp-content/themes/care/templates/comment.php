<div class="avatar-wrap">
<?php echo wp_kses_post( get_avatar( $comment, $size = '54' ) ); ?>
</div>
<div class="body">
	<div class="comment-meta">
		<span class="author-link">
		<?php comment_author_link(); ?>
		</span>
		/
		<time datetime="<?php echo esc_attr( comment_date( 'c' ) ); ?>"><a
				href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>"><?php printf( esc_html__( '%1$s', 'care' ), get_comment_date(), get_comment_time() ); ?></a>
		</time>
		<?php $comment_reply_link = get_comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<?php if ( $comment_reply_link ): ?>
		 / <?php echo wp_kses_post( $comment_reply_link ); ?>
		<?php endif ?>
		<?php if ( is_user_logged_in() ): ?>

		/ <?php edit_comment_link( esc_html__( '(Edit)', 'care' ), '', '' ); ?>
		<?php endif ?>
	</div>

	<?php if ( $comment->comment_approved == '0' ) : ?>
		<div class="alert alert-info">
			<?php esc_html_e( 'Your comment is awaiting moderation.', 'care' ); ?>
		</div>
	<?php endif; ?>

	<?php comment_text(); ?>
