<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-plugin-update-easter-egg-modal">
	<div id="ls-plugin-update-easter-egg-modal">
		<?= lsGetSVGIcon('police-box', 'duotone') ?>
		<h1><?= __('Hang in there ...', 'LayerSlider') ?></h1>
		<p><?= __('You can have all the updates you can handle ... but for that, we’d need a time-machine, wouldn’t we?', 'LayerSlider') ?></p>
		<p><?= __('We ask your patience while we’re unlocking the secrets of the space-time continuum. Or just steal a TARDIS. Once we reach Time Lord status, we’ll fix the timeline and serve updates much faster. We promise!', 'LayerSlider') ?></p>
		<p><?= __('This page is kind of a mess now. Why don’t you just reload it and start using the new LayerSlider? Maybe our taste changed for the better...', 'LayerSlider') ?></p>
		<p class="center ls--form-control">
			<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-blue"><?= __('Reload page', 'LayerSlider') ?></a>
		</p>
	</div>
</script>