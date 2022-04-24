(function($) {


	window.lsShowTransition = function( el ) {

		var $el = jQuery( el ),

			// Get transition index
			index = parseInt( $el.data('key') ) - 1,

			// Get transition class
			trclass = $el.closest('.lse-transitions-section').data('tr-type'),
			trtype, trObj;

		// Built-in 3D
		if(trclass == '3d_transitions') {
			trtype = '3d';
			trObj = layerSliderTransitions['t'+trtype+''][index];

		// Built-in 2D
		} else if(trclass == '2d_transitions') {
			trtype = '2d';
			trObj = layerSliderTransitions['t'+trtype+''][index];

		// Custom 3D
		} else if(trclass == 'custom_3d_transitions') {
			trtype = '3d';
			trObj = layerSliderCustomTransitions['t'+trtype+''][index];

		// Custom 3D
		} else if(trclass == 'custom_2d_transitions') {
			trtype = '2d';
			trObj = layerSliderCustomTransitions['t'+trtype+''][index];
		}

		// Parse settings
		let settings = $.extend( true, {}, {
			width: 500,
			height: 250,
			imgPath: '../assets/img/',
			skinPath: '../layerslider/skins/',
			transitionType: '2d',
			transitionObject: null,
			showCircleTimer: false,
			pauseOnHover: false,
			skin: 'noskin',
			slidedelay: 100,
			startInViewport: false
		}, {
			transitionType: trtype,
			transitionObject: trObj,
			imgPath: lsTrImgPath,
			skinsPath: pluginPath+'layerslider/skins/'
		} );

		settings.slideTransition = {
			type: settings.transitionType,
			obj: settings.transitionObject
		};

		let $previewSlider = jQuery( '#lse-slide-transition-sample' );

		// Add slider HTML markup
		jQuery('<lse-b class="lse-transition-preview-slider" style="width: '+settings.width+'px; height: '+settings.height+'px;"> \
				<lse-b class="ls-slide" data-ls="slidedelay: '+settings.delay+';"> \
					<img src="'+settings.imgPath+'sample_slide_1.jpg" class="ls-bg"> \
				</lse-b> \
				<lse-b class="ls-slide" data-ls="slidedelay: '+settings.delay+';"> \
					<img src="'+settings.imgPath+'sample_slide_2.jpg" class="ls-bg"> \
				</lse-b> \
			</lse-b>').appendTo( $previewSlider );

		// Initialize the slider
		$previewSlider.find('.lse-transition-preview-slider').layerSlider( settings );
	};


	window.lsHideTransition = function() {

		// Stop transition
		var $slider = jQuery('#lse-slide-transition-sample' ).find('.lse-transition-preview-slider');
		if( $slider.length ) {
			$slider.layerSlider( 'destroy', true );
		}
	};

})(jQuery);
