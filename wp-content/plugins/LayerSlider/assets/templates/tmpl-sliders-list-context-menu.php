<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-ls-sliders-list-context-menu">
	<div class="ls-context-menu ls-sliders-list-context-menu">
		<div class="ls-context-menu-backdrop"></div>
		<ul>
			<li data-action="embed" class="ls-visible-item">
				<?= lsGetSVGIcon('plus') ?>
				<span><?= __('Embed', 'LayerSlider') ?></span>
			</li>
			<li data-action="export" class="ls-visible-item">
				<?= lsGetSVGIcon('file-export') ?>
				<span><?= __('Export', 'LayerSlider') ?></span>
			</li>
			<li data-action="export-html" class="ls-visible-item">
				<?= lsGetSVGIcon('code') ?>
				<span><?= __('Export as HTML', 'LayerSlider') ?></span>
			</li>

			<li data-action="duplicate" class="ls-visible-item">
				<?= lsGetSVGIcon('clone') ?>
				<span><?= __('Duplicate', 'LayerSlider') ?></span>
			</li>
			<li data-action="revisions" class="ls-visible-item">
				<?= lsGetSVGIcon('history') ?>
				<span><?= __('Revisions', 'LayerSlider') ?></span>
			</li>
			<li class="divider ls-visible-item"></li>
			<li data-action="hide" class="ls-visible-item">
				<?= lsGetSVGIcon('eye-slash') ?>
				<span><?= __('Hide', 'LayerSlider') ?></span>
			</li>
			<li data-action="unhide" class="ls-hidden-item">
				<?= lsGetSVGIcon('eye') ?>
				<span><?= __('Unhide', 'LayerSlider') ?></span>
			</li>
			<li data-action="delete">
				<?= lsGetSVGIcon('trash-alt') ?>
				<span><?= __('Delete', 'LayerSlider') ?></span>
			</li>
		</ul>
	</div>
</script>
