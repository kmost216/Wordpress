<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<script type="text/html" id="tmpl-transition-modal-siderbar">

	<lse-b id="transition-modal-siderbar">
		<lse-b class="kmw-sidebar-title">
			<?= __('Slide Transitions', 'LayerSlider') ?>
		</lse-b>
		<kmw-navigation class="km-tabs-list" data-target="#lse-transitions-list">

			<kmw-menutitle>
				<kmw-menutext><?= __('Built-in', 'LayerSlider') ?></kmw-menutext>
			</kmw-menutitle>

			<kmw-menuitem class="kmw-active">
				<?= lsGetSVGIcon('th-large', false, false, 'kmw-icon') ?>
				<kmw-menutext><?= __('2D Transitions', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>
			<kmw-menuitem>
				<?= lsGetSVGIcon('cube', 'regular', false, 'kmw-icon') ?>
				<kmw-menutext><?= __('3D Transitions', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>
			<kmw-menuitem class="lse-transitions-special-effects">
				<?= lsGetSVGIcon('magic', false, false, 'kmw-icon') ?>
				<kmw-menutext><?= __('Special Effects', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>

			<kmw-menutitle>
				<kmw-menutext><?= __('User Transitions', 'LayerSlider') ?></kmw-menutext>
			</kmw-menutitle>

			<kmw-menuitem>
				<?= lsGetSVGIcon('th-large', false, false, 'kmw-icon') ?>
				<kmw-menutext><?= __('Custom 2D', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>
			<kmw-menuitem>
				<?= lsGetSVGIcon('cube', 'regular', false, 'kmw-icon') ?>
				<kmw-menutext><?= __('Custom 3D', 'LayerSlider') ?></kmw-menutext>
			</kmw-menuitem>
		</kmw-navigation>
	</lse-b>
</script>

<script type="text/html" id="tmpl-transition-modal-content">
	<div id="lse-transition-window">

		<lse-b class="kmw-modal-toolbar" style="margin-top: 10px;">
			<lse-button id="lse-transitions-modal-apply-button"><?= __('Apply to other slides', 'LayerSlider') ?></lse-button>
			<lse-button id="lse-transitions-modal-select-button"><?= __('Select all', 'LayerSlider') ?></lse-button>
		</lse-b>

		<kmw-h1 class="kmw-modal-title">
			<?= __('2D Transitions', 'LayerSlider') ?>
		</kmw-h1>


		<lse-b id="lse-transitions-list" class="km-tabs-content">

			<!-- 2D -->
			<lse-grid class="lse-transitions-section kmw-active" data-tr-type="2d_transitions" >
				<lse-row></lse-row>
			</lse-grid>

			<!-- 3D -->
			<lse-grid class="lse-transitions-section" data-tr-type="3d_transitions">
				<lse-row></lse-row>
			</lse-grid>

			<!-- Special Effects -->
			<lse-b class="lse-transitions-section" data-tr-type="special_effects">

				<?php if( ! LS_Config::isActivatedSite() ) : ?>
				<lse-b class="lse-notification lse-bg-highlight">
					<?= lsGetSVGIcon('info-circle') ?>
					<lse-text><?= sprintf(__('Special Effects are premium features. You can preview them with the buttons below, but you need to register your LayerSlider license in order to use them on front end pages. %sPurchase a license%s or %sread the documentation%s to learn more. %sGot LayerSlider in a theme?%s', 'LayerSlider'), '<a href="'.LS_Config::get('purchase_url').'" target="_blank">', '</a>', '<a href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>', '<a href="https://layerslider.com/documentation/#activation-bundles" target="_blank">', '</a>') ?></lse-text>
				</lse-b>
				<?php endif ?>

				<lse-p>
					<?= __('Special effects are like regular slide transitions and they work in the same way. You can set them on each slide individually. Mixing them with other transitions on other slides is perfectly fine. You can also apply them on all of your slides at once by pressing the “Apply to other slides” button above.', 'LayerSlider') ?>
				</lse-p>

				<lse-grid id="lse-special-transitions">
					<lse-row id="lse-transition-origami">
						<lse-col>
							<lse-h2><?= __('Origami transition', 'LayerSlider') ?></lse-h2>
							<lse-p>
								<?= __('Share your gorgeous photos with the world or your loved ones in a truly inspirational way and create sliders with stunning effects with Origami.', 'LayerSlider') ?>
							</lse-p>
							<lse-p class="lse-font-s">
									<?= __('Origami is a form of 3D transition and it works in the same way as regular slide transitions do. Besides Internet Explorer, Origami works in all the modern browsers (including Edge).', 'LayerSlider') ?>
							</lse-p>
							<lse-p class="lse-tac">
								<lse-button-group>
									<a class="lse-button" href="https://layerslider.com/sliders/origami/" target="_blank">
										<lse-text>
											<?= __('Live example', 'LayerSlider') ?>
										</lse-text>
									</a>

									<?php if( LS_Config::isActivatedSite() ) : ?>
									<lse-button class="lse-select-special-transition" data-name="transitionorigami">
										<lse-text>
											<?= __('Use it on this slide', 'LayerSlider') ?>
										</lse-text>
										<?= lsGetSVGIcon('check',false,['class' => 'lse-it-fix']) ?>
									</lse-button>
									<?php endif ?>
								</lse-button-group>
							</lse-p>
						</lse-col>
						<lse-col class="lse-transition-thumbnail"></lse-col>
					</lse-row>
				</lse-grid>

			</lse-b>


			<!-- Custom 2D -->
			<lse-grid class="lse-transitions-section" data-tr-type="custom_2d_transitions">
				<lse-row>
					<lse-p><?= __('You haven’t created any custom 2D transitions yet.', 'LayerSlider') ?></lse-p>
				</lse-row>
			</lse-grid>

			<!-- Custom 3D -->
			<lse-grid class="lse-transitions-section" data-tr-type="custom_3d_transitions">
				<lse-row>
					<lse-p><?= __('You haven’t created any custom 3D transitions yet.', 'LayerSlider') ?></lse-p>
				</lse-row>
			</lse-grid>

		</lse-b>
	</div>
</script>