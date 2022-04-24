<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

// Get all skins
$skins = LS_Sources::getSkins();
$skin = (!empty($_GET['skin']) && strpos($_GET['skin'], '..') === false) ? $_GET['skin'] : '';
if(empty($skin)) {
	$skin = reset($skins);
	$skin = $skin['handle'];
}
$skin = LS_Sources::getSkin($skin);
$file = $skin['file'];


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
							<?= __('LayerSlider Skin Editor', 'LayerSlider') ?>
						</ls-h2>
					</ls-col>
					<ls-col class="ls--col1-2 ls--text-right">
						<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-lightgray"><?= lsGetSVGIcon('arrow-left') ?><ls-button-text><?= __('Back', 'LayerSlider') ?></ls-button-text></a>
					</ls-col>
				</ls-row>
			</ls-grid>

			<ls-box>

				<input type="hidden" name="ls-user-skins" value="1">
				<?php wp_nonce_field('save-user-skin'); ?>
				<ls-table>
					<table class="ls--table">
						<thead>
							<tr>
								<th class="ls--text-center">
									<ls-small class="ls--text-caps"><?= __('Choose a skin:', 'LayerSlider') ?></ls-small>
									<ls-select-wrapper>
										<select name="skin" class="ls-skin-editor-select ls--bg-white ls--small ls--dark">
											<?php foreach($skins as $item) : ?>
											<?php if($item['handle'] == $skin['handle']) { ?>
											<option value="<?= $item['handle'] ?>" selected="selected"><?= $item['name'] ?></option>
											<?php } else { ?>
											<option value="<?= $item['handle'] ?>"><?= $item['name'] ?></option>
											<?php } ?>
											<?php endforeach; ?>
										</select>
										<ls-select-arrow class="ls--dark"></ls-select-arrow>
									</ls-select-wrapper>

								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="ls--text-center ls--bg-yellow">
									<small class="ls--dark ls--strong">
										<?= __('Built-in skins will be overwritten by plugin updates. Making changes should be done through the Custom Styles Editor.', 'LayerSlider') ?>
									</small>
								</td>
							</tr>
							<tr>
								<td class="ls--p-0">
									<textarea rows="10" cols="50" name="contents" class="ls-codemirror"><?= htmlentities(file_get_contents($file)); ?></textarea>
								</td>
							</tr>
							<tr>
								<td class="ls--text-center ls--bg-yellow">
									<small class="ls--dark ls--strong">
										<?= __('Modifying a skin with invalid code can break your projects’ appearance.<br>Changes cannot be reverted after saving.', 'LayerSlider') ?>
									</small>
								</td>
							</tr>
						</tbody>
					</table>
				</ls-table>

			</ls-box>

		</ls-section>

		<ls-section class="ls--form-control">

			<?php if( ! is_writable($file)) { ?>
			<ls-p class="ls--text-center ls--strong ls--gray">
				<?= sprintf(__('You need to make this file writable in order to save your changes. See the %sCodex%s for more information.', 'LayerSlider'), '<a href="https://wordpress.org/support/article/changing-file-permissions/" target="_blank">', '</a>') ?>
			</ls-p>
			<?php } else { ?>
			<button class="ls--button ls--bg-blue"><?= __('Save changes', 'LayerSlider') ?></button>
			<?php } ?>

		</ls-section>

	</form>

</div>