<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<lse-b class="lse-dn">

	<div id="lse-object-modal-sidebar">
		<div class="kmw-sidebar-title">
			<?= __('Object Library', 'LayerSlider') ?>
		</div>
		<kmw-navigation class="km-tabs-list" data-target="#lse-object-modal-tabs">

			<kmw-menuitem class="kmw-active lse-welcome-svg-menu-item">
				<?= lsGetSVGIcon('stars', 'solid', false, 'kmw-icon') ?>
				<kmw-menutext><?= __('Welcome', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menuitem class="lse-insert-svg-menu-item">
				<?= lsGetSVGIcon('file-upload', 'solid', false, 'kmw-icon') ?>
				<kmw-menutext><?= __('Insert SVG', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

		</kmw-navigation>
	</div>

	<lse-b id="lse-object-modal-window">

		<lse-b id="lse-object-modal-tabs" class="km-tabs-content">

			<!-- Welcome Screen -->
			<lse-b class="kmw-active">

				<img src="<?= LS_ROOT_URL ?>/static/admin/img/creature-coming-soon.png" alt="<?= __('Coming Soon', 'LayerSlider') ?>">
				<lse-p class="lse-mt-s"><?= __('Stay tuned for an extensive collection of ready-to-go media assets that you can instantly use in your projects. The Object Library will soon offer commonly used images, video and audio, and scalable vector graphics.', 'LayerSlider') ?></lse-p>

				<lse-p class="lse-mt-s"><?= __('In the meantime, you can insert your own SVG objects just by dropping them on the project canvas or under the "Insert SVG" tab in this window.', 'LayerSlider') ?></lse-p>
			</lse-b>


			<!-- Insert SVG -->
			<lse-b>

				<lse-b class="lse-notification lse-bg-yellow">
					<?= lsGetSVGIcon('info-circle') ?>
					<lse-text><?= __('You can easily insert SVG files just by dropping them on the project canvas.', 'LayerSlider') ?></lse-text>
				</lse-b>

				<lse-p>
					<?= __('Alternatively, you can enter and edit the inline source code of SVGs as well.', 'LayerSlider') ?>
				</lse-p>

				<lse-b class="lse-white-theme">
					<textarea id="lse-object-insert-textarea" required placeholder="&lt;svg ..."></textarea>
				</lse-b>

				<lse-p class="lse-tac lse-common-modal-style">
					<lse-button id="lse-object-insert-button"><?= __('Insert SVG', 'LayerSlider') ?></ls-button>
				</lse-p>
			</lse-b>

		</lse-b>

	</lse-b>

</lse-b>