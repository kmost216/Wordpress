<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="ls-3d-transition-template">
	<div class="ls-transition-item">
		<table class="ls-box ls-tr-settings">
			<thead>
				<tr>
					<td colspan="2"><?= __('Preview', 'LayerSlider') ?></td>
					<td colspan="2"><?= __('Tiles', 'LayerSlider') ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">
						<div class="ls-builder-preview ls-transition-preview">
							<img src="<?= LS_ROOT_URL ?>/static/admin/img/sample_slide_1.jpg" alt="preview image">
						</div>
					</td>
					<td colspan="2">
						<table class="tiles">
							<tbody>
								<tr>
									<td class="right"><?= __('Rows', 'LayerSlider') ?></td>
									<td><input type="text" name="rows" value="1" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
									<td class="right"><?= __('Cols', 'LayerSlider') ?></td>
									<td><input type="text" name="cols" value="1" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
								</tr>
							</tbody>
							<tbody class="tile">
								<tr>
									<td class="right"><?= __('Delay', 'LayerSlider') ?></td>
									<td><input type="text" name="delay" value="75" data-help="<?= __('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
									<td class="right"><?= __('Sequence', 'LayerSlider') ?></td>
									<td>
										<select name="sequence" data-help="<?= __('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
											<option value="forward"><?= __('Forward', 'LayerSlider') ?></option>
											<option value="reverse"><?= __('Reverse', 'LayerSlider') ?></option>
											<option value="col-forward"><?= __('Col-forward', 'LayerSlider') ?></option>
											<option value="col-reverse"><?= __('Col-reverse', 'LayerSlider') ?></option>
											<option value="random"><?= __('Random', 'LayerSlider') ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="right"><?= __('Depth', 'LayerSlider') ?></td>
									<td colspan="3">
										<label data-help="<?= __('The script tries to identify the optimal depth for your rotated objects (tiles). With this option you can force your objects to have a large depth when performing 180 degree (and its multiplies) rotation.', 'LayerSlider') ?>">
											<input type="checkbox" class="checkbox" name="depth" value="large">
											<?= __('Large depth', 'LayerSlider') ?>
										</label>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<td colspan="4">
						<?= __('Before animation', 'LayerSlider') ?>
						<p class="ls-builder-checkbox">
							<label><input type="checkbox" class="ls-builder-collapse-toggle"> <?= __('Enabled', 'LayerSlider') ?></label>
						</p>
					</td>
				</tr>
			</thead>
			<tbody class="before ls-builder-collapsed">
				<tr>
					<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
					<td><input type="text" name="duration" value="1000" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags"></ul>
						<p class="ls-tr-add-property">
							<a href="#" class="ls-icon-tr-add">
								<?= lsGetSVGIcon('plus') ?>
								<ls-span><?= __('Add new', 'LayerSlider') ?></ls-span>
							</a>
							<select>
								<option value="scale3d,0.8"><?= __('Scale3D', 'LayerSlider') ?></option>
								<option value="rotateX,90"><?= __('RotateX', 'LayerSlider') ?></option>
								<option value="rotateY,90"><?= __('RotateY', 'LayerSlider') ?></option>
								<option value="delay,200"><?= __('Delay', 'LayerSlider') ?></option>
							</select>
						</p>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<td colspan="4">
						<?= __('Animation', 'LayerSlider') ?>
					</td>
				</tr>
			</thead>
			<tbody class="animation">
				<tr>
					<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
					<td><input type="text" name="duration" value="1000" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td class="right"><?= __('Direction', 'LayerSlider') ?></td>
					<td>
						<select name="direction" data-help="<?= __('The direction of rotation.', 'LayerSlider') ?>">
							<option value="vertical"><?= __('Vertical', 'LayerSlider'); ?></option>
							<option value="horizontal" selected="selected"><?= __('Horizontal', 'LayerSlider') ?></option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags">
							<li>
								<p>
									<span><?= __('RotateX', 'LayerSlider') ?></span>
									<input type="text" name="rotateY" value="90">
								</p>
								<?= lsGetSVGIcon('times-circle') ?>
							</li>
						</ul>
						<p class="ls-tr-add-property">
							<a href="#" class="ls-icon-tr-add">
								<?= lsGetSVGIcon('plus') ?>
								<ls-span><?= __('Add new', 'LayerSlider') ?></ls-span>
							</a>
							<select>
								<option value="scale3d,0.8"><?= __('Scale3D', 'LayerSlider') ?></option>
								<option value="rotateX,90"><?= __('RotateX', 'LayerSlider') ?></option>
								<option value="rotateY,90"><?= __('RotateY', 'LayerSlider') ?></option>
								<option value="delay,200"><?= __('Delay', 'LayerSlider') ?></option>
							</select>
						</p>
					</td>
				</tr>
			</tbody>
			<thead>
				<tr>
					<td colspan="4">
						<?= __('After animation', 'LayerSlider') ?>
						<p class="ls-builder-checkbox">
							<label><input type="checkbox" class="ls-builder-collapse-toggle"> <?= __('Enabled', 'LayerSlider') ?></label>
						</p>
					</td>
				</tr>
			</thead>
			<tbody class="after ls-builder-collapsed">
				<tr>
					<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
					<td><input type="text" name="duration" value="1000" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
					<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
					<td>
						<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
							<option>linear</option>
							<option>easeInQuad</option>
							<option>easeOutQuad</option>
							<option>easeInOutQuad</option>
							<option>easeInCubic</option>
							<option>easeOutCubic</option>
							<option>easeInOutCubic</option>
							<option>easeInQuart</option>
							<option>easeOutQuart</option>
							<option>easeInOutQuart</option>
							<option>easeInQuint</option>
							<option>easeOutQuint</option>
							<option selected="selected">easeInOutQuint</option>
							<option>easeInSine</option>
							<option>easeOutSine</option>
							<option>easeInOutSine</option>
							<option>easeInExpo</option>
							<option>easeOutExpo</option>
							<option>easeInOutExpo</option>
							<option>easeInCirc</option>
							<option>easeOutCirc</option>
							<option>easeInOutCirc</option>
							<option>easeInBack</option>
							<option>easeOutBack</option>
							<option>easeInOutBack</option>
						</select>
					</td>
				</tr>
				<tr class="transition">
					<td colspan="4">
						<ul class="ls-tr-tags"></ul>
						<p class="ls-tr-add-property">
							<a href="#" class="ls-icon-tr-add">
								<?= lsGetSVGIcon('plus') ?>
								<ls-span><?= __('Add new', 'LayerSlider') ?></ls-span>
							</a>
							<select>
								<option value="scale3d,0.8"><?= __('Scale3D', 'LayerSlider') ?></option>
								<option value="rotateX,90"><?= __('RotateX', 'LayerSlider') ?></option>
								<option value="rotateY,90"><?= __('RotateY', 'LayerSlider') ?></option>
								<option value="delay,200"><?= __('Delay', 'LayerSlider') ?></option>
							</select>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</script>