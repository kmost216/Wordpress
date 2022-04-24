if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function (searchElement /*, fromIndex */ ) {
		"use strict";
		if (this === null) {
			throw new TypeError();
		}
		var t = Object(this);
		var len = t.length >>> 0;
		if (len === 0) {
			return -1;
		}
		var n = 0;
		if (arguments.length > 1) {
			n = Number(arguments[1]);
			if (n != n) { // shortcut for verifying if it's NaN
				n = 0;
			} else if (n != 0 && n != Infinity && n != -Infinity) {
				n = (n > 0 || -1) * Math.floor(Math.abs(n));
			}
		}
		if (n >= len) {
			return -1;
		}
		var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
		for (; k < len; k++) {
			if (k in t && t[k] === searchElement) {
				return k;
			}
		}
		return -1;
	};
}

Array.prototype.fill = function(value, length){
	while(length--){
		this[length] = value;
	}
	return this;
};

Storage.prototype.setObject = function(key, value) {
	this.setItem(key, JSON.stringify(value));
};

Storage.prototype.getObject = function(key) {
	var value = this.getItem(key);
	return value && JSON.parse(value);
};




function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function ucFirst(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}



(function( $ ) {
	$.fn.appendToWithIndex = function(to, index) {

		if( !( to instanceof jQuery ) ) { to = $(to); }

		if(index == 0) {
			this.prependTo(to);
		} else {
			this.insertAfter( to.children(':eq('+(index-1)+')') );
		}

		return this;
	};
})( jQuery );


var LS_ContextMenu = {

	open: function( event, contextMenuProperties ) {

		contextMenuProperties = contextMenuProperties || {};

		// Prevent showing OS native contextmenu
		event.preventDefault();
		event.stopPropagation();

		// Close any other open contextmenu
		LS_ContextMenu.close( contextMenuProperties );

		// Mouse position
		var mt = event.pageY;
			ml = event.pageX;

		// Attempt to find the contextmenu instance.
		var $contextMenu = jQuery( contextMenuProperties.selector );

		// Create new contextmenu instance if it wasn't
		// added to the document previously.
		if( ! $contextMenu.length ) {
			$contextMenu = jQuery( jQuery( contextMenuProperties.template ).text() ).prependTo('body');
		}

		if( contextMenuProperties.width ) {
			$contextMenu.css('width', contextMenuProperties.width );
		}

		// Handle right edges
		var contextMenuWidth 	= $contextMenu.width(),
			windowWidth 		= jQuery( window ).width(),
			overflowWidth 		= windowWidth - ( ml + contextMenuWidth );

		// Handle screen sides
		if( overflowWidth > 0 ) {
			$contextMenu.removeClass('ls-context-left-subs');
			$contextMenu.css({ top: mt, left: ml + 3 })
		} else {

			if( event.alignRight ) {
				mt = event.alignRight.pageY || mt;
				ml = event.alignRight.pageX || ml;
			}

			$contextMenu.addClass('ls-context-left-subs');
			$contextMenu.css({ top: mt, left: 'auto', right: windowWidth - ml })
		}

		if( contextMenuProperties.onBeforeOpen ) {
			contextMenuProperties.onBeforeOpen( $contextMenu );
		}

		// Set contextmenu position and display it
		$contextMenu.addClass('ls-context-menu-opened');

		if( contextMenuProperties.onOpen ) {
			contextMenuProperties.onOpen( $contextMenu );
		}

		// Close event
		setTimeout( function() {
			jQuery('body').off('click.ls-context-menu').on('click.ls-context-menu', function() {
				LS_ContextMenu.close( contextMenuProperties );
			});
		}, event.manualOpen ? 100 : 0 );
	},

	close: function( contextMenuProperties ) {

		if( contextMenuProperties && contextMenuProperties.onClose ) {
			contextMenuProperties.onClose();
		}

		jQuery('body').off('click.ls-context-menu');
		jQuery('.ls-context-menu').removeClass('ls-context-menu-opened');
	}
};


var LS_CodeMirror = {

	init : function(settings) {

		var defaults = {
			mode: 'css',
			theme: 'solarized',
			lineNumbers: true,
			lineWrapping: true,
			autofocus: true,
			indentUnit: 4,
			indentWithTabs: true,
			foldGutter: true,
			gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
			styleActiveLine: true,
			extraKeys: {
				"Ctrl-Q": function(cm) {
					cm.foldCode(cm.getCursor());
				}
			}
		};


		jQuery('.ls-codemirror').each(function() {

			var options = jQuery.extend(true, {}, defaults, settings || {});

			if( jQuery(this).prop('readonly') ) {
				options.readOnly = true;
				options.theme += ' readonly';
			}

			var cm = CodeMirror.fromTextArea(this, options);

			cm.on('change', function( cm ) {

				cm.save();
				jQuery( cm.getTextArea() ).trigger('updated.ls', cm);
			});


			if( jQuery(this).closest('#lse-callback-events').length ) {

				cm.on('beforeChange',function( cm, change ) {

					// Select all
					if( change.from.line === 0 && change.to.line === cm.lastLine() ) {

						cm.setSelection({ line: 1, ch: 0 }, { line: cm.lastLine()-1, ch: 99999 });
						cm.replaceSelection( change.text[0] );
						change.cancel();

					} else {

						if( change.from.line === 0) {
							change.from.line = 1;

							if( change.origin === '+delete') {
								change.cancel();
							}
						}

						if( change.to.line === cm.lastLine() ) {
							change.to.line = cm.lastLine()-1;

							if( change.origin === '+delete') {
								change.cancel();
							}
						}
					}

					jQuery( cm.getTextArea() ).trigger('updated.ls', cm);
				});
			}
		});
	}
};



jQuery(function($) {

	// Status messages
	if( typeof LS_statusMessage !== 'undefined' ) {
		kmUI.notify.show( LS_statusMessage );
	}

	$( document ).on('click', '.ls-install-plugin-update', function( event ) {

		event.preventDefault();

		if( LS_slidersMeta.isActivatedSite ) {

			try {
				lsInstallPluginUpdate();

			} catch ( error ) {

				if( $( this ).attr('href') ) {
					window.location.href = $( this ).attr('href');
				}
			}

		} else {

			lsDisplayActivationWindow();
		}
	});

	var lsUpdateIconClicked = 0;
	$( document ).on('click', '#ls-plugin-update-success-modal .ls-checkmark-holder', function() {


		var $this 		= $( this ),
			$wrapper 	= $this.parent(),
			$container 	= $this.closest('.kmw-modal-container'),
			rotations 	= [ -10,  20, -30,  15,  -5,   5 ],
			scales 		= [ 1.6, 1.3, 1.1, 1.8, 1.6, 1.4 ],
			rotation 	= rotations[ lsUpdateIconClicked % rotations.length ],
			scale 		= scales[ lsUpdateIconClicked % scales.length ];


		$this.css('transform', 'scale('+scale+') rotate('+rotation+'deg)');

		lsUpdateIconClicked++;

		if( lsUpdateIconClicked > 12  ) {

			lsUpdateIconClicked = 0;

			lsAddUpdateEasterEggExplosion();
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 200 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 400 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 600 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 800 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 1000 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 1200 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 1400 );
			setTimeout( function() { lsAddUpdateEasterEggExplosion(); }, 1600 );




			setTimeout( function() {
				kmw.modal.close();
				lsDisplayUpdateEasterEgg();

			}, 1600 );

		} else if( lsUpdateIconClicked > 6 ) {
			$container.css('animation', 'ls-shake 500ms infinite');

		} else if( lsUpdateIconClicked > 4 ) {
			$wrapper.addClass('ls-animate').css('animation-iteration-count', 'infinite');

		} else if( lsUpdateIconClicked > 2 ) {
			$wrapper.removeClass('ls-animate');
			setTimeout( function() {
				$wrapper.addClass('ls-animate');
			}, 100);
		}
	});

	$('.ls-pagination-limit select').on('change', function() {

		var data = {
			action: 'ls_save_pagination_limit',
			limit: jQuery( this ).val()
		};

		$.post( ajaxurl, data, function() {
			document.location.href = LS_l10n.adminURL+'?page=layerslider';
		});
	});

	var lsSlideUnder = {

		init : function(){

			$(document).on('click', '[data-ls-su]', function() {
				//if( $(this).parent().find('.ls-su').length == 0 ){
					lsSlideUnder.open($(this));
				//}
			});
		},

		create : function($el){

			// lsSlideUnder container is positioned absolute so we need a relative or absolute position parent element

			if( $el.parent().css('position') == 'static' ){
				$el.parent().css('position','relative');
			}

			if( $el.css('position') == 'static' ){
				$el.css('position','relative');
			}

			// Creating lsSlideUnder HTML markup

			var $su = $('<div>'),
				$sui = $('<div>'),
				$suc = $('<div>');

			$su.addClass('ls-su');
			$sui.addClass('ls-su-inner');
			$suc.addClass('ls-su-content');

			// Appending into the parent of the opener element

			$el.parent().prepend( $su
					.append( $sui
				.append( $suc
					)
				)
			);

			// Copying some CSS properties from the opener element

			var suiProps = [
				'borderRightStyle',
				'borderRightWidth',
				'borderRightColor',
				'borderLeftStyle',
				'borderLeftWidth',
				'borderLeftColor',
				'borderBottomStyle',
				'borderBottomWidth',
				'borderBottomColor',
				'backgroundColor'
			];

			for(i=0;i<suiProps.length;i++){
				$sui.css( suiProps[i], $el.css(suiProps[i]) );
			}

			$suc.css({
				'paddingTop' : $el.css('paddingLeft'),
				'paddingLeft' : $el.css('paddingLeft'),
				'paddingBottom' : $el.css('paddingLeft'),
				'paddingRight' : $el.css('paddingRight')
			});

			// Sizing and positioning

			$su.css({
				left: $el.position().left + parseInt( $el.css('marginLeft') ),
				top: $el.position().top + parseInt( $el.css('marginTop') ) + $el.outerHeight(),
				width: $el.width() + parseInt( $el.css('paddingLeft') ) + parseInt( $el.css('paddingRight') ) + parseInt( $el.css('borderLeftWidth')) + parseInt( $el.css('borderRightWidth'))
			});

			// Inserting data to content

			$suc.append( $el.siblings('.ls-su-data').html() );
		},

		open : function( $el ){

			if( !$el.parent().find( '.ls-su' ).length ){
				lsSlideUnder.create( $el );
			}

			$su = $el.parent().find( '.ls-su' );
			$sui = $el.parent().find( '.ls-su-inner' );

			if( $su.hasClass( 'ls-su-opened') ){
				return;
			}

			$su.addClass( 'ls-su-opened' );

			TweenLite.set( $su.parent()[0], {
					z:100
			});

			TweenLite.set( $su[0],
				{
					opacity: .7,
					height: 'auto',
					transformOrigin: 'center top',
					rotationX: 90,
					transformPerspective: 500
				}
			);

			TweenLite.set( $sui[0],
				{
					top: 0
				}
			);

			TweenLite.to(
				$su[0],
				2,
				{
					opacity: 1,
					rotationX: 0,
					ease: 'Elastic.easeOut'
				}
			);

			// Creating close function

			$(document).one( 'click', function(e){
				lsSlideUnder.close($su, $sui);
			});
		},

		close : function($su, $sui){

			TweenLite.to(
				$sui[0],
				.3,
				{
					top: -$sui.outerHeight(),
					ease: 'Quart.easeIn'
				}
			);

			TweenLite.to(
				$su[0],
				.3,
				{
					opacity: .7,
					height: 0,
					ease: 'Quart.easeIn',
					onComplete : function(){
						$su.removeClass( 'ls-su-opened' );
					}
				}
			);
		}
	};

	lsSlideUnder.init();

	if( window.kmUI ) {
		kmUI.popover.init();
	}

	// CodeMirror
	if(document.location.href.indexOf('&action=edit') === -1) {
		LS_CodeMirror.init();
	}


	// Skin/CSS Editor
	if( document.location.href.indexOf('section=skin-editor') !== -1 ) {
		$('select[name="skin"]').change(function() {
			document.location.href = LS_l10n.adminURL+'?page=layerslider&section=skin-editor&skin=' + $(this).children(':selected').val();
		});
	}


	if( navigator.platform.indexOf('Mac') !== -1 ) {
		$('body').addClass('ls-platform-mac');
	}

});


var lsDisplayActivationWindow = function( windowProperties ) {

	var deafultProperties = {
		into: 'body',
		title: LS_l10n.activationFeature,
		content: '#tmpl-activation',
		minHeight: 740,
		maxHeight: 740
	};

	windowProperties = jQuery.extend( true, deafultProperties, windowProperties );

	kmw.modal.open({
		uid: 'activation-window',
		into: windowProperties.into,
		title: windowProperties.title,
		content: windowProperties.content,
		minWidth: 880,
		maxWidth: 880,
		minHeight: windowProperties.minHeight,
		maxHeight: windowProperties.maxHeight,
		zIndex: 9999999,

		modalClasses: 'lse-activation-modal-window',

		overlaySettings: {
			animationIn: 'fade',
			zIndex: 9999999,
		},

		onOpen: function( modal ) {

			jQuery( modal.element ).addClass( 'kmw-modal-visible' );
		}
	});

}

var lsDisplayUpdateEasterEgg = function() {

	for( var c = 0; c < 150; c++ ) {

		setTimeout( function( c ) {
			lsAddUpdateEasterEggIcon( c );
		}, 600*c, c );
	}

	kmw.modal.open({
		maxWidth: 500,
		zIndex: 100200,
		closeButton: false,
		closeOnEscape: false,
		content: '#tmpl-plugin-update-easter-egg-modal',
		animationIn: 'scale',
		overlaySettings: {
			closeOnClick: false,
			animationIn: 'fade',
			zIndex: 100100
		}
	});
};


var lsInstallPluginUpdate = function() {

	wp.updates.maybeRequestFilesystemCredentials();

	kmw.modal.open({
		content: '#tmpl-plugin-update-loading-modal',
		minWidth: 300,
		maxWidth: 300,
		closeButton: false,
		closeOnEscape: false,
		animationIn: 'scale',
		overlaySettings: {
			closeOnClick: false,
			animationIn: 'fade'
		}
	});

	wp.updates.ajax('update-plugin', {
		plugin: LS_ENV.base,
		slug: LS_ENV.slug,
		success: function() {
			kmw.modal.close()
			kmw.modal.open({
				maxWidth: 400,
				zIndex: 100200,
				closeButton: false,
				closeOnEscape: false,
				content: '#tmpl-plugin-update-success-modal',
				animationIn: 'scale',
				overlaySettings: {
					closeOnClick: false,
					animationIn: 'fade',
					zIndex: 100100
				}
			});

		},
		error: function() {
			kmw.modal.close()
			kmw.modal.open({
				maxWidth: 500,
				closeButton: false,
				closeOnEscape: false,
				content: '#tmpl-plugin-update-error-modal',
				animationIn: 'scale',
				overlaySettings: {
					closeOnClick: false,
					animationIn: 'fade'
				}
			});
		}
	});

};

var lsAddUpdateEasterEggExplosion = function() {

	var icons = [
		'check',
		'cat',
		'heart',
		'rocket',
		'hourglass',
		'ufo',
		'station',
		'alien',
		'galaxy'
	];

	var windowWidth 	= jQuery( window ).width() / 1.5,
		windowHeight 	= jQuery( window ).height() / 1.5;

	icons.forEach( function( icon ) {

		var $icon = jQuery( LS_InterfaceIcons.easteregg[ icon ] ).addClass('ls-update-easter-egg-explosion-icon').appendTo('body');

		setTimeout( function( ) {

			var rotate = Math.floor( Math.random() * 90 ) + 1;
				rotate *= Math.floor( Math.random() * 2 ) == 1 ? 1 : -1;

			var translateX = Math.floor( Math.random() * windowWidth ) + 1;
				translateX *= Math.floor( Math.random() * 2 ) == 1 ? 1 : -1;

			var translateY = Math.floor( Math.random() * windowHeight ) + 1;
				translateY *= Math.floor( Math.random() * 2 ) == 1 ? 1 : -1;

			var duration = 600 + Math.floor( Math.random() * 400 );

			$icon.css({
				'transition': 'transform '+duration+'ms, opacity 200ms',
				'transform': 'translate('+translateX+'px, '+translateY+'px) rotate('+rotate+'deg)'
			});

			setTimeout( function() {
				$icon.css('opacity', 0 );

				setTimeout( function() {
					$icon.remove();
				}, 200 );
			}, duration + 100 );

		}, 100);
	});

};

var lsAddUpdateEasterEggIcon = function( iteration ) {

	var icons = [
		'check',
		'cat',
		'heart',
		'rocket',
		'hourglass',
		'ufo',
		'station',
		'alien',
		'galaxy'
	];

	var icon = icons[ iteration % icons.length ];

	var $icon = jQuery( LS_InterfaceIcons.easteregg[ icon ] ).addClass('ls-update-easter-egg-icon').appendTo('body');

	var randomRotate 	= Math.floor(Math.random() * 45 ) + 1;
		randomRotate 	*= Math.floor(Math.random() * 2 ) == 1 ? 1 : -1;

	var randomRotateAlt = Math.floor(Math.random() * 360 ) + 1;
		randomRotateAlt *= Math.floor(Math.random() * 2 ) == 1 ? 1 : -1;


	var windowHeight 	= jQuery( document ).height(),
		windowWidth 	= jQuery( window ).width(),
		randomDelay 	= (Math.random() * (0.100 - 20.000) + 20.000).toFixed(3),
		randomScale 	= (Math.random() * (0.400 - 1.300) + 1.800).toFixed(3),
		randomX 		= Math.floor(Math.random() * windowWidth ) + 1;

	TweenLite.set( $icon[0], {
		y: -120,
		x: randomX,
		scale: randomScale,
		rotation: randomRotate,
	});

	TweenLite.to( $icon[0], 30, {
		y: windowHeight,
		rotation: randomRotateAlt
	});
};