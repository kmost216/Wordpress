<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Care_Plugin_Widget_Latest_Posts extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-latest-posts',
			'description' => esc_html__( 'Latest Post from News category.( for footer section)', 'care-plugin' ),
		);

		parent::__construct( 'scp_latest_posts', CARE_PLUGIN_NAME . ' - Latest Posts Widget', $widget_ops );
	}

	public function form( $instance ) {

		$default = array(
			'title'           => esc_html__( 'Latest Posts', 'care-plugin' ),
			'current_cat'     => null,
			'show_image'      => '0',
			'number_of_posts' => 2,
			'date_format'     => 'j M, Y',
			'cat_link_text'   => 'View All',
		);

		$instance = wp_parse_args( (array) $instance, $default );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'current_cat' ) ); ?>"><?php esc_html_e( 'Category', 'care-plugin' ); ?></label><br/>
			<?php
			wp_dropdown_categories( array(
				'selected'         => $instance['current_cat'],
				'name'             => $this->get_field_name( 'current_cat' ),
				'id'               => $this->get_field_id( 'current_cat' ),
				'class'            => 'widefat',
				'show_count'       => true,
				'show_option_none' => 'All',
				'hide_empty'       => false,
				'orderby'          => 'name'
			) );
			?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>"><?php esc_html_e( 'Show Image', 'care-plugin' ); ?></label><br/>
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'show_image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_image' ) ); ?>">
				<option value="0" <?php echo esc_html( $instance['show_image'] == '0' ? 'selected="selected"' : '' ); ?>><?php esc_html_e( 'No', 'care-plugin' ); ?></option>
				<option value="1" <?php echo esc_html( $instance['show_image'] == '1' ? 'selected="selected"' : '' ); ?>><?php esc_html_e( 'Yes', 'care-plugin' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>"><?php esc_html_e( 'Number of Posts', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'number_of_posts' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'number_of_posts' ) ); ?>" value="<?php echo esc_attr( $instance['number_of_posts'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php esc_html_e( 'Date Format', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" value="<?php echo esc_attr( $instance['date_format'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat_link_text' ) ); ?>"><?php esc_html_e( 'Category Link Button Text', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'cat_link_text' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'cat_link_text' ) ); ?>" value="<?php echo esc_attr( $instance['cat_link_text'] ); ?>"/>
		</p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();
		if ( empty( $old_instance ) ) {
			$old_instance = $new_instance;
		}

		if ( $new_instance['num'] > 8 ) {
			$new_instance['num'] = 8;
		}

		foreach ( $old_instance as $k => $value ) {
			$instance[ $k ] = trim( strip_tags( $new_instance[ $k ] ) );
		}

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );

		if ( $instance['current_cat'] == '-1' ) {
			$instance['current_cat'] = null;
		}
		//Get leatest posts from upcoming Events Category
		$args = array(
			'numberposts'      => $instance['number_of_posts'],
			'category'         => $instance['current_cat'],
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'suppress_filters' => false
		);

		$posts = get_posts( $args );
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );

		$css_class = $instance['show_image'] ? 'show-image' : '';
		echo wp_kses_post( $before_widget );
		?>
		<?php if ( $title ): ?>
			<?php echo wp_kses_post( $before_title . $title . $after_title ); ?>
		<?php endif; ?>
		<div class="items">
			<?php foreach ( $posts as $post ): ?>

				<div class="widget-post-list-item <?php echo esc_attr( $css_class ); ?>">
					<?php if ( $instance['show_image'] ): ?>

						<div class="thumbnail">
							<?php
							$img_url = '';
							if ( has_post_thumbnail( $post->ID ) ) {
								$img_url = get_the_post_thumbnail( $post->ID, 'thumbnail' );
							}
							if ( '' != $img_url ) {
								echo '<a href="' . esc_url( get_permalink( $post->ID ) ) . '" title="' . esc_attr( get_post_field( 'post_title', $post->ID ) ) . '">' . $img_url . '</a>';
							}
							?>
						</div>
					<?php endif; ?>
					<div class="data">
						<div class="title">
							<a title="<?php echo esc_attr( $post->post_title ); ?>" href="<?php the_permalink( $post->ID ); ?>"><?php echo esc_html( $post->post_title ); ?></a>
						</div>
						<div class="meta-data">
		                    <span class="date">
		                        <?php echo esc_html( date_i18n( $instance['date_format'], strtotime( $post->post_date ) ) ); ?>
		                    </span>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( ! empty( $instance['cat_link_text'] ) ): ?>
			<?php $category_link = get_category_link( $instance['current_cat'] ); ?>
			<a class="view-all" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $instance['cat_link_text'] ); ?></a>
		<?php endif; ?>
		<?php
		echo wp_kses_post( $after_widget );
	}

}

register_widget( 'Care_Plugin_Widget_Latest_Posts' );
