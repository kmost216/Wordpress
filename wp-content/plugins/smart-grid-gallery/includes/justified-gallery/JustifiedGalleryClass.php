<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'JustifiedGallery' ) ) {

	class JustifiedGallery {

		public $ID;
		public $shortcode_atts;
		public $gallery_atts;
		public $lightbox;
		public $lightbox_atts;

		/**
		 * Constructor function parse all shortcode attributes 
		 * and create slider instance
		 * 
		 * @param array $atts
		 */
		
		function __construct( $atts ) {

			$this->ID = $this->unique_ID(); // Generate ID for multiple sliders on one page

			$atts = $this->to_camel_case( $atts ); // Transform $atts keys to CamelCase

			// Gallery defaults
			$this->gallery_atts = shortcode_atts( array(
				
				// Available in generator
				"rowHeight" 				=> 200,
				"mobileRowHeight" 			=> 200,
				"margins" 					=> 10,
				"lastRow" 					=> 'nojustify', // or can be 'justify' or 'hide'
				"fixedHeight" 				=> 'false',
				"captions" 					=> 'true',
				"captionsColor"				=> '#000000',
				"captionsOpacity" 			=> '0.7',
				"randomize" 				=> 'false',

				// Not presented in generator
				"maxRowHeight" 				=> 0, 			// negative value = no limits, 0 = 1.5 * rowHeight
				"rel" 						=> $this->ID, 	// rewrite the rel of each analyzed links
				"target" 					=> 'null', 		// rewrite the target of all links
				"refreshTime" 				=> 250,
				
				"cssAnimation"				=> 'true',		// Use or not css animations. Using css animations you can change the behavior changing the justified gallery CSS file, or rewriting that rules.
				"captionsAnimationDuration" => 500,			// Caption fadeIn/fadeOut duration.
				"imagesAnimationDuration"	=> 300,			// Image fadeIn duration.
				"captionsVisibleOpacity"	=> 0.7,

				"class"						=> "" 			// Custom class for styling

			), $atts );

			// Plugin defaults
			$this->shortcode_atts = shortcode_atts( array(
				"lightbox"		=> "photo-swipe",
				"style"			=> '1',
				
				// Font
				"fontType"		=> 'regular',
				"fontSize"		=> '1em',
				"fontWeight"	=> '400',
				"fontColor"		=> '#ffffff',
				"fontFamily"	=> 'Helvetica, Arial, sans-serif',
				"googleFont"	=> 'Lobster',
				
				// Load more
				"loadMore"			=> 'scroll', 	// or 'button'
				"buttonText"		=> 'Load More',
				"buttonBackground"	=> '#444444',
				"buttonTextColor"	=> '#ffffff',
				"buttonStyle"		=> 'square', 	// round, circle
				"buttonSize"		=> 'medium', 	// small, big
			), $atts );
			
			// support shortcodes if someone used photobox
			if ( $this->shortcode_atts['lightbox'] == "photobox" ) {
				$this->shortcode_atts['lightbox'] = "photo-swipe";
			}
			$this->lightbox = $this->shortcode_atts['lightbox'];

			// Swipebox defaults
			if ( $this->lightbox == "swipebox" ) {
				
				$this->lightbox_atts = shortcode_atts( array(
					// Available in generator
					"hideBarsOnMobile" 	=> "true", // false will show the caption and navbar on mobile devices
					"hideBarsDelay" 	=> "3000", // delay before hiding bars
				), $atts );
			}

			// Magnific Popup defaults
			if ( $this->lightbox == "magnific-popup" ) {
				
				$this->lightbox_atts = shortcode_atts( array(
					"title" 		=> 'true',
					"counter" 		=> "(A/B)",
				), $atts );

				// Update counter to Magnific Popup standard
				$this->lightbox_atts['counter'] = str_replace( "A", "%curr%", 	$this->lightbox_atts['counter'] );
				$this->lightbox_atts['counter'] = str_replace( "B", "%total%", 	$this->lightbox_atts['counter'] );
			}

			// PhotoSwipe defaults
			if ( $this->lightbox == "photo-swipe" ) {

				$this->lightbox_atts = shortcode_atts( array(
					"title" 		=> 'true',
					"share" 		=> 'true',

					// not presented in generator
					"print"			=> 'false',
					
					// not presented in docs
					"history" 		=> 'false'

				), $atts );

				// output HTML in th footer
				add_action("wp_footer", array( $this, "photoswipe_html") );
			}

			// Check for mobile devices
			if ( wp_is_mobile() ) {
				$this->gallery_atts['rowHeight'] = $this->gallery_atts['mobileRowHeight'];
			}

		}


		/**
		 * Show JustifiedGallery view
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function show( $content ) {

			$galleries = $this->parse_shortcodes( $content, "gallery" );

			if ( is_array( $galleries ) ) { 

				require 'views/justified-gallery.php';
			}
			else {
				echo "<p><b>".__("[gallery] shortcode not found inside [smart-grid][/smart-grid] shortcode", "topdevs")."</b></p>";
			}
		
		}


		/**
		 * Echo custom CSS based on shortcode params
		 *
		 * @author Ilya K.
		 * @since 1.3
		 */

		function custom_css() {
			?>
			<style>
	            #justified_gallery_<?php echo $this->ID; ?> .sgg-caption {
					background: rgb(<?php echo $this->hex2rgb($this->gallery_atts['captionsColor']); ?>);
					background: rgba(<?php echo $this->hex2rgb($this->gallery_atts['captionsColor']); ?>,<?php echo $this->gallery_atts['captionsOpacity']; ?>);
					color: <?php echo $this->shortcode_atts['fontColor']; ?>;
					font-size: <?php echo $this->shortcode_atts['fontSize']; ?>;
					font-weight: <?php echo $this->shortcode_atts['fontWeight']; ?>;
					font-family: <?php echo ( $this->shortcode_atts['fontType'] == 'google' ) ? $this->shortcode_atts['googleFont'] : $this->shortcode_atts['fontFamily']; ?>;
				}
				#load_more_<?php echo $this->ID; ?> {
				    background: <?php echo $this->shortcode_atts['buttonBackground']; ?>;
				    color: <?php echo $this->shortcode_atts['buttonTextColor']; ?>;
				}
			</style>
        	<?php 
		}


		/**
		 * Echo custom JS based on shortcode params
		 *
		 * @author Ilya K.
		 * @since 1.3
		 */

		function custom_js( $galleries ) {
			?>
			<script type="text/javascript">
				(function($){
					$("#justified_gallery_<?php echo $this->ID; ?>").justifiedGallery({
						<?php $this->gallery_atts_js(); ?>
					})
					.on('jg.complete', function(){
						<?php $this->lightbox_js(); ?>
					});
					<?php $this->direction_aware(); ?>
					<?php $this->google_font_js(); ?>
					<?php $this->infinite_scroll( $galleries ); ?>
				})(jQuery);
			</script>
			<?php 
		}


		/**
		 * Return array of shortcodes filtered by $name and parsed args presented in passed $content.
		 * Return 'false' if content has no shortcodes.
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function parse_shortcodes( $content, $name ) {

			$pattern = get_shortcode_regex();
			preg_match_all( '/'. $pattern .'/s', $content, $matches );

			$names 	= $matches[2];
			$args 	= $matches[3];

			if ( ! $args ) 
				return false;

			foreach ( $args as $key => $value ) {

				if ( $names[$key] == $name ) {

					$shortcodes[$key]['name'] = $names[$key];
					$shortcodes[$key]['args'] = shortcode_parse_atts( $value );
				}
			}

			return $shortcodes;
		}


		/**
		 * Echo images HTML as required by JustifiedGallery based on ids list
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function gallery_images( $args, $echo = false ) { 

			$ids = explode( ',', $args['ids'] );

			if ( ! $ids ) 
				return false;

			if ( $this->gallery_atts['maxRowHeight'] > 0 )
				$max_height = $this->gallery_atts['maxRowHeight'];
			
			if ( $this->gallery_atts['maxRowHeight'] == 0 )
				$max_height = $this->gallery_atts['rowHeight'] * 1.5;

			if ( $this->gallery_atts['maxRowHeight'] < 0 )
				$max_height = 1025;

			if ( $max_height > 1024 )
				$size = 'full';
			elseif ( $max_height > 780 )
				$size = 'large';
 			elseif ( $max_height > 540 )
				$size = 'sgg-780';
			elseif ( $max_height > 420 )
				$size = 'sgg-540';
 			elseif ( $max_height > 300 )
				$size = 'sgg-420';
 			else
				$size = 'medium';

			$size = apply_filters( "smart_grid_image_size", $size, $this->gallery_atts['maxRowHeight'] );

			if ( $echo ) {
				ob_start();
			}

			foreach ( $ids as $id ) {
				
				$image 		= get_post( $id );
				$image_src 	= wp_get_attachment_image_src( $id, 'full' );

				if ( ! $image_src ) {
					continue;
				}
				
				$thumb_src	= wp_get_attachment_image_src( $id, $size );

				// Check width 
				$thumb_width	= $thumb_src[1];
				$thumb_height 	= $thumb_src[2];

				if ( !$thumb_width || !$thumb_height ) {
					$thumb_src = wp_get_attachment_image_src( $id, 'full' );
				}
				else {
					$thumb_ratio = $thumb_width / $thumb_height;
	
					$max_width 	= $max_height * $thumb_ratio;

					if ( $size == 'medium' && $max_width > 300 )
						$thumb_src = wp_get_attachment_image_src( $id, 'sgg-420' );

					if ( $size == 'sgg-420' && $max_width > 420 )
 						$thumb_src = wp_get_attachment_image_src( $id, 'sgg-540' );
 
 					if ( $size == 'sgg-540' && $max_width > 540 )
						$thumb_src = wp_get_attachment_image_src( $id, 'sgg-780' );
				
					if ( $size == 'sgg-780' && $max_width > 1024 )
						$thumb_src = wp_get_attachment_image_src( $id, 'full' );
				}

				// Choose source for caption
				// First look at Caption
				$caption = trim( $image->post_excerpt );

				// Then look for ALT
				if ( empty( $caption ) )
					$caption = trim( get_post_meta( $id, '_wp_attachment_image_alt', true ) );
				
				// Names usually awful
				if ( empty( $caption ) )
					$caption = trim( $image->post_title ); // Finally, use the title

				$caption = str_replace("\"", "'", $caption);
				$caption = apply_filters( "smart_grid_image_caption", $caption );

				// Set the ALT attribute
				// First look for ALT
				$alt = trim( get_post_meta( $id, '_wp_attachment_image_alt', true ) );
				
				// If no ALT use Caption
				if ( empty( $alt ) )
					$alt = strip_tags( trim( $image->post_excerpt ) );
				
				// Names usually awful
				if ( empty( $alt ) )
					$alt = trim( $image->post_title ); // Finally, use the title

				$alt = str_replace("\"", "'", $alt);
				$alt = apply_filters( "smart_grid_image_alt", $alt );

				// Caption used in "Magnific Popup" and "SwipeBox" lightboxes
				$lightbox_caption = ( $caption );
				$lightbox_caption = apply_filters( "smart_grid_image_lightbox_caption", $lightbox_caption, $alt );

				// Get meta
				$embed_url 		= get_post_meta( $id, 'sgg_iframe_url', true );
				$external_url 	= get_post_meta( $id, 'sgg_external_url', true );

				// External link target
				$target = "";
				$target = apply_filters( "smart_grid_external_link_target", $target );

				//var_dump($embed_url);			
				
				// No lightbox
				if ( $this->shortcode_atts['lightbox'] == "none" ) {

					// External link
					if ( $external_url )
						echo "<a target=\"$target\" href=\"{$external_url}\"><img src=\"{$thumb_src[0]}\" data-caption=\"$caption\" alt=\"$alt\"/></a>";
					// Plain image 
					else
						echo "<div><img src=\"{$thumb_src[0]}\" data-caption=\"$caption\" alt=\"$alt\"/></div>";
				}
				
				// Link to image source
				elseif ( $this->shortcode_atts['lightbox'] == "image" )
					echo "<a href=\"{$image_src[0]}\"><img src=\"{$thumb_src[0]}\" data-caption=\"$caption\" alt=\"$alt\"/></a>";
				
				// Lightbox with Embed URL like YouTube or Vimeo
				elseif ( $embed_url )
					echo "<a class=\"sgg-lightbox-item mfp-iframe\" data-type=\"video\" href=\"{$embed_url}\" data-caption=\"$lightbox_caption\"><img src=\"{$thumb_src[0]}\" data-caption=\"$caption\" alt=\"$alt\"/></a>";

				// Lightbox
				else
					echo "<a class=\"sgg-lightbox-item\" href=\"{$image_src[0]}\" data-size=\"$image_src[1]x$image_src[2]\" data-caption=\"$lightbox_caption\"><img src=\"{$thumb_src[0]}\" data-caption=\"$caption\" alt=\"$alt\"/></a>";
			}

			if ( $echo ) {
				return ob_get_clean();
			}
	 	}

	 	
	 	/**
		 * Echo JustifiedGallery atts in JS format
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function gallery_atts_js () { 

			if ( ! $this->gallery_atts )
				return;

			$atts_output = "sizeRangeSuffixes : {'lt100': '', 'lt240': '', 'lt320': '', 'lt500': '', 'lt640': '', 'lt1024': ''},";
			$atts_output .= $this->js_atts( $this->gallery_atts );

			echo $atts_output;
		}


		/**
		 * Echo Lightbox js with atts
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function lightbox_js () { 

			$js = "";

			$rel = "&rel=0";
			
			// PhotoSwipe
			if ( $this->lightbox == "photo-swipe" ) {
			
				$js .= "$(document).ready(function(){
							var pswp_$this->ID = SGGinitPhotoSwipeFromDOM('#justified_gallery_$this->ID',";
				$js .= "{". $this->js_atts( $this->lightbox_atts ) . " uid: '$this->ID' })";
				$js .= "})";
			}

			// Swipebox
			if ( $this->lightbox == "swipebox" ) {
				
				$js .= "$('#justified_gallery_$this->ID a.sgg-lightbox-item').swipebox({";
				$js .= $this->js_atts( $this->lightbox_atts );
				$js .= "});";
			}

			// Magnific Popup
			if ( $this->lightbox == "magnific-popup" ) {
				
				$js .= "$('#justified_gallery_$this->ID a.sgg-lightbox-item').magnificPopup({";

				// Defaults
				$js .= "type: 'image',
						mainClass: 'mfp-with-zoom',
						closeOnContentClick: true,
						closeBtnInside: false,
						preloader: 'true',
						tLoading: '',
						tClose: '',";

				$js .= "image: {
							verticalFit: true";

				// Show title
				if ( $this->lightbox_atts['title'] == 'true' )
					$js .= ",titleSrc: function(item) {
								return item.el.attr('data-caption');
							}";
				else 
					$js .= ",titleSrc: function(item) {
								return \"\";
							}";

				$js .= "},";

				$js .= "zoom: {
							enabled: true,
							duration: 300
						},
						gallery: {
							enabled: true,
							tPrev: '',
    						tNext: '',
							tCounter: '".$this->lightbox_atts['counter']."'
						},";

				$js .= "iframe: {
						  markup: 
						    '<div class=\"mfp-iframe-scaler\">'+
							  '<div class=\"mfp-close\"></div>'+
							    '<iframe class=\"mfp-iframe\" frameborder=\"0\" allowfullscreen></iframe>'+
							  '<div class=\"mfp-title\"></div>'+
							'</div>',
						  patterns: {
						    youtube: {
						      index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
						      id: 'v=', // String that splits URL in a two parts, second part should be %id%
						      // Or null - full URL will be returned
						      // Or a function that should return %id%, for example:
						      // id: function(url) { return 'parsed id'; }
						      src: '//www.youtube.com/embed/%id%?showinfo=0$rel' // URL that will be set as a source for iframe. 
						    },
						    youtu_be: {
						      index: 'youtu.be/',
						      id: '/',
						      src: '//www.youtube.com/embed/%id%?showinfo=0$rel'
						    },
						    vimeo: {
						      index: 'vimeo.com/',
						      id: '/',
						      src: '//player.vimeo.com/video/%id%?byline=0&amp;portrait=0'
						    }
						  }
						},
						callbacks: {
						  markupParse: function(template, values, item) {
						   values.title = item.el.attr('data-caption');
						  }
						}";
				
				// Close
				$js .= "});";
			}

			echo $js;
		}


		/**
		 * Return atts in JS format
		 *
		 * @author Ilya K.
		 * @since 1.0
		 */

		function js_atts ( $atts ) {

			if ( ! is_array( $atts ) )
				return;

			$atts_output = "";

			foreach ( $atts as $key => $value ) {

				if ( is_numeric( $value ) || $value === 'true' || $value === 'false' || $value === 'null' )
					$atts_output .= "$key: $value,\r\n";
				else 
					$atts_output .= "$key: \"$value\",\r\n";
			}

			return $atts_output;
		}


		/**
		 * Echo JS for direction aware
		 * 
		 * @author Ilya K.
		 * @since 1.0
		 */

		function direction_aware() {

			if ( $this->shortcode_atts['style'] == 8 )
				require('views/direction-aware.js.php');
		}


		/**
		 * Google Web Fonts JS
		 *
		 * @author Ilya K.
		 * @since 1.1
		 */

		function google_font_js () { 
			
			if ( $this->shortcode_atts['fontType'] == 'google' ) {

				// Add script only once
				require_once('views/google-font.js.php');

				// Add to families
				echo "WebFontConfig.google.families.push('{$this->shortcode_atts['googleFont']}');";
			}
		}
		

		/**
		 * Infinite scroll JS
		 *
		 * @author Ilya K.
		 * @since 1.3
		 */

		function infinite_scroll( $galleries ) { ?>
				var galleries = [<?php foreach ( $galleries as $gallery ) : ?>
					"<?php echo htmlentities($this->gallery_images( $gallery['args'], true ), ENT_QUOTES) ?>",
				<?php endforeach; ?>];
				var gallery = $("#justified_gallery_<?php echo $this->ID; ?>");
				<?php if ( $this->shortcode_atts['loadMore'] != "button" ) : ?>$(window).scroll(function() {
					if ( galleries.length >= 1  ) {
						var scroll_top = $(window).scrollTop();
						var scroll_bottom = scroll_top + $(window).height();
						var gallery_top = $(gallery).offset().top;
						var gallery_height = $(gallery).innerHeight();
						var gallery_bottom = gallery_top + gallery_height;
						if( scroll_bottom >= gallery_bottom ) {
							var images = galleries.splice(0,1);
							var image_html = $("#load_more_holder_<?php echo $this->ID; ?>").html(images).text();
							$(gallery).append(image_html);
							$(gallery).justifiedGallery('norewind');
						}
					}
				});<?php else: ?>
				$("#load_more_<?php echo $this->ID; ?>").on('click', function() {
					if ( galleries.length >= 1  ) {
						var images = galleries.splice(0,1); 
						var image_html = $("#load_more_holder_<?php echo $this->ID; ?>").html(images).text();
						$(gallery).append(image_html);
						$(gallery).justifiedGallery('norewind');
						if ( galleries.length == 0 ) {
							$("#load_more_<?php echo $this->ID; ?>").css('display', 'none');
						}
					}
				});<?php endif;
		}


		/**
		 * Echo Load More button HTML
		 *
		 * @since 1.3
		 */

		private function load_more_button( $galleries ) {

			if ( sizeof( $galleries ) == 0 || $this->shortcode_atts['loadMore'] != "button" ) {
				return;
			}

			$classes = array (
				"sgg-load-more", 
				"sgg-button-{$this->shortcode_atts['buttonStyle']}",
			 	"sgg-button-{$this->shortcode_atts['buttonSize']}"
				);

			$classes = implode( " ", $classes );
			
			?>
			
			<button id="load_more_<?php echo $this->ID; ?>" class="<?php echo $classes; ?>">
				<?php echo $this->shortcode_atts['buttonText']; ?>
			</button>
			
			<?php
		}


		/**
		 * Output PhotoSwipe HTML
		 *
		 * @author Ilya K.
		 * @since 1.3
		 */

		public function photoswipe_html() {

			require_once('views/photoswipe.php');
		}


	 	/**
		 * Generate unique ID for multpile galleries on one page
		 *
		 * @since 1.0
		 */
		
		private function unique_ID( $length = 6 ) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}


		/**
		 * Transform $atts keys to CamelCase, as WordPress do not support CamelCase in shortcode atts
		 *
		 * @since 1.0
		 */
		
		private function to_camel_case( $atts ) {
			
			if ( ! $atts ) 
				return array();

			$new_atts = array();

			foreach ( $atts as $key => $value ) {

				$key = preg_replace_callback( '/_(.?)/', 
					array($this, "to_camel_case_callback"), $key );
				$new_atts[$key] = $value;
			}

			return $new_atts;
		}


		/**
		 * Callback for to_camel_case preg_replace_callback function
		 *
		 * @since 1.4.4
		 */

		function to_camel_case_callback($matches) {
			return strtoupper($matches[1]);
		}


		/**
		 * Convert HEX to RGB
		 *
		 * @since  1.0
		 */

		function hex2rgb($hex) {
			$hex = str_replace("#", "", $hex);

			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
			}
			$rgb = array($r, $g, $b);
			
			return implode(",", $rgb); // returns the rgb values separated by commas
		}
	}

}
?>