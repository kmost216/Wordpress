<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-add-new-slider">
	<form method="post" id="add-new-slider-modal" class="ls--form-control">
		<?php wp_nonce_field('add-slider'); ?>
		<input type="hidden" name="ls-add-new-slider" value="1">

		<kmw-h1 class="kmw-modal-title"><?= __('Add New Project', 'LayerSlider') ?></kmw-h1>

		<input type="text" name="title" placeholder="<?= __('Name Your Project    (e.g., Homepage Slider)', 'LayerSlider') ?>">

		<div class="ls-type-selection">

			<div class="ls-type ls-blank ls-selected">
				<?= lsGetSVGIcon('pencil-ruler') ?>
				<h5><?= __('Blank Project', 'LayerSlider') ?></h5>
			</div>

			<div class="ls-type ls-open-template-store">
				<?= lsGetSVGIcon('map'); ?>
				<h5><?= __('Browse Templates', 'LayerSlider') ?></h5>
			</div>

		</div>

		<ls-p>
			<button type="submit" class="ls--button ls--bg-lightgray ls--white"><?= __('Create Blank Project', 'LayerSlider') ?></button>
		</ls-p>
	</form>
</script>