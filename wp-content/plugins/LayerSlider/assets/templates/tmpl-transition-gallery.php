<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-ls-transition-modal">
	<div id="ls-transition-window">
		<kmw-h1 class="kmw-modal-title"><?= __('Choose a slide transition to import', 'LayerSlider') ?></kmw-h1>

		<div id="transitiongallery-header">
			<div id="transitionmenu" class="buildermenu">
				<span><?= __('Show Transitions:', 'LayerSlider') ?></span>
				<ul class="filters">
					<li class="active"><?= __('2D', 'LayerSlider') ?></li>
					<li><?= __('3D', 'LayerSlider') ?></li>
				</ul>
			</div>
		</div>


		<div id="ls-transitions-list">

			<!-- 2D -->
			<section class="lse-transitions-section active" data-tr-type="2d_transitions"></section>

			<!-- 3D -->
			<section class="lse-transitions-section" data-tr-type="3d_transitions"></section>
		</div>

	</div>
</script>