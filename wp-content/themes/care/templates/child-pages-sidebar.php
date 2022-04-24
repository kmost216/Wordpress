<?php if ( care_get_child_pages() || $post->post_parent > 0 ) : ?>
	<nav class="site-nav children-links clearfix">
		<ul>
			<?php
				$args = array(
					'child_of' => care_get_top_ancestor_id(),
					'title_li' => ''
				);
			?>
			<?php wp_list_pages( $args ); ?>
		</ul>
	</nav>
<?php endif; ?>
