<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="lse-add-layer-template">
	<div id="lse-add-layer-modal-window">
		<kmw-h1 class="kmw-modal-title"><?= __('Add New Layer', 'LayerSlider') ?></kmw-h1>

		<lse-grid>
			<lse-row>
				<lse-b data-type="img">
					<?= lsGetSVGIcon('image-polaroid', 'regular') ?>
					<lse-text><?= __('Image', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="text">
					<?= lsGetSVGIcon('align-left') ?>
					<lse-text><?= __('Text', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="media">
					<?= lsGetSVGIcon('play-circle') ?>
					<lse-text><?= __('Video / Audio', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="button">
					<?= lsGetSVGIcon('dot-circle') ?>
					<lse-text><?= __('Button', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="shape-modal">
					<?= lsGetSVGIcon('shapes') ?>
					<lse-text><?= __('Shape', 'LayerSlider') ?></lse-text>
				</lse-b>
			</lse-row>
			<lse-row>
				<lse-b data-type="icon-modal">
					<?= lsGetSVGIcon('icons') ?>
					<lse-text><?= __('Icon', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="svg-modal">
					<?= lsGetSVGIcon('stars') ?>
					<lse-text><?= __('Object', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="html">
					<?= lsGetSVGIcon('code') ?>
					<lse-text><?= __('HTML', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="post">
					<?= lsGetSVGIcon('database') ?>
					<lse-text><?= __('Dynamic Layer', 'LayerSlider') ?></lse-text>
				</lse-b>
				<lse-b data-type="import">
					<?= lsGetSVGIcon('file-import') ?>
					<lse-text><?= __('Import Layer', 'LayerSlider') ?></lse-text>
				</lse-b>
			</lse-row>
		</lse-grid>
	</div>
</script>