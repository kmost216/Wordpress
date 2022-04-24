<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="lse-static-layer-item-template">
	<lse-li>
		<lse-b class="lse-layer-thumb-wrapper">
			<lse-b class="lse-layer-thumb">

			</lse-b>
		</lse-b>
		<lse-b class="lse-layer-text">
			<lse-text class="lse-layer-title"></lse-text>

		</lse-b>
		<lse-b class="lse-layer-controls lse-it-fix">
			<lse-ib href="#" class="lse-jump-to-layer" data-help="<?= __('Click this icon to jump to the slide where this layer was added on, so you can quickly edit its settings.', 'LayerSlider') ?>">
				<?= lsGetSVGIcon('arrow-alt-circle-right') ?>
			</lse-ib>
		</lse-b>
	</lse-li>
</script>
