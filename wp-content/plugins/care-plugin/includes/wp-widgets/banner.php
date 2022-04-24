<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Care_Plugin_Widget_Banner extends WP_Widget {


	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget-banner',
			'description' => esc_html__( 'Banner', 'care-plugin' ),
		);

		parent::__construct( 'scp_banner', CARE_PLUGIN_NAME . ' - Banner Widget', $widget_ops );
	}

	public function form( $instance ) {

		$default = array(
			'title'       => esc_html__( 'Banner', 'care-plugin' ),
			'label'       => '',
			'text'        => 'Banner text',
			'button_text' => '',
			'button_link' => '',
		);

		$instance = wp_parse_args( (array) $instance, $default );
		?>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Label', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"
			       value="<?php echo esc_attr( $instance['label'] ); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'care-plugin' ); ?></label><br/>
			<textarea class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"
			          id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_attr( $instance['text'] ); ?></textarea>
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Button Text', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"
			       value="<?php echo esc_attr( $instance['button_text'] ); ?>"/>
		</p>
		<p>
			<label
				for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'Button Link', 'care-plugin' ); ?></label><br/>
			<input class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"
			       value="<?php echo esc_attr( $instance['button_link'] ); ?>"/>
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

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );

		echo wp_kses_post( $before_widget );
		?>

		<div class="title">
			<?php echo esc_html( $title ); ?>

			<?php if ( $instance['label'] ): ?>
				<span class="label">
					<?php echo esc_html( $instance['label'] ); ?>
				</span>
			<?php endif; ?>
		</div>
		<div class="text">
			<?php echo wp_kses_post( $instance['text'] ); ?>
		</div>

		<?php if ( ! empty( $instance['button_text'] ) ): ?>
			<a class="link hoverable"
			   href="<?php echo esc_url( $instance['button_link'] ); ?>"><div class="anim"></div><?php echo esc_html( $instance['button_text'] ); ?></a>
		<?php endif; ?>
		<?php
		echo wp_kses_post( $after_widget );
	}

}

register_widget( 'Care_Plugin_Widget_Banner' );
