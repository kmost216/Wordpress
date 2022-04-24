<?php

$grid = array (
	"row_height" => array (
		"type"	=> 'text',
		"value"	=> '200',
		"units"	=> 'px',
		"title"	=> __('Row Height', 'topdevs'),
		"desc"	=> __('The approximate height of rows', 'topdevs'),
	),
	
	"mobile_row_height" => array (
		"type"	=> 'text',
		"value"	=> '200',
		"units"	=> 'px',
		"title"	=> __('Mobile Row Height', 'topdevs'),
		"desc"	=> __('The approximate height of rows on mobile devices (phones, tablets). <b>Does not consider resolution, window width, or any other factors!</b>', 'topdevs'),
	),

	"fixed_height" => array (
		"type"	=> 'select',
		"value"	=> 'false',
		"options"	=> array (
			"false" => __('False', 'topdevs'),
			"true" 	=> __('True','topdevs'),
			),
		"title"	=> __('Fixed Height', 'topdevs'),
		"desc"	=> __('All the rows will be exactly with the specified "Row Height" if True', 'topdevs'),
	),

	"last_row" => array (
		"type"	=> 'select',
		"value"	=> 'nojustify',
		"options"   => array (
			"justify" 		=> __('Justify', 'topdevs'),
			"nojustify" 	=> __('No justify', 'topdevs'),
			"hide" 			=> __('Hide', 'topdevs'),
			),
		"title"	=> __('Last Row', 'topdevs'),
		"desc"  => __('Decide if you want to "Justify" the last row or not, or to "Hide" the row if it can\'t be justified', 'topdevs'),
	),
	
	"margins" => array (
		"type"  => 'text',
		"value" => '10',
		"units" => 'px',
		"title"	=> __('Margin', 'topdevs'),
		"desc"  => __('Margin between images', 'topdevs'),
	),

	"randomize" => array (
		"type"  => 'select',
		"value" => 'false',
		"options"   => array (
			"false" => __('False', 'topdevs'),
			"true" 	=> __('True',  'topdevs'),
			),
		"title"	=> __('Randomize Images', 'topdevs'),
		"desc"  => __('Set to "True" to show images in random order', 'topdevs'),
	),

	"load_more" => array (
		"type"  => 'select',
		"value" => 'scroll',
		"options"   => array (
			"scroll" 	=> __('On scroll', 'topdevs'),
			"button" 	=> __('On button click', 'topdevs'),
			),
		"title"	=> __('Load More', 'topdevs'),
		"desc"  => __('Automatically load next [gallery] shortcode on page scroll or on "Load More" button click. <br/>Only for [smart-grids] with multiple [gallery] shortcodes inside.', 'topdevs'),
	),

	"button_text" => array (
		"type"  => 'text',
		"value" => 'Load More',
		"units" => '',
		"title"	=> __('Button Text', 'topdevs'),
		"desc"  => '',
		"condition" => array (
				"load_more" => "button",
			),  
	),

	"button_background" => array (
		"type"  => 'color',
		"value" => '#444444',
		"title" => __('Background Color', 'topdevs'),
		"desc"  => __('HEX color code for button background. <br/>(Your template styles may interfere)', 'topdevs'),
		"condition" => array (
				"load_more" => "button",
			),
	),

	"button_text_color" => array (
		"type"  => 'color',
		"value" => '#ffffff',
		"title" => __('Text Color', 'topdevs'),
		"desc"  => __('HEX color code for button text. <br/>(Your template styles may interfere)', 'topdevs'),
		"condition" => array (
				"load_more" => "button",
			), 
	),

	"button_style" => array (
		"type"	=> 'select',
		"value"	=> 'square',
		"options"   => array (
			"square"	=> __('Square', 'topdevs'),
			"round" 	=> __('Round', 'topdevs'),
			"circle" 	=> __('Circle', 'topdevs'),
			),
		"title" => __('Button Style', 'topdevs'),
		"desc"  => __('Choose button shape. <br/>(Your template styles may interfere)', 'topdevs'),
		"condition" => array (
				"load_more" => "button",
			), 
	),

	"button_size" => array (
		"type"	=> 'select',
		"value"	=> 'medium',
		"options"   => array (
			"small"		=> __('Small', 'topdevs'),
			"medium" 	=> __('Medium', 'topdevs'),
			"big" 		=> __('Big', 'topdevs'),
			),
		"title" => __('Button Size', 'topdevs'),
		"desc"  => __('Choose button size. <br/>(Your template styles may interfere)', 'topdevs'),
		"condition" => array (
				"load_more" => "button"
			) 
	),

	);

$captions = array (

	"captions" => array (
		"type"  => 'select',
		"value" => 'true',
		"options"   => array (
			"false" => 'Hide',
			"true" 	=> 'Show',
			),
		"title" => __('Show Captions', 'topdevs'),
		"desc"  => __('Decide Show or not image captions', 'topdevs'),
	),

	"style" => array (
		"type"	=> 'select',
		"value"	=> '1',
		"options"   => array (
			"1" 	=> __('1 - Fade', 'topdevs'),
			"2" 	=> __('2 - Fade & Image Zoom', 'topdevs'),
			"3" 	=> __('3 - Slide Up', 'topdevs'),
			"4" 	=> __('4 - Slide Up Full', 'topdevs'),
			"5" 	=> __('5 - Slide Down Full', 'topdevs'),
			"6" 	=> __('6 - Slide Right Full', 'topdevs'),
			"7" 	=> __('7 - Slide Left Full', 'topdevs'),
			"8" 	=> __('8 - Direction Aware', 'topdevs'),
			"9" 	=> __('9 - Slide Up Full & Image Out', 'topdevs'),
			"10" 	=> __('10 - Slide Down Full & Image Out', 'topdevs'),
			"11" 	=> __('11 - Caption Fade Out', 'topdevs'),
			"12" 	=> __('12 - Caption Always Bottom', 'topdevs'),
			"13" 	=> __('13 - Caption Fade Out/Fade In (Odd/Even)', 'topdevs'),
			),
		"title" => __('Captions Style', 'topdevs'),
		"desc"  => __('Captions Hover Style. <a target="_blank" href="http://topdevs.net/smart-grid-gallery/wordpress-gallery-hover-effects/">See examples</a>', 'topdevs'),
		"condition" => array (
				"captions" => "true",
			),
	),

	"captions_color" => array (
		"type"  => 'color',
		"value" => '#000000',
		"title" => __('Captions Color', 'topdevs'),
		"desc"  => __('HEX color code for captions background', 'topdevs'),
		"condition" => array (
				"captions" => "true",
			),
	),

	"captions_opacity" => array (
		"type"  => 'text',
		"value" => '0.7',
		"title" => __('Captions opacity', 'topdevs'),
		"desc"  => __('Captions background opacity. Use \'.\' as decimal separator', 'topdevs'),
		"condition" => array (
				"captions" => "true",
			),
	)
);

$font = array (

	"font_type" => array (
		"type"	=> 'select',
		"value"	=> 'regular',
		"options"   => array (
			"regular"	=> __('Regular Font Family', 'topdevs'),
			"google" 	=> __('Google Web Font', 'topdevs'),
			),
		"title" => __('Font Type', 'topdevs'),
		"desc"  => __('Choose if you want to use regular font family or <a target="_blank" href="https://www.google.com/fonts#AboutPlace:about">Google Font</a>', 'topdevs'),
	),

	"font_family" => array (
		"type"	=> 'text',
		"value"	=> 'Helvetica, Arial, sans-serif',
		"title"	=> __('Font Family', 'topdevs'),
		"desc"	=> __('Use <a target="_blank" href="http://www.w3schools.com/cssref/css_websafe_fonts.asp">Web Safe Font</a> or any font family available in your theme', 'topdevs'),
		"condition" => array (
				"font_type" => "regular",
			),
	),

	"google_font" => array (
		"type"	=> 'text',
		"value"	=> 'Lobster',
		"title"	=> __('Google Web Font', 'topdevs'),
		"desc"	=> __('Use any <a target="_blank" href="https://www.google.com/fonts">Google Font</a> name like "Open Sans", "Roboto" or "Droid Serif"', 'topdevs'),
		"condition" => array (
				"font_type" => "google",
			),
	),

	"font_color" => array (
		"type"  => 'color',
		"value" => '#ffffff',
		"title" => __('Font Color', 'topdevs'),
		"desc"  => __('HEX color code for captions texts', 'topdevs'),
	),
	
	"font_size" => array (
		"type"	=> 'text',
		"value"	=> '1em',
		"title"	=> __('Font Size', 'topdevs'),
		"desc"	=> __('Captions font size. Can be px, em or %', 'topdevs'),
	),

	"font_weight" => array (
		"type"	=> 'select',
		"value"	=> '400',
		"options"   => array (
			"normal" 	=> 'normal',
			"bold" 		=> 'bold',
			"bolder" 	=> 'bolder',
			"lighter" 	=> 'lighter',
			"100" 		=> '100',
			"200" 		=> '200',
			"300" 		=> '300',
			"400" 		=> '400',
			"500" 		=> '500',
			"600" 		=> '600',
			"700" 		=> '700',
			"800" 		=> '800',
			"900" 		=> '900',
			),
		"title" => __('Font Weight', 'topdevs'),
		"desc"  => __('Captions font weight', 'topdevs'),
	),

	);

$lightbox = array (

	"lightbox" => array (
		"type"	=> 'select',
		"value"	=> 'photo-swipe',
		"options"   => array (
			"none" 				=> __('None', 'topdevs'),
			"image"				=> __('Link to image source', 'topdevs'),
			"photo-swipe" 		=> __('PhotoSwipe', 'topdevs'),
			"magnific-popup" 	=> __('Magnific Popup', 'topdevs'),
			"swipebox" 			=> __('Swipebox', 'topdevs'),
			),
		"title" => __('Lightbox', 'topdevs'),
		"desc"  => '',
	),
	
	"title" => array (
		"type"  => 'select',
		"value" => 'true',
		"options"   => array (
			"true" 	=> __('True', 'topdevs'),
			"false" => __('False', 'topdevs'),
			),
		"title" => __('Image Title', 'topdevs'),
		"desc"  => __('Set to "False" to hide image title', 'topdevs'),
		"condition" => array (
				"lightbox" => "photo-swipe,magnific-popup",
			)
	 ),

	"share" => array (
		"type"  => 'select',
		"value" => 'true',
		"options"   => array (
			"true" 	=> __('True', 'topdevs'),
			"false" => __('False', 'topdevs'),
			),
		"title" => __('Social Share', 'topdevs'),
		"desc"  => __('Enable social sharing options', 'topdevs'),
		"condition" => array (
				"lightbox" => "photo-swipe",
			)
	 ),

	"counter" => array (
		"type"	=> 'text',
		"value"	=> '(A/B)',
		"title"	=> __('Counter', 'topdevs'),
		"desc"	=> __('Counts which piece of content (A) is being viewed, relative to the total count (B) of items', 'topdevs'),
		"condition" => array (
				"lightbox" => "magnific-popup",
			),
	 ),

	
	"hide_bars_on_mobile" => array (
		"type"  => 'select',
		"value" => 'true',
		"options"   => array (
			"true" 	=> __('Hide', 'topdevs'),
			"false" => __('Show', 'topdevs'),
			),
		"title" => __('Bars On Mobile', 'topdevs'),
		"desc"  => __('\'Show\' or \'Hide\'the caption and navbar on mobile devices', 'topdevs'),
		"condition" => array (
				"lightbox" => "swipebox",
			) 
		),

	"hide_bars_delay" => array (
		"type"	=> 'text',
		"value"	=> '3000',
		"units" => 'ms',
		"title"	=> __('Hide Bars Delay', 'topdevs'),
		"desc"	=> __('Delay before hiding bars', 'topdevs'),
		"condition" => array (
				"lightbox" => "swipebox",
			) 
		),

	);

$params = array (
	"grid" => array (
		"title" 	=> '<div class="dashicons dashicons-screenoptions"></div>'. __('Grid', 'topdevs'),
		"params"	=> $grid,
		),
	"captions" => array (
		"title" 	=> '<div class="dashicons dashicons-editor-quote"></div>'. __('Captions', 'topdevs'),
		"params"	=> $captions,
		),
	"font" => array (
		"title" 	=> '<div class="dashicons dashicons-editor-paste-text"></div>'. __('Typography', 'topdevs'),
		"params"	=> $font,
		),
	"lightbox" => array (
		"title" 	=> '<div class="dashicons dashicons-external"></div>'. __('Lightbox', 'topdevs'),
		"params"	=> $lightbox,
		),
	);

// Create instance
$sgg_tinymce = new SmartGridGalleryTinyMCE( 'sgg_', $params );

?>