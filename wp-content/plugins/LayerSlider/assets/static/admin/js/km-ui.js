/*

KM-UI script

*/

jQuery( function( $ ){

	window.kmUI  = {

		dropdown: {

			instance: null,
			options: {},
			$button: $(),
			$target: $(),

			defaults: {
				placement: 'bottom',
				offsetX: 0,
				offsetY: 0
			},

			init: function() {

				$( document ).on('click', '[data-toggle="dropdown"]', function( event ) {
					event.stopPropagation();
					kmUI.dropdown.show( this );

				}).on('click', '[data-screen]', function( event ) {
					kmUI.dropdown.showScreen( $( $( this ).data('screen') ) );

				}).on('click', '.ls-dropdown-screen-back', function() {
					kmUI.dropdown.hideScreen();
				});
			},


			show: function( button, showProperties ) {

				showProperties = showProperties || {};

				var self = this;

				var $button 	= $( button ),
					target 		= $button.data('target'),
					reference 	= $button.data('reference'),
					$target 	= target ? $( target ) : $button.parent().find('ls-dropdown-panel'),
					$refenrece 	= reference ? $( reference ) : $button,
					options 	= $.extend( {}, self.defaults, $button.data() ),
					$inner 		= $target.find('ls-dropdown-inner'),
					$screen 	= $inner.find('ls-dropdown-screen:first');


				if( ! showProperties.forceOpen ) {
					if( self.$button.is( $button ) ) {
						self.hide();
						return;
					}
				}

				self.hide();
				self.hideScreen();

				self.options = options;
				self.$button = $button;
				self.$target = $target;



				$target.addClass('ls-dropdown-open');
				$inner.height( $screen.height() );

				self.instance = Popper.createPopper( $refenrece[0], $target[0], {
					placement: options.placement,
					modifiers: [
						{
							name: 'offset',
							options: {
								offset: [ options.offsetX, options.offsetY ]
							}
						}
					]
				});

				$( document ).on('click.ls-dropdown-panel', 'body', function( event ) {

					if( kmUI.dropdown.options.stopPropagation ) {

						var $eventTarget = $( event.target );
						if( $eventTarget.is( kmUI.dropdown.$target ) || $eventTarget.closest( kmUI.dropdown.$target ).length ) {
							if( ! $eventTarget.hasClass('ls-dismiss-panel') && ! $eventTarget.closest('.ls-dismiss-panel').length ) {
								return;
							}
						}
					}

					kmUI.dropdown.hide();
				});
			},


			hide: function() {

				this.hideScreen();

				$( document ).off('click.ls-dropdown-panel')
				$('.ls-dropdown-open').removeClass('ls-dropdown-open');

				this.options = {};
				this.$button = $();
				this.$target = $();

				if( this.instance ) {
					this.instance.destroy();
					this.instance = null;
				}
			},

			showScreen: function( $screen ) {

				var $panel = $screen.closest('ls-dropdown-panel'),
					$inner = $panel.find('ls-dropdown-inner');

				$panel.addClass('ls-screen-open');
				$screen.addClass('ls-screen-visible');

				$inner.height( $screen.height() );
			},

			hideScreen: function( ) {

				$('.ls-screen-visible').each( function() {


					var $this 	= $( this ),
						$panel 	= $this.closest('ls-dropdown-panel'),
						$inner 	= $panel.find('ls-dropdown-inner'),
						$screen = $panel.find('ls-dropdown-screen:first');

					$inner.height( $screen.height() );
					$this.removeClass('ls-screen-visible');
					$('ls-dropdown-panel.ls-screen-open').removeClass('ls-screen-open');
				});
			}
		},

		notify: {

			timeout: 0,

			defaults: {
				maxWidth: 500,
				spinner: false,
				icon: 'check',
				iconColor: 'inherit',
				iconSize: null,
				text: '',
				timeout: 0
			},

			show: function( settings ) {

				settings = settings || {};
				settings = $.extend( true, {}, kmUI.notify.defaults, settings );

				var $notification 	= $('.ls-notify-osd'),
					$icon 			= $notification.children('.icon'),
					$text 			= $notification.children('.text');

				if( settings.spinner ) {
					$icon.show().html('<div class="spinner is-active"></div>');

				} else if( settings.icon ) {

					$icon
						.show()
						.css('color', settings.iconColor )
						.html( LS_InterfaceIcons.notifications[ settings.icon ] );

				} else {
					$icon.hide();
				}

				$text.html( settings.text );

				if( settings.iconSize ) {
					// ...
				}

				$notification
					.css('max-width', settings.maxWidth)
					.addClass('ls-visible');

				if( settings.timeout ) {
					clearTimeout( kmUI.notify.timeout );
					kmUI.notify.timeout = setTimeout(function() {
						kmUI.notify.hide();
					}, settings.timeout );
				}
			},

			hide: function() {
				$('.ls-notify-osd').removeClass('ls-visible');
			}
		},

		popover: {

			defaults: {
				width: 100,
				padding: 20,
				durationOpen: 500,
				durationClose: 400,
				theme: 'dark',
				animate: 'flip',
				direction: 'top',
				timeout: 0,
				distance: 0
			},

			init : function() {

				$( document ).on( 'mouseenter.kmUI', '[data-help]:not([data-help-disabled],[data-km-ui-popover-disabled],[data-km-ui-disabled])', function(event) {

					event.stopPropagation();

					var $el = $(this),
						delay = parseInt( $el.data('help-delay') ) || 1000;

					kmUI.popover.timeout = setTimeout( function(){
						kmUI.popover.close();
						kmUI.popover.open( $el );
					}, delay );
				});

				$( document ).on( 'mouseleave.kmUI', '[data-help]', function() {
					clearTimeout(kmUI.popover.timeout);
					kmUI.popover.close();
				});

				$( document ).on( 'click.kmUI', '[data-popover]', function() {
					kmUI.popover.close();
					kmUI.popover.open( this, true );
				});
			},

			destroy : function() {
				kmUI.popover.close();
				$( document ).off( 'mouseenter.kmUI', '[data-help]:not([data-help-disabled],[data-km-ui-popover-disabled],[data-km-ui-disabled])');
				$( document ).off( 'mouseleave.kmUI', '[data-help]');
			},

			open : function( el, po ) {

				if( typeof LS_editorSettings != 'undefined' && ! LS_editorSettings.showTooltips ) {
					return;
				}

				var $el = $(el);

				// Waiting for hiding previous popover
				var delay = 0;

				setTimeout( function(){

					// Create popover
					var $popover = $('<div class="km-ui-popover"><div class="km-ui-popover-inner"></div><span></span></div>').prependTo('body'),
						duration = parseInt( $el.data( 'help-duration') ) || kmUI.popover.defaults.durationOpen,
						distance = parseInt( $el.data( 'km-ui-popover-distance') ) || kmUI.popover.defaults.distance;

					// Get popover
					$popover.data( 'tooltipCaller', $el);

					// Custom class
					if( $el.data('help-class') ) {
						$popover.addClass( $el.data( 'help-class' ) );
					}

					// Custom theme
					if( typeof $el.data( 'km-ui-popover-theme' ) != 'undefined' ){
						$popover.addClass( 'km-ui-theme-' + $el.data( 'km-ui-popover-theme' ) );
					}

					// Set popover text
					if( po ){
						if( typeof $el.data( 'popover' ) != 'undefined' ){
							$popover.addClass( 'km-ui-' + $el.data( 'popover' ) );
						}

						if( typeof $el.data( 'popover-dir') != 'undefined' ){
							$popover.addClass( 'km-ui-popover-direction-' + $el.data( 'popover-dir' ) );
						}

						$popover.find( '.km-ui-popover-inner' ).html( $el.siblings( '.ls-popover-data, .km-ui-popover-data' ).html() );

						$( document ).one( 'click.kmUI', function(){
							kmUI.popover.close();
						});
					}else{
						$popover.find('.km-ui-popover-inner').html( $el.data('help') );
					}

					// Get viewport dimensions
					var v_w = $( window ).width(),

					// Get element dimensions
					e_w = $el.outerWidth(),

					// Get element position
					e_l = $el.offset().left,
					e_t = $el.offset().top,

					// Get tooltip dimensions
					t_w = $popover.outerWidth(),
					t_h = $popover.outerHeight(),

					// Position popover
					top = $popover.hasClass( 'km-ui-direction-btm' ) ? e_t + $el.outerHeight() + 10 : e_t - t_h - 10,
					from = $popover.hasClass( 'km-ui-direction-btm' ) ? -10 : 30;

					if( $el.data( 'help-transition' ) !== false ) {
						TweenLite.set( $popover[0],{
							opacity: 0,
							top: top - distance,
							y: -from,
							left: e_l - (t_w - e_w) / 2,
							transformPerspective: 500,
							transformOrigin: '50% bottom',
							rotationX: 30
						});
						TweenLite.to( $popover[0], duration/1000,{
							opacity: 1,
							rotationX: 0,
							y: 0,
							ease: Back.easeOut
						});
					} else {
						$popover.css({
							top: top - from,
							left: e_l - (t_w - e_w) / 2
						});
					}

					// Fix right position
					if( $popover.offset().left + t_w > v_w ){

						$popover.css({
							left: 'auto',
							right: 10
						});

						$popover.find( 'span' ).css({
							left: 'auto',
							right: v_w - $el.offset().left - $el.outerWidth() / 2 - 17,
							marginLeft: 'auto'
						});
					}

					if( $el.data( 'km-ui-popover-autoclose' ) ){
						setTimeout( function(){
							kmUI.popover.close();
						}, parseInt( $el.data( 'km-ui-popover-autoclose' ) ) * 1000 );
					}
				}, delay);
			},

			close : function() {

				var $item = $( '.km-ui-popover' );

				if( $item.length ) {
					var $caller = $item.data( 'tooltipCaller' ),
						duration = $caller.data( 'help-duration' ) || kmUI.popover.defaults.durationClose,
						playOnlyOnce = $caller.data( 'km-ui-popover-once') || null;

					if( $caller.data( 'help-transition' ) !== false ) {
						$('.km-ui-popover:last').animate({
							opacity : 0
						}, duration / 2, function(){
							$(this).remove();
						});
					} else {
						$('.km-ui-popover:last').remove();
					}

					if( playOnlyOnce ){
						$caller.attr( 'data-km-ui-popover-disabled', 'true' );
					}
				}
			}
		}
	};
});
