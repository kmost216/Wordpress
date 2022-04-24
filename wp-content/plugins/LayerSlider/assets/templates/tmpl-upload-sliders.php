<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-upload-sliders">
	<div id="ls-upload-modal-window">
		<kmw-h1 class="kmw-modal-title"><?= __('Import Projects', 'LayerSlider') ?></kmw-h1>
		<form method="post" enctype="multipart/form-data">
			<p><?= __('Here you can upload your previously exported projects. To import them to your site, you just need to choose and select the appropriate export file (files with .zip or .json extensions), then press the Import Projects button.', 'LayerSlider') ?></p>
			<div class="ls-notification updated"><div><?= sprintf(__('Looking for the importable demo content? %sBrowse Templates%s.', 'LayerSlider'), '<a href="#" class="ls-open-template-store" data-delay="750">'.lsGetSVGIcon('map'), '</a>') ?></div></div>
			<?php wp_nonce_field('import-sliders'); ?>
			<input type="hidden" name="ls-import" value="1">
			<ls-div class="centered center ls-form-file">
				<span class="file-text"><?= __('No import file chosen. Click to choose or drag file here.', 'LayerSlider') ?></span>
				<input type="file" name="import_file">
			</ls-div>

			<ls-p class="ls-center ls--form-control">
				<button type="submit" class="ls--button ls--bg-lightgray ls--white"><?= __('Import Projects', 'LayerSlider') ?></button>
			</ls-p>
		</form>
	</div>
</script>