<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Events {

	protected $namespace = 'linp_events';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->namespace, array( $this, 'render' ) );
	}

	public function integrateWithVC() {
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}

		vc_map( array(
			'name'        => esc_html__( 'Tribe Events', 'care-plugin' ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => esc_html__( 'Aislin', 'js_composer' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => esc_html__( 'Widget Title', 'care-plugin' ),
					'param_name'  => 'title',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'holder'      => '',
					'class'       => '',
					'heading'     => esc_html__( 'Start Date Format', 'care-plugin' ),
					'param_name'  => 'start_date_format',
					'admin_label' => true,
					'value'       => 'M d, Y',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Nubmer of events to display', 'care-plugin' ),
					'param_name'  => 'limit',
					'description' => esc_html__( 'Enter number only.', 'care-plugin' ),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Description', 'care-plugin' ),
					'param_name' => 'show_description',
					'value'      => array(
						'No'  => '0',
						'Yes' => '1',
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Event description word length', 'care-plugin' ),
					'param_name'  => 'description_word_length',
					'description' => esc_html__( 'Enter number only.', 'care-plugin' ),
					'dependency'  => Array( 'element' => 'show_description', 'value' => array( '1' ) ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'View All Events Link Text', 'care-plugin' ),
					'param_name'  => 'view_all_events_link_text',
					'description' => esc_html__( 'If Left Blank link will not show.', 'care-plugin' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'care-plugin' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'care-plugin' ),
				),

			)
		) );
	}

	public function render( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title'                     => '',
			'limit'                     => '3',
			'description_word_length'   => '20',
			'start_date_format'         => '',
			'show_description'          => '0',
			'view_all_events_link_text' => 'View All Events',
			'el_class'                  => '',
		), $atts ) );

		ob_start();

		if ( ! function_exists( 'tribe_get_events' ) ) {
			return;
		}

		$posts = tribe_get_events( apply_filters( 'tribe_events_list_widget_query_args', array(
			'eventDisplay'   => 'list',
			'posts_per_page' => $limit
		) ) );

		// If no posts let's bail
		if ( ! $posts ) {
			return;
		}

		
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'linp-tribe-events-wrap ' . $el_class, $this->namespace, $atts );

		//Check if any posts were found
		if ( $posts ) {
			?>
			<div class="<?php echo esc_attr( $css_class ); ?>">
				<?php if ( $title ) : ?>
					<h3 class="widget-title">
						<i class="icon-Calendar-New"></i> <?php echo esc_html( $title ); ?>
					</h3>
				<?php endif; ?>
				<ul class="linp-tribe-events">
					<?php
					foreach ( $posts as $post ) :
						setup_postdata( $post );
						?>
						<li class="event">
							<div class="date">
								<?php if ( $start_date_format ) : ?>
									<?php echo esc_html( tribe_get_start_date( $post, false, $start_date_format ) ); ?>
								<?php else: ?>
									<span class="month">
										<?php echo esc_html( tribe_get_start_date( $post, false, 'M' ) ); ?>
									</span>

									<span class="day">
										<?php echo esc_html( tribe_get_start_date( $post, false, 'd' ) ); ?>
									</span>
								<?php endif; ?>
							</div>
							<div class="info">
								<div class="title">
									<a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>"
									   rel="bookmark"><?php echo esc_html( $post->post_title ); ?></a>
								</div>
								<?php if ( (int) $show_description ) : ?>
									<div class="content">
										<?php echo wp_kses_post( wp_trim_words( strip_shortcodes( $post->post_content ), $description_word_length, '&hellip;' ) ); ?>
									</div>
								<?php endif; ?>
							</div>
						</li>
					<?php
					endforeach;
					?>
				</ul>
				<?php if ( ! empty( $view_all_events_link_text ) ) : ?>
					<p class="linp-tribe-events-link">
						<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"
						   rel="bookmark"><?php echo esc_html( $view_all_events_link_text ); ?></a>
					</p>
				<?php endif; ?>
			</div>
			<?php
			//No Events were Found
		} else {
			?>
			<p><?php esc_html_e( 'There are no upcoming events at this time.', 'care-plugin' ); ?></p>
		<?php
		}

		wp_reset_query();
		$content = ob_get_clean();

		return $content;
	}
}

new Care_Plugin_VC_Addon_Events();
