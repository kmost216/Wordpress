<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

$lsDefaults = [

	'slider' => [

		'createdWith' => [
			'value' => '',
			'keys' => 'createdWith'
		],

		'sliderVersion' => [
			'value' => '',
			'keys' => 'sliderVersion',
			'props' => [
				'forceoutput' => true
			]
		],

		'status' => [
			'value' => true,
			'name' => __('Status', 'LayerSlider'),
			'keys' => 'status',
			'desc' => __('Unpublished projects will not be visible for your visitors until you re-enable this option. This also applies to scheduled projects, thus leaving this option enabled is recommended in most cases.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],

		'loadOrder' => [
			'value' => '',
			'name' => __('Load order', 'LayerSlider'),
			'keys' => 'loadOrder',
			'advanced' => true,
			'desc' => __('Sets the loading order of LayerSlider projects. Useful to prioritize embeds above the fold when you have multiple projects on the same page. The value “1” will be loaded first. Projects without a value will be loaded simultaneously after the ordered ones have finished loading.', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => 1,
				'max' => 100,
				'step' => 1
			],
			'props' => [
				'meta' => true
			]
		],

		'loadDelay' => [
			'value' => '',
			'name' => __('Load delay', 'LayerSlider'),
			'keys' => 'loadDelay',
			'advanced' => true,
			'desc' => __('Delays loading this project with the given amount in milliseconds. A second is 1000 milliseconds.', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'step' => 100
			]
		],

		'scheduleStart' => [
			'value' => '',
			'name' => __('Schedule From', 'LayerSlider'),
			'keys' => 'schedule_start',
			'desc' => '',
			'attrs' => [
				'placeholder' => __('No schedule', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],


		'scheduleEnd' => [
			'value' => '',
			'name' => __('Schedule Until', 'LayerSlider'),
			'keys' => 'schedule_end',
			'desc' => '',
			'attrs' => [
				'placeholder' => __('No schedule', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],


		// ============= //
		// |   Layout  | //
		// ============= //


		'type' => [
			'value' => 'responsive',
			'name' => __('Project Type', 'LayerSlider'),
			'keys' => 'type',
			'desc' => '',
			'attrs' => [
				'type' => 'hidden'
			]
		],

		'width' => [
			'value' => 1280,
			'name' => __('Canvas Width', 'LayerSlider'),
			'keys' => 'width',
			'desc' => __('The width of the project canvas in pixels.', 'LayerSlider'),
			'attrs' => [
				'type' => 'text',
				'placeholder' => 1280
			],
			'props' => [
				'meta' => true
			]
		],

		'height' => [
			'value' => 720,
			'name' => __('Canvas Height', 'LayerSlider'),
			'keys' => 'height',
			'desc' => __('The height of the project canvas in pixels.', 'LayerSlider'),
			'attrs' => [
				'type' => 'text',
				'placeholder' => 720
			],
			'props' => [
				'meta' => true
			]
		],


		'maxWidth' => [
			'value' => '',
			'name' => __('Max-width', 'LayerSlider'),
			'keys' => 'maxwidth',
			'desc' => __('The maximum width your slider can take in pixels or percents when responsive mode is enabled.', 'LayerSlider'),
			'attrs' => [
				'placeholder' => '100%'
			],
			'props' => [
				'meta' => true
			]
		],


		'responsiveUnder' => [
			'value' => '',
			'name' => __('Responsive Under', 'LayerSlider'),
			'keys' => ['responsiveunder', 'responsiveUnder'],
			'desc' => __('Turns on responsive mode in a full-width slider under the specified value in pixels. Can only be used with full-width mode.', 'LayerSlider'),
			'advanced' => true,
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'placeholder' => __('Canvas width', 'LayerSlider')
			]
		],

		'layersContrainer' => [
			'value' => '',
			'keys' => ['sublayercontainer', 'layersContainer']
		],


		'fullSizeMode' => [
			'value' => 'normal',
			'name' => __('Mode', 'LayerSlider'),
			'keys' => 'fullSizeMode',
			'desc' => __('Sizing behavior of your full size sliders.', 'LayerSlider'),
			'options' => [
				'normal' => __('Normal', 'LayerSlider'),
				'fitheight' => __('Fit to parent height', 'LayerSlider')
			],
			'attrs' => [
				'min' => 0
			]
		],

		'allowFullscreen' => [
			'value' => true,
			'name' => __('Allow Fullscreen Mode', 'LayerSlider'),
			'keys' => 'allowFullscreen',
			'desc' => __('Visitors can enter OS native full-screen mode when double clicking on the slider.', 'LayerSlider')
		],

		'maxRatio' => [
			'value' => '',
			'name' => __('Maximum Responsive Ratio', 'LayerSlider'),
			'keys' => 'maxRatio',
			'desc' => __('The slider will not enlarge your layers above the target ratio. The value 1 will keep your layers in their initial size, without any upscaling.', 'LayerSlider'),
			'advanced' => true
		],

		'fitScreenWidth' => [
			'value' => true,
			'name' => __('Fit To Screen Width', 'LayerSlider'),
			'keys' => 'fitScreenWidth',
			'desc' => __('If enabled, the slider will always have the same width as the viewport, even if a theme uses a boxed layout, unless you choose the “Fit to parent height” full size mode.', 'LayerSlider'),
			'advanced' => true
		],

		'preventSliderClip' => [
			'value' => true,
			'name' => __('Prevent Slider Clipping', 'LayerSlider'),
			'keys' => 'preventSliderClip',
			'desc' => __('Ensures that the theme cannot clip parts of the slider when used in a boxed layout.', 'LayerSlider'),
			'advanced' => true
		],


		'insertMethod' => [
			'value' => 'prependTo',
			'name' => __('Move The Slider By', 'LayerSlider'),
			'keys' => 'insertMethod',
			'desc' => __('Move your slider to a different part of the page by providing a jQuery DOM manipulation method & selector for the target destination.', 'LayerSlider'),
			'options' => [
				'prependTo' => 'prepending to',
				'appendTo' => 'appending to',
				'insertBefore' => 'inserting before',
				'insertAfter' => 'inserting after'
			]
		],

		'insertSelector' => [
			'value' => '',
			'keys' => 'insertSelector',
			'attrs' => [
				'placeholder' => __('Enter selector', 'LayerSlider')
			]
		],

		'clipSlideTransition' => [
			'value' => 'disabled',
			'name' => __('Clip Slide Transition', 'LayerSlider'),
			'keys' => 'clipSlideTransition',
			'desc' => __('Choose on which axis (if any) you want to clip the overflowing content (i.e. that breaks outside of the slider bounds).', 'LayerSlider'),
			'advanced' => true,
			'options' => [
				'disabled' => __('Do not hide', 'LayerSlider'),
				'enabled' => __('Hide on both axis', 'LayerSlider'),
				'x' => __('X Axis', 'LayerSlider'),
				'y' => __('Y Axis', 'LayerSlider')
			]
		],


		// == COMPATIBILITY ==

		'responsiveness' => [
			'value' => true,
			'keys' => 'responsive',
			'props' => [
				'meta' => true,
				'output' => true
			]
		],
		'fullWidth' => [
			'value' => false,
			'keys' => 'forceresponsive',
			'props' => [
				'meta' => true,
				'output' => true
			]
		],

		// == END OF COMPATIBILITY ==

		'slideBGSize' => [
			'value' => 'cover',
			'name' => __('Background Size', 'LayerSlider'),
			'keys' => 'slideBGSize',
			'desc' => __('This will be used as a default on all slides, unless you choose to explicitly override it on a per slide basis.', 'LayerSlider'),
			'options' => [
				'auto' => __('Auto', 'LayerSlider'),
				'cover' => __('Cover', 'LayerSlider'),
				'contain' => __('Contain', 'LayerSlider'),
				'100% 100%' => __('Stretch', 'LayerSlider')
			]
		],

		'slideBGPosition' => [
			'value' => '50% 50%',
			'name' => __('Background Position', 'LayerSlider'),
			'keys' => 'slideBGPosition',
			'desc' => __('This will be used as a default on all slides, unless you choose the explicitly override it on a per slide basis.', 'LayerSlider'),
			'options' => [
				'0% 0%' => __('left top', 'LayerSlider'),
				'0% 50%' => __('left center', 'LayerSlider'),
				'0% 100%' => __('left bottom', 'LayerSlider'),
				'50% 0%' => __('center top', 'LayerSlider'),
				'50% 50%' => __('center center', 'LayerSlider'),
				'50% 100%' => __('center bottom', 'LayerSlider'),
				'100% 0%' => __('right top', 'LayerSlider'),
				'100% 50%' => __('right center', 'LayerSlider'),
				'100% 100%' => __('right bottom', 'LayerSlider')
			]
		],


		'parallaxSensitivity' => [
			'value' => 10,
			'name' => __('Parallax Sensitivity', 'LayerSlider'),
			'keys' => 'parallaxSensitivity',
			'desc' => __('Increase or decrease the sensitivity of parallax content when moving your mouse cursor or tilting your mobile device.', 'LayerSlider')
		],


		'parallaxCenterLayers' => [
			'value' => 'center',
			'name' => __('Parallax Center Layers', 'LayerSlider'),
			'keys' => 'parallaxCenterLayers',
			'desc' => __('Choose a center point for parallax content where all layers will be aligned perfectly according to their original position.', 'LayerSlider'),
			'options' => [
				'center' => __('At center of the viewport', 'LayerSlider'),
				'top' => __('At the top of the viewport', 'LayerSlider')
			]
		],

		'parallaxCenterDegree' => [
			'value' => 40,
			'name' => __('Parallax Center Degree', 'LayerSlider'),
			'keys' => 'parallaxCenterDegree',
			'desc' => __('Provide a comfortable holding position (in degrees) for mobile devices, which should be the center point for parallax content where all layers should align perfectly.', 'LayerSlider')
		],

		'parallaxScrollReverse' => [
			'value' => false,
			'name' => 'Reverse Scroll Direction',
			'keys' => 'parallaxScrollReverse',
			'desc' => __('Your parallax layers will move to the opposite direction when scrolling the page.', 'LayerSlider')
		],


		// ================= //
		// |    Mobile    | //
		// ================= //

		'optimizeForMobile' => [
			'value' => true,
			'name' => __('Optimize For Mobile', 'LayerSlider'),
			'keys' => 'optimizeForMobile',
			'advanced' => true,
			'desc' => __('Enable optimizations on mobile devices to avoid performance issues (e.g. fewer tiles in slide transitions, reducing performance-heavy effects with very similar results, etc).', 'LayerSlider')
		],


		'hideOnMobile' => [
			'value' => false,
			'name' => __('Hide On Mobile', 'LayerSlider'),
			'keys' => ['hideonmobile', 'hideOnMobile'],
			'desc' => __('Hides the project on mobile devices, including tablets.', 'LayerSlider')
		],


		'hideUnder' => [
			'value' => '',
			'name' => __('Hide Under', 'LayerSlider'),
			'keys' => ['hideunder', 'hideUnder'],
			'desc' => __('Hides the project when the viewport width goes under the specified value.', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => -1
			]
		],


		'hideOver' => [
			'value' => '',
			'name' => __('Hide Over', 'LayerSlider'),
			'keys' => ['hideover', 'hideOver'],
			'desc' => __('Hides the project when the viewport becomes wider than the specified value.', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => -1
			]
		],

		'slideOnSwipe' => [
			'value' => true,
			'name' => __('Use Slide Effect When Swiping', 'LayerSlider'),
			'keys' => 'slideOnSwipe',
			'desc' => __('Ignore selected slide transitions and use sliding effects only when users are changing slides with a swipe gesture on mobile devices.', 'LayerSlider')
		],

		// ================ //
		// |   Slideshow  | //
		// ================ //


		'autoStart' => [
			'value' => true,
			'name' => __('Auto-start Slideshow', 'LayerSlider'),
			'keys' => ['autostart', 'autoStart'],
			'desc' => __('Slideshow will automatically start after page load.', 'LayerSlider')
		],

		'startInViewport' => [
			'value' => true,
			'name' => __('Start Only In Viewport', 'LayerSlider'),
			'keys' => ['startinviewport', 'startInViewport'],
			'desc' => __('The project will not start playing until it becomes visible.', 'LayerSlider')
		],

		'hashChange' => [
			'value' => false,
			'name' => __('Change URL Hash', 'LayerSlider'),
			'keys' => 'hashChange',
			'desc' => __('Updates the hash in the page URL when changing slides based on the deeplinks you’ve set to your slides. This makes it possible to share URLs that will start the project with the currently visible slide.', 'LayerSlider'),
			'advanced' => true
		],

		'pauseLayers' => [
			'value' => false,
			'name' => __('Pause Layers', 'LayerSlider'),
			'keys' => 'pauseLayers',
			'desc' => __('If you enable this option, layer transitions will not start playing as long the slideshow is in a paused state.', 'LayerSlider'),
			'advanced' => true
		],

		'pauseOnHover' => [
			'value' => 'disabled',
			'name' => __('Pause On Hover', 'LayerSlider'),
			'keys' => ['pauseonhover', 'pauseOnHover'],
			'options' => [
				'disabled' => __('Do nothing', 'LayerSlider'),
				'enabled' => __('Pause slideshow', 'LayerSlider'),
				'layers' => __('Pause slideshow and layer transitions', 'LayerSlider'),
				'looplayers' => __('Pause slideshow and layer transitions, including loops', 'LayerSlider')
			],
			'desc' => __('Decide what should happen when you move your mouse cursor over the project.', 'LayerSlider')
		],

		'firstSlide' => [
			'value' => 1,
			'name' => __('Start With Slide', 'LayerSlider'),
			'keys' => ['firstlayer', 'firstSlide'],
			'desc' => __('The project will start with the specified slide. You can also use the value “random”.', 'LayerSlider'),
			'attrs' => ['type' => 'text']
		],

		'keybNavigation' => [
			'value' => true,
			'name' => __('Keyboard Navigation', 'LayerSlider'),
			'keys' => ['keybnav', 'keybNav'],
			'desc' => __('You can navigate through slides with the left and right arrow keys.', 'LayerSlider')
		],


		'touchNavigation' => [
			'value' => true,
			'name' => __('Touch Navigation', 'LayerSlider'),
			'keys' => ['touchnav', 'touchNav'],
			'desc' => __('Gesture-based navigation when swiping on touch-enabled devices.', 'LayerSlider')
		],

		'playByScroll' => [
			'value' => false,
			'name' => __('Play By Scroll', 'LayerSlider'),
			'keys' => 'playByScroll',
			'desc' => sprintf(__('Play the project by scrolling the web page. %sClick here%s to see a live example.', 'LayerSlider'), '<a href="https://layerslider.com/sliders/play-by-scroll/" target="_blank">', '</a>' ),
			'premium' => true
		],


		'playByScrollSpeed' => [
			'value' => 1,
			'name' => __('Play By Scroll Speed', 'LayerSlider'),
			'keys' => 'playByScrollSpeed',
			'desc' => __('Play By Scroll speed multiplier.', 'LayerSlider'),
			'premium' => true
		],


		'playByScrollStart' => [
			'value' => false,
			'name' => __('Start Immediately', 'LayerSlider'),
			'keys' => 'playByScrollStart',
			'desc' => __('Instead of freezing the project until visitors start scrolling, the project will automatically start playback and will only pause at the first keyframe.', 'LayerSlider'),
			'premium' => true
		],

		'playByScrollSkipSlideBreaks' => [
			'value' => false,
			'name' => __('Skip Slide Breaks', 'LayerSlider'),
			'keys' => 'playByScrollSkipSlideBreaks',
			'desc' => __('Enable this option to eliminate the stop between slide changes. Visitors would no longer need to scroll at the end of slides, instead the project will only stop at the keyframes you specify.', 'LayerSlider'),
			'premium' => true
		],


		'loops' => [
			'value' => 0,
			'name' => __('Cycles', 'LayerSlider'),
			'keys' => ['loops', 'cycles'],
			'desc' => __('Number of cycles if slideshow is enabled.', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => 0
			]
		],

		'forceLoopNumber' => [
			'value' => true,
			'name' => __('Force Number Of Cycles', 'LayerSlider'),
			'keys' => ['forceloopnum', 'forceCycles'],
			'advanced' => true,
			'desc' => __('The project will always stop at the given number of cycles, even if the slideshow restarts.', 'LayerSlider')
		],

		'shuffle' => [
			'value' => false,
			'name' => __('Shuffle Mode', 'LayerSlider'),
			'keys' => ['randomslideshow', 'shuffleSlideshow'],
			'desc' => __('Slideshow will proceed in random order. This feature does not work with looping.', 'LayerSlider')
		],


		'twoWaySlideshow' => [
			'value' => false,
			'name' => __('Two Way Slideshow', 'LayerSlider'),
			'keys' => ['twowayslideshow', 'twoWaySlideshow'],
			'advanced' => true,
			'desc' => __('Slideshow can go backwards if someone switches to a previous slide.', 'LayerSlider')
		],

		'forceLayersOutDuration' => [
			'value' => 750,
			'name' => __('Forced Animation Duration', 'LayerSlider'),
			'keys' => 'forceLayersOutDuration',
			'advanced' => true,
			'desc' => __('The animation speed in milliseconds when the project forces remaining layers out of scene before changing slides.', 'LayerSlider'),
			'attrs' => [
				'min' => 0
			]
		],

		// ================= //
		// |   Appearance  | //
		// ================= //

		'skin' => [
			'value' => 'v6',
			'name' => __('Skin', 'LayerSlider'),
			'keys' => 'skin',
			'desc' => __('The skin used for this project. The “noskin” skin is a border- and buttonless skin. Your custom skins will appear in the list when you create their folders.', 'LayerSlider'),
			'props' => [
				'output' => true
			]
		],


		'sliderFadeInDuration' => [
			'value' => 350,
			'name' => __('Initial Fade Duration', 'LayerSlider'),
			'keys' => ['sliderfadeinduration', 'sliderFadeInDuration'],
			'advanced' => true,
			'desc' => __('Change the duration of the initial fade animation when the page loads. Enter 0 to disable fading.', 'LayerSlider'),
			'attrs' => [
				'min' => 0
			]
		],


		'sliderClasses' => [
			'value' => '',
			'name' => __('Project Classes', 'LayerSlider'),
			'keys' => 'sliderclass',
			'desc' => __('One or more space-separated class names to be added to the project container element.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],

		'sliderStyle' => [
			'value' => 'margin-bottom: 0px;',
			'name' => __('Project CSS', 'LayerSlider'),
			'keys' => ['sliderstyle', 'sliderStyle'],
			'desc' => __('You can enter custom CSS to change some style properties on the project wrapper element. More complex CSS should be applied with the Custom Styles Editor.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],


		'globalBGColor' => [
			'value' => '',
			'name' => __('Background Color', 'LayerSlider'),
			'keys' => ['backgroundcolor', 'globalBGColor'],
			'desc' => __('Global background color of the project. Slides with non-transparent background will cover this one. You can use all CSS methods such as HEX or RGB(A) values.', 'LayerSlider')
		],

		'globalBGImage' => [
			'value' => '',
			'name' => __('Background Image', 'LayerSlider'),
			'keys' => ['backgroundimage', 'globalBGImage'],
			'desc' => __('Global background image of the project. Slides with non-transparent backgrounds will cover it. This image will not scale in responsive mode.', 'LayerSlider')
		],

		'globalBGImageId' => [
			'value' => '',
			'keys' => ['backgroundimageId', 'globalBGImageId'],
			'props' => [
				'meta' => true
			]
		],

		'globalBGRepeat' => [
			'value' => 'no-repeat',
			'name' => __('Background Repeat', 'LayerSlider'),
			'keys' => 'globalBGRepeat',
			'desc' => __('Global background image repeat.', 'LayerSlider'),
			'options' => [
				'no-repeat' => __('No-repeat', 'LayerSlider'),
				'repeat' => __('Repeat', 'LayerSlider'),
				'repeat-x' => __('Repeat-x', 'LayerSlider'),
				'repeat-y' => __('Repeat-y', 'LayerSlider')
			]
		],


		'globalBGAttachment' => [
			'value' => 'scroll',
			'name' => __('Background Behavior', 'LayerSlider'),
			'keys' => 'globalBGAttachment',
			'desc' => __('Choose between a scrollable or fixed global background image.', 'LayerSlider'),
			'options' => [
				'scroll' => __('Scroll', 'LayerSlider'),
				'fixed' => __('Fixed', 'LayerSlider')
			]
		],


		'globalBGPosition' => [
			'value' => '50% 50%',
			'name' => __('Background Position', 'LayerSlider'),
			'keys' => 'globalBGPosition',
			'desc' => __('Global background image position of the project. The first value is the horizontal position and the second value is the vertical.', 'LayerSlider')
		],

		'globalBGSize' => [
			'value' => 'auto',
			'name' => __('Background Size', 'LayerSlider'),
			'keys' => 'globalBGSize',
			'desc' => __('Global background size of the project. You can set the size in pixels, percentages, or constants: auto | cover | contain ', 'LayerSlider')
		],



		// ================= //
		// |   Navigation  | //
		// ================= //

		'navPrevNextButtons' => [
			'value' => true,
			'name' => __('Prev & Next Buttons', 'LayerSlider'),
			'keys' => ['navprevnext', 'navPrevNext'],
			'desc' => __('Disabling this option will hide the Prev and Next buttons.', 'LayerSlider')
		],

		'hoverPrevNextButtons' => [
			'value' => true,
			'name' => __('Prev & Next Buttons', 'LayerSlider'),
			'keys' => ['hoverprevnext', 'hoverPrevNext'],
			'desc' => __('Show the buttons only when someone moves the mouse cursor over the project. This option depends on the previous setting.', 'LayerSlider')
		],

		'navStartStopButtons' => [
			'value' => true,
			'name' => __('Start & Stop Buttons', 'LayerSlider'),
			'keys' => ['navstartstop', 'navStartStop'],
			'desc' => __('Disabling this option will hide the Start & Stop buttons.', 'LayerSlider')
		],


		'navSlideButtons' => [
			'value' => true,
			'name' => __('Slide Navigation Buttons', 'LayerSlider'),
			'keys' => ['navbuttons', 'navButtons'],
			'desc' => __('Disabling this option will hide slide navigation buttons or thumbnails.', 'LayerSlider')
		],

		'hoverSlideButtons' => [
			'value' => false,
			'name' => __('Slide Navigation', 'LayerSlider'),
			'keys' => ['hoverbottomnav', 'hoverBottomNav'],
			'desc' => __('Slide navigation buttons (including thumbnails) will be shown on mouse hover only.', 'LayerSlider')
		],

		'barTimer' => [
			'value' => false,
			'name' => __('Bar Timer', 'LayerSlider'),
			'keys' => ['bartimer', 'showBarTimer'],
			'desc' => __('Show the bar timer to indicate slideshow progression.', 'LayerSlider')
		],

		'circleTimer' => [
			'value' => true,
			'name' => __('Circle Timer', 'LayerSlider'),
			'keys' => ['circletimer', 'showCircleTimer'],
			'desc' => __('Use circle timer to indicate slideshow progression.', 'LayerSlider')
		],

		'slideBarTimer' => [
			'value' => false,
			'name' => __('Slidebar Timer', 'LayerSlider'),
			'keys' => ['slidebartimer', 'showSlideBarTimer'],
			'desc' => __('You can grab the slidebar timer playhead and seek the whole slide real-time like a movie.', 'LayerSlider')
		],

		// ========================== //
		// |  Thumbnail navigation  | //
		// ========================== //


		'thumbnailNavigation' => [
			'value' => 'hover',
			'name' => __('Thumbnail Navigation', 'LayerSlider'),
			'keys' => ['thumb_nav', 'thumbnailNavigation'],
			'desc' => __('Use thumbnail navigation instead of slide bullet buttons.', 'LayerSlider'),
			'options' => [
				'disabled' => __('Disabled', 'LayerSlider'),
				'hover' => __('Hover', 'LayerSlider'),
				'always' => __('Always', 'LayerSlider')
			]
		],

		'thumbnailAreaWidth' => [
			'value' => '60%',
			'name' => __('Thumbnail Container Width', 'LayerSlider'),
			'keys' => ['thumb_container_width', 'tnContainerWidth'],
			'desc' => __('The width of the thumbnail area relative to the project size.', 'LayerSlider')
		],

		'thumbnailWidth' => [
			'value' => 100,
			'name' => __('Thumbnail Width', 'LayerSlider'),
			'keys' => ['thumb_width', 'tnWidth'],
			'desc' => __('The width of thumbnails in the navigation area.', 'LayerSlider'),
			'attrs' => [
				'min' => 0
			]
		],

		'thumbnailHeight' => [
			'value' => 60,
			'name' => __('Thumbnail Height', 'LayerSlider'),
			'keys' => ['thumb_height', 'tnHeight'],
			'desc' => __('The height of thumbnails in the navigation area.', 'LayerSlider'),
			'attrs' => [
				'min' => 0
			]
		],

		'thumbnailActiveOpacity' => [
			'value' => 35,
			'name' => __('Active Thumbnail Opacity', 'LayerSlider'),
			'keys' => ['thumb_active_opacity', 'tnActiveOpacity'],
			'desc' => __('Opacity in percentage of the active slide’s thumbnail.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'max' => 100
			]
		],

		'thumbnailInactiveOpacity' => [
			'value' => 100,
			'name' => __('Inactive Thumbnail Opacity', 'LayerSlider'),
			'keys' => ['thumb_inactive_opacity', 'tnInactiveOpacity'],
			'desc' => __('Opacity in percentage of inactive slide thumbnails.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'max' => 100
			]
		],

		// ============ //
		// |  Videos  | //
		// ============ //

		'autoPlayVideos' => [
			'value' => true,
			'name' => __('Automatically Play Media', 'LayerSlider'),
			'keys' => ['autoplayvideos', 'autoPlayVideos'],
			'desc' => __('The playback of video and audio layers will automatically be started on the active slide.', 'LayerSlider')
		],

		'autoPauseSlideshow' => [
			'value' => 'auto',
			'name' => __('Pause Slideshow', 'LayerSlider'),
			'keys' => ['autopauseslideshow', 'autoPauseSlideshow'],
			'desc' => __('The slideshow can temporally be paused while video or audio layers are playing. You can choose to permanently stop the pause until manual restarting.', 'LayerSlider'),
			'options' => [
				'auto' => __('While playing', 'LayerSlider'),
				'enabled' => __('Permanently', 'LayerSlider'),
				'disabled' => __('No action', 'LayerSlider')
			]
		],

		'youtubePreviewQuality' => [
			'value' => 'maxresdefault.jpg',
			'name' => __('Youtube Preview', 'LayerSlider'),
			'keys' => ['youtubepreview', 'youtubePreview'],
			'desc' => __('The automatically fetched preview image quaility for YouTube videos when you do not set your own. Please note, some videos do not have HD previews, and you may need to choose a lower quaility.', 'LayerSlider'),
			'options' => [
				'maxresdefault.jpg' => __('Maximum quality', 'LayerSlider'),
				'hqdefault.jpg' => __('High quality', 'LayerSlider'),
				'mqdefault.jpg' => __('Medium quality', 'LayerSlider'),
				'default.jpg' => __('Default quality', 'LayerSlider')
			]
		],


		'rememberUnmuteState' => [
			'value' => true,
			'name' => __('Remember Unmute State', 'LayerSlider'),
			'keys' => 'rememberUnmuteState',
			'desc' => __('After a visitor has clicked on the Unmute button, the project will assume that all later media can play with sound. Disable this option if you want to display the Unmute button on each slide separately.', 'LayerSlider')
		],


		// =========== //
		// |  Popup  | //
		// =========== //

		'popupShowOnClick' => [
			'value' => '',
			'name' => __('Open By Click', 'LayerSlider'),
			'keys' => 'popupShowOnClick',
			'desc' => __('Enter a jQuery selector to open the Popup by clicking on the target element(s). Acting as a toggle, a secondary click will close the Popup. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],

		'popupShowOnScroll' => [
			'value' => '',
			'name' => __('Open At Scroll Position', 'LayerSlider'),
			'keys' => 'popupShowOnScroll',
			'desc' => __('Enter a scroll position in pixels or percents, which will open the Popup when visitors scroll to that location. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],

		'popupCloseOnScroll' => [
			'value' => '',
			'name' => __('Close At Scroll Position', 'LayerSlider'),
			'keys' => 'popupCloseOnScroll',
			'desc' => __('Enter a scroll position in pixels or percents, which will close the Popup when visitors scroll to that location. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],

		'popupCloseOnTimeout' => [
			'value' => '',
			'name' => __('Close Automatically After', 'LayerSlider'),
			'keys' => 'popupCloseOnTimeout',
			'desc' => __('Automatically closes the Popup in the specified number of seconds after it was opened. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],

		'popupCloseOnSliderEnd' => [
			'value' => false,
			'name' => __('Close On End', 'LayerSlider'),
			'keys' => 'popupCloseOnSliderEnd',
			'desc' => __('Closes the Popup after it has completed a full cycle and all your slides were displayed.', 'LayerSlider')
		],

		'popupShowOnLeave' => [
			'value' => false,
			'name' => __('Before Leaving The Page', 'LayerSlider'),
			'keys' => 'popupShowOnLeave',
			'desc' => __('Opens the Popup before leaving the page. A leave intent is considered when visitors leave the browser window with their mouse cursor in the direction where the window controls and the tab bar is located.', 'LayerSlider')
		],

		'popupShowOnIdle' => [
			'value' => '',
			'name' => __('Open When Idle For', 'LayerSlider'),
			'keys' => 'popupShowOnIdle',
			'desc' => __('Opens the Popup after the specified number of seconds when the user is inactive without moving the mouse cursor or pressing any button. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],

		'popupShowOnTimeout' => [
			'value' => '',
			'name' => __('Open Automatically After', 'LayerSlider'),
			'keys' => 'popupShowOnTimeout',
			'desc' => __('Automatically opens the Popup after the specified number of seconds. Leave this field empty if you don’t want to use this trigger.', 'LayerSlider')
		],


		'popupShowOnce' => [
			'value' => true,
			'name' => __('Prevent Reopening', 'LayerSlider'),
			'keys' => 'popupShowOnce',
			'desc' => __('Depending on your settings, the same Popup can be displayed in multiple times without reloading the page. Such example would be when you use a scroll trigger and the user scrolls to that location a number of times. Enabling this option will prevent opening this Popup consequently.', 'LayerSlider')
		],

		'popupDisableOverlay' => [
			'value' => false,
			'name' => __('Disable Overlay', 'LayerSlider'),
			'keys' => 'popupDisableOverlay',
			'desc' => __('Disable this option to hide the overlay behind the Popup.', 'LayerSlider')
		],

		'popupShowCloseButton' => [
			'value' => true,
			'name' => __('Show Close Button', 'LayerSlider'),
			'keys' => 'popupShowCloseButton',
			'desc' => __('Disable this option to hide the Popup close button. This option is also useful when you would like to use a custom close button. To do that, select the “Close the Popup” option from the layer linking field.', 'LayerSlider')
		],

		'popupCloseButtonStyle' => [
			'value' => '',
			'name' => __('Close Button Custom CSS', 'LayerSlider'),
			'keys' => 'popupCloseButtonStyle',
			'desc' => __('Enter a list of CSS properties, which will be applied to the built-in close button (if enabled) to customize it’s appearance.', 'LayerSlider'),
			'advanced' => true
		],

		'popupOverlayClickToClose' => [
			'value' => true,
			'name' => __('Close By Clicking Away', 'LayerSlider'),
			'keys' => 'popupOverlayClickToClose',
			'desc' => __('Close the Popup by clicking on the overlay.', 'LayerSlider')
		],

		'popupStartSliderImmediately' => [
			'value' => false,
			'name' => __('Start Popup Immediately', 'LayerSlider'),
			'keys' => 'popupStartSliderImmediately',
			'desc' => __('Enable this option to immediately start layer animations without waiting for the Popup to complete its opening transition.', 'LayerSlider'),
			'advanced' => true
		],

		'popupResetOnClose' => [
			'value' => 'slide',
			'name' => __('Reset On Close', 'LayerSlider'),
			'keys' => 'popupResetOnClose',
			'desc' => __('Choose whether the project should play all slide transitions over again when re-opening the Popup.', 'LayerSlider'),
			'advanced' => true,
			'options' => [
				'disabled' => __('Disabled', 'LayerSlider'),
				'slide' => __('Reset slide', 'LayerSlider'),
				'slider' => __('Reset popup', 'LayerSlider')
			]
		],

		// 'popupCustomStyle' => [
		// 	'value' => '',
		// 	'name' => __('Popup custom CSS', 'LayerSlider'),
		// 	'keys' => 'popupCustomStyle',
		// 	'desc' => __('Enter CSS properties, which will be applied to the popup main container element to customize it’s appearance.', 'LayerSlider')
		// ],

		'popupWidth' => [
			'value' => 640,
			'name' => __('Popup Width', 'LayerSlider'),
			'keys' => 'popupWidth',
			'attrs' => [
				'type' => 'number',
				'min' => 0,
 			],
			'props' => [
				'meta' => true
			]
		],

		'popupHeight' => [
			'value' => 360,
			'name' => __('Popup Height', 'LayerSlider'),
			'keys' => 'popupHeight',
			'attrs' => [
				'type' => 'number',
				'min' => 0,
 			],
			'props' => [
				'meta' => true
			]
		],

		'popupFitWidth' => [
			'value' => false,
			'name' => __('Fit Width', 'LayerSlider'),
			'keys' => 'popupFitWidth'
		],

		'popupFitHeight' => [
			'value' => false,
			'name' => __('Fit Height', 'LayerSlider'),
			'keys' => 'popupFitHeight'
		],

		'popupPositionHorizontal' => [
			'value' => 'center',
			'keys' => 'popupPositionHorizontal'
		],

		'popupPositionVertical' => [
			'value' => 'middle',
			'keys' => 'popupPositionVertical'
		],

		'popupDistanceLeft' => [
			'value' => 10,
			'name' => __('Distance Left', 'LayerSlider'),
			'keys' => 'popupDistanceLeft'
		],

		'popupDistanceRight' => [
			'value' => 10,
			'name' => __('Distance Right', 'LayerSlider'),
			'keys' => 'popupDistanceRight'
		],

		'popupDistanceTop' => [
			'value' => 10,
			'name' => __('Distance Top', 'LayerSlider'),
			'keys' => 'popupDistanceTop'
		],

		'popupDistanceBottom' => [
			'value' => 10,
			'name' => __('Distance Bottom', 'LayerSlider'),
			'keys' => 'popupDistanceBottom'
		],

		'popupDurationIn' => [
			'value' => 1000,
			'name' => __('Opening Duration', 'LayerSlider'),
			'keys' => 'popupDurationIn',
			'desc' => __('The Popup opening transition duration specified in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'step' => 100
			]
		],

		'popupDurationOut' => [
			'value' => 500,
			'name' => __('Closing Duration', 'LayerSlider'),
			'keys' => 'popupDurationOut',
			'desc' => __('The Popup closing transition duration specified in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'step' => 100
			]
		],

		'popupDelayIn' => [
			'value' => 200,
			'name' => __('Opening Delay', 'LayerSlider'),
			'keys' => 'popupDelayIn',
			'desc' => __('Delay before opening the Popup specified in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'advanced' => true,
			'attrs' => [
				'min' => 0,
				'step' => 100
			]
		],

		// 'popupEaseIn' => [
		// 	'value' => 'easeInOutQuint',
		// 	'name' => __('Opening easing', 'LayerSlider'),
		// 	'keys' => 'popupEaseIn',
		// 	'desc' => __('The timing function of the animation. With it you can manipulate the movement of animated objects. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider')
		// ],

		// 'popupEaseOut' => [
		// 	'value' => 'easeInQuint',
		// 	'name' => __('Closing easing', 'LayerSlider'),
		// 	'keys' => 'popupEaseOut',
		// 	'desc' => __('The timing function of the animation. With it you can manipulate the movement of animated objects. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider')
		// ],

		'popupTransitionIn' => [
			'value' => 'fade',
			'name' => __('Opening Transition', 'LayerSlider'),
			'keys' => 'popupTransitionIn',
			'desc' => __('Choose from one of the pre-defined Popup opening transitions.', 'LayerSlider'),
			'options' => [
				'fade' => __('Fade', 'LayerSlider'),
				'slidefromtop' => __('Slide from top', 'LayerSlider'),
				'slidefrombottom' => __('Slide from bottom', 'LayerSlider'),
				'slidefromleft' => __('Slide from left', 'LayerSlider'),
				'slidefromright' => __('Slide from right', 'LayerSlider'),
				'rotatefromtop' => __('Rotate from top', 'LayerSlider'),
				'rotatefrombottom' => __('Rotate from bottom', 'LayerSlider'),
				'rotatefromleft' => __('Rotate from left', 'LayerSlider'),
				'rotatefromright' => __('Rotate from right', 'LayerSlider'),
				'scalefromtop' => __('Scale from top', 'LayerSlider'),
				'scalefrombottom' => __('Scale from bottom', 'LayerSlider'),
				'scalefromleft' => __('Scale from left', 'LayerSlider'),
				'scalefromright' => __('Scale from right', 'LayerSlider'),
				'scale' => __('Scale', 'LayerSlider'),
				'spin' => __('Spin', 'LayerSlider'),
				'spinx' => __('Spin horizontally', 'LayerSlider'),
				'spiny' => __('Spin vertically', 'LayerSlider'),
				'elastic' => __('Elastic', 'LayerSlider')
			]
		],

		'popupTransitionOut' => [
			'value' => 'fade',
			'name' => __('Closing Transition', 'LayerSlider'),
			'keys' => 'popupTransitionOut',
			'desc' => __('Choose from one of the pre-defined Popup closing transitions.', 'LayerSlider'),
			'options' => [
				'fade' => __('Fade', 'LayerSlider'),
				'slidetotop' => __('Slide to top', 'LayerSlider'),
				'slidetobottom' => __('Slide to bottom', 'LayerSlider'),
				'slidetoleft' => __('Slide to left', 'LayerSlider'),
				'slidetoright' => __('Slide to right', 'LayerSlider'),
				'rotatetotop' => __('Rotate to top', 'LayerSlider'),
				'rotatetobottom' => __('Rotate to bottom', 'LayerSlider'),
				'rotatetoleft' => __('Rotate to left', 'LayerSlider'),
				'rotatetoright' => __('Rotate to right', 'LayerSlider'),
				'scaletotop' => __('Scale to top', 'LayerSlider'),
				'scaletobottom' => __('Scale to bottom', 'LayerSlider'),
				'scaletoleft' => __('Scale to left', 'LayerSlider'),
				'scaletoright' => __('Scale to right', 'LayerSlider'),
				'scale' => __('Scale', 'LayerSlider'),
				'spin' => __('Spin', 'LayerSlider'),
				'spinx' => __('Spin horizontally', 'LayerSlider'),
				'spiny' => __('Spin vertically', 'LayerSlider'),
				'elastic' => __('Elastic', 'LayerSlider')
			]
		],

		// 'popupCustomTransitionIn' => [
		// 	'value' => '',
		// 	'name' => __('Custom opening transition', 'LayerSlider'),
		// 	'keys' => 'popupCustomTransitionIn',
		// ],

		// 'popupCustomTransitionOut' => [
		// 	'value' => '',
		// 	'name' => __('Custom closing transition', 'LayerSlider'),
		// 	'keys' => 'popupCustomTransitionOut',
		// ],

		'popupOverlayBackground' => [
			'value' => 'rgba(0,0,0,.85)',
			'name' => __('Overlay Color', 'LayerSlider'),
			'keys' => 'popupOverlayBackground',
			'desc' => __('The overlay color. You can use color names, hexadecimal, RGB or RGBA values.', 'LayerSlider')
		],

		'popupOverlayDurationIn' => [
			'value' => 400,
			'name' => __('Overlay Opening Duration', 'LayerSlider'),
			'keys' => 'popupOverlayDurationIn',
			'desc' => __('The overlay opening transition duration specified in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'step' => 100
			]
		],

		'popupOverlayDurationOut' => [
			'value' => 400,
			'name' => __('Overlay Closing Duration', 'LayerSlider'),
			'keys' => 'popupOverlayDurationOut',
			'desc' => __('The overlay closing transition duration specified in milliseconds. A second equals to 1000 milliseconds.', 'LayerSlider'),
			'attrs' => [
				'min' => 0,
				'step' => 100
			]
		],

		// 'popupOverlayEaseIn' => [
		// 	'value' => 'easeInQuint',
		// 	'name' => __('Overlay opening easing', 'LayerSlider'),
		// 	'keys' => 'popupOverlayEaseIn',
		// 	'desc' => __('The timing function of the animation. With it you can manipulate the movement of animated objects. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider')
		// ],

		// 'popupOverlayEaseOut' => [
		// 	'value' => 'easeInQuint',
		// 	'name' => __('Overlay closing easing', 'LayerSlider'),
		// 	'keys' => 'popupOverlayEaseOut',
		// 	'desc' => __('The timing function of the animation. With it you can manipulate the movement of animated objects. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider')
		// ],

		'popupOverlayTransitionIn' => [
			'value' => 'fade',
			'name' => __('Opening Transition', 'LayerSlider'),
			'keys' => 'popupOverlayTransitionIn',
			'desc' => __('Choose from one of the pre-defined overlay opening transitions.', 'LayerSlider'),
			'options' => [
				'fade' => __('Fade', 'LayerSlider'),
				'slidefromtop' => __('Slide from top', 'LayerSlider'),
				'slidefrombottom' => __('Slide from bottom', 'LayerSlider'),
				'slidefromleft' => __('Slide from left', 'LayerSlider'),
				'slidefromright' => __('Slide from right', 'LayerSlider'),
				'fadefromtopright' => __('Fade from top right', 'LayerSlider'),
				'fadefromtopleft' => __('Fade from top left', 'LayerSlider'),
				'fadefrombottomright' => __('Fade from bottom right', 'LayerSlider'),
				'fadefrombottomleft' => __('Fade from bottom left', 'LayerSlider'),
				'scale' => __('Scale', 'LayerSlider')
			]
		],

		'popupOverlayTransitionOut' => [
			'value' => 'fade',
			'name' => __('Closing Transition', 'LayerSlider'),
			'keys' => 'popupOverlayTransitionOut',
			'desc' => __('Choose from one of the pre-defined overlay closing transitions.', 'LayerSlider'),
			'options' => [
				'fade' => __('Fade', 'LayerSlider'),
				'slidetotop' => __('Slide to top', 'LayerSlider'),
				'slidetobottom' => __('Slide to bottom', 'LayerSlider'),
				'slidetoleft' => __('Slide to left', 'LayerSlider'),
				'slidetoright' => __('Slide to right', 'LayerSlider'),
				'fadetotopright' => __('Fade to top right', 'LayerSlider'),
				'fadetotopleft' => __('Fade to top left', 'LayerSlider'),
				'fadetobottomright' => __('Fade to bottom right', 'LayerSlider'),
				'fadetobottomleft' => __('Fade to bottom left', 'LayerSlider'),
				'scale' => __('Scale', 'LayerSlider')
			]
		],

		//----

		'popupPagesAll' => [
			'value' => false,
			'name' => __('All Pages', 'LayerSlider'),
			'keys' => 'popup_pages_all',
			'props' => [
				'meta' => true
			]
		],

		'popupPagesHome' => [
			'value' => false,
			'name' => __('Homepage', 'LayerSlider'),
			'keys' => 'popup_pages_home',
			'props' => [
				'meta' => true
			]
		],

		'popupPagesPage' => [
			'value' => false,
			'name' => __('Pages', 'LayerSlider'),
			'keys' => 'popup_pages_page',
			'props' => [
				'meta' => true
			]
		],

		'popupPagesPost' => [
			'value' => false,
			'name' => __('Posts', 'LayerSlider'),
			'keys' => 'popup_pages_post',
			'props' => [
				'meta' => true
			]
		],

		'popupPagesCustom' => [
			'value' => '',
			'name' => __('Include Custom Pages', 'LayerSlider'),
			'keys' => 'popup_pages_custom',
			'props' => [
				'meta' => true
			]
		],

		'popupPagesExclude' => [
			'value' => '',
			'name' => __('Exclude Pages', 'LayerSlider'),
			'keys' => 'popup_pages_exclude',
			'props' => [
				'meta' => true
			]
		],

		'popupRolesAdministrator' => [
			'value' => true,
			'name' => __('Administrators', 'LayerSlider'),
			'keys' => 'popup_roles_administrator',
			'props' => [ 'meta' => true ]
		],

		'popupRolesEditor' => [
			'value' => true,
			'name' => __('Editors', 'LayerSlider'),
			'keys' => 'popup_roles_editor',
			'props' => [ 'meta' => true ]
		],

		'popupRolesAuthor' => [
			'value' => true,
			'name' => __('Authors', 'LayerSlider'),
			'keys' => 'popup_roles_author',
			'props' => [ 'meta' => true ]
		],

		'popupRolesContributor' => [
			'value' => true,
			'name' => __('Contributors', 'LayerSlider'),
			'keys' => 'popup_roles_contributor',
			'props' => [ 'meta' => true ]
		],

		'popupRolesSubscriber' => [
			'value' => true,
			'name' => __('Subscribers', 'LayerSlider'),
			'keys' => 'popup_roles_subscriber',
			'props' => [ 'meta' => true ]
		],

		'popupRolesCustomer' => [
			'value' => true,
			'name' => __('Customers', 'LayerSlider'),
			'keys' => 'popup_roles_customer',
			'props' => [ 'meta' => true ]
		],

		'popupRolesVisitor' => [
			'value' => true,
			'name' => __('Visitors', 'LayerSlider'),
			'keys' => 'popup_roles_visitor',
			'props' => [ 'meta' => true ]
		],

		'popupFirstTimeVisitor' => [
			'value' => false,
			'name' => __('Show Only For First Time Visitors', 'LayerSlider'),
			'keys' => 'popup_first_time_visitor',
			'props' => [ 'meta' => true ]
		],

		'popupRepeat' => [
			'value' => true,
			'name' => __('Repeat Popup', 'LayerSlider'),
			'keys' => 'popup_repeat',
			'desc' => __('Enables or disables repeating this Popup to your target audience with the below specified frequency.', 'LayerSlider'),
			'props' => [ 'meta' => true ]
		],

		'popupRepeatDays' => [
			'value' => '',
			'name' => __('Repeat After', 'LayerSlider'),
			'keys' => 'popup_repeat_days',
			'desc' => __('Controls the repeat frequency of this Popup specified in days. Leave this option empty if you want to display the Popup on each page load. Enter 0 to repeat after the end of a browsing session (when the browser closes).', 'LayerSlider'),
			'props' => [ 'meta' => true ],
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'max' => 365
			]
		],





		// ========== //
		// |  Misc  | //
		// ========== //


		'relativeURLs' => [
			'value' => false,
			'name' => __('Use Relative URLs', 'LayerSlider'),
			'keys' => 'relativeurls',
			'desc' => __('Use relative URLs for local images. This setting could be important when moving your WP installation.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],

		'allowRestartOnResize' => [
			'value' => false,
			'name' => __('Allow Restarting Slides On Resize', 'LayerSlider'),
			'keys' => 'allowRestartOnResize',
			'desc' => __('Certain transformation and transition options cannot be updated on the fly when the browser size or device orientation changes. By enabling this option, LayerSlider will automatically detect such situations and will restart itself to preserve its appearance.', 'LayerSlider'),
			'advanced' => true
		],

		'useSrcset' => [
			'value' => 'inherit',
			'name' => __('Use srcset Attribute', 'LayerSlider'),
			'keys' => 'useSrcset',
			'desc' => __('The srcset attribute allows loading dynamically scaled images based on screen resolution. It can save bandwidth and allow using retina-ready images on high resolution devices. In some rare edge cases, this option might cause blurry images.', 'LayerSlider'),
			'options' => [
				'inherit' => __('Global default', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			],
			'props' => [
				'forceoutput' => true
			]
		],

		'enhancedLazyLoad' => [
			'value' => 'inherit',
			'name' => 'Enhanced Lazy Load',
			'keys' => 'enhancedLazyLoad',
			'desc' => __('The default lazy loading behavior ensures maximum compatibility and works ideally for general purposes. However, there is a chance that the browser might start downloading some assets for a split second before LayerSlider cancels them. Enabling this option will eliminate any chance of generating even a minuscule amount of unwanted traffic, but it can also cause issues for search engine indexing and other WP themes/plugins.', 'LayerSlider'),
			'options' => [
				'inherit' => __('Global default', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			],
			'advanced' => true,
			'props' => [
				'meta' => true
			]
		],


		'preferBlendMode' => [
			'value' => 'disabled',
			'name' => __('Prefer Blend Mode', 'LayerSlider'),
			'keys' => 'preferBlendMode',
			'desc' => __('Enable this option to avoid blend mode issues with slide transitions. Due to technical limitations, this will also clip your slide transitions regardless of your settings.', 'LayerSlider'),
			'options' => [
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			],
			'advanced' => true
		],


		'postType' => [
			'value' => '',
			'keys' => 'post_type',
			'props' => [
				'meta' => true
			]
		],

		'postOrderBy' => [
			'value' => 'date',
			'keys' => 'post_orderby',
			'options' => [
				'date' => __('Date Published', 'LayerSlider'),
				'modified' => __('Date Modified', 'LayerSlider'),
				'ID' => __('Post ID', 'LayerSlider'),
				'title' => __('Post Title', 'LayerSlider'),
				'comment_count' => __('Number of Comments', 'LayerSlider'),
				'rand' => __('Random', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],

		'postOrder' => [
			'value' => 'DESC',
			'keys' => 'post_order',
			'options' => [
				'ASC' => __('Ascending', 'LayerSlider'),
				'DESC' => __('Descending', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],

		'postCategories' => [
			'value' => '',
			'keys' => 'post_categories',
			'props' => [
				'meta' => true
			]
		],

		'postTags' => [
			'value' => '',
			'keys' => 'post_tags',
			'props' => [
				'meta' => true
			]
		],

		'postTaxonomy' => [
			'value' => '',
			'keys' => 'post_taxonomy',
			'props' => [
				'meta' => true
			]
		],

		'postTaxTerms' => [
			'value' => '',
			'keys' => 'post_tax_terms',
			'props' => [
				'meta' => true
			]
		]
	],

	'slides' => [

		'image' => [
			'value' => '',
			'name' => __('Set A Slide Image', 'LayerSlider'),
			'keys' => 'background',
			'props' => [ 'meta' => true ]
		],

		'imageId' => [
			'value' => '',
			'keys' => 'backgroundId',
			'props' => [ 'meta' => true ]
		],

		'imageSize' => [
			'value' => 'inherit',
			'name' => __('Size', 'LayerSlider'),
			'keys' => 'bgsize',
			'options' => [
				'inherit' => __('Inherit', 'LayerSlider'),
				'auto' => __('Auto', 'LayerSlider'),
				'cover' => __('Cover', 'LayerSlider'),
				'contain' => __('Contain', 'LayerSlider'),
				'100% 100%' => __('Stretch', 'LayerSlider')
			]
		],

		'imagePosition' => [
			'value' => 'inherit',
			'name' => __('Position', 'LayerSlider'),
			'keys' => 'bgposition'
		],

		'imageColor' => [
			'value' => '',
			'name' => __('Background Color', 'LayerSlider'),
			'keys' => 'bgcolor'
		],

		'thumbnail' => [
			'value' => '',
			'name' => __('Set A Slide Thumbnail', 'LayerSlider'),
			'keys' => 'thumbnail',
			'props' => [ 'meta' => true ]
		],

		'thumbnailId' => [
			'value' => '',
			'keys' => 'thumbnailId',
			'props' => [ 'meta' => true ]
		],

		'delay' => [
			'value' => '',
			'name' => __('Duration', 'LayerSlider'),
			'keys' => ['slidedelay', 'duration'],
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'step' => 500,
				'placeholder' => __('auto', 'LayerSlider')
			]
		],

		'2dTransitions' => [
			'value' => '',
			'keys' => ['2d_transitions', 'transition2d']
		],

		'3dTransitions' => [
			'value' => '',
			'keys' => ['3d_transitions', 'transition3d']
		],

		'custom2dTransitions' => [
			'value' => '',
			'keys' => ['custom_2d_transitions', 'customtransition2d']
		],

		'custom3dTransitions' => [
			'value' => '',
			'keys' => ['custom_3d_transitions', 'customtransition3d']
		],

		'customProperties' => [
			'value' => '',
			'keys' => 'customProperties',
			'props' => [
				'meta' => true
			]
		],

		'transitionOrigami' => [
			'value' => false,
			'name' => __('Origami', 'LayerSlider'),
			'keys' => 'transitionorigami',
			'premium' => true
		],

		'transitionDuration' => [
			'value' => '',
			'name' => __('Custom Transition Duration', 'LayerSlider'),
			'keys' => 'transitionduration',
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'step' => 500,
				'placeholder' => __( 'auto', 'LayerSlider' )
			]
		],

		'timeshift' => [
			'value' => 0,
			'name' => __('Time Shift', 'LayerSlider'),
			'keys' => 'timeshift',
			'attrs' => [
				'step' => 50
			]
		],

		'linkUrl' => [
			'value' => '',
			'name' => __('Enter URL', 'LayerSlider'),
			'keys' => ['layer_link', 'linkUrl'],
			'props' => [
				'meta' => true
			]
		],


		'linkId' => [
			'value' => '',
			'keys' => 'linkId',
			'props' => [ 'meta' => true ]
		],

		'linkName' => [
			'value' => '',
			'keys' => 'linkName',
			'props' => [ 'meta' => true ]
		],

		'linkType' => [
			'value' => '',
			'keys' => 'linkType',
			'props' => [ 'meta' => true ]
		],

		'linkTarget' => [
			'value' => '_self',
			'name' => __('Link Target', 'LayerSlider'),
			'keys' => ['layer_link_target', 'linkTarget'],
			'options' => [
				'_self' => __('Open on the same page', 'LayerSlider'),
				'_blank' => __('Open on new page', 'LayerSlider'),
				'_parent' => __('Open in parent frame', 'LayerSlider'),
				'_top' => __('Open in main frame', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],


		'linkPosition' => [
			'value' => 'over',
			'keys' => ['layer_link_type', 'linkPosition'],
			'options' => [
				'over' => __('On top of layers', 'LayerSlider'),
				'under' => __('Underneath layers', 'LayerSlider'),
			],
			'props' => [
				'meta' => true
			]
		],

		'ID' => [
			'value' => '',
			'name' => __('#ID', 'LayerSlider'),
			'keys' => 'id',
			'props' => [
				'meta' => true
			]
		],

		'deeplink' => [
			'value' => '',
			'name' => __('Deeplink', 'LayerSlider'),
			'keys' => 'deeplink',
			'attrs' => [
				'placeholder' => __('Enter slide slug', 'LayerSlider')
			]
		],

		'globalHover' => [
			'value' => false,
			'name' => __('Global Hover', 'LayerSlider'),
			'keys' => 'globalhover',
			'premium' => true
		],

		'postContent' => [
			'value' => null,
			'keys' => 'post_content',
			'props' => [
				'meta' => true
			]
		],


		'postOffset' => [
			'value' => '-1',
			'keys' => 'post_offset',
			'props' => [
				'meta' => true
			]
		],

		'skipSlide' => [
			'value' => false,
			'name' => __('Hidden', 'LayerSlider'),
			'keys' => 'skip',
			'props' => [
				'meta' => true
			]
		],


		'overflow' => [
			'value' => false,
			'name' => __('Overflow Layers', 'LayerSlider'),
			'keys' => 'overflow'
		],

		'kenBurnsZoom' => [
			'value' => 'disabled',
			'name' => __('Zoom', 'LayerSlider'),
			'keys' => 'kenburnszoom',
			'options' => [
				'disabled' => __('Disabled', 'LayerSlider'),
				'in' => __('Zoom In', 'LayerSlider'),
				'out' => __('Zoom Out', 'LayerSlider')
			]
		],

		'kenBurnsRotate' => [
			'value' => '',
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'kenburnsrotate',
			'attrs' => [
				'type' => 'number',
				'placeholder' => 0
			]

		],

		'kenBurnsScale' => [
			'value' => 1.2,
			'name' => __('Scale', 'LayerSlider'),
			'keys' => 'kenburnsscale',
			'attrs' => [
				'type' => 'number',
				'step' => 0.1
			],
			'props' => [
				'output' => true
			]
		],


		'parallaxType' => [
			'value' => '2d',
			'name' => __('Type', 'LayerSlider'),
			'keys' => 'parallaxtype',
			'options' => [
				'2d' => __('2D', 'LayerSlider'),
				'3d' => __('3D', 'LayerSlider')
 			]
		],

		'parallaxEvent' => [
			'value' => 'cursor',
			'name' => __('Event', 'LayerSlider'),
			'keys' => 'parallaxevent',
			'options' => [
				'cursor' => __('Cursor or Tilt', 'LayerSlider'),
				'scroll' => __('Scroll', 'LayerSlider')
 			]
		],

		'parallaxAxis' => [
			'value' => 'both',
			'name' => __('Axes', 'LayerSlider'),
			'keys' => 'parallaxaxis',
			'options' => [
				'none' => __('None', 'LayerSlider'),
				'both' => __('Both axes', 'LayerSlider'),
				'x' => __('Horizontal only', 'LayerSlider'),
				'y' => __('Vertical only', 'LayerSlider')
			]
		],


		'parallaxTransformOrigin' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'parallaxtransformorigin'
		],

		'parallaxDurationMove' => [
			'value' => 1500,
			'name' => __('Move Duration', 'LayerSlider'),
			'keys' => 'parallaxdurationmove',
			'attrs' => [
				'type' => 'number',
				'step' => 100,
				'min' => 0
			]
		],

		'parallaxDurationLeave' => [
			'value' => 1200,
			'name' => __('Leave Duration', 'LayerSlider'),
			'keys' => 'parallaxdurationleave',
			'attrs' => [
				'type' => 'number',
				'step' => 100,
				'min' => 0
			]
		],

		'parallaxDistance' => [
			'value' => 10,
			'name' => __('Distance', 'LayerSlider'),
			'keys' => 'parallaxdistance',
			'attrs' => [
				'type' => 'number',
				'step' => 1
			]
		],

		'parallaxRotate' => [
			'value' => 10,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'parallaxrotate',
			'attrs' => [
				'type' => 'number',
				'step' => 1
			]
		],

		'parallaxPerspective' => [
			'value' => 500,
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'parallaxtransformperspective',
			'attrs' => [
				'type' => 'number',
				'step' => 100
			]
		],

		'scheduleStart' => [
			'value' => '',
			'name' => __('Schedule From', 'LayerSlider'),
			'keys' => 'schedule_start',
			'attrs' => [
				'placeholder' => __('No schedule', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],


		'scheduleEnd' => [
			'value' => '',
			'name' => __('Schedule Until', 'LayerSlider'),
			'keys' => 'schedule_end',
			'attrs' => [
				'placeholder' => __('No schedule', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		]
	],

	'layers' => [

		// ======================= //
		// |  Content  | //
		// ======================= //

		'uuid' => [
			'value' => '',
			'keys' => 'uuid',
			'props' => [
				'meta' => true
			]
		],

		'type' => [
			'value' => 'ls-layer',
			'keys' => 'type',
			'props' => [
				'meta' => true
			]
		],

		'htmlTag' => [
			'value' => 'ls-layer',
			'name' => __('HTML Element', 'LayerSlider'),
			'keys' => 'htmlTag',
			'props' => [
				'meta' => true
			],
			'options' => [
				'ls-layer' => '&lt;ls-layer&gt;',
				'div' => '&lt;div&gt;',
				'span' => '&lt;span&gt;',
				'p' => '&lt;p&gt;',
				'h1' => '&lt;h1&gt;',
				'h2' => '&lt;h2&gt;',
				'h3' => '&lt;h3&gt;',
				'h4' => '&lt;h4&gt;',
				'h5' => '&lt;h5&gt;',
				'h6' => '&lt;h6&gt;',
			]
		],

		'hide_on_desktop' => [
			'value' => false,
			'keys' => 'hide_on_desktop',
			'props' => [
				'meta' => true
			]
		],

		'hide_on_tablet' => [
			'value' => false,
			'keys' => 'hide_on_tablet',
			'props' => [
				'meta' => true
			]
		],

		'hide_on_phone' => [
			'value' => false,
			'keys' => 'hide_on_phone',
			'props' => [
				'meta' => true
			]
		],

		'media' => [
			'value' => 'img',
			'keys' => 'media',
			'props' => [
				'meta' => true
			]
		],

		'image' => [
			'value' => '',
			'keys' => 'image',
			'props' => [
				'meta' => true
			]
		],

		'imageId' => [
			'value' => '',
			'keys' => 'imageId',
			'props' => [ 'meta' => true ]
		],

		'html' => [
			'value' => '',
			'keys' => 'html',
			'props' => [
				'meta' => true,
				'forceoutput' => true
			]
		],

		'icon' => [
			'value' => '',
			'keys' => 'icon',
			'props' => [
				'meta' => true
			]
		],

		'iconColor' => [
			'value' => '',
			'name' => __('Icon Color', 'LayerSlider'),
			'keys' => 'iconColor',
			'props' => [
				'meta' => true
			]
		],

		'iconPlacement' => [
			'value' => 'right',
			'name' => __('Icon Placement', 'LayerSlider'),
			'keys' => 'iconPlacement',
			'options' => [
				'left' => __('Left', 'LayerSlider'),
				'right' => __('Right', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],

		'iconSize' => [
			'value' => 1,
			'name' => __('Icon Size', 'LayerSlider'),
			'keys' => 'iconSize',
			'attrs' => [
				'type' => 'number',
				'step' => 0.05,
				'min' => 0.2
			],
			'props' => [
				'meta' => true
			]
		],

		'iconGap' => [
			'value' => 0,
			'name' => __('Icon Gap', 'LayerSlider'),
			'keys' => 'iconGap',
			'attrs' => [
				'type' => 'number',
				'step' => 0.1,
				'min' => 0
			],
			'props' => [
				'meta' => true
			]
		],

		'iconVerticalAdjustment' => [
			'value' => 0,
			'name' => __('Vertical Adjustment', 'LayerSlider'),
			'keys' => 'iconVerticalAdjustment',
			'attrs' => [
				'type' => 'number',
				'step' => 0.025
			],
			'props' => [
				'meta' => true
			]
		],

		'htmlLineBreak' => [
			'value' => 'auto',
			'keys' => 'htmlLineBreak',
			'name' => __('Line Break', 'LayerSlider'),
			'options' => [
				'auto' => __('Automatic', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'manual' => _x('Manual (&lt;br&gt;)', 'Displays as "Manual (<br>)". Plase don’t change the HTML entities.', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],

		'actions' => [
			'value' => '',
			'keys' => 'actions',
			'props' => [
				'meta' => true
			]
		],

		'mediaAutoPlay' => [
			'value' => 'inherit',
			'name' => __('Media Autoplay', 'LayerSlider'),
			'keys' => 'autoplay',
			'options' => [
				'inherit' => __('Inherit', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			]
		],

		'mediaInfo' => [
			'value' => 'auto',
			'name' => __('Show Media Info', 'LayerSlider'),
			'keys' => 'showinfo',
			'options' => [
				'auto' => __('Auto', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			]
		],

		'mediaControls' => [
			'value' => 'auto',
			'name' => __('Media Controls', 'LayerSlider'),
			'keys' => 'controls',
			'options' => [
				'auto' => __('Auto', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			]
		],


		'mediaPoster' => [
			'value' => '',
			'keys' => 'poster',
			'name' => __('Media Poster Image', 'LayerSlider')
		],

		'mediaPosterId' => [
			'value' => '',
			'keys' => 'posterId',
			'props' => [ 'meta' => true ]
		],


		'mediaFillMode' => [
			'value' => 'cover',
			'name' => __('Media Fill Mode', 'LayerSlider'),
			'keys' => 'fillmode',
			'options' => [
				'contain'  => __('Contain', 'LayerSlider'),
				'cover'  => __('Cover', 'LayerSlider')
			]
		],


		'mediaVolume' => [
			'value' => '',
			'name' => __('Media Volume', 'LayerSlider'),
			'keys' => 'volume',
			'attrs' => [
				'type' => 'number',
				'min' => 0,
				'max' => 100,
				'placeholder' => __('auto', 'LayerSlider')
			]
		],

		'mediaMuted' => [
			'value' => 'auto',
			'name' => __('Play Media Muted', 'LayerSlider'),
			'keys' => 'muted',
			'options' => [
				'auto'  => __('Auto', 'LayerSlider'),
				'enabled'  => __('Enabled', 'LayerSlider'),
				'disabled'  => __('Disabled', 'LayerSlider'),
				'offerToUnmute'  => __('Offer to unmute', 'LayerSlider')
			]
		],


		'mediaLoop' => [
			'value' => 'auto',
			'name' => __('Media Loop', 'LayerSlider'),
			'keys' => 'loopmedia',
			'options' => [
				'auto' => __('Auto', 'LayerSlider'),
				'enabled' => __('Enabled', 'LayerSlider'),
				'disabled' => __('Disabled', 'LayerSlider')
			]
		],

		'mediaBackgroundVideo' => [
			'value' => false,
			'name' => __('Background Video', 'LayerSlider'),
			'keys' => 'backgroundvideo'
		],

		'mediaOverlay' => [
			'value' => 'disabled',
			'name' => __('Video Overlay Image', 'LayerSlider'),
			'keys' => 'overlay'
		],


		'postTextLength' => [
			'value' => '',
			'keys' => 'post_text_length',
			'name' => __('Limit Post Text Length', 'LayerSlider'),
			'attrs' => [
				'type' => 'number',
				'min' => 0
			],
			'props' => [
				'meta' => true
			]
		],


		// ======================= //
		// |  Animation options  | //
		// ======================= //
		'transition' => [ 'value' => '', 'keys' => 'transition', 'props' => [ 'meta' => true ] ],

		'transitionIn' => [
			'value' => true,
			'keys' => 'transitionin'
		],

		'transitionInOffsetX' => [
			'value' => '0',
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'offsetxin',
			'attrs' => ['type' => 'text']
		],

		'transitionInOffsetY' => [
			'value' => '0',
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'offsetyin',
			'attrs' => ['type' => 'text']
		],

		'transitionInDuration' => [
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'durationin',
			'attrs' => [ 'min' => 0, 'step' => 50 ]
		],

		'transitionInDelay' => [
			'value' => 0,
			'name' => __('Start At', 'LayerSlider'),
			'keys' => 'delayin',
			'attrs' => [ 'min' => 0, 'step' => 50 ]
		],

		'transitionInEasing' => [
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'easingin'
		],

		'transitionInFade' => [
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys' => 'fadein'
		],

		'transitionInRotate' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'rotatein',
			'attrs' => ['type' => 'text']
		],

		'transitionInRotateX' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys' => 'rotatexin',
			'attrs' => ['type' => 'text']
		],

		'transitionInRotateY' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys' => 'rotateyin',
			'attrs' => ['type' => 'text']
		],

		'transitionInSkewX' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewxin',
			'attrs' => ['type' => 'text']
		],

		'transitionInSkewY' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewyin',
			'attrs' => ['type' => 'text']
		],

		'transitionInScaleX' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scalexin',
			'attrs' => ['type' => 'text']
		],

		'transitionInScaleY' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleyin',
			'attrs' => ['type' => 'text']
		],

		'transitionInTransformOrigin' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'transformoriginin'
		],

		'transitionInClip' => [
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'clipin'
		],

		'transitionInBGColor' => [
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'bgcolorin'
		],

		'transitionInColor' => [
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'colorin'
		],

		'transitionInRadius' => [
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'radiusin'
		],

		'transitionInWidth' => [
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'widthin'
		],

		'transitionInHeight' => [
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'heightin'
		],

		'transitionInFilter' => [
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filterin'
		],

		'transitionInPerspective' => [
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'transformperspectivein'
		],

		// ======

		'transitionOut' => [
			'value' => true,
			'keys' => 'transitionout'
		],

		'transitionOutOffsetX' => [
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'offsetxout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutOffsetY' => [
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'offsetyout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutDuration' => [
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'durationout',
			'attrs' => [ 'min' => 0, 'step' => 50 ]
		],

		'showUntil' => [
			'value' => '0',
			'keys' => 'showuntil'
		],

		'transitionOutStartAt' => [
			'value' => 'slidechangeonly',
			'name' => __('Start At', 'LayerSlider'),
			'keys' => 'startatout',
			'attrs' => [ 'type' => 'hidden' ]
		],


		'transitionOutStartAtTiming' => [
			'value' => 'slidechangeonly',
			'keys' => 'startatouttiming',
			'props' => [ 'meta' => true ],
			'options' => [
				'slidechangeonly' => __('Slide change starts (ignoring modifier)', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes', 'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider'),
				'textinandloopend' => __('Opening Text and Loop Transitions complete', 'LayerSlider'),
				'allinandloopend' => __('Opening, Opening Text and Loop Transitions complete', 'LayerSlider'),
				'textoutstart' => __('Ending Text Transition starts', 'LayerSlider'),
				'textoutend' => __('Ending Text Transition completes', 'LayerSlider'),
				'textoutandloopend' => __('Ending Text and Loop Transitions complete', 'LayerSlider')
			]
		],

		'transitionOutStartAtOperator' => [
			'value' => '+',
			'keys' => 'startatoutoperator',
			'props' => [ 'meta' => true ],
			'options' => ['+', '-', '/', '*']
		],

		'transitionOutStartAtValue' => [
			'value' => 0,
			'keys' => 'startatoutvalue',
			'props' => [ 'meta' => true ]
		],


		'transitionOutEasing' => [
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'easingout'
		],

		'transitionOutFade' => [
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys' => 'fadeout'
		],

		'transitionOutRotate' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'rotateout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutRotateX' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys' => 'rotatexout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutRotateY' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys' => 'rotateyout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutSkewX' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewxout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutSkewY' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewyout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutScaleX' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scalexout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutScaleY' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleyout',
			'attrs' => ['type' => 'text']
		],

		'transitionOutTransformOrigin' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'transformoriginout'
		],

		'transitionOutClip' => [
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'clipout'
		],

		'transitionOutFilter' => [
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filterout'
		],

		'transitionOutPerspective' => [
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'transformperspectiveout'
		],

		// -----

		'skipLayer' => [
			'value' => false,
			'name' => __('Hidden', 'LayerSlider'),
			'keys' => 'skip',
			'props' => [
				'meta' => true
			]
		],

		'transitionOutBGColor' => [
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'bgcolorout'
		],

		'transitionOutColor' => [
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'colorout'
		],

		'transitionOutRadius' => [
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'radiusout'
		],

		'transitionOutWidth' => [
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'widthout'
		],

		'transitionOutHeight' => [
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'heightout'
		],


		// == Compatibility ==
		'transitionInType' => [
			'value' => 'auto',
			'keys' => 'slidedirection'
		],
		'transitionOutType' => [
			'value' => 'auto',
			'keys' => 'slideoutdirection'
		],

		'transitionOutDelay' => [
			'value' => 0,
			'keys' => 'delayout'
		],

		'transitionInScale' => [
			'value' => '1.0',
			'keys' => 'scalein'
		],

		'transitionOutScale' => [
			'value' => '1.0',
			'keys' => 'scaleout'
		],



		// Text Animation IN
		// -----------------

		'textTransitionIn' => [
			'value' => false,
			'keys' => 'texttransitionin'
		],

		'textTypeIn' => [
			'value' => 'chars_asc',
			'name' => __('Animate', 'LayerSlider'),
			'keys' => 'texttypein',
			'options' => [
				'lines_asc'  => __('by lines ascending', 'LayerSlider'),
				'lines_desc' => __('by lines descending', 'LayerSlider'),
				'lines_rand' => __('by lines random', 'LayerSlider'),
				'lines_center' => __('by lines center to edge', 'LayerSlider'),
				'lines_edge' => __('by lines edge to center', 'LayerSlider'),
				'words_asc'  => __('by words ascending', 'LayerSlider'),
				'words_desc' => __('by words descending', 'LayerSlider'),
				'words_rand' => __('by words random', 'LayerSlider'),
				'words_center' => __('by words center to edge', 'LayerSlider'),
				'words_edge' => __('by words edge to center', 'LayerSlider'),
				'chars_asc'  => __('by chars ascending', 'LayerSlider'),
				'chars_desc' => __('by chars descending', 'LayerSlider'),
				'chars_rand' => __('by chars random', 'LayerSlider'),
				'chars_center' => __('by chars center to edge', 'LayerSlider'),
				'chars_edge' => __('by chars edge to center', 'LayerSlider')
			],
			'props' => [
				'output' => true
			]
		],

		'textShiftIn' => [
			'value' => 50,
			'name' => __('Shift In', 'LayerSlider'),
			'keys'  => 'textshiftin',
			'attrs' => ['type' => 'number']
		],

		'textOffsetXIn' => [
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys'  => 'textoffsetxin',
			'attrs' => ['type' => 'text']
		],

		'textOffsetYIn' => [
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys'  => 'textoffsetyin',
			'attrs' => ['type' => 'text']
		],

		'textDurationIn' => [
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys'  => 'textdurationin',
			'attrs' => [ 'min' => 0, 'step' => 50 ]
		],

		'textEasingIn' => [
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys'  => 'texteasingin',
		],

		'textFadeIn' => [
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys'  => 'textfadein'
		],

		'textStartAtIn' => [
			'value' => 'transitioninend',
			'name' => __('StartAt', 'LayerSlider'),
			'keys'  => 'textstartatin',
			'attrs' => ['type' => 'hidden']
		],

		'textStartAtInTiming' => [
			'value' => 'transitioninend',
			'keys'  => 'textstartatintiming',
			'props' => [ 'meta' => true ],
			'options' => [
				'transitioninstart' => __('Opening Transition starts', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes', 'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider')
			]
		],

		'textStartAtInOperator' => [
			'value' => '+',
			'keys'  => 'textstartatinoperator',
			'props' => [ 'meta' => true ],
			'options' => ['+', '-', '/', '*']
		],

		'textStartAtInValue' => [
			'value' => 0,
			'keys'  => 'textstartatinvalue',
			'props' => [ 'meta' => true ]
		],

		'textRotateIn' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys'  => 'textrotatein',
			'attrs' => ['type' => 'text']
		],

		'textRotateXIn' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys'  => 'textrotatexin',
			'attrs' => ['type' => 'text']
		],

		'textRotateYIn' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys'  => 'textrotateyin',
			'attrs' => ['type' => 'text']
		],

		'textScaleXIn' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys'  => 'textscalexin',
			'attrs' => ['type' => 'text']
		],

		'textScaleYIn' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys'  => 'textscaleyin',
			'attrs' => ['type' => 'text']
		],

		'textSkewXIn' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys'  => 'textskewxin',
			'attrs' => ['type' => 'text']
		],

		'textSkewYIn' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys'  => 'textskewyin',
			'attrs' => ['type' => 'text']
		],



		'textTransformOriginIn' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys'  => 'texttransformoriginin'
		],

		'textPerspectiveIn' => [
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'texttransformperspectivein',
		],




		// Text Animation OUT
		// -----------------

		'textTransitionOut' => [
			'value' => false,
			'keys' => 'texttransitionout'
		],

		'textTypeOut' => [
			'value' => 'chars_desc',
			'name' => __('Animate', 'LayerSlider'),
			'keys' => 'texttypeout',
			'options' => [
				'lines_asc'  => __('by lines ascending', 'LayerSlider'),
				'lines_desc' => __('by lines descending', 'LayerSlider'),
				'lines_rand' => __('by lines random', 'LayerSlider'),
				'lines_center' => __('by lines center to edge', 'LayerSlider'),
				'lines_edge' => __('by lines edge to center', 'LayerSlider'),
				'words_asc'  => __('by words ascending', 'LayerSlider'),
				'words_desc' => __('by words descending', 'LayerSlider'),
				'words_rand' => __('by words random', 'LayerSlider'),
				'words_center' => __('by words center to edge', 'LayerSlider'),
				'words_edge' => __('by words edge to center', 'LayerSlider'),
				'chars_asc'  => __('by chars ascending', 'LayerSlider'),
				'chars_desc' => __('by chars descending', 'LayerSlider'),
				'chars_rand' => __('by chars random', 'LayerSlider'),
				'chars_center' => __('by chars center to edge', 'LayerSlider'),
				'chars_edge' => __('by chars edge to center', 'LayerSlider')
			],
			'props' => [
				'output' => true
			]
		],

		'textShiftOut' => [
			'value' => '',
			'name' => __('Shift Out', 'LayerSlider'),
			'keys'  => 'textshiftout',
			'attrs' => ['type' => 'number']
		],

		'textOffsetXOut' => [
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys'  => 'textoffsetxout',
			'attrs' => ['type' => 'text']
		],

		'textOffsetYOut' => [
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys'  => 'textoffsetyout',
			'attrs' => ['type' => 'text']
		],

		'textDurationOut' => [
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys'  => 'textdurationout',
			'attrs' => [ 'min' => 0, 'step' => 50 ]
		],

		'textEasingOut' => [
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys'  => 'texteasingout',
			'attrs' => ['type' => 'hidden']
		],

		'textFadeOut' => [
			'value' => true,
			'name' => __('Fade', 'LayerSlider'),
			'keys'  => 'textfadeout'
		],

		'textStartAtOut' => [
			'value' => 'allinandloopend',
			'name' => __('StartAt', 'LayerSlider'),
			'keys'  => 'textstartatout',
			'attrs' => ['type' => 'hidden']
		],

		'textStartAtOutTiming' => [
			'value' => 'allinandloopend',
			'keys'  => 'textstartatouttiming',
			'props' => [ 'meta' => true ],
			'options' => [
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider'),
				'loopstart' => __('Loop starts', 'LayerSlider'),
				'loopend' => __('Loop completes',  'LayerSlider'),
				'transitioninandloopend' => __('Opening and Loop Transitions complete', 'LayerSlider'),
				'textinandloopend' => __('Opening Text and Loop Transitions complete', 'LayerSlider'),
				'allinandloopend' => __('Opening, Opening Text and Loop Transitions complete', 'LayerSlider')
			]
		],

		'textStartAtOutOperator' => [
			'value' => '+',
			'keys'  => 'textstartatoutoperator',
			'props' => [ 'meta' => true ],
			'options' => ['+', '-', '/', '*']
		],

		'textStartAtOutValue' => [
			'value' => 0,
			'keys'  => 'textstartatoutvalue',
			'props' => [ 'meta' => true ]
		],

		'textRotateOut' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys'  => 'textrotateout',
			'attrs' => ['type' => 'text']
		],

		'textRotateXOut' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys'  => 'textrotatexout',
			'attrs' => ['type' => 'text']
		],

		'textRotateYOut' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys'  => 'textrotateyout',
			'attrs' => ['type' => 'text']
		],

		'textScaleXOut' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys'  => 'textscalexout',
			'attrs' => ['type' => 'text']
		],

		'textScaleYOut' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys'  => 'textscaleyout',
			'attrs' => ['type' => 'text']
		],

		'textSkewXOut' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys'  => 'textskewxout',
			'attrs' => ['type' => 'text']
		],

		'textSkewYOut' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys'  => 'textskewyout',
			'attrs' => ['type' => 'text']
		],



		'textTransformOriginOut' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys'  => 'texttransformoriginout',
			'attrs' => ['type' => 'text']
		],


		'textPerspectiveOut' => [
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'texttransformperspectiveout',
		],







		// ======


		// LOOP

		'loop' => [
			'value' => false,
			'keys' => 'loop'
		],

		'loopOffsetX' => [
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'loopoffsetx',
			'attrs' => ['type' => 'text']
		],

		'loopOffsetY' => [
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'loopoffsety',
			'attrs' => ['type' => 'text']
		],

		'loopDuration' => [
			'value' => 1000,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'loopduration',
			'attrs' => ['min' => 0, 'step' => 100 ]
		],

		'loopStartAt' => [
			'value' => 'allinend',
			'name' => __('Start At', 'LayerSlider'),
			'keys' => 'loopstartat',
			'attrs' => ['type' => 'hidden', 'step' => 100 ]
		],

		'loopStartAtTiming' => [
			'value' => 'allinend',
			'keys'  => 'loopstartattiming',
			'props' => [ 'meta' => true ],
			'options' => [
				'transitioninstart' => __('Opening Transition starts', 'LayerSlider'),
				'transitioninend' => __('Opening Transition completes', 'LayerSlider'),
				'textinstart' => __('Opening Text Transition starts', 'LayerSlider'),
				'textinend' => __('Opening Text Transition completes', 'LayerSlider'),
				'allinend' => __('Opening and Opening Text Transition complete', 'LayerSlider')
			]
		],

		'loopStartAtOperator' => [
			'value' => '+',
			'keys'  => 'loopstartatoperator',
			'props' => [ 'meta' => true ],
			'options' => ['+', '-', '/', '*']
		],

		'loopStartAtValue' => [
			'value' => 0,
			'keys'  => 'loopstartatvalue',
			'props' => [ 'meta' => true ]
		],

		'loopEasing' => [
			'value' => 'linear',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'loopeasing'
		],

		'loopOpacity' => [
			'value' => 1,
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'loopopacity',
			'attrs' => [ 'min' => 0, 'max' => 1, 'step' => 0.1 ]
		],

		'loopRotate' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'looprotate',
			'attrs' => ['type' => 'text']
		],

		'loopRotateX' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys' => 'looprotatex',
			'attrs' => ['type' => 'text']
		],

		'loopRotateY' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys' => 'looprotatey',
			'attrs' => ['type' => 'text']
		],

		'loopSkewX' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'loopskewx',
			'attrs' => ['type' => 'text']
		],

		'loopSkewY' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'loopskewy',
			'attrs' => ['type' => 'text']
		],

		'loopScaleX' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'loopscalex',
			'attrs' => ['type' => 'text']
		],

		'loopScaleY' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'loopscaley',
			'attrs' => ['type' => 'text']
		],

		'loopTransformOrigin' => [
			'value' => '50% 50% 0',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'looptransformorigin'
		],

		'loopClip' => [
			'value' => '',
			'name' => __('Mask', 'LayerSlider'),
			'keys' => 'loopclip'
		],

		'loopCount' => [
			'value' => '1',
			'name' => __('Repeat', 'LayerSlider'),
			'keys' => 'loopcount',
			'props' => [
				'output' => true
			],
			'options' => [
				'-1' => __('Infinite', 'LayerSlider'),
				'1' => __('No repeat', 'LayerSlider'),
				'2' => __('1x', 'LayerSlider'),
				'3' => __('2x', 'LayerSlider'),
				'4' => __('3x', 'LayerSlider'),
				'5' => __('4x', 'LayerSlider'),
				'6' => __('5x', 'LayerSlider'),
				'7' => __('6x', 'LayerSlider'),
				'8' => __('7x', 'LayerSlider'),
				'9' => __('8x', 'LayerSlider'),
				'10' => __('9x', 'LayerSlider'),
				'11' => __('10x', 'LayerSlider'),
				'12' => __('11x', 'LayerSlider'),
				'13' => __('12x', 'LayerSlider'),
				'14' => __('13x', 'LayerSlider'),
				'15' => __('14x', 'LayerSlider'),
				'16' => __('15x', 'LayerSlider'),
				'17' => __('16x', 'LayerSlider'),
				'18' => __('17x', 'LayerSlider'),
				'19' => __('18x', 'LayerSlider'),
				'20' => __('19x', 'LayerSlider'),
				'21' => __('20x', 'LayerSlider')
			]
		],

		'loopWait' => [
			'value' => 0,
			'name' => __('Wait', 'LayerSlider'),
			'keys' => 'looprepeatdelay',
			'attrs' => [ 'min' => 0, 'step' => 100 ]
		],

		'loopYoyo' => [
			'value' => false,
			'name' => __('Yoyo', 'LayerSlider'),
			'keys' => 'loopyoyo'
		],

		'loopPerspective' => [
			'value' => '500',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'looptransformperspective'
		],

		'loopFilter' => [
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'loopfilter'
		],





		// HOVER

		'hover' => [
			'value' => false,
			'keys' => 'hover'
		],


		'hoverOffsetX' => [
			'value' => 0,
			'name' => __('OffsetX', 'LayerSlider'),
			'keys' => 'hoveroffsetx',
			'attrs' => ['type' => 'text']
		],

		'hoverOffsetY' => [
			'value' => 0,
			'name' => __('OffsetY', 'LayerSlider'),
			'keys' => 'hoveroffsety',
			'attrs' => ['type' => 'text']
		],

		'hoverInDuration' => [
			'value' => 500,
			'name' => __('Duration', 'LayerSlider'),
			'keys' => 'hoverdurationin',
			'attrs' => [ 'min' => 0, 'step' => 100 ]
		],

		'hoverOutDuration' => [
			'value' => '',
			'name' => __('Reverse Duration', 'LayerSlider'),
			'keys' => 'hoverdurationout',
			'attrs' => [ 'min' => 0, 'step' => 100, 'placeholder' => __('same', 'LayerSlider') ]
		],

		'hoverInEasing' => [
			'value' => 'easeInOutQuint',
			'name' => __('Easing', 'LayerSlider'),
			'keys' => 'hovereasingin'
		],

		'hoverOutEasing' => [
			'value' => '',
			'name' => __('Reverse Easing', 'LayerSlider'),
			'keys' => 'hovereasingout',
			'attrs' => [ 'placeholder' => __('same', 'LayerSlider') ]
		],

		'hoverOpacity' => [
			'value' => '',
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'hoveropacity',
			'attrs' => [
				'min' => 0,
				'max' => 1,
				'step' => 0.1
			]
		],

		'hoverRotate' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'hoverrotate',
			'attrs' => ['type' => 'text']
		],

		'hoverRotateX' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys' => 'hoverrotatex',
			'attrs' => ['type' => 'text']
		],

		'hoverRotateY' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys' => 'hoverrotatey',
			'attrs' => ['type' => 'text']
		],

		'hoverSkewX' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'hoverskewx',
			'attrs' => ['type' => 'text']
		],

		'hoverSkewY' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'hoverskewy',
			'attrs' => ['type' => 'text']
		],

		'hoverScaleX' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'hoverscalex',
			'attrs' => ['type' => 'text']
		],

		'hoverScaleY' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'hoverscaley',
			'attrs' => ['type' => 'text']
		],

		'hoverTransformOrigin' => [
			'value' => '50% 50% 0',
      		'attrs' => [ 'placeholder' => __('inherit', 'LayerSlider') ],
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'hovertransformorigin'
		],

		'hoverBGColor' => [
			'value' => '',
			'name' => __('Background', 'LayerSlider'),
			'keys' => 'hoverbgcolor'
		],

		'hoverColor' => [
			'value' => '',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'hovercolor'
		],

		'hoverBorderRadius' => [
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'hoverborderradius'
		],

		'hoverTransformPerspective' => [
			'value' => 500,
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'hovertransformperspective'
		],

		'hoverTopOn' => [
			'value' => true,
			'name' => __('Always On Top', 'LayerSlider'),
			'keys' => 'hoveralwaysontop'
		],





		// Parallax
		'parallax' => [
			'value' => false,
			'keys' => 'parallax'
		],

		'parallaxLevel' => [
			'value' => 10,
			'name' => __('Parallax Level', 'LayerSlider'),
			'keys' => 'parallaxlevel',
			'props' => [
				'output' => true
			]
		],

		'parallaxType' => [
			'value' => 'inherit',
			'name' => __('Type', 'LayerSlider'),
			'keys' => 'parallaxtype',
			'options' => [
				'inherit' => __('Inherit', 'LayerSlider'),
				'2d' => __('2D', 'LayerSlider'),
				'3d' => __('3D', 'LayerSlider')
 			]
		],

		'parallaxEvent' => [
			'value' => 'inherit',
			'name' => __('Event', 'LayerSlider'),
			'keys' => 'parallaxevent',
			'options' => [
				'inherit' => __('Inherit', 'LayerSlider'),
				'cursor' => __('Cursor or Tilt', 'LayerSlider'),
				'scroll' => __('Scroll', 'LayerSlider')
 			]
		],

		'parallaxAxis' => [
			'value' => 'inherit',
			'name' => __('Axes', 'LayerSlider'),
			'keys' => 'parallaxaxis',
			'options' => [
				'inherit' => __('Inherit', 'LayerSlider'),
				'none' => __('None', 'LayerSlider'),
				'both' => __('Both', 'LayerSlider'),
				'x' => __('Horizontal only', 'LayerSlider'),
				'y' => __('Vertical only', 'LayerSlider')
			]
		],


		'parallaxTransformOrigin' => [
			'value' => '',
			'name' => __('Transform Origin', 'LayerSlider'),
			'keys' => 'parallaxtransformorigin',
			'attrs' => [
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],

		'parallaxDurationMove' => [
			'value' => '',
			'name' => __('Move Duration', 'LayerSlider'),
			'keys' => 'parallaxdurationmove',
			'attrs' => [
				'type' => 'number',
				'step' => 100,
				'min' => 0,
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],

		'parallaxDurationLeave' => [
			'value' => '',
			'name' => __('Leave Duration', 'LayerSlider'),
			'keys' => 'parallaxdurationleave',
			'attrs' => [
				'type' => 'number',
				'step' => 100,
				'min' => 0,
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],

		'parallaxRotate' => [
			'value' => '',
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'parallaxrotate',
			'attrs' => [
				'type' => 'number',
				'step' => 1,
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],

		'parallaxDistance' => [
			'value' => '',
			'name' => __('Distance', 'LayerSlider'),
			'keys' => 'parallaxdistance',
			'attrs' => [
				'type' => 'number',
				'step' => 1,
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],

		'parallaxPerspective' => [
			'value' => '',
			'name' => __('Perspective', 'LayerSlider'),
			'keys' => 'parallaxtransformperspective',
			'attrs' => [
				'type' => 'number',
				'step' => 100,
				'placeholder' => __('Inherit', 'LayerSlider')
			]
		],


		// TRANSITON MISC
		'transitionStatic' => [
			'value' => 'none',
			'name' => __('Keep This Layer Visible', 'LayerSlider'),
			'keys' => 'static',
			'options' => [
				'none' => __('Until the end of this slide (default)', 'LayerSlider'),
				'forever' => __('Forever (the layer will never animate out)', 'LayerSlider')
			]
		],

		'transitionKeyframe' => [
			'value' => false,
			'name' => __('Play By Scroll Keyframe', 'LayerSlider'),
			'keys' => 'keyframe'
		],


		// Attributes


		'linkURL' => [
			'value' => '',
			'name' => __('Enter URL', 'LayerSlider'),
			'keys' => 'url',
			'props' => [
				'meta' => true
			]
		],

		'linkId' => [
			'value' => '',
			'keys' => 'linkId',
			'props' => [ 'meta' => true ]
		],

		'linkName' => [
			'value' => '',
			'keys' => 'linkName',
			'props' => [ 'meta' => true ]
		],

		'linkType' => [
			'value' => '',
			'keys' => 'linkType',
			'props' => [ 'meta' => true ]
		],


		'linkTarget' => [
			'value' => '_self',
			'name' => __('URL target', 'LayerSlider'),
			'keys' => 'target',
			'options' => [
				'_self' => __('Open on the same page', 'LayerSlider'),
				'_blank' => __('Open on new page', 'LayerSlider'),
				'_parent' => __('Open in parent frame', 'LayerSlider'),
				'_top' => __('Open in main frame', 'LayerSlider')
			],
			'props' => [
				'meta' => true
			]
		],

		'innerAttributes' => [
			'value' => '',
			'name' => __('Custom Attributes', 'LayerSlider'),
			'keys' => 'innerAttributes',
			'desc' => __('Your list of custom attributes. Use this feature if your needs are not covered by the common attributes above or you want to override them. You can use data-* as well as regular attribute names. Empty attributes (without value) are also allowed. For example, to make a FancyBox gallery, you may enter “data-fancybox-group” and “gallery1” for the attribute name and value, respectively.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],

		'outerAttributes' => [
			'value' => '',
			'name' => __('Custom Attributes', 'LayerSlider'),
			'keys' => 'outerAttributes',
			'desc' => __('Your list of custom attributes. Use this feature if your needs are not covered by the common attributes above or you want to override them. You can use data-* as well as regular attribute names. Empty attributes (without value) are also allowed. For example, to make a FancyBox gallery, you may enter “data-fancybox-group” and “gallery1” for the attribute name and value, respectively.', 'LayerSlider'),
			'props' => [
				'meta' => true
			]
		],

		// Styles

		'width' => [
			'value' => '',
			'name' => __('Width', 'LayerSlider'),
			'keys' => 'width',
			'props' => [
				'meta' => true
			]
		],

		'height' => [
			'value' => '',
			'name' => __('Height', 'LayerSlider'),
			'keys' => 'height',
			'props' => [
				'meta' => true
			]
		],

		'top' => [
			'value' => '',
			'name' => __('Top', 'LayerSlider'),
			'keys' => 'top',
			'props' => [
				'meta' => true
			]
		],

		'left' => [
			'value' => '',
			'name' => __('Left', 'LayerSlider'),
			'keys' => 'left',
			'props' => [
				'meta' => true
			]
		],

		'paddingTop' => [
			'value' => '',
			'name' => __('Padding Top', 'LayerSlider'),
			'keys' => 'padding-top',
			'props' => [
				'meta' => true
			]
		],

		'paddingRight' => [
			'value' => '',
			'name' => __('Padding Right', 'LayerSlider'),
			'keys' => 'padding-right',
			'props' => [
				'meta' => true
			]
		],

		'paddingBottom' => [
			'value' => '',
			'name' => __('Padding Bottom', 'LayerSlider'),
			'keys' => 'padding-bottom',
			'props' => [
				'meta' => true
			]
		],

		'paddingLeft' => [
			'value' => '',
			'name' => __('Padding Left', 'LayerSlider'),
			'keys' => 'padding-left',
			'props' => [
				'meta' => true
			]
		],

		'borderWidth' => [
			'value' => '',
			'name' => __('Border Width', 'LayerSlider'),
			'keys' => 'border-width',
			'props' => [
				'meta' => true
			]
		],

		'borderStyle' => [
			'value' => 'solid',
			'name' => __('Border Style', 'LayerSlider'),
			'keys' => 'border-style',
			'props' => [
				'meta' => true
			],
			'options' => [
				'none' => __('None', 'LayerSlider'),
				'hidden' => __('Hidden', 'LayerSlider'),
				'dotted' => __('Dotted', 'LayerSlider'),
				'dashed' => __('Dashed', 'LayerSlider'),
				'solid' => __('Solid', 'LayerSlider'),
				'double' => __('Double', 'LayerSlider'),
				'groove' => __('Groove', 'LayerSlider'),
				'ridge' => __('Ridge', 'LayerSlider'),
				'inset' => __('Inset', 'LayerSlider'),
				'outset' => __('Outset', 'LayerSlider')

			]
		],

		'borderColor' => [
			'value' => '#000',
			'name' => __('Border Color', 'LayerSlider'),
			'keys' => 'border-color',
			'props' => [
				'meta' => true
			]
		],

		'boxShadow' => [
			'value' => '',
			'name' => __('Box Shadow', 'LayerSlider'),
			'keys' => 'box-shadow',
			'props' => [
				'meta' => true
			]
		],

		'textShadow' => [
			'value' => '',
			'name' => __('Text Shadow', 'LayerSlider'),
			'keys' => 'text-shadow',
			'props' => [
				'meta' => true
			]
		],

		'fontFamily' => [
			'value' => '',
			'name' => __('Font Family', 'LayerSlider'),
			'keys' => 'font-family',
		],

		'fontSize' => [
			'value' => 36,
			'name' => __('Font Size', 'LayerSlider'),
			'keys' => 'font-size',
			'attrs' => ['type' => 'number'],
			'props' => [
				'meta' => true
			]
		],

		'lineHeight' => [
			'value' => '',
			'name' => __('Line height', 'LayerSlider'),
			'keys' => 'line-height',
			'attrs' => ['type' => 'number'],
			'props' => [
				'meta' => true
			]
		],

		'fontWeight' => [
			'value' => 400,
			'name' => __('Font Weight', 'LayerSlider'),
			'keys' => 'font-weight',
			'attrs' => [
				'min' => 100,
				'max' => 900,
				'step' => 100
			],
			'props' => [
				'meta' => true
			]
		],

		'fontStyle' => [
			'value' => 'normal',
			'name' => __('Font Style', 'LayerSlider'),
			'keys' => 'font-style',
			'props' => [
				'meta' => true
			]
		],

		'textDecoration' => [
			'value' => 'none',
			'name' => __('Text Decoration', 'LayerSlider'),
			'keys' => 'text-decoration',
			'props' => [
				'meta' => true
			]
		],

		'textTransform' => [
			'value' => 'none',
			'name' => __('Text Transform', 'LayerSlider'),
			'keys' => 'text-transform',
			'props' => [
				'meta' => true
			]
		],

		'letterSpacing' => [
			'value' => 0,
			'name' => __('Letter Spacing', 'LayerSlider'),
			'keys' => 'letter-spacing',
			'attrs' => [
				'type' 	=> 'number',
				'min' 	=> -10,
				'max' 	=> 30,
				'step' 	=> 0.5
			],
			'props' => [
				'meta' => true
			]
		],

		'textAlign' => [
			'value' => 'left',
			'name' => __('Text Align', 'LayerSlider'),
			'keys' => 'text-align',
			'props' => [
				'meta' => true
			]
		],

		'opacity' => [
			'value' => 1,
			'name' => __('Opacity', 'LayerSlider'),
			'keys' => 'opacity',
			'attrs' => [
				'min' => 0,
				'max' => 1,
				'step' => 0.05
			],
			'props' => [
				'meta' => true
			]
		],

		'minFontSize' => [
			'value' => '',
			'name' => __('Min. Font Size', 'LayerSlider'),
			'keys' => 'minfontsize',
			'attrs' => [
				'min' => 0,
				'max' => 150
			]
		],

		'minMobileFontSize' => [
			'value' => '',
			'name' => __('Min. Mobile Font Size', 'LayerSlider'),
			'keys' => 'minmobilefontsize',
			'attrs' => [
				'min' => 0,
				'max' => 150
			]
		],



		'color' => [
			'value' => '#000',
			'name' => __('Color', 'LayerSlider'),
			'keys' => 'color',
			'props' => [
				'meta' => true
			]
		],

		'background' => [
			'value' => '',
			'keys' => 'layerBackground',
			'props' => [ 'meta' => true ]
		],

		'backgroundId' => [
			'value' => '',
			'keys' => 'layerBackgroundId',
			'props' => [ 'meta' => true ]
		],

		'backgroundColor' => [
			'value' => '',
			'name' => __('Background Color', 'LayerSlider'),
			'keys' => 'background-color',
			'props' => [
				'meta' => true
			]
		],

		'backgroundSize' => [
			'value' => '',
			'name' => __('Background Size', 'LayerSlider'),
			'keys' => 'background-size',
			'options' => [
				'' => __('Inherit', 'LayerSlider'),
				'auto' => __('Auto', 'LayerSlider'),
				'cover' => __('Cover', 'LayerSlider'),
				'contain' => __('Contain', 'LayerSlider'),
				'100% 100%' => __('Stretch', 'LayerSlider')
			]
		],

		'backgroundPosition' => [
			'value' => '0% 0%',
			'name' => __('Background Position', 'LayerSlider'),
			'keys' => 'background-position',
			'options' => [
				'0% 0%' => __('left top', 'LayerSlider'),
				'0% 50%' => __('left center', 'LayerSlider'),
				'0% 100%' => __('left bottom', 'LayerSlider'),
				'50% 0%' => __('center top', 'LayerSlider'),
				'50% 50%' => __('center center', 'LayerSlider'),
				'50% 100%' => __('center bottom', 'LayerSlider'),
				'100% 0%' => __('right top', 'LayerSlider'),
				'100% 50%' => __('right center', 'LayerSlider'),
				'100% 100%' => __('right bottom', 'LayerSlider')
			]
		],

		'backgroundRepeat' => [
			'value' => 'no-repeat',
			'name' => __('Background Repeat', 'LayerSlider'),
			'keys' => 'background-repeat',
			'options' => [
				'no-repeat' => __('No repeat', 'LayerSlider'),
				'repeat' => __('Repeat', 'LayerSlider'),
				'repeat-x' => __('Repeat horizontally', 'LayerSlider'),
				'repeat-y' => __('Repeat vertically', 'LayerSlider'),
				'space' => __('Space', 'LayerSlider'),
				'round' => __('Round', 'LayerSlider')
			]
		],

		'borderRadius' => [
			'value' => '',
			'name' => __('Rounded Corners', 'LayerSlider'),
			'keys' => 'border-radius',
			'props' => [
				'meta' => true
			]
		],

		'wordWrap' => [
			'value' => false,
			'name' => 'Word Wrap',
			'keys' => 'wordwrap',
			'props' => [
				'meta' => true
			]
		],

		'style' => [
			'value' => '',
			'name' => __('Custom Styles', 'LayerSlider'),
			'keys' => 'style',
			'props' => [
				'meta' => true
			]
		],

		'styles' => [
			'value' => '',
			'keys' => 'styles',
			'props' => [
				'meta' => true,
				'raw' => true
			]
		],

		'transformOrigin' => [
			'value' => '50% 50% 0',
			'keys' => 'transformOrigin'
		],

		'rotate' => [
			'value' => 0,
			'name' => __('Rotation', 'LayerSlider'),
			'keys' => 'rotation'
		],

		'rotateX' => [
			'value' => 0,
			'name' => __('RotationX', 'LayerSlider'),
			'keys' => 'rotationX'
		],

		'rotateY' => [
			'value' => 0,
			'name' => __('RotationY', 'LayerSlider'),
			'keys' => 'rotationY'
		],

		'scaleX' => [
			'value' => 1,
			'name' => __('ScaleX', 'LayerSlider'),
			'keys' => 'scaleX',
			'attrs' => [
				'step' => '0.1'
			]
		],

		'scaleY' => [
			'value' => 1,
			'name' => __('ScaleY', 'LayerSlider'),
			'keys' => 'scaleY',
			'attrs' => [
				'step' => '0.1'
			]
		],

		'skewX' => [
			'value' => 0,
			'name' => __('SkewX', 'LayerSlider'),
			'keys' => 'skewX'
		],

		'skewY' => [
			'value' => 0,
			'name' => __('SkewY', 'LayerSlider'),
			'keys' => 'skewY'
		],

		'position' => [
			'value' => '',
			'name' => __('Align Positions From', 'LayerSlider'),
			'keys' => 'position',
			'options' => [
				'' => __('Sides of the project', 'LayerSlider'),
				'fixed' => __('Sides of the screen', 'LayerSlider')
			]
		],

		'zIndex' => [
			'value' => '',
			'name' => __('Stacking Order', 'LayerSlider'),
			'keys' => 'z-index',
			'attrs' => [
				'type' => 'number',
				'min' => 1,
				'placeholder' => __('auto', 'LayerSlider')
			]
		],

		'cursor' => [
			'value' => '',
			'name' => __('Mouse Cursor', 'LayerSlider'),
			'keys' => 'cursor',
			'options' => [
				'auto' => __('Auto', 'LayerSlider'),
				'default' => __('Default', 'LayerSlider'),
				'pointer' => __('Pointer', 'LayerSlider'),
				'help' => __('Help', 'LayerSlider'),
				'text' => __('Text', 'LayerSlider'),
				'vertical-text' => __('Vertical text', 'LayerSlider'),
				'zoom-in' => __('Zoom in', 'LayerSlider'),
				'zoom-out' => __('Zoom out', 'LayerSlider')
			]
		],


		'pointerEvents' => [
			'value' => false,
			'name' => __('Prevent Mouse Events', 'LayerSlider'),
			'keys' => 'pointerEvents'
		],


		'blendMode' => [
			'value' => 'unset',
			'name' => __('Blend Mode', 'LayerSlider'),
			'keys' => 'mix-blend-mode',
			'options' => [
				'unset' => __('Default', 'LayerSlider'),
				'normal' => 'Normal',
				'multiply' => 'Multiply',
				'screen' => 'Screen',
				'overlay' => 'Overlay',
				'darken' => 'Darken',
				'lighten' => 'Lighten',
				'color-dodge' => 'Color-dodge',
				'color-burn' => 'Color-burn',
				'hard-light' => 'Hard-light',
				'soft-light' => 'Soft-light',
				'difference' => 'Difference',
				'exclusion' => 'Exclusion',
				'hue' => 'Hue',
				'saturation' => 'Saturation',
				'color' => 'Color',
				'luminosity' => 'Luminosity'
			]
		],

		'filter' => [
			'value' => '',
			'name' => __('Filter', 'LayerSlider'),
			'keys' => 'filter'
		],



		// Attributes

		'ID' => [
			'value' => '',
			'name' => __('ID', 'LayerSlider'),
			'keys' => 'id',
			'props' => [
				'meta' => true
			]
		],

		'class' => [
			'value' => '',
			'name' => __('Classes', 'LayerSlider'),
			'keys' => 'class',
			'props' => [
				'meta' => true
			]
		],

		'title' => [
			'value' => '',
			'name' => __('Title', 'LayerSlider'),
			'keys' => 'title',
			'props' => [
				'meta' => true
			]
		],

		'alt' => [
			'value' => '',
			'name' => __('Alt', 'LayerSlider'),
			'keys' => 'alt',
			'props' => [
				'meta' => true
			]
		],

		'rel' => [
			'value' => '',
			'name' => __('Rel', 'LayerSlider'),
			'keys' => 'rel',
			'props' => [
				'meta' => true
			]
		]

	],

	'easings' => [
		'linear',
		'swing',
		'easeInQuad',
		'easeOutQuad',
		'easeInOutQuad',
		'easeInCubic',
		'easeOutCubic',
		'easeInOutCubic',
		'easeInQuart',
		'easeOutQuart',
		'easeInOutQuart',
		'easeInQuint',
		'easeOutQuint',
		'easeInOutQuint',
		'easeInSine',
		'easeOutSine',
		'easeInOutSine',
		'easeInExpo',
		'easeOutExpo',
		'easeInOutExpo',
		'easeInCirc',
		'easeOutCirc',
		'easeInOutCirc',
		'easeInElastic',
		'easeOutElastic',
		'easeInOutElastic',
		'easeInBack',
		'easeOutBack',
		'easeInOutBack',
		'easeInBounce',
		'easeOutBounce',
		'easeInOutBounce'
	]
];
