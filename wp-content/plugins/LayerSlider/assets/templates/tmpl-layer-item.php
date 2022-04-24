<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="lse-layer-item-template">
	<lse-li>
		<lse-b class="lse-layer-thumb-wrapper">
			<lse-b class="lse-layer-thumb lse-it-fix">

			</lse-b>
		</lse-b>
		<lse-b class="lse-layer-text">
			<input type="text" name="subtitle" class="lse-layer-title" value="<?= sprintf(__('Layer #%d', 'LayerSlider'), '1') ?>">

		</lse-b>
		<lse-b class="lse-layer-controls lse-it-fix">
			<?= lsGetSVGIcon('eye-slash', false, [
				'class' => 'lse-hide-layer',
				'data-tt' => '.tt-layer-visibility'
			]) ?>

			<?= lsGetSVGIcon('lock', false, [
				'class' => 'lse-lock-layer',
				'data-tt' => '.tt-layer-lock'
			]) ?>

			<?= lsGetSVGIcon('clone', false, [
				'class' => 'lse-duplicate-layer',
				'data-tt' => '.tt-layer-duplicate'
			]) ?>

			<?= lsGetSVGIcon('trash-alt', false, [
				'class' => 'lse-remove-layer',
				'data-tt' => '.tt-layer-remove'
			]) ?>
		</lse-b>
	</lse-li>
</script>
