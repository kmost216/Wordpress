<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class Care_Plugin_VC_Addon_Post_List {

	protected $namespace = 'linp_post_list';

	function __construct() {
		add_action( vc_is_inline() ? 'init' : 'admin_init', array( $this, 'integrateWithVC' ) );
		add_shortcode( $this->namespace, array( $this, 'render' ) );
	}

	public function integrateWithVC() {
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			return;
		}
		
		global $_wp_additional_image_sizes;
		$thumbnail_sizes = array();
		foreach ( $_wp_additional_image_sizes as $name => $settings ) {
			$thumbnail_sizes[ $name . ' (' . $settings['width'] . 'x' . $settings['height'] . ')' ] = $name;
		}

		$args       = array(
			'orderby' => 'name',
			'parent'  => 0
		);
		$categories = get_categories( $args );
		$cats       = array('All' => '');
		foreach ( $categories as $category ) {

			$cats[ $category->name ] = $category->term_id;
		}

		vc_map( array(
			'name'        => esc_html__( 'Post List', 'care-plugin' ),
			'description' => '',
			'base'        => $this->namespace,
			'class'       => '',
			'controls'    => 'full',
			'icon'        => plugins_url( 'assets/aislin-vc-icon.png', __FILE__ ),
			'category'    => esc_html__( 'Aislin', 'care-plugin' ),
			'params'      => array(
				array(
					'type'       => 'dropdown',
					'holder'     => '',
					'class'      => '',
					'heading'    => esc_html__( 'Category', 'care-plugin' ),
					'param_name' => 'category',
					'value'      => $cats,
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Number of Posts', 'care-plugin' ),
					'param_name' => 'number_of_posts',
					'value'      => '2',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Post Date Format', 'care-plugin' ),
					'param_name' => 'post_date_format',
					'value'      => 'M d, Y',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Post description word length', 'care-plugin' ),
					'param_name'  => 'description_word_length',
					'description' => esc_html__( 'Enter number only.', 'care-plugin' ),
					'value'       => '15'
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Link Text', 'care-plugin' ),
					'param_name'  => 'link_text',
					'value'       => 'Read More',
					'description' => esc_html__( 'If you do not wish to display Read More link just leave this field blank.', 'care-plugin' ),
				),
//				array(
//					'type'        => 'textfield',
//					'heading'     => esc_html__( 'Category Link Text', 'care-plugin' ),
//					'param_name'  => 'cat_link_text',
//					'value'       => 'View All',
//					'description' => esc_html__( 'If you do not wish to display the Category Link just leave this field blank.', 'care-plugin' ),
//				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Number of Columns', 'care-plugin' ),
					'param_name' => 'number_of_columns',
					'value'      => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Show Author/Comment Count/Category?', 'care-plugin' ),
					'param_name' => 'show_meta',
					'value'      => array(
						'No'  => '0',
						'Yes' => '1',
					),
				),
				array(
					'type'       => 'dropdown',
					'class'      => '',
					'heading'    => esc_html__( 'Thumbnail Dimensions', 'care-plugin' ),
					'param_name' => 'thumbnail_dimensions',
					'value'      => $thumbnail_sizes,
				),
				array(
					'type'       => 'colorpicker',
					'class'      => '',
					'heading'    => esc_html__( 'Meta Data Color', 'care-plugin' ),
					'param_name' => 'meta_data_color',
					'value'      => '',
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
			'category'                => null,
			'number_of_posts'         => 2,
			'link_text'               => 'Read More',
			'cat_link_text'           => '',
			'number_of_columns'       => 1,
			'description_word_length' => '15',
			'thumbnail_dimensions'    => 'thumbnail',
			'post_date_format'        => '',
			'show_meta'               => '0',
			'el_class'                => '',
		), $atts ) );

		// $content = wpb_js_remove_wpautop($content); // fix unclosed/unwanted paragraph tags in $content

		$args = array(
			'numberposts'      => $number_of_posts,
			'category'         => $category,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'suppress_filters' => false,
		);

		$posts = get_posts( $args );

		// If no posts let's bail
		if ( ! $posts ) {
			return;
		}

		$grid = array(
			'one whole',
			'one half',
			'one third',
			'one fourth',
			'one fifth',
			'one sixth',
		);
		$grid_class = $grid[ (int) $number_of_columns - 1 ];

		ob_start();

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'linp-post-list ' . $el_class, $this->namespace, $atts );
		?>
		<div class="<?php echo esc_attr( $css_class ); ?>">
			<?php foreach ( array_chunk( $posts, $number_of_columns ) as $chunk ): ?>
				<div class="vc_row">
					<?php foreach ( $chunk as $post ): ?>
						<div class="wh-padding item <?php echo esc_attr( $grid_class ); ?>">
							<?php $img_url = ''; ?>
							<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
								<?php $img_url = get_the_post_thumbnail( $post->ID, $thumbnail_dimensions, array( 'class' => 'post-list-thumb' ) ); ?>
							<?php endif; ?>
							<?php if ( '' != $img_url ) : ?>
								<div class="img-container">
									<div class="date">
										<?php if ( $post_date_format ) : ?>
											<?php echo wp_kses_post( date_i18n( $post_date_format, strtotime( $post->post_date ) ) ); ?>
										<?php else: ?>
											<div class="month">
												<?php echo wp_kses_post( date_i18n( 'M', strtotime( $post->post_date ) ) ); ?>
											</div>
											<div class="separator"></div>
											<div class="day">
												<?php echo wp_kses_post( date_i18n( 'd', strtotime( $post->post_date ) ) ); ?>
											</div>
										<?php endif; ?>
									</div>
									<a href="<?php the_permalink( $post->ID ) ?>"
									   title="<?php echo esc_attr( get_post_field( 'post_title', $post->ID ) ); ?>"><?php echo wp_kses_post( $img_url ); ?></a>
								</div>
							<?php endif; ?>
							<div class="data">
								<h3>
									<a title="<?php echo esc_attr( $post->post_title ); ?>"
									   href="<?php the_permalink( $post->ID ); ?>">
										<?php echo esc_html( $post->post_title ); ?>
									</a>
								</h3>
								<?php if ( (int) $show_meta ): ?>
									<div class="meta-data">
										<span class="comments">
	                                        <i class="icon-Message"></i> <?php echo esc_html( $post->comment_count ); ?>
	                                    </span>
										<span class="author">
					                         <i class="icon-User2"></i> <?php esc_attr_e( 'by', 'care-plugin' ); ?> <a
												href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
												<?php the_author_meta( 'display_name' ); ?>
											</a>
					                    </span>
									</div>
								<?php endif; ?>
								<div class="content">
									<?php $text = apply_filters( 'widget_text', strip_shortcodes( $post->post_content ) ); ?>
									<p><?php echo wp_kses_post( wp_trim_words( strip_shortcodes( $text ), $description_word_length, '&hellip;' ) ); ?></p>
								</div>
								<?php if ( $link_text ) : ?>
									<a class="read-more" href="#"><?php echo esc_html( $link_text ); ?></a>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
			<?php if ( $cat_link_text ): ?>
				<?php $category_link = get_category_link( $category ); ?>
				<a class="cbp_widget_link cbp_widget_button"
				   href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $cat_link_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}

new Care_Plugin_VC_Addon_Post_List();
