<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

add_action('init', function() {

	add_action('save_post', 'layerslider_delete_caches');

	if(current_user_can(get_option('layerslider_custom_capability', 'manage_options'))) {

		// Preview iframe contents
		if( ! empty( $_GET['page'] ) && $_GET['page'] === 'layerslider' && ! empty( $_GET['action'] ) && $_GET['action'] === 'preview-iframe-html') {
			include LS_ROOT_PATH.'/templates/tmpl-project-preview-iframe.php';
			exit;
		}


		// Set Locale
		if( ! empty( $_GET['page'] ) && $_GET['page'] === 'layerslider' && ! empty( $_GET['action'] ) && $_GET['action'] === 'set-locale') {

			if( ! empty( $_GET['locale'] ) ) {
				update_option('ls_custom_locale', $_GET['locale']);
			}

			if( ! empty( $_GET['id'] ) ) {
				wp_redirect( admin_url('admin.php?page=layerslider&action=edit&id='.(int) $_GET['id'] ) );
				exit;
			}

			wp_redirect( admin_url('admin.php?page=layerslider') );
			exit;
		}


		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'create-slider') {
			if( check_admin_referer('create-slider') ) {
				ls_add_new_slider();
			}
		}

		// Hide slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide') {
			if( check_admin_referer('hide_'.$_GET['id']) ) {
				add_action('admin_init', 'layerslider_hideslider');
			}
		}

		// Restore slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'restore') {
			if( check_admin_referer('restore_'.$_GET['id']) ) {
				add_action('admin_init', 'layerslider_restoreslider');
			}
		}

		// Duplicate slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'duplicate') {
			if( check_admin_referer('duplicate_'.$_GET['id']) ) {
				add_action('admin_init', 'layerslider_duplicateslider');
			}
		}

		// Export slider
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'export') {
			if( check_admin_referer('export-sliders') ) {
				$_POST['sliders'] = [ (int) $_GET['id'] ];
				$_POST['ls-export'] = true;
			}
		}

		// Export as HTML
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'export-html') {
			if( check_admin_referer('export-sliders') ) {
				ls_export_as_html( (int) $_GET['id'] );
			}
		}

		// Empty caches
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'empty_caches') {
			if( check_admin_referer('empty_caches') ) {
				add_action('admin_init', 'layerslider_empty_caches');
			}
		}

		// Empty Google Fonts
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'empty_google_fonts') {
			if( check_admin_referer('empty_google_fonts') ) {
				add_action('admin_init', 'layerslider_empty_google_fonts');
			}
		}

		// Update Library
		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'update_store') {
			if( check_admin_referer('update_store') ) {
				LS_RemoteData::update();
				wp_redirect( admin_url('admin.php?page=layerslider&message=updateStore') );
				exit;
			}
		}

		// Database Update
		if( isset( $_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'database_update') {
			if( check_admin_referer('database_update') ) {
				layerslider_create_db_table();
				wp_redirect( admin_url('admin.php?page=layerslider&section=system-status&message=dbUpdateSuccess') );
				exit;
			}
		}


		// Clear Groups
		if( isset( $_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'clear_groups') {
			if( check_admin_referer('clear_groups') ) {
				LS_Sliders::removeAllGroups();
				wp_redirect( admin_url('admin.php?page=layerslider&section=system-status&message=clearGroupsSuccess') );
				exit;
			}
		}


		if( isset( $_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'check_updates') {
			if( check_admin_referer('check_updates') ) {
				ls_force_update_check();
			}

		}


		// Slider list bulk actions
		if(isset($_POST['ls-bulk-action'])) {
			if( check_admin_referer('bulk-action') ) {
				add_action('admin_init', 'ls_sliders_bulk_action');
			}
		}

		// Add new slider
		if(isset($_POST['ls-add-new-slider'])) {
			if( check_admin_referer('add-slider') ) {
				add_action('admin_init', 'ls_add_new_slider');
			}
		}

		// Import sliders
		if(isset($_POST['ls-import'])) {
			if( check_admin_referer('import-sliders') ) {
				add_action('admin_init', 'ls_import_sliders');
			}
		}

		// Export sliders
		if(isset($_POST['ls-export'])) {
			if( check_admin_referer('export-sliders') ) {
				add_action('admin_init', 'ls_export_sliders');
			}
		}

		// Custom CSS editor
		if(isset($_POST['ls-user-css'])) {
			if( check_admin_referer('save-user-css') ) {
				add_action('admin_init', 'ls_save_user_css');
			}
		}

		// Skin editor
		if(isset($_POST['ls-user-skins'])) {
			if( check_admin_referer('save-user-skin') ) {
				add_action('admin_init', 'ls_save_user_skin');
			}
		}

		// Transition builder
		if(isset($_POST['ls-user-transitions'])) {
			if( check_admin_referer('save-user-transitions') ) {
				add_action('admin_init', 'ls_save_user_transitions');
			}
		}


		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-important-notice') {
			if( check_admin_referer('hide-important-notice') ) {

				$noticeData = LS_RemoteData::get('important-notice', false );
				if( ! empty( $noticeData['date'] ) ) {
					update_option('ls-last-important-notice', $noticeData['date']);
				}

				wp_redirect( admin_url( 'admin.php?page=layerslider') );
				exit;
			}
		}

		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-support-notice') {
			if( check_admin_referer('hide-support-notice') ) {
				update_user_meta( get_current_user_id(), 'ls-show-support-notice-timestamp', time() );
				wp_redirect( admin_url( 'admin.php?page=layerslider') );
				exit;
			}
		}

		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-canceled-activation-notice') {
			if( check_admin_referer('hide-canceled-activation-notice') ) {
				update_option('ls-show-canceled_activation_notice', 0);
				wp_redirect( admin_url( 'admin.php?page=layerslider') );
				exit;
			}
		}

		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'hide-update-notice') {
			if( check_admin_referer('hide-update-notice') ) {
				$latest = get_option('ls-latest-version', LS_PLUGIN_VERSION);
				update_option('ls-last-update-notification', $latest);
				wp_redirect( admin_url( 'admin.php?page=layerslider') );
				exit;
			}
		}


		if(isset($_GET['page']) && $_GET['page'] == 'layerslider' && isset($_GET['action']) && $_GET['action'] == 'disable_dt_silence') {

			if( class_exists( 'The7_Admin_Dashboard_Settings' ) ) {
				The7_Admin_Dashboard_Settings::set( 'silence-purchase-notification', false );
			}

			wp_redirect( admin_url( 'admin.php?page=layerslider') );
			exit;

		}


		// Erase Plugin Data
		if( isset( $_POST['ls-erase-plugin-data'] ) ) {
			if( check_admin_referer('erase_data') ) {
				add_action('admin_init', 'ls_erase_plugin_data');
			}
		}

		// AJAX functions
		add_action('wp_ajax_ls_save_google_fonts', 'ls_save_google_fonts');
		add_action('wp_ajax_ls_save_plugin_settings', 'ls_save_plugin_settings');
		add_action('wp_ajax_ls_save_slider', 'ls_save_slider');
		add_action('wp_ajax_ls_publish_slider', 'ls_publish_slider');
		add_action('wp_ajax_ls_revert_slider', 'ls_revert_slider');
		add_action('wp_ajax_ls_import_bundled', 'ls_import_bundled');
		add_action('wp_ajax_ls_import_online', 'ls_import_online');
		add_action('wp_ajax_ls_save_pagination_limit', 'ls_save_pagination_limit');
		add_action('wp_ajax_ls_save_editor_settings', 'ls_save_editor_settings');
		add_action('wp_ajax_ls_slider_library_contents', 'ls_slider_library_contents');
		add_action('wp_ajax_ls_get_slider_details', 'ls_get_slider_details');
		add_action('wp_ajax_ls_get_mce_sliders', 'ls_get_mce_sliders');
		add_action('wp_ajax_ls_get_mce_slides', 'ls_get_mce_slides');
		add_action('wp_ajax_ls_get_post_details', 'ls_get_post_details');
		add_action('wp_ajax_lse_get_search_posts', 'lse_get_search_posts');
		add_action('wp_ajax_ls_get_taxonomies', 'ls_get_taxonomies');
		add_action('wp_ajax_ls_upload_from_url', 'ls_upload_from_url');
		add_action('wp_ajax_ls_store_opened', 'ls_store_opened');
		add_action('wp_ajax_ls_create_slider_group', 'ls_create_slider_group');
		add_action('wp_ajax_ls_add_slider_to_group', 'ls_add_slider_to_group');
		add_action('wp_ajax_ls_rename_slider_group', 'ls_rename_slider_group');
		add_action('wp_ajax_ls_remove_slider_from_group', 'ls_remove_slider_from_group');
		add_action('wp_ajax_ls_delete_slider_group', 'ls_delete_slider_group');
		add_action('wp_ajax_ls_download_module', 'ls_download_module');
		add_action('wp_ajax_ls_get_revisions', 'ls_get_revisions');
		add_action('wp_ajax_ls_save_revisions_options', 'ls_save_revisions_options');
	}
});

function ls_force_update_check() {
	delete_site_transient('update_plugins');
	wp_redirect( admin_url( 'update-core.php' ) );
	exit;
}

function ls_download_module() {

	$module = new LS_ModuleManager( $_GET['module'] );

	die(json_encode([
		'success' => empty( $module->errMessage ),
		'message' => $module->errMessage
	]));
}

function ls_get_revisions() {

	$revisions = LS_Revisions::snapshots( (int) $_GET['sliderID'] );

	foreach( $revisions as $key => $revision ) {

		$revisions[$key]->avatar 	= function_exists( 'get_avatar_url' ) ? get_avatar_url( $revisions[$key]->author ) : '';
		$revisions[$key]->nickname 	= get_userdata( $revisions[$key]->author )->user_nicename;
		$revisions[$key]->time_diff =  sprintf(__(' %s ago', 'LayerSlider'), human_time_diff( $revision->date_c ) );
		$revisions[$key]->created 	= ls_date('M j @ H:i', $revision->date_c);
		$revisions[$key]->data 		= ls_normalize_slider_data( json_decode( $revision->data , true) );
	}

	die( json_encode( $revisions ) );
}


function ls_create_slider_group() {

	$groupId = LS_Sliders::addGroup( __('Unnamed Group', 'LayerSlider') );

	foreach( $_GET['items'] as $sliderId ) {

		LS_Sliders::addSliderToGroup(
			(int) $sliderId,
			(int) $groupId
		);
	}

	die( json_encode( [ 'groupId' => $groupId ] ) );
}


function ls_add_slider_to_group() {

	LS_Sliders::addSliderToGroup(
		(int) $_GET['sliderId'],
		(int) $_GET['groupId']
	);
}


function ls_rename_slider_group() {

	LS_Sliders::renameGroup(
		(int) $_GET['groupId'],
		$_GET['name']
	);
}


function ls_remove_slider_from_group() {

	LS_Sliders::removeSliderFromGroup(
		(int) $_GET['sliderId'],
		(int) $_GET['groupId']
	);
}


function ls_delete_slider_group() {

	LS_Sliders::removeGroup( (int) $_GET['groupId'] );
}



// Template store last viewed
function ls_store_opened() {
	update_user_meta(get_current_user_id(), 'ls-store-last-viewed', date('Y-m-d'));
	exit;
}

function layerslider_delete_caches() {

	global $wpdb;
	$sql = "SELECT * FROM $wpdb->options
			WHERE option_name LIKE '_transient_ls-slider-data-%'
			ORDER BY option_id DESC LIMIT 100";

	if( $transients = $wpdb->get_results($sql) ) {
		foreach( $transients as $key => $value ) {
			$key = str_replace('_transient_', '', $value->option_name);
			delete_transient($key);
		}
	}
}

function layerslider_empty_caches() {
	layerslider_delete_caches();
	wp_redirect( admin_url('admin.php?page=layerslider&message=cacheEmpty') );
	exit;
}


function layerslider_empty_google_fonts() {
	delete_option( 'ls-google-fonts' );
	wp_redirect( admin_url('admin.php?page=layerslider&message=googleFontsEmpty') );
	exit;
}


function ls_add_new_slider() {

	$title 	= ! empty( $_POST['title'] ) ? $_POST['title'] : __('Unnamed Project', 'LayerSlider');
	$id 	= LS_Sliders::add( $title );

	wp_redirect( admin_url('admin.php?page=layerslider&action=edit&id='.$id.'&showsettings=1') );
	exit;
}

function ls_sliders_bulk_action() {

	// Export
	if( $_POST['action'] === 'export' ) {
		ls_export_sliders();

	} elseif( $_POST['action'] === 'export-html' ) {
		ls_export_as_html( (int) $_POST['sliders'][0] );

	} elseif( $_POST['action'] === 'duplicate') {
		layerslider_duplicateslider( $_POST['sliders'][0] );

	// Hide
	} elseif($_POST['action'] === 'hide') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) {
				LS_Sliders::remove( intval($item) );
				delete_transient('ls-slider-data-'.intval($item));
			}
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=hideSuccess&count='.count($_POST['sliders'])) );
			exit;
		} else {
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=hideSelectError&error=1') );
			exit;
		}


	// Delete
	} elseif($_POST['action'] === 'delete') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) {
				LS_Sliders::delete( intval($item) );
				LS_Revisions::clear( intval($item) );
				delete_transient('ls-slider-data-'.intval($item));
			}
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=deleteSuccess&count='.count($_POST['sliders'])) );
			exit;
		} else {
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=deleteSelectError&error=1') );
			exit;
		}


	// Restore
	} elseif($_POST['action'] === 'restore') {
		if(!empty($_POST['sliders']) && is_array($_POST['sliders'])) {
			foreach($_POST['sliders'] as $item) { LS_Sliders::restore( intval($item)); }
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=restoreSuccess&count='.count($_POST['sliders'])) );
			exit;
		} else {
			wp_redirect( admin_url( 'admin.php?page=layerslider&message=restoreSelectError&error=1') );
			exit;
		}


	// Group
	} elseif($_POST['action'] === 'group') {

		// Error check
		if(!isset($_POST['sliders'][1]) || !is_array($_POST['sliders'])) {
			wp_redirect( admin_url( 'admin.php?page=layerslider&error=1&message=groupSelectError') );
			exit;
		}

		if( $sliders = LS_Sliders::find($_POST['sliders']) ) {
			$groupId = LS_Sliders::addGroup(
				__('Unnamed Group', 'LayerSlider')
			);

			foreach( $sliders as $slider ) {
				LS_Sliders::addSliderToGroup( $slider['id'], $groupId );
			}
		}

		wp_redirect( admin_url( 'admin.php?page=layerslider&message=groupSuccess&count='.count($_POST['sliders']) ) );
		exit;

	// Merge
	} elseif($_POST['action'] === 'merge') {

		// Error check
		if(!isset($_POST['sliders'][1]) || !is_array($_POST['sliders'])) {
			wp_redirect( admin_url( 'admin.php?page=layerslider&error=1&message=mergeSelectError') );
			exit;
		}

		if($sliders = LS_Sliders::find($_POST['sliders'])) {
			foreach($sliders as $key => $item) {

				// Get IDs
				$ids[] = '#' . $item['id'];

				// Merge slides
				if($key === 0) { $data = $item['data']; }
				else { $data['layers'] = array_merge($data['layers'], $item['data']['layers']); }
			}

			// Save as new
			$name = 'Merged sliders of ' . implode(', ', $ids);
			$data['properties']['title'] = $name;
			LS_Sliders::add($name, $data);
		}

		wp_redirect( admin_url( 'admin.php?page=layerslider&message=mergeSuccess&count='.count( $_POST['sliders'] ) ) );
		exit;
	}
}

function ls_save_plugin_settings() {

	check_admin_referer('ls-save-plugin-settings');

	// Get capability
	$capability = ( $_POST['custom_role'] === 'custom' ) ?
					$_POST['custom_capability'] :
					$_POST['custom_role'];

	// Test capability
	if( ! empty( $capability ) && current_user_can( $capability ) ) {
		update_option('layerslider_custom_capability', $capability);
	}

	// Language
	update_option('ls_custom_locale', $_POST['ls_custom_locale'] );

	$options = [

		//Performance
		'use_cache',
		'include_at_footer',
		'conditional_script_loading',
		'concatenate_output',
		'defer_scripts',
		'use_loading_attribute',

		// Troubleshooting
		'clear_3rd_party_caches',
		'admin_no_conflict_mode',
		'rocketscript_ignore',
		'load_all_js_files',
		'gsap_sandboxing',
		'use_custom_jquery',

		// Miscellaneous
		'tinymce_helper',
		'gutenberg_block',
		'elementor_widget',
		'suppress_debug_info',

		// Project Defaults
		'use_srcset',
		'enhanced_lazy_load',
	];

	foreach( $options as $item ) {
		update_option('ls_'.$item, (int) array_key_exists($item, $_POST));
	}

	// Google Fonts
	update_option('layerslider-google-fonts-enabled', (int) array_key_exists('ls_gdpr_goole_fonts', $_POST) );

	// Scripts priority
	update_option('ls_scripts_priority', (int)$_POST['scripts_priority']);



	layerslider_delete_caches();

	die( json_encode( [ 'success' => true ] ) );
}

function ls_save_google_fonts() {

	check_admin_referer('save-google-fonts');

	$fonts = [];
	if( ! empty( $_POST['fonts'] ) && is_array( $_POST['fonts'] ) ) {
		foreach( $_POST['fonts'] as $key => $val ) {

			if( ! empty( $val ) ) {
				$fonts[] = [
					'param' => $val
				];
			}
		}
	}

	update_option('ls-google-fonts', $fonts );
	exit;
}


function ls_save_pagination_limit() {

	$userID = get_current_user_id();
	$limit 	= (int) $_POST['limit'];

	update_user_meta( $userID, 'ls-pagination-limit', $limit );
	exit;
}


function ls_save_editor_settings() {

	wp_verify_nonce( $_POST['nonce'], 'ls-save-editor-settings');
	update_user_meta( get_current_user_id(), 'ls-editor-settings', $_POST['data'] );
	exit;
}

function ls_slider_library_contents() {

	$sliders = LS_Sliders::find([
		'orderby' => 'date_c',
		'order' => 'DESC',
		'limit' => 200,
		'groups' => true
	]);

	$excludeActionSheet = true;

	include LS_ROOT_PATH.'/templates/tmpl-slider-library.php';

	exit;
}


function ls_get_slider_details( ) {

	$sliderID = (int) $_GET['sliderID'];

	$slider = LS_Sliders::find( $sliderID );
	$preview = apply_filters('ls_preview_for_slider', $slider );

	die( json_encode([
		'id' => $slider['id'],
		'slug' => $slider['slug'],
		'name' => apply_filters('ls_slider_title', stripslashes( $slider['name'] ), 40 ),
		'previewurl' => ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif',
		'slidecount' => ! empty( $slider['data']['layers'] ) ? count( $slider['data']['layers'] ) : 0,
		'author' => $slider['author'],
		'date_c' => $slider['date_c'],
		'date_m' => $slider['date_m']
	]) );
}


function ls_get_mce_sliders() {

	$sliders = LS_Sliders::find( [ 'limit' => 200 ] );

	foreach($sliders as $key => $item) {
		$sliders[$key]['preview'] = apply_filters('ls_preview_for_slider', $item );
		$sliders[$key]['name'] = ! empty($item['name']) ? htmlspecialchars(stripslashes($item['name'])) : 'Unnamed';

		// Prevent outputting the unnecessarily large slider data object that
		// in some cases also causes server issues with the large request data.
		$sliders[$key]['data'] = null;
	}

	die( json_encode( $sliders ) );
}


function ls_get_mce_slides() {

	$sliderID = (int) $_GET['sliderID'];

	$slider = LS_Sliders::find( $sliderID );
	$slider = $slider['data'];
	$slides = [];

	// Slides
	foreach($slider['layers'] as $slideKey => $slide ) {

		// Add untouched slide data
		$slides[ $slideKey ] = $slide;


		if( ! empty( $slide['properties']['backgroundId'] ) ) {
			$slides[ $slideKey ]['properties'][ 'background' ] = apply_filters('ls_get_image', $slide['properties']['backgroundId'], $slide['properties']['background']);
			$slides[ $slideKey ]['properties'][ 'backgroundThumb' ] = apply_filters('ls_get_image', $slide['properties']['backgroundId'], $slide['properties']['background']);
		}

		if( ! empty( $slide['properties']['thumbnailId'] ) ) {
			$slides[ $slideKey ]['properties'][ 'thumbnail' ] = apply_filters('ls_get_image', $slide['properties']['thumbnailId'], $slide['properties']['thumbnail']);
			$slides[ $slideKey ]['properties'][ 'thumbnailThumb' ] = apply_filters('ls_get_image', $slide['properties']['thumbnailId'], $slide['properties']['thumbnail']);
		}

		$slides[ $slideKey ]['properties']['title'] = ! empty( $slide['properties']['title'] ) ? stripslashes( $slide['properties']['title'] ) : 'Slide #'.($slideKey+1);

		// Layers
		foreach( $slide['sublayers'] as $layerKey => $layer ) {


			// Parse embedded JSON data
			$layer['styles'] 		= !empty( $layer['styles'] ) ? (object) json_decode(stripslashes($layer['styles']), true) : new stdClass;
			$layer['transition'] 	= !empty( $layer['transition'] ) ? (object) json_decode(stripslashes($layer['transition']), true) : new stdClass;
			$layer['html'] 			= !empty( $layer['html'] ) ? stripslashes($layer['html']) : '';

			// Add 'top', 'left' and 'wordwrap' to the styles object
			if(isset($layer['top'])) { $layer['styles']->top = $layer['top']; unset($layer['top']); }
			if(isset($layer['left'])) { $layer['styles']->left = $layer['left']; unset($layer['left']); }
			if(isset($layer['wordwrap'])) { $layer['styles']->wordwrap = $layer['wordwrap']; unset($layer['wordwrap']); }

			if( ! empty( $layer['transition']->showuntil ) ) {

				$layer['transition']->startatout = 'transitioninend + '.$layer['transition']->showuntil;
				$layer['transition']->startatouttiming = 'transitioninend';
				$layer['transition']->startatoutvalue = $layer['transition']->showuntil;
				unset($layer['transition']->showuntil);
			}

			if( ! empty( $layer['transition']->parallaxlevel ) ) {
				$layer['transition']->parallax = true;
			}

			// Custom attributes
			$layer['innerAttributes'] = !empty($layer['innerAttributes']) ?  (object) $layer['innerAttributes'] : new stdClass;
			$layer['outerAttributes'] = !empty($layer['outerAttributes']) ?  (object) $layer['outerAttributes'] : new stdClass;


			// v6.5.6: Convert old checkbox media settings to the new
			// select based options.
			if( isset( $layer['transition']->controls ) ) {
				if( true === $layer['transition']->controls ) {
					$layer['transition']->controls = 'auto';
				} elseif( false === $layer['transition']->controls ) {
					$layer['transition']->controls = 'disabled';
				}
			}

			$slides[ $slideKey ]['sublayers'][ $layerKey ] = $layer;

			if( ! empty( $layer['imageId'] ) ) {
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'image' ] = apply_filters('ls_get_image', $layer['imageId'], $layer['image']);
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'imageThumb' ] = apply_filters('ls_get_image', $layer['imageId'], $layer['image']);
			}

			if( ! empty( $layer['posterId'] ) ) {
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'poster' ] = apply_filters('ls_get_image', $layer['posterId'], $layer['poster']);
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'posterThumb' ] = apply_filters('ls_get_image', $layer['posterId'], $layer['poster']);
			}

			if( ! empty( $layer['layerBackgroundId'] ) ) {
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'layerBackground' ] = apply_filters('ls_get_image', $layer['layerBackgroundId'], $layer['layerBackground']);
				$slides[ $slideKey ]['sublayers'][ $layerKey ][ 'layerBackgroundThumb' ] = apply_filters('ls_get_image', $layer['layerBackgroundId'], $layer['layerBackground']);
			}

			$slides[ $slideKey ]['sublayers'][ $layerKey ]['subtitle'] = ! empty( $layer['subtitle'] ) ? substr( stripslashes( $layer['subtitle'] ), 0, 32) : 'Layer #'.($layerKey+1);
		}

		$slides[ $slideKey ][ 'sublayers' ] = array_reverse( $slides[ $slideKey ][ 'sublayers' ] );
	}

	die( json_encode( $slides ) );
}



function ls_prepare_save_data( $data ) {

	// Parse slider settings
	$data['properties'] = json_decode( stripslashes( html_entity_decode( $data['properties'] ) ), true );

	$schedule_start = $data['properties']['schedule_start'];
	$schedule_end = $data['properties']['schedule_end'];

	if( ! empty( $schedule_start ) && is_string( $schedule_start ) ) {
		$data['properties']['schedule_start'] = ls_date_create_for_timezone( $schedule_start );
	}

	if( ! empty( $schedule_end ) && is_string( $schedule_end  ) ) {
		$data['properties']['schedule_end'] = ls_date_create_for_timezone( $schedule_end  );
	}

	// Parse slide data
	if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slideKey => $slideData) {

			$slideData = json_decode(stripslashes($slideData), true);

			$schedule_start = ! empty( $slideData['properties']['schedule_start'] ) ? $slideData['properties']['schedule_start'] : '';
			$schedule_end = ! empty( $slideData['properties']['schedule_end'] ) ? $slideData['properties']['schedule_end'] : '';

			if( ! empty( $schedule_start ) && is_string( $schedule_start ) ) {
				$slideData['properties']['schedule_start'] = ls_date_create_for_timezone( $schedule_start );
			}

			if( ! empty( $schedule_end ) && is_string( $schedule_end  ) ) {
				$slideData['properties']['schedule_end'] = ls_date_create_for_timezone( $schedule_end  );
			}

			if( ! empty( $slideData['sublayers'] ) ) {
				foreach( $slideData['sublayers'] as $layerKey => $layerData ) {

					if( ! empty( $layerData['transition'] ) ) {
						$slideData['sublayers'][$layerKey]['transition'] = addslashes($layerData['transition']);
					}

					if( ! empty( $layerData['styles'] ) ) {
						$slideData['sublayers'][$layerKey]['styles'] = addslashes($layerData['styles']);
					}
				}
			}

			$data['layers'][$slideKey] = $slideData;
		}
	}

	$title = esc_sql($data['properties']['title']);
	$slug = !empty($data['properties']['slug']) ? esc_sql($data['properties']['slug']) : '';


	// Relative URL
	if( isset( $data['properties']['relativeurls'] ) ) {
		$data = layerslider_convert_urls($data);
	}

	return [
		'title' => $title,
		'slug' 	=> $slug,
		'data' 	=> $data
	];
}


function ls_save_slider() {

	// Vars
	$id 		= (int) $_POST['id'];
	$data 		= $_POST['sliderData'];
	$isDirty 	= $_POST['dirty'];

	// Security check
	check_admin_referer( 'ls-save-slider-' . $id );

	// Set $title, $slug, $data
	extract( ls_prepare_save_data( $data ) );

	// WPML
	if( has_action( 'wpml_register_single_string' ) ) {
		layerslider_register_wpml_strings( $id, $data );
	}

	// Save draft
	LS_Sliders::saveDraft( $id, $data, $isDirty );

	// Revisions handling
	if( LS_Revisions::$active ) {

		$lastRevision = LS_Revisions::last( $id );

		if( ! $lastRevision || $lastRevision->date_c < time() - 60*LS_Revisions::$interval ) {
			LS_Revisions::add( $id, json_encode($data) );

			if( LS_Revisions::count( $id ) > LS_Revisions::$limit ) {
				LS_Revisions::shift( $id );
			}
		}
	}

	die( json_encode( [ 'status' => 'ok' ] ) );
}


function ls_publish_slider() {

	// Vars
	$id 	= (int) $_POST['id'];
	$data 	= $_POST['sliderData'];

	// Security check
	check_admin_referer( 'ls-save-slider-' . $id );

	// Set $title, $slug, $data
	extract( ls_prepare_save_data( $data ) );

	// WPML
	if( has_action( 'wpml_register_single_string' ) ) {
		layerslider_register_wpml_strings( $id, $data );
	}

	// Delete transient (if any) to
	// invalidate outdated data
	delete_transient('ls-slider-data-'.$id);

	// Save draft
	LS_Sliders::saveDraft( $id, $data );

	// Revisions handling
	if( LS_Revisions::$active ) {

		$lastRevision = LS_Revisions::last( $id );

		if( ! $lastRevision || $lastRevision->date_c < time() - 60*LS_Revisions::$interval ) {
			LS_Revisions::add( $id, json_encode($data) );

			if( LS_Revisions::count( $id ) > LS_Revisions::$limit ) {
				LS_Revisions::shift( $id );
			}
		}
	}

	// Update the slider
	if( empty( $id ) ) {
		$id = LS_Sliders::add($title, $data, $slug);
	} else {
		LS_Sliders::update($id, $title, $data, $slug);
	}


	// Popup Index
	if( $data['properties']['type'] === 'popup' ) {
		$props = $data['properties'];
		LS_Popups::addIndex([
			'id' => $id,
			'first_time_visitor' => ! empty($props['popup_first_time_visitor']),
			'repeat' => ! empty( $props['popup_repeat'] ),
			'repeat_days' => $props['popup_repeat_days'],
			'roles' => [
				'administrator' => ! empty($props['popup_roles_administrator']),
				'editor' 		=> ! empty($props['popup_roles_editor']),
				'author' 		=> ! empty($props['popup_roles_author']),
				'contributor' 	=> ! empty($props['popup_roles_contributor']),
				'subscriber' 	=> ! empty($props['popup_roles_subscriber']),
				'customer' 		=> ! empty($props['popup_roles_customer']),
				'visitor' 		=> ! empty($props['popup_roles_visitor'])
			],

			'pages' => [
				'all'  		=> ! empty($props['popup_pages_all']),
				'home' 		=> ! empty($props['popup_pages_home']),
				'post' 		=> ! empty($props['popup_pages_post']),
				'page' 		=> ! empty($props['popup_pages_page']),
				'custom' 	=> $props['popup_pages_custom'],
				'exclude' 	=> $props['popup_pages_exclude']
			]
		]);

	} else {
		LS_Popups::removeIndex( $id );
	}


	// Clear 3rd party caches
	if( get_option('ls_clear_3rd_party_caches', true ) ) {
		ls_empty_3rd_party_caches();
	}


	die( json_encode( [ 'status' => 'ok' ] ) );
}


function ls_save_revisions_options() {

	// Security check
	check_admin_referer('ls-save-revisions-options');

	update_option('ls-revisions-limit', (int) $_POST['ls-revisions-limit']);
	update_option('ls-revisions-interval', (int) $_POST['ls-revisions-interval']);

	die( json_encode( [ 'status' => true ] ) );
}



function ls_revert_slider( ) {

	$sliderId 	= (int)$_POST['slider-id'];
	$revisionId = (int)$_POST['revision-id'];

	// Security check
	check_admin_referer('ls-revert-slider-'.$sliderId);

	if( empty( $sliderId ) || empty( $revisionId ) ) {
		die( json_encode( [ 'status' => false ] ) );
	}

	// Revert back to revision
	LS_Revisions::revert( $sliderId, $revisionId );

	// Delete transient cache
	delete_transient( 'ls-slider-data-'.$sliderId );

	die( json_encode( [ 'status' => true ] ) );
}


/********************************************************/
/*               Action to duplicate slider             */
/********************************************************/
function layerslider_duplicateslider( $sliderId = 0 ) {

	if( empty( $sliderId ) ) {
		$sliderId = $_GET['id'];
	}

	$sliderId = (int) $sliderId;
	if( empty( $sliderId ) ) {
		return;
	}

	// Get the original slider
	$slider = LS_Sliders::find( $sliderId );
	$data = $slider['data'];

	// Name check
	if( empty( $data['properties']['title'] ) ) {
		$data['properties']['title'] = 'Unnamed';
	}

	// Remove existing layer UUIDs for better WPML integration.
	// The editor will generate new UUIDs and register these layers
	// as new, so users can freely change the contents of the duplicated
	// slider without having conflicts with or references to the old one.
	if( ! empty( $data['layers'] ) && is_array( $data['layers'] ) ) {
		foreach( $data['layers'] as $slideKey => $slideData ) {

			if( ! empty( $slideData['sublayers'] ) && is_array( $slideData['sublayers'] ) ) {
				foreach( $slideData['sublayers'] as $layerKey => $layerData ) {

					unset( $data['layers'][ $slideKey ]['sublayers'][ $layerKey ]['uuid'] );
				}
			}
		}
	}

	// Insert the duplicate
	$data['properties']['title'] .= ' copy';
	LS_Sliders::add($data['properties']['title'], $data);

	// Success
	wp_redirect( admin_url( 'admin.php?page=layerslider&message=duplicateSuccess&count=1') );
	exit;
}


/********************************************************/
/*                Action to remove slider               */
/********************************************************/
function layerslider_hideslider() {

	// Check received data
	if(empty($_GET['id'])) { return false; }

	// Remove the slider
	LS_Sliders::remove( intval($_GET['id']) );

	// Delete transient cache
	delete_transient('ls-slider-data-'.intval($_GET['id']));

	// Reload page
	wp_redirect( admin_url( 'admin.php?page=layerslider&message=hideSuccess&count=1') );
	exit;
}


/********************************************************/
/*                Action to restore slider              */
/********************************************************/
function layerslider_restoreslider() {

	// Check received data
	if(empty($_GET['id'])) { return false; }

	// Remove the slider
	LS_Sliders::restore( (int) $_GET['id'] );

	// Delete transient cache
	delete_transient('ls-slider-data-'.intval($_GET['id']));

	// Reload page
	if( ! empty($_GET['ref']) ) {
		wp_safe_redirect( urldecode($_GET['ref']) );
	} else {
		wp_redirect( admin_url('admin.php?page=layerslider&message=restoreSuccess&count=1') );
	}

	exit;
}

/********************************************************/
/*            Actions to import sample slider            */
/********************************************************/
function ls_import_bundled() {

	// Check nonce
	check_ajax_referer('ls-import-demos', 'security');


	// Get samples and importUtil
	$sliders = LS_Sources::getDemoSliders();
	require_once LS_ROOT_PATH.'/classes/class.ls.importutil.php';

	if( ! empty($_GET['slider']) && is_string($_GET['slider'] )) {
		if( $item = LS_Sources::getDemoSlider($_GET['slider']) ) {
			if( file_exists( $item['file'] ) ) {
				$import = new LS_ImportUtil($item['file']);
				$id = $import->lastImportId;
			}
		}
	}

	die( json_encode( [
		'success' => !! $id,
		'slider_id' => $id,
		'url' => admin_url('admin.php?page=layerslider&action=edit&id='.$id)
	] ));
}


function ls_import_online() {

	// Check nonce
	check_ajax_referer('ls-import-demos', 'security');

	$name 			= $_GET['name'];
	$slider 		= urlencode( $_GET['slider'] );
	$collection 	= ! empty( $_GET['collection'] ) ? urlencode( $_GET['collection'] ) : '';
	$remoteURL 		= LS_REPO_BASE_URL.'sliders/download.php?slider='.$slider.'&collection='.$collection;

	$uploads 		= wp_upload_dir();
	$downloadPath 	= $uploads['basedir'].'/lsimport.zip';

	// Download package
	$zip 			= $GLOBALS['LS_AutoUpdate']->sendApiRequest( $remoteURL );
	$defErrorCode 	= 'ERR_UNAUTHORIZED_ACCESS';
	$defErrorTitle 	= __('Import Error', 'LayerSlider');
	$defErrorMsg 	= __('LayerSlider couldn’t download your selected slider. Please check LayerSlider → Options → System Status for potential issues. The WP Remote functions may be unavailable or your web hosting provider has to allow external connections to our domain.', 'LayerSlider');


	// Invalid response
	if( ! $zip ) {
		die( json_encode( [
			'success' => false,
			'message' => $defErrorMsg
		] ) );
	}


	// Try parsing response as JSON.
	//
	// Warn about potential errors and check
	// activation state on client side in case
	// of receiving a "Not Activated" flag
	if( $zip && $zip[0] === '{' && $zip[1] === '"' )  {
		if( $json = json_decode( $zip, true ) ) {

			// Check activation state
			if( ! empty( $json['_not_activated'] ) ) {
				$GLOBALS['LS_AutoUpdate']->check_activation_state();
				die( json_encode( [
					'success' => false,
					'reload' => true
				] ) );
			}

			die( json_encode( [
				'success' => false,
				'errCode' => ! empty( $json['errCode'] ) ? $json['errCode'] : $defErrorCode,
				'title' 	=> ! empty( $json['title'] ) ? $json['title'] : $defErrorTitle,
				'message' => ! empty( $json['message'] ) ? $json['message'] : $defErrorMsg
			] ) );
		}
	}


	// Save package
	if( ! file_put_contents($downloadPath, $zip) ) {
		die( json_encode( [
			'success' => false,
			'message' => __('LayerSlider couldn’t save the downloaded slider on your server. Please check LayerSlider → Options → System Status for potential issues. The most common reason for this issue is the lack of write permission on the /wp-content/uploads/ directory.', 'LayerSlider')
		] ) );
	}

	// Load importUtil & import the slider
	require_once LS_ROOT_PATH.'/classes/class.ls.importutil.php';
	$import = new LS_ImportUtil( $downloadPath, null, $name );
	$id = $import->lastImportId;
	$sliderCount = (int)$import->sliderCount;

	// Remove package
	unlink( $downloadPath );

	$url = admin_url('admin.php?page=layerslider&action=edit&id='.$id);

	if( $sliderCount > 1 ) {
		$url = admin_url('admin.php?page=layerslider&message=importSuccess&count='.$sliderCount);
	}

	// Success
	die( json_encode( [
		'success' => !! $id,
		'slider_id' => $id,
		'url' => $url
	] ) );
}





// IMPORT SLIDERS
//-------------------------------------------------------
function ls_import_sliders() {

	// Check export file if any
	if(!is_uploaded_file($_FILES['import_file']['tmp_name'])) {
		wp_redirect( admin_url('admin.php?page=layerslider&error=1&message=importSelectError' ) );
		die('No data received.');
	}

	require_once LS_ROOT_PATH.'/classes/class.ls.importutil.php';

	$import = new LS_ImportUtil(
		$_FILES['import_file']['tmp_name'],
		$_FILES['import_file']['name'],
		__('Imported Group', 'LayerSlider')
	);


	// One slider, redirect to editor
	if( ! empty( $import->lastImportId ) ) {

		if(	(int)$import->sliderCount === 1 ) {
			wp_redirect( admin_url('admin.php?page=layerslider&action=edit&id='.$import->lastImportId) );

		// Multiple sliders, redirect to slider list
		} else {
			wp_redirect( admin_url('admin.php?page=layerslider&message=importSuccess&count='.$import->sliderCount) );
		}

	} else {
		wp_redirect( admin_url('admin.php?page=layerslider&message=importFailed&error') );
	}

	exit;
}




// EXPORT SLIDERS
//-------------------------------------------------------
function ls_export_sliders( $sliderId = 0 ) {

	// Get sliders
	if( ! empty( $sliderId ) ) {
		$sliders = LS_Sliders::find( $sliderId );

	} elseif(isset($_POST['sliders'][0]) && $_POST['sliders'][0] == -1) {
		$sliders = LS_Sliders::find( ['limit' => 500 ] );

	} elseif(!empty($_POST['sliders'])) {
		$sliders = LS_Sliders::find($_POST['sliders']);

	} else {
		wp_redirect( admin_url( 'admin.php?page=layerslider&error=1&message=exportSelectError') );
		die('Invalid data received.');
	}

	// Check results
	if(empty($sliders)) {
		wp_redirect( admin_url( 'admin.php?page=layerslider&error=1&message=exportNotFound') );
		die('Invalid data received.');
	}

	if(class_exists('ZipArchive')) {
		include LS_ROOT_PATH.'/classes/class.ls.exportutil.php';
		$zip = new LS_ExportUtil;
	}

	// Gather slider data
	foreach($sliders as $item) {

		// Get saved project draft if any
		if( $draft = LS_Sliders::getDraft( (int) $item['id'] ) ) {
			$item['data'] = $draft['data'];
		}

		// Slider settings array for fallback mode
		$data[] = $item['data'];

		// If ZipArchive is available
		if( class_exists('ZipArchive') ) {

			// Add slider folder and settings.json
			$name = empty($item['name']) ? 'slider_' . $item['id'] : $item['name'];
			$name = sanitize_file_name($name);
			$zip->addSettings(json_encode($item['data']), $name);

			// Add images?
			if(!isset($_POST['skip_images'])) {

				remove_all_filters('wp_get_attachment_image_src');

				$images = $zip->getImagesForSlider($item['data']);
				$images = $zip->getFSPaths($images);
				$zip->addImage($images, $name);
			}
		}
	}

	if( class_exists('ZipArchive') ) {

		$date = ls_date('Y-m-d').' at '.ls_date('H.i.s');

		if( count( $sliders ) > 1 ) {
			$fileName = 'LayerSlider – '.count( $sliders ).' sliders – '.$date.'.zip';
		} else {
			$fileName = 'LayerSlider – '.$name.' – '.$date.'.zip';
		}

		$zip->download( $fileName );

	} else {
		$name = 'LayerSlider Export '.ls_date('Y-m-d').' at '.ls_date('H.i.s').'.json';
		header('Content-type: application/force-download');
		header('Content-Disposition: attachment; filename="'.str_replace(' ', '_', $name).'"');
		die(base64_encode(json_encode($data)));
	}
}




// CSS EDITOR
//-------------------------------------------------------
function ls_save_user_css() {

	// Get target file and content
	$upload_dir = wp_upload_dir();
	$file = $upload_dir['basedir'].'/layerslider.custom.css';
	$content = sanitize_textarea_field( stripslashes( $_POST['contents'] ) );

	// Attempt to save changes
	if( is_writable( $upload_dir['basedir'] ) ) {

		if( empty( $content ) ) {
			unlink( $file );
		} else {
			file_put_contents( $file, $content );
		}

		wp_redirect( admin_url( 'admin.php?page=layerslider&section=css-editor&message=editSuccess' ) );
		exit;

	// File isn't writable
	} else {
		wp_die(__('It looks like your files isn’t writable, so PHP couldn’t make any changes (CHMOD).', 'LayerSlider'), __('Cannot write to file', 'LayerSlider'), [ 'back_link' => true ] );
	}
}





// SKIN EDITOR
//-------------------------------------------------------
function ls_save_user_skin() {

	// Error checking
	if( empty( $_POST['skin'] ) || strpos( $_POST['skin'], '..' ) !== false ) {
		wp_die( __('It looks like you haven’t selected any skin to edit.', 'LayerSlider'), __('No skin selected.', 'LayerSlider'), ['back_link' => true ] );
	}

	// Get skin file and contents
	$skin = LS_Sources::getSkin( $_POST['skin'] );
	$file = $skin['file'];
	$content = sanitize_textarea_field( stripslashes( $_POST['contents'] ) );

	// Attempt to write the file
	if( is_writable( $file ) ) {
		file_put_contents( $file, $content );
		wp_redirect( admin_url( 'admin.php?page=layerslider&section=skin-editor&message=editSuccess&skin='.$skin['handle'] ) );
		exit;
	} else {
		wp_die( __('It looks like your files isn’t writable, so PHP couldn’t make any changes (CHMOD).', 'LayerSlider'), __('Cannot write to file', 'LayerSlider'), [ 'back_link' => true ] );
	}
}




// TRANSITION BUILDER
//-------------------------------------------------------
function ls_save_user_transitions() {

	$upload_dir = wp_upload_dir();
	$custom_trs = $upload_dir['basedir'] . '/layerslider.custom.transitions.js';
	$content = sanitize_textarea_field( stripslashes($_POST['ls-transitions']) );
	$data = 'var layerSliderCustomTransitions = '.$content.';';
	file_put_contents($custom_trs, $data);
	die('SUCCESS');
}


// --
function ls_get_post_details() {

	$params = $_POST['params'];

	if( empty( $params['post_type'] ) ) {
		$params['post_type'] = 'post';
	}

	$queryArgs = [
		'post_status' => 'publish',
		'limit' => 100,
		'posts_per_page' => 100,
		'post_type' => $params['post_type'],
		'suppress_filters' => false
	];

	if(!empty($params['post_orderby'])) {
		$queryArgs['orderby'] = $params['post_orderby']; }

	if(!empty($params['post_order'])) {
		$queryArgs['order'] = $params['post_order']; }

	if(!empty($params['post_categories'][0])) {
		$queryArgs['category__in'] = $params['post_categories']; }

	if(!empty($params['post_tags'][0])) {
		$queryArgs['tag__in'] = $params['post_tags']; }

	if(!empty($params['post_taxonomy']) && !empty($params['post_tax_terms'])) {
		$queryArgs['tax_query'][] = [
			'taxonomy' => $params['post_taxonomy'],
			'field' => 'id',
			'terms' => $params['post_tax_terms']
		];
	}

	$posts = LS_Posts::find($queryArgs)->getParsedObject();

	die(json_encode($posts));
}


function lse_get_search_posts() {

	$filters = [
		'posts_per_page' 	=> 50,
		'post_status' 		=> 'any',
		'post_type' 		=> 'post'
	];

	if( ! empty( $_GET['s'] ) ) {
		$filters['s'] = $_GET['s'];
	}

	if( ! empty( $_GET['post_type'] ) ) {
		$types = [ 'post', 'page', 'attachment' ];
		if( in_array( $_GET['post_type'], $types ) ) {
			$filters['post_type'] = $_GET['post_type'];
		}
	}

	$query = new WP_Query( $filters );

	if( ! empty( $query->posts ) ) {
		$ret = [];
		foreach ( $query->posts as $key => $val ) {

			if( $val->post_type === 'attachment' ) {
				$imageURL = wp_get_attachment_url( $val->ID );
			} elseif( function_exists('get_post_thumbnail_id') && function_exists('wp_get_attachment_url') ) {
				$imageURL = wp_get_attachment_url(get_post_thumbnail_id( $val->ID ));
			}

			if( ! $imageURL ) {
				$imageURL = LS_ROOT_URL . '/static/admin/img/blank.gif';
			}

			$ret[] = [
				'author' 	=> get_userdata($val->post_author)->user_nicename,
				'content' 	=> htmlentities( $val->post_content ),
				'image-url' => $imageURL,
				'post-id' 	=> $val->ID,
				'post-slug' => $val->post_name,
				'post-url' 	=> get_permalink( $val->ID ),
				'post-type' => $val->post_type,
				'title' 	=> htmlentities( $val->post_title ),
				'date-published' => get_the_date('', $val->ID ),
				'date-modified' => get_the_modified_date('', $val->ID )
			];
		}

		die( json_encode( $ret ) );
	}

	die('[]');

}


function ls_get_taxonomies() {
	die(json_encode(array_values(get_terms($_POST['taxonomy']))));
}



function ls_erase_plugin_data() {

	// Only administrators can use this function.
	if( ! current_user_can('manage_options') ) {
		die('You are not an administrator.');
	}

	// Check for network-wide
	if( isset( $_POST['networkwide'] ) && ! current_user_can('manage_network') ) {
		die('You are not a network admin.');
	}

	if( is_multisite() && isset( $_POST['networkwide'] ) ) {

		// Get current & other sites
		global $wpdb;
		$current = $wpdb->blogid;
		$sites 	 = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

		// Iterate over the sites
		foreach($sites as $site) {
			switch_to_blog($site);
			ls_do_erase_plugin_data();
		}

		// Switch back the old site
		switch_to_blog($current);

		// Deactivate LayerSlider network-wide
		deactivate_plugins( LS_PLUGIN_BASE, false, true );

	} else {
		ls_do_erase_plugin_data();
	}

	// Finished
	wp_redirect( admin_url('plugins.php') );
	exit;
}



function ls_do_erase_plugin_data() {

	require_once LS_ROOT_PATH.'/classes/class.ls.uninstaller.php';

	$uninstaller = new LS_Uninstaller;
	$uninstaller->erasePluginData();
	$uninstaller->deactivatePlugin();

}


// function ls_upload_from_url() {

// 	// Check user permission
// 	if(!current_user_can(get_option('layerslider_custom_capability', 'manage_options'))) {
// 		die( json_encode( ['success' => false ] ) );
// 	}

// 	// Get URL & uploads folder
// 	$url = $_GET['url'];
// 	$uploads = wp_upload_dir();

// 	// Check if /uploads dir is writable
// 	if(is_writable($uploads['basedir'])) {

// 		// Set upload target
// 		$targetDir	= $uploads['basedir'].'/layerslider/cc_sdk/';
// 		$targetURL	= $uploads['baseurl'].'/layerslider/cc_sdk/';
// 		$targetExt	= pathinfo($url, PATHINFO_EXTENSION);
// 		$uploadFile	= $targetDir.time().'.'.$targetExt;

// 		// Create folder if not exists
// 		if(!file_exists(dirname($targetDir))) { mkdir(dirname($targetDir), 0755); }
// 		if(!file_exists($targetDir)) { mkdir($targetDir, 0755); }

// 		// Save image from URL
// 		$fp = fopen($uploadFile, 'w');
// 		fwrite($fp, file_get_contents($url));
// 		fclose($fp);

// 		// Include image.php for media library upload
// 		require_once(ABSPATH.'wp-admin/includes/image.php');

// 		// Get file type
// 		$fileName = sanitize_file_name(basename($uploadFile));
// 		$fileType = wp_check_filetype($fileName, null);

// 		// Validate media
// 		if(!empty($fileType['ext']) && $fileType['ext'] != 'php') {

// 			// Attachment meta
// 			$attachment = [
// 				'guid' => $uploadFile,
// 				'post_mime_type' => $fileType['type'],
// 				'post_title' => preg_replace( '/\.[^.]+$/', '', $fileName),
// 				'post_content' => '',
// 				'post_status' => 'inherit'
// 			];

// 			// Insert and update attachment
// 			$attach_id = wp_insert_attachment($attachment, $uploadFile, 37);
// 			if($attach_data = wp_generate_attachment_metadata($attach_id, $uploadFile)) {
// 				wp_update_attachment_metadata($attach_id, $attach_data);
// 			}

// 			// Success
// 			die( json_encode( [
// 				'success' => true,
// 				'id' => $attach_id,
// 				'url' => $targetURL.$fileName
// 			] ) );
// 		}
// 	}
// }


function layerslider_convert_urls($arr) {

	// Global BG
	if(!empty($arr['properties']['backgroundimage']) && strpos($arr['properties']['backgroundimage'], 'http://') !== false) {
		$arr['properties']['backgroundimage'] = parse_url($arr['properties']['backgroundimage'], PHP_URL_PATH);
	}

	if(!empty($arr['layers'])) {
		foreach($arr['layers'] as $key => $slide) {

			// Layer BG
			if(strpos($slide['properties']['background'], 'http://') !== false) {
				$arr['layers'][$key]['properties']['background'] = parse_url($slide['properties']['background'], PHP_URL_PATH);
			}

			// Layer Thumb
			if(strpos($slide['properties']['thumbnail'], 'http://') !== false) {
				$arr['layers'][$key]['properties']['thumbnail'] = parse_url($slide['properties']['thumbnail'], PHP_URL_PATH);
			}

			// Image sublayers
			if(!empty($slide['sublayers'])) {
				foreach($slide['sublayers'] as $subkey => $layer) {
					if($layer['media'] == 'img' && strpos($layer['image'], 'http://') !== false) {
						$arr['layers'][$key]['sublayers'][$subkey]['image'] = parse_url($layer['image'], PHP_URL_PATH);
					}
				}
			}
		}
	}

	return $arr;
}


function layerslider_register_wpml_strings( $sliderID, $data ) {

	if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as $slideIndex => $slide) {

			if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
				foreach($slide['sublayers'] as $layerIndex => $layer) {

					if( ! empty( $layer['html'] ) && $layer['type'] != 'img' ) {

						// Check 'createdWith' property to decide which WPML implementation
						// should we use. This property was added in v6.5.5 along with the
						// new WPML implementation, so no version comparison required.
						if( ! empty( $layer['uuid'] ) && ! empty( $data['properties']['createdWith'] ) ) {

							$string_name = "slider-{$sliderID}-layer-{$layer['uuid']}-html";
							do_action( 'wpml_register_single_string', 'LayerSlider Sliders', $string_name, $layer['html'] );

						// Old implementation
						} else {

							$string_name = '<'.$layer['type'].':'.substr(sha1($layer['html']), 0, 10).'> layer on slide #'.($slideIndex+1).' in slider #'.$sliderID.'';
							do_action( 'wpml_register_single_string', 'LayerSlider WP', $string_name, $layer['html']);
						}
					}
				}
			}
		}
	}
}


function ls_export_as_html( $sliderID ) {

	// Markup export uses PHP 5.3 features (namespaces, callbacks, etc),
	// thus we cannot use the code directly on the global scope in order
	// to avoid parsing errors on pre 5.3 PHP versions.
	include LS_ROOT_PATH . '/includes/slider_markup_export.php';
}


function ls_empty_3rd_party_caches() {

	// W3 Total Cache
	if( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
	}

	// WP Fastest Cache
	if( ! empty( $GLOBALS['wp_fastest_cache'] ) && method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' ) ) {
		$GLOBALS['wp_fastest_cache']->deleteCache();
	}

	// WP Super Cache
	if( function_exists( 'wp_cache_clean_cache' ) ) {
		global $file_prefix;
		wp_cache_clean_cache( $file_prefix, true );
	}

	// WP Rocket
	if( function_exists('rocket_clean_domain') ) {
		rocket_clean_domain();
	}

	// WP-Optimize
	if( function_exists('wpo_cache_flush') ) {
		wpo_cache_flush();
	}

	// SG Optimizer
	if( function_exists('sg_cachepress_purge_cache') ) {
		sg_cachepress_purge_cache();
	}

	// LiteSpeed Cache For WordPress
	if( has_action('litespeed_purge_all') ) {
		do_action( 'litespeed_purge_all' );
	}

	// Autoptimize
	if( method_exists('autoptimizeCache', 'clearall' ) ) {
		autoptimizeCache::clearall();
	}
}
