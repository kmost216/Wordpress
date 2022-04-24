<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-plugin-update-error-modal">
	<div id="ls-plugin-update-error-modal">
		<kmw-h1 class="kmw-modal-title"><?= __('Aw, Snap!', 'LayerSlider') ?></kmw-h1>
		<p><?= __('Something went wrong and WordPress was not able to update LayerSlider. This is likely a temporary issue, and you should try again a bit later.', 'LayerSlider') ?></p>
		<p><?= __('In the meantime, you can force WordPress to re-check and verify updates by visiting Dashboard → Updates. The new version of LayerSlider can be installed there as well. That screen might also offer additional information on what the issue can be.', 'LayerSlider') ?></p>
		<p class="center ls--form-control">
			<a href="<?= wp_nonce_url( admin_url('admin.php?page=layerslider&action=check_updates'), 'check_updates' ) ?>" class="ls--button ls--bg-blue"><?= __('Visit Updates', 'LayerSlider') ?></a>
		</p>
	</div>
</script>