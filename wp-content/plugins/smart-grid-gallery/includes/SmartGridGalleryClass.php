<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'SmartGridGallery' ) ) {
	
	class SmartGridGallery {

		public function __construct() {

			// Add actions
			// TODO: update to load only on instance page
			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueueScripts' ) );
			
			// Create shortcode
			add_shortcode( 'smart-grid', array( &$this, 'shortcode') );

			// Add attachments fields
			add_filter( 'attachment_fields_to_save', array ( &$this, 'fields_to_save' ), 10, 2 );
			add_filter( 'attachment_fields_to_edit', array ( &$this, 'fields_to_edit' ), 10, 2 );

			// Add custom image sizes to fill the gap between 300 and 1024 default WP sizes
			add_image_size( 'sgg-420', 420, 420 );
 			add_image_size( 'sgg-540', 540, 540 );
			add_image_size( 'sgg-780', 780, 780 );
		}	
		
		/**
		 * Front end scripts
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */
		
		public function enqueueScripts() {
			
			// Make sure jQuery migrate added
			// wp_enqueue_script( 'jquery-migrate', "http://code.jquery.com/jquery-migrate-1.2.1.min.js", array('jquery') );
			
			// JustifiedGallery
			//wp_enqueue_script( 'justified-gallery', plugins_url( 'justified-gallery/dist/js/jquery.justifiedGallery.min.js', __FILE__ ), array( 'jquery' ) );
			//wp_enqueue_style ( 'justified-gallery', plugins_url( 'justified-gallery/dist/css/justifiedGallery.css', __FILE__ ) );
			
			// Lightboxes
			//wp_enqueue_script( 'swipebox', plugins_url( 'lightboxes/swipebox/js/jquery.swipebox.js', __FILE__ ), array( 'jquery' ) );
			//wp_enqueue_style ( 'swipebox', plugins_url( 'lightboxes/swipebox/css/swipebox.min.css', __FILE__ ) );

			//wp_enqueue_script( 'magnific-popup', plugins_url( 'lightboxes/magnific-popup/jquery.magnific-popup.min.js', __FILE__ ), array( 'jquery' ) );
			//wp_enqueue_style ( 'magnific-popup', plugins_url( 'lightboxes/magnific-popup/magnific-popup.css', __FILE__ ) );

			// Compiled version
			wp_enqueue_script( 'smart-grid', plugins_url( '/dist/sgg.min.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_style ( 'smart-grid', plugins_url( '/dist/sgg.min.css', __FILE__ ) );			
		}
		
		
		/**
		 * Show shortcode view
		 * 
		 * @author Ilya K.
		 * @since 1.0
		 */
		
		function shortcode( $atts, $content ) {
			
			$grid = new JustifiedGallery( $atts );
			
			ob_start();
			
			$grid->show( $content );
		
			return ob_get_clean();
		}

		/**
		 * Save attachment fields
		 * 
		 * @author Ilya K.
		 * @since 1.3
		 */
		
		function fields_to_edit ( $fields, $post ) {
			
			if ( substr($post->post_mime_type, 0, 5) == 'image' ) {

				$fields['iframe_url'] = array (
					'label'		=> "Video URL",
					'input' 	=> 'text',
					'value' 	=> get_post_meta( $post->ID, 'sgg_iframe_url', true ),
					'helps' 	=> __( '<span style="word-wrap: break-word;" >Supported formats:<br/>
						http://www.youtube.com/watch?v=VIDEOID<br/>
						http://youtu.be/VIDEOID<br/>
						http://vimeo.com/VIDEOID</span>' )
				);

				$fields['external_url'] = array (
					'label'		=> "External URL",
					'input' 	=> 'text',
					'value' 	=> get_post_meta( $post->ID, 'sgg_external_url', true ),
					'helps' 	=> __( 'Works only if Lightboxes disabled.' )
				);
			}

			return $fields;
			
		}

		
		/**
		 * Save attachment fields
		 * 
		 * @author Ilya K.
		 * @since 1.3
		 */
		
		function fields_to_save ( $post, $attachment ) {
			
			// Iframe URL
			if ( isset( $attachment['iframe_url'] ) )
				update_post_meta( $post['ID'], 'sgg_iframe_url', $attachment['iframe_url'] );

			// External URL
			if ( isset( $attachment['external_url'] ) )
				update_post_meta( $post['ID'], 'sgg_external_url', $attachment['external_url'] );

			return $post;
		}

	}
}

// Create Grid Gallery instance
$smart_grid_gallery = new SmartGridGallery();


/**
 * Template tag
 * 
 */

if ( ! function_exists( "smart_grid" ) ) {

	function smart_grid ( $grid_atts = array(), $images_atts = array() ) {

		$post = get_post();

		$grid = new JustifiedGallery( $grid_atts );

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $images_atts['orderby'] ) ) {
			$images_atts['orderby'] = sanitize_sql_orderby( $images_atts['orderby'] );
			if ( !$images_atts['orderby'] )
				unset( $images_atts['orderby'] );
		}

		// Extract only [gallery] attributes
		extract( shortcode_atts( array(
			'order'		=> 'ASC',
			'orderby'	=> 'ID',
			'ids'		=> '',
			'id'		=> $post ? $post->ID : 0
		), $images_atts ) );

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		// Get images IDs
		if ( empty( $ids ) ) {
			$attachments = get_children( array(
				'post_parent' 		=> $id, 
				'post_status' 		=> 'inherit', 
				'post_type' 		=> 'attachment', 
				'post_mime_type' 	=> 'image', 
				'order' 			=> $order, 
				'orderby' 			=> $orderby ) );

			$ids = array_keys( $attachments );
		}

		// Check IDs
		if ( ! is_array( $ids ) ) {
			echo "<b>Wrong IDs format</b><br/>";
			return;
		}

		// Exclude wrong ids
		foreach ( $ids as $key => $id ) {
			if ( ! wp_attachment_is_image( $id ) )
				unset ( $ids[$key] );
		}

		if ( empty ( $ids ) ) {
			echo "<b>No images found</b><br/>";
			return;
		}

		// IDs are Ok
		$ids = implode(',', $ids );

		$gallery_shortcode = "[gallery ids=\"$ids\"]";
				
		$grid->show( $gallery_shortcode );
	}

}

/**
 * Open extreranl links in new tab.
 */

/*add_filter( "smart_grid_external_link_target", "sgg_external_link_target" );
function sgg_external_link_target( $target ) {
	return "_blank";
}*/

?>