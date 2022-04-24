<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

// Attempt to workaround memory limit & execution time issues
@ini_set( 'max_execution_time', 0 );
@ini_set( 'memory_limit', apply_filters( 'admin_memory_limit', WP_MAX_MEMORY_LIMIT ) );

$deleteLink = '';
if( !empty( $_GET['user'] ) ) {
	$deleteLink = wp_nonce_url('users.php?action=delete&amp;user='.(int)$_GET['user'], 'bulk-users' );
}

$authorized = LS_Config::isActivatedSite();
$isAdmin 	= current_user_can('manage_options');

$notifications = [

	'dbUpdateSuccess' => __('LayerSlider has attempted to update your database. Server restrictions may apply, please verify whether it was successful.', 'LayerSlider'),

	'clearGroupsSuccess' => __('Groups have been removed. All projects are now moved to the main grid where they remain available to you.', 'LayerSlider')
];


// Notify OSD
if( isset( $_GET['message'] ) ) {
	wp_localize_script('ls-common', 'LS_statusMessage', [
		'icon' 		=> isset( $_GET['error'] ) ? 'error' : 'success',
		'iconColor' => isset( $_GET['error'] ) ? '#ff2323' : '#8BC34A',
		'text' 		=> $notifications[ $_GET['message'] ],
		'timeout' 	=> 8000
	]);
}

// Icons
wp_localize_script('ls-common', 'LS_InterfaceIcons', [

	'notifications' => [
		'error' 	=> lsGetSVGIcon('exclamation-triangle'),
		'success' 	=> lsGetSVGIcon('check'),
	]
]);

include LS_ROOT_PATH . '/includes/ls_global.php';

?>

<!-- Notify OSD -->
<ls-div class="ls-notify-osd">
	<ls-span class="icon"></ls-span>
	<ls-span class="text"></ls-span>
</ls-div>



<div class="wrap">
	<ls-section id="ls--system-status" class="ls--form-control">
		<ls-grid class="ls--header">
			<ls-row class="ls--flex-stretch ls--flex-center ls--no-min-width">
				<ls-col class="ls--col1-2">
					<ls-h2 class="ls--clear-after">
						<?= __('LayerSlider System Status', 'LayerSlider') ?>
					</ls-h2>
				</ls-col>
				<ls-col class="ls--col1-2 ls--text-right">
					<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-lightgray"><?= lsGetSVGIcon('arrow-left') ?><ls-button-text><?= __('Back', 'LayerSlider') ?></ls-button-text></a>
				</ls-col>
			</ls-row>
		</ls-grid>

		<ls-box>

			<ls-p>
				<?= __('This page is intended to help you identifying possible issues and to display relevant debug information about your site.', 'LayerSlider') ?>
				<?= __('Whenever a potential issues is detected, it will be marked with red or orange text describing the nature of that issue.', 'LayerSlider') ?>
			</ls-p>
			<ls-p class="ls--strong">
				<?= __('Please keep in mind that in most cases only your web hosting company can change server settings, thus you should contact them with the messages provided (if any).', 'LayerSlider') ?>

			</ls-p>
		</ls-box>

		<ls-box>

			<!-- System Status -->
			<?php
				$latest 	= LS_RemoteData::getAvailableVersion();
				$plugins 	= get_plugins();
				$cachePlugs = [];
				$timeout 	= (int) ini_get('max_execution_time');
				$memory 	= ini_get('memory_limit');
				$memoryB 	= str_replace( ['G', 'M', 'K'], ['000000000', '000000', '000'], $memory);
				$postMaxB 	= str_replace( ['G', 'M', 'K'], ['000000000', '000000', '000'], ini_get('post_max_size'));
				$uploadB 	= str_replace( ['G', 'M', 'K'], ['000000000', '000000', '000'], ini_get('upload_max_filesize'));
			?>
			<ls-table>

				<table class="ls--table ls--striped">
					<thead>
						<tr>
							<th colspan="4"><?= __('Available Updates', 'LayerSlider') ?></th>
						</tr>
					</thead>
					<tbody>
						<tr class="<?= ! $authorized ? 'ls--warning' : '' ?>">
							<td><?= __('Auto-Updates:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $authorized ? 'exclamation-circle' : 'check' ) ?></td>
							<td><?= ! $authorized ?  __('Not set', 'LayerSlider') :  __('Activated', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $authorized ) : ?>
								<ls-span><?= sprintf(__('Register your LayerSlider license for auto-updates so you can always use the latest release with all the new features and bug fixes. %sClick here to learn more%s.', 'LayerSlider'), '<a href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = version_compare( LS_PLUGIN_VERSION, $latest, '>=' ); ?>
						<tr class="<?= ! $test ? 'ls--warning' : '' ?>">

							<td><?= __('LayerSlider version:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( !$test ? 'exclamation-circle' : 'check' ) ?></td>
							<td><?= LS_PLUGIN_VERSION ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= sprintf( __('Update to latest version (%1$s), as we are constantly working on new features, improvements and bug fixes.', 'LayerSlider'), $latest) ?></ls-span>
								<?php endif ?>
							</td>
						</tr>

						<?php $test = layerslider_verify_db_tables(); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('LayerSlider database:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Error', 'LayerSlider') : __('OK', 'LayerSlider') ?></td>
							<td class="ls--pb-0">
									<?php if( ! $test ) : ?>
									<ls-div class="ls--mb-2">
										<ls-span><?= __('Your database needs an update in order for LayerSlider to work properly. Please press the ’Update Database’ button on the right. If this does not help, you need to contact your web server hosting company to fix any issue preventing plugins creating and updating database tables.', 'LayerSlider') ?></ls-span>
									</ls-div>

									<?php endif ?>

									<ls-div class="ls--text-right">
										<a href="<?= wp_nonce_url( admin_url('admin.php?page=layerslider&section=system-status&action=clear_groups'), 'clear_groups') ?>" class="ls--mb-1 ls--button ls--small ls--bg-light ls-clear-groups-button"><?= __('Clear Groups', 'LayerSlider') ?></a>

										<a href="<?= wp_nonce_url( admin_url('admin.php?page=layerslider&section=system-status&action=database_update'), 'database_update') ?>" class="ls--mb-1 ls--ml-1 ls--button ls--small ls--bg-light"><?= __('Update Database', 'LayerSlider') ?></a>
									</ls-div>

							</td>
						</tr>

						<?php $test = true; ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('WordPress version:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= get_bloginfo('version') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= sprintf( __('Update WordPress to a newer version to ensure compatibility.', 'LayerSlider'), $latest) ?></ls-span>
								<?php endif ?>
							</td>
						</tr>

						<?php
							$response = wp_remote_post('https://repository.kreaturamedia.com/v4/ping/' );
							$test = ( ! is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 );
						?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('WP Remote functions:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Blocked', 'LayerSlider') : __('OK', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= sprintf( __('Failed to connect to our update server. This could cause issues with license registration, serving updates, downloading templates and installable modules, and displaying certain information like the release log. It’s most likely a web server configuration issue. Please contact your server host and ask them to allow external connections to %srepository.kreaturamedia.com%s domain and have cURL and the necessary components installed.', 'LayerSlider'), '<ls-mark class="ls--bg-red ls--white">', '</ls-mark>' ) ?></ls-span>
								<?php endif ?>
							</td>
						</tr>

					<tbody>
					<thead>
						<th colspan="4"><?= __('Site Setup & Plugin Settings', 'LayerSlider') ?></th>
					</thead>
					<tbody>


						<?php

							if( $authorized ) :
							$test = strpos(LS_ROOT_FILE, '/wp-content/plugins/LayerSlider/');
							if( ! $test ) { $test = strpos(LS_ROOT_FILE, '\\wp-content\\plugins\\LayerSlider\\'); }

						?>
						<tr class="<?= ! $test ? 'ls--info' : ''?>">
							<td><?= __('Install Location', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'info-circle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Non-standard', 'LayerSlider') : __('OK', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span>
									<?= __('Using LayerSlider from a non-standard install location or having a different directory name could lead issues in receiving and installing updates. Commonly, you see this issue when you’re using a theme-included version of LayerSlider. To fix this, please first search for an option to disable/unload the bundled version in your theme, then re-install a fresh copy. Your projects and settings are stored in the database, re-installing the plugin will not harm them.', 'LayerSlider') ?>
								</ls-span>
								<?php endif ?>
							</td>
						</tr>
						<?php endif ?>


						<?php $test = defined('WP_DEBUG') && WP_DEBUG; ?>
						<tr class="<?= ! $test ? 'ls--info' : '' ?>">
							<td><?= __('WP Debug Mode:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'info-circle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Disabled', 'LayerSlider') : __('Enabled', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span>
									<?= __('If you experience any issue, we recommend enabling the WP Debug mode while debugging.', 'LayerSlider') ?>
									<?= '<a href="https://wordpress.org/support/article/debugging-in-wordpress/" target="_blank">'. __('Click here to learn more', 'LayerSlider') .'</a>' ?>
								</ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php
							$uploads = wp_upload_dir();
							$uploadsDir = $uploads['basedir'];
							$test = file_exists($uploadsDir) && is_writable($uploadsDir);
						?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('Uploads directory:', 'LayerSlider') ?></td>
							<td>
								<?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Inaccessible', 'LayerSlider') : __('OK', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span>
									<?= __('LayerSlider uses the uploads directory for image uploads, exporting/importing projects, and downloading modules. Make sure that your /wp-content/uploads/ directory exists and has write permission.', 'LayerSlider') ?>
									<?= '<a href="http://www.wpbeginner.com/wp-tutorials/how-to-fix-image-upload-issue-in-wordpress/" target="_blank">'. __('Click here to learn more', 'LayerSlider') .'</a>' ?>
								</ls-span>
								<?php endif ?>
							</td>
						</tr>

						<?php

							foreach($plugins as $key => $plugin) {
								if(
									stripos( $plugin['Name'], 'cache' ) !== false ||
									stripos( $plugin['Name'], 'Cachify' ) !== false ||
									stripos( $plugin['Name'], 'Optimi' ) !== false ||
									stripos( $plugin['Name'], 'WP Rocket' ) !== false
								) {
									$cachePlugs[] = $plugin['Name'];
								}
							}

							$test = empty( $cachePlugs );
						?>
						<tr class="<?= ! $test ? 'ls--warning' : '' ?>">
							<td><?= __('Cache plugins', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-circle' : 'check' ) ?></td>
							<td><?= ! $test ? implode(', ', $cachePlugs) : __('Not found', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('The listed plugin(s) may prevent edits and other changes to show up on your site in real-time. Empty your caches if you experience any issue.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>

						<?php $test = ! get_option('ls_use_custom_jquery', false); ?>
						<tr class="<?= ! $test ? 'ls--warning' : '' ?>">

							<td><?= __('jQuery Google CDN:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Enabled', 'LayerSlider') : __('Disabled', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('Should be used in special cases only, as it can break otherwise functioning sites. This option is located on the main LayerSlider admin screen under the Advanced tab.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>
					</tbody>
					<thead>
						<tr>
							<th colspan="4"><?= __('Server Settings', 'LayerSlider') ?></th>
						</tr>
					</thead>
					<tbody>

						<?php $test = version_compare( phpversion(), '5.4', '>=' ); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Version:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= phpversion() ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('LayerSlider requires PHP 5.4.0 or newer. Please contact your host and ask them to upgrade PHP on your web server. Alternatively, they often offer a customer dashboard for their services, which might also provide an option to choose your preferred PHP version.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = ! ( $timeout > 0 && $timeout < 60 ); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Time Limit:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! empty( $timeout ) ? $timeout.'s' : 'No limit' ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('PHP max. execution time should be set to at least 60 seconds or higher when importing large projects. Please contact your host and ask them to change this PHP setting on your web server accordingly.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = ! ( (int)$memory > 0 && $memoryB < 64 * 1000 * 1000 ); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Memory Limit:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= $memory ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('PHP memory limit should be set to at least 64MB or higher when dealing with large projects. Please contact your host and ask them to change this PHP setting on your web server accordingly.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = $postMaxB > 16 * 1000 * 1000; ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Post Max Size:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ini_get('post_max_size') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('Importing larger projects could be problematic in some cases. This option is needed to upload large files. We recommend to set it to at least 16MB or higher. Please contact your host and ask them to change this PHP setting on your web server accordingly.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = $uploadB > 16 * 1000 * 1000; ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Max Upload Size:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ini_get('upload_max_filesize') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('Importing larger projects could be problematic in some cases. This option is needed to upload large files. We recommend to set it to at least 16MB or higher. Please contact your host and ask them to change this PHP setting on your web server accordingly.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = ! extension_loaded('suhosin'); ?>
						<tr class="<?= ! $test ? 'ls--warning' : '' ?>">
							<td><?= __('Suhosin:', '') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-circle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Active', 'LayerSlider') : __('Not found', 'LayerSlider'); ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('Suhosin may override PHP server settings that are otherwise marked OK here. If you experience issues, please contact your web hosting company and ask them to verify the listed server settings.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = class_exists('ZipArchive'); ?>
						<tr class="<?= ! $test ? 'ls--warning' : '' ?>">
							<td><?= __('PHP ZipArchive Extension:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-circle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Disabled', 'LayerSlider') : __('Enabled', 'LayerSlider'); ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('The PHP ZipArchive extension is needed to export projects. Please note, this is *NOT* the equivalent of the PEAR Archive_Zip package. The two are different, and hosting companies usually don’t offer a way to make this change on your own. Please contact your server hosting company and ask them to enable PHP’s ZipArchive extension.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>



						<?php $test = class_exists('DOMDocument'); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP DOMDocument Extension:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Disabled', 'LayerSlider') : __('Enabled', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('Front-end projects and the editor interface require the PHP DOMDocument extension and will not work properly without it. Please contact your web hosting company and ask them enable the PHP DOMDocument extension.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = extension_loaded('mbstring'); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Multibyte String Extension:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Disabled', 'LayerSlider') : __('Enabled', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('The lack of PHP “mbstring” extension can lead to unexpected issues. Contact your server hosting provider and ask them to install/enable this extension.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>


						<?php $test = function_exists('mb_ereg_match'); ?>
						<tr class="<?= ! $test ? 'ls--error' : '' ?>">
							<td><?= __('PHP Multibyte Regex Functions:', 'LayerSlider') ?></td>
							<td><?= lsGetSVGIcon( ! $test ? 'exclamation-triangle' : 'check' ) ?></td>
							<td><?= ! $test ? __('Disabled', 'LayerSlider') : __('Enabled', 'LayerSlider') ?></td>
							<td>
								<?php if( ! $test ) : ?>
								<ls-span><?= __('The lack of PHP “mbregex” module can lead to unexpected issues. Contact your server hosting provider and ask them to install/enable this module.', 'LayerSlider') ?></ls-span>
								<?php endif ?>
							</td>
						</tr>

					</tbody>
				</table>

			</ls-table>

		</ls-box>

	</ls-section>

	<ls-section class="ls--form-control">

		<ls-grid>
			<ls-row class="ls--flex-stretch ls--flex-center ls--no-min-width">
				<ls-col class="ls--col1-2">
					<ls-button class="ls-phpinfo-button ls--bg-blue"><?= __('Show Advanced Details', 'LayerSlider') ?></ls-button>
				</ls-col>
				<ls-col class="ls--col1-2 ls--text-right">
					<ls-button class="ls-erase-button ls--bg-red"><?= __('Erase All Plugin Data', 'LayerSlider') ?></ls-button>
				</ls-col>
			</ls-row>
		</ls-grid>

	</ls-section>

	<script type="text/html" id="ls-phpinfo">
		<?php phpinfo(); ?>
	</script>

	<script type="text/html" id="ls-phpinfo-modal">
		<ls-div id="ls-phpinfo-modal-window">
			<kmw-h1 class="kmw-modal-title"><?= __('Advanced Debug Details', 'LayerSlider') ?></kmw-h1>
			<iframe></iframe>
		</ls-div>
	</script>

	<script type="text/html" id="ls-erase-modal">
		<ls-div id="ls-erase-modal-window" class="ls--form-control">

			<kmw-h1 class="kmw-modal-title"><?= __('Erase All Plugin Data', 'LayerSlider') ?></kmw-h1>
			<form method="post" class="inner" onsubmit="return confirm('<?= __('This action cannot be undone. All LayerSlider data will be permanently deleted and you will not be able to restore them afterwards. Please consider every possibility before deciding.\r\n\r\n Are you sure you want to continue?', 'LayerSlider') ?>');">
				<ls-p><?= __('When you deactivate or remove LayerSlider, your projects and settings are retained to prevent accidental data loss. You can use this utility if you really want to erase all data used by LayerSlider.', 'LayerSlider') ?></ls-p>
				<ls-p class="ls--strong"><?= __('The following actions will be performed when you confirm your intention to erase all plugin data:', 'LayerSlider'); ?></ls-p>

				<?php wp_nonce_field('erase_data'); ?>

				<ls-ul class="ls--list-style-disc">
					<ls-li><?= __('Remove LayerSlider’s database tables, which store your projects, drafts, and revisions.', 'LayerSlider') ?></ls-li>
					<ls-li><?= __('Remove the relevant entries from the <i>wp_options</i> database table, which stores plugin settings.', 'LayerSlider') ?></ls-li>
					<ls-li><?= __('Remove the relevant entries from the <i>wp_usermeta</i> database table, which stores user associated plugin settings.', 'LayerSlider') ?></ls-li>
					<ls-li><?= __('Remove files and folders created by LayerSlider from the <i>/wp-content/uploads</i> directory. This will not affect your own uploads in the Media Library.', 'LayerSlider') ?></ls-li>
					<ls-li><?= __('Deactivate LayerSlider as a last step.', 'LayerSlider') ?></ls-li>
				</ls-ul>
				<ls-p><ls-i><?= __('The actions above will be performed on this blog only. If you have a multisite network and you are a network administrator, then an “Apply to all sites” checkbox will appear, which you can use to erase data from every site in your network if you choose so.', 'LayerSlider') ?></ls-i></ls-p>

				<ls-p><?= __('Please note: You CANNOT UNDO this action. Please CONSIDER EVERY POSSIBILITY before choosing to erase all plugin data, as you will not be able to restore data afterwards.', 'LayerSlider') ?></ls-p>

				<?php if( is_multisite() && current_user_can('manage_network') ) : ?>
					<ls-p class="ls--text-center">
						<label><input type="checkbox" name="networkwide" onclick="return confirm('<?= __('Are you sure you want to erase plugin data from every site in network?', 'LayerSlider') ?>');"> <?= __('Apply to all sites in multisite network', 'LayerSlider') ?></label>
					</ls-p>
				<?php endif ?>


				<ls-p class="ls--text-center">
					<button type="submit" name="ls-erase-plugin-data" class="ls--button ls--bg-red <?= $isAdmin ? '' : 'ls--disabled' ?>" <?= $isAdmin ? '' : 'disabled' ?>><?= __('Erase Plugin Data', 'LayerSlider') ?></button>
					<?php if( ! $isAdmin ) : ?>
					<ls-p class="ls--notice">
						<?= __('You must be an administrator to use this feature.', 'LayerSlider') ?>
					</ls-p>
					<?php endif ?>
				</ls-p>
			</form>
		</ls-div>
	</script>

	<script>

		jQuery(document).ready(function() {

			jQuery('.ls-phpinfo-button').click(function() {

				var $modal = kmw.modal.open({
					content: '#ls-phpinfo-modal',
					minWidth: 400,
					maxWidth: 1200,
					maxHeight: '100%'
				});

				var $contents = jQuery('#ls-phpinfo').text();

				$modal.find('iframe').contents().find('html').html( $contents );
			});


			jQuery('.ls-erase-button').click(function() {

				kmw.modal.open({
					content: '#ls-erase-modal',
					minWidth: 400,
					maxWidth: 1000
				});
			});


			jQuery('.ls-clear-groups-button').click( function( event ) {

				if( ! confirm( LS_l10n.SSClearGroupsConfirmation ) ) {
					event.preventDefault();
				}
			});

		});
	</script>
</div>