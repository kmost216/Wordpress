<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-plugin-update-success-modal">
	<div id="ls-plugin-update-success-modal">
		<div class="ls-checkmark-wrapper">
			<div class="ls-checkmark-holder">
				<svg class="ls-checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
					<circle class="ls-checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
					<path class="ls-checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
				</svg>
			</div>
		</div>
		<h1><?= __('Update Installed', 'LayerSlider') ?></h1>
		<p><?= __('Hooray, LayerSlider just got even better! Thanks for sticking around while we keep adding new features and eliminating those pesky bugs.', 'LayerSlider') ?></p>
		<p><?= sprintf(__('You can read our detailed %srelease log%s if you’re interested, or just go ahead and reload the page to take advantage of the new version.', 'LayerSlider'), '<a target="_blank" href="https://layerslider.com/release-log/">', '</a>') ?></p>
		<p class="center ls--form-control">
			<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-blue"><?= __('Reload page', 'LayerSlider') ?></a>
		</p>
	</div>
</script>