<?php

	// Prevent direct file access
	defined( 'LS_ROOT_FILE' ) || exit;

	$userID = get_current_user_id();

	LS_Notifications::gatherNotifications();

	$pageSize = (int) get_user_meta( $userID, 'ls-pagination-limit', true );
	$pageSize = empty( $pageSize ) ? 25 : $pageSize;


	// Get current page
	$curPage = (!empty($_GET['paged']) && is_numeric($_GET['paged'])) ? (int) $_GET['paged'] : 1;

	$currentUser = wp_get_current_user();

	// Set filters
	$userFilters 		= false;
	$showHiddenItems 	= false;
	$showPopupSlider	= false;
	$showAllSlider 		= false;

	$urlParamFilter 	= 'published';
	$urlParamOrder 		= 'date_c';
	$urlParamTerm 		= '';

	$filters = [
		'orderby' 	=> 'date_c',
		'order' 	=> 'DESC',
		'page' 		=> $curPage,
		'limit' 	=> $pageSize,
		'drafts' 	=> true,
		'groups' 	=> true
	];

	if( ! empty($_GET['filter']) && $_GET['filter'] === 'all' ) {
		$userFilters = true;
		$showAllSlider = true;
		$urlParamFilter = htmlentities($_GET['filter']);
		$filters['exclude'] = [];
	}

	if( ! empty($_GET['filter']) && $_GET['filter'] === 'hidden') {
		$userFilters = true;
		$showHiddenItems = true;
		$urlParamFilter = htmlentities($_GET['filter']);
		$filters['exclude'] = [];
		$filters['where'] = "flag_deleted = '1'";
	}

	if( ! empty($_GET['filter']) && $_GET['filter'] === 'popup') {
		$userFilters = true;
		$showPopupSlider = true;
		$urlParamFilter = htmlentities($_GET['filter']);
		$filters['exclude'] = [];
		$filters['where'] = "flag_popup = '1'";
	}

	if( ! empty($_GET['order']) ) {
		$userFilters = true;
		$urlParamOrder = $_GET['order'];
		$filters['orderby'] = htmlentities($_GET['order']);

		if( $_GET['order'] === 'name' ) {
			$filters['order'] = 'ASC';
		}
	}

	if( ! empty($_GET['term']) ) {
		$userFilters = true;
		$urlParamTerm = htmlentities($_GET['term']);
		$filters['where'] = "name LIKE '%".esc_sql($_GET['term'])."%' OR slug LIKE '%".esc_sql($_GET['term'])."%' OR id = '".esc_sql($_GET['term'])."'";
	}

	// Find sliders
	$sliders = LS_Sliders::find( $filters );

	// Pager
	$maxItem = LS_Sliders::$count;
	$maxPage = ceil( $maxItem / $pageSize );
	$maxPage = $maxPage ? $maxPage : 1;



	// License & updates
	$code 		= get_option('layerslider-purchase-code', '');
	$validity 	= LS_Config::isActivatedSite();
	$channel 	= get_option('layerslider-release-channel', 'stable');


	// License key
	$codeFormatted = '';
	if(!empty($code)) {
		$start = substr($code, 0, -6);
		$end = substr($code, -6);
		$codeFormatted = preg_replace("/[a-zA-Z0-9]/", '⦁', $start) . $end;
		$codeFormatted = str_replace('-', ' ', $codeFormatted);
	}

	// Template store data
	$lsStoreData 		= LS_RemoteData::get('templates');
	$lsStoreLastViewed 	= get_user_meta( $userID, 'ls-store-last-viewed', true);

	// Update last visited date
	if( empty( $lsStoreLastViewed ) ) {
		$lsStoreLastViewed = time();
		update_user_meta( $userID, 'ls-store-last-viewed', date('Y-m-d'));
	}

	$lsStoreHasUpdate = ( ! empty($lsStoreData['last_updated']) && $lsStoreLastViewed <  $lsStoreData['last_updated'] );


	// Notifications panel contents
	$bellNotifications = LS_Notifications::bellNotifications();
	$inlineNotifications = LS_Notifications::inlineNotifications();


	$pluginUpdates 			= get_plugin_updates();

	// Notification messages
	$notificationsItemCount = ! empty( $_GET['count'] ) ? (int)$_GET['count'] : 0;
	$notifications = [

		'updateStore' => __('LayerSlider Templates have been updated', 'LayerSlider'),

		'hideSelectError' => __('Select an item to hide', 'LayerSlider'),
		'hideSuccess' => sprintf( _n( '%d item has been hidden', '%d items have been hidden', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),

		'duplicateSuccess' => sprintf( _n( '%d item has been duplicated', '%d items have been duplicated', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),
		'duplicateSuccess' => sprintf( _n( '%d item has been duplicated', '%d items have been duplicated', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),

		'deleteSelectError' => __('Select an item to delete', 'LayerSlider'),
		'deleteSuccess' => sprintf( _n( '%d item has been deleted', '%d items have been deleted', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),
		'groupSuccess' => sprintf( _n( '%d item has been grouped', '%d items have been grouped', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),
		'groupSelectError' => __('Select at least 2 items to group them', 'LayerSlider'),
		'mergeSelectError' => __('Select at least 2 items to merge them', 'LayerSlider'),
		'mergeSuccess' => sprintf( __('%d items have been merged as new', 'LayerSlider'), $notificationsItemCount ),
		'restoreSelectError' => __('Select an item to restore', 'LayerSlider'),
		'restoreSuccess' => sprintf( _n( '%d item has been restored', '%d items have been restored', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),

		'exportNotFound' => __('No items were found to export', 'LayerSlider'),
		'exportSelectError' => __('Select an item to export', 'LayerSlider'),
		'exportZipError' => __('The PHP ZipArchive extension is required to import .zip files', 'LayerSlider'),

		'importSelectError' => __('Choose a file to import', 'LayerSlider'),
		'importFailed' => __('The import file seems to be invalid or corrupted', 'LayerSlider'),
		'importSuccess' => sprintf( _n( '%d item has been imported', '%d items have been imported', $notificationsItemCount, 'LayerSlider' ), $notificationsItemCount ),

		'generalUpdated' => __('Settings saved', 'LayerSlider'),
		'cacheEmpty' => __('LayerSlider caches has been emptied', 'LayerSlider'),
		'googleFontsEmpty' => __('Google Fonts has been emptied', 'LayerSlider')
	];


	wp_localize_script('ls-dashboard', 'LS_slidersMeta', [
		'isActivatedSite' => $validity
	]);
	wp_localize_script('ls-dashboard', 'LS_pageMeta', [
		'assetsPath' 	=> LS_ROOT_URL,
		'skinsPath' 	=> LS_ROOT_URL.'/static/layerslider/skins/',
	]);


	// Notify OSD
	if( isset( $_GET['message'] ) ) {
		wp_localize_script('ls-dashboard', 'LS_statusMessage', [
			'icon' 		=> isset( $_GET['error'] ) ? 'error' : 'success',
			'iconColor' => isset( $_GET['error'] ) ? '#ff2323' : '#8BC34A',
			'text' 		=> $notifications[ $_GET['message'] ],
			'timeout' 	=> 8000
		]);
	}

	// Icons
	wp_localize_script('ls-dashboard', 'LS_InterfaceIcons', [

		'notifications' => [
			'error' 	=> lsGetSVGIcon('exclamation-triangle'),
			'success' 	=> lsGetSVGIcon('check'),
		],

		'easteregg' => [
			'check' 	=> lsGetSVGIcon('check'),
			'cat' 		=> lsGetSVGIcon('cat-space', 'duotone'),
			'heart' 	=> lsGetSVGIcon('heart'),
			'rocket' 	=> lsGetSVGIcon('rocket-launch'),
			'hourglass' => lsGetSVGIcon('hourglass-half', 'duotone'),
			'ufo' 		=> lsGetSVGIcon('ufo', 'duotone'),
			'station' 	=> lsGetSVGIcon('space-station-moon', 'duotone'),
			'alien' 	=> lsGetSVGIcon('alien-monster', 'duotone'),
			'galaxy' 	=> lsGetSVGIcon('galaxy', 'duotone')
		]

	]);
?>

<?php include LS_ROOT_PATH . '/includes/ls_global.php'; ?>

<!-- Notify OSD -->
<div class="ls-notify-osd">
	<span class="icon"></span>
	<span class="text"></span>
</div>


<div class="wrap ls-wrap" id="ls-list-page">

	<ls-section id="ls--projects-list">
		<ls-h2 class="ls--mv-2 ls--gray"><?= sprintf( __('Howdy, %s! Welcome to LayerSlider!', 'LayerSlider'), $currentUser->nickname ) ?></ls-h2>

		<?php
			include LS_ROOT_PATH . '/templates/tmpl-add-new-slider.php';
			include LS_ROOT_PATH . '/templates/tmpl-addons-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-slider-group-item.php';
			include LS_ROOT_PATH . '/templates/tmpl-slider-group-placeholder.php';
			include LS_ROOT_PATH . '/templates/tmpl-slider-group-remove-area.php';
			include LS_ROOT_PATH . '/templates/tmpl-import-templates.php';
			include LS_ROOT_PATH . '/templates/tmpl-importing.php';
			include LS_ROOT_PATH . '/templates/tmpl-version-warning.php';
			include LS_ROOT_PATH . '/templates/tmpl-upload-sliders.php';
			include LS_ROOT_PATH . '/templates/tmpl-quick-import.php';
			include LS_ROOT_PATH . '/templates/tmpl-activation.php';
			include LS_ROOT_PATH . '/templates/tmpl-activation-unavailable.php';
			include LS_ROOT_PATH . '/templates/tmpl-purchase-ww-popups.php';
			include LS_ROOT_PATH . '/templates/tmpl-embed-slider.php';
			include LS_ROOT_PATH . '/templates/tmpl-sliders-list-context-menu.php';
			include LS_ROOT_PATH . '/templates/tmpl-plugin-update-loading-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-plugin-update-success-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-canceled-activation-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-plugin-update-error-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-plugin-update-easter-egg-modal.php';
			include LS_ROOT_PATH . '/templates/tmpl-plugin-settings.php';
			include LS_ROOT_PATH . '/templates/tmpl-font-library.php';
		?>


		<div id="ls-list-main-menu" class="ls-menu-container <?= ! empty( $inlineNotifications ) ? 'ls-has-inline-notifications' : '' ?>">

			<div class="ls-menu-left">
			<ls-button data-scroll="#ls-slider-filters">
					<?= lsGetSVGIcon('th-large') ?>
					<ls-button-text><?= __('Projects', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button class="ls-show-activation-box">
					<?= lsGetSVGIcon('key') ?>
					<ls-button-text><?= __('License', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-scroll="#ls--box-twitter-feed">
					<?= lsGetSVGIcon('newspaper') ?>
					<ls-button-text><?= __('News', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<a class="ls-button ls-menu-help-button" href="https://layerslider.com/help/" target="blank">
					<?= lsGetSVGIcon('question') ?>
					<ls-button-text><?= __('Help', 'LayerSlider') ?></ls-button-text>
				</a>

			</div>

			<div class="ls-menu-right">

				<ls-button class="ls-notifications-button <?= LS_Notifications::unreadCount() ? 'ls-active' : '' ?>" data-toggle="dropdown" data-reference="#ls-list-main-menu" data-target="#ls-notification-panel" data-stop-propagation="1" data-placement="bottom-end" data-offset-y="12">
					<?= lsGetSVGIcon('bell') ?>
				</ls-button>

				<ls-button class="ls-open-plugin-settings-button">
					<?= lsGetSVGIcon('cog') ?>
				</ls-button>

				<ls-button data-toggle="dropdown" data-reference="#ls-list-main-menu" data-target="#ls-plugin-more-panel" data-stop-propagation="1" data-placement="bottom-end" data-offset-y="12">
					<?= lsGetSVGIcon('ellipsis-v'); ?>
				</ls-button>
			</div>
		</div>

		<?php if( ! empty( $inlineNotifications ) ) : ?>
		<div class="ls-fancy-notice-wrapper">

			<?php foreach( $inlineNotifications as $notification ) : ?>
			<div class="ls-fancy-notice <?= ! empty( $notification['class'] ) ? $notification['class'] : '' ?> <?= empty( $notification['fixed'] ) ? 'ls-notification-dismissible' : '' ?>">
				<div class="ls-menu-left">
					<div class="ls-fancy-notice-title">
						<?= $notification['icon'] ?>
						<?= $notification['title'] ?>
					</div>

					<?php if( ! empty( $notification['message'] ) ) : ?>
					<div class="ls-fancy-notice-text">
						<?= $notification['message'] ?>
					</div>
					<?php endif ?>
				</div>
				<div class="ls-menu-right">

					<?php if( ! empty( $notification['buttons'] ) ) : ?>
					<?php foreach( $notification['buttons'] as $button ) : ?>
					<a class="ls-button <?= ! empty( $button['class'] ) ? $button['class'] : '' ?> " <?= ! empty( $button['href'] ) ? 'href="'.$button['href'].'"' : '' ?> <?= ! empty( $button['target'] ) ? 'target="'.$button['target'].'"' : '' ?>>
						<ls-button-text><?= ! empty( $button['text'] ) ? $button['text'] : 'Learn More' ?></ls-button-text>
					</a>
					<?php endforeach ?>
					<?php endif ?>
				</div>
			</div>
			<?php endforeach ?>

		</div>
		<?php endif ?>

		<ls-dropdown-panel id="ls-notification-panel">
			<ls-dropdown-holder class="ls-dropdown-overflow">
				<ls-dropdown-inner>
					<ls-dropdown-screen>
						<ls-dropdown-header>
							<?= __('Notifications', 'LayerSlider') ?>

							<?php if( ! empty( $bellNotifications ) ) : ?>
							<ls-button id="ls-notification-clear-button">
								<?= lsGetSVGIcon('check') ?>
								<ls-button-text><?= __('Mark All as Read', 'LayerSlider') ?></ls-button-text>
							</ls-button>
							<?php endif ?>

						</ls-dropdown-header>
						<ls-menu-separator></ls-menu-separator>
						<ls-dropdown-menu>

							<?php if( ! empty( $bellNotifications ) ) : ?>
							<?php foreach( $bellNotifications as $notification ) : ?>
							<ls-menu-item class="<?= ! empty( $notification['class'] ) ? $notification['class'] : '' ?> <?= ! empty( $notification['unread'] ) ? 'ls-notification-unread' : '' ?> <?= empty( $notification['selectable'] ) ? 'ls-menu-unselectable' : '' ?>">
									<ls-menu-icon><?= $notification['icon'] ?></ls-menu-icon>
									<ls-menu-title><?= $notification['title'] ?></ls-menu-title>
									<ls-menu-text>
										<?= $notification['message'] ?>

										<?php if( ! empty( $notification['buttons'] ) ) : ?>
										<ls-menu-buttons>
											<?php foreach( $notification['buttons'] as $button ) : ?>
											<a class="ls-button <?= ! empty( $button['class'] ) ? $button['class'] : '' ?> " <?= ! empty( $button['href'] ) ? 'href="'.$button['href'].'"' : '' ?> <?= ! empty( $button['target'] ) ? 'target="'.$button['target'].'"' : '' ?>>
												<ls-button-text><?= ! empty( $button['text'] ) ? $button['text'] : 'Learn More' ?></ls-button-text>
											</a>
											<?php endforeach ?>
										</ls-menu-buttons>
										<?php endif ?>

									</ls-menu-text>

									<?php if( ! empty( $notification['url'] ) ) : ?>
									<a class="ls-menu-link" href="<?= $notification['url'] ?>" target="<?= ! empty( $notification['url_target'] ) ? $notification['url_target'] : '_self' ?>"></a>
									<?php endif ?>

									<ls-menu-date>
										<?= human_time_diff( $notification['date'] ) ?>
										<?= __('ago', 'LayerSlider') ?>
									</ls-menu-date>
								</ls-menu-item>
							<?php endforeach ?>
							<?php else: ?>
								<div class="ls-notifications-empty">
									<?= lsGetSVGIcon('comments-alt', 'duotone') ?>
									<ls-div class="ls-notification-empty-title"><?= __('No notifications yet', 'LayerSlider') ?></ls-div>
									<ls-div class="ls-notification-empty-text"><?= __('Check back later for updates about new releases, features, deals, and important product information.', 'LayerSlider') ?></ls-div>
								</div>
							<?php endif ?>

						</ls-dropdown-menu>
					</ls-dropdown-screen>
				</ls-dropdown-inner>
			</ls-dropdown-holder>
		</ls-dropdown-panel>

		<ls-dropdown-panel id="ls-plugin-more-panel">
			<ls-dropdown-holder>
				<ls-dropdown-inner>
					<ls-dropdown-screen>
						<ls-dropdown-menu>
							<ls-menu-item class="ls-open-plugin-settings-button ls-dismiss-panel">
								<ls-menu-icon><?= lsGetSVGIcon('cog') ?></ls-menu-icon>
								<ls-menu-title><?= __('Plugin Settings', 'LayerSlider') ?></ls-menu-title>
							</ls-menu-item>
							<ls-menu-separator></ls-menu-separator>
							<?php if( strpos( LS_PLUGIN_VERSION, 'b' ) !== false || strpos( LS_PLUGIN_VERSION, 'a' ) !== false) : ?>
							<ls-menu-item class="ls-menu-more-feedback">
								<a class="ls-menu-link" href="mailto:support@kreaturamedia.com?subject=LayerSlider (v<?= LS_PLUGIN_VERSION ?>) Feedback"></a>
								<ls-menu-icon><?= lsGetSVGIcon('bullhorn') ?></ls-menu-icon>
								<ls-menu-title><?= __('Give Feedback', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('Help us improve LayerSlider.', 'LayerSlider') ?></ls-menu-text>
							</ls-menu-item>
							<ls-menu-separator></ls-menu-separator>
							<?php endif ?>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('shield-alt') ?></ls-menu-icon>
								<ls-menu-title><?= __('System Status', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('Identify possible issues & display relevant debug information.', 'LayerSlider') ?> </ls-menu-text>
								<a class="ls-menu-link" href="<?= admin_url('admin.php?page=layerslider&section=system-status') ?>"></a>
							</ls-menu-item>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('paint-brush') ?></ls-menu-icon>
								<ls-menu-title><?= __('Skin Editor', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('Edit the CSS file of LayerSlider skins to apply custom modifications.', 'LayerSlider') ?> </ls-menu-text>
								<a class="ls-menu-link" href="<?= admin_url('admin.php?page=layerslider&section=skin-editor') ?>"></a>
							</ls-menu-item>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('palette') ?></ls-menu-icon>
								<ls-menu-title><?= __('CSS Editor', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('Add your own CSS code that will be applied globally on your site.', 'LayerSlider') ?></ls-menu-text>
								<a class="ls-menu-link" href="<?= admin_url('admin.php?page=layerslider&section=css-editor') ?>"></a>
							</ls-menu-item>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('wave-sine') ?></ls-menu-icon>
								<ls-menu-title><?= __('Transition Builder', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('Make new slide transitions easily with this drag & drop editor.', 'LayerSlider') ?></ls-menu-text>
								<a class="ls-menu-link" href="<?= admin_url('admin.php?page=layerslider&section=transition-builder') ?>"></a>
							</ls-menu-item>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('question-circle') ?></ls-menu-icon>
								<ls-menu-title><?= __('Get Help', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('FAQs, documentation, and more.', 'LayerSlider') ?></ls-menu-text>
								<a class="ls-menu-link" href="https://layerslider.com/help/" target="_blank"></a>
							</ls-menu-item>
							<ls-menu-item>
								<ls-menu-icon><?= lsGetSVGIcon('layer-group') ?></ls-menu-icon>
								<ls-menu-title><?= __('About LayerSlider', 'LayerSlider') ?></ls-menu-title>
								<ls-menu-text><?= __('About the product & useful resources.') ?></ls-menu-text>
								<a class="ls-menu-link" href="<?= admin_url('admin.php?page=layerslider&section=about') ?>"></a>
							</ls-menu-item>
						</ls-dropdown-menu>
					</ls-dropdown-screen>

				</ls-dropdown-inner>
			</ls-dropdown-holder>
		</ls-dropdown-panel>


		<!-- Welcome message -->
		<ls-section id="ls--welcome" class="<?= ( !empty( $sliders ) || $userFilters ) ? 'ls--mt-0 ls--mb-0' : '' ?>">

			<?php if( empty( $sliders ) && ! $userFilters ) : ?>
			<div id="ls-no-sliders">
				<h4><?= __('Create Your First Project', 'LayerSlider') ?></h4>
				<div class="ls-text"><?= __('You’re on your way to enrich your site with great graphics and stunning animations. To get started with LayerSlider, do any of the following:', 'LayerSlider') ?></div>
			</div>
			<?php endif ?>


			<div id="ls-list-buttons" class="ls-center ls-clearfix <?= ( empty( $sliders ) && ! $userFilters ) ? 'no-projects' : '' ?>">

				<div class="ls-item">
					<div class="ls-item-inner">
						<a href="#" id="ls-add-slider-button">
							<?= lsGetSVGIcon('plus'); ?>
							<div class="ls-tile-text"><?= __('Add New Project', 'LayerSlider') ?></div>
						</a>
					</div>
				</div>

				<div class="ls-item import-templates <?= $lsStoreHasUpdate ? 'has-updates' : '' ?>">
					<?= lsGetSVGIcon('exclamation-circle',null,[
						'class' => 'ls-update-icon'
					]); ?>
					<div class="ls-item-inner">
						<a href="#" id="ls-browse-templates-button" class="import-templates <?= $lsStoreHasUpdate ? 'has-updates' : '' ?>">
							<?= lsGetSVGIcon('map'); ?>
							<div class="ls-tile-text"><?= __('Browse Templates', 'LayerSlider') ?></div>
						</a>
					</div>
				</div>

				<div class="ls-item import-sliders">
					<div class="ls-item-inner" data-drop-text="<?= _e('Drop file to import', 'LayerSlider') ?>" data-import-text="<?= _e('Uploading ...', 'LayerSlider') ?>">
						<a href="#" id="ls-import-button">
							<?= lsGetSVGIcon('file-import'); ?>
							<div class="ls-tile-text"><?= __('Import Project', 'LayerSlider') ?></div>
						</a>
					</div>
				</div>

				<?php //if( ! $validity ) : ?>
				<div class="ls-item">
					<div class="ls-item-inner">
						<a href="#" id="ls-addons-button">
							<?= lsGetSVGIcon('award'); ?>
							<div class="ls-tile-text"><?= __('Premium Benefits', 'LayerSlider') ?></div>
						</a>
					</div>
				</div>
				<?php //endif ?>
			</div>
		</ls-section>

		<?php if( ! empty( $sliders ) || $userFilters ) : ?>

		<!-- Floating slider selection bar -->
		<div id="ls-slider-selection-bar-placeholder"></div>
		<div id="ls-slider-selection-bar" class="ls-menu-container">

			<div class="ls-menu-left">
				<ls-button data-action="embed" class="ls-single-selection">
					<?= lsGetSVGIcon('plus') ?>
					<ls-button-text><?= __('Embed', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="export">
					<?= lsGetSVGIcon('file-export') ?>
					<ls-button-text><?= __('Export', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="duplicate" class="ls-single-selection">
					<?= lsGetSVGIcon('clone') ?>
					<ls-button-text><?= __('Duplicate', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="hide" class="ls-hide-menu-button">
					<?= lsGetSVGIcon('eye-slash') ?>
					<ls-button-text><?= __('Hide', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="unhide" class="ls-unhide-menu-button">
					<?= lsGetSVGIcon('eye') ?>
					<ls-button-text><?= __('Unhide', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="delete">
					<?= lsGetSVGIcon('trash-alt') ?>
					<ls-button-text><?= __('Delete', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="group" class="ls-multiple-selection">
					<?= lsGetSVGIcon('th-large') ?>
					<ls-button-text><?= __('Group', 'LayerSlider') ?></ls-button-text>
				</ls-button>

				<ls-button data-action="merge" class="ls-multiple-selection">
					<?= lsGetSVGIcon('images') ?>
					<ls-button-text><?= __('Merge As New', 'LayerSlider') ?></ls-button-text>
				</ls-button>
			</div>


			<div class="ls-menu-right">
				<ls-button data-action="cancel">
					<ls-button-text><?= __('Cancel', 'LayerSlider') ?></ls-button-text>
				</ls-button>
			</div>
		</div>


		<!-- Slider Filters -->
		<form method="get" id="ls-slider-filters" class="ls-control-bar">
			<input type="hidden" name="page" value="layerslider">

			<div class="ls-slider-filters-filters">
				<?= __('Show', 'LayerSlider') ?>
				<select name="filter">
					<option value="published"><?= __('published items', 'LayerSlider') ?></option>
					<option value="hidden" <?= $showHiddenItems ? 'selected' : '' ?>><?= __('hidden items', 'LayerSlider') ?></option>
					<option value="popup" <?= $showPopupSlider ? 'selected' : '' ?>><?= __('popup') ?></option>
					<option value="all" <?= $showAllSlider ? 'selected' : '' ?>><?= __('all', 'LayerSlider') ?></option>
				</select>
			</div>
			<div class="ls-slider-filters-sort">
				<?= __('Sort by', 'LayerSlider') ?>
				<select name="order">
					<option value="name" <?= ($filters['orderby'] === 'name') ? 'selected' : '' ?>><?= __('name', 'LayerSlider') ?></option>
					<option value="date_c" <?= ($filters['orderby'] === 'date_c') ? 'selected' : '' ?>><?= __('date created', 'LayerSlider') ?></option>
					<option value="date_m" <?= ($filters['orderby'] === 'date_m') ? 'selected' : '' ?>><?= __('date modified', 'LayerSlider') ?></option>
					<option value="schedule_start" <?= ($filters['orderby'] === 'schedule_start') ? 'selected' : '' ?>><?= __('date scheduled', 'LayerSlider') ?></option>
				</select>
			</div>

			<div class="ls-slider-filters-right">
				<input type="search" name="term" placeholder="<?= __('Filter by name', 'LayerSlider') ?>" value="<?= ! empty($_GET['term']) ? htmlentities($_GET['term']) : '' ?>">
				<button class="button"><?= __('Search', 'LayerSlider') ?></button>
			</div>

		</form>


		<form method="post" class="ls-slider-list-form">
			<input type="hidden" name="ls-bulk-action" value="1">
			<?php wp_nonce_field('bulk-action'); ?>

			<!-- Empty results notification -->
			<?php if( empty( $sliders ) && $userFilters ) : ?>
			<div id="ls-empty-search" class="ls--form-control">
				<h4><?= __('No Projects Found', 'LayerSlider') ?></h4>
				<div class="ls-text"><?= sprintf(__('Your search did not match any projects. Make sure that your words are spelled correctly and you used the correct filters.', 'LayerSlider'), '<a href="'.admin_url('admin.php?page=layerslider').'">', '</a>') ?></div>
				<ls-p>
					<a class="ls--button ls--large ls--bg-lightgray ls--white" href="<?= admin_url('admin.php?page=layerslider') ?>"><?= __('Reset Search', 'LayerSlider') ?></a>
				</ls-p>
			</div>
			<?php endif ?>


			<?php if( ! empty($sliders ) ) : ?>
			<div>

				<div class="ls-sliders-grid ls-slider-list-items ls-clearfix">


					<?php
					foreach( $sliders as $key => $item ) {

						if( ! empty( $item['draft'] ) ) {
							$item['data'] = $item['draft']['data'];
						}

						$class = ($item['flag_deleted'] == '1') ? 'dimmed' : '';
						$preview = apply_filters('ls_preview_for_slider', $item );

						if( ! empty( $item['flag_group'] ) ) {
							$groupItems = $item['items'];

							if( empty( $groupItems ) ) { continue; }
							?>
							<div class="slider-item group-item" data-id="<?= $item['id'] ?>">
								<div class="slider-item-wrapper">
									<div class="items">
										<?php
											if( ! empty( $item['items'] ) ) {
											foreach( $groupItems as $groupKey => $groupItem )  {
											$groupPreview = apply_filters('ls_preview_for_slider', $groupItem ); ?>
												<div class="item <?= ($groupItem['flag_deleted'] == '1') ? 'dimmed' : '' ?>">
													<div class="preview" style="background-image: url(<?=  ! empty( $groupPreview ) ? $groupPreview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);">
														<?php if( empty( $groupPreview ) ) : ?>
														<div class="no-preview">
															<?= __('No Preview', 'LayerSlider') ?>
														</div>
														<?php endif ?>
													</div>
												</div>
											<?php } } ?>
									</div>

									<div class="info">
										<div class="name">
											<?= lsGetSVGIcon('th-large') ?>
											<ls-span>
												<?= apply_filters('ls_slider_title', stripslashes( $item['name'] ), 40) ?>
											</ls-span>
										</div>
									</div>

								</div>
							</div>
							<div class="ls-hidden">
								<div class="ls-clearfix">
									<?php
										if( ! empty( $item['items'] ) ) {
											foreach( $groupItems as $groupKey => $item ) {

												if( ! empty( $item['draft'] ) ) {
													$item['data'] = $item['draft']['data'];
												}

												$class = ($item['flag_deleted'] == '1') ? 'dimmed' : '';
												$preview = apply_filters('ls_preview_for_slider', $item );

												include LS_ROOT_PATH.'/templates/tmpl-slider-grid-item.php';
											}
										}
									?>
								</div>
							</div>
							<?php

						} else {
							include LS_ROOT_PATH.'/templates/tmpl-slider-grid-item.php';
						}
					}
					?>

				</div>

			</div>

			<div id="ls-slider-pagination" class="ls-control-bar">
				<div class="ls-bulk-actions">
					<select name="action">
						<option value="0"><?= __('Bulk Actions', 'LayerSlider') ?></option>
						<option value="export"><?= __('Export selected', 'LayerSlider') ?></option>
						<option value="export-html"><?= __('Export as HTML', 'LayerSlider') ?></option>
						<option value="duplicate"><?= __('Duplicate selected', 'LayerSlider') ?></option>
						<option value="hide"><?= __('Hide selected', 'LayerSlider') ?></option>
						<option value="delete"><?= __('Delete permanently', 'LayerSlider') ?></option>
						<option value="restore"><?= __('Restore selected', 'LayerSlider') ?></option>
						<option value="group"><?= __('Create group from selected', 'LayerSlider') ?></option>
						<option value="merge"><?= __('Merge selected as new', 'LayerSlider') ?></option>
					</select>
					<button class="button"><?= __('Apply', 'LayerSlider') ?></button>
				</div>
				<div class="ls-pagination-limit ls-slider-filters-left">
					<?= sprintf(__('Show %s per page', 'LayerSlider'), '<select name="limit"><option '.($pageSize === 10 ? 'selected' : '' ).'>10</option><option '.($pageSize === 25 ? 'selected' : '' ).'>25</option><option '.($pageSize === 50 ? 'selected' : '' ).'>50</option><option '.($pageSize === 75 ? 'selected' : '' ).'>75</option><option '.($pageSize === 100 ? 'selected' : '' ).'>100</option></select>') ?>
				</div>
				<div class="ls-pagination ls-slider-filters-right">
					<div class="tablenav-pages">
						<span class="displaying-num"><?= sprintf(_n('%d project', '%d projects', $maxItem, 'LayerSlider'), $maxItem) ?></span>
						<span class="pagination-links">
							<a class="button first-page<?= ($curPage <= 1) ? ' disabled' : ''; ?>" title="<?= __('Go to the first page', 'LayerSlider') ?>" href="<?= admin_url( 'admin.php?page=layerslider&filter='.$urlParamFilter.'&term='.$urlParamTerm.'&order='.$urlParamOrder ) ?>">«</a>
							<a class="button prev-page <?= ($curPage <= 1) ? ' disabled' : ''; ?>" title="<?= __('Go to the previous page', 'LayerSlider') ?>" href="<?= admin_url( 'admin.php?page=layerslider&paged='.($curPage-1).'&filter='.$urlParamFilter.'&term='.$urlParamTerm.'&order='.$urlParamOrder ) ?> ">‹</a>

							<span class="total-pages"><?= sprintf(__('%1$d of %2$d', 'LayerSlider'), $curPage, $maxPage) ?> </span>

							<a class="button next-page <?= ($curPage >= $maxPage) ? ' disabled' : ''; ?>" title="<?= __('Go to the next page', 'LayerSlider') ?>" href="<?= admin_url( 'admin.php?page=layerslider&paged='.($curPage+1).'&filter='.$urlParamFilter.'&term='.$urlParamTerm.'&order='.$urlParamOrder ) ?>">›</a>
							<a class="button last-page <?= ($curPage >= $maxPage) ? ' disabled' : ''; ?>" title="<?= __('Go to the last page', 'LayerSlider') ?>" href="<?= admin_url( 'admin.php?page=layerslider&paged='.$maxPage.'&filter='.$urlParamFilter.'&term='.$urlParamTerm.'&order='.$urlParamOrder ) ?>">»</a>
						</span>
					</div>
				</div>
			</div>
			<?php endif ?>
		</form>
		<?php endif ?>

	</ls-section>

	<ls-section id="ls--admin-boxes" class="ls--form-control <?= $validity ? 'ls--registered' : 'ls--not-registered' ?>">
		<ls-grid>
			<ls-row class="ls--flex-stretch">
				<ls-col class="ls--col1-2">
					<ls-box id="ls--box-support" class="ls--fex ls--column ls--flex-stretch">
						<ls-box-inner>
							<ls-h2 class="ls--green">
								<?= __('Help & Support', 'LayerSlider') ?>
							</ls-h2>
							<ls-ul class="ls--list-with-icons">
								<ls-li>
									<?= lsGetSVGIcon('book') ?>
									<ls-strong><?= __('Read the documentation', 'LayerSlider') ?></ls-strong>
									<ls-small><?= __('Get started with using LayerSlider.', 'LayerSlider') ?></ls-small>
								</ls-li>
								<ls-li>
									<?= lsGetSVGIcon('life-ring') ?>
									<ls-strong><?= __('Browse the FAQs', 'LayerSlider') ?></ls-strong>
									<ls-small><?= __('Find answers for common questions.', 'LayerSlider') ?></ls-small>
								</ls-li>
								<ls-li class="ls--disable-if-not-registered">
									<ls-span class="ls--show-if-registered">
										<?= lsGetSVGIcon('users') ?>
									</ls-span>
									<ls-span class="ls--show-if-not-registered">
										<?= lsGetSVGIcon('lock') ?>
									</ls-span>
									<ls-strong><?= __('Direct Support', 'LayerSlider') ?>
										<a class="ls-show-activation-box ls--button ls--small ls--bg-gray ls--show-if-not-registered">
											<?= __('Unlock Now', 'LayerSlider') ?>
										</a>
									</ls-strong>
									<ls-small><?= __('Get in touch with our Support Team.', 'LayerSlider') ?></ls-small>
								</ls-li>
							</ls-ul>
							<ls-p class="ls--mt-7 ls--mb-4">
									<a class="ls--button ls--bg-green ls--large" href="https://layerslider.com/help/" target="_blank"><?= __('Open Help Center', 'LayerSlider') ?></a>
							</ls-p>
						</ls-box-inner>
					</ls-box>
				</ls-col>
				<ls-col class="ls--col1-2">
					<ls-box id="ls--box-social-media">
						<ls-box-inner>
							<ls-h2 class="ls--lightgray">
								<?= __('Connect With LayerSlider', 'LayerSlider') ?>
							</ls-h2>
							<ls-p>
								<?= __('Follow us on Social Media and get notified about the latest product updates, sales, deals, and participate in giveaways and other programs.', 'LayerSlider') ?>
							</ls-p>
							<ls-grid class="ls--v-1 ls--h-1">
								<ls-row class="ls--flex-stretch">
									<ls-col class="ls--col1-2">
										<a class="ls--social-twitter" href="https://twitter.com/kreaturamedia/" target="_blank">
											<?= lsGetSVGIcon('twitter', 'brands') ?>
											<ls-strong>
												Twitter
											</ls-strong>
										</a>
									</ls-col>
									<ls-col class="ls--col1-2">
										<a class="ls--social-facebook" href="https://www.facebook.com/kreaturamedia/" target="_blank">
											<?= lsGetSVGIcon('facebook-f', 'brands') ?>
											<ls-strong>
												Facebook
											</ls-strong>
										</a>
									</ls-col>
									<ls-col class="ls--col1-2">
										<a class="ls--social-youtube" href="https://www.youtube.com/user/kreaturamedia/" target="_blank">
											<?= lsGetSVGIcon('youtube', 'brands') ?>
											<ls-strong>
												YouTube
											</ls-strong>
										</a>
									</ls-col>
									<ls-col class="ls--col1-2">
										<a class="ls--social-instagram" href="https://instagram.com/layersliderwp/" target="_blank">
											<?= lsGetSVGIcon('instagram', 'brands') ?>
											<ls-strong>
												Instagram
											</ls-strong>
										</a>
									</ls-col>
								</ls-row>
							</ls-grid>
						</ls-box-inner>
					</ls-box>
				</ls-col>

<!-- 				<ls-col class="<?= ( !empty( $sliders ) || $userFilters ) ? 'ls--flex-order-first' : '' ?>">
 -->

 				<ls-col class="ls--flex-order-first">

					<ls-box id="ls--box-license" class="ls--bg-cover ls--no-overflow">

						<ls-box-inner>

							<ls-grid class="ls--overflow">
								<ls-row>
									<ls-bg-wrapper>
										<ls-grid>
											<ls-row>
												<ls-col class="ls--col1-2">
													<ls-bg></ls-bg>
												</ls-col>
												<ls-col class="ls--col1-2"></ls-col>
											</ls-row>
										</ls-grid>s
									</ls-bg-wrapper>
									<ls-col class="ls--col1-2 ls--foreground ls--text-center">
										<ls-h1 class="ls--white">

											<ls-span class="ls--show-if-not-registered">
												<?= __('Register Your License', 'LayerSlider') ?>
											</ls-span>

											<ls-span class="ls--show-if-registered">
												<?= __('Registered License', 'LayerSlider') ?>
											</ls-span>

										</ls-h1>

										<ls-h4 class="ls--white">

											<ls-span class="ls--show-if-not-registered">
												<?= __('Please enter your license key below.', 'LayerSlider') ?>
											</ls-span>

											<ls-span class="ls--show-if-registered">
												<?= __('Thank you for your purchase!', 'LayerSlider') ?>
											</ls-span>

										</ls-h4>

										<ls-p class="ls--white">
											<ls-span class="ls--show-if-not-registered">
												<?= __('Unlock all these benefits and get the full LayerSlider experience:', 'LayerSlider') ?>

											</ls-span>
											<ls-span class="ls--show-if-registered">
												<?= __('You can now access all these benefits:', 'LayerSlider') ?>
											</ls-span>
										</ls-p>

										<ls-grid class="ls--v-2 ls--h-2 ls--premium-features ls--text-left">
											<ls-row class="ls--flex-stretch">
												<ls-col class="ls--col1-2">
													<ls-box>
														<ls-box-inner>
															<ls-p class="ls--ml-3">
																<ls-strong class="ls--font-large">
																	<?= __('Automatic Updates', 'LayerSlider') ?>
																</ls-strong>
																<ls-p>
																	<?= __('Always receive the latest LayerSlider version.', 'LayerSlider') ?>
																</ls-p>

															</ls-p>
															<ls-span class="ls--red ls--show-if-not-registered">
																<?= lsGetSVGIcon('lock') ?>
															</ls-span>
															<ls-span class="ls--blue ls--show-if-registered">
																<?= lsGetSVGIcon('check') ?>
															</ls-span>
														</ls-box-inner>
													</ls-box>
												</ls-col>
												<ls-col class="ls--col1-2">
													<ls-box>
														<ls-box-inner>
															<ls-p class="ls--ml-3">
																<ls-strong class="ls--font-large">
																	<?= __('Product Support', 'LayerSlider') ?>
																</ls-strong>
																<ls-p>
																	<?= __('Direct help from our Support Team.', 'LayerSlider') ?>
																</ls-p>

															</ls-p>
															<ls-span class="ls--red ls--show-if-not-registered">
																<?= lsGetSVGIcon('lock') ?>
															</ls-span>
															<ls-span class="ls--blue ls--show-if-registered">
																<?= lsGetSVGIcon('check') ?>
															</ls-span>
														</ls-box-inner>
													</ls-box>
												</ls-col>
												<ls-col class="ls--col1-2">
													<ls-box>
														<ls-box-inner>
															<ls-p class="ls--ml-3">
																<ls-strong class="ls--font-large">
																	<?= __('Exclusive Features', 'LayerSlider') ?>
																</ls-strong>
																<ls-p>
																	<?= __('Unlock exclusive and early-access features.', 'LayerSlider') ?>
																</ls-p>

															</ls-p>
															<ls-span class="ls--red ls--show-if-not-registered">
																<?= lsGetSVGIcon('lock') ?>
															</ls-span>
															<ls-span class="ls--blue ls--show-if-registered">
																<?= lsGetSVGIcon('check') ?>
															</ls-span>
														</ls-box-inner>
													</ls-box>
												</ls-col>
												<ls-col class="ls--col1-2">
													<ls-box>
														<ls-box-inner>
															<ls-p class="ls--ml-3">
																<ls-strong class="ls--font-large">
																	<?= __('Premium Templates', 'LayerSlider') ?>
																</ls-strong>
																<ls-p>
																	<?= __('Access more templates to get started with projects.', 'LayerSlider') ?>
																</ls-p>

															</ls-p>
															<ls-span class="ls--red ls--show-if-not-registered">
																<?= lsGetSVGIcon('lock') ?>
															</ls-span>
															<ls-span class="ls--blue ls--show-if-registered">
																<?= lsGetSVGIcon('check') ?>
															</ls-span>
														</ls-box-inner>
													</ls-box>
												</ls-col>
											</ls-row>
										</ls-grid>

										<form method="post" class="inner">
											<input type="hidden" name="action" value="ls_authorize_site">
											<?php wp_nonce_field( 'ls_authorize_site' ); ?>

											<!--
												<ls-span class="ls--white"><?= __('Enter your license key:', 'LayerSlider') ?></ls-span>

												<a target="_blank" class="button button-small where-button" href="https://layerslider.com/documentation/#activation-purchase-code"><?= __('Where’s my license key?', 'LayerSlider') ?></a>
			 								-->
											<ls-div class="ls--key">
												<input class="ls--hero ls--fullwidth ls--border-white ls--bg-white" type="text" name="purchase_code" value="<?= $codeFormatted ?>" placeholder="<?= __('Enter your license key here', 'LayerSlider') ?>">
											</ls-div>
											<ls-p class="ls--clear-after">
												<button class="ls--float-left ls--button ls--large ls--bg-red button-save ls--show-if-not-registered"><?= __('Register License', 'LayerSlider') ?></button>
												<button class="ls--float-left ls--button ls--large ls--bg-blue button-save ls--show-if-registered"><?= __('Update License', 'LayerSlider') ?></button>
												<a href="#" class="ls--float-right ls--button ls--large ls--bg-white ls--blue ls-deauthorize ls--show-if-registered"><?= __('Deregister License', 'LayerSlider') ?></a>

												<a target="_blank" class="ls--float-right ls--button ls--large ls--bg-white ls--red purchase-button ls--show-if-not-registered" href="<?= LS_Config::get('purchase_url') ?>"><?= __('Purchase license', 'LayerSlider') ?></a>
											</ls-p>
											<ls-p class="ls--white ls--font-s ls--show-if-not-registered">
												<?php if( ! LS_Config::get('autoupdate') ) {
													echo sprintf(
														__('License registration requires a direct purchase of a LayerSlider license if you have received the plugin with a WordPress theme. For more information, please refer to %sthis article%s.', 'LayerSlider'), '<a class="ls--white" href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>');
												} else {
													echo sprintf(__('If you experience any issue or need further information,<br> please read our %sregistration guide%s.', 'LayerSlider'), '<a class="ls--white" href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>');
												} ?>
											</ls-p>
										</form>

									</ls-col>
									<ls-col class="ls--col1-2 ls--background">

										<!-- Slider HTML markup -->
										<div id="ls--license-slider" style="width:400px;height:500px;max-width:430px;max-height: 500px;margin:0 auto;">

											<!-- Slide 1-->
											<div class="ls-slide" data-ls="transition2d:5; overflow:true; kenburnsscale:1.2;">
												<img width="128" height="369" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/rocket.png" class="ls-l" alt="" style="top:165px; left:135px; background-size:inherit; background-position:inherit;" data-ls="offsetyin:bottom; durationin:1500; delayin:500; easingin:easeOutQuint; fadein:false; offsetyout:top; easingout:easeInQuint; loop:true; loopoffsety:-20; loopduration:2000; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopcount:-1; loopyoyo:true;">
												<img width="230" height="162" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/smoke-right.png" class="ls-l" alt="" style="top:382px; left:213px; background-size:inherit; background-position:inherit;" data-ls="offsetyin:bottom; durationin:1500; delayin:500; easingin:easeOutQuint; fadein:false; offsetxout:10sw; offsetyout:30sh; easingout:easeInQuint; loop:true; loopduration:2350; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopscalex:0.9; looptransformorigin:0% 50% 0; loopcount:-1; loopyoyo:true;">
												<img width="213" height="134" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/smoke-left.png" class="ls-l" alt="" style="top:389px; left:-42px; background-size:inherit; background-position:inherit;" data-ls="offsetyin:bottom; durationin:1500; delayin:500; easingin:easeOutQuint; fadein:false; offsetxout:-10sw; offsetyout:30sh; easingout:easeInQuint; loop:true; loopduration:2650; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopscalex:0.9; looptransformorigin:100% 50% 0; loopcount:-1; loopyoyo:true;">
												<img width="305" height="197" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/smoke-center.png" class="ls-l" alt="" style="top:364px; left:34px; background-size:inherit; background-position:inherit;" data-ls="offsetyin:bottom; durationin:1500; delayin:500; easingin:easeOutQuint; fadein:false; offsetyout:50sh; easingout:easeInQuint; loop:true; loopduration:2900; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopscalex:1.2; loopscaley:1.1; loopcount:-1; loopyoyo:true;">
												<p style="top:10px; left:50%; background-size:inherit; background-position:inherit; font-size:40px; font-family:Pacifico; color:#fff;" class="ls-l" data-ls="offsetyin:top; durationin:1500; delayin:1000; easingin:easeOutQuint; offsetyout:-1000; easingout:easeOutQuint; loop:true; loopoffsety:10; loopduration:1500; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopcount:-1; loopyoyo:true; skewX:1;"><?= __('Go Premium!', 'LayerSlider') ?></p>
											</div>


											<!-- Slide 2-->
											<div class="ls-slide" data-ls="overflow:true; kenburnsscale:1.2;">
												<img src="<?= LS_ROOT_URL ?>/static/admin/img/slider/galaxy.png" class="ls-l" alt="" style="top:-100px; left:-100px; width: 1200px; height: 1200px; background-size:inherit; background-position:inherit; opacity:.2;" data-ls="durationin:2000; delayin:500; easingin:easeInOutSine; loop:true; loopduration:240000; loopstartat:transitioninstart + 0; looprotate:-360; loopcount:-1;">
												<div style="top:120px; left:460px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:1600; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:100; rotation:-45;"></div>
												<div style="top:-380px; left:630px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:2000; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:175; rotation:-45;"></div>
												<div style="top:-321px; left:770px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:2200; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:250; rotation:-45;"></div>
												<div style="top:-380px; left:450px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:1500; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:100; rotation:-45;"></div>
												<div style="top:-380px; left:550px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:2350; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:175; rotation:-45;"></div>
												<div style="top:-40px; left:770px; background-size:inherit; background-position:inherit; font-size:18px; height:4px; width:150px; background-color:#ffffff; border-radius:4px; opacity:.15;" class="ls-l" data-ls="durationin:0; delayin:1750; easingin:linear; fadein:false; loop:true; loopoffsetx:-1500; loopduration:600; loopcount:-1; looprepeatdelay:250; rotation:-45;"></div>
												<img width="128" height="369" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/rocket-flame-blue.png" class="ls-l" alt="" style="top:127px; left:134px; background-size:inherit; background-position:inherit;" data-ls="offsetxin:-300; offsetyin:300; durationin:2000; delayin:1000; easingin:easeOutQuint; rotatein:45; offsetxout:300; offsetyout:-300; easingout:easeInQuint; rotateout:45; loop:true; loopoffsety:-10; loopoffsetx:-20; loopopacity: 0.65; looprotate:-3; loopduration:4000; loopstartat:transitioninstart + 200; loopeasing:easeInOutSine; loopscalex:0.9; loopscaley:1.05; looptransformorigin:100% 100% 0; loopcount:-1; loopyoyo:true; rotation:45;">
												<img width="128" height="369" src="<?= LS_ROOT_URL ?>/static/admin/img/slider/rocket-blue.png" class="ls-l" alt="" style="top:130px; left:130px; background-size:inherit; background-position:inherit;" data-ls="offsetxin:-300; offsetyin:300; durationin:2000; delayin:1000; easingin:easeOutQuint; rotatein:45; offsetxout:300; offsetyout:-300; easingout:easeInQuint; rotateout:45; loop:true; loopoffsety:-10; loopoffsetx:-10; looprotate:-3; loopduration:4000; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopscaley:1.02; looptransformorigin:100% 100% 0; loopcount:-1; loopyoyo:true; rotation:45;">
												<p style="top:10px; left:50%; background-size:inherit; background-position:inherit; font-size:40px; font-family:Pacifico; color:#fff;" class="ls-l" data-ls="offsetyin:top; durationin:1500; delayin:1500; easingin:easeOutQuint; loop:true; loopoffsety:10; loopduration:1500; loopstartat:transitioninstart + 0; loopeasing:easeInOutSine; loopcount:-1; loopyoyo:true; skewX:1;"><?= __('Premium activated!', 'LayerSlider') ?></p>
											</div>
										</div>
									</ls-col>
								</ls-row>
							</ls-grid>

						</ls-box-inner>
					</ls-box>

				</ls-col>
 				<ls-col>
					<ls-box id="ls--box-newsletter">
						<ls-box-inner>
							<ls-grid class="ls--v-3 ls--h-3">
								<ls-row>
									<ls-col class="ls--col1-2">
										<ls-h2 class="ls--white">
											<?= __('LayerSlider Newsletter', 'LayerSlider') ?>
										</ls-h2>
										<form method="post" action="https://kreaturamedia.com/newsletter/" target="_blank">
											<input class="ls--large ls--fullwidth ls--border-white ls--bg-white ls--purple" type="text" name="email" value="<?= ! empty( $currentUser->data->user_email ) ? $currentUser->data->user_email : '' ?>" placeholder="<?= __('Enter your email address', 'LayerSlider') ?>">
											<ls-p class="ls--text-center">
												<button class="ls--button ls--bg-purple">
													<?= lsGetSVGIcon('paper-plane') ?>
													<ls-span>
													<?= __('Subscribe', 'LayerSlider') ?>
													</ls-span>
												</button>
											</ls-p>
										</form>
									</ls-col>
									<ls-col class="ls--col1-2">
										<ls-ul class="ls--list-with-icons ls--inline-block">
											<ls-li>
												<?= lsGetSVGIcon('bullhorn') ?>
												<ls-strong><?= __('Stay Updated', 'LayerSlider') ?></ls-strong>
												<ls-small><?= __('News about the latest features and other product info.', 'LayerSlider') ?></ls-small>
											</ls-li>
											<ls-li>
												<?= lsGetSVGIcon('heart') ?>
												<ls-strong><?= __('Sneak Peek on Product Updates', 'LayerSlider') ?></ls-strong>
												<ls-small><?= __('Access to all the cool new features before anyone else.', 'LayerSlider') ?></ls-small>
											</ls-li>
											<ls-li>
												<?= lsGetSVGIcon('smile', 'regular') ?>
												<ls-strong><?= __('Provide Feedback', 'LayerSlider') ?></ls-strong>
												<ls-small><?= __('Participate in various programs and help us improving LayerSlider.', 'LayerSlider') ?></ls-small>
											</ls-li>
										</ls-ul>
									</ls-col>
								</ls-row>
							</ls-grid>
						</ls-box-inner>
					</ls-box>
				</ls-col>
 				<ls-col class="ls--col1-2">
					<ls-box id="ls--box-twitter-feed">
						<ls-box-inner>
							<ls-h2 class="ls--lightgray">
								<?= __('Latest News', 'LayerSlider') ?>
							</ls-h2>
							<ls-wrapper>
								<ls-div>
									<a class="twitter-timeline" data-chrome="nofooter noborders transparent" href="https://twitter.com/kreaturamedia?ref_src=twsrc%5Etfw">Tweets by kreaturamedia</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
								</ls-div>
							</ls-wrapper>
						</ls-box-inner>
					</ls-box>
				</ls-col>
				<ls-col class="ls--col1-2">
					<ls-box id="ls--box-updates">
						<ls-box-inner>
							<ls-h2 class="ls--red">
								<?= __('Plugin Updates', 'LayerSlider') ?>
								<ls-span class="ls--float-right">
									<a class="ls--button ls--bg-white ls--red ls--border-red ls--medium" href="<?= wp_nonce_url( admin_url('admin.php?page=layerslider&action=check_updates'), 'check_updates' ) ?>">
										<ls-span>
											<?= __('Re-Check', 'LayerSlider') ?>
										</ls-span>
										<?= lsGetSVGIcon('sync-alt', false, ['id' => 'ls--check-for-updates']) ?>
									</a>
								</ls-span>
							</ls-h2>
							<ls-box id="ls--update-settings" class="ls--bg-red">
								<ls-ul class="ls--list-with-icons">
									<ls-li>
										<?= lsGetSVGIcon('box-open') ?>
										<ls-span><?= __('Installed Version:', 'LayerSlider') ?> <ls-strong><?= LS_PLUGIN_VERSION ?></ls-strong></ls-span>
									</ls-li>
									<ls-li>
										<?= lsGetSVGIcon('cloud-download-alt') ?>
										<ls-grid class="ls--v-0 ls--h-0">
											<ls-row>
												<ls-col class="ls--col2-3">
													<ls-span><?= __('Available Version: ', 'LayerSlider') ?> <ls-strong><?= LS_RemoteData::getAvailableVersion() ?></ls-strong>
													</ls-span>
												</ls-col>

												<ls-col class="ls--col1-3">
													<?php if( ! empty( $GLOBALS['LS_hasPluginUpdate'] ) ): ?>
													<a class="ls--show-if-registered ls-install-plugin-update ls--float-right ls--button ls--small ls--red ls--bg-white ls--ml-1"><?= __('Install Now', 'LayerSlider') ?></a>
													<?php endif ?>
												</ls-col>
											</ls-row>
										</ls-grid>
									</ls-li>
									<ls-li>
										<?= lsGetSVGIcon('directions') ?>
										<form method="get" id="ls--release-channel">
											<ls-grid class="ls--v-0 ls--h-0">
												<ls-row>
													<ls-col class="ls--col2-3">
														<ls-span>
															<?php wp_nonce_field( 'ls_set_release_channel' ); ?>
															<input type="hidden" name="action" value="ls_set_release_channel">
															<?= __('Release Channel', 'LayerSlider') ?>
														</ls-span>
													</ls-col>
													<ls-col class="ls--col1-3">
														<ls-select-wrapper>
															<select class="ls--small" name="channel">
																<option value="stable"<?= ( $channel === 'stable' ) ? 'selected' : '' ?>><?= __('Stable', 'LayerSlider') ?></option>
																<option value="beta"<?= ( $channel === 'beta' ) ? 'selected' : '' ?>><?= __('Beta', 'LayerSlider') ?></option>
																</select>
															<ls-select-arrow></ls-select-arrow>
														</ls-select-wrapper>
													</ls-col>
												</ls-row>
											</ls-grid>
										</form>

									</ls-li>
								</ls-ul>
							</ls-box>
							<?php if( empty( LS_RemoteData::get('release-log') ) ) : ?>
							<ls-p><?= sprintf(__('Couldn’t display the release log. Please check %sSystem Status%s for potential errors.', 'LayerSlider'), '<a href="'.admin_url('admin.php?page=layerslider&section=system-status').'">', '</a>' ) ?></ls-p>
							<?php endif ?>
							<ls-ul id="ls--release-log">

								<?php if( ! empty( LS_RemoteData::get('release-log') ) ) : ?>
								<?= LS_RemoteData::get('release-log') ?>

								<ls-div class="ls--text-center ls--bottom-gradient">
									<a target="_blank" href="https://layerslider.com/release-log/" class="ls--button ls--bg-lightgray ls--white">
										<?= __('Show More', 'LayerSlider') ?>
									</a>
								</ls-div>
								<?php endif ?>

							</ls-ul>
						</ls-box-inner>
					</ls-box>
				</ls-col>
			</ls-row>
		</ls-grid>
	</ls-section>

</div>


<script type="text/javascript">
	var pluginPath = '<?= LS_ROOT_URL ?>/static/';
</script>
