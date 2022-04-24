<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

// Get uploads dir
$upload_dir = wp_upload_dir();
$file = $upload_dir['basedir'].'/layerslider.custom.css';

// Get contents
$contents = file_exists($file) ? file_get_contents($file) : '';


$notifications = [
	'editSuccess' => __('Your changes has been saved', 'LayerSlider')
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

	<form method="post">

		<ls-section class="ls--form-control">

			<ls-grid class="ls--header">
				<ls-row class="ls--flex-stretch ls--flex-center ls--no-min-width">
					<ls-col class="ls--col1-2">
						<ls-h2 class="ls--clear-after">
							<?= __('LayerSlider CSS Editor', 'LayerSlider') ?>
						</ls-h2>
					</ls-col>
					<ls-col class="ls--col1-2 ls--text-right">
						<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-lightgray"><?= lsGetSVGIcon('arrow-left') ?><ls-button-text><?= __('Back', 'LayerSlider') ?></ls-button-text></a>
					</ls-col>
				</ls-row>
			</ls-grid>

			<ls-box>

				<input type="hidden" name="ls-user-css" value="1">
				<?php wp_nonce_field('save-user-css'); ?>

				<ls-table>
					<table class="ls--table">
						<thead>
							<tr>
								<th class="ls--text-center">
									<ls-small class="ls--text-caps"><?= __('Contents of your custom CSS file', 'LayerSlider') ?></ls-small>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="ls--p-0">
									<textarea rows="10" cols="50" name="contents" class="ls-codemirror"><?php if( ! empty( $contents ) ) {
											echo htmlentities( $contents );
										} else {
											echo '/*' . NL . __('You can type here custom CSS code, which will be loaded both on your admin and front-end pages. Please make sure to not override layout properties (positions and sizes), as they can interfere with the sliders built-in responsive functionality. Here are few example targets to help you get started:', 'LayerSlider');
											echo NL . '*/' . NL . NL;
											echo '.ls-container { /* Slider container */' . NL . NL . '}' .NL.NL;
											echo '.ls-layers { /* Layers wrapper */ ' . NL  . NL . '}' . NL.NL;
											echo '.ls-3d-box div { /* Sides of 3D transition objects */ ' . NL  . NL . '}';
										}?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ls--text-center ls--bg-yellow">
									<small class="ls--dark ls--strong">
										<?= __('Using invalid CSS code could break the appearance of your site or your projects. Changes cannot be reverted after saving.','LayerSlider') ?>
									</small>
								</td>
							</tr>
						</tbody>
					</table>
				</ls-table>

			</ls-box>

		</ls-section>

		<ls-section class="ls--form-control">

			<?php if( ! is_writable( $upload_dir['basedir'] ) ) { ?>
			<ls-p class="ls--text-center ls--strong ls--gray">
				<?= sprintf(__('You need to make your uploads folder writable in order to save your changes. See the %sCodex%s for more information.', 'LayerSlider'), '<a href="https://wordpress.org/support/article/changing-file-permissions/" target="_blank">', '</a>') ?>
			</ls-p>
			<?php } else { ?>
			<button class="ls--button ls--bg-blue"><?= __('Save changes', 'LayerSlider') ?></button>
			<?php } ?>

		</ls-section>

	</form>

</div>