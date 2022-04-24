<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-slide-tab">
	<lse-b class="lse-slide-tab">
		<lse-b class="lse-slide-preview-container lse-has-contextmenu" data-contextmenu-selector="#lse-context-menu-slide-settings">
			<lse-b class="lse-slide-preview"></lse-b>
			<?= lsGetSVGIcon('eye-slash', false, ['class' => 'lse-slide-hidden']) ?>
			<?= lsGetSVGIcon('ellipsis-v', false,
				[
					'class' => 'lse-slide-actions lse-has-left-contextmenu',
					'data-contextmenu-selector' => '#lse-context-menu-slide-settings'
				])?>
			<lse-i class="lse-slide-counter"></lse-i>
			<lse-i class="lse-slide-text"><?= __('No Preview', 'LayerSlider') ?></lse-i>
		</lse-b>
		<lse-b class="lse-slide-name">
			<input type="text" placeholder="<?= __('Slide name', 'LayerSlider') ?>">
		</lse-b>
	</lse-b>
</script>