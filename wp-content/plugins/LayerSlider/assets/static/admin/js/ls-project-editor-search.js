const LS_SearchActions = [

	/*
	|   ADD NEW ...
	|-------------------------------------------------------------------------*/
	{
		name: 'Add New',
		actions: [
			{
				name: 'Image Layer',
				icon: 'img',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('img');
				}
			},

			{
				name: 'Text Layer',
				icon: 'text',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('text');
				}
			},

			{
				name: 'Video / Audio Layer',
				icon: 'media',
				keywords: 'add new create media',
				action: function() {
					LayerSlider.addFormattedLayer('media');
				}
			},

			{
				name: 'Button Layer',
				icon: 'button',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('button');
				}
			},


			{
				name: 'Icon Layer',
				icon: 'icon',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('icon-modal');
				}
			},

			{
				name: 'Shape Layer',
				icon: 'shape',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('shape-modal');
				}
			},

			{
				name: 'SVG Layer',
				icon: 'svg',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('svg-modal');
				}
			},

			{
				name: 'HTML Layer',
				icon: 'html',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('html');
				}
			},

			{
				name: 'Dynamic Layer',
				icon: 'post',
				keywords: 'add new create',
				action: function() {
					LayerSlider.addFormattedLayer('post');
				}
			}

		]

	},


	/*
	|   LAYER ACTIONS
	|-------------------------------------------------------------------------*/
	{
		name: 'Layer Actions',
		actions: [

			{
				name: 'Add New Layer',
				icon: 'plus',
				keywords: 'create',
				action: function() {
					jQuery('.lse-add-layer-button').click();
				}
			},

			{
				name: 'Import Layer',
				icon: 'import',
				keywords: 'create add new',
				action: function() {
					LS_ImportLayer.open();
				}
			},

			{
				name: 'Duplicate Layer',
				icon: 'clone',
				action: function() {
					LayerSlider.duplicateLayer();
				}
			},

			{
				name: 'Copy Layer',
				icon: 'copy',
				action: function() {
					LayerSlider.copyLayer();
				}
			},

			{
				name: 'Paste Layer',
				icon: 'clipboard',
				action: function() {
					LayerSlider.pastaLayer();
				}
			},

			{
				name: 'Remove Layer',
				icon: 'trash',
				keywords: 'delete trash hide',
				action: function() {
					LayerSlider.removeLayer();
				}
			},

			{
				name: 'Toggle Layer Locking',
				icon: 'lock',
				action: function() {
					LayerSlider.lockLayer();
				}
			},

			{
				name: 'Toggle Layer Visibility',
				icon: 'eye',
				keywords: 'hide show',
				action: function() {
					LayerSlider.hideLayer();
				}
			},


		]
	},



	/*
	|   SLIDE ACTIONS
	|-------------------------------------------------------------------------*/
	{
		name: 'Slide Actions',
		actions: [

			{
				name: 'Add Slide',
				icon: 'plus',
				keywords: 'new',
				action: function() {
					LayerSlider.addSlide();
				}
			},

			{
				name: 'Duplicate Slide',
				icon: 'clone',
				keywords: 'clone',
				action: function() {
					LayerSlider.duplicateSlide();
				}
			},

			{
				name: 'Remove Slide',
				icon: 'trash',
				keywords: 'delete trash hide',
				action: function() {
					LayerSlider.removeSlide();
				}
			},

			{
				name: 'Toggle Slide Visibility',
				icon: 'eye',
				keywords: 'publish unpublish hide show',
				action: function() {
					LayerSlider.toggleSlideVisibility();
				}
			},

			{
				name: 'Generate Slide Preview',
				icon: 'camera',
				keywords: 'thumbnail image capture',
				action: function() {
					LayerSlider.captureSlide();
				}
			},

			{
				name: 'Slide Options',
				icon: 'cog',
				keywords: 'settings background thumbnail link attributes schedule',
				action: function() {
					LayerSlider.openSlideOptions();
				}
			},

			{
				name: 'Undo',
				icon: 'undo',
				keywords: 'history back',
				action: function() {
					LS_UndoManager.undo()
				}
			},

			{
				name: 'Redo',
				icon: 'redo',
				keywords: 'history',
				action: function() {
					LS_UndoManager.redo()
				}
			},

			{
				name: 'Toggle Slide Preview',
				icon: 'film',
				keywords: 'live run animate start',
				action: function() {
					lsEditor.preview.toggle('slide');
				}
			},

			{
				name: 'Toggle Layer Preview',
				icon: 'film',
				keywords: 'live run animate start',
				action: function() {
					lsEditor.preview.toggle('layer');
				}
			}
		]
	},



	/*
	|   SLIDER ACTIONS
	|-------------------------------------------------------------------------*/
	{
		name: 'Project Actions',
		actions: [

			{
				name: 'Save Project',
				icon: 'save',
				keywords: 'publish',
				action: function() {
					LayerSlider.save();
				}
			},

			{
				name: 'Publish Project',
				icon: 'publish',
				keywords: 'save',
				action: function() {
					LayerSlider.publish();
				}
			},

			{
				name: 'Export Project',
				icon: 'export',
				keywords: 'save',
				action: function() {
					document.location.href = LS_editorMeta.exportURL;
				}
			},

			{
				name: 'Revisions',
				icon: 'history',
				keywords: 'versions history backup undo',
				action: function() {
					LS_Revisions.open();
				}
			},

			{
				name: 'Project Settings',
				icon: 'wrench',
				keywords: 'options',
				action: function() {
					LayerSlider.openSliderSettings();
				}
			},

			{
				name: 'Event Callbacks',
				icon: 'retweet',
				keywords: 'options',
				action: function() {
					LayerSlider.openEventCallbacks()
				}
			},


		]
	},



	/*
	|   GENERAL
	|-------------------------------------------------------------------------*/
	{
		name: 'General',
		actions: [


			{
				name: 'Interface Settings',
				icon: 'cog',
				keywords: 'options',
				action: function() {
					lsEditor.slideMenu.slideTo( 'ellipsisMenu', 'interfaceSettings' );
				}
			},

			{
				name: 'Documentation',
				icon: 'book',
				keywords: 'tutorial documentation help',
				action: function() {
					window.open( 'https://layerslider.com/documentation/' );
				}
			},

			{
				name: 'Interactive Guides',
				icon: 'book',
				keywords: 'help tour tutorial',
				action: function() {
					lsEditor.slideMenu.slideTo( 'ellipsisMenu', 'interactiveGuides' );
				}
			},

			{
				name: 'Language',
				icon: 'globe',
				keywords: 'options',
				action: function() {
					lsEditor.slideMenu.slideTo( 'ellipsisMenu', 'language' );
				}
			},

			{
				name: 'Keyboard Shortcuts',
				icon: 'keyboard',
				action: function() {
					LS_editorUI.openKeyboardShortcuts();
				}
			},

			{
				name: 'How To Embed',
				icon: 'plus',
				keywords: 'help publish insert add',
				action: function() {
					LS_editorUI.openEmbedModal();
				}
			},

			{
				name: 'Get Help',
				icon: 'help',
				keywords: 'tutorial documentation',
				action: function() {
					window.open( 'https://layerslider.com/help/' );
				}
			},

			{
				name: 'Toggle Fullscreen Mode',
				icon: 'fullscreen',
				keywords: 'clone',
				action: function() {
					lsEditor.workspace.toggleFullscreenMode();
				}
			},

			{
				name: 'Follow Us on Twitter',
				icon: 'twitter',
				keywords: 'social',
				action: function() {
					window.open( 'https://twitter.com/kreaturamedia' );
				}
			},

			{
				name: 'Follow Us on Facebook',
				icon: 'facebook',
				keywords: 'like social',
				action: function() {
					window.open( 'https://www.facebook.com/kreaturamedia' );
				}
			},

			{
				name: 'Follow Us on Instagram',
				icon: 'instagram',
				keywords: 'like social',
				action: function() {
					window.open( 'https://www.instagram.com/layersliderwp/' );
				}
			},

			{
				name: 'Watch Us on YouTube',
				icon: 'youtube',
				keywords: 'tutorial help documentation social',
				action: function() {
					window.open( 'https://www.youtube.com/user/kreaturamedia' );
				}
			}

		]
	}


];