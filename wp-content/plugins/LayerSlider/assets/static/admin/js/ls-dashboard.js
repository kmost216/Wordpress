var importModalWindowTimeline = null,
	importModalWindowTransition = null,
	importModalThumbnailsTransition = null,

	draggedSliderItem = null,
	targetSliderItem = null,

	sliderDragGroupingTimeout = null,
	sliderGroupRenameTimeout = null,

	$lastOpenedGroup,

	activeShuffleContainerIndex = 0;


// Stores the lastly selected slider item
// foe which the context menu was opened.
var LS_contextMenuSliderItem;


jQuery(function($) {

	kmUI.dropdown.init();

	$('#ls-list-main-menu ls-button[data-scroll]').on('click', function() {
		scrollToElement( $( this ).data('scroll') );
	});

	// Auto-submit filter/search bar when choosing different view mode
	// from drop-down menus.
	$('#ls-slider-filters').on('change', 'select', function() {
		$(this).closest('#ls-slider-filters').submit();
	});

	$('#ls-plugin-settings-tabs input[name="ls_gdpr_goole_fonts"]').on('change', function() {

		var $checkbox 	= $( this ),
			$wrapper 	= $('.ls-show-if-google-fonts-enabled');

		$wrapper[ $checkbox.prop('checked') ? 'removeClass' : 'addClass' ]('ls-hidden');
	}).change();

	$('#ls-plugin-settings-tabs .ls-empty-google-fonts').on('click', function( event ) {
		if( ! confirm( LS_l10n.GFEmptyConfirmation ) ) {
			event.preventDefault();
			return false;
		}
	});

	$('#ls-global-google-fonts').on('click', '.ls-remove-font', function() {

		if( confirm( LS_l10n.GFRemoveConfirmation ) ) {
			var $fontItem = $( this ).closest('.ls-font-item');

			$fontItem.css({ opacity: 0, transform: 'scale(0)'});
			setTimeout( function() {
				$fontItem.remove();
				saveGoogleFonts();
			}, 250 );
		}
	});

	$( document ).on('click', '.ls-open-plugin-settings-button', function() {

		kmw.modal.open({
			content: $('#tmpl-plugin-settings-content'),
			clip: true,
			minWidth: 400,
			maxHeight: '90%',
			maxWidth: 1280,
			sidebar: {
				left: {
					width: 300,
					customHeaderHeight: true,
					content: $('#tmpl-plugin-settings-sidebar')
				}
			}
		});
	});

	$( document ).on('click', '.ls-open-fonts-library', function() {

		LS_fontLibrary.open( function( fontName ) {

			LS_fontLibrary.close();

			setTimeout( function() {

				var $template = $( $('#ls-font-item-template').html() );

				$template.find('.ls-font-name').text( fontName ).css('font-family', '"'+fontName+'"');
				$('#ls-global-google-fonts').prepend( $template );
				saveGoogleFonts();
			}, 800 );
		});
	});


	$( document ).on('click', '#ls-plugin-settings-content input', function( event ) {

		const 	$checkbox 	= $( this ),
				checked 	= $checkbox.prop('checked');

		// Show additional warning message when enabling option
		if( checked && $checkbox.data('warning-enable') ) {
			if( ! confirm( $( this ).data('warning-enable') ) ) {
				event.preventDefault();
				event.stopPropagation();
				return;
			}
		}

		// Show additional warning message when disabling option
		if( ! checked && $checkbox.data('warning-disable') ) {
			if( ! confirm( $( this ).data('warning-disable') ) ) {
				event.preventDefault();
				event.stopPropagation();
				return;
			}
		}

	});


	var pluginSettingsTimout;
	$( document ).on('change input', '#ls-plugin-settings-content input, #ls-plugin-settings-content select', function() {

		clearTimeout( pluginSettingsTimout );
		pluginSettingsTimout = setTimeout( function() {

			const formData = $('#ls-plugin-settings-content').serialize();

			$.post( ajaxurl, formData, ( responseData ) => {

			});

		}, 500 );
	});

	$( document ).on('click', '.ls-show-canceled-activation-modal', function() {
		kmw.modal.open({
			content: '#tmpl-canceled-activation-modal',
			modalClasses: 'tmpl-canceled-activation-modal',
			minWidth: 400,
			maxWidth: 960,
		});
	});

	// Twitter feed
	window.lsTwitterFeedInterval = setInterval( function() {

		let $iframe 	= $('#ls--box-twitter-feed iframe'),
			$contents 	= $iframe.contents(),
			$header 	= $contents.find('.timeline-Header');

		if( $header.length ) {

			$contents.find('head').append('<link rel="stylesheet" href="'+LS_pageMeta.assetsPath+'/static/admin/css/twitter.css" type="text/css" />');
			clearInterval( window.lsTwitterFeedInterval );
		}


	}, 200 );

	// Fallback Twitter feed
	setTimeout( function() {
		clearInterval( window.lsTwitterFeedInterval );
	}, 5000 );


	$('#ls-notification-clear-button').click( function() {

		$('.ls-notifications-button').removeClass('ls-active');
		$('#ls-notification-panel .ls-notification-unread').removeClass('ls-notification-unread');
		$('.ls-fancy-notice-wrapper .ls-notification-dismissible').slideUp( 400, function() {
			$( this ).remove();

			if( ! $('.ls-fancy-notice-wrapper').children().length ) {
				$('#ls-list-main-menu').removeClass('ls-has-inline-notifications');
			}
		});

		$.getJSON( ajaxurl, { action: 'ls_clear_notifications' });
	});

	jQuery('.ls-slider-list-items').on('click', ':checkbox', function() {

		$( this ).closest('.slider-item').toggleClass('ls-selected');
		checkSliderSelection();
	});



	$('.ls-slider-list-items').on('contextmenu', '.slider-item', function( event ) {

		var $sliderItem = $( this );

		if( $sliderItem.hasClass('group-item') ) {
			event.preventDefault();
			return;
		}

		LS_contextMenuSliderItem = $sliderItem;

		LS_ContextMenu.open( event, {
			width: 230,
			selector: '.ls-sliders-list-context-menu',
			template: '#tmpl-ls-sliders-list-context-menu',
			onBeforeOpen: function( $contextMenu ) {

				if( event.manualOpen ) {
					$sliderItem.addClass('ls-context-menu-open');
				}

				$sliderItem.addClass('ls-highlight-row');
				$contextMenu.removeClass('ls-hidden-slider');

				if( $sliderItem.data('hidden') ) {
					$contextMenu.addClass('ls-hidden-slider');
				}
			},

			onClose: function() {
				$('.slider-item').removeClass('ls-context-menu-open ls-highlight-row');
			}
		});


	}).on('click', '.slider-item .preview', function( event ) {

		if( event.ctrlKey || event.metaKey ) {

			event.preventDefault();

			$( this ).closest('.slider-item').find('.slider-checkbox').click();
		}


	}).on('mouseenter', '.slider-actions-button', function() {
		$( this ).closest('.slider-item').addClass('ls-block-active-state');

	}).on('mouseleave', '.slider-actions-button', function() {
		$( this ).closest('.slider-item').removeClass('ls-block-active-state');

	}).on('click', '.slider-actions-button', function() {

		var $this 	= jQuery( this ),
			offsets = $this.offset(),
			width 	= $this.width(),
			height 	= $this.height();


		jQuery('.ls-slider-list-items').triggerHandler(

			jQuery.Event( 'contextmenu', {
				target: $this[0],
				pageX: offsets.left - 3,
				pageY: offsets.top + height + 7,
				manualOpen: true,
				alignRight: {
					pageX: offsets.left + width
				}
			})
		);


	}).on('click', '.slider-item.group-item', function( e ) {
		e.preventDefault();

		var $this 		= $( this ),
			groupName 	= $.trim( $this.find('.name ls-span').html() ).replace(/"/g, '&quot;');

		$lastOpenedGroup = $this;

		kmw.modal.open({
			into: '.ls-sliders-grid',
			title: '<input value="'+groupName+'"><a href="#" class="ls--button ls--bg-blue ls--small ls-remove-group-button" data-help="'+LS_l10n.SLRemoveGroupTooltip+'" data-help-delay="100">'+LS_l10n.SLRemoveGroupButton+'</a>',
			content: $this.next().children(),
			maxWidth: 1380,
			minWidth: 600,
			spacing: 60,
			modalClasses: 'ls-slider-group-modal-window ls--form-control',
			animationIn: 'scale',
			overlaySettings: {
				animationIn: 'fade',
				customStyle: {
					backgroundColor: 'rgba( 225, 225, 225, 0.95 )'
				}
			},
			onBeforeOpen: function() {
				jQuery('#ls-slider-selection-bar-placeholder').show();
				jQuery('#ls-slider-selection-bar').addClass('ls-overlay-selection-bar');
			},
			onClose: function() {
				jQuery('#ls-slider-selection-bar-placeholder').hide();
				jQuery('#ls-slider-selection-bar').removeClass('ls-overlay-selection-bar');
			}
		});



		setTimeout( function() {
			removeSliderFromGroupDraggable();
		}, 200);

	});


	$( document ).on('input', '.ls-slider-group-modal-window .kmw-modal-title input', function() {

		$this = $( this );

		clearTimeout( sliderGroupRenameTimeout );
		sliderGroupRenameTimeout = setTimeout( function() {

			$.get( ajaxurl, {
				action: 'ls_rename_slider_group',
				groupId: $lastOpenedGroup.data('id'),
				name: $this.val()
			});

		}, 300 );


		$lastOpenedGroup.find('.name ls-span').text( $this.val() );
	});

	$( document ).on('click', '.ls-slider-group-modal-window .ls-remove-group-button', function( e) {

		e.preventDefault();
		kmUI.popover.close();


		setTimeout( function() {

			if( confirm( LS_l10n.SLRemoveGroupConfirm ) ) {

				$.get( ajaxurl, {
					action: 'ls_delete_slider_group',
					groupId: $lastOpenedGroup.data('id'),
				});

				var $sliders = $('.ls-slider-group-modal-window .slider-item');

				// Destroy previous draggable instance (if any)
				if( $sliders.hasClass('ui-draggable') ) {
					$sliders.draggable('destroy');
				}

				// Destroy previous droppable instance (if any)
				if( $sliders.hasClass('ui-droppable') ) {
					$sliders.droppable('destroy');
				}

				$sliders.prependTo('.ls-sliders-grid');

				setTimeout( function() {
					addSliderToGroupDraggable();
					addSliderToGroupDroppable();

					createSliderGroupDroppable();
				}, 300 );


				$lastOpenedGroup.next().remove();
				$lastOpenedGroup.remove();

				kmw.modal.close();
			}

		}, 300 );
	});

	jQuery('#ls-add-slider-button').click( function( e ) {
		e.preventDefault();

		kmw.modal.open({
			content: '#tmpl-add-new-slider',
			maxWidth: 415,
			minWidth: 415,
			onOpen: function() {
				$('#add-new-slider-modal input').focus();
			}

		});
	});

	jQuery('#ls-addons-button').click( function( e ) {
		e.preventDefault();

		kmw.modal.open({
			id: 'ls-premium-benefits-modal',
			content: '<iframe src="https://layerslider.com/premium-embed/" frameborder="0" allowtransparency="true" allowfullscreen="true"></iframe>',
			maxWidth: 1280,
			maxHeight: '100%',
			padding: 0,
			spacing: 20,
			closeButton: true
		});
	});


	// Import Sliders
	$('#ls-list-buttons').on('click', '#ls-import-button', function(e) {
		e.preventDefault();

		kmw.modal.open({
			content: $('#tmpl-upload-sliders').text(),
			minWidth: 400,
			maxWidth: 700
		});

	});

	// Pagivation
	$('.pagination-links a.disabled').click(function(e) {
		e.preventDefault();
	});



	// Drag and drop import
	var importTileDropZone;
	$( document ).on('dragenter.ls', '.ls-item.import-sliders', function( e ) {
		e.preventDefault();
		importTileDropZone = e.target;
		$( this ).addClass('ls-dragover')

	}).on('dragleave.ls drop.ls', '.ls-item.import-sliders', function( e ) {
		e.preventDefault();
		if( e.target == importTileDropZone ) {
			$( this ).removeClass('ls-dragover')
		}

	}).on('dragover.ls', '.ls-item.import-sliders', function( e ) {
		e.preventDefault();

	}).on('drop.ls', '.ls-item.import-sliders', function( event ) {

		var oe 		= event.originalEvent,
			files 	= event.originalEvent.dataTransfer.files,
			$this 	= $( this ),
			$form 	= $('#tmpl-quick-import-form');


		// Prevent uploading empty or multiple file selection
		if( files.length === 0 ||  files.length > 1 ) {
			return false;
		}

		// Prevent uploading files other than ZIP packages
		if( files[0].name.toLowerCase().indexOf('.zip') === -1 ) {
			return false;
		}


		if( ! $form.length ) {
			$form = $( $('#tmpl-quick-import').text() ).prependTo('body');
		}

		$this.addClass('importing');

		$form.find('input[type="file"]')[0].files = files;
		$form.submit();
	});

	// Import window file input
	$( document ).on( 'change', '#ls-upload-modal-window .ls-form-file input', function() {

		var file = this.files[0],
			$input = $(this),
			$parent = $input.parent(),
			$span = $input.prev();

		if( !$input.data( 'original-text' ) ){
			$input.data( 'original-text', $span.text() );
		}

		if( file ) {
			$span.text( file.name );
			$parent.addClass( 'file-chosen' );
		} else {
			$span.text( $input.data( 'original-text' ) );
			$parent.removeClass( 'file-chosen' );
		}
	});




	// Import sample slider
	$( '#ls-browse-templates-button' ).on( 'click', function( event ) {

		event.preventDefault();

		var	$modal;

		// If the Template Store was previously opened on the current page,
		// just grab the element, do not bother re-appending and setting
		// up events, etc.

		// Append dark overlay
		if( !jQuery( '#ls-import-modal-overlay' ).length ){
			jQuery( '<div id="ls-import-modal-overlay">' ).appendTo( '#wpwrap' );
		}

		if( jQuery( '#ls-import-modal-window' ).length ){

			$modal = jQuery( '#ls-import-modal-window' );

		// First time open on the current page. Set up the UI and others.
		} else {

			// Append the template & setup the live logo
			$modal = jQuery( jQuery('#tmpl-import-sliders').text() ).hide().prependTo('body');

			// Update last store view date
			if( $modal.hasClass('has-updates') ) {
				jQuery.get( window.ajaxurl, { action: 'ls_store_opened' });
			}

			// Hide all template items temporarily for faster animations
			jQuery( '#ls-import-modal-window .items' ).hide();


			// Initialize Looking for more? slider
			setTimeout( function() {
				jQuery('#popups-looking-for-more').layerSlider({
					keybNav: false,
					touchNav: false,
					skin: 'v6',
					navPrevNext: false,
					hoverPrevNext: false,
					navStartStop: false,
					navButtons: false,
					showCircleTimer: false,
					useSrcset: false,
					skinsPath: pluginPath + 'layerslider/skins/'
				});

				jQuery('#open-webshopworks-popups').on('click', function() {
					jQuery('#ls-import-modal-window .source-filter li:last').click();
				});
			}, 1200 );

			importModalWindowTimeline = new TimelineMax({
				onStart: function(){
					jQuery( '#ls-import-modal-overlay' ).show();
					jQuery( 'html, body' ).addClass( 'ls-no-overflow' );
					jQuery(document).on( 'keyup.LS', function( e ) {
						if( e.keyCode === 27 ){
							jQuery( '#ls-browse-templates-button' ).data( 'lsModalTimeline' ).reverse().timeScale(1.5);
						}
					});
				},
				onComplete: function(){
					if( importModalWindowTimeline ) {
						importModalWindowTimeline.remove( importModalThumbnailsTransition );
					}
				},
				onReverseComplete: function(){
					jQuery( 'html, body' ).removeClass( 'ls-no-overflow' );
					jQuery(document).off( 'keyup.LS' );
					jQuery( '#ls-import-modal-overlay' ).hide();
					TweenMax.set( jQuery( '#ls-import-modal-window' )[0], { css: { y: -100000 } });
				},
				paused: true
			});

			$(this).data( 'lsModalTimeline', importModalWindowTimeline );

			importModalWindowTimeline.fromTo( $('#ls-import-modal-overlay')[0], 0.75, {
				autoCSS: false,
				css: {
					opacity: 0
				}
			},{
				autoCSS: false,
				css: {
					opacity: 0.75
				},
				ease: Quart.easeInOut
			}, 0 );

			importModalThumbnailsTransition = TweenMax.fromTo( $( '#ls-import-modal-window .items' )[0], 0.5, {
				autoCSS: false,
				css: {
					opacity: 0,
					display: 'flex'
				}
			},{
				autoCSS: false,
				css: {
					opacity: 1
				},
			ease: Quart.easeInOut
			});

			importModalWindowTimeline.add( importModalThumbnailsTransition, 0.75 );
		}

		importModalWindowTimeline.remove( importModalWindowTransition );

		importModalWindowTransition = TweenMax.fromTo( $modal[0], 0.75, {
			autoCSS: false,
			css: {
				position: 'fixed',
				display: 'block',
				y: 0,
				x: jQuery( window ).width()
			}
		},{
			autoCSS: false,
			css: {
				x: 0
			},
			ease: Quart.easeInOut
		}, 0 );

		importModalWindowTimeline.add( importModalWindowTransition, 0 );

		importModalWindowTimeline.play();
	});



	// Template Store: Content chooser
	jQuery( document ).on('click', '#ls-import-modal-window .content-filter li, #ls-import-modal-window .source-filter li', function() {

		activeShuffleContainerIndex = jQuery( this ).data('index');

		jQuery('#ls-import-modal-window .inner')
			.removeClass('active')
			.eq( activeShuffleContainerIndex )
			.addClass('active')
			.find('.items')
			.show();
	});


	// Template Store: Slider filters
	jQuery( document ).on( 'click', '#ls-import-modal-window .shuffle-filters li', function(){

		$(this).addClass('active').siblings().removeClass('active');

		var $this 	= $( this ),
			$target = $('.ls-template-items').eq( activeShuffleContainerIndex ),
			$scroll = $('.ls-templates-holder').eq( activeShuffleContainerIndex ),
			$items 	= $target.find('.item'),
			cat 	= $this.data('group');


		if( ! cat ) {
			$items.show();
		} else {
		 	$items.hide().filter('[data-groups*="'+cat+'"]').show();
		}

		$scroll.animate({ scrollTop: 0 }, 300 );
	});


	$( document ).on( 'click', '#ls-import-modal-window > header b', function(){
		$( '#ls-browse-templates-button' ).data( 'lsModalTimeline' ).reverse();

	}).on('submit', '#ls-upload-modal-window form', function(e) {

		jQuery('.button', this).text(LS_l10n.SLUploadProject).addClass('saving');

	}).on('click', '.ls-open-add-new-slider', function(e) {

		e.preventDefault();

		kmw.modal.close();

		$('#ls-add-slider-button').click();

	}).on('click', '.ls-open-template-store', function(e) {

		e.preventDefault();

		kmw.modal.close();

		setTimeout(function() {
			$('#ls-browse-templates-button').click();
		}, $(this).data('delay') || 0);
	});

	$('#ls--release-channel select').change( function() {

	var $select = $( this ),
		$form 	= $select.closest('form');


		$.getJSON( ajaxurl, $form.serialize(), function( data ) {

			kmUI.notify.show({
				icon: 'success',
				text: LS_l10n.releaseChannelUpdated,
				timeout: 2000
			});
		});
	});


	// Auto-update and License registration
	$('#ls--box-license form').submit(function(e) {

		// Prevent browser default submission
		e.preventDefault();

		var $form 	= $(this),
			$key 	= $form.find('input[name="purchase_code"]'),
			$button = $form.find('.button-save:visible');

		if( $key.val().length < 10 ) {
			alert(LS_l10n.SLEnterCode);
			return false;
		}

		// Send request and provide feedback message
		$button.data('text', $button.text() ).text(LS_l10n.working);

		// Post it
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: $(this).serialize(),
			error: function( jqXHR, textStatus, errorThrown ) {
				alert(LS_l10n.SLActivationError.replace('%s', errorThrown) );
				$button.removeClass('saving').text( $button.data('text') );
			},
			success: function( data ) {

				// Parse response and set message
				data = $.parseJSON(data);

				// Success
				if( data && ! data.errCode ) {

					// Updated license, was already registered
					if( LS_slidersMeta.isActivatedSite ) {

						kmUI.notify.show({
							icon: 'success',
							text: LS_l10n.licenseKeyUpdated,
							timeout: 2000
						});
					}

					// Make sure that features requiring activation will
					// work without refreshing the page.
					LS_slidersMeta.isActivatedSite = true;

					// Update GUI to reflect the "registered" state
					$( '#ls--license-slider' ).layerSlider( 2 );
					LS__setRegistered( true );

				// HTML-based error message (if any)
				} else if( typeof data.messageHTML !== "undefined" ) {

					kmw.modal.open({
						title: data.titleHTML ? data.titleHTML : LS_l10n.activationErrorTitle,
						content: '<div id="tmpl-activation-error-modal-window">'+data.messageHTML+'</div>',
						maxWidth: 660,
						minWidth: 400
					});

				// Alert message (if any)
				} else if( typeof data.message !== "undefined" ) {
					alert( data.message );
				}

				$button.removeClass('saving').text( $button.data('text') );
			}
		});
	});


	// Auto-update deauthorization
	$('#ls--box-license a.ls-deauthorize').click(function(event) {
		event.preventDefault();

		if( confirm(LS_l10n.SLDeactivate) ) {

			var $form = $(this).closest('form');

			$.get( ajaxurl, $.param({ action: 'ls_deauthorize_site' }), function(data) {

				// Parse response and set message
				var data = $.parseJSON(data);

				if( data && ! data.errCode ) {

					$form.find('.ls--key input').val('');

					LS_slidersMeta.isActivatedSite = false;


					// Update GUI to reflect the "registered" state
					$( '#ls--license-slider' ).layerSlider( 1 );
					LS__setRegistered( false );
				}

				// Alert message (if any)
				if(typeof data.message !== "undefined") {
					alert(data.message);
				}
			});
		}
	});

	var lsShowActivationBox = function( activateBox ) {

		document.location.hash = '';

		kmw.modal.close();

		var $box = $('#ls--box-license');


		if( ! $box.length || $box.is(':hidden') ) {
			kmw.modal.open({
				content: '#tmpl-activation-unavailable',
				maxWidth: 600
			});

			return false;
		}

		scrollToElement( $('#ls--box-license') );
	};

	$( document ).on('click', '.ls-show-activation-box', function(e) {
		e.preventDefault();
		lsShowActivationBox();
	});

	$( document ).on('click', '#lse-activation-modal-window .lse-button-activation', function( e ) {

		e.preventDefault();

		if( $(this).closest('#ls-import-modal-window').length ) {

			jQuery(document).trigger( jQuery.Event('keyup', { keyCode: 27 }) );
			setTimeout(function() {
				lsShowActivationBox( true );
			}, 800);

		} else {

			kmw.modal.close( false, {
				onClose: function() {
					lsShowActivationBox( true );
				}
			});
		}
	});

	if( document.location.href.indexOf('#activationBox') !== -1 ) {
		setTimeout(function() {
			lsShowActivationBox( true );
		}, 500 );
	}


	// Shortcode
	$('input.ls-shortcode').click(function() {
		this.focus();
		this.select();
	});

	// Template Store Import
	$( document ).on('click', '#ls-import-modal-window .item-import a', function( event ) {
		event.preventDefault();

		var $item 		= jQuery(this),
			$figure 	= $item.closest('figure'),
			name 		= $figure.data('name'),
			handle 		= $figure.data('handle'),
			collection 	= $figure.data('collection'),
			bundled 	= !! $figure.data('bundled'),
			action 		= bundled ? 'ls_import_bundled' : 'ls_import_online';


		// Premium notice
		if( $figure.data('premium') && ! LS_slidersMeta.isActivatedSite ) {

			lsDisplayActivationWindow({
				into: '#ls-import-modal-window',
				title: LS_l10n.activationTemplate
			});

			return;

		// Version warning
		} else if( $figure.data('version-warning') ) {

			kmw.modal.open({
				into: '#ls-import-modal-window',
				content: '#tmpl-version-warning',
				id: 'ls-version-warning',
				minWidth: 500,
				maxWidth: 500
			});
			return;
		}

		kmw.modal.open({
			content: '#tmpl-importing',
			into: '#ls-import-modal-window',
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

		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: action,
				slider: handle,
				name: name,
				collection: collection,
				security: window.lsImportNonce
			},

			beforeSend: function( jqXHR, settings ) {

				setTimeout( function( ) {

					var $modal = jQuery('#ls-loading-modal-window').closest('.kmw-modal');

					TweenLite.to( $modal[0], 0.5, {
						minWidth: 580,
						maxWidth: 580,
						height: 446,
						maxHeight: 480,

						onComplete: function() {
							$('<div class="ls-import-notice">'+LS_l10n.SLImportNotice+'</div>')
							.hide()
							.appendTo( $modal.find('.kmw-modal-content') )
							.fadeIn( 250 );
						}
					});
				}, 1000*60 );
			},

			success: function(data, textStatus, jqXHR) {

				data = data ? JSON.parse( data ) : {};

				if( data.success ) {
					document.location.href = data.url;

				} else {

					kmw.modal.close();

					if( data.reload ) {
						window.location.reload( true );
						return;
					}

					if( data.errCode && data.errCode == 'ERR_WW_POPUPS_PURCHASE_NOT_FOUND') {


							lsDisplayActivationWindow({
								into: '#ls-import-modal-window',
								title: LS_l10n.purchaseWWPopups,
								content: '#tmpl-purchase-webshopworks-popups',
								minHeight: 680,
								maxHeight: 680
							});


						return;
					}

					setTimeout(function() {
						kmw.modal.open({
							into: '#ls-import-modal-window',
							title: data.title || LS_l10n.SLImportErrorTitle,
							content: data.message || LS_l10n.SLImportError,
							animationIn: 'scale',
							overlaySettings: {
								animationIn: 'fade'
							}

						});

					}, 600);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {

				kmw.modal.close();

				setTimeout(function() {
					kmw.modal.open({
						into: '#ls-import-modal-window',
						title: LS_l10n.SLImportErrorTitle,
						content: LS_l10n.SLImportHTTPError.replace('%s', errorThrown),
						animationIn: 'scale',
						overlaySettings: {
							animationIn: 'fade'
						}

					});

				}, 600);
			},
			complete: function() {

			}
		});
	});

	if( document.location.hash === '#open-template-store' ) {
		setTimeout( function() {
			$('#ls-browse-templates-button').click();
		}, 500);


	} else if( document.location.hash === '#open-addons' ) {
		setTimeout( function() {
			$('#ls-addons-button').click();
		}, 500);
	}



	var addSliderToGroupDraggable = function() {

		$('.ls-sliders-grid > .slider-item').draggable({
			scope: 'add-to-group',
			cancel: '.group-item, .hero',
			handle: '.preview',
			distance: 5,
			helper: 'clone',
			revert: 'invalid',
			revertDuration: 300,
			start: function( event, ui ) {

				draggedSliderItem = event.target;
				$( draggedSliderItem ).addClass('dragging-original');
			},

			stop: function( event, ui ) {
				$( event.target ).removeClass('dragging-original');
			}
		});
	};


	var addSliderToGroupDroppable = function() {

		$('.ls-sliders-grid .group-item').droppable({
			scope: 'add-to-group',
			accept: '.slider-item',
			tolerance: 'pointer',
			hoverClass: 'slider-dropping',
			over: function( event, ui ) {

				ui.helper.find('.preview').addClass('slider-dropping');
			},

			out: function( event, ui ) {
				ui.helper.find('.preview').removeClass('slider-dropping');
			},


			drop: function( event, ui ) {

				addSliderToGroup( event.target, draggedSliderItem );
			}
		});
	};



	var removeSliderFromGroupDraggable = function() {

		$('.ls-sliders-grid .kmw-modal-inner .slider-item').draggable({
			scope: 'remove-from-group',
			handle: '.preview',
			appendTo: '.ls-sliders-grid',
			distance: 5,
			helper: 'clone',
			zIndex: 9999999,
			revert: 'invalid',
			revertDuration: 300,
			start: function( event, ui ) {
				draggedSliderItem = event.target;
				$( draggedSliderItem ).addClass('dragging-original');
				$('#ls-group-remove-area').addClass('active');
			},

			stop: function( event, ui ) {
				$( draggedSliderItem ).removeClass('dragging-original');
				$('#ls-group-remove-area').removeClass('active');
			}
		});
	};


	var removeSliderFromGroupDroppable = function() {

		$('#ls-group-remove-area .ls-drop-area').droppable({
			scope: 'remove-from-group',
			accept: '.slider-item',
			tolerance: 'pointer',

			over: function( event, ui ) {
				ui.draggable.addClass('over-drag-area');
				ui.helper.find('.preview').addClass('cursor-default');
				$( event.target ).addClass('over');
			},

			out: function( event, ui ) {
				ui.draggable.removeClass('over-drag-area');
				ui.helper.find('.preview').removeClass('cursor-default');
				$( event.target ).removeClass('over');
			},

			drop: function( event, ui ) {

				$( event.target ).removeClass('over');
				ui.draggable.removeClass('over-drag-area');

				removeSliderFromGroup(
					$lastOpenedGroup,
					ui.draggable
				);
			}
		});
	};



	var createSliderGroupLastEvent;

	var createSliderGroupDroppable = function() {

		$('.ls-sliders-grid .slider-item:not(.hero,.group-item)').droppable({
			scope: 'add-to-group',
			accept: '.slider-item',
			tolerance: 'pointer',
			hoverClass: 'slider-dropping',

			over: function( event, ui ) {

				var f = function(){
					targetSliderItem = event.target;
					$( event.target ).addClass('create-group');
					ui.helper.find('.preview').addClass('slider-dropping');
					createSliderGroupLastEvent = 'over';
				};

				if( createSliderGroupLastEvent == 'over' ){
					setTimeout( function(){
						f();
					}, 0 );
				} else {
					f();
				}
			},

			out: function( event, ui ) {

				var f = function(){
					targetSliderItem = null;
					$('.slider-item').removeClass('create-group');
					ui.helper.find('.preview').removeClass('slider-dropping');
					createSliderGroupLastEvent = 'out';
				};

				if( createSliderGroupLastEvent == 'out' ){

					setTimeout( function(){
						f();
					}, 0 );
				} else {
					f();
				}
			},

			deactivate: function( event, ui ) {
				clearTimeout( sliderDragGroupingTimeout );
				$('.slider-item').removeClass('create-group');
				ui.helper.find('.preview').removeClass('slider-dropping');
			},

			drop: function( event, ui ) {

				if( targetSliderItem ) {

					var $template 	= $( $('#tmpl-slider-group-item').text() ),
						$markup 	= $template.insertAfter( targetSliderItem ),
						$group 		= $markup.filter('.group-item');

					addSliderToGroup( $group, targetSliderItem, true );
					addSliderToGroup( $group, draggedSliderItem, true );

					$( targetSliderItem ).hide();
					$( draggedSliderItem ).hide();

					addSliderToGroupDroppable();

					$.getJSON( ajaxurl, {
						action: 'ls_create_slider_group',
						items: [
							$( targetSliderItem ).data('id'),
							$( draggedSliderItem ).data('id')
						]

					}, function( data ) {
						$group.data('id', data.groupId );
					});
				}
			}
		});
	};






	var addSliderToGroup = function( groupElement, sliderElement, withoutXHR ) {

		var $group 			= $( groupElement ),
			$groupItems 	= $group.find('.items'),
			$slider 		= $( sliderElement ),
			$sliderPreview 	= $slider.find('.preview'),
			$groupItem 		= $( $('#tmpl-slider-group-placeholder').text() );

		// XHR request to add slider to group
		if( ! withoutXHR ) {
			$.get( ajaxurl, {
				action: 'ls_add_slider_to_group',
				sliderId: $slider.data('id'),
				groupId: $group.data('id')
			});
		}


		// Add slider to group on UI
		if( ! $sliderPreview.find('.no-preview').length ) {
			$groupItem.find('.preview').css('background-image', $sliderPreview.css('background-image') );
			$groupItem.find('.preview').empty();
		}

		// Destroy previous draggable instance (if any)
		if( $slider.hasClass('ui-draggable') ) {
			$slider.draggable('destroy');
		}

		// Destroy previous droppable instance (if any)
		if( $slider.hasClass('ui-droppable') ) {
			$slider.droppable('destroy');
		}

		$slider.clone( true, true )
			.removeClass('dragging-original')
			.removeClass('create-group')
			.appendTo( $group.next().children() );

		$groupItem.appendTo( $groupItems );
		setTimeout( function() {
			$groupItem.removeClass('scale0');
		}, 100 );

		// Remove the original element
		$slider.remove();
	};



	var removeSliderFromGroup = function( groupElement, sliderElement, withoutXHR ) {

		var $group 			= $( groupElement ),
			$groupItems 	= $group.find('.items'),
			$slider 		= $( sliderElement ),
			$sliderPreview 	= $slider.find('.preview'),
			$siblings 		= $slider.siblings();

		// XHR request to add slider to group
		if( ! withoutXHR ) {
			$.get( ajaxurl, {
				action: 'ls_remove_slider_from_group',
				sliderId: $slider.data('id'),
				groupId: $group.data('id')
			});
		}

		// Remove from preview items
		$groupItems.children().eq( $slider.index() ).remove();

		// Destroy previous draggable instance (if any)
		if( $slider.hasClass('ui-draggable') ) {
			$slider.draggable('destroy');
		}

		// Destroy previous droppable instance (if any)
		if( $slider.hasClass('ui-droppable') ) {
			$slider.droppable('destroy');
		}

		// Remove slider from group
		$slider.prependTo('.ls-sliders-grid');

		setTimeout( function() {
			addSliderToGroupDraggable();
			addSliderToGroupDroppable();

			createSliderGroupDroppable();
		}, 300 );


		// Handle auto-group deletion in case of removing
		// the last element.
		if( $siblings.length < 1 ) {

			$group.next().remove();
			$group.remove();

			kmw.modal.close();
		}
	};


	$('#ls-slider-selection-bar').on('click', 'ls-button', function( event ) {
		event.preventDefault();
		performSliderAction( $( this ).data('action') );
	});

	$( document ).on('click', '.ls-sliders-list-context-menu li', function( event ) {
		event.preventDefault();
		performSliderAction( $( this ).data('action'), {
			sliderItem: LS_contextMenuSliderItem,
			selectSliderItem: true
		});
	});



	var checkSliderSelection = function() {

		$selected = $('.ls-slider-list-items :checkbox:checked' );

		if( $selected.length ) {
			$('.ls-sliders-grid').addClass('ls-has-selection');
			$('body').addClass('ls-has-slider-selection');

			if( $selected.length > 1 ) {
				$('body').addClass('ls-has-multiple-slider-selection');
			} else {
				$('body').removeClass('ls-has-multiple-slider-selection');
			}

			if( $selected.closest('.slider-item.dimmed').length ) {
				$('body').addClass('ls-has-hidden-slider-selection');
			} else {
				$('body').removeClass('ls-has-hidden-slider-selection');
			}


			if( $selected.closest('.slider-item:not(.dimmed)').length ) {
				$('body').addClass('ls-has-published-slider-selection');
			} else {
				$('body').removeClass('ls-has-published-slider-selection');
			}


		} else {
			$('.ls-sliders-grid').removeClass('ls-has-selection');
			$('body').removeClass('ls-has-slider-selection ls-has-multiple-slider-selection ls-has-hidden-slider-selection ls-has-published-slider-selection');
		}
	};

	checkSliderSelection();


	var startSliderSelection = function() {

	};

	var stopSliderSelection = function() {

	};

	var performSliderAction = function( action, actionProperties ) {

		actionProperties = actionProperties || {};

		var $form 			= $('.ls-slider-list-form'),
			$bulkSelect 	= $('.ls-bulk-actions select[name="action"]'),
			$sliderItem		= $('.slider-item.ls-selected');

		if( actionProperties.sliderItem ) {
			$sliderItem = $( actionProperties.sliderItem );
		}

		if( actionProperties.selectSliderItem ) {
			$sliderItem.find('.slider-checkbox').prop('checked', true );
		}

		switch( action ) {

			case 'cancel':
				$('.slider-item :checkbox').prop('checked', false);
				$('.slider-item.ls-selected' ).removeClass('ls-selected');
				checkSliderSelection();
				break;

			case 'embed':
				showSliderEmbedModal(
					$sliderItem.data('id'),
					$sliderItem.data('slug')
				);
				break;

			case 'export':
				$bulkSelect.val('export');
				$form.submit();
				break;

			case 'export-html':
				if( exportSliderAsHTML() ) {
					$bulkSelect.val('export-html');
					$form.submit();
				}
				break;

			case 'duplicate':
				$bulkSelect.val('duplicate');
				$form.submit();
				break;

			case 'revisions':
				document.location.href = $sliderItem.data('revisions');
				break;

			case 'hide':
				if( confirm( LS_l10n.SLHideProjects ) ) {
					$bulkSelect.val('hide');
					$form.submit();
				}
				break;

			case 'unhide':
				$bulkSelect.val('restore');
				$form.submit();
				break;

			case 'group':
				$bulkSelect.val('group');
				$form.submit();
				break;

			case 'merge':
				$bulkSelect.val('merge');
				$form.submit();
				break;

			case 'delete':
				if( confirm( LS_l10n.SLDeleteProject ) ) {
					$bulkSelect.val('delete');
					$form.submit();
				}
				break;
		}

		if( actionProperties.selectSliderItem ) {
			$sliderItem.find('.slider-checkbox').prop('checked', false );
		}
	};

	var showSliderEmbedModal = function( sliderId, sliderSlug ) {

		var $modal 	= kmw.modal.open({
			content: jQuery('#tmpl-embed-project'),
			minWidth: 400,
			maxWidth: 980,
			sidebar: {
				left: {
					width: 300,
					content: jQuery('#tmpl-embed-project-sidebar')
				}
			}
		});

		$modal.find('input.lse-shortcode').val('[layerslider id="'+(sliderSlug || sliderId)+'"]');

	};


	var exportSliderAsHTML = function() {

		if( ! LS_slidersMeta.isActivatedSite ) {
			lsDisplayActivationWindow();
			return false;
		}



		if( window.localStorage ) {

			if( ! localStorage.lsExportHTMLWarning ) {
				localStorage.lsExportHTMLWarning = 0;
			}

			var counter = parseInt( localStorage.lsExportHTMLWarning ) || 0;

			if( counter < 3 ) {

				localStorage.lsExportHTMLWarning = ++counter;

				if( ! confirm( LS_l10n.SLExportProjectHTML ) ) {
					return false;
				}
			}
		}

		return true;
	};

	var scrollToElement = function( target, callback ) {

		if( ! target ) {
			return;
		}

		var $target = $( target );

		if( $target.length ) {
			$('html,body')
				.stop( true, true )
				.animate({
					scrollTop: $target.offset().top - 50
				}, 500, function() {
					if( callback ) {
						callback();
					}
				});
		}
	};

	var saveGoogleFonts = function() {

		var data = {
			action: 'ls_save_google_fonts',
			_wpnonce: $('#ls-global-google-fonts-nonce').text(),
			fonts: []
		};

		$('#ls-global-google-fonts .ls-font-name').each( function() {
			data.fonts.push( $( this ).text() );
		});

		$.post( ajaxurl, data );
	};


	// Group draggable & droppable
	addSliderToGroupDraggable();
	addSliderToGroupDroppable();

	createSliderGroupDroppable();

	removeSliderFromGroupDraggable();
	removeSliderFromGroupDroppable();

	var LS__setRegistered = function( registered){
		if( registered ){
			$('#ls--admin-boxes').removeClass('ls--not-registered').addClass('ls--registered');
		}else{
			$('#ls--admin-boxes').removeClass('ls--registered').addClass('ls--not-registered');
		}

	};

	// Initialize sliders on the main admin page
	$( '#ls--license-slider' ).layerSlider({
		createdWith: '6.11.5',
		sliderVersion: '6.11.5',
		allowFullscreen: false,
		firstSlide: LS_slidersMeta.isActivatedSite ? 2 : 1,
		autoStart: false,
		startInViewport: true,
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
