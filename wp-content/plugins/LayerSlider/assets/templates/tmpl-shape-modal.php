<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<lse-b class="lse-dn">

	<lse-b id="tmpl-shape-modal-sidebar">

		<lse-grid class="lse-form-elements lse-floating-window-theme">

			<lse-row>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-fe-wrapper class="lse-select">
							<select id="lse-shape-modal-type">
								<option value="polygon">Polygon</option>
								<option value="oval">Oval</option>
								<option value="rectangle">Rectangle</option>
								<option value="line">Line</option>
							</select>
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
			</lse-row>

			<lse-row class="lse-shape-modal-polygon">
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Side Count', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-range-inputs lse-3-1">
						<input class="lse-small" type="range" min="3" max="20" value="6">
						<input name="sideCount" type="number" min="3" max="20" value="6">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Side Length', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-range-inputs lse-3-1">
						<input class="lse-small" type="range" min="10" max="300" value="200">
						<input name="sideLength" type="number" min="10" max="300" value="200">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Radius', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-range-inputs lse-3-1">
						<input class="lse-small" type="range" min="1" max="200" value="5">
						<input name="radius" type="number" min="1" max="200" value="5">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Stroke size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-range-inputs lse-3-1">
						<input class="lse-small" type="range" min="0" max="100" value="0">
						<input name="strokeWidth" type="number" min="0" max="100" value="0">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Stroke Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Stroke Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="strokeColor" type="text" class="lse-color-picker-input" value="#000">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Fill Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Fill Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="fillColor" type="text" class="lse-color-picker-input" value="#0099ff">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
			</lse-row>

			<lse-row class="lse-shape-modal-oval">
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Horizontal size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="10" max="300" value="150">
						<input name="width" type="number" min="10" max="300" value="150">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Vertical size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="10" max="300" value="150">
						<input name="height" type="number" min="10" max="300" value="150">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Stroke size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="0" max="100" value="0">
						<input name="strokeWidth" type="number" min="0" max="100" value="0">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Stroke Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Fill Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="strokeColor" type="text" class="lse-color-picker-input" value="#000">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Fill Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Fill Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="fillColor" type="text" class="lse-color-picker-input" value="#0099ff">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
			</lse-row>

			<lse-row class="lse-shape-modal-rectangle">

				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Horizontal size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="10" max="300" value="200">
						<input name="width" type="number" min="10" max="300" value="200">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Vertical size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="10" max="300" value="150">
						<input name="height" type="number" min="10" max="300" value="150">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Radius', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="1" max="200" value="5">
						<input name="radius" type="number" min="1" max="200" value="5">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Stroke size', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="0" max="100" value="0">
						<input name="strokeWidth" type="number" min="0" max="100" value="0">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Stroke Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Fill Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="strokeColor" type="text" class="lse-color-picker-input" value="#000">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Fill Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Fill Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="fillColor" type="text" class="lse-color-picker-input" value="#0099ff">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
			</lse-row>

			<lse-row class="lse-shape-modal-line">
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Length', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="1" max="1000" value="150">
						<input name="length" type="number" min="1" max="1000" value="150">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-wide">
					<lse-ib>
						<lse-text>
							<?= __('Thickness', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-3-1 lse-range-inputs">
						<input class="lse-small" type="range" min="1" max="1000" value="10">
						<input name="lineWidth" type="number" min="1" max="1000" value="10">
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Rounded Endings', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib class="lse-jcc">
						<label class="ls-switch"><input name="roundedEndings" type="checkbox" checked><ls-switch></ls-switch></label>
					</lse-ib>
				</lse-col>
				<lse-col class="lse-3-1">
					<lse-ib>
						<lse-text>
							<?= __('Fill Color', 'LayerSlider') ?>
						</lse-text>
					</lse-ib>
					<lse-ib>
						<lse-fe-wrapper class="lse-smart-help lse-color-input" data-smart-help="color" data-smart-help-title="<?= __('Color', 'LayerSlider') ?>" data-smart-load="lse-color-picker">
							<input name="strokeColor" type="text" class="lse-color-picker-input" value="#000">
						</lse-fe-wrapper>
					</lse-ib>
				</lse-col>
			</lse-row>

		</lse-grid>

		<lse-b id="lse-shape-sidebar-bottom">
			<lse-button class="<?= LS_Config::isActivatedSite() ? '' : 'lse-premium-lock' ?>">
				<?php if( ! LS_Config::isActivatedSite() ) : ?>
				<?= lsGetSVGIcon('lock', false, ['class' => 'lse-it-fix'] ) ?>
				<?php endif ?>
				<lse-text><?= __('Insert Shape', 'LayerSlider') ?></lse-text>
			</lse-button>
			<lse-p class="lse-shape-modal-advice"><?= __('You can resize, rotate, and do other things with your shape once it’s inserted into the editor', 'LayerSlider') ?></lse-p>
		</lse-b>

	</lse-b>

	<lse-b id="tmpl-shape-modal">

		<lse-b class="lse-shape-modal-content"></lse-b>

	</lse-b>

</lse-b>
