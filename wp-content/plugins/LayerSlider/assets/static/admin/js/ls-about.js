jQuery( document ).ready(function( $ ) {

	jQuery('body').addClass('folded');

	jQuery('#collapse-menu').click( function() {
		jQuery( window ).resize();

	});

	$('#ls-welcome-slider').on('slideTimelineDidStart.layerSlider', function( event, slider ) {
		setTimeout(function(){
			TweenMax.to( '#ls--welcome-boxes', 3, {
				y: 0,
				opacity: 1,
				ease: Quint.easeInOut
			});
		},1000);
	});

	jQuery('#ls-welcome-slider, #ls-welcome-slider-bg').layerSlider({
		type: 'fullsize',
		allowFullscreen: false,
		fullSizeMode: 'fitheight',
		startInViewport: false,
		keybNav: false,
		touchNav: false,
		skin: 'noskin',
		navPrevNext: false,
		hoverPrevNext: false,
		navStartStop: false,
		navButtons: false,
		showCircleTimer: false,
		allowRestartOnResize: true,
		useSrcset: false,
		skinsPath: LS_pageMeta.skinsPath
	});

	jQuery('.ls-welcome-box-slider').layerSlider({
		slideOnSwipe: false,
		keybNav: false,
		touchNav: false,
		skin: 'noskin',
		navPrevNext: false,
		hoverPrevNext: false,
		navStartStop: false,
		navButtons: false,
		showCircleTimer: false,
		useSrcset: false,
		skinsPath: LS_pageMeta.skinsPath
	});
});