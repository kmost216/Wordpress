<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-activation-unavailable">
	<kmw-h1 class="kmw-modal-title"><?= __('License registration unavailable', 'LayerSlider') ?></kmw-h1>
	<p><?= __('LayerSlider was unable to display the license registration screen due to an unexpected issue. Your active WordPress theme likely interferes and proactively tries to hide the license registration box.', 'LayerSlider') ?></p>
	<p><?= __('To resolve this issue, please review your theme settings and try to find a relevant option. Some themes include an option to “silence” bundled plugin notifications. Unfortunately, an option like that can also prevent you from using the product properly and receiving additional benefits.', 'LayerSlider') ?></p>

	<?php if( class_exists( 'The7_Admin_Dashboard_Settings' ) && function_exists( 'presscore_is_silence_enabled' ) && presscore_is_silence_enabled() ) : ?>
	<div class="ls-center">
		<a href="<?= admin_url('admin.php?page=layerslider&action=disable_dt_silence') ?>" class="button button-primary button-hero"><?= __('Disable The7’s silence plugin notifications option', 'LayerSlider') ?></a>
	</div>
	<?php else : ?>
	<p><?= sprintf( __('Alternatively, you can ask the author of your WordPress theme to take steps and make the license registration box visible again. Also %smake sure to always use an original copy of LayerSlider%s downloaded from an official source. Pirated or modified copies can suffer from the same issue.', 'LayerSlider'), '<b>', '</b>') ?></p>
	<?php endif ?>
</script>