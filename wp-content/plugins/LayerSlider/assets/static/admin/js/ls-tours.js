window.lseTourIntervals = [];

export const LS_tourData = {

	abortedTour: {
		intro: { enable: false },
		tourMap: { enable: false },
		continue: { enable: false },
		pagination: false,
		create: function(){
			window.LS_tourIsActive = true;
			jQuery( '.g-modal-size' ).attr( 'data-step', 'abort' );
		},
		end: function(){
			window.LS_tourIsActive = false;
			localStorage['lse-welcome-guide-warned'] = 1;
		},
		steps: [{
			target: '#lse-ellipsis-opener',
			title: 'Before You Go',
			content: 'You can access interactive guided tours from this menu if you change your mind later.',
			spacing: 1
		}],
		pagination: false,
		lang: {
			endText: 'Okay'
		}
	},

	interfaceWalkthrough: {

		tourTitle: 'Interface Walkthrough',
		tourMap: {
			enable: false
		},
		width: 400,
		overlayClickable: false,
		pagination: false,
		create: function(){
			jQuery( '.g-modal-size' ).attr( 'data-step', 'intro' );
			window.LS_tourIsActive = true;
		},
		end: function(){

			window.LS_tourIsActive = false;

			if( window.lseTourIntervals[0] ){
				clearInterval( window.lseTourIntervals[0] );
			}
			if( window.lseTourIntervals[1] ){
				clearInterval( window.lseTourIntervals[1] );
			}
		},

		finish: function() {
			localStorage['lse-welcome-guide-completed'] = 1;
		},

		abort: function() {
			localStorage['lse-welcome-guide-completed'] = 1;

			setTimeout( function() {
				if( ! localStorage['lse-welcome-guide-warned'] ) {
					iGuider( LS_tourData.abortedTour );
				}
			}, 500 );
		},

		continue: {
			enable: false
		},

		intro: {
			title: 'Welcome to LayerSlider 7',
			content: 'This 3-minute tour breifly highlights key areas of the LayerSlider 7 project editor. Whether you’re new to LayerSlider or coming from an older version, this guide can be helpful to get familiar with the all-new editor interface.',
			cover: 'https://layerslider.com/media/guides/welcome/intro-effected-2.png',
			width: 760
		},

		steps: [
			{
				target: '#lse-show-project-settings',
				title: 'Project Settings',
				content: 'Project Setting, formerly known as “Slider Settings”, is where you can set the canvas size, layout, appearance, navigation, and slideshow options, among many others.<br><br>We’ve chosen the name “Project” to represent all the different types of work you can build with LayerSlider, such as sliders, popups, hero scenes, image galleries, slideshows, animated page blocks, etc.',
				spacing: 1,
				before: function(){
					jQuery( '.g-modal-size' ).attr( 'data-step', 'projectsettings' );
				}
			},
			{
				target: '#lse-show-slides-list',
				title: 'Slides List',
				content: 'Slides are useful to create different <b>animation scenes</b> that are activated in a defined sequence. You can change their behavior and freely navigate between them.<br><br>Simple image galleries might only contain slides with a background image. More complex slides have their dedicated list of layers. A layer can be an image, text, icon, video, or any object added to the slide that animates independently from other layers or even from the slide.<br><br>You can access the list of your slides by opening this panel. Your project can contain as many slides and layers as you want.',
				cover: 'https://layerslider.com/media/guides/welcome/slides-list.png',
				spacing: 1,
				width: 550
			},
			{
				target: '#lse-toolbar-sidebar-tabs',
				title: 'Slide and Layer Settings',
				content: 'You can access slide and layer settings from the right sidebar. You can choose which one you would like to edit with the tabs at the top. <br><br> In the sidebar, you find the individual slide or layer options. Many have a <b>+</b> sign attached to them when you move your mouse cursor over their field. Clicking on the <b>+</b> sign will open a panel where you find helpful information describing what that option does, examples, as well as additional features. For instance, the <b>+</b> sign of the Font Family field lets you choose from more than a thousand beautiful typefaces provided by Google Fonts.',
				spacing: 1,
				before: function(){
					window.lseTourIntervals[0] = setInterval(function(){
						jQuery( '#lse-show-slide-settings' ).click();
					},3000)
					setTimeout(function(){
						window.lseTourIntervals[1] = setInterval(function(){
							jQuery( '#lse-show-layer-settings' ).click();
						},3000)
					},1500)
				},
				after: function(){
					clearInterval( window.lseTourIntervals[0] );
					clearInterval( window.lseTourIntervals[1] );
				}

			},
			{
				target: 'lse-action-buttons',
				title: 'Save & Publish Buttons',
				content: 'In LayerSlider 7, you can now save drafts without making them public on front-end pages. The save button creates a draft that’s only accessible in the editor. This enables you to freely edit and experiment on projects and publish the changes only when your work is ready.<br><br><b>REMEMBER</b>: Once you want to make your changes visible on front-end pages, you need to press the PUBLISH button.',
				spacing: 1
			},
			{
				target: 'lse-layers-list lse-sidebar-head lse-options',
				title: 'Customize Editor Layout',
				content: 'The project editor allows you to customize its user interface to your needs. Different panels can be closed, rearranged, or resized to fit your preference and screen space. You can find these controls at the top of each panel.',
				cover: 'https://layerslider.com/media/guides/welcome/layouts.png',
				spacing: 10,
				shape: 1,
				width: 760,
				before: function(){
					jQuery( '.g-modal-size' ).attr( 'data-step', 'layouts' );
				}
			},
			{
				target: '#lse-layers-extra-settings',
				title: 'Workspace Settings',
				content: 'There are lots of workspace settings you can choose from. The most important ones have their dedicated buttons down here for easy access. These include highlighting layers, snapping, bringing selected layers to the front, and controlling workspace overflow.<br><br>You can also right-click at many places to access the context menu offering even more options. On the right sidebar, you have options like expanding or collapsing sections. Inside the preview area, you can access layer actions such as adding, removing, aligning layers, among others. Right-clicking on the workspace area outside of the preview reveals options like showing or hiding the rulers.',
				spacing: 1
			},
			{
				target: '#lse-toolbar-extras',
				title: 'More Handy Tools',
				content: 'For a distraction-free editing experience, you can enter fullscreen mode. The search functionality is also there to find or quickly access settings and perform common actions like saving your project. The ellipsis menu contains more resources like Keyboard Shortcuts and instructions on embedding projects on your front-end pages. If you ever need help, just click on the questions mark.',
				spacing: 1
			},
			{
				target: '#lse-brand',
				title: 'Exit to WordPress Dashboard',
				content: 'Once you’d like to exit the editor, just click on the LAYERSLIDER7 button to return to your WordPress dashboard.',
				spacing: 1
			}
		]
	}
};