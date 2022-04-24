<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-import-layer">

	<lse-grid id="lse-import-layer-modal-window" class="lse-import-slider-contents">

		<kmw-h1 class="kmw-modal-title"><?= __('Import Layer', 'LayerSlider') ?></kmw-h1>

		<lse-row>
			<lse-col class="lse-quarter">
				<lse-h2><?= __('Select project', 'LayerSlider') ?></lse-h2>
			</lse-col>
			<lse-col class="lse-quarter">
				<lse-h2><?= __('Choose a Slide', 'LayerSlider') ?></lse-h2>
			</lse-col>
			<lse-col class="lse-half">
				<lse-h2><?= __('Click to import', 'LayerSlider') ?></lse-h2>
			</lse-col>
		</lse-row>
		<lse-row class="lse-half">
			<lse-col class="lse-quarter lse-import-layer-sliders lse-scrollbar lse-scrollbar-dark">
				<?= __('Loading ...', 'LayerSlider') ?>
			</lse-col>
			<lse-col class="lse-quarter lse-import-layer-slides lse-scrollbar lse-scrollbar-dark">
				<?= __('Select a project first.', 'LayerSlider') ?>
			</lse-col>
			<lse-col class="lse-half lse-import-layer-layers lse-scrollbar lse-scrollbar-dark">
				<?= __('Select a slide first.', 'LayerSlider') ?>
			</lse-col>
		</lse-row>
	</lse-grid>

</script>