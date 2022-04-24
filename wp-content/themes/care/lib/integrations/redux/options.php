<?php

$opt_name = CARE_THEME_OPTION_NAME;

if ( ! class_exists('Redux')) {
	return;
}

$other_settings = '';
$sass_vars_file = get_template_directory() . '/lib/integrations/redux/css/other-settings/vars.scss';
if ( file_exists( $sass_vars_file ) ) {
	ob_start();
	include $sass_vars_file;
	$other_settings = ob_get_clean();
}
// ----------------------------------
// -> General
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-general',
	'title'  => esc_html__( 'General Settings', 'care' ),
	'icon'   => 'el-icon-home',
	'fields' => array(
		array(
			'id'       => 'custom-js-code',
			'type'     => 'ace_editor',
			'title'    => esc_html__( 'JS Code', 'care' ),
			'subtitle' => esc_html__( 'Paste your JS code here.', 'care' ),
			'mode'     => 'javascript',
			'theme'    => 'monokai',
			'default'  => "jQuery(document).ready(function(){\n\n});"
		),
		array(
			'id'          => 'custom-thumbnail-sizes',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Custom Thumbnail Sizes', 'care' ),
			'subtitle'    => esc_html__( 'Pipe separated list of custom thumbnail size names and sizes.', 'care' ),
			'description' => esc_html__( 'Please use this format: <br><strong>custom-thumbnail-size:500x500|another-custom-thumbnail-size:320x150</strong>. <br>No spaces allowed. Thumnail Sizes you register here will only be applied to any new image from now on. If you wish to apply them on any of the old images we recomend using <a href="http://wordpress.org/plugins/regenerate-thumbnails/">Regenerate Thumbnails Plugin</a>',
				'care' ),
			'mode'        => 'text',
			'theme'       => 'monokai',
			'default'     => ""
		),
		array(
			'id'       => 'top-bar-layout-block',
			'type'     => 'select',
			'title'    => esc_html__('Top Bar Layout Block', 'care'),
			'data'     => 'posts',
			'args'     => array('post_type' => array('layout_block')),
		),
		array(
			'id'       => 'footer-layout-block',
			'type'     => 'select',
			'title'    => esc_html__('Footer Layout Block', 'care'),
			'data'     => 'posts',
			'args'     => array('post_type' => array('layout_block')),
		),
		array(
			'id'    => 'header-layout-block-mobile',
			'type'  => 'select',
			'title' => esc_html__( 'Mobile Header Layout Block', 'care' ),
			'data'  => 'posts',
			'args'  => array( 'post_type' => array( 'layout_block' ), 'posts_per_page' => - 1 ),
		),
		array(
			'id'      => 'header-mobile-break-point',
			'type'    => 'spinner',
			'title'   => esc_html__( 'Header Mobile Show Bellow', 'care' ),
			'desc'    => esc_html__( 'Set the width of the screen in px bellow which the Mobile header is shown.', 'care' ),
			'default' => '767',
			'min'     => '50',
			'max'     => '2000',
			'step'    => '1',
		),
	),
) );
// -> End General


// ----------------------------------
// -> Styling
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-styling',
	'icon'   => 'el-icon-website',
	'title'  => esc_html__( 'Styling', 'care' ),
	'fields' => array(
		array(
		    'id'       => 'global-accent-color',
		    'type'     => 'color',
		    'title'    => esc_html__( 'Global Accent Color', 'care' ),
		    'desc'     => esc_html__( 'This color will be used accross the site.', 'care' ),
			'compiler' => 'true',
		    'default'  => '#ffc000',
		    'validate' => 'color',
		),
		array(
			'id'       => 'custom-css',
			'type'     => 'ace_editor',
			'title'    => esc_html__( 'Custom CSS Code', 'care' ),
			'subtitle' => esc_html__( 'Paste your CSS code here.', 'care' ),
			'compiler' => 'true',
			'mode'     => 'css',
			'theme'    => 'monokai',
			'default'  => '',
			'options'  => array(
				'minLines'=> 50
			),
		),
	)
) );
// -> End Styling

// ----------------------------------
// -> Body
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-body',
	'title'  => esc_html__( 'Body', 'care' ),
	'icon'   => 'el-icon-check-empty',
	'fields' => array(
		array(
			'id'       => 'container-width',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => esc_html__( 'Container Width', 'care' ),
			'compiler' => array( '.cbp-container', '#tribe-events-pg-template' ),
			'height'   => false,
			'mode'     => 'max-width',
			'default'  => array(
				'width' => '980',
				'units' => 'px',
			),
		),
		array(
			'id'       => 'boxed-outer-container-width',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => esc_html__( 'Boxed Outer Container Width', 'care' ),
			'subtitle' => esc_html__( 'This is only applicable when "Boxed" page template is used.', 'care' ),
			'compiler' => array( '.wh-main-wrap' ),
			'height'   => false,
			'mode'     => 'max-width',
			'default'  => array(
				'width' => '1100',
				'units' => 'px',
			),
		),
		array(
			'id'       => 'body-background',
			'type'     => 'background',
			'compiler' => array( 'body' ),
			'title'    => esc_html__( 'Background', 'care' ),
		),
		array(
			'id'          => 'body-typography',
			'type'        => 'typography',
			'title'       => esc_html__( 'Font', 'care' ),
			'subtitle'    => esc_html__( 'Specify the body font properties.', 'care' ),
			'google'      => true,
			'text-align'  => false,
			'line-height' => false,
			'compiler'    => array( 'body' ),
			'default'     => array(
				'color'       => '#333',
				'font-size'   => '14px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'       => 'body-link-color',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Link Color', 'care' ),
			'compiler' => array( 'a' ),
			'default'  => array(
				'regular' => '#353434',
				'hover'   => '#585757',
				'active'  => '#353434',
			)
		),
		array(
			'id'             => 'main-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-padding' , '#tribe-events-pg-template'),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Padding', 'care' ),
			'desc'    => esc_html__( 'This is where you select a padding for all layout elements. For widgets compiled from a page you need to set the padding on each widget.',
				'care' ),
			'default'        => array(
				'padding-top'    => '20px',
				'padding-right'  => '20px',
				'padding-bottom' => '20px',
				'padding-left'   => '20px',
				'units'          => 'px',
			)
		),
	)
) );



Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-body-headings',
	'title'      => esc_html__( 'Headings', 'care' ),
	'fields'     => array(
		array(
			'id'         => 'headings-typography-h1',
			'type'       => 'typography',
			'title'      => esc_html__( 'H1', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h1', 'h1 a' ),
			'default'    => array(
				'font-size'   => '48px',
				'line-height' => '52px',
			),
		),
		array(
			'id'             => 'headings-margin-h1',
			'type'           => 'spacing',
			'compiler'       => array( 'h1', 'h1 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H1 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '33px',
				'margin-right'  => 0,
				'margin-bottom' => '33px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h2',
			'type'       => 'typography',
			'title'      => esc_html__( 'H2', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h2', 'h2 a' ),
			'default'    => array(
				'font-size'   => '30px',
				'line-height' => '34px',
			),
		),
		array(
			'id'             => 'headings-margin-h2',
			'type'           => 'spacing',
			'compiler'       => array( 'h2', 'h2 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H2 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '25px',
				'margin-right'  => 0,
				'margin-bottom' => '25px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h3',
			'type'       => 'typography',
			'title'      => esc_html__( 'H3', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h3', 'h3 a' ),
			'default'    => array(
				'font-size'   => '22px',
				'line-height' => '24px',
			),
		),
		array(
			'id'             => 'headings-margin-h3',
			'type'           => 'spacing',
			'compiler'       => array( 'h3', 'h3 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H3 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '22px',
				'margin-right'  => 0,
				'margin-bottom' => '22px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h4',
			'type'       => 'typography',
			'title'      => esc_html__( 'H4', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h4', 'h4 a' ),
			'default'    => array(
				'font-size'   => '20px',
				'line-height' => '24px',
			),
		),
		array(
			'id'             => 'headings-margin-h4',
			'type'           => 'spacing',
			'compiler'       => array( 'h4', 'h4 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H4 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '25px',
				'margin-right'  => 0,
				'margin-bottom' => '25px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h5',
			'type'       => 'typography',
			'title'      => esc_html__( 'H5', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h5', 'h5 a' ),
			'default'    => array(
				'font-size'   => '18px',
				'line-height' => '22px',
			),
		),
		array(
			'id'             => 'headings-margin-h5',
			'type'           => 'spacing',
			'compiler'       => array( 'h5', 'h5 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H5 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '30px',
				'margin-right'  => 0,
				'margin-bottom' => '30px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
		array(
			'id'         => 'headings-typography-h6',
			'type'       => 'typography',
			'title'      => esc_html__( 'H6', 'care' ),
			'google'     => true,
			'text-align' => false,
			'compiler'   => array( 'h6', 'h6 a' ),
			'default'    => array(
				'font-size'   => '16px',
				'line-height' => '20px',
			),
		),
		array(
			'id'             => 'headings-margin-h6',
			'type'           => 'spacing',
			'compiler'       => array( 'h6', 'h6 a' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'H6 Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '36px',
				'margin-right'  => 0,
				'margin-bottom' => '36px',
				'margin-left'   => 0,
				'units'         => 'px',
			)
		),
	)
) );
// -> End Body

// ----------------------------------
// -> Header
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'header',
	'title'  => esc_html__( 'Header', 'care' ),
	'icon'   => 'el-icon-delicious',
	'fields' => array(
		array(
			'id'       => 'header-background',
			'type'     => 'background',
			'compiler' => array( '.wh-header, .respmenu-wrap' ),
			'title'    => esc_html__( 'Background', 'care' ),
			'subtitle' => esc_html__( 'Pick a background color for the header', 'care' ),
			'default'  => array(
				'background-color' => '#bfbfbf'
			),
		),
		array(
			'id'       => 'logo',
			'type'     => 'media',
			'title'    => esc_html__( 'Logo', 'care' ),
			'url'      => true,
			'mode'     => false,
			'subtitle' => esc_html__( 'Upload logo', 'care' ),

		),
		array(
			'id'       => 'logo-sticky',
			'type'     => 'media',
			'title'    => esc_html__( 'Sticky Menu Logo', 'care' ),
			'url'      => true,
			'mode'     => false,
			'subtitle' => esc_html__( 'If not set Logo will be used in sticky menu.', 'care' ),

		),
		array(
		    'id'       => 'logo-location',
		    'type'     => 'select',
		    'title'    => esc_html__( 'Logo Location', 'care' ),
		    'options'  => array(
		        'main_menu' => 'Main Menu',
		        'no_show' => 'Do not show',
			),
		    'default'  => array('main_menu'),
		),
		array(
			'id'            => 'logo-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Logo Width/ Menu Width', 'care' ),
			'subtitle'      => esc_html__( 'Drag the slider to change logo width.', 'care' ),
			'desc'          => esc_html__( 'The grid has 12 steps. If Logo location is set to Main Menu, the menu will take what is left up to 12. If logo is set to 12 menu will also take up 12 and will be put bellow it.',
				'care' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label',
		),
		array(
			'id'       => 'logo-width-exact',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => esc_html__( 'Logo Width', 'care' ),
			'desc'     => esc_html__( 'Set exact logo width', 'care' ),
			'height'   => false,
			'default'  => array(

			),
		),
		array(
			'id'       => 'logo-sticky-width-exact',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'title'    => esc_html__( 'Sticky Logo Width', 'care' ),
			'desc'     => esc_html__( 'Set exact sticky logo width', 'care' ),
			'height'   => false,
			'default'  => array(

			),
		),
		array(
			'id'             => 'logo-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-logo' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'right'          => false,
			'left'           => false,
			'bottom'         => false,
			'title'          => esc_html__( 'Logo Margin Top', 'care' ),
			'default'        => array(
				'units'          => 'px',
			),

		),
		array(
			'id'       => 'logo-alignment',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Logo Alignment', 'care' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
		),
		array(
			'id'       => 'main-menu-alignment',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Menu Alignment', 'care' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'right',
		),
		array(
			'id'      => 'header-padding-override',
			'type'    => 'switch',
			'title'   => esc_html__( 'Override Header Padding', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'             => 'header-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-main-menu-bar-wrapper > .cbp-container > div' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Header Padding', 'care' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'header-padding-override', 'equals', '1' ),
			),

		),
	)
) );


Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-main-menu',
	'title'      => esc_html__( 'Main Menu', 'care' ),
		'fields'     => array(
			array(
			    'id'             => 'menu-main-top-level-typography',
			    'type'           => 'typography',
			    'title'          => esc_html__( 'Top Level Items Typography', 'care' ),
			    'google'         => true,
			    'font-backup'    => true,
			    'color'          => false,
			    'text-transform' => true,
			    'all_styles'     => true,
			    'compiler'         => array(
			    	'.sf-menu.wh-menu-main a',
			    	'.respmenu li a',
		    	),
			    'units'          => 'px',
			    'default'        => array(
			        'font-style'    => '700',
			        'font-family'   => 'Abel',
			        'google'        => true,
			        'font-size'     => '18px',
			        'line-height'   => '24px'
			    ),
			),
			array(
			    'id'             => 'menu-main-sub-items-typography',
			    'type'           => 'typography',
			    'title'          => esc_html__( 'Subitems Typography', 'care' ),
			    'google'         => true,
			    'font-backup'    => true,
			    'color'          => false,
			    'text-transform' => true,
			    'all_styles'     => true,
			    'compiler'         => array( '.sf-menu.wh-menu-main ul li a' ),
			    'units'          => 'px',
			    'default'        => array(
			        'font-style'    => '700',
			        'font-family'   => 'Abel',
			        'google'        => true,
			        'font-size'     => '16px',
			        'line-height'   => '24px'
			    ),
			),
			array(
			    'id'        => 'main-menu-link-color',
			    'type'      => 'link_color',
			    'title'     => esc_html__( 'Menu Item Link Color', 'care' ),
			    'active'    => false,
			    'compiler'     => array(
			    	'.sf-menu.wh-menu-main a', 
			    	'.respmenu li a', 
			    	'.cbp-respmenu-more',
		    	),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'        => 'main-menu-menu-item-hover-background',
			    'type'      => 'background',
			    'compiler'    => array(
			    	'.sf-menu.wh-menu-main > li:hover',
			    	'.sf-menu.wh-menu-main > li.sfHover',
		    	),
			    'title'     => esc_html__( 'Menu Item Hover Background', 'care' ),
			    'subtitle'  => esc_html__( 'Pick a background color for the menu item on hover.', 'care' ),
			),
			array(
			    'id'        => 'main-menu-current-item-background',
			    'type'      => 'background',
			    'compiler'    => array(
				    '.sf-menu.wh-menu-main .current-menu-item',
				    '.respmenu_current'
			    ),
			    'title'     => esc_html__( 'Current Menu Item Background', 'care' ),
			    'subtitle'  => esc_html__( 'Pick a background color for the current menu item.', 'care' ),
			),
			array(
			    'id'        => 'main-menu-current-item-link-color',
			    'type'      => 'link_color',
			    'title'     => esc_html__( 'Current Menu Item Link Color', 'care' ),
			    'active'    => false,
			    'compiler'     => array( '.sf-menu.wh-menu-main .current-menu-item a' ),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'        => 'main-menu-submenu-item-background',
			    'type'      => 'background',
			    'compiler'    => array(
					'.sf-menu.wh-menu-main ul li',
					'.sf-menu.wh-menu-main .sub-menu',
				),
			    'title'     => esc_html__( 'Submenu Menu Item Background', 'care' ),
			    'default'   => array(
			        'background-color'   => '#fff',
			    ),
			),
			array(
			    'id'        => 'main-menu-submenu-item-hover-background',
			    'type'      => 'background',
			    'compiler'    => array(
			    	'.sf-menu.wh-menu-main ul li:hover',
			    	'.sf-menu.wh-menu-main ul ul li:hover',
		    	),
			    'title'     => esc_html__( 'Subenu Item Hover Background', 'care' ),
			    'subtitle'  => esc_html__( 'Pick a background color for the menu item on hover.', 'care' ),
			),
			array(
			    'id'        => 'main-menu-submenu-item-link-color',
			    'type'      => 'link_color',
			    'title'     => esc_html__( 'Submenu Item Link Color', 'care' ),
			    'active'    => false,
			    'compiler'     => array( '.sf-menu.wh-menu-main ul li a' ),
			    'default'   => array(
			        'regular'   => '#000',
			        'hover'     => '#333',
			    ),
			),
			array(
			    'id'             => 'main-menu-padding',
			    'type'           => 'spacing',
			    'compiler'         => array( '.wh-menu-main' ),
			    'mode'           => 'padding',
			    'units'          => array('px'),
			    'units_extended' => 'false',
			    'title'          => esc_html__( 'Padding Top/Bottom', 'care' ),
			    'description'    => esc_html__( 'Use it to better vertical align the menu', 'care' ),
			    'left' => false,
			    'right' => false,
			    'default'            => array(
			        'padding-top'    => '0',
			        'padding-bottom' => '0',
			        'units'          => 'px',
			    ),
			),
			array(
			    'id'        => 'main-menu-use-menu-is-sticky',
			    'type'      => 'switch',
			    'title'     => esc_html__( 'Enable Sticky Menu', 'care' ),
			    'default'   => 1,
			),
			array(
				'id'       => 'main-menu-sticky-background',
				'type'     => 'background',
				'title'    => esc_html__( 'Sticky Menu Background', 'care' ),
				'compiler' => array( '.wh-sticky-header .wh-main-menu-bar-wrapper' ),
				'default'  => array(
				   'background-color' => '#fff',
				),
			    'required' => array(
					array( 'main-menu-use-menu-is-sticky', 'equals', '1' ),
				),
			),
			array(
				'id'       => 'main-menu-sticky-link-color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Sticky Menu Link Color', 'care' ),
				'compiler' => array(
					'.wh-sticky-header .sf-menu.wh-menu-main > li > a',
				),
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular'  => '#000',
					'hover'    => '#333',
				)
			),
			array(
				'id'             => 'main-menu-sticky-padding',
				'type'           => 'spacing',
				'compiler'       => array( '.wh-sticky-header .wh-menu-main' ),
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Sticky Menu Padding', 'care' ),
				'description'    => esc_html__( 'Use it to better vertical align the menu', 'care' ),
				'left' => false,
				'right' => false,
				'default'            => array(
					'padding-top'    => '0',
					'padding-bottom' => '0',
					'units'          => 'px',
				),
				'required' => array(
					array( 'main-menu-use-menu-is-sticky', 'equals', '1' ),
				)
			),
			array(
			    'id'       => 'main-menu-sticky-border',
			    'type'     => 'border',
			    'title'    => esc_html__( 'Sticky Menu Border', 'care' ),
			    'compiler' => array( '.wh-sticky-header .wh-main-menu-bar-wrapper' ),
			    'all'      => false,
			    'bottom'   => true,
			    'top'      => false,
			    'left'     => false,
			    'right'    => false,
			    'default'  => array(
			        'border-color'  => '#f5f5f5',
			        'border-style'  => 'solid',
			        'border-bottom' => '1px',
			    )
			),
			array(
			    'id'          => 'main-menu-initial-waypoint-compensation',
			    'type'        => 'text',
			    'title'       => esc_html__( 'Initial Waypoint Scroll Compensation', 'care' ),
			    'description' => esc_html__( 'Enter number only.', 'care' ),
			    'validate'    => 'number',
			    'default'     => 120
			),

		)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-responsive-menu',
	'title'      => esc_html__( 'Responsive Menu', 'care' ),
    'fields'    => array(
        array(
            'id'        => 'respmenu-use',
            'type'      => 'switch',
            'compiler'  => 'true',
            'title'     => esc_html__( 'Use Responsive Menu?', 'care' ),
            'default'   => true,
        ),
        array(
            'id'        => 'respmenu-show-start',
            'type'      => 'spinner',
            'title'     => esc_html__( 'Display bellow', 'care' ),
            'desc'      => esc_html__( 'Set the width of the screen in px bellow which the menu is shown.', 'care' ),
            'default'   => '767',
            'min'   => '50',
            'max'   => '2000',
            'step'     => '1',
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
        array(
            'id'        => 'respmenu-logo',
            'type'      => 'media',
            'title'     => esc_html__( 'Logo', 'care' ),
            'url'       => true,
            'mode'      => false,
            'subtitle'  => esc_html__( 'Set logo image', 'care' ),
            'required' => array(
                array('respmenu-use','equals','1'),
            ),
        ),
        array(
            'id'       => 'respmenu-logo-dimensions',
            'type'     => 'dimensions',
            'units'    => array( 'em','px','%' ),
            'title'    => esc_html__( 'Logo Dimensions (Width/Height)', 'care' ),
            'compiler' => array( '.respmenu-header .respmenu-header-logo-link img' ),
            'required' => array(
                array( 'respmenu-use','equals','1' ),
            ),
        ),
	    array(
		    'id'       => 'respmenu-background',
		    'type'     => 'background',
		    'title'    => esc_html__( 'Background', 'care' ),
		    'compiler'         => array( '.respmenu-wrap' ),
		    'default'  => array(
			    'background-color' => '#fff',
		    ),
	    ),
	    array(
		    'id'       => 'respmenu-link-color',
		    'type'     => 'link_color',
		    'title'    => esc_html__( 'Menu Link Color', 'care' ),
		    'compiler' => array(
			    '.respmenu li a',
				'.cbp-respmenu-more'
		    ),
		    'active'   => false,
		    'visited'  => false,
		    'default'  => array(
			    'regular'  => '#000',
			    'hover'    => '#333',
		    )
	    ),
		array(
			'id'          => 'respmenu-display-switch-color',
			'type'        => 'color',
			'mode'        => 'border-color',
			'title'       => esc_html__( 'Display Toggle Color', 'care' ),
			'compiler'    => array( '.respmenu-open hr' ),
			'transparent' => false,
			'default'     => '#000',
			'validate'    => 'color',
		),
        array(
			'id'          => 'respmenu-display-switch-color-hover',
			'type'        => 'color',
			'mode'        => 'border-color',
			'title'       => esc_html__( 'Display Toggle Hover Color', 'care' ),
			'compiler'    => array( '.respmenu-open:hover hr' ),
			'transparent' => false,
			'default'     => '#999',
			'validate'    => 'color',
		),
        array(
            'id'        => 'respmenu-display-switch-img',
            'type'      => 'media',
            'title'     => esc_html__( 'Display Toggle Image', 'care' ),
            'url'       => true,
            'mode'      => false,
            'subtitle'  => esc_html__( 'Set the image to replace default 3 lines for menu toggle button.', 'care' ),
            'required' => array(
                array( 'respmenu-use','equals','1' ),
            ),
        ),
        array(
            'id'       => 'respmenu-display-switch-img-dimensions',
            'type'     => 'dimensions',
            'units'    => array( 'em','px','%' ),
            'title'    => esc_html__( 'Display Toggle Image Dimensions (Width/Height)', 'care' ),
            'compiler' => array( '.respmenu-header .respmenu-open img' ),
            'required' => array(
                array( 'respmenu-use','equals','1' ),
            ),
        ),
    )
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-header-embellishments',
	'title'      => esc_html__( 'Embellishments', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'header-embellishments-enable',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable', 'care' ),
			'default' => false,
		),
		array(
			'id'       => 'header-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-header-top' ),
			'title'    => esc_html__( 'Embellishment Top Background', 'care' ),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Top Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-header-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'header-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-header-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Top Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative top margin to pull it up.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-header-bottom' ),
			'title'    => esc_html__( 'Embellishment Bottom Background', 'care' ),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'header-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Bottom Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-header-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'header-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-header-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Bottom Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative bottom margin to pull it down.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'header-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Header

// ----------------------------------
// -> Page Title
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-page-title',
	'title'  => esc_html__( 'Page Title', 'care' ),
	'icon'   => 'el-icon-font',
	'fields' => array(
		array(
			'id'       => 'page-title-background',
			'type'     => 'background',
			'compiler' => array( '.wh-page-title-bar' ),
			'title'    => esc_html__( 'Background', 'care' ),
			'subtitle' => esc_html__( 'Pick a background color for the page title.', 'care' ),
			'default'  => array(
				'background-color' => '#bfbfbf'
			),
		),
		array(
			'id'             => 'page-title-typography',
			'type'           => 'typography',
			'title'          => esc_html__( 'Page Title Font', 'care' ),
			'subtitle'       => esc_html__( 'Specify the page title font properties.', 'care' ),
			'google'         => true,
			'text-align'     => true,
			'text-transform' => true,
			'compiler'       => array( 'h1.page-title' ),
			'default'        => array(
				'color'       => '#333',
				'font-size'   => '48px',
				'line-height' => '48px',
				'font-family' => 'Arial,Helvetica,sans-serif',
				'font-weight' => 'Normal',
			),
		),
		array(
			'id'             => 'page-title-spacing',
			'type'           => 'spacing',
			'compiler'       => array( '.page-title' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Page Title Margin', 'care' ),
			'default'        => array(
				'margin-top'    => '33px',
				'margin-right'  => '0px',
				'margin-bottom' => '33px',
				'margin-left'   => '0px',
				'units'         => 'px',
			),

		),
		array(
			'id'       => 'page-title-wrapper-padding-override',
			'type'     => 'switch',
			'title'    => esc_html__( 'Override Page Title Wrapper Padding', 'care' ),
			'default'  => false,
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'             => 'page-title-wrapper-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-page-title-wrapper' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Page Title Wrapper Padding', 'care' ),
			'default'        => array(
				'padding-top'    => '5px',
				'padding-right'  => '20px',
				'padding-bottom' => '5px',
				'padding-left'   => '20px',
				'units'          => 'px',
			),
			'required'       => array(
				array( 'page-title-wrapper-padding-override', 'equals', '1' ),
			),

		),
	),
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-page-title-breadcrumbs',
	'title'      => esc_html__( 'Breadcrumbs', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'page-title-breadcrumbs-enable',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable', 'care' ),
			'default' => true,
		),
		array(
			'id'       => 'page-title-breadcrumbs-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Position', 'care' ),
			'options'  => array(
				'above_title'  => 'Above the title',
				'bellow_title' => 'Bellow the title',
			),
			'default'  => 'bellow_title',
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-breadcrumbs-typography',
			'type'           => 'typography',
			'title'          => esc_html__( 'Font', 'care' ),
			'google'         => true,
			'font-backup'    => true,
			'text-transform' => true,
			'compiler'       => array( '.wh-breadcrumbs' ),
			'units'          => 'px',
			'default'        => array(
				'color'       => '#333',
				'font-style'  => '700',
				'font-family' => 'Abel',
				'google'      => true,
				'font-size'   => '14px',
				'line-height' => '10px'
			),
			'required'       => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-breadcrumbs-link-color',
			'type'     => 'link_color',
			'title'    => esc_html__( 'Links Color', 'care' ),
			'active'   => false,
			'compiler' => array( '.wh-breadcrumbs a' ),
			'default'  => array(
				'regular' => '#333',
				'hover'   => '#999',
			),
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-breadcrumbs-alignment',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Alignment', 'care' ),
			'options'  => array(
				'left'   => 'Left',
				'center' => 'Center',
				'right'  => 'Right',
			),
			'default'  => 'left',
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-breadcrumbs-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-breadcrumbs-wrapper' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Padding', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'padding-top'    => '20',
				'padding-bottom' => '20',
				'units'       => 'px',
			),
			'required' => array(
				array( 'page-title-breadcrumbs-enable', 'equals', '1' ),
			),
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-page-title-embellishments',
	'title'      => esc_html__( 'Embellishments', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'page-title-embellishments-enable',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable', 'care' ),
			'default' => false,
		),
		array(
			'id'       => 'page-title-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-page-title-top' ),
			'title'    => esc_html__( 'Embellishment Top Background', 'care' ),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Top Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-page-title-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-page-title-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Top Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative top margin to pull it up.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-page-title-bottom' ),
			'title'    => esc_html__( 'Embellishment Bottom Background', 'care' ),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'page-title-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Bottom Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-page-title-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'page-title-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-page-title-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Bottom Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative bottom margin to pull it down.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'page-title-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Page Title

// ----------------------------------
// -> Content
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-content',
	'title'  => esc_html__( 'Content', 'care' ),
	'icon'   => 'el-icon-file-edit',
	'fields' => array(
		array(
			'id'       => 'content-background',
			'type'     => 'background',
			'compiler' => array( '.wh-content' ),
			'title'    => esc_html__( 'Background', 'care' ),
			'subtitle' => esc_html__( 'Pick a background color for the content', 'care' ),
		),
		array(
			'id'             => 'content-padding',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-content' ),
			'mode'           => 'padding',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Padding', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'padding-top'    => '20',
				'padding-bottom' => '20',
				'units'       => 'px',
			)
		),
		array(
			'id'            => 'content-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Content Width', 'care' ),
			'subtitle'      => esc_html__( 'Drag the slider to change menu width grid steps.', 'care' ),
			'desc'          => esc_html__( 'The grid has 12 steps.', 'care' ),
			'default'       => 9,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),
		array(
			'id'            => 'sidebar-width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Sidebar Width', 'care' ),
			'subtitle'      => esc_html__( 'Drag the slider to change menu width grid steps.', 'care' ),
			'desc'          => esc_html__( 'The grid has 12 steps.', 'care' ),
			'default'       => 3,
			'min'           => 1,
			'step'          => 1,
			'max'           => 12,
			'display_value' => 'label'
		),

	),
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-content-embellishments',
	'title'      => esc_html__( 'Embellishments', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'content-embellishments-enable',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable', 'care' ),
			'default' => false,
		),
		array(
			'id'       => 'content-embellishment-background-top',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-content-top' ),
			'title'    => esc_html__( 'Embellishment Top Background', 'care' ),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Top Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-content-top' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'content-embellishment-background-top-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-content-top' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Top Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative top margin to pull it up.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-bottom',
			'type'     => 'background',
			'compiler' => array( '.wh-embellishment-content-bottom' ),
			'title'    => esc_html__( 'Embellishment Bottom Background', 'care' ),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'content-embellishment-background-bottom-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'em', 'px', '%' ),
			'title'    => esc_html__( 'Embellishment Bottom Container Height', 'care' ),
			'compiler' => array( '.wh-embellishment-content-bottom' ),
			'width'    => false,
			'default'  => array(
				'height' => '20',
				'units'  => 'px'
			),
			'required' => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),
		array(
			'id'             => 'content-embellishment-background-bottom-margin',
			'type'           => 'spacing',
			'compiler'       => array( '.wh-embellishment-content-bottom' ),
			'mode'           => 'margin',
			'units'          => array( 'em', 'px' ),
			'units_extended' => 'false',
			'title'          => esc_html__( 'Embellishment Bottom Container Margin', 'care' ),
			'desc'           => esc_html__( 'Use negative bottom margin to pull it up.', 'care' ),
			'left'           => false,
			'right'          => false,
			'default'        => array(
				'margin-top'    => '0',
				'margin-bottom' => '0',
				'units'         => 'px',
			),
			'required'       => array(
				array( 'content-embellishments-enable', 'equals', '1' ),
			),
		),

	)
) );
// -> End Content

// ----------------------------------
// -> Blog Archive
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-blog-archive',
	'title'  => esc_html__( 'Blog/Archive', 'care' ),
	'icon'   => 'el-icon-file',
	'fields' => array(
		array(
			'id'       => 'post-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Post Excerpt Length', 'care' ),
			'subtitle' => esc_html__( 'This setting will be applied to any section using post excerpt','care' ),
			'validate' => 'numeric',
			'msg'      => 'You must enter a number.',
			'default'  => 20
		),
	)
) );

Redux::setSection( $opt_name, array(
	'id'     => 'section-blog-archive-single',
	'title'  => esc_html__( 'Blog/Archive Single', 'care' ),
	'subsection'   => true,
	'fields' => array(
		array(
			'id'      => 'single-post-is-boxed',
			'type'    => 'switch',
			'title'   => esc_html__( 'Is Boxed?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'single-post-sidebar-left',
			'type'    => 'switch',
			'title'   => esc_html__( 'Sidebar on the Left?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'archive-single-use-share-this',
			'type'    => 'switch',
			'title'   => esc_html__( 'Use Share This buttons?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'archive-single-use-page-title',
			'type'    => 'switch',
			'title'   => esc_html__( 'Use Page Title?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'       => 'archive-single-header-message',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Header Message', 'care' ),
			'subtitle' => esc_html__( 'This text is shown bellow the menu on single post and single teacher. If empty the box will not be printed.','care' ),
		),

	)
) );
// -> End Blog Archive


// ----------------------------------
// -> Search Page
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-search-page',
	'title'  => esc_html__( 'Search Page', 'care' ),
	'icon'   => 'el-icon-search',
	'fields' => array(
		array(
			'id'      => 'search-page-use-sidebar',
			'type'    => 'switch',
			'title'   => esc_html__( 'Use Sidebar?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'       => 'search-page-items-per-page',
			'type'     => 'text',
			'title'    => esc_html__( 'Items Per Page', 'care' ),
			'validate' => 'numeric',
			'msg'      => 'You must enter a number.',
			'default'  => 10
		),

	)
) );
// -> End Search Page


// ----------------------------------
// -> Misc
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-misc',
	'title'  => esc_html__( 'Misc', 'care' ),
	'icon'   => 'el-icon-website',
	'fields' => array()
));

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-misc-scroll-to-top-button',
	'title'      => esc_html__( 'Scroll to Top Button', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'use-scroll-to-top',
			'type'    => 'switch',
			'title'   => esc_html__( 'Use Scroll to Top Button?', 'care' ),
			'default' => true,
			'on'      => 'Yes',
			'off'     => 'No',
		),
		array(
			'id'      => 'scroll-to-top-text',
			'type'    => 'text',
			'title'   => esc_html__( 'Scroll to Top Text', 'care' ),
			'default' => '',
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
			),
		),
		array(
			'id'      => 'scroll-to-top-button-override',
			'type'    => 'switch',
			'title'   => esc_html__( 'Override Scroll to Top Button?', 'care' ),
			'default' => false,
			'on'      => 'Yes',
			'off'     => 'No',
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
			),
		),
		array(
			'id'       => 'scroll-to-top-button',
			'type'     => 'background',
			'compiler' => array( '#scrollUp' ),
			'title'    => esc_html__( 'Scroll to Top Button', 'care' ),
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
				array( 'scroll-to-top-button-override', 'equals', '1' ),
			),

		),
		array(
			'id'       => 'scroll-to-top-dimensions',
			'type'     => 'dimensions',
			'units'    => array( 'px' ),
			'compiler' => array( '#scrollUp' ),
			'title'    => esc_html__( 'Dimensions (Width/Height)', 'care' ),
			'default'  => array(
				'width'  => '70',
				'height' => '70'
			),
			'required' => array(
				array( 'use-scroll-to-top', 'equals', '1' ),
				array( 'scroll-to-top-button-override', 'equals', '1' ),
			),
		),
		array(
			'id'      => 'gmaps_api_key',
			'type'    => 'text',
			'title'   => esc_html__( 'Google Maps API Key', 'care' ),
			'default' => '',
			'desc'    => esc_html__( 'Enter GMaps API key', 'care' ),
		),
	)
) );

Redux::setSection( $opt_name, array(
	'subsection' => true,
	'id'         => 'subsection-misc-text-direction',
	'title'      => esc_html__( 'Text Direction', 'care' ),
	'fields'     => array(
		array(
			'id'      => 'is-rtl',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable RTL?', 'care' ),
			'default' => false,
		),
	)
) );
// -> End Misc


// ----------------------------------
// -> Other Settings
// ----------------------------------
Redux::setSection( $opt_name, array(
	'id'     => 'section-other-settings',
	'title'  => esc_html__( 'Other Settings', 'care' ),
	'icon'   => 'el-icon-website',
	'fields' => array(
		array(
		    'id'   => 'other-settings-info',
		    'type' => 'info',
			'desc' => esc_html__('If you have made edits to the code and wish to see the original code click on the link bellow. If you wish to completely restore the original code either copy this reference code to the editor bellow or reset the section.', 'care'),
		),
		array(
		    'id'   => 'other-settings-info-link',
		    'type' => 'info',
		    'desc' => '<a href="'.get_template_directory_uri().'/lib/redux/css/other-settings/vars.scss" target="_blank">Click here to see a refrence of original code</a>'
		),
		array(
			'id'       => 'other-settings-vars',
			'type'     => 'ace_editor',
			'title'    => esc_html__( 'Settings', 'care' ),
			'mode'     => 'scss',
			'compiler' => 'true',
			'theme'    => 'monokai',
			'default'  => $other_settings,
			'options'  => array(
				'minLines'=> 100
			),
		),
	)
) );
// -> End Other Settings
