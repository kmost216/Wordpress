<?php

	// Prevent direct file access
	defined( 'LS_ROOT_FILE' ) || exit;

	// Attempt to avoid memory limit issues
	@ini_set( 'memory_limit', apply_filters( 'admin_memory_limit', WP_MAX_MEMORY_LIMIT ) );

	$userID = get_current_user_id();

	// Get the ID of the slider
	$id = (int) $_GET['id'];

	// Get slider

	$sliderItem = LS_Sliders::find( $id );
	$slider 	= $sliderItem['data'];

	$sliderDraft = LS_Sliders::getDraft( $id );

	if( ! isset( $_GET['ignore-drafts'] ) ) {

		if( ! empty( $sliderDraft['data'] ) ) {
			$slider = $sliderDraft['data'];
			$lsSliderDraftLoaded = true;
		}
	}

	$slider = ls_normalize_slider_data( $slider );

	// Redirect back to the slider list if the slider cannot be found
	// or it is malformed or a group item.
	//
	// Using <script> tag since headers are already sent out at this point.
	if( empty( $slider ) || ! empty( $sliderItem['flag_group'] ) ){
		die('<script>window.location.href = "'.admin_url('admin.php?page=layerslider').'";</script>');
	}

	// License registration
	$lsActivated = LS_Config::isActivatedSite();

	// Get DOM utils
	if( ! class_exists('\LayerSlider\DOM') ) {
		require_once LS_ROOT_PATH.'/classes/class.ls.dom.php';
	}

	// Get defaults
	include LS_ROOT_PATH . '/config/defaults.php';
	include LS_ROOT_PATH . '/classes/class.ls.modules.php';

	$moduleManager = new LS_Modules;
	$modules = $moduleManager->getAllModuleData();

	// Run filters
	if( has_filter( 'layerslider_override_defaults' ) ) {
		$newDefaults = apply_filters( 'layerslider_override_defaults', $lsDefaults );
		if( ! empty( $newDefaults ) && is_array( $newDefaults ) ) {
			$lsDefaults = $newDefaults;
			unset($newDefaults);
		}
	}

	// Get global Google Fonts
	$googleFonts = get_option('ls-google-fonts', [] );
	$googleFontsEnabled = (int) get_option('layerslider-google-fonts-enabled', true);

	// Get post types
	$postTypes = LS_Posts::getPostTypes();
	$postCategories = get_categories();
	$postTags = get_tags();
	$postTaxonomies = get_taxonomies( ['_builtin' => false ], 'objects');


	// Editor Settings
	$editorSettings = get_user_meta( $userID, 'ls-editor-settings', true );
	$editorSettings = json_decode( $editorSettings, true );
	$editorSettings = ! empty( $editorSettings ) ? $editorSettings : [];
	$editorSettings = array_merge([
		'showTooltips' 			=> true,
		'useKeyboardShortcuts' 	=> true
	], $editorSettings );

	wp_localize_script('ls-project-editor', 'LS_editorSettings', $editorSettings );


	// Editor Modules
	wp_localize_script('ls-project-editor', 'LS_editorModules', $modules);

	// Editor Meta
	wp_localize_script('ls-project-editor', 'LS_editorMeta', [
		'isActivatedSite' 		=> $lsActivated,
		'googleFontsEnabled' 	=> (bool) $googleFontsEnabled,
		'editorSettingsNonce' 	=> wp_create_nonce('ls-save-editor-settings'),
		'exportURL' 			=> wp_nonce_url( admin_url('admin.php?page=layerslider&action=export&id='.$id.''), 'export-sliders' )
	]);

	// Layer type icons
	wp_localize_script('ls-project-editor', 'LS_InterfaceIcons', [
		'layerTypes' => [
			'img' 			=> lsGetSVGIcon('image-polaroid', 'regular'),
			'text' 			=> lsGetSVGIcon('align-left'),
			'media' 		=> lsGetSVGIcon('play-circle'),
			'button' 		=> lsGetSVGIcon('dot-circle'),
			'icon' 			=> lsGetSVGIcon('icons'),
			'shape' 		=> lsGetSVGIcon('shapes'),
			'svg' 			=> lsGetSVGIcon('stars'),
			'html' 			=> lsGetSVGIcon('code'),
			'post' 			=> lsGetSVGIcon('database'),
			'import' 		=> lsGetSVGIcon('file-import')
		],

		'notifications' => [
			'save' 				=> lsGetSVGIcon('save'),
			'check' 			=> lsGetSVGIcon('check'),
			'camera' 			=> lsGetSVGIcon('camera'),
			'images' 			=> lsGetSVGIcon('images'),
			'upload' 			=> lsGetSVGIcon('cloud-upload-alt'),
			'font-case' 		=> lsGetSVGIcon('font-case'),
			'window-maximize' 	=> lsGetSVGIcon('window-maximize', 'regular')
		],

		'search' 		=> [

			'circle' 		=> lsGetSVGIcon('circle', 'regular'),
			'fullscreen' 	=> lsGetSVGIcon('expand-alt'),
			'clone' 		=> lsGetSVGIcon('clone'),
			'eye' 			=> lsGetSVGIcon('eye'),
			'trash' 		=> lsGetSVGIcon('trash-alt'),
			'camera' 		=> lsGetSVGIcon('camera'),
			'undo' 			=> lsGetSVGIcon('undo-alt'),
			'redo' 			=> lsGetSVGIcon('redo-alt'),
			'film' 			=> lsGetSVGIcon('film'),
			'lock' 			=> lsGetSVGIcon('lock'),
			'copy' 			=> lsGetSVGIcon('copy'),
			'clipboard' 	=> lsGetSVGIcon('clipboard'),
			'plus' 			=> lsGetSVGIcon('plus'),
			'cog' 			=> lsGetSVGIcon('cog'),
			'save' 			=> lsGetSVGIcon('save'),
			'publish' 		=> lsGetSVGIcon('cloud-upload-alt'),
			'wrench' 		=> lsGetSVGIcon('wrench'),
			'retweet' 		=> lsGetSVGIcon('retweet'),
			'globe' 		=> lsGetSVGIcon('globe-americas'),
			'book' 			=> lsGetSVGIcon('book'),
			'help' 			=> lsGetSVGIcon('question-circle'),
			'export' 		=> lsGetSVGIcon('file-export'),
			'history' 		=> lsGetSVGIcon('history'),
			'keyboard' 		=> lsGetSVGIcon('keyboard'),
			'facebook' 		=> lsGetSVGIcon('facebook-f', 'brands'),
			'twitter' 		=> lsGetSVGIcon('twitter', 'brands'),
			'youtube' 		=> lsGetSVGIcon('youtube', 'brands'),
			'chevronRight' 	=> lsGetSVGIcon('chevron-right')


		]
	]);

	include LS_ROOT_PATH . '/includes/ls_global.php';

	// Load project-spefici Google Fonts
	if( $googleFontsEnabled && ! empty( $slider['googlefonts'] ) && is_array( $slider['googlefonts'] ) ) {
		$fontFragments = [];
		foreach( $slider['googlefonts'] as $font ) {
			$fontParams = explode(':', $font['param']);
			$fontName 	= urlencode( urldecode( $fontParams[0] ) );
			$fontFragments[] = $fontName.':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
		}
		$fontsURL = implode('%7C', $fontFragments);

		echo '<link href="https://fonts.googleapis.com/css?family='.$fontsURL.'" rel="stylesheet">';
	}

	// Editor state classes
	$lseEditorClasses = [];

	if( (int) $sliderItem['flag_dirty'] && ! isset( $_GET['ignore-drafts'] ) ) {
		$lseEditorClasses[] = 'lse-slider-is-dirty';
	}

	if( isset( $_GET['ignore-drafts'] ) && ! empty( $sliderDraft['data'] ) ) {
		$lseEditorClasses[] = 'lse-editor-is-dirty';
		$lseEditorClasses[] = 'lse-draft-available';
		$lseEditorClasses[] = 'lse-menu-more-badge';
	}

	if( (int) $sliderItem['flag_dirty'] && ! empty( $lsSliderDraftLoaded ) ) {
		$lseEditorClasses[] = 'lse-draft-edit';
		//$lseEditorClasses[] = 'lse-menu-more-badge';
	}

	$lseEditorClasses = implode(' ', $lseEditorClasses);
?>

<form method="post" id="lse-editor-form" novalidate="novalidate" autocomplete="off">

	<lse-warning id="lse-warning">

		<!-- Old Browser Warning -->
		<lse-b class="lse-warning-old-browser">
			<!-- Icon -->
			<?= lsGetSVGIcon('exclamation-triangle') ?>
			<!-- Title -->
			<lse-p class="lse-warning-title">
				<?= __('Incompatible Browser Detected', 'LayerSlider') ?>
			</lse-p>
			<!-- Text -->
			<lse-p class="lse-warning-text">
				<?= __('We are sorry, but the LayerSlider 7 Editor cannot be loaded in your current web browser. We recommend you to use the latest version of Edge, Firefox, Chrome, or Safari. You can try to load the editor anyway if you believe this is a false detection.', 'LayerSlider') ?>
			</lse-p>
			<!-- Button -->
			<lse-p class="lse-warning-button lse-tac">
				<lse-button>
					<lse-text><?= __('Load Editor Anyway', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('arrow-right',false,['class' => 'lse-it-fix']) ?>
				</lse-button>
			</lse-p>
		</lse-b>

	</lse-warning>

	<script>

		function LSE_browserTests() {

			try {
				var storage = window.localStorage;
				var x = '__storage_test__';
				storage.setItem(x, x);
				storage.removeItem(x);
			} catch(e) {
				return false;
			}

			try {
				eval('"use strict"; let xxyyzz32124361');
			} catch (e) {
				return false;
			}

			try {
				eval('"use strict"; () => {}');
			} catch (e) {
				return false;
			}

			var testzyx = {};
			try {
				eval('"use strict"; var zyx987zz = testzyx?.prop1zyx?.prop2zyx;')
			} catch (e) {
				return false
	  		}

			try {
				eval('"use strict"; class Xxyyzz32124361 {}');
			} catch (e) {
				return false;
			}

			// try {
			// 	eval('"use strict"; try { import("xxyyzz32124361").catch(() => {}); } catch (e) { }');
			// } catch (e) {
			// 	return false;
			// }

			return true;
		}

		if( ! LSE_browserTests() ) {
			var warningElement = document.getElementById('lse-warning');

			warningElement.className += ' lse-visible lse-warning-old-browser';
			document.body.appendChild( warningElement );
		}
	</script>

	<lse-dropzone-overlay></lse-dropzone-overlay>
	<lse-dropzone></lse-dropzone>

	<?php include LS_ROOT_PATH . '/templates/tmpl-post-options.php'; ?>

	<lse-editor class="lse-editor-is-loading lse-layers-list-docked lse-highlight-layers lse-selection-is-on-front lse-desktop-view <?= $lseEditorClasses ?>">

		<input type="hidden" name="slider_id" value="<?= $id ?>">
		<input type="hidden" name="action" value="ls_save_slider">
		<?php wp_nonce_field('ls-save-slider-' . $id); ?>

		<lse-overlay id="lse-loading" data-original-loading-text="<?= __('loading', 'LayerSlider') ?>">
			<lse-loading-indicator></lse-loading-indicator>
		</lse-overlay>

		<lse-main-frame>

			<lse-top-frame>

				<!-- class="lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-navbar" -->
				<lse-navbar class="lse-toolbar">

					<lse-button-group id="lse-toolbar-primary">
						<lse-submenu-wrapper>
				 			<a class="lse-button" id="lse-brand" href="<?= admin_url('admin.php?page=layerslider') ?>">L<span class="lse-wide">ayer</span>S<span class="lse-wide">lider</span><span class="lse-highlight">7</span></a>
							<lse-submenu>

								<?php if( ! $lsActivated ) : ?>
								<a class="lse-button lse-bg-unregistered lse-premium-menu-button">
									<?= lsGetSVGIcon('lock') ?>
									<lse-text><?= __('Unregistered', 'LayerSlider') ?></lse-text>
								</a>
								<?php endif ?>
								<a class="lse-button" href="<?= admin_url('admin.php?page=layerslider') ?>">
									<?= lsGetSVGIcon('layer-group') ?>
									<lse-text>
										<?= __('My Projects', 'LayerSlider') ?>
									</lse-text>
								</a>
								<a class="lse-button" href="<?= admin_url('/') ?>">
									<?= lsGetSVGIcon('wordpress','brands') ?>
									<lse-text>
										<?= __('WP Dashboard', 'LayerSlider') ?>
									</lse-text>
								</a>
							</lse-submenu>
						</lse-submenu-wrapper>
						<lse-button id="lse-show-project-settings">
							<?= lsGetSVGIcon('cog') ?>
							<lse-text><span class="lse-not-wide"><?= __('Project', 'LayerSlider') ?></span><span class="lse-wide"><?= __('Project Settings', 'LayerSlider') ?></span></lse-text>
						</lse-button>
						<lse-button id="lse-show-slides-list" class="lse-can-be-activated">
							<?= lsGetSVGIcon('images') ?>
							<lse-text><span class="lse-not-wide"><?= __('Slides', 'LayerSlider') ?></span><span class="lse-wide"><?= __('Slides List', 'LayerSlider') ?></span></lse-text>
							<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open lse-it-0']) ?>
							<?= lsGetSVGIcon('times',false,['class' => 'lse-close']) ?>
						</lse-button>
						<lse-submenu-wrapper id="lse-preview">
							<lse-button class="lse-exit-preview">
								<?= lsGetSVGIcon('play-circle') ?>
								<lse-text class="lse-wide"><?= __('Preview', 'LayerSlider') ?></lse-text>
								<?= lsGetSVGIcon('times',false,['class' => 'lse-close']) ?>
							</lse-button>
							<lse-submenu class="lse-has-shortcut">
								<lse-button class="lse-toggle-slide-preview">
									<?= lsGetSVGIcon('image') ?>
									<lse-text>
										<?= __('Slide', 'LayerSlider') ?>
									</lse-text>
									<kbd>
										<kbd><?= _x('SPACE', 'Space bar key on keyboard', 'LayerSlider') ?></kbd>
									</kbd>
								</lse-button>
								<lse-button class="lse-toggle-layer-preview">
									<?= lsGetSVGIcon('bring-forward') ?>
									<lse-text>
										<?= __('Layer', 'LayerSlider') ?>
									</lse-text>
									<kbd>
										<kbd>&#8679;</kbd> <kbd><?= _x('SPACE', 'Space bar key on keyboard', 'LayerSlider') ?></kbd>
									</kbd>
								</lse-button>
								<lse-button class="lse-toggle-timeline-view">
									<?= lsGetSVGIcon('stream','regular') ?>
									<lse-text><?= __('Timeline', 'LayerSlider') ?></lse-text>
								</lse-button>
								<lse-button class="lse-toggle-project-preview">
									<?= lsGetSVGIcon('window-maximize', 'regular') ?>
									<lse-text><?= __('Project', 'LayerSlider') ?></lse-text>
								</lse-button>
							</lse-submenu>
						</lse-submenu-wrapper>
						<lse-submenu-wrapper id="lse-zoom-menu">
							<lse-button class="lse-not-wide">
							<?= lsGetSVGIcon('search-plus') ?>
							</lse-button>
							<lse-button class="lse-wide">
							<?= lsGetSVGIcon('search-plus') ?>
							<lse-text><?= __('Zoom', 'LayerSlider') ?></lse-text>
							</lse-button>
							<lse-submenu class="lse-horizontal">
								<lse-grid class="lse-form-elements lse-darker-theme">
									<lse-row>
										<lse-col class="lse-full">
											<lse-ib class="lse-2-1 lse-range-inputs">
												<input class="lse-zoom-range lse-small" type="range" min="50" max="200" value="100" step="5">
												<input class="lse-zoom-input" type="number" min="50" max="200" value="100" step="5"><lse-unit>%</lse-unit>
											</lse-ib>
										</lse-col>
									</lse-row>
								</lse-grid>
							</lse-submenu>
						</lse-submenu-wrapper>
						<lse-button class="lse-zoom-1 lse-b-0 lse-active-text" data-tt><?= lsGetSVGIcon('expand') ?></lse-button>
						<lse-tt>
							<?= __('100%', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>0</kbd>
							</kbd>
						</lse-tt>
						<lse-button class="lse-zoom-fit lse-active-text" data-tt><?= lsGetSVGIcon('expand-arrows-alt') ?></lse-button>
						<lse-tt>
							<?= __('Zoom to fit', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>9</kbd>
							</kbd>
							</lse-tt>

						<lse-submenu-wrapper id="lse-history-menu">
							<lse-button id="lse-history">
								<?= lsGetSVGIcon('history') ?>
								<lse-text class="lse-wide">
									<?= __('History', 'LayerSlider') ?>
								</lse-text>
							</lse-button>

							<lse-submenu>
								<lse-wrapper>
									<lse-button class="lse-toggle-revisions">
										<?= lsGetSVGIcon('repeat-alt') ?>
										<lse-text><?= __('Revisions', 'LayerSlider') ?></lse-text>
									</lse-button>
									<lse-separator></lse-separator>
									<lse-text><?= __('History List:', 'LayerSlider') ?></lse-text>
								</lse-wrapper>
								<lse-wrapper id="lse-history-list" class="lse-scrollbar lse-scrollbar-light">
									<lse-button class="lse-protected">
										<?= lsGetSVGIcon('folder-open') ?>
										<lse-text><?= __('Slide Open', 'LayerSlider') ?></lse-text>
									</lse-button>
								</lse-wrapper>
							</lse-submenu>
						</lse-submenu-wrapper>

						<lse-button id="lse-history-undo" class="lse-b-0 lse-active-text lse-wider" data-tt><?= lsGetSVGIcon('undo-alt') ?></lse-button>
						<lse-tt>
							<?= __('Undo', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>Z</kbd>
							</kbd>
							</lse-tt>
						<lse-button id="lse-history-redo" class="lse-active-text lse-wider" data-tt><?= lsGetSVGIcon('redo-alt') ?></lse-button>
						<lse-tt>
							<?= __('Redo', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>Y</kbd>
							</kbd>
						</lse-tt>

						<lse-submenu-wrapper id="lse-change-device-view">
							<lse-button class="lse-changed-by-submenu lse-icons-only">
								<?= lsGetSVGIcon('desktop',false,['class' => 'lse-active']) ?>
								<?= lsGetSVGIcon('tablet-alt') ?>
								<?= lsGetSVGIcon('mobile-alt') ?>
							</lse-button>
							<lse-submenu class="lse-pos-from-center">
								<lse-button class="lse-active" data-editor-class="lse-desktop-view" data-type="desktop">
									<?= lsGetSVGIcon('desktop') ?>
									<lse-text><?= __('Desktop View', 'LayerSlider') ?></lse-text>
								</lse-button>
								<lse-button data-editor-class="lse-tablet-view" data-type="tablet">
									<?= lsGetSVGIcon('tablet-alt') ?>
									<lse-text><?= __('Tablet View', 'LayerSlider') ?></lse-text>
								</lse-button>
								<lse-button data-editor-class="lse-mobile-view" data-type="phone">
									<?= lsGetSVGIcon('mobile-alt') ?>
									<lse-text><?= __('Mobile View', 'LayerSlider') ?></lse-text>
								</lse-button>
							</lse-submenu>
						</lse-submenu-wrapper>

						<lse-wrapper id="lse-make-project-scrollable-wrapper" data-tt data-tt-de="0">
							<label class="lse-label">
								<label class="ls-switch lse-small"><input id="lse-make-project-scrollable" type="checkbox"><ls-switch></ls-switch></label>
								<lse-text><?= __('Enable scrolling', 'LayerSlider') ?></lse-text>
							</label>
						</lse-wrapper>
						<lse-tt><?= __('Increases screen height to test parallax effect by scrolling.', 'LayerSlider') ?></lse-tt>

					</lse-button-group>

					<lse-button-group id="lse-toolbar-middle">
					</lse-button-group>

					<lse-button-group id="lse-toolbar-extras" class="lse-icons-only">
						<a href="https://layerslider.com/help" class="lse-button" target="_blank">
							<?= lsGetSVGIcon('question') ?>
						</a>
						<lse-button class="lse-open-search-window" data-tt>
							<?= lsGetSVGIcon('search') ?>
						</lse-button>
						<lse-tt>
							<?= __('Search ', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>E</kbd>
							</kbd>
						</lse-tt>
						<lse-button id="lse-toggle-fullscreen" data-tt>
							<?= lsGetSVGIcon('expand-alt',false,['class' => 'lse-open']) ?>
							<?= lsGetSVGIcon('compress-alt',false,['class' => 'lse-close']) ?>
						</lse-button>
						<lse-tt>
							<?= __('Full screen', 'LayerSlider') ?>
							<kbd>
								<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>F</kbd>
							</kbd>
						</lse-tt>
						<lse-submenu-wrapper class="lse-show-on-click lse-has-overlay" id="lse-ellipsis-opener" data-callback="ellipsis">
							<lse-button>
								<?= lsGetSVGIcon('ellipsis-v',false,['class' => 'lse-open']) ?>
								<?= lsGetSVGIcon('times',false,['class' => 'lse-close']) ?>
							</lse-button>
							<lse-submenu class="lse-pos-from-right lse-stop-click-prop">

								<lse-slide-menu id="lse-ellipsis-menu" class="lse-reset-on-close">
									<lse-slide-menu-style-wrapper>
										<lse-slide-menu-inner>

											<lse-slide-menu-wrapper>
												<lse-slide-menu-holder class="lse-visible">

													<lse-wrapper class="lse-notice lse-draft-notice">
														<lse-text>
															<?= __('You’re currently editing a saved draft. You can publish it when it’s ready, or discard the changes and revert it back to the original.', 'LayerSlider') ?>
														</lse-text>
														<lse-p class="lse-tac">
															<a class="lse-button" href="<?= admin_url('admin.php?page=layerslider&action=edit&id='.$id.'&ignore-drafts') ?>">
																<?= lsGetSVGIcon('history') ?>
																<ls-button-text><?= __('Revert back to original', 'LayerSlider') ?></ls-button-text>
															</a>
														</lse-p>
													</lse-wrapper>

													<lse-wrapper class="lse-notice lse-draft-available-notice">
														<lse-text>
															<?= __('A draft is available for this project that contains unpublished changes.', 'LayerSlider') ?>
														</lse-text>
														<lse-p class="lse-tac">
															<a class="lse-button" href="<?= admin_url('admin.php?page=layerslider&action=edit&id='.$id) ?>">
															<?= lsGetSVGIcon('history') ?>
															<ls-button-text><?= __('Revert back to draft', 'LayerSlider') ?></ls-button-text>
														</a>
														</lse-p>
													</lse-wrapper>

													<lse-button data-slide-to="next" data-index="1" data-name="interfaceSettings">
														<?= lsGetSVGIcon('cog') ?>
														<lse-text><?= __('Interface Settings', 'LayerSlider') ?></lse-text>
														<?= lsGetSVGIcon('chevron-right', null, ['class' => 'ls-menu-arrow']) ?>
													</lse-button>

													<lse-button data-slide-to="next" data-index="2" data-name="interactiveGuides">
														<?= lsGetSVGIcon('book') ?>
														<lse-text><?= __('Interactive Guides', 'LayerSlider') ?></lse-text>
														<?= lsGetSVGIcon('chevron-right', null, ['class' => 'ls-menu-arrow']) ?>
													</lse-button>

													<lse-separator></lse-separator>

													<?php if( strpos( LS_PLUGIN_VERSION, 'b' ) !== false || strpos( LS_PLUGIN_VERSION, 'a' ) !== false) : ?>
													<a class="lse-button" href="mailto:support@kreaturamedia.com?subject=LayerSlider (v<?= LS_PLUGIN_VERSION ?>) Feedback">
														<lse-ib>
															<?= lsGetSVGIcon('bullhorn',false,['class' => 'lse-top-0']) ?>
															<lse-text><?= __('Give Feedback', 'LayerSlider') ?></lse-text>

														</lse-ib>
														<lse-text><?= __('Help us improve LayerSlider.', 'LayerSlider') ?></lse-text>
													</a>

													<lse-separator></lse-separator>
													<?php endif ?>

													<lse-button class="lse-toggle-revisions">
														<lse-ib>
															<?= lsGetSVGIcon('repeat-alt') ?>
															<lse-text><?= __('Revisions', 'LayerSlider') ?></lse-text>
														</lse-ib>
														<lse-text><?= __('Browse earlier versions.', 'LayerSlider') ?></lse-text>
													</lse-button>

													<lse-button class="lse-open-keyboard-shortcuts">
														<lse-ib>
															<?= lsGetSVGIcon('keyboard') ?>
															<lse-text><?= __('Keyboard Shortcuts', 'LayerSlider') ?></lse-text>
														</lse-ib>
														<lse-text><?= __('Boost your productivity.', 'LayerSlider') ?></lse-text>
													</lse-button>

													<lse-button class="lse-open-embed-modal">
														<lse-ib>
															<?= lsGetSVGIcon('plus') ?>
															<lse-text><?= __('How To Embed', 'LayerSlider') ?></lse-text>
														</lse-ib>
														<lse-text><?= __('Insert LayerSlider to pages.', 'LayerSlider') ?></lse-text>
													</lse-button>

													<a class="lse-button" href="https://layerslider.com/help/" target="_blank">
														<lse-ib>
															<?= lsGetSVGIcon('question-circle') ?>
															<lse-text><?= __('Get Help', 'LayerSlider') ?></lse-text>
														</lse-ib>
														<lse-text><?= __('FAQs, documentation, and more.', 'LayerSlider') ?></lse-text>
													</a>

												</lse-slide-menu-holder>
											</lse-slide-menu-wrapper>

											<lse-slide-menu-wrapper>

												<lse-slide-menu-holder>

													<lse-slide-menu-header>
														<?= lsGetSVGIcon('arrow-left', null, ['class' => 'lse-slide-menu-nav-back lse-can-be-hovered']) ?>
														<lse-text>
															<?= __('Interface Settings', 'LayerSlider') ?>
														</lse-text>
													</lse-slide-menu-header>

													<lse-separator></lse-separator>

													<lse-slide-menu-item>

														<?= lsGetSVGIcon('keyboard') ?>
														<lse-text><?= __('Keyboard Shortcuts', 'LayerSlider') ?></lse-text>
														<?= lsGetSwitchControl([
															'name' => 'useKeyboardShortcuts',
															'checked' => ! empty( $editorSettings['useKeyboardShortcuts'] )
														],[
															'class' => 'lse-small'
														]) ?>

													</lse-slide-menu-item>

													<lse-slide-menu-item>

														<?= lsGetSVGIcon('comment-alt') ?>
														<lse-text><?= __('Tooltips', 'LayerSlider') ?></lse-text>
														<?= lsGetSwitchControl([
															'name' => 'showTooltips',
															'checked' => ! empty( $editorSettings['showTooltips'] )
														],[
															'class' => 'lse-small'
														]) ?>

													</lse-slide-menu-item>

												</lse-slide-menu-holder>

												<lse-slide-menu-holder data-tour-url="<?= LS_ROOT_URL . '/static/admin/js/ls-tours.js' ?>">

													<lse-slide-menu-header>
														<?= lsGetSVGIcon('arrow-left', null, ['class' => 'lse-slide-menu-nav-back lse-can-be-hovered']) ?>
														<lse-text>
															<?= __('Interactive Guides', 'LayerSlider') ?>
														</lse-text>
													</lse-slide-menu-header>

													<lse-separator></lse-separator>

													<lse-button data-tour="interfaceWalkthrough">
														<lse-ib>
															<?= lsGetSVGIcon('file') ?>
															<lse-text><?= __('Interface Walkthrough', 'LayerSlider') ?></lse-text>
														</lse-ib>
													</lse-button>

													<!-- <lse-button>
														<lse-ib>
															<lse-text><?= __('Interactive Guides are coming soon.', 'LayerSlider') ?></lse-text>
														</lse-ib>
													</lse-button> -->

												</lse-slide-menu-holder>

											</lse-slide-menu-wrapper>

										</lse-slide-menu-inner>
									</lse-slide-menu-style-wrapper>
								</lse-slide-menu>
							</lse-submenu>
						</lse-submenu-wrapper>
					</lse-button-group>

					<lse-button-group id="lse-revisions-settings">
						<input type="hidden" name="action" value="ls_save_revisions_options">
						<?php wp_nonce_field('ls-save-revisions-options'); ?>
						<lse-submenu-wrapper class="lse-show-on-click">
							<lse-button>
								<?= lsGetSVGIcon('cog') ?>
								<lse-text><?= __('Revisions Settings', 'LayerSlider') ?></lse-text>
								<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open lse-it-0']) ?>
								<?= lsGetSVGIcon('times',false,['class' => 'lse-close']) ?>
							</lse-button>
							<lse-submenu class="lse-pos-from-right lse-stop-click-prop">
								<lse-grid class="lse-form-elements lse-darker-theme">
									<lse-row>
										<lse-col class="lse-3-1">
											<lse-ib>
												<lse-text>
													<?= __('Revisions per project', 'LayerSlider') ?>
												</lse-text>
											</lse-ib>
											<lse-ib>
												<input type="number" name="ls-revisions-limit" value="<?= LS_Revisions::$limit ?>">
											</lse-ib>
										</lse-col>
										<lse-col class="lse-3-1">
											<lse-ib>
												<lse-text>
													<?= __('Create revisions after', 'LayerSlider') ?>
												</lse-text>
											</lse-ib>
											<lse-ib>
												<input type="number" name="ls-revisions-interval" value="<?= LS_Revisions::$interval ?>"><lse-unit><?= __('min', 'LayerSlider') ?></lse-unit>
											</lse-ib>
										</lse-col>
									</lse-row>
								</lse-grid>
							</lse-submenu>
						</lse-submenu-wrapper>
					</lse-button-group>

					<lse-button-group class="lse-exit-timeline-view">
						<lse-button class="lse-active">
							<lse-text><?= __('Exit Timeline View', 'LayerSlider' ) ?></lse-text><?= lsGetSVGIcon('times') ?>
						</lse-button>
					</lse-button-group>
					<lse-button-group class="lse-exit-revisions">
						<lse-button class="lse-active">
							<lse-text><?= __('Exit Revisions', 'LayerSlider' ) ?></lse-text><?= lsGetSVGIcon('times') ?>
						</lse-button>
					</lse-button-group>
					<lse-button-group class="lse-exit-project-view">
						<lse-button class="lse-active">
							<lse-text><?= __('Exit Project View', 'LayerSlider' ) ?></lse-text><?= lsGetSVGIcon('times') ?>
						</lse-button>
					</lse-button-group>
					<lse-button-group id="lse-toolbar-sidebar-tabs" class="lse-tabs" data-tabs-for="lse-right-frame lse-sidebars-holder" data-for-editor="active-right-sidebar" data-update-workspace>
						<lse-button id="lse-show-slide-settings" class="lse-active" data-for-editor="slide-settings">
							<?= lsGetSVGIcon('image',false,['class' => 'lse-ultrawide']) ?>
							<lse-text class="lse-ultrawide">
									<?= __('Slide Settings', 'LayerSlider') ?>
							</lse-text>
							<lse-text class="lse-not-ultrawide">
								<span class=><?= __('Slide', 'LayerSlider' ) ?>
							</lse-text>
							<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-it-0 lse-close']) ?>
						</lse-button>
						<lse-button id="lse-show-layer-settings" data-for-editor="layer-settings">
							<?= lsGetSVGIcon('layer-group','duotone',['class' => 'lse-ultrawide']) ?>
							<lse-text class="lse-ultrawide">
									<?= __('Layer Settings', 'LayerSlider') ?>
							</lse-text>
							<lse-text class="lse-not-ultrawide">
								<span class=><?= __('Layers', 'LayerSlider' ) ?>
							</lse-text>
							<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-it-0 lse-close']) ?>
						</lse-button>
						<!-- NAV BTN -->
 					</lse-button-group>

				</lse-navbar>

			</lse-top-frame>


			<lse-main-frame>

				<lse-project-frame>
					<lse-project-aspect-ratio>
						<iframe src="<?= admin_url('admin.php?page=layerslider&action=preview-iframe-html')  ?>" loading="eager" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" id="lse-project-preview"></iframe>
					</lse-project-aspect-ratio>
				</lse-project-frame>

				<lse-left-frame>

					<lse-sidebar>

						<lse-sidebar-inner>

							<lse-layers-list class="lse-sidebar ls-tabs">

								<lse-sidebar-head>
									<?= lsGetSVGIcon('layer-group') ?>
									<lse-text><?= __('Layers List', 'LayerSlider') ?></lse-text>
									<lse-options>
										<?= lsGetSVGIcon('arrow-to-left',false,[
											'data-lse-action' => 'positionLayersList',
											'id' => 'lse-action-position-layers-list',
											'class' => 'lse-no-toggle',
											'data-tt' => '.tt-position-layers-list'
										]) ?>
										<?= lsGetSVGIcon('columns',false,[
											'data-lse-action' => 'dockLayersList',
											'id' => 'lse-action-dock-layers-list',
											'class' => 'lse-active',
											'data-tt' => '.tt-dock-layers-list'
										]) ?>
										<?= lsGetSVGIcon('map-pin',false,[
											'data-lse-action' => 'pinLayersList',
											'id' => 'lse-action-pin-layers-list',
											'class' => 'lse-active',
											'data-tt' => '.tt-pin-layers-list'
										]) ?>
										<?= lsGetSVGIcon('times',false,[
											'id' => 'lse-action-close-layers-list',
											'data-lse-action' => 'closeLayersList',
											'data-tt' => '.tt-close-layers-list'
										]) ?>
									</lse-options>
								</lse-sidebar-head>

								<lse-sidebar-subnav class="lse-jcfs">

									<lse-subnav-item id="lse-add-layer-button" class="lse-no-toggle">
										<?= lsGetSVGIcon('layer-plus') ?>
										<lse-text><?= __('Add Layer', 'LayerSlider') ?></lse-text>
									</lse-subnav-item>

								</lse-sidebar-subnav>

								<lse-sidebar-body>

									<lse-sidebar-content class="lse-scrollbar lse-scrollbar-light">

										<lse-sidebar-section-head>
											<lse-text>
												<?= __('Layers on this slide', 'LayerSlider') ?>
											</lse-text>
										</lse-sidebar-section-head>

										<lse-tt class="tt-layer-visibility">
											<?= __('Toggle layer visibility', 'LayerSlider') ?>
										</lse-tt>
										<lse-tt class="tt-layer-lock">
											<?= __('Lock / Unlock layer', 'LayerSlider') ?>
										</lse-tt>
										<lse-tt class="tt-layer-duplicate">
											<?= __('Duplicate layer', 'LayerSlider') ?>
											<kbd>
												<kbd class="ls-mac-key">⌘</kbd><kbd class="ls-win-key">⌃</kbd><kbd>D</kbd>
											</kbd>
										</lse-tt>
										<lse-tt class="tt-layer-remove">
											<?= __('Remove layer', 'LayerSlider') ?>
											<kbd>
												<kbd>&#9003;</kbd>
											</kbd>
										</lse-tt>

										<lse-sidebar-section-body class="lse-mv-0">

											<div class="lse-layers-list-wrapper lse-inputs-dblclick">

												<lse-ul id="lse-layers-list" class="lse-layers-list lse-layer-sortable ui-sortable">

												</lse-ul>

												<ls-b class="lse-no-layers-notification">
													<lse-b><?= __('This slide has no layers.') ?></lse-b>
													<lse-b><?= __('Click ADD LAYER to add your first layer.') ?></lse-b>
												</ls-b>

											</div>

										</lse-sidebar-section-body>

										<lse-sidebar-section-head class="lse-static-layers-head">
											<lse-text>
												<?= __('Static layers from other slides', 'LayerSlider') ?>
											</lse-text>
										</lse-sidebar-section-head>
										<lse-sidebar-section-body class="lse-mv-0">

											<div class="lse-layers-list-wrapper lse-inputs-dblclick">

												<lse-ul id="lse-static-layers-list" class="lse-static-layers lse-layer-sortable ui-sortable">

												</lse-ul>

											</div>

										</lse-sidebar-section-body>

									</lse-sidebar-content>

								</lse-sidebar-body>

								<lse-sidebar-subnav class="lse-jcc" id="lse-layers-extra-settings">

									<?= lsGetSVGIcon('bullseye-pointer','duotone',[
										'class' => 'lse-no-toggle lse-can-be-activated lse-active',
										'data-tt' => '',
										'data-tt-de' => '0',
										'data-lse-action' => 'highlightLayers'
									]) ?>
									<lse-tt><?= __('Highlight layers: Hovering over layers in the layers list and workspace will be highlighted in the editor.', 'LayerSlider') ?></lse-tt>

									<?= lsGetSVGIcon('magnet', 'duotone',[
										'class' => 'lse-no-toggle lse-can-be-activated lse-active',
										'data-tt' => '',
										'data-tt-de' => '0',
										'data-lse-action' => 'layerSnapping'
									]) ?>
									<lse-tt><?= __('Snapping: Easily align layer edges, anchor points, and centers to other editor objects such as layers, ruler guides, etc.', 'LayerSlider') ?></lse-tt>

									<?= lsGetSVGIcon('bring-forward',false,[
										'class' => 'lse-no-toggle lse-can-be-activated lse-active',
										'data-tt' => '',
										'data-tt-de' => '0',
										'data-lse-action' => 'bringSelectionToFront'
									]) ?>
									<lse-tt><?= __('Bring selection to front: Selected layer will always be on top of overlapping layers.', 'LayerSlider') ?></lse-tt>

									<?= lsGetSVGIcon('workspace-overflow','misc',[
										'class' => 'lse-no-toggle lse-can-be-activated lse-active',
										'data-tt' => '',
										'data-tt-de' => '0',
										'data-lse-action' => 'overflowLayers'
									]) ?>
									<lse-tt><?= __('Workspace overflow: Show objects outside of the project canvas.', 'LayerSlider') ?></lse-tt>

								</lse-sidebar-subnav>

							</lse-layers-list>

						</lse-sidebar-inner>

					</lse-sidebar>

				</lse-left-frame>

				<lse-main-frame>

					<lse-top-frame>

						<lse-slides-list class="lse-toolbar">
							<div id="lse-slide-tabs" class="ls-clearfix ui-sortable lse-hide-input-if-not-empty lse-input-style-dark-shadow lse-center-in-inputs lse-scrollbar lse-scrollbar-light">


								<div id="lse-add-slide" class="lse-unsortable lse-slide-controls">
									<div>
										<div class="lse-inner-wrapper">
											<lse-b>
												<?= lsGetSVGIcon('plus') ?>
												<lse-text><?= __('Add New', 'LayerSlider') ?></lse-text>
											</lse-b>
										</div>
									</div>
								</div>
								<div id="lse-import-slide" class="lse-unsortable lse-slide-controls">
									<div>
										<div class="lse-inner-wrapper">
											<lse-b>
												<?= lsGetSVGIcon('file-import') ?>
												<lse-text><?= __('Import', 'LayerSlider') ?></lse-text>
											</lse-b>
										</div>
									</div>
								</div>
							</div>

						</lse-slides-list>

					</lse-top-frame>

					<lse-workspace-frame class="lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-outer-workspace">

						<lse-tiny-note></lse-tiny-note>

						<!-- Notify OSD -->
						<lse-notify-osd>
							<lse-ib class="lse-icon"></lse-ib>
							<lse-ib class="lse-text"></lse-ib>
						</lse-notify-osd>

						<lse-rulers>
							<lse-ruler-wrapper id="lse-ruler-wrapper-h">
								<canvas class="lse-ruler"></canvas>
	 							<lse-pointer-indicator></lse-pointer-indicator>
							</lse-ruler-wrapper>
							<lse-ruler-wrapper id="lse-ruler-wrapper-v">
								<canvas class="lse-ruler"></canvas>
								<lse-pointer-indicator></lse-pointer-indicator>
							</lse-ruler-wrapper>
						</lse-rulers>

			 			<lse-workspace-wrapper class="lse-scrollbar lse-scrollbar-dark">
			 				<lse-stop-overflow-layers>
				 				<lse-workspace-helper>
									<lse-workspace id="lse-workspace">
										<lse-workspace-content>
											<lse-guide class="lse-guides-h">
											</lse-guide>
											<lse-guide class="lse-guides-v">
											</lse-guide>
											<div class="lse-center-line" id="lse-center-h"></div>
											<div class="lse-center-line" id="lse-center-v"></div>
											<lse-preview-wrapper class="lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-preview">
												<lse-fade-outer-layers></lse-fade-outer-layers>
												<lse-preview-area></lse-preview-area>
												<lse-live-preview-area></lse-live-preview-area>
												<lse-layer-highlight></lse-layer-highlight>
												<lse-rotate-selected data-text="<?= __('rotation', 'LayerSlider') ?>" data-alternate-text="<?= __('drag to rotate', 'LayerSlider') ?>" data-rotation="0" id="lse-rotate-selected">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"/></svg>
												</lse-rotate-selected>
												<lse-no-click-area></lse-no-click-area>
												<lse-navigation-area></lse-navigation-area>
											</lse-preview-wrapper>
											<lse-dropzone-highlight>
												<?= lsGetSVGIcon('file-upload') ?>
												<lse-text><?= __('Darg & Drop Images or SVGs', 'LayerSlider') ?></lse-text>
												<?= lsGetSVGIcon('spinner-third', 'duotone', [ 'class' => 'lse-dropzone-p' ]) ?>
												<lse-text class="lse-dropzone-p"><?= __('Processing...', 'LayerSlider') ?></lse-text>
											</lse-dropzone-highlight>
										</lse-workspace-content>
									</lse-workspace>
				 				</lse-workspace-helper>
							</lse-stop-overflow-layers>
						</lse-workspace-wrapper>

						<lse-hidden-wrapper id="for-workspace">
							<lse-transform-helper>
								<lse-transform-marker></lse-transform-marker>
								<lse-transform-origin-marker>
									<lse-transform-origin-radius-marker></lse-transform-origin-radius-marker>
								</lse-transform-origin-marker>
							</lse-transform-helper>
						</lse-hidden-wrapper>

					</lse-workspace-frame>

					<lse-revisions-mask></lse-revisions-mask>
					<lse-revisions-frame class="lse-unselectable">
						<?php wp_nonce_field('ls-revert-slider-' . $id); ?>
						<input type="hidden" name="action" value="ls_revert_slider">
						<input type="hidden" name="slider-id" value="<?= $id ?>">
						<input type="hidden" id="lse-revision-id" name="revision-id">
						<lse-wrapper>
							<input id="lse-revisions-slider" type="range" min="1" max="1" value="1">

							<lse-ib class="lse-half lse-tal">
								<lse-text id="lse-revisions-oldest"></lse-text>
							</lse-ib>
							<lse-ib class="lse-half lse-tar">
								<lse-text>
									<?= __('Now', 'LayerSlider') ?>
								</lse-text>
							</lse-ib>
							<lse-button id="lse-revisions-back-button" class="lse-revisions-jump ">
								<?= lsGetSVGIcon('arrow-left',false,['class' => 'lse-it-fix']) ?>
							</lse-button>
							<lse-ib id="lse-revisions-info" class="lse-tac">
								<lse-b>
									<?= __('Selected revision by', 'LayerSlider') ?> <lse-i id="lse-revision-author"></lse-i>
								</lse-b>
								<lse-b>
									<lse-i id="lse-revisions-time-diff"></lse-i>
									(<lse-i id="lse-revisions-date"></lse-i>)
								</lse-b>
							</lse-ib>
							<lse-button id="lse-revisions-forward-button" class="lse-revisions-jump">
								<?= lsGetSVGIcon('arrow-right',false,['class' => 'lse-it-fix']) ?>
							</lse-button>
							<lse-b class="lse-full lse-tac">
								<lse-button id="lse-revisions-apply-button">
									<?= __('Apply selected revision', 'LayerSlider') ?>
								</lse-button>
							</lse-b>
						</lse-wrapper>
						<lse-wrapper id="lse-show-on-empty-revisions">
							<lse-b class="lse-full lse-tac">
								<?= __('No revisions are available for this project yet. Revisions will be added over time when you make new changes.', 'LayerSlider') ?>
								<br>
								<?= __('You can review Revisions Settings at the top to make sure that snapshots are made frequently.', 'LayerSlider') ?>
							</lse-b>
						</lse-wrapper>
					</lse-revisions-frame>
					<lse-timeline-frame>
						<div id="lse-timeline-resize" class="ui-resizable-handle ui-resizable-n"></div>
						<lse-wrapper data-timeline-for="lse-preview-timeline">
							<div id="lse-timeline-legend">
								<lse-b class="lse-layer-delay-in"><?= __('delay', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-transition-in"><?= __('in', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-transition-out"><?= __('out', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-text-in"><?= __('text in', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-text-out"><?= __('text out', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-loop"><?= __('loop / middle', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-layer-static"><?= __('static', 'LayerSlider') ?></lse-b>
								<lse-b class="lse-over-slide-duration"><?= __('over slide duration', 'LayerSlider') ?></lse-b>
							</div>
							<div id="lse-timeline-layers-list" class="lse-scrollbar lse-scrollbar-invisible">
								<div id="lse-timeline-layers-title">
									<?= __('Layers', 'LayerSlider') ?>
								</div>
								<div id="lse-timeline-layers-list-items">
								</div>
							</div>
							<div id="lse-timeline-scroll-wrapper" class="lse-scrollbar lse-scrollbar-light">
								<div id="lse-timeline-scroll-inner">
									<div id="lse-current-time"></div>
									<div id="lse-timeline-ruler-wrapper">
										<canvas class="lse-ruler"></canvas>
									</div>
									<div id="lse-total-timeline">
									</div>
									<div id="lse-slide-timeline"></div>
								</div>
							</div>
						</lse-wrapper>
					</lse-timeline-frame>

				</lse-main-frame>

				<lse-right-frame class="lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-sidebars">

					<lse-sidebar>

						<lse-sidebar-inner>

							<lse-sidebars-holder>

								<!-- SLIDE SETTINGS -->

								<lse-slide-settings class="lse-sidebar lse-dark-theme">
									<?php
									lsGetInput( $lsDefaults['slides']['postOffset'], null, [ 'type' => 'hidden' ]);
									lsGetInput( $lsDefaults['slides']['3dTransitions'], null, [ 'type' => 'hidden' ]);
									lsGetInput( $lsDefaults['slides']['2dTransitions'], null, [ 'type' => 'hidden' ]);
									lsGetInput( $lsDefaults['slides']['custom3dTransitions'], null, [ 'type' => 'hidden' ]);
									lsGetInput( $lsDefaults['slides']['custom2dTransitions'], null, [ 'type' => 'hidden' ]);
									?>
									<lse-sidebar-head>
										<?= lsGetSVGIcon('image') ?>
										<lse-text class="lse-hide-on-wide-sidebar"><?= __('Slide Settings', 'LayerSlider') ?></lse-text>
										<lse-text class="lse-show-on-wide-sidebar"><?= __('Select slide background, set slide transitions, effects and linking.', 'LayerSlider') ?></lse-text>
										<lse-options>
											<?= lsGetSVGIcon('arrows-alt-h',false,[
												'data-lse-action' => 'wideSidebar',
												'data-tt' => '.tt-expand-sidebar'
											]) ?>
										</lse-options>
									</lse-sidebar-head>

									<lse-sidebar-subnav class="lse-tabs" data-tabs-for="lse-slide-settings" data-tabs-content-filter="lse-sidebar-body">

										<lse-subnav-item class="lse-active">
											<?= lsGetSVGIcon('image') ?>
											<lse-text><?= __('Background', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('wave-sine') ?>
											<lse-text><?= __('Timing & Transition', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('magic','regular') ?>
											<lse-text><?= __('Effects', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('box-open') ?>
											<lse-text><?= __('Content Sources', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('link','regular') ?>
											<lse-text><?= __('Slide Linking', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('calendar-alt','regular') ?>
											<lse-text><?= __('Schedule', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item>
											<?= lsGetSVGIcon('cog') ?>
											<lse-text><?= __('Misc', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>

									</lse-sidebar-subnav>

									<!-- SLIDE BG -->
									<lse-sidebar-body data-section-name="<?= __('Background', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Slide Background', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Image', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-image-input lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-image-input">
																		<lse-image-input class="lse-media-upload lse-bulk-upload lse-slide-image" data-prop="background"  data-search-name="<?= __('Background Image', 'LayerSlider') ?>"></lse-image-input>
																		<?= lsGetSVGIcon('ellipsis-v', null, [
																			'class' => 'lse-options lse-has-left-contextmenu',
																			'data-contextmenu-selector' => '#lse-context-menu-image-input'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="backgroundColor" data-smart-help-title="<?= __('Background Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['slides']['imageColor'], null ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Position', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-alignment lse-max-one lse-toggle-all" data-set-hidden-input-to="align">
																		<lse-button class="lse-active" data-align="0% 0%" data-tt=".tt-align-left-top"></lse-button>
																		<lse-button data-align="50% 0%" data-tt=".tt-align-center-top"></lse-button>
																		<lse-button data-align="100% 0%" data-tt=".tt-align-right-top"></lse-button>
																		<lse-button data-align="0% 50%" data-tt=".tt-align-left-center"></lse-button>
																		<lse-button data-align="50% 50%" data-tt=".tt-align-center-center"></lse-button>
																		<lse-button data-align="100% 50%" data-tt=".tt-align-right-center"></lse-button>
																		<lse-button data-align="0% 100%" data-tt=".tt-align-left-bottom"></lse-button>
																		<lse-button data-align="50% 100%" data-tt=".tt-align-center-bottom"></lse-button>
																		<lse-button data-align="100% 100%" data-tt=".tt-align-right-bottom"></lse-button>
																		<?php lsGetInput( $lsDefaults['slides']['imagePosition'], null, [
																			'type' => 'hidden',
																			'class' => 'lse-restore-prop'
																		]) ?>
																	</lse-fe-wraper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Background Size', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['imageSize'], null ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Slide Thumbnail', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Set Thumbnail', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-image-input lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-image-input">
																		<lse-image-input class="lse-media-upload lse-bulk-upload lse-slide-thumbnail" data-prop="thumbnail" data-search-name="<?= __('Thumbnail', 'LayerSlider') ?>"></lse-image-input>
																		<?= lsGetSVGIcon('ellipsis-v', null, [
																			'class' => 'lse-options lse-has-left-contextmenu',
																			'data-contextmenu-selector' => '#lse-context-menu-image-input'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-capture-slide"><?= __('Capture Slide', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- TIMING & TRANSITION -->
									<lse-sidebar-body data-section-name="<?= __('Timing & Transition', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Slide Timing', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['delay'], null ) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Time shift', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['timeshift'], null ) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Slide Transition', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transition duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['transitionDuration'], null ) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib class="lse-jcc">
																<lse-button class="lse-giant lse-select-transitions" data-search-name="<?= __('Select Transitions', 'LayerSlider') ?>"><?= __('Select Transitions', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-mt-s lse-wide lse-col-notice lse-no-slide-bg-notice">
																<lse-ib>
																	<lse-text>
																		<?= __('Slide transitions won’t be visible until you set a slide background image or color.', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- EFFECTS -->
									<lse-sidebar-body data-section-name="<?= __('Effects', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Ken Burns', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Zoom', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['kenBurnsZoom'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['kenBurnsScale'] ) ?>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['kenBurnsRotate'] ) ?>
																	<lse-unit>deg</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Hover', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>

																	<?php if( ! $lsActivated ) : ?>
																	<?= lsGetSVGIcon('lock',false,[
																		'class' => 'lse-premium lse-premium-lock',
																		'data-tt' => '.tt-premium'
																	] ) ?>
																	<?php endif ?>
																	<lse-text>
																		<?= __('Global hover', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['slides']['globalHover'], null, [], false, [
																		'data-tt' => '.tt-global-hover',
																		'data-tt-de' => 0
																	] ) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide lse-jcc">
																<a href="https://layerslider.com/sliders/global-hover-example/" target="_blank" class="lse-button">
																	<lse-text><?= __('See it in action', 'LayerSlider') ?></lse-text>
																</a>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Parallax Defaults', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Type', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['parallaxType'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Event', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['parallaxEvent'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Axes', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['parallaxAxis'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Distance', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxdistance" data-smart-help-title="<?= __('Parallax Distance', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['parallaxDistance'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxrotation" data-smart-help-title="<?= __('Parallax Rotation', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['parallaxRotate'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Move Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxmoveduration" data-smart-help-title="<?= __('Move Duration', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['parallaxDurationMove'] ) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Leave Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxleaveduration" data-smart-help-title="<?= __('Leave Duration', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['parallaxDurationLeave'] ) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?> "data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['slides']['parallaxTransformOrigin'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['parallaxPerspective'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>


											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- CONTENT SOURCES -->
									<lse-sidebar-body data-section-name="<?= __('Content Sources', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Content Sources', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib class="lse-half lse-jcc">
																	<lse-button data-search-name="<?= __('Configure Post Options', 'LayerSlider') ?>" class="lse-giant lse-aic lse-configure-post-options">
																		<?= lsGetSVGIcon('box-open') ?>
																		<lse-text>
																		<?= __('Configure Post Options', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- SLIDE LINKING -->
									<lse-sidebar-body data-section-name="<?= __('Slide Linking', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Slide Linking', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements lse-link-fields">
														<lse-row>
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-text>
																		<?= __('Set link', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['slides']['linkUrl'], null, [
																		'class' => 'lse-link-url-input',
																		'placeholder' => $lsDefaults['slides']['linkUrl']['name']
																	]) ?>
																	<?php lsGetInput( $lsDefaults['slides']['linkId'], null, [ 'type' => 'hidden' ]) ?>
																	<?php lsGetInput( $lsDefaults['slides']['linkName'], null, [ 'type' => 'hidden' ]) ?>
																	<?php lsGetInput( $lsDefaults['slides']['linkType'], null, [ 'type' => 'hidden' ]) ?>

																	<?= lsGetSVGIcon('times', null, [
																		'class' => 'lse-remove lse-it-0'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-hide-if-has-link">
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-link-post"><?= __('Choose Post or Page', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-hide-if-has-link">
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-link-dyn"><?= __('Use dynamic post URL', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['linkTarget'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['slides']['linkPosition'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Deep linking', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="deeplink" data-smart-help-title="<?= __('Deep Link', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['slides']['deeplink'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- SCHEDULE -->
									<lse-sidebar-body id="lse-slide-setting-schedule" data-section-name="<?= __('Schedule', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Schedule Slide', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('From', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="schedule_start" class="lse-datepicker-input slideprop" data-datepicker-classes="lse-datepicker-floating" data-datepicker-key="schedule_start">
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('To', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="schedule_end" class="lse-datepicker-input slideprop" data-datepicker-classes="lse-datepicker-floating" data-datepicker-key="schedule_end">
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- MISC -->
									<lse-sidebar-body data-section-name="<?= __('Misc', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Additional Settings', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-3-1">
																<lse-ib>
																	<lse-text>
																		<?= __('Overflow Layers', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['slides']['overflow'] ) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text>
														<?= __('Custom Slide Properties', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements lse-form-rows lse-custom-slide-properties">
														<?= lsGetSVGIcon('times-circle',false,['class' => 'lse-form-rows-close']) ?>
														<lse-row>
															<lse-col class="lse-placeholder lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" placeholder="key" class="lse-key">
																	<input type="text" placeholder="value" class="lse-value">
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

								</lse-slide-settings>

								<!-- LAYER SETTINGS -->

								<lse-layer-settings data-layer-type="image" class="lse-sidebar lse-dark-theme">

									<lse-sidebar-head>
										<?= lsGetSVGIcon('layer-group','duotone') ?>
										<lse-text class="lse-hide-on-wide-sidebar"><?= __('Layer Settings', 'LayerSlider') ?></lse-text>
										<lse-text class="lse-show-on-wide-sidebar"><?= __('Set content, style, transitions and linking of selected layers.', 'LayerSlider') ?></lse-text>
										<lse-options>
											<?= lsGetSVGIcon('arrows-alt-h',false,[
												'data-lse-action' => 'wideSidebar',
												'data-tt' => '.tt-expand-sidebar'
											]) ?>
										</lse-options>
									</lse-sidebar-head>

									<lse-b id="lse-multiple-notice">
										<lse-text>
											<?= __('Multiple selection mode', 'LayerSlider') ?>
										</lse-text>
									</lse-b>
									<lse-sidebar-subnav class="lse-make-attention lse-tabs" data-tabs-for="lse-layer-settings" data-tabs-filter=":not(.lse-no-toggle, lse-flex-placeholder)" data-tabs-content-filter="lse-sidebar-body">

										<lse-subnav-item id="lse-open-layers-list" class="lse-grayaaa lse-no-toggle lse-get-attention lse-attention-once" data-lse-action="closeLayersList">
											<?= lsGetSVGIcon('list-alt') ?>
											<lse-text><?= __('Layers List', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-active lse-layer-content-tab">
											<?= lsGetSVGIcon('edit','regular') ?>
											<lse-text><?= __('Content', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-layer-style-tab lse-not-bg-video-only">
											<?= lsGetSVGIcon('palette','regular') ?>
											<lse-text><?= __('Style', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-layer-transition-tab lse-not-bg-video-only">
											<?= lsGetSVGIcon('wave-sine') ?>
											<lse-text><?= __('Transition', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-layer-link-tab lse-not-bg-video-only">
											<?= lsGetSVGIcon('link','regular') ?>
											<lse-text><?= __('Link', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-layer-actions-tab lse-not-bg-video-only">
											<?= lsGetSVGIcon('bullseye-pointer','regular',[
												'class' => 'lse-mirror-h'
											]) ?>
											<lse-text><?= __('Actions', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-subnav-item class="lse-layer-attributes-tab lse-not-bg-video-only">
											<?= lsGetSVGIcon('list-alt','regular') ?>
											<lse-text><?= __('Attributes', 'LayerSlider') ?></lse-text>
										</lse-subnav-item>

										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>
										<lse-flex-placeholder></lse-flex-placeholder>

									</lse-sidebar-subnav>

									<!-- LAYER CONTENT -->
									<lse-sidebar-body data-section-name="<?= __('Content', 'LayerSlider') ?>">

										<?php lsGetInput( $lsDefaults['layers']['media'], null, [ 'type' => 'hidden' ]) ?>
										<lse-sidebar-content-nav id="lse-set-layer-type" class="lse-smart-dropdown-wrapper lse-max-clicks" data-max-clicks="3" data-max-clicks-namespace="layerTypeSelector" data-tt>
											<lse-text></lse-text>
											<lse-options class="lse-icons-only">
												<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
												<?= lsGetSVGIcon('times',false,['class' => 'lse-close lse-it-fix']) ?>
											</lse-options>

											<lse-smart-dropdown>
												<lse-smart-dropdown-inner>
													<lse-ul>
														<lse-li data-name="img" class="lse-active"><?= lsGetSVGIcon('image-polaroid') ?><ls-text><?= __('Image', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="text"><?= lsGetSVGIcon('align-left') ?><ls-text><?= __('Text', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="media"><?= lsGetSVGIcon('play-circle') ?><ls-text><?= __('Video / Audio', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="button"><?= lsGetSVGIcon('dot-circle') ?><ls-text><?= __('Button', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="shape"><?= lsGetSVGIcon('shapes') ?><ls-text><?= __('Shape', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="icon"><?= lsGetSVGIcon('icons') ?><ls-text><?= __('Icon', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="svg"><?= lsGetSVGIcon('stars') ?><ls-text><?= __('Object', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="html"><?= lsGetSVGIcon('code') ?><ls-text><?= __('HTML', 'LayerSlider') ?></ls-text></lse-li>
														<lse-li data-name="post"><?= lsGetSVGIcon('database') ?><ls-text><?= __('Dynamic Layer', 'LayerSlider') ?></ls-text></lse-li>
													</lse-ul>
												</lse-smart-dropdown-inner>
											</lse-smart-dropdown>

										</lse-sidebar-content-nav>
										<lse-tt><?= __('Click to change layer type', 'LayerSlider') ?></lse-tt>

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>

															<!-- COMMON -->

															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text class="lse-tac">
																		<?= __('Toggle device visibility', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc lse-it-fix">
																	<lse-button-group id="lse-layer-device-types" class="lse-min-one lse-toggle-all">
																		<lse-button data-type="desktop" class="lse-active">
																			<?= lsGetSVGIcon('desktop') ?>
																		</lse-button>
																		<lse-button data-type="tablet" class="lse-active">
																			<?= lsGetSVGIcon('tablet-alt') ?>
																		</lse-button>
																		<lse-button data-type="phone" class="lse-active">
																			<?= lsGetSVGIcon('mobile-alt') ?>
																		</lse-button>
																	</lse-button-group>
																</lse-ib>
															</lse-col>

															<lse-separator></lse-separator>

															<!-- IMAGE LAYER -->

															<lse-col class="lse-img-type-only">
																<lse-ib>
																	<lse-text><?= __('Set image', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-tac">
																	<lse-fe-wrapper class="lse-image-input lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-image-input">
																		<lse-image-input class="lse-media-upload lse-bulk-upload lse-layer-image" data-prop="image" data-search-name="<?= __('Image', 'LayerSlider') ?>"></lse-image-input>
																		<?= lsGetSVGIcon('ellipsis-v', null, [
																			'class' => 'lse-options lse-has-left-contextmenu',
																			'data-contextmenu-selector' => '#lse-context-menu-image-input'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder class="lse-img-type-only"></lse-col-placeholder>


															<!-- COMMON (CONTENT BOX) -->
															<lse-col class="lse-content-box-type-only lse-wide">
																<lse-ib>
																	<textarea name="html" data-prop="html" data-default="" data-search-name="<?= __('Content', 'LayerSlider') ?>" id="lse-layer-content" placeholder="<?= __('Type / add your layer content here', 'LayerSlider') ?>"></textarea>
																</lse-ib>
															</lse-col>


															<!-- BUTTON LAYER -->
															<lse-col class="lse-button-type-only">
																<lse-ib class="lse-half lse-jcc">
																	<lse-button data-search-name="<?= __('Choose Button Preset', 'LayerSlider') ?>" class="lse-giant lse-aic lse-choose-button-preset">
																		<?= lsGetSVGIcon('palette')?>
																		<lse-text>
																		<?= __('Choose Button Preset', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																</lse-ib>
															</lse-col>
															<lse-separator class="lse-button-type-only"></lse-separator>

															<lse-col class="lse-media-type-only">
																<lse-ib class="lse-half lse-jcc">
																	<lse-button class="lse-giant lse-aic lse-open-media-modal">
																		<?= lsGetSVGIcon('icons')?>
																		<lse-text>
																		<?= __('Change media', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																	<button class="lse-dn lse-media-upload lse-bulk-upload lse-insert-media"></button>
																</lse-ib>
															</lse-col>
															<lse-separator class="lse-media-type-only"></lse-separator>


															<!-- LINE BREAK OPTIONS -->
															<lse-col class="lse-content-box-type-only">
																<lse-ib>
																	<lse-text><?= __('line breaks', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['htmlLineBreak'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<!-- ELEMENT TYPE -->
															<lse-col class="lse-content-box-type-only">
																<lse-ib>
																	<lse-text><?= __('HTML element', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['htmlTag'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>



															<!-- OBJECT LAYER -->

															<lse-col class="lse-object-type-only">
																<lse-ib class="lse-half lse-jcc">
																	<lse-button data-search-name="<?= __('Modify Object', 'LayerSlider') ?>" class="lse-giant lse-aic lse-modify-object">
																		<?= lsGetSVGIcon('palette')?>
																		<lse-text>
																		<?= __('Modify Object', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																</lse-ib>
															</lse-col>

															<!-- SHAPE LAYER -->

															<lse-col class="lse-shape-type-only">
																<lse-ib class="lse-half lse-jcc">
																	<lse-button data-search-name="<?= __('Modify Shape', 'LayerSlider') ?>" class="lse-giant lse-aic lse-modify-shape">
																		<?= lsGetSVGIcon('shapes')?>
																		<lse-text>
																		<?= __('Modify Shape', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																</lse-ib>
															</lse-col>

															<!-- ICON LAYER -->

															<lse-col class="lse-icon-type-only">
																<lse-ib>
																	<lse-text><?= __('Icon', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-icon-input">
																		<lse-icon-picker data-prop="html" data-search-name="<?= __('Choose Icon', 'LayerSlider') ?>">

																		</lse-icon-picker>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<!-- DYNAMIC LAYER -->

															<lse-separator class="lse-post-type-only"></lse-separator>
															<lse-col id="lse-post-placeholders" class="lse-post-type-only lse-wide">
																<lse-button>[post-id]</lse-button>
																<lse-button>[post-slug]</lse-button>
																<lse-button>[post-url]</lse-button>
																<lse-button>[date-published]</lse-button>
																<lse-button>[time-published]</lse-button>
																<lse-button>[date-modified]</lse-button>
																<lse-button>[time-modified]</lse-button>
																<lse-button>[image]</lse-button>
																<lse-button>[image-url]</lse-button>
																<lse-button>[thumbnail]</lse-button>
																<lse-button>[thumbnail-url]</lse-button>
																<lse-button>[title]</lse-button>
																<lse-button>[content]</lse-button>
																<lse-button>[excerpt]</lse-button>
																<!-- <lse-button data-placeholder="<a href=&quot;[post-url]&quot;>Read more</a>">[link]</lse-button> -->
																<lse-button>[author]</lse-button>
																<lse-button>[author-name]</lse-button>
																<lse-button>[author-avatar]</lse-button>
																<lse-button>[author-id]</lse-button>
																<lse-button>[categories]</lse-button>
																<lse-button>[tags]</lse-button>
																<lse-button>[comments]</lse-button>
																<lse-button>[meta:&lt;fieldname&gt;]</lse-button>															</lse-col>
															<lse-col class="lse-post-type-only lse-wide lse-text-only">
																<lse-text><?= __('Click on one or more post placeholders to insert them into your layer’s content. Post placeholders act like shortcodes in WP, and they will be filled with the actual content from your posts.', 'LayerSlider') ?></lse-text>
															</lse-col>
															<lse-separator class="lse-post-type-only"></lse-separator>
															<lse-col class="lse-post-type-only">
																<lse-ib>
																	<lse-text>
																		<?= __('Limit text length (if any)', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['postTextLength'], null ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-post-type-only">
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-giant lse-aic lse-configure-post-options">
																		<?= lsGetSVGIcon('map-pin')?>
																		<lse-text>
																		<?= __('Configure post options', 'LayerSlider') ?>
																		</lse-text>
																	</lse-button>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

												<!-- LAYER ICON -->

												<lse-sidebar-section-head class="lse-add-replace-icon">
													<lse-text>
														<?= __('Additional Options', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-add-replace-icon">
													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Icon', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-icon-input">
																		<lse-icon-picker data-prop="icon" data-search-name="<?= __('Choose Icon', 'LayerSlider') ?>">

																		</lse-icon-picker>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Icon Color', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="iconColor" data-smart-help-title="<?= __('Icon Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['iconColor'] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Icon Placement', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['iconPlacement'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text><?= __('Icon Size', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<?php lsGetInput( $lsDefaults['layers']['iconSize'], null, [
																		'name' => '',
																		'type' => 'range',
																		'max' => 10,
																		'class' => 'lse-small'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['iconSize'] ) ?>
																	<lse-unit>em</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text><?= __('Icon Gap', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<?php lsGetInput( $lsDefaults['layers']['iconGap'], null, [
																		'name' => '',
																		'type' => 'range',
																		'max' => 10,
																		'class' => 'lse-small'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['iconGap'] ) ?>
																	<lse-unit>em</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text><?= __('Vertical Adjustment', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<?php lsGetInput( $lsDefaults['layers']['iconVerticalAdjustment'], null, [
																		'name' => '',
																		'type' => 'range',
																		'min' => -2,
																		'max' => 2,
																		'class' => 'lse-small'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['iconVerticalAdjustment'] ) ?>
																	<lse-unit>em</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

												<!-- MEDIA LAYER -->

												<lse-sidebar-section-head class="lse-media-type-only">
													<lse-text>
														<?= __('Media Options', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-media-type-only">

													<lse-grid class="lse-form-elements">

														<lse-row>

															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Poster image', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-image-input lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-image-input">
																		<lse-image-input class="lse-media-upload lse-bulk-upload lse-media-image" data-prop="poster" data-search-name="<?= __('Poster', 'LayerSlider') ?>"></lse-image-input>
																		<?= lsGetSVGIcon('ellipsis-v', null, [
																			'class' => 'lse-options lse-has-left-contextmenu',
																			'data-contextmenu-selector' => '#lse-context-menu-image-input'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('background video', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['mediaBackgroundVideo'], null, [
																		'class' => 'lse-bgvideo lse-transition-prop',
																		'data-toggle-class' => 'lse-bg-video',
																		'data-toggle-selector' => 'lse-layer-settings'
																	] ) ?>
																</lse-ib>
															</lse-col>

															<lse-col-placeholder></lse-col-placeholder>

															<lse-col class="lse-wide lse-bg-video-only lse-col-notice">
																<lse-ib>
																	<lse-text>
																		<?= __('Please note, the slide background image and any layers will cover the video.', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
															</lse-col>

															<lse-separator></lse-separator>

															<lse-col class="lse-not-bg-video-only">
																<lse-ib>
																	<lse-text><?= __('Autoplay', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaAutoPlay'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Play muted', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaMuted'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Volume', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['mediaVolume'], null, [
																		'name' => '',
																		'type' => 'range',
																		'class' => 'lse-small lse-transition-prop'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['mediaVolume'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>

																</lse-ib>
															</lse-col>

															<lse-col class="lse-not-bg-video-only">
																<lse-ib>
																	<lse-text><?= __('Fill mode', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaFillMode'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col class="lse-not-bg-video-only">
																<lse-ib>
																	<lse-text><?= __('Controls', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaControls'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col class="lse-not-bg-video-only">
																<lse-ib>
																	<lse-text><?= __('Show info', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaInfo'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Loop', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['mediaLoop'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col class="lse-bg-video-only">
																<lse-ib>
																	<lse-text>
																		<?= __('Overlay image', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php
																		$location = LS_ROOT_PATH.'/static/layerslider/overlays/*';
																		$overlays = ['disabled' => __('No overlay image', 'LayerSlider') ];

																		foreach( glob($location) as $file ) {
																			$basename = basename($file);
																			$url = LS_ROOT_URL.'/static/layerslider/overlays/'.$basename;

																			if( ! strstr( $basename, '.php' ) ) {
																				$overlays[$url] = $basename;
																			}
																		}

																		lsGetSelect( $lsDefaults['layers']['mediaOverlay'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $overlays
																		]);
																		?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

															<lse-col-placeholder></lse-col-placeholder>

														</lse-row>

													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>

									<!-- LAYER STYLE -->
									<lse-sidebar-body class="lse-layer-style-panel" data-storage="styles" data-section-name="<?= __('Style', 'LayerSlider') ?>">

										<lse-sidebar-content>

											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-button-group class="lse-toolbar lse-toolbar-head lse-aic lse-jcfe">

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-style-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-style-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Size & Position', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-has-toolbar">

													<lse-button-group class="lse-toolbar">

														<lse-button data-set='{"style-width":"100%","style-height":"100%","style-left":"0","style-top":"0"}' data-tt data-tt-de="0">
															<?= lsGetSVGIcon('expand-arrows-alt') ?>
														</lse-button>
														<lse-tt>
															<?= __('Set layer to full size', 'LayerSlider') ?>
														</lse-tt>

														<lse-button data-set='{"style-width":"","style-height":""}' data-tt data-tt-de="0">
															<?= lsGetSVGIcon('expand-wide') ?>
														</lse-button>
														<lse-tt>
															<?= __('Set layer to auto size', 'LayerSlider') ?>
														</lse-tt>

														<lse-button data-set='{"style-width":"","style-height":"","style-left":"","style-top":""}' data-tt data-tt-de="0">
															<?= lsGetSVGIcon('ban') ?>
														</lse-button>
														<lse-tt>
															<?= __('Clear all size and position values', 'LayerSlider') ?>
														</lse-tt>

														<lse-button id="lse-pos-to-percent" data-tt data-tt-de="0">
															%
														</lse-button>
														<lse-tt>
															<?= __('Convert left and top values to percentages', 'LayerSlider') ?>
														</lse-tt>

														<lse-button id="lse-pos-to-pixels" data-tt data-tt-de="0">
															px
														</lse-button>
														<lse-tt>
															<?= __('Convert left and top values to pixels', 'LayerSlider') ?>
														</lse-tt>

														<lse-ib class="lse-f11"></lse-ib>
														<lse-button class="lse-pos-to-center lse-center-h" data-tt data-tt-de="0">
															<?= lsGetSVGIcon('border-center-v', 'duotone') ?>
														</lse-button>
														<lse-tt>
															<?= __('Position to horizontal center', 'LayerSlider') ?>
														</lse-tt>

														<lse-button class="lse-pos-to-center lse-center-v" data-tt data-tt-de="0">
															<?= lsGetSVGIcon('border-center-h', 'duotone') ?>
														</lse-button>
														<lse-tt>
															<?= __('Position to vertical middle', 'LayerSlider') ?>
														</lse-tt>
														<lse-tt class="tt-pos-to-abs-center">
															<?= __('Position to absolute center', 'LayerSlider') ?>
														</lse-tt>

														<lse-button class="lse-pos-to-center lse-center-h lse-center-v" data-tt=".tt-pos-to-abs-center" data-tt-de="0">
															<?= lsGetSVGIcon('border-inner', 'duotone') ?>
														</lse-button>

													</lse-button-group>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Size', 'LayerSlider') ?><lse-props><?= __('width', 'LayerSlider') ?>, <?= __('height', 'LayerSlider') ?></lse-props><lse-cur-prop></lse-cur-prop><lse-units>px %</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="width" data-smart-help-title="<?= __('Width', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['width'], null, [
																			'class' 			=> 'lse-style-prop',
																			'placeholder' 		=> 'auto',
																			'data-prop-type' 	=> __('width', 'LayerSlider'),
																			'data-get' 			=> 'style-width'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="height" data-smart-help-title="<?= __('Height', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['height'], null, [
																			'class' 			=> 'lse-style-prop',
																			'placeholder' 		=> 'auto',
																			'data-prop-type' 	=> __('height', 'LayerSlider'),
																			'data-get' 			=> 'style-height'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Position', 'LayerSlider') ?><lse-props><?= __('left', 'LayerSlider') ?>, <?= __('top', 'LayerSlider') ?></lse-props><lse-cur-prop></lse-cur-prop><lse-units>px %</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="left" data-smart-help-title="<?= __('Left position', 'LayerSlider') ?>" data-smart-operations data-smart-options="left">
																		<?php lsGetInput( $lsDefaults['layers']['left'], null, [
																			'class' 			=> 'lse-style-prop',
																			'placeholder' 		=> '0px',
																			'data-prop-type' 	=> __('left', 'LayerSlider'),
																			'data-get' 			=> 'style-left'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="top" data-smart-help-title="<?= __('Top position', 'LayerSlider') ?>" data-smart-operations data-smart-options="top">
																		<?php lsGetInput( $lsDefaults['layers']['top'], null, [
																			'class' 			=> 'lse-style-prop',
																			'placeholder' 		=> '0px',
																			'data-prop-type' 	=> __('top', 'LayerSlider'),
																			'data-get' 			=> 'style-top'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Align position from', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['position'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active lse-vector-type-only">
													<lse-text class="lse-icon-type-only">
														<?= __('Icon Style', 'LayerSlider') ?>
													</lse-text>
													<lse-text class="lse-object-type-only">
														<?= __('Object Style', 'LayerSlider') ?>
													</lse-text>
													<lse-text class="lse-shape-type-only">
														<?= __('Shape Style', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-vector-type-only">

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-icon-type-only">
																<lse-ib>
																	<lse-text>
																		<?= __('Icon Size', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['fontSize'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 150,
																		'name' 	=> '',
																		'class' => 'lse-style-prop'
																	]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['fontSize'], null, [
																		'class' => 'lse-style-prop',
																		'data-search-name' => __('Icon Size', 'LayerSlider')
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-icon-type-only">
																<lse-ib>
																	<lse-text>
																		<?= __('Line Height', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['lineHeight'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 150,
																		'name' 	=> '',
																		'class' => 'lse-style-prop'
																	]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['lineHeight'], null, [
																		'class' => 'lse-style-prop'
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text class="lse-icon-type-only">
																		<?= __('Icon Color', 'LayerSlider') ?>
																	</lse-text>
																	<lse-text class="lse-object-type-only">
																		<?= __('Object Color', 'LayerSlider') ?>
																	</lse-text>
																	<lse-text class="lse-shape-type-only">
																		<?= __('Shape Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="textColor" data-smart-help-title="<?= __('Text Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['color'], null, [
																			'type' => 'text',
																			'class' => 'lse-style-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>
												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active lse-textish-type-only">
													<lse-text>
														<?= __('Text & Typography', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-textish-type-only">

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Font Family', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="fontfamily" data-smart-help-title="<?= __('Font family', 'LayerSlider') ?>" data-smart-options="fontfamily" data-hide-smart-options-title>
																		<?php lsGetInput( $lsDefaults['layers']['fontFamily'], null, [
																			'class' => 'lse-style-prop lse-layer-font-family',
																			'placeholder' => 'Arial, sans-serif'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Font Size', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['fontSize'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 150,
																		'name' 	=> '',
																		'class' => 'lse-style-prop'
																	]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['fontSize'], null, [
																		'class' => 'lse-style-prop'
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Line Height', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['lineHeight'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 150,
																		'name' 	=> '',
																		'class' => 'lse-style-prop'
																	]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['lineHeight'], null, [
																		'class' => 'lse-style-prop'
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Text Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="textColor" data-smart-help-title="<?= __('Text Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['color'], null, [
																			'type' => 'text',
																			'class' => 'lse-style-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Word Wrap', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['wordWrap'], null, [
																		'class' => 'lse-style-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col class="lse-wide lse-jcfe lse-it-fix lse-set-text-sample">
																<lse-ib>
																	<lse-button-group class="lse-icons-only lse-max-one lse-min-one lse-toggle-all" data-style="text-align" data-set-hidden-input-to="value">
																		<lse-button class="lse-active" data-value="left">
																			<?= lsGetSVGIcon('align-left') ?>
																		</lse-button>
																		<lse-button data-value="center">
																			<?= lsGetSVGIcon('align-center') ?>
																		</lse-button>
																		<?php lsGetInput( $lsDefaults['layers']['textAlign'], null, [
																			'type' => 'hidden',
																			'class' => 'lse-style-prop lse-restore-prop'
																		]) ?>
																		<lse-button data-value="right">
																			<?= lsGetSVGIcon('align-right') ?>
																		</lse-button>
																		<lse-button data-value="justify">
																			<?= lsGetSVGIcon('align-justify') ?>
																		</lse-button>
																	</lse-button-group>
																	<lse-button-group class="lse-icons-only lse-toggle-all">
																		<lse-button data-style="font-weight" data-value="700" data-default-value="400">
																			<?= lsGetSVGIcon('bold') ?>
																		</lse-button>
																		<lse-button data-style="font-style" data-value="italic" data-default-value="normal" data-set-hidden-input-to="value">
																			<?= lsGetSVGIcon('italic') ?>
																			<?php lsGetInput( $lsDefaults['layers']['fontStyle'], null, [
																				'type' => 'hidden',
																				'class' => 'lse-style-prop lse-restore-prop'
																			]) ?>
																		</lse-button>
																	</lse-button-group>
																	<lse-button-group class="lse-icons-only lse-max-one lse-toggle-all" data-default-value="none" data-style="text-decoration" data-set-hidden-input-to="value">
																		<lse-button data-value="underline">
																			<?= lsGetSVGIcon('underline') ?>
																		</lse-button>
																		<lse-button data-value="line-through">
																			<?= lsGetSVGIcon('strikethrough') ?>
																		</lse-button>
																		<?php lsGetInput( $lsDefaults['layers']['textDecoration'], null, [
																			'type' => 'hidden',
																			'class' => 'lse-style-prop lse-restore-prop'
																		]) ?>
																		<lse-button data-value="overline">
																			<?= lsGetSVGIcon('overline') ?>
																		</lse-button>
																	</lse-button-group>
																	<lse-button-group class="lse-icons-only lse-max-one lse-toggle-all" data-default-value="none" data-style="text-transform" data-set-hidden-input-to="value">
																		<lse-button data-value="uppercase">
																			<?= lsGetSVGIcon('text-size') ?>
																		</lse-button>
																		<?php lsGetInput( $lsDefaults['layers']['textTransform'], null, [
																			'type' => 'hidden',
																			'class' => 'lse-style-prop lse-restore-prop'
																		]) ?>
																		<lse-button data-value="capitalize">
																			<?= lsGetSVGIcon('font-case') ?>
																		</lse-button>
																	</lse-button-group>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide" id="lse-text-sample">
																<lse-text>
																	<?= __('sample text', 'LayerSlider') ?><lse-ib></lse-ib>
																</lse-text>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Font weight', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['fontWeight'], null, [
																		'name' => '',
																		'type' => 'range',
																		'class' => 'lse-style-prop',
																		'data-style' => 'font-weight'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['fontWeight'], null, [

																		'class' => 'lse-style-prop lse-restore-prop',
																		'data-style' => 'font-weight'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Letter Spacing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['letterSpacing'], null, [
																		'name' => '',
																		'type' => 'range',
																		'class' => 'lse-style-prop',
																		'data-style' => 'letter-spacing',
																		'data-unit' => 'px'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['letterSpacing'], null, [

																		'class' => 'lse-style-prop',
																		'data-style' => 'letter-spacing',
																		'data-unit' => 'px'
																	]) ?>

																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Min. Font Size', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['minFontSize'], null, [
																		'name' => '',
																		'type' => 'range',
																		'class' => 'lse-transition-prop'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['minFontSize'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Min. Mobile Font Size', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['minMobileFontSize'], null, [
																		'name' => '',
																		'type' => 'range',
																		'class' => 'lse-transition-prop'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['minMobileFontSize'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-textish-type-only">
													<lse-text>
														<?= __('Text Shadow', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-has-toolbar lse-textish-type-only">

													<lse-button-group class="lse-toolbar">

														<lse-ib class="lse-f11"></lse-ib>

														<lse-button class="lse-clear-property" data-tt=".tt-clear-property" data-tt-de="0">
															<?= lsGetSVGIcon('trash-alt') ?>
														</lse-button>

													</lse-button-group>

													<lse-grid class="lse-form-elements lse-dark-theme">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<input data-cv="text-shadow" data-cv-id="4" data-default="" type="text">
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Horizontal', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="-50" max="50" value="0" data-default="0">
																	<input data-cv="text-shadow" data-cv-unit="px" data-cv-id="1" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Vertical', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="-50" max="50" value="0" data-default="0">
																	<input data-cv="text-shadow" data-cv-unit="px" data-cv-id="2" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Blur', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="0" max="100" value="0" data-default="0">
																	<input data-cv="text-shadow" data-cv-unit="px" data-cv-id="3" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-row>
														<?php lsGetInput( $lsDefaults['layers']['textShadow'], null, [
															'class' 	=> 'lse-style-prop lse-restore-prop lse-undomanager-merge',
															'data-sv' 	=> 'text-shadow',
															'type' 		=> 'hidden'
														]) ?>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Border, corners & padding', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated',
																		'data-link-property' => 'border-width-style',
																		'data-tt' => ''
																	]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Border size', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px em</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-quarter">
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-width-style" data-cv-id="1" data-prop-type="<?= __('top', 'LayerSlider') ?>" data-link="border-width-style">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-width-style" data-cv-id="2" data-prop-type="<?= __('right', 'LayerSlider') ?>" data-link="border-width-style">
																	</lse-fe-wrapper>
																	<?php lsGetInput( $lsDefaults['layers']['borderWidth'], null, [
																		'class' 	=> 'lse-style-prop lse-restore-prop lse-undomanager-merge',
																		'data-sv' 	=> 'border-width-style',
																		'type' 		=> 'hidden'
																	]) ?>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-width-style" data-cv-id="3" data-prop-type="<?= __('bottom', 'LayerSlider') ?>" data-link="border-width-style">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-width-style" data-cv-id="4" data-prop-type="<?= __('left', 'LayerSlider') ?>" data-link="border-width-style">
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Border style', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['borderStyle'], null, [
																			'class' => 'lse-style-prop'
																		] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Border color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['borderColor'], null, [
																			'class' => 'lse-style-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated',
																		'data-link-property' => 'border-radius-style',
																		'data-tt' => ''
																	]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Rounding', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px % em</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-quarter">
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-style" data-cv-id="1" data-prop-type="<?= __('top-left', 'LayerSlider') ?>" data-link="border-radius-style">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-style" data-cv-id="2" data-prop-type="<?= __('top-right', 'LayerSlider') ?>" data-link="border-radius-style">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-style" data-cv-id="3" data-prop-type="<?= __('btm-right', 'LayerSlider') ?>" data-link="border-radius-style">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-style" data-cv-id="4" data-prop-type="<?= __('btm-left', 'LayerSlider') ?>" data-link="border-radius-style">
																	</lse-fe-wrapper>
																	<?php lsGetInput( $lsDefaults['layers']['borderRadius'], null, [
																		'class' 	=> 'lse-style-prop lse-restore-prop lse-undomanager-merge',
																		'data-sv' 	=> 'border-radius-style',
																		'type' 		=> 'hidden'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated',
																		'data-link-property' => 'padding-style',
																		'data-tt' => ''
																	]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Padding', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px em</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-quarter">
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['paddingTop'], null, [
																			'class' 			=> 'lse-style-prop',
																			'data-prop-type' 	=> __('top', 'LayerSlider'),
																			'data-link' 		=> 'padding-style'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['paddingRight'], null, [
																			'class' 			=> 'lse-style-prop',
																			'data-prop-type' 	=> __('right', 'LayerSlider'),
																			'data-link' 		=> 'padding-style'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['paddingBottom'], null, [
																			'class' 			=> 'lse-style-prop',
																			'data-prop-type' 	=> __('bottom', 'LayerSlider'),
																			'data-link' 		=> 'padding-style'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['paddingLeft'], null, [
																			'class' 			=> 'lse-style-prop',
																			'data-prop-type' 	=> __('left', 'LayerSlider'),
																			'data-link' 		=> 'padding-style'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Background', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Image', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-image-input lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-image-input">
																		<lse-image-input class="lse-media-upload lse-bulk-upload lse-layer-background-image" data-prop="layerBackground"  data-search-name="<?= __('Background Image', 'LayerSlider') ?>"></lse-image-input>
																		<?= lsGetSVGIcon('ellipsis-v', null, [
																			'class' => 'lse-options lse-has-left-contextmenu',
																			'data-contextmenu-selector' => '#lse-context-menu-image-input'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="backgroundColor" data-smart-help-title="<?= __('Background Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['backgroundColor'], null, [
																			'class' => 'lse-style-prop',
																			'data-type' => 'gradient'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Position', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-alignment lse-min-one lse-max-one lse-toggle-all" data-set-hidden-input-to="align">
																		<lse-button class="lse-active" data-align="0% 0%" data-tt=".tt-align-left-top"></lse-button>
																		<lse-button data-align="50% 0%" data-tt=".tt-align-center-top"></lse-button>
																		<lse-button data-align="100% 0%" data-tt=".tt-align-right-top"></lse-button>
																		<lse-button data-align="0% 50%" data-tt=".tt-align-left-center"></lse-button>
																		<lse-button data-align="50% 50%" data-tt=".tt-align-center-center"></lse-button>
																		<lse-button data-align="100% 50%" data-tt=".tt-align-right-center"></lse-button>
																		<lse-button data-align="0% 100%" data-tt=".tt-align-left-bottom"></lse-button>
																		<lse-button data-align="50% 100%" data-tt=".tt-align-center-bottom"></lse-button>
																		<lse-button data-align="100% 100%" data-tt=".tt-align-right-bottom"></lse-button>
																		<?php lsGetInput( $lsDefaults['layers']['backgroundPosition'], null, [
																			'type' => 'hidden',
																			'class' => 'lse-style-prop lse-restore-prop'
																		] ) ?>
																	</lse-fe-wraper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Background Size', 'LayerSlider') ?><lse-units>px % +</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="backgroundSize" data-smart-help-title="<?= __('Background Size', 'LayerSlider') ?>" data-smart-options="backgroundSize">
																		<?php lsGetInput( $lsDefaults['layers']['backgroundSize'], null, [ 'class' => 'lse-style-prop'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Background Repeat', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['backgroundRepeat'], null, [  'class' => 'lse-style-prop' ] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-style',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="style">
																		<?php lsGetInput( $lsDefaults['layers']['scaleX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-link' 		=> 'scale-style',
																			'data-prop-type' 	=> 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="style">
																		<?php lsGetInput( $lsDefaults['layers']['scaleY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-link' 		=> 'scale-style',
																			'data-prop-type' 	=> 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['rotate'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> __('Z (normal)', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['rotateX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['rotateY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['skewX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['skewY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated lse-set-active lse-dn',
																		'data-link-property' => 'transform-origin-in',
																		'data-tt' => ''
																	]) ?>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInTransformOrigin'], null, [
																			'class' => 'lse-transition-prop',
																			'data-link' => 'transform-origin-in'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Box Shadow', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-has-toolbar">

													<lse-button-group class="lse-toolbar">

														<lse-ib class="lse-f11"></lse-ib>

														<lse-button class="lse-clear-property" data-tt=".tt-clear-property" data-tt-de="0">
															<?= lsGetSVGIcon('trash-alt') ?>
														</lse-button>

													</lse-button-group>


													<lse-grid class="lse-form-elements lse-dark-theme">
														<lse-row>
															<lse-col>
																<lse-ib class="lse-jcc">
																	<lse-button-group class="lse-toggle-all lse-min-one lse-max-one" data-cv="box-shadow" data-cv-id="1">
																		<lse-button data-cv-value="" class="lse-active"><lse-text><?= __('outside', 'LayerSlider') ?></lse-text></lse-button>
																		<lse-button data-cv-value="inset"><lse-text><?= __('inside', 'LayerSlider') ?></lse-text></lse-button>
																	</lse-button-group>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<input data-cv="box-shadow" data-cv-id="6" data-default="" type="text">
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Horizontal', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="-50" max="50" value="0" data-default="0">
																	<input data-cv="box-shadow" data-cv-unit="px" data-cv-id="2" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Vertical', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="-50" max="50" value="0"  data-default="0">
																	<input data-cv="box-shadow" data-cv-unit="px" data-cv-id="3" type="number" value="0"  data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Blur', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="0" max="100" value="0" data-default="0">
																	<input data-cv="box-shadow" data-cv-unit="px" data-cv-id="4" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Spread', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<input type="range" min="-50" max="50" value="0" data-default="0">
																	<input data-cv="box-shadow" data-cv-unit="px" data-cv-id="5" type="number" value="0" data-default="0"><lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-row>
														<?php lsGetInput( $lsDefaults['layers']['boxShadow'], null, [
															'class' 	=> 'lse-style-prop lse-restore-prop lse-undomanager-merge',
															'data-sv' 	=> 'box-shadow',
															'type' 		=> 'hidden'
														]) ?>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Effects', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Opacity', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['opacity'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 1,
																		'step' 	=> 0.05,
																		'name' 	=> '',
																		'class' => 'lse-small lse-style-prop'
																	]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['opacity'], null, [
																		'class' => 'lse-style-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Blend Mode', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['blendMode'], null, [
																			'class' => 'lse-style-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Filter', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="filter" data-smart-help-title="<?= __('Filter', 'LayerSlider') ?>" data-smart-options="filter" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['filter'], null, [
																			'class' => 'lse-style-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more">
													<lse-text>
														<?= __('Advanced Settings', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">

														<lse-row>

															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Stacking order', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['zIndex'], null, [
																			'placeholder' => __('default', 'LayerSlider'),
																			'class' => 'lse-style-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Mouse Cursor', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper>
																		<lse-fe-wrapper class="lse-select">
																			<?php lsGetSelect( $lsDefaults['layers']['cursor'], null, [
																				'class' => 'lse-style-prop'
																			]) ?>
																		</lse-fe-wrapper>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-3-1">
																<lse-ib>
																	<lse-text><?= __('Prevent mouse events', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetCheckbox( $lsDefaults['layers']['pointerEvents'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-text><?= __('Custom CSS', 'LayerSlider')?></lse-text>
																</lse-ib>
																<lse-ib>
																	<textarea id="lse-custom-css-textarea" name="style" data-search-name="<?= __('Custom CSS', 'LayerSlider') ?>" data-prop="style" data-default="" placeholder="<?= __('You can enter CSS properties here for further customization. Example:

cursor: pointer;
overflow: hidden;', 'LayerSlider') ?>"></textarea>
																</lse-ib>
															</lse-col>

														</lse-row>

													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>
									</lse-sidebar-body>

									<!-- LAYER TRANSITIONS -->
									<lse-sidebar-body class="lse-layer-transition-panel" data-section-name="<?= __('Transition', 'LayerSlider') ?>">

										<lse-sidebar-content-nav class="lse-smart-dropdown-wrapper lse-max-clicks" data-max-clicks="3" data-max-clicks-namespace="transitionSelector" data-tt>
											<lse-text></lse-text>
											<lse-options class="lse-icons-only">
												<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
												<?= lsGetSVGIcon('times',false,['class' => 'lse-close lse-it-fix']) ?>
											</lse-options>

											<lse-smart-dropdown>
												<lse-smart-dropdown-inner>
													<lse-ul id="lse-transition-dropdown" class="lse-tabs" data-tabs-for="#lse-transition-tabs" data-append-to-active-tab=".lse-additional-transition-settings">
														<lse-li class="lse-active"><?= __('Opening Transition', 'LayerSlider') ?></lse-li>
														<lse-li class="lse-textish-type-only"><?= __('Opening Text Transition', 'LayerSlider') ?></lse-li>
														<lse-li><?= __('Loop or Middle Transition', 'LayerSlider') ?></lse-li>
														<lse-li class="lse-textish-type-only"><?= __('Ending Text Transition', 'LayerSlider') ?></lse-li>
														<lse-li><?= __('Ending Transition', 'LayerSlider') ?></lse-li>
														<lse-li><?= __('Hover Transition', 'LayerSlider') ?></lse-li>
														<lse-li><?= __('Parallax Transition', 'LayerSlider') ?></lse-li>
													</lse-ul>
												</lse-smart-dropdown-inner>
											</lse-smart-dropdown>
										</lse-sidebar-content-nav>
										<lse-tt><?= __('Click to choose transition', 'LayerSlider') ?></lse-tt>

										<lse-sidebar-content id="lse-transition-tabs">

											<!-- OPENING TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light" data-storage="opening-transition" data-section-name="<?= __('Opening Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['transitionIn'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-opening-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer></lse-preview-layer>
													</lse-preview-slider>
													<lse-tt><?= __('Plays when layers enter the scene. <br><br> Layers animate from these options toward their appearance set under the <b>STYLE</b> menu.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsetin" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="in-x">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInOffsetX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																			'data-units' 		=> 'px % left lw sw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsetin" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="in-y">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInOffsetY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																			'data-units' 		=> 'px % top lh sh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-in',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scalein" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInScaleX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																			'data-link' 		=> 'scale-transition-in'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scalein" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInScaleY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																			'data-link' 		=> 'scale-transition-in'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatein" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInRotate'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> __('Z (normal)', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatein" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInRotateX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatein" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInRotateY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewin" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInSkewX'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewin" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInSkewY'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Size', 'LayerSlider') ?><lse-props><?= __('width', 'LayerSlider') ?>, <?= __('height', 'LayerSlider') ?></lse-props><lse-cur-prop></lse-cur-prop><lse-units>px</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInWidth'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> __('width', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInHeight'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> __('height', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Mask', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="mask" data-smart-options="mask" data-smart-help-title="<?= __('Mask', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInClip'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInTransformOrigin'], null, [
																			'class' => 'lse-transition-prop',
																			'data-link' => 'transform-origin-in'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInPerspective'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Start at', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="startat" data-smart-help-title="<?= __('Start at', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInDelay'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper><lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInDuration'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper><lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['transitionInEasing'], null, [
																			'class' 	=> 'lse-transition-prop',
																			'options' 	=> $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Fade', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['transitionInFade'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-textish-type-only">
																<lse-ib>
																	<lse-text>
																		<?= __('Text Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="textColor" data-smart-help-title="<?= __('Text Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInColor'], null, [
																			'class' => 'lse-transition-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="backgroundColor" data-smart-help-title="<?= __('Background Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['transitionInBGColor'], null, [
																			'class' => 'lse-transition-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Filter', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="filterin" data-smart-help-title="<?= __('Filter', 'LayerSlider') ?>" data-smart-options="filter" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['transitionInFilter'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated',
																		'data-link-property' => 'border-radius-transition-in',
																		'data-tt' => ''
																	]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Rounding', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px % em</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-quarter">
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-in" data-cv-id="1" data-prop-type="<?= __('top-left', 'LayerSlider') ?>" data-link="border-radius-transition-in">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-in" data-cv-id="2" data-prop-type="<?= __('top-right', 'LayerSlider') ?>" data-link="border-radius-transition-in">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-in" data-cv-id="3" data-prop-type="<?= __('btm-right', 'LayerSlider') ?>" data-link="border-radius-transition-in">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-in" data-cv-id="4" data-prop-type="<?= __('btm-left', 'LayerSlider') ?>" data-link="border-radius-transition-in">
																	</lse-fe-wrapper>
																	<?php lsGetInput( $lsDefaults['layers']['transitionInRadius'], null, [
																		'class' 	=> 'lse-transition-prop lse-restore-prop lse-undomanager-merge',
																		'data-sv' 	=> 'border-radius-transition-in',
																		'type' 		=> 'hidden'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-additional-transition-settings">
													<lse-text>
														<?= __('Additional Settings', 'LayerSlider') ?>
													</lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-additional-transition-settings">

													<lse-grid class="lse-form-elements">
														<lse-row class="lse-wide-cols">
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Keep this layer visible', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-select" data-smart-help="static" data-smart-help-title="<?= __('Static Layers', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['transitionStatic'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Play By Scroll Keyframe', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['transitionKeyframe'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

											<!-- OPENING TEXT TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light lse-disabled" data-storage="opening-text-transition" data-section-name="<?= __('Opening Text Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['textTransitionIn'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-opening-text-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer-text class="lse-preview-layer-t1">t</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t2">e</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t3">x</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t4">t</lse-preview-layer-text>
													</lse-preview-slider>
													<lse-tt>
														<?= __('Animates characters, words, or lines of text as they enter the scene. <br><br> Options specified here are the initial state of each fragment before they start animating toward the whole joint text.', 'LayerSlider') ?>
													</lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-text>
																		<?= __('Animate', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['textTypeIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsettextin" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="textin-x">
																		<?php lsGetInput( $lsDefaults['layers']['textOffsetXIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																			'data-units' 		=> 'px % left lw sw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsettextin" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="textin-y">
																		<?php lsGetInput( $lsDefaults['layers']['textOffsetYIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																			'data-units' 		=> 'px % top lh sh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-text-in',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaletextin" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textScaleXIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																			'data-link' 		=> 'scale-transition-text-in'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaletextin" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textScaleYIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																			'data-link' 		=> 'scale-transition-text-in'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextin" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> __('Z (normal)', 'LayerSlider'),
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextin" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateXIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextin" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateYIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewtextin" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textSkewXIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'X',
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewtextin" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textSkewYIn'], null, [
																			'class' 			=> 'lse-transition-prop',
																			'data-prop-type' 	=> 'Y',
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['textTransformOriginIn'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['textPerspectiveIn'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-start-at-wrapper lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Start when', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetInput( $lsDefaults['layers']['textStartAtIn'], null, [
																			'class' => 'lse-transition-prop lse-start-at-calc lse-undomanager-merge'
																		]) ?>

																		<?php lsGetSelect( $lsDefaults['layers']['textStartAtInTiming'], null, [
																			'class' => 'lse-transition-prop lse-start-at-timing'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-start-at-wrapper lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('with modifier', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-1-3">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['textStartAtInOperator'], null, [
																			'class' => 'lse-transition-prop lse-start-at-operator'
																		]) ?>
																	</lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['textStartAtInValue'], null, [
																			'class' => 'lse-transition-prop lse-start-at-value'
																		]) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['textDurationIn'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Shift in', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="textshiftduration" data-smart-help-title="<?= __('Shift In', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['textShiftIn'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['textEasingIn'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Fade', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['textFadeIn'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

											<!-- LOOP / MIDDLE TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light lse-disabled" data-storage="loop-transition" data-section-name="<?= __('Loop or Middle Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['loop'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-loop-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer></lse-preview-layer>
													</lse-preview-slider>
													<lse-tt><?= __('Animates layers continuously with an optional Yo-yo effect. <br><br>Can also act as a middle animation step between Opening and Ending transitions.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offset" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="loop-x">
																		<?php lsGetInput( $lsDefaults['layers']['loopOffsetX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-units' => 'px % left lw sw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offset" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="loop-y">
																		<?php lsGetInput( $lsDefaults['layers']['loopOffsetY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-units' => 'px % top lh sh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-loop',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopScaleX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-link' => 'scale-transition-loop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopScaleY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-link' => 'scale-transition-loop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopRotate'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('Z (normal)', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopRotateX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopRotateY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopSkewX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopSkewY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Mask', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="mask" data-smart-help-title="<?= __('Mask', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['loopClip'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['loopTransformOrigin'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['loopPerspective'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('Start when', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetInput( $lsDefaults['layers']['loopStartAt'], null, [
																			'class' => 'lse-transition-prop lse-start-at-calc lse-undomanager-merge'
																		]) ?>
																		<?php lsGetSelect( $lsDefaults['layers']['loopStartAtTiming'], null, [
																			'class' => 'lse-transition-prop lse-start-at-timing'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('with modifier', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-1-3">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['loopStartAtOperator'], null, [
																			'class' => 'lse-transition-prop lse-start-at-operator'
																		]) ?>
																	</lse-fe-wrapper>

																	<?php lsGetInput( $lsDefaults['layers']['loopStartAtValue'], null, [
																		'class' => 'lse-transition-prop lse-start-at-value'
																	]) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['loopDuration'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['loopEasing'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Repeat', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['loopCount'], null, [
																			'class' => 'lse-transition-prop'
																		], true ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Wait', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="loopwait" data-smart-help-title="<?= __('Loop Wait', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['loopWait'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Yoyo', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['loopYoyo'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Opacity', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-half">
																	<?php lsGetInput( $lsDefaults['layers']['loopOpacity'], null, [
																		'type' 	=> 'range',
																		'min' 	=> 0,
																		'max' 	=> 1,
																		'step' 	=> 0.05,
																		'name' 	=> '',
																		'class' => 'lse-small lse-transition-prop'
																	]) ?>

																	<?php lsGetInput( $lsDefaults['layers']['loopOpacity'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Filter', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="filter" data-smart-help-title="<?= __('Filter', 'LayerSlider') ?>" data-smart-options="filter" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['loopFilter'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

											<!-- ENDING TEXT TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light lse-disabled" data-storage="ending-text-transition" data-section-name="<?= __('Ending Text Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['textTransitionOut'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-ending-text-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer-text class="lse-preview-layer-t1">t</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t2">e</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t3">x</lse-preview-layer-text>
														<lse-preview-layer-text class="lse-preview-layer-t4">t</lse-preview-layer-text>
													</lse-preview-slider>
													<lse-tt><?= __('Animates characters, words, or lines of text as they leave the scene. <br><br> Each fragment animate from the whole joint text toward the options you set here.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-text>
																		<?= __('Animate', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['textTypeOut'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsettextout" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="textout-x">
																		<?php lsGetInput( $lsDefaults['layers']['textOffsetXOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-units' => 'px % left lw sw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsettextout" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="textout-y">
																		<?php lsGetInput( $lsDefaults['layers']['textOffsetYOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-units' => 'px % top lh sh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-text-out',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaletextout" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textScaleXOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-link' => 'scale-transition-text-out'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaletextout" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textScaleYOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-link' => 'scale-transition-text-out'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('Z (normal)', 'LayerSlider'),
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateXOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotatetextout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textRotateYOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewtextout" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textSkewXOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewtextout" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-help-filter="text">
																		<?php lsGetInput( $lsDefaults['layers']['textSkewYOut'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['textTransformOriginOut'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['textPerspectiveOut'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('Start when', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetInput( $lsDefaults['layers']['textStartAtOut'], null, [
																			'class' => 'lse-transition-prop lse-start-at-calc lse-undomanager-merge'
																		]) ?>
																		<?php lsGetSelect( $lsDefaults['layers']['textStartAtOutTiming'], null, [
																			'class' => 'lse-transition-prop lse-start-at-timing'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('with modifier', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-1-3">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['textStartAtOutOperator'], null, [
																			'class' => 'lse-transition-prop lse-start-at-operator'
																		]) ?>
																	</lse-fe-wrapper>
																	<?php lsGetInput( $lsDefaults['layers']['textStartAtOutValue'], null, [
																		'class' => 'lse-transition-prop lse-start-at-value'
																	]) ?>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['textDurationOut'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Shift out', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="textshiftduration" data-smart-help-title="<?= __('Shift Out', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['textShiftOut'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['textEasingOut'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Fade', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['textFadeOut'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

											<!-- ENDING TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light" data-storage="ending-transition" data-section-name="<?= __('Ending Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['transitionOut'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-ending-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer></lse-preview-layer>
													</lse-preview-slider>
													<lse-tt><?= __('Plays when layers leave the scene. <br><br> Animates layers from their current state toward the options you set here.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsetout" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="out-x">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutOffsetX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-units' => 'px % left lw sw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offsetout" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="out-y">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutOffsetY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-units' => 'px % top lh sh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-out',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaleout" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutScaleX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-link' => 'scale-transition-out'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scaleout" data-smart-options="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutScaleY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-link' => 'scale-transition-out'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotateout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutRotate'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('Z (normal)', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotateout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutRotateX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotateout" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutRotateY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewout" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutSkewX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skewout" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutSkewY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Size', 'LayerSlider') ?><lse-props><?= __('width', 'LayerSlider') ?>, <?= __('height', 'LayerSlider') ?></lse-props><lse-cur-prop></lse-cur-prop><lse-units>px</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutWidth'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('width', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutHeight'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('height', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Mask', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="mask" data-smart-help-title="<?= __('Mask', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutClip'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutTransformOrigin'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutPerspective'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('Start when', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutStartAt'], null, [
																			'class' => 'lse-transition-prop lse-start-at-calc lse-undomanager-merge'
																		]) ?>
																		<?php lsGetSelect( $lsDefaults['layers']['transitionOutStartAtTiming'], null, [
																			'class' => 'lse-transition-prop lse-start-at-timing'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full lse-start-at-wrapper">
																<lse-ib>
																	<lse-text>
																		<?= __('with modifier', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-1-3">
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['transitionOutStartAtOperator'], null, [
																			'class' => 'lse-transition-prop lse-start-at-operator'
																		]) ?>
																	</lse-fe-wrapper>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutStartAtValue'], null, [
																			'class' => 'lse-transition-prop lse-start-at-value'
																		]) ?>
																		<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutDuration'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['transitionOutEasing'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Fade', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-jcc">
																	<?php lsGetCheckbox( $lsDefaults['layers']['transitionOutFade'], null, [
																		'class' => 'lse-transition-prop'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Text Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="textColor" data-smart-help-title="<?= __('Text Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutColor'], null, [
																			'class' => 'lse-transition-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Background Color', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="backgroundColor" data-smart-help-title="<?= __('Background Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutBGColor'], null, [
																			'class' => 'lse-transition-prop'
																		] ) ?>
																		<?= lsGetSVGIcon('times', null, [
																			'class' => 'lse-remove lse-it-0'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Filter', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="filterout" data-smart-help-title="<?= __('Filter', 'LayerSlider') ?>" data-smart-options="filter" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['transitionOutFilter'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																		'class' => 'lse-can-be-activated',
																		'data-link-property' => 'border-radius-transition-out',
																		'data-tt' => ''
																	]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Rounding', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px % em</lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-quarter">
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-out" data-cv-id="1" data-prop-type="<?= __('top-left', 'LayerSlider') ?>" data-link="border-radius-transition-out">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-out" data-cv-id="2" data-prop-type="<?= __('top-right', 'LayerSlider') ?>" data-link="border-radius-transition-out">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-out" data-cv-id="3" data-prop-type="<?= __('btm-right', 'LayerSlider') ?>" data-link="border-radius-transition-out">
																	</lse-fe-wrapper>
																	<lse-fe-wrapper>
																	<input type="text" data-cv="border-radius-transition-out" data-cv-id="4" data-prop-type="<?= __('btm-left', 'LayerSlider') ?>" data-link="border-radius-transition-out">
																	</lse-fe-wrapper>
																	<?php lsGetInput( $lsDefaults['layers']['transitionOutRadius'], null, [
																		'class' 	=> 'lse-transition-prop lse-restore-prop lse-undomanager-merge',
																		'data-sv' 	=> 'border-radius-transition-out',
																		'type' 		=> 'hidden'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

											<!-- HOVER TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light lse-disabled" data-storage="hover-transition" data-section-name="<?= __('Hover Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['hover'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-hover-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-layer></lse-preview-layer>
													</lse-preview-slider>
													<lse-tt><?= __('Plays transition when users tap or move their mouse cursor over layers.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>


												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transformation', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Offset', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offset" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | X axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="hover-x">
																		<?php lsGetInput( $lsDefaults['layers']['hoverOffsetX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-units' => 'px % lw +'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="offset" data-smart-help-title="<?= __('Offset', 'LayerSlider') ?>" data-smart-options-title="<?= __('Offset | Y axis', 'LayerSlider') ?>" data-smart-options="offset" data-smart-operations data-smart-help-filter="hover-y">
																		<?php lsGetInput( $lsDefaults['layers']['hoverOffsetY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-units' => 'px % lh +'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<?= lsGetSVGIcon('link','regular',[
																			'class' => 'lse-can-be-activated',
																			'data-link-property' => 'scale-transition-hover',
																			'data-tt' => ''
																		]) ?>
																	<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																	<lse-text>
																		<?= __('Scale', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= __('number', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | X axis', 'LayerSlider') ?>" data-smart-operations data-smart-options="scale">
																		<?php lsGetInput( $lsDefaults['layers']['hoverScaleX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X',
																			'data-link' => 'scale-transition-hover'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="scale" data-smart-help-title="<?= __('Scale', 'LayerSlider') ?>" data-smart-options-title="<?= __('Scale | Y axis', 'LayerSlider') ?>" data-smart-operations data-smart-options="scale">
																		<?php lsGetInput( $lsDefaults['layers']['hoverScaleY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y',
																			'data-link' => 'scale-transition-hover'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?><lse-props>Z, X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-third">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverRotate'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => __('Z (normal)', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverRotateX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="rotate" data-smart-options="rotate" data-smart-help-title="<?= __('Rotation', 'LayerSlider') ?>" data-smart-options-title="<?= __('Rotation | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverRotateY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																	<?= __('Skew', 'LayerSlider') ?><lse-props>X, Y</lse-props><lse-cur-prop></lse-cur-prop><lse-units><?= _x('degree', 'measurement unit', 'LayerSlider') ?></lse-units>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-half">
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | X axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverSkewX'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'X'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="skew" data-smart-options="skew" data-smart-help-title="<?= __('Skew', 'LayerSlider') ?>" data-smart-options-title="<?= __('Skew | Y axis', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverSkewY'], null, [
																			'class' => 'lse-transition-prop',
																			'data-prop-type' => 'Y'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['hoverTransformOrigin'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['hoverTransformPerspective'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverInDuration'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Reverse', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="duration" data-smart-help-title="<?= __('Duration | reverse', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['hoverOutDuration'], null, [
																			'class' => 'lse-transition-prop',
																			'placeholder' => __('Same', 'LayerSlider')
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Easing', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['hoverInEasing'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => $lsDefaults['easings']
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Reverse', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing | reverse', 'LayerSlider') ?>">
																		<?php lsGetSelect( $lsDefaults['layers']['hoverOutEasing'], null, [
																			'class' => 'lse-transition-prop',
																			'options' => array_merge( [ '' => __('Same', 'LayerSlider') ], $lsDefaults['easings'] )
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Style Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

												<lse-grid class="lse-form-elements">
													<lse-row>
														<lse-col>
															<lse-ib>
																<lse-text>
																	<?= __('Opacity', 'LayerSlider') ?>
																</lse-text>
															</lse-ib>
															<lse-ib class="lse-range-inputs lse-half">
																<?php lsGetInput( $lsDefaults['layers']['hoverOpacity'], null, [
																	'type' 	=> 'range',
																	'min' 	=> 0,
																	'max' 	=> 1,
																	'step' 	=> 0.05,
																	'name' 	=> '',
																	'class' => 'lse-small lse-transition-prop'
																]) ?>
																<?php lsGetInput( $lsDefaults['layers']['hoverOpacity'], null, [
																	'class' => 'lse-transition-prop'
																]) ?>
															</lse-ib>
														</lse-col>
														<lse-col>
															<lse-ib>
																<lse-text>
																	<?= __('Always on top', 'LayerSlider') ?>
																</lse-text>
															</lse-ib>
															<lse-ib class="lse-jcc">
																<?php lsGetCheckbox( $lsDefaults['layers']['hoverTopOn'], null, [
																	'class' => 'lse-style-prop'
																]) ?>
															</lse-ib>
														</lse-col>
														<lse-col>
															<lse-ib>
																<lse-text>
																	<?= __('Text Color', 'LayerSlider') ?>
																</lse-text>
															</lse-ib>
															<lse-ib>
																<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="textColor" data-smart-help-title="<?= __('Text Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																	<?php lsGetInput( $lsDefaults['layers']['hoverColor'], null, [
																		'class' => 'lse-transition-prop'
																	] ) ?>
																	<?= lsGetSVGIcon('times', null, [
																		'class' => 'lse-remove lse-it-0'
																	]) ?>
																</lse-fe-wrapper>
															</lse-ib>
														</lse-col>
														<lse-col>
															<lse-ib>
																<lse-text>
																	<?= __('Background Color', 'LayerSlider') ?>
																</lse-text>
															</lse-ib>
															<lse-ib>
																<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="backgroundColor" data-smart-help-title="<?= __('Background Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
																<?php lsGetInput( $lsDefaults['layers']['hoverBGColor'], null, [
																	'class' => 'lse-transition-prop'
																] ) ?>
																<?= lsGetSVGIcon('times', null, [
																	'class' => 'lse-remove lse-it-0'
																]) ?>
																</lse-fe-wrapper>
															</lse-ib>
														</lse-col>
														<lse-col class="lse-full">
															<lse-ib>
																<?= lsGetSVGIcon('link','regular',[
																	'class' => 'lse-can-be-activated',
																	'data-link-property' => 'border-radius-transition-hover',
																	'data-tt' => ''
																]) ?>
																<lse-tt><?= __('Link / Unlink fields', 'LayerSlider') ?></lse-tt>

																<lse-text>
																	<?= __('Rounding', 'LayerSlider') ?> <lse-cur-prop></lse-cur-prop><lse-units>px % em</lse-units>
																</lse-text>
															</lse-ib>
															<lse-ib class="lse-quarter">
																<lse-fe-wrapper>
																<input type="text" data-cv="border-radius-transition-hover" data-cv-id="1" data-prop-type="<?= __('top-left', 'LayerSlider') ?>" data-link="border-radius-transition-hover">
																</lse-fe-wrapper>
																<lse-fe-wrapper>
																<input type="text" data-cv="border-radius-transition-hover" data-cv-id="2" data-prop-type="<?= __('top-right', 'LayerSlider') ?>" data-link="border-radius-transition-hover">
																</lse-fe-wrapper>
																<lse-fe-wrapper>
																<input type="text" data-cv="border-radius-transition-hover" data-cv-id="3" data-prop-type="<?= __('btm-right', 'LayerSlider') ?>" data-link="border-radius-transition-hover">
																</lse-fe-wrapper>
																<lse-fe-wrapper>
																<input type="text" data-cv="border-radius-transition-hover" data-cv-id="4" data-prop-type="<?= __('btm-left', 'LayerSlider') ?>" data-link="border-radius-transition-hover">
																</lse-fe-wrapper>
																<?php lsGetInput( $lsDefaults['layers']['hoverBorderRadius'], null, [
																	'class' 	=> 'lse-transition-prop lse-restore-prop lse-undomanager-merge',
																	'data-sv' 	=> 'border-radius-transition-hover',
																	'type' 		=> 'hidden'
																]) ?>
															</lse-ib>
														</lse-col>
														<lse-col-placeholder></lse-col-placeholder>
													</lse-row>
												</lse-grid>

												</lse-sidebar-section-body>
											</lse-sidebar-section>

											<!-- PARALLAX TRANSITION -->
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light lse-disabled" data-storage="parallax-transition" data-section-name="<?= __('Parallax Transition', 'LayerSlider') ?>">

												<lse-button-group class="lse-toolbar lse-aic lse-jcfe">

													<?php lsGetCheckbox( $lsDefaults['layers']['parallax'], null, [
														'class' => 'lse-transition-prop lse-layer-transition-checkbox',
														'data-lse-undomanager-exclude' => 1,
														'data-lse-update-data-exclude' => 1
													]) ?>

													<lse-button class="lse-copy-layer-properties" data-tt=".tt-copy-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('copy','regular') ?>
													</lse-button>

													<lse-button class="lse-paste-layer-properties" data-tt=".tt-paste-transition-properties" data-tt-de="0" data-tt-pos="bottom">
														<?= lsGetSVGIcon('paste') ?>
													</lse-button>

												</lse-button-group>

												<lse-transition-preview id="lse-parallax-transition-preview">
													<lse-preview-slider data-tt-pos="left" data-tt data-tt-de="0">
														<lse-preview-slider-side></lse-preview-slider-side>
														<lse-preview-layer class="lse-preview-layer-p1"></lse-preview-layer>
														<lse-preview-layer class="lse-preview-layer-p2"></lse-preview-layer>
													</lse-preview-slider>
													<lse-tt><?= __('Moves layers at a different pace when scrolling or moving the mouse cursor.', 'LayerSlider') ?></lse-tt>
												</lse-transition-preview>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Parallax Settings', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-text>
																		<?= __('Parallax Level', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib class="lse-range-inputs lse-2-1">
																	<?php lsGetInput( $lsDefaults['layers']['parallaxLevel'], null, [
																		'type' 	=> 'range',
																		'min' 	=> -30,
																		'max' 	=> 30,
																		'step' 	=> 1,
																		'name' 	=> '',
																		'class' => 'lse-small lse-transition-prop'
																	]) ?>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxlevel" data-smart-help-title="<?= __('Parallax Level', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxLevel'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Type', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['parallaxType'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Event', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['parallaxEvent'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Axes', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['parallaxAxis'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Distance', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxdistance" data-smart-help-title="<?= __('Parallax Distance', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxDistance'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Rotation', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxrotation" data-smart-help-title="<?= __('Parallax Rotation', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxRotate'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Transform Origin', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="transformOrigin" data-smart-help-title="<?= __('Transform Origin', 'LayerSlider') ?>" data-smart-options="transformOrigin" data-set-values>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxTransformOrigin'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Perspective', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="perspective" data-smart-help-title="<?= __('Perspective', 'LayerSlider') ?>">
																		<?php lsGetInput( $lsDefaults['layers']['parallaxPerspective'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>

														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head class="lse-can-be-closed lse-show-more lse-active">
													<lse-text>
														<?= __('Transition Properties', 'LayerSlider') ?>
													</lse-text>
													<lse-options class="lse-icons-only">
														<?= lsGetSVGIcon('sort-down',false,['class' => 'lse-open']) ?>
														<?= lsGetSVGIcon('sort-up',false,['class' => 'lse-close lse-it-fix-2']) ?>
													</lse-options>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements">
														<lse-row>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Move Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxmoveduration" data-smart-help-title="<?= __('Move Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxDurationMove'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text>
																		<?= __('Leave Duration', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-smart-help" data-smart-help="parallaxleaveduration" data-smart-help-title="<?= __('Leave Duration', 'LayerSlider') ?>" data-smart-operations>
																		<?php lsGetInput( $lsDefaults['layers']['parallaxDurationLeave'], null, [
																			'class' => 'lse-transition-prop'
																		]) ?>
																	</lse-fe-wrapper>
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>

										</lse-sidebar-content>

									</lse-sidebar-body>


									<!-- Link -->
									<lse-sidebar-body data-section-name="<?= __('Link', 'LayerSlider') ?>">

										<lse-sidebar-content>
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">
												<lse-sidebar-section-head>
													<lse-text><?= __('Layer linking', 'LayerSlider') ?></lse-text>
												</lse-sidebar-section-head>
												<lse-sidebar-section-body>
													<lse-grid class="lse-form-elements lse-link-fields">
														<lse-row>
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-text>
																		<?= __('Set link', 'LayerSlider') ?>
																	</lse-text>
																</lse-ib>
																<lse-ib>
																	<?php lsGetInput( $lsDefaults['layers']['linkURL'], null, [
																		'class' => 'lse-link-url-input',
																		'placeholder' => $lsDefaults['layers']['linkURL']['name']
																	]) ?>


																	<?php lsGetInput( $lsDefaults['layers']['linkId'], null, [ 'type' => 'hidden' ]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['linkName'], null, [ 'type' => 'hidden' ]) ?>
																	<?php lsGetInput( $lsDefaults['layers']['linkType'], null, [ 'type' => 'hidden' ]) ?>

																	<?= lsGetSVGIcon('times', null, [
																		'class' => 'lse-remove lse-it-0'
																	]) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-hide-if-has-link">
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-link-post"><?= __('Choose Post or Page', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-hide-if-has-link">
																<lse-ib class="lse-jcc">
																	<lse-button class="lse-link-dyn"><?= __('Use dynamic post URL', 'LayerSlider') ?></lse-button>
																</lse-ib>
															</lse-col>
															<lse-separator></lse-separator>
															<lse-col class="lse-full">
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<?php lsGetSelect( $lsDefaults['layers']['linkTarget'] ) ?>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>
												</lse-sidebar-section-body>
											</lse-sidebar-section>
										</lse-sidebar-content>
									</lse-sidebar-body>

									<!-- Actions -->
									<lse-sidebar-body data-section-name="<?= __('Actions', 'LayerSlider') ?>">
										<lse-sidebar-content>
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text><?= __('Layer Actions', 'LayerSlider') ?></lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-wrapper id="lse-layer-actions-data">

														<!-- Scroll -->
														<lse-b data-layer-action="scrollBelowProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Scrolls below the project, pushing it outside of the viewport to make room for any content that follows.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Duration', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="duration" value="1000">
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Easing', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<select name="easing">
																			<?php foreach( $lsDefaults['easings'] as $easing ) : ?>
																			<option <?= ( $easing === 'easeInOutQuart' ) ? 'selected' : '' ?>><?= $easing ?></option>
																			<?php endforeach ?>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Scroll Offset', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="number" name="offset" value="0">
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="scrollToNextProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Scrolls to the next LayerSlider project on page (if there’s any).', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Duration', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="duration" value="1000">
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Easing', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<select name="easing">
																			<?php foreach( $lsDefaults['easings'] as $easing ) : ?>
																			<option <?= ( $easing === 'easeInOutQuart' ) ? 'selected' : '' ?>><?= $easing ?></option>
																			<?php endforeach ?>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Scroll Offset', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="number" name="offset" value="0">
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="scrollToPrevProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Scrolls to the previous LayerSlider project on page (if there’s any).', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Duration', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="duration" value="1000">
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Easing', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<select name="easing">
																			<?php foreach( $lsDefaults['easings'] as $easing ) : ?>
																			<option <?= ( $easing === 'easeInOutQuart' ) ? 'selected' : '' ?>><?= $easing ?></option>
																			<?php endforeach ?>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Scroll Offset', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="number" name="offset" value="0">
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="scrollToElement">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Scrolls to the specified element. You can enter a CSS/jQuery selector to target elements. To target LayerSlider projects, use custom class names instead of relying on their randomized ID.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Duration', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="duration" value="1000">
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Easing', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select lse-smart-help" data-smart-help="easing" data-smart-help-title="<?= __('Easing', 'LayerSlider') ?>">
																		<select name="easing">
																			<?php foreach( $lsDefaults['easings'] as $easing ) : ?>
																			<option <?= ( $easing === 'easeInOutQuart' ) ? 'selected' : '' ?>><?= $easing ?></option>
																			<?php endforeach ?>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Scroll Offset', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="number" name="offset" value="0">
																	<lse-unit>px</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Selector', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="selector" value="" placeholder=".myClass">
																</lse-ib>
															</lse-col>
														</lse-b>

														<!-- Navigation -->
														<lse-b data-layer-action="switchSlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Jumps to the specified slide. Project Settings like Shuffle mode does not affect the selected slide.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Slide', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<select name="slide" class="lse-layer-action-slide-list">
																			<option disabled><?= __('Select Slide', 'LayerSlider') ?></option>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="nextSlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Jumps to the next slide. Options like Shuffle mode or Two way slideshow can affect the sequence.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="prevSlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Jumps to the previous slide. Options like Shuffle mode or Two way slideshow can affect the sequence.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<!-- Slideshow -->
														<lse-b data-layer-action="stopSlideshow">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Stops the slideshow. Depending on your settings, layer animations and progress timers may not be interrupted, but your project will not commence to the next slide automatically.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="startSlideshow">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Resumes the slideshow and re-enables the automatic slide change.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>


														<!-- Slide Animation Timeline -->
														<lse-b data-layer-action="replaySlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Instantly restarts the slide replaying all layer transitions from the beginning.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="reverseSlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Plays all transitions backward from the moment it’s triggered, then pauses at the beginning of the slide. An option is provided to continue replaying the slide normally afterward.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Replay', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<?= lsGetSwitchControl(['name' => 'replay']) ?>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="resetSlide">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Immediately sets the current slide back to its starting state and pauses it.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<!-- Project Animation Timeline -->
														<lse-b data-layer-action="pauseProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Stops the project by freezing every animation taking place when triggered, including slide transitions when changing slides.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="resumeProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Resumes the project and continues playing frozen animations.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="toggleProject">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Toggles between Pause Project and Resume Project by respecting the current state.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>


														<!-- Media Playback -->
														<lse-b data-layer-action="playMedia">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Starts playback of any active media element on the current slide.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="pauseMedia">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Pauses playback of any active media element on the current slide.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="unmuteMedia">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Unmutes playback of any active media element on the current slide. Using this action may require a Click or Tap trigger due to browser restrictions.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>


														<!-- Popups -->
														<lse-b data-layer-action="openPopup">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Opens Popups waiting in the background to be launched. Popups must be embedded on page.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Open With Slide', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<select name="slide" class="lse-layer-action-slide-list">
																			<option value="" data-protected><?= __('No override', 'LayerSlider') ?></option>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="closePopup">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Closes this Popup. Works only if the current project type is set to a Popup.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>

														<lse-b data-layer-action="closeAllPopups">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Closes all opened Popups on page.', 'LayerSlider') ?>
															</lse-col>
														</lse-b>


														<!-- Advanced -->
														<lse-b data-layer-action="jsFunction">
															<lse-col class="lse-wide lse-layer-action-desc">
																<?= __('Calls a JavaScript function by its name. This is intended for web developers. The function must be present on page prior triggering this action.', 'LayerSlider') ?>
															</lse-col>
															<lse-col>
																<lse-ib>
																	<lse-text><?= __('Function Name', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="text" name="function" value="" placeholder="<?= __('myFunction', 'LayerSlider') ?>">
																</lse-ib>
															</lse-col>
														</lse-b>



													</lse-wrapper>

													<lse-grid id="lse-layer-actions-list" class="lse-form-elements lse-form-rows lse-undomanager-exclude">
														<?= lsGetSVGIcon('times-circle',false,['class' => 'lse-form-rows-close']) ?>
														<lse-row class="lse-placeholder lse-layer-action">
															<lse-col class="lse-wide">
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<select name="action" class="lse-select-layer-action" data-search-name="<?= __('Layer Action', 'LayerSlider') ?>">
																			<option selected disabled value=""><?= __('ADD NEW LAYER ACTION...', 'LayerSlider') ?></option>
																			<option disabled></option>

																			<optgroup label="<?= __('Scroll', 'LayerSlider') ?>">

																				<option value="scrollBelowProject"><?= __('Scroll Below Project', 'LayerSlider') ?></option>
																				<option value="scrollToNextProject"><?= __('Scroll to Next Project', 'LayerSlider') ?></option>
																				<option value="scrollToPrevProject"><?= __('Scroll to Previous Project', 'LayerSlider') ?></option>
																				<option value="scrollToElement"><?= __('Scroll to Element', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Navigation', 'LayerSlider') ?>">
																				<option value="switchSlide"><?= __('Jump to Slide', 'LayerSlider') ?></option>
																				<option value="nextSlide"><?= __('Next Slide', 'LayerSlider') ?></option>
																				<option value="prevSlide"><?= __('Previous Slide', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Slideshow', 'LayerSlider') ?>">
																				<option value="stopSlideshow"><?= __('Stop Slideshow', 'LayerSlider') ?></option>
																				<option value="startSlideshow"><?= __('Start Slideshow', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Slide Animation Timeline', 'LayerSlider') ?>">
																				<option value="replaySlide"><?= __('Replay Slide', 'LayerSlider') ?></option>
																				<option value="reverseSlide"><?= __('Reverse Slide', 'LayerSlider') ?></option>
																				<option value="resetSlide"><?= __('Reset Slide', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Project Animation Timeline', 'LayerSlider') ?>">
																				<option value="pauseProject"><?= __('Pause Project', 'LayerSlider') ?></option>
																				<option value="resumeProject"><?= __('Resume Project', 'LayerSlider') ?></option>
																				<option value="toggleProject"><?= __('Toggle Pause/Resume', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Media Playback', 'LayerSlider') ?>">
																				<option value="playMedia"><?= __('Play Media', 'LayerSlider') ?></option>
																				<option value="pauseMedia"><?= __('Pause Media', 'LayerSlider') ?></option>
																				<option value="unmuteMedia"><?= __('Unmute Media', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Popups', 'LayerSlider') ?>">
																				<option value="openPopup"><?= __('Open Popup', 'LayerSlider') ?></option>
																				<option value="closePopup"><?= __('Close Popup', 'LayerSlider') ?></option>
																				<option value="closeAllPopups"><?= __('Close All Popups', 'LayerSlider') ?></option>
																			</optgroup>

																			<optgroup label="<?= __('Advanced', 'LayerSlider') ?>">
																				<option value="jsFunction"><?= __('Call JavaScript function', 'LayerSlider') ?></option>
																			</optgroup>

																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide lse-layer-action-desc"></lse-col>
															<lse-col class="lse-dn">
																<lse-ib>
																	<lse-text><?= __('Trigger', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<lse-fe-wrapper class="lse-select">
																		<select name="trigger">
																			<option value="click"><?= __('Click or Tap', 'LayerSlider') ?></option>
																			<option value="mouseenter"><?= __('Mouse Enter', 'LayerSlider') ?></option>
																			<option value="mouseleave"><?= __('Mouse Leave', 'LayerSlider') ?></option>
																		</select>
																	</lse-fe-wrapper>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-dn">
																<lse-ib>
																	<lse-text><?= __('Delay', 'LayerSlider') ?></lse-text>
																</lse-ib>
																<lse-ib>
																	<input type="number" name="delay" min="0" step="100" value="0">
																	<lse-unit>ms</lse-unit>
																</lse-ib>
															</lse-col>
															<lse-col-separator></lse-col-separator>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

											</lse-sidebar-section>
										</lse-sidebar-content>
									</lse-sidebar-body>

									<!-- Attributes -->
									<lse-sidebar-body data-section-name="<?= __('Attributes', 'LayerSlider') ?>">
										<lse-sidebar-content>
											<lse-sidebar-section class="lse-scrollbar lse-scrollbar-light">

												<lse-sidebar-section-head>
													<lse-text><?= __('Common Attributes', 'LayerSlider') ?></lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body>

													<lse-grid class="lse-form-elements lse-dark-theme lse-layer-common-attributes">
														<lse-row>
															<lse-col class="lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" value="id" disabled>
																	<?php lsGetInput( $lsDefaults['layers']['ID']) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" value="class" disabled>
																	<?php lsGetInput( $lsDefaults['layers']['class']) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" value="title" disabled>
																	<?php lsGetInput( $lsDefaults['layers']['title']) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" value="alt" disabled>
																	<?php lsGetInput( $lsDefaults['layers']['alt']) ?>
																</lse-ib>
															</lse-col>
															<lse-col class="lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" value="rel" disabled>
																	<?php lsGetInput( $lsDefaults['layers']['rel']) ?>
																</lse-ib>
															</lse-col>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>

												<lse-sidebar-section-head>
													<lse-text><?= __('Custom Attributes', 'LayerSlider') ?></lse-text>
												</lse-sidebar-section-head>

												<lse-sidebar-section-body class="lse-layer-custom-attributes">

													<lse-grid class="lse-form-elements lse-form-rows">
														<?= lsGetSVGIcon('times-circle',false,['class' => 'lse-form-rows-close']) ?>
														<lse-row>
															<lse-col class="lse-placeholder lse-wide">
																<lse-ib class="lse-1-2">
																	<input type="text" placeholder="key" class="lse-key">
																	<input type="text" placeholder="value" class="lse-value">
																	<label class="ls-switch" data-tt-de="0" data-tt=".tt-custom-attributes-checkbox"><input type="checkbox" checked><ls-switch></ls-switch></label>
																</lse-ib>
															</lse-col>
															<lse-col-placeholder></lse-col-placeholder>
														</lse-row>
													</lse-grid>

												</lse-sidebar-section-body>
											</lse-sidebar-section>
										</lse-sidebar-content>
									</lse-sidebar-body>

								</lse-layer-settings>

								<!-- NAVIGATION SETTINGS -->

								<lse-action-buttons class="lse-sidebar">

									<lse-button-group class="lse-text-center">
										<lse-button id="lse-save-button">
											<?= lsGetSVGIcon('save') ?>
											<?= lsGetSVGIcon('spinner-third','duotone',['class' => 'lse-show-on-action']) ?>
											<lse-text><?= __('Save', 'LayerSlider') ?></lse-text>
											<lse-text class="lse-show-on-action"><?= __('Saving', 'LayerSlider') ?></lse-text>
										</lse-button>
										<lse-button id="lse-publish-button">
											<?= lsGetSVGIcon('cloud-upload-alt') ?>
											<?= lsGetSVGIcon('spinner-third','duotone',['class' => 'lse-show-on-action']) ?>
											<lse-text><?= __('Publish', 'LayerSlider') ?></lse-text>
											<lse-text class="lse-show-on-action"><?= __('Publishing', 'LayerSlider') ?></lse-text>
										</lse-button>
									</lse-button-group>

								</lse-action-buttons>

							</lse-sidebars-holder>

						</lse-sidebar-inner>

					</lse-sidebar>

				</lse-right-frame>

			</lse-main-frame>

		</lse-main-frame>
	</lse-editor>

</form>

<?php include LS_ROOT_PATH . '/templates/tmpl-smart-help.php'; ?>

<!-- GLOBAL TOOLTIPS -->

<lse-tt class="tt-clear-property">
	<?= __('Restore to defaults', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-slide-transition-sample lse-theme-light" id="lse-slide-transition-sample">
</lse-tt>
<lse-tt class="tt-advanced">
	<?= __('This feature requires license registration. Click on the padlock to learn more.', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-premium lse-premium">
	<?= __('This feature requires license registration. Click on the padlock to learn more.', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-global-hover">
	<?= __('Triggers all hover transitions at once when moving the mouse cursor over or tapping on the slide.', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-custom-attributes-checkbox">
	<?= htmlentities( __('In some cases your layers may be wrapped by another element. For example, an ＜A＞ tag when you use layer linking. By default, new attributes will be applied on the wrapper (if any), which is desirable in most cases (e.g. lightbox plugins). If there is no wrapper element, attributes will be automatically applied on the layer itself. Uncheck this option when you need to apply this attribute on the layer element in all cases.', 'LayerSlider') ) ?>
</lse-tt>
<lse-tt class="tt-position-layers-list">
	<?= __('Set layers list position', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-dock-layers-list">
	<?= __('Dock layers list', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-pin-layers-list">
	<?= __('Pin layers list', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-close-layers-list">
	<?= __('Close layers list', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-copy-style-properties">
	<?= __('Copy style properties', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-paste-style-properties">
	<?= __('Paste style properties', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-copy-transition-properties">
	<?= __('Copy transition properties', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-paste-transition-properties">
	<?= __('Paste transition properties', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-expand-sidebar">
	<?= __('Expand / shrink sidebar', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-left-top">
	<?= __('Align item to top left', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-center-top">
	<?= __('Align item to top center', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-right-top">
	<?= __('Align item to top right', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-left-center">
	<?= __('Align item to center left', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-center-center">
	<?= __('Align item to center center', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-right-center">
	<?= __('Align item to center right', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-left-bottom">
	<?= __('Align item to bottom left', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-center-bottom">
	<?= __('Align item to bottom center', 'LayerSlider') ?>
</lse-tt>
<lse-tt class="tt-align-right-bottom">
	<?= __('Align item to bottom right', 'LayerSlider') ?>
</lse-tt>

<!-- CONTEXT MENUS GO HERE -->

<div class="lse-context-menu-holder">

	<div id="lse-context-menu-preview" class="lse-floating-window-theme">
		<lse-context-content class="lse-menu">
			<lse-submenu-wrapper>
				<lse-button>
					<?= lsGetSVGIcon('plus') ?>
					<lse-text><?= __('Add Layer', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('chevron-right','regular',['class' => 'lse-submenu-icon']) ?>
				</lse-button>
				<lse-submenu class="lse-context-add-layer">
					<lse-button data-type="img">
						<?= lsGetSVGIcon('image-polaroid', 'regular') ?>
						<span><?= __('Image', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="text">
						<?= lsGetSVGIcon('align-left') ?>
						<span><?= __('Text', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="media">
						<?= lsGetSVGIcon('play-circle') ?>
						<span><?= __('Video / Audio', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="button">
						<?= lsGetSVGIcon('dot-circle') ?>
						<span><?= __('Button', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="shape-modal">
						<?= lsGetSVGIcon('shapes') ?>
						<span><?= __('Shape', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="icon-modal">
						<?= lsGetSVGIcon('icons') ?>
						<span><?= __('Icon', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="svg-modal">
						<?= lsGetSVGIcon('stars') ?>
						<span><?= __('Object', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="html">
						<?= lsGetSVGIcon('code') ?>
						<span><?= __('HTML', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="post">
						<?= lsGetSVGIcon('database') ?>
						<span><?= __('Dynamic Layer', 'LayerSlider') ?></span>
					</lse-button>
					<lse-button data-type="import">
						<?= lsGetSVGIcon('file-import') ?>
						<span><?= __('Import Layer', 'LayerSlider') ?></span>
					</lse-button>
				</lse-submenu>
			</lse-submenu-wrapper>
			<lse-submenu-wrapper class="lse-context-overlapping-layers">
				<lse-button>
					<?= lsGetSVGIcon('bring-forward') ?>
					<lse-text><?= __('Overlapping Layers', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('chevron-right','regular',['class' => 'lse-submenu-icon']) ?>
				</lse-button>
				<lse-submenu></lse-submenu>
			</lse-submenu-wrapper>
			<lse-submenu-wrapper>
				<lse-button>
					<?= lsGetSVGIcon('border-inner', 'duotone') ?>
					<lse-text class="lse-context-menu-single"><?= __('Align Layer', 'LayerSlider') ?></lse-text>
					<lse-text class="lse-context-menu-multiple"><?= __('Align Layers', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('chevron-right','regular',['class' => 'lse-submenu-icon']) ?>
				</lse-button>
				<lse-submenu class="lse-context-menu-align">
					<lse-button data-move="left">
						<?= lsGetSVGIcon('border-left', 'duotone') ?>
						<lse-text><?= __('Left Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="center">
						<?= lsGetSVGIcon('border-center-v', 'duotone') ?>
						<lse-text><?= __('Horizontal Center', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="right">
						<?= lsGetSVGIcon('border-right', 'duotone') ?>
						<lse-text><?= __('Right Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-separator></lse-separator>
					<lse-button data-move="top">
						<?= lsGetSVGIcon('border-top', 'duotone') ?>
						<lse-text><?= __('Top Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="middle">
						<?= lsGetSVGIcon('border-center-h', 'duotone') ?>
						<lse-text><?= __('Vertical Center', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="bottom">
						<?= lsGetSVGIcon('border-bottom', 'duotone') ?>
						<lse-text><?= __('Bottom Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-separator></lse-separator>
					<lse-button data-move="middle center" class="ls-align-center-center">
						<?= lsGetSVGIcon('border-inner', 'duotone') ?>
						<lse-text><?= __('Center Center', 'LayerSlider') ?></lse-text>
					</lse-button>
				</lse-submenu>
			</lse-submenu-wrapper>
			<lse-submenu-wrapper class="lse-context-menu-align-in-selection">
				<lse-button>
					<?= lsGetSVGIcon('align-layers-left', 'misc') ?>
					<lse-text><?= __('Align Layers in Selection', 'LayerSlider') ?></lse-text>
					<?= lsGetSVGIcon('chevron-right','regular',['class' => 'lse-submenu-icon']) ?>
				</lse-button>
				<lse-submenu>
					<lse-button data-move="left">
						<?= lsGetSVGIcon('align-layers-left', 'misc') ?>
						<lse-text><?= __('Left Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="center">
						<?= lsGetSVGIcon('align-layers-center-h', 'misc') ?>
						<lse-text><?= __('Horizontal Center', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="right">
						<?= lsGetSVGIcon('align-layers-right', 'misc') ?>
						<lse-text><?= __('Right Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-separator></lse-separator>
					<lse-button data-move="top">
						<?= lsGetSVGIcon('align-layers-top', 'misc') ?>
						<lse-text><?= __('Top Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="middle">
						<?= lsGetSVGIcon('align-layers-center-v', 'misc') ?>
						<lse-text><?= __('Vertical Center', 'LayerSlider') ?></lse-text>
					</lse-button>
					<lse-button data-move="bottom">
						<?= lsGetSVGIcon('align-layers-bottom', 'misc') ?>
						<lse-text><?= __('Bottom Edge', 'LayerSlider') ?></lse-text>
					</lse-button>
				</lse-submenu>
			</lse-submenu-wrapper>
			<lse-button class="lse-context-menu-duplicate">
				<?= lsGetSVGIcon('clone') ?>
				<lse-text class="lse-context-menu-single"><?= __('Duplicate Layer', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Duplicate Layers', 'LayerSlider') ?></lse-text>
				<kbd>
					<kbd class="ls-mac-key">⌘</kbd>
					<kbd class="ls-win-key">⌃</kbd>
					<kbd>D</kbd>
				</kbd>
			</lse-button>
			<lse-button class="lse-context-menu-remove">
				<?= lsGetSVGIcon('trash-alt') ?>
				<lse-text class="lse-context-menu-single"><?= __('Remove Layer', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Remove Layers', 'LayerSlider') ?></lse-text>
				<kbd>&#9003;</kbd>
			</lse-button>
			<lse-button class="lse-context-menu-copy-layer">
				<?= lsGetSVGIcon('copy') ?>
				<lse-text class="lse-context-menu-single"><?= __('Copy Layer', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Copy Layers', 'LayerSlider') ?></lse-text>
				<kbd>
					<kbd class="ls-mac-key">⌘</kbd>
					<kbd class="ls-win-key">⌃</kbd>
					<kbd>C</kbd>
				</kbd>
			</lse-button>
			<lse-button class="lse-context-menu-paste-layer">
				<?= lsGetSVGIcon('clipboard') ?>
				<lse-text class="lse-context-menu-single"><?= __('Paste Layer', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Paste Layers', 'LayerSlider') ?></lse-text>
				<kbd>
					<kbd class="ls-mac-key">⌘</kbd>
					<kbd class="ls-win-key">⌃</kbd>
					<kbd>V</kbd>
				</kbd>
			</lse-button>
			<lse-separator></lse-separator>
			<lse-button class="lse-context-menu-hide">
				<?= lsGetSVGIcon('eye') ?>
				<lse-text class="lse-context-menu-single"><?= __('Toggle Layer Visibility', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Toggle Layers Visibility', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-button class="lse-context-menu-lock">
				<?= lsGetSVGIcon('lock') ?>
				<lse-text class="lse-context-menu-single"><?= __('Toggle Layer Locking', 'LayerSlider') ?></lse-text>
				<lse-text class="lse-context-menu-multiple"><?= __('Toggle Layers Locking', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-separator></lse-separator>
			<lse-button class="lse-context-menu-copy-styles">
				<?= lsGetSVGIcon('copy') ?>
				<lse-text><?= __('Copy Layer Styles', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-button class="lse-context-menu-paste-styles">
				<?= lsGetSVGIcon('clipboard') ?>
				<lse-text><?= __('Paste Layer Styles', 'LayerSlider') ?></lse-text>
			</lse-button>
		</lse-context-content>
	</div>

	<div id="lse-context-menu-image-input" class="lse-floating-window-theme">
		<lse-context-content class="lse-menu">
			<lse-button class="lse-pick-image"><?= lsGetSVGIcon('plus') ?><lse-text><?= __('Pick image', 'LayerSlider') ?></lse-text></lse-button>
			<lse-button class="lse-post-image"><?= lsGetSVGIcon('images','duotone') ?><lse-text><?= __('Use post image', 'LayerSlider') ?></lse-text></lse-button>
			<lse-button class="lse-url-prompt"><?= lsGetSVGIcon('globe') ?><lse-text><?= __('Enter from URL', 'LayerSlider') ?></lse-text></lse-button>
			<lse-separator></lse-separator>
			<lse-button class="lse-pixie-editor"><?= lsGetSVGIcon('pencil-ruler') ?><lse-text><?= __('Image editor', 'LayerSlider') ?></lse-text></lse-button>
			<lse-separator></lse-separator>
			<lse-button class="lse-remove-image"><?= lsGetSVGIcon('times-circle') ?><lse-text><?= __('Remove image', 'LayerSlider') ?></lse-text></lse-button>
		</lse-context-content>
	</div>

	<div id="lse-context-menu-slide-settings" class="lse-floating-window-theme">
		<lse-context-content class="lse-menu">
			<lse-button data-action="duplicate">
				<?= lsGetSVGIcon('clone') ?>
				<lse-text><?= __('Duplicate Slide', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-button data-action="hide">
				<?= lsGetSVGIcon('eye-slash') ?>
				<lse-text><?= __('Unpublish Slide', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-button data-action="unhide">
				<?= lsGetSVGIcon('eye') ?>
				<lse-text><?= __('Publish Slide', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-button data-action="remove">
				<?= lsGetSVGIcon('trash-alt') ?>
				<lse-text><?= __('Remove Slide', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-separator></lse-separator>
			<lse-button data-action="capture">
				<?= lsGetSVGIcon('camera') ?>
				<lse-text><?= __('Generate Thumbnail', 'LayerSlider') ?></lse-text>
			</lse-button>
		</lse-context-content>
	</div>

	<div id="lse-context-menu-sidebars" class="lse-floating-window-theme lse-stop-click-prop">
		<lse-context-head>
			<?= __('Sidebar Settings', 'LayerSlider') ?>
		</lse-context-head>
		<lse-context-content>
			<lse-grid class="lse-form-elements">
				<lse-row>
					<lse-col class="lse-show-only-if-section-tabs">
						<lse-ib>
							<lse-text><?= __('Section tabs', 'LayerSlider') ?></lse-text>
						</lse-ib>
						<lse-ib class="lse-f11">
							<lse-button class="lse-f11 lse-jcc lse-expand-section-tabs">
								<lse-text><?= __('Expand all', 'LayerSlider') ?></lse-text>
							</lse-button>
						</lse-ib>
					</lse-col>
					<lse-col class="lse-show-only-if-section-tabs">
						<lse-ib>
						</lse-ib>
						<lse-ib>
							<lse-button class="lse-f11 lse-jcc lse-collapse-section-tabs">
								<lse-text><?= __('Collapse all', 'LayerSlider') ?></lse-text>
							</lse-button>
						</lse-ib>
					</lse-col>
					<lse-col class="lse-show-only-if-section-tabs">
						<lse-ib>
							<lse-text><?= __('Auto close', 'LayerSlider') ?></lse-text>
						</lse-ib>
						<lse-ib class="lse-jcc">
							<label class="ls-switch lse-small"><input type="checkbox" data-lse-action="autoCloseSectionTabs"><ls-switch></ls-switch></label>
						</lse-ib>
					</lse-col>
					<lse-separator class="lse-show-only-if-section-tabs"></lse-separator>
					<lse-col>
						<lse-ib>
							<lse-text><?= __('Layers List Pos.', 'LayerSlider') ?></lse-text>
						</lse-ib>
						<lse-ib class="lse-jcc">
							<lse-fe-wrapper class="lse-select">
								<select data-lse-action="positionLayersList">
									<option selected value="left"><?= __('Left side', 'LayerSlider') ?></option>
									<option value="right"><?= __('Right side', 'LayerSlider') ?></option>
								</select>
							</lse-fe-wrapper>
						</lse-ib>
					</lse-col>
					<lse-col>
						<lse-ib>
							<lse-text><?= __('Pin Layers List', 'LayerSlider') ?></lse-text>
						</lse-ib>
						<lse-ib class="lse-jcc">
							<label class="ls-switch lse-small"><input type="checkbox" checked data-lse-action="pinLayersList"><ls-switch></ls-switch></label>
						</lse-ib>
					</lse-col>
				</lse-row>
			</lse-grid>
		</lse-context-content>
	</div>

	<div id="lse-context-menu-outer-workspace" class="lse-floating-window-theme lse-stop-click-prop">
		<lse-context-head>
			<?= __('Workspace Settings', 'LayerSlider') ?>
		</lse-context-head>
		<lse-context-content>
			<lse-grid class="lse-form-elements">
				<lse-row>
					<lse-col class="lse-2-1">
						<lse-ib><lse-text><?= __('Show rulers', 'LayerSlider') ?></lse-text></lse-ib>
						<lse-ib class="lse-jcc">
							<label class="ls-switch lse-small"><input data-lse-action="showRulers" type="checkbox" checked="checked"><ls-switch></ls-switch></label>
						</lse-ib>
					</lse-col>
					<lse-col class="lse-2-1">
						<lse-ib><lse-text><?= __('Show guides', 'LayerSlider') ?></lse-text></lse-ib>
						<lse-ib class="lse-jcc">
							<label class="ls-switch lse-small"><input data-lse-action="showGuides" type="checkbox" checked="checked"><ls-switch></ls-switch></label>
						</lse-ib>
					</lse-col>
					<lse-col class="lse-2-1">
						<lse-ib><lse-text><?= __('Show info panel', 'LayerSlider') ?></lse-text></lse-ib>
						<lse-ib class="lse-jcc">
							<label class="ls-switch lse-small"><input data-lse-action="showTinyNote" type="checkbox" checked="checked"><ls-switch></ls-switch></label>
						</lse-ib>
					</lse-col>
					<lse-separator></lse-separator>
					<lse-col class="lse-full">
						<lse-ib>
							<lse-text>
								<?= __('Workspace Padding', 'LayerSlider') ?>
							</lse-text>
						</lse-ib>
						<lse-ib class="lse-2-1 lse-range-inputs lse-set-overscroll">
							<input data-lse-action="setOverscroll" class="lse-small" type="range" min="0" max="500" value="150">
							<input data-lse-action="setOverscroll" type="number" value="150"><lse-unit>px</lse-unit>
						</lse-ib>
					</lse-col>
				</lse-row>

			</lse-grid>
		</lse-context-content>
	</div>

</div>

<!-- CONTEXT MENUS END HERE -->


<?php

include LS_ROOT_PATH . '/templates/tmpl-project-settings.php';
include LS_ROOT_PATH . '/templates/tmpl-layer-item.php';
include LS_ROOT_PATH . '/templates/tmpl-static-layer-item.php';
include LS_ROOT_PATH . '/templates/tmpl-add-layer.php';
include LS_ROOT_PATH . '/templates/tmpl-post-chooser.php';
include LS_ROOT_PATH . '/templates/tmpl-insert-icons-modal.php';
include LS_ROOT_PATH . '/templates/tmpl-insert-media-modal.php';
include LS_ROOT_PATH . '/templates/tmpl-button-presets.php';
include LS_ROOT_PATH . '/templates/tmpl-import-slide.php';
include LS_ROOT_PATH . '/templates/tmpl-import-layer.php';
include LS_ROOT_PATH . '/templates/tmpl-slide-tab.php';
include LS_ROOT_PATH . '/templates/tmpl-activation.php';
include LS_ROOT_PATH . '/templates/tmpl-keyboard-shortcuts.php';
include LS_ROOT_PATH . '/templates/tmpl-embed-slider.php';
include LS_ROOT_PATH . '/templates/tmpl-callback-events-modal.php';
include LS_ROOT_PATH . '/templates/tmpl-shape-modal.php';
include LS_ROOT_PATH . '/templates/tmpl-object-modal.php';
include LS_ROOT_PATH . '/templates/tmpl-revisions-welcome.php';
include LS_ROOT_PATH . '/templates/tmpl-font-library.php';
include LS_ROOT_PATH . '/templates/tmpl-search-window.php';
include LS_ROOT_PATH . '/templates/tmpl-transition-window.php';
?>


<!-- Get slider data from DB -->
<script type="text/javascript">

	// Slider data
	window.lsSliderData = <?= json_encode($slider) ?>;

	// Plugin path
	var pluginPath = '<?= LS_ROOT_URL ?>/static/';
	var lsTrImgPath = '<?= LS_ROOT_URL ?>/static/admin/img/';
</script>
