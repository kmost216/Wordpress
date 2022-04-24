<?php

	// Prevent direct file access
	defined( 'LS_ROOT_FILE' ) || exit;

	// Custom transitions file
	$upload_dir = wp_upload_dir();
	$custom_trs = $upload_dir['basedir'] . '/layerslider.custom.transitions.js';
	$sample_trs = LS_ROOT_PATH.'/demos/transitions.js';

	// Get transition file
	if(file_exists($custom_trs)) { $data = file_get_contents($custom_trs); }
		elseif(file_exists($sample_trs)) { $data = file_get_contents($sample_trs); }

	// Get JSON data
	if(!empty($data)) {
		$data = substr($data, 35);
		$data = substr($data, 0, -1);
		$data = json_decode($data, true);
	}

	// Function to convert array keys to property names
	function lsTrGetProperty($key) {
		switch ($key) {
			case 'scale3d': return 'Scale3D'; break;
			case 'rotateX': return 'RotateX'; break;
			case 'rotateY': return 'RotateY'; break;
			case 'x': return 'MoveX'; break;
			case 'y': return 'MoveY'; break;
			case 'delay': return 'Delay'; break;
			default: return $key; break;
		}
	}

	include LS_ROOT_PATH . '/includes/ls_global.php';


// Import sample markup of transitions
include LS_ROOT_PATH . '/templates/tmpl-2d-transition.php';
include LS_ROOT_PATH . '/templates/tmpl-3d-transition.php';

// Import Transition Gallery markup
include LS_ROOT_PATH . '/templates/tmpl-transition-gallery.php';

wp_localize_script('layerslider-tr-builder', 'LS_InterfaceIcons', [
	'times' 	=> lsGetSVGIcon('times-circle')
]);


 ?>
<div class="wrap">

	<form method="post" id="ls-tr-builder-form">

		<ls-section>

			<?php wp_nonce_field('save-user-transitions'); ?>
			<input type="hidden" name="ls-user-transitions" value="1">
			<input type="hidden" name="ls-transitions">


			<ls-grid class="ls--header ls--form-control">
				<ls-row class="ls--flex-stretch ls--flex-center ls--no-min-width">
					<ls-col class="ls--col1-2">
						<ls-h2 class="ls--clear-after">
							<?= __('LayerSlider Slide Transition Builder', 'LayerSlider') ?>
						</ls-h2>
					</ls-col>
					<ls-col class="ls--col1-2 ls--text-right">
						<a href="<?= admin_url('admin.php?page=layerslider') ?>" class="ls--button ls--bg-lightgray"><?= lsGetSVGIcon('arrow-left') ?><ls-button-text><?= __('Back', 'LayerSlider') ?></ls-button-text></a>
					</ls-col>
				</ls-row>
			</ls-grid>

			<ls-box>


		<div class="ls-slider-settings ls-transition-settings">
			<div class="ls-box ls-settings">
				<div class="inner">
					<div class="ls-settings-sidebar ls-transitions-sidebar">
						<h3 class="subheader">
							<?= __('2D Transitions', 'LayerSlider') ?>
							<a href="#" class="ls-import-transition">
								<?= lsGetSVGIcon('file-import') ?>
								<ls-span><?= __('Import', 'LayerSlider') ?></ls-span>
							</a>
							<a href="#" class="ls-add-transition">
								<?= lsGetSVGIcon('plus') ?>
								<ls-span><?= __('Add New', 'LayerSlider') ?></ls-span>
							</a>
						</h3>
						<ul class="2d" data-type="2d">
							<?php $hidenClass = '' ?>
							<?php if(!empty($data['t2d']) && is_array($data['t2d'])) : ?>
							<?php $hidenClass = 'ls-hidden' ?>
							<?php foreach($data['t2d'] as $tr) : ?>
							<li>
								<?= lsGetSVGIcon('bars') ?>
								<input type="text" value="<?= htmlspecialchars(html_entity_decode($tr['name'])) ?>" placeholder="<?= __('Type transition name', 'LayerSlider') ?>">
								<a href="#" title="<?= __('Remove transition', 'LayerSlider') ?>" class="remove">
									<?= lsGetSVGIcon('trash') ?>
								</a>
							</li>
							<?php endforeach ?>
							<?php endif ?>
						</ul>
						<p class="ls-no-transition <?= $hidenClass ?>"><?= __('No 2D transitions yet.', 'LayerSlider') ?></p>
						<h3 class="subheader">
							<?= __('3D Transitions', 'LayerSlider') ?>
							<a href="#" class="ls-import-transition">
								<?= lsGetSVGIcon('file-import') ?>
								<ls-span><?= __('Import', 'LayerSlider') ?></ls-span>
							</a>
							<a href="#" class="ls-add-transition">
								<?= lsGetSVGIcon('plus') ?>
								<ls-span><?= __('Add New', 'LayerSlider') ?></ls-span>
							</a>
						</h3>
						<ul class="3d" data-type="3d">
							<?php $hidenClass = '' ?>
							<?php if(!empty($data['t3d']) && is_array($data['t3d'])) : ?>
							<?php $hidenClass = 'ls-hidden' ?>
							<?php foreach($data['t3d'] as $tr) : ?>
							<li>
								<?= lsGetSVGIcon('bars') ?>
								<input type="text" value="<?= htmlspecialchars(html_entity_decode($tr['name'])) ?>" placeholder="<?= __('Type transition name', 'LayerSlider') ?>">
								<a href="#" title="<?= __('Remove transition', 'LayerSlider') ?>" class="remove">
									<?= lsGetSVGIcon('trash') ?>
								</a>
							</li>
							<?php endforeach ?>
							<?php endif ?>
						</ul>
						<p class="ls-no-transition <?= $hidenClass ?>"><?= __('No 3D transitions yet.', 'LayerSlider') ?></p>
					</div>
					<div class="ls-settings-contents ls-transition-contents">
						<div class="ls-box ls-tr-builder">

							<div class="ls-tr-options ls-clearfix">
								<div class="ls-builder-left ls-tr-list-3d">
									<?php if(!empty($data['t3d']) && is_array($data['t3d'])) : ?>
									<?php foreach($data['t3d'] as $key => $tr) : ?>
									<?php $activeClass = ($key == 0) ? ' active' : '' ?>
									<div class="ls-transition-item<?= $activeClass ?>">
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
																	<?php $tr['rows'] = is_array($tr['rows']) ? implode(',', $tr['rows']) : $tr['rows']; ?>
																	<?php $tr['cols'] = is_array($tr['cols']) ? implode(',', $tr['cols']) : $tr['cols']; ?>
																	<td class="right"><?= __('Rows', 'LayerSlider') ?></td>
																	<td><input type="text" name="rows" value="<?= $tr['rows'] ?>" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																	<td class="right"><?= __('Cols', 'LayerSlider') ?></td>
																	<td><input type="text" name="cols" value="<?= $tr['cols'] ?>" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																</tr>
															</tbody>
															<tbody class="tile">
																<tr>
																	<td class="right"><?= __('Delay', 'LayerSlider') ?></td>
																	<td><input type="text" name="delay" value="<?= $tr['tile']['delay'] ?>" data-help="<?= __('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
																	<td class="right"><?= __('Sequence', 'LayerSlider') ?></td>
																	<td>
																		<select name="sequence" data-help="<?= __('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
																			<option value="forward"<?= ($tr['tile']['sequence'] == 'forward') ? ' selected="selected"' : '' ?>><?= __('Forward', 'LayerSlider') ?></option>
																			<option value="reverse"<?= ($tr['tile']['sequence'] == 'reverse') ? ' selected="selected"' : '' ?>><?= __('Reverse', 'LayerSlider') ?></option>
																			<option value="col-forward"<?= ($tr['tile']['sequence'] == 'col-forward') ? ' selected="selected"' : '' ?>><?= __('Col-forward', 'LayerSlider') ?></option>
																			<option value="col-reverse"<?= ($tr['tile']['sequence'] == 'col-reverse') ? ' selected="selected"' : '' ?>><?= __('Col-reverse', 'LayerSlider') ?></option>
																			<option value="random"<?= ($tr['tile']['sequence'] == 'random') ? ' selected="selected"' : '' ?>><?= __('Random', 'LayerSlider') ?></option>
																		</select>
																	</td>
																</tr>
																<tr>
																	<td class="right"><?= __('Depth', 'LayerSlider') ?></td>
																	<td colspan="3">
																		<label data-help="<?= __('The script tries to identify the optimal depth for your rotated objects (tiles). With this option you can force your objects to have a large depth when performing 180 degree (and its multiplies) rotation.', 'LayerSlider') ?>">
																			<input type="checkbox" class="checkbox" name="depth" value="large"<?= isset($tr['tile']['depth']) ? ' checked="checked"' : '' ?>>
																			<?= __('Large depth', 'LayerSlider') ?>
																		</label>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
											<?php
												$checkboxProp = isset($tr['before']) ? ' checked="checked"' : '';
												$collapseClass = !isset($tr['before']) ? ' ls-builder-collapsed' : '';
											?>
											<thead>
												<tr>
													<td colspan="4">
														<?= __('Before animation', 'LayerSlider') ?>
														<p class="ls-builder-checkbox">
															<label><input type="checkbox"<?= $checkboxProp ?> class="ls-builder-collapse-toggle"> <?= __('Enabled', 'LayerSlider') ?></label>
														</p>
													</td>
												</tr>
											</thead>
											<tbody class="before<?= $collapseClass ?>">
												<tr>
													<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?= isset($tr['before']['duration']) ? $tr['before']['duration'] : '1000' ?>" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
													<td>
														<?php $tr['before']['easing'] = isset($tr['before']['easing']) ? $tr['before']['easing'] : 'easeInOutBack' ?>
														<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?= ($tr['before']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?= ($tr['before']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?= ($tr['before']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?= ($tr['before']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?= ($tr['before']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?= ($tr['before']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?= ($tr['before']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?= ($tr['before']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?= ($tr['before']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?= ($tr['before']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?= ($tr['before']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?= ($tr['before']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?= ($tr['before']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?= ($tr['before']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?= ($tr['before']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?= ($tr['before']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?= ($tr['before']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?= ($tr['before']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">
														<ul class="ls-tr-tags">
															<?php if(isset($tr['before']['transition']) && !empty($tr['before']['transition'])) : ?>
															<?php foreach($tr['before']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?= lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?= $pkey ?>" value="<?= $prop ?>">
																</p>
																<?= lsGetSVGIcon('times-circle') ?>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
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
														<?= __('Animation', 'LayerSlider') ?>
													</td>
												</tr>
											</thead>
											<tbody class="animation">
												<tr>
													<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?= $tr['animation']['duration'] ?>" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
													<td>
														<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?= ($tr['animation']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?= ($tr['animation']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?= ($tr['animation']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?= ($tr['animation']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?= ($tr['animation']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?= ($tr['animation']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?= ($tr['animation']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?= ($tr['animation']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?= ($tr['animation']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?= ($tr['animation']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?= ($tr['animation']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr>
													<td></td>
													<td></td>
													<td class="right"><?= __('Direction', 'LayerSlider') ?></td>
													<td>
														<select name="direction" data-help="<?= __('The direction of rotation.', 'LayerSlider') ?>">
															<option value="vertical"<?= ($tr['animation']['direction'] == 'vertical') ? ' selected="selected"' : '' ?>><?= __('Vertical', 'LayerSlider'); ?></option>
															<option value="horizontal"<?= ($tr['animation']['direction'] == 'horizontal') ? ' selected="selected"' : '' ?>><?= __('Horizontal', 'LayerSlider') ?></option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">

														<ul class="ls-tr-tags">
															<?php if(isset($tr['animation']['transition']) && !empty($tr['animation']['transition'])) : ?>
															<?php foreach($tr['animation']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?= lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?= $pkey ?>" value="<?= $prop ?>">
																</p>
																<?= lsGetSVGIcon('times-circle') ?>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
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
											<?php
												$checkboxProp = isset($tr['after']) ? ' checked="checked"' : '';
												$collapseClass = !isset($tr['after']) ? ' ls-builder-collapsed' : '';
											?>
											<thead>
												<tr>
													<td colspan="4">
														<?= __('After animation', 'LayerSlider') ?>
														<p class="ls-builder-checkbox">
															<label><input type="checkbox"<?= $checkboxProp ?> class="ls-builder-collapse-toggle"> <?= __('Enabled', 'LayerSlider') ?></label>
														</p>
													</td>
												</tr>
											</thead>
											<tbody class="after<?= $collapseClass ?>">
												<tr>
													<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?= isset($tr['after']['duration']) ? $tr['after']['duration'] : '1000' ?>" data-help="<?= __('The duration of your animation. This value is in millisecs, so the value 1000 means 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
													<td>
														<?php $tr['after']['easing'] = isset($tr['after']['easing']) ? $tr['after']['easing'] : 'easeInOutBack' ?>
														<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?= ($tr['after']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?= ($tr['after']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?= ($tr['after']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?= ($tr['after']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?= ($tr['after']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?= ($tr['after']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?= ($tr['after']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?= ($tr['after']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?= ($tr['after']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?= ($tr['after']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?= ($tr['after']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?= ($tr['after']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?= ($tr['after']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?= ($tr['after']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?= ($tr['after']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?= ($tr['after']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?= ($tr['after']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?= ($tr['after']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
														</select>
													</td>
												</tr>
												<tr class="transition">
													<td colspan="4">
														<ul class="ls-tr-tags">
															<?php if(isset($tr['after']['transition']) && !empty($tr['after']['transition'])) : ?>
															<?php foreach($tr['after']['transition'] as $pkey => $prop) : ?>
															<li>
																<p>
																	<span><?= lsTrGetProperty($pkey) ?></span>
																	<input type="text" name="<?= $pkey ?>" value="<?= $prop ?>">
																</p>
																<?= lsGetSVGIcon('times-circle') ?>
															</li>
															<?php endforeach; ?>
															<?php endif; ?>
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
										</table>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<div class="ls-builder-right ls-tr-list-2d">

									<?php if(!empty($data['t2d']) && is_array($data['t2d'])) : ?>
									<?php foreach($data['t2d'] as $key => $tr) : ?>
									<?php $activeClass = ($key == 0) ? ' active' : '' ?>
									<div class="ls-transition-item<?= $activeClass ?>">
										<table class="ls-box ls-tr-settings bottomborder">
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
																	<?php $tr['rows'] = is_array($tr['rows']) ? implode(',', $tr['rows']) : $tr['rows']; ?>
																	<?php $tr['cols'] = is_array($tr['cols']) ? implode(',', $tr['cols']) : $tr['cols']; ?>
																	<td class="right"><?= __('Rows', 'LayerSlider') ?></td>
																	<td><input type="text" name="rows" value="<?= $tr['rows'] ?>" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many rows of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																	<td class="right"><?= __('Cols', 'LayerSlider') ?></td>
																	<td><input type="text" name="cols" value="<?= $tr['cols'] ?>" data-help="<?= __('<i>number</i> or <i>min,max</i> If you specify a value greater than 1, LayerSlider will cut your slide into tiles. You can specify here how many columns of your transition should have. If you specify two numbers separated with a comma, LayerSlider will use that as a range and pick a random number between your values.', 'LayerSlider') ?>"></td>
																</tr>
															</tbody>
															<tbody class="tile">
																<tr>
																	<td class="right"><?= __('Delay', 'LayerSlider') ?></td>
																	<td><input type="text" name="delay" value="<?= $tr['tile']['delay'] ?>" data-help="<?= __('You can apply a delay between the tiles and postpone their animation relative to each other.', 'LayerSlider') ?>"></td>
																	<td class="right"><?= __('Sequence', 'LayerSlider') ?></td>
																	<td>
																		<select name="sequence" data-help="<?= __('You can control the animation order of the tiles here.', 'LayerSlider') ?>">
																			<option value="forward"<?= ($tr['tile']['sequence'] == 'forward') ? ' selected="selected"' : '' ?>><?= __('Forward', 'LayerSlider') ?></option>
																			<option value="reverse"<?= ($tr['tile']['sequence'] == 'reverse') ? ' selected="selected"' : '' ?>><?= __('Reverse', 'LayerSlider') ?></option>
																			<option value="col-forward"<?= ($tr['tile']['sequence'] == 'col-forward') ? ' selected="selected"' : '' ?>><?= __('Col-forward', 'LayerSlider') ?></option>
																			<option value="col-reverse"<?= ($tr['tile']['sequence'] == 'col-reverse') ? ' selected="selected"' : '' ?>><?= __('Col-reverse', 'LayerSlider') ?></option>
																			<option value="random"<?= ($tr['tile']['sequence'] == 'random') ? ' selected="selected"' : '' ?>><?= __('Random', 'LayerSlider') ?></option>
																		</select>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
											<thead>
												<tr>
													<td colspan="4"><?= __('Transition', 'LayerSlider') ?></td>
												</tr>
											</thead>
											<tbody class="transition">
												<tr>
													<td class="right"><?= __('Duration', 'LayerSlider') ?></td>
													<td><input type="text" name="duration" value="<?= $tr['transition']['duration'] ?>" data-help="<?= __('The duration of the animation. This value is in millisecs, so the value 1000 measn 1 second.', 'LayerSlider') ?>"></td>
													<td class="right"><a href="http://easings.net/" target="_blank"><?= __('Easing', 'LayerSlider') ?></a></td>
													<td>
														<select name="easing" data-help="<?= __('The timing function of the animation. With this function you can manipulate the movement of the animated object. Please click on the link next to this select field to open easings.net for more information and real-time examples.', 'LayerSlider') ?>">
															<option<?= ($tr['transition']['easing'] == 'linear') ? ' selected="selected"' : '' ?>>linear</option>
															<option<?= ($tr['transition']['easing'] == 'swing') ? ' selected="selected"' : '' ?>>swing</option>
															<option<?= ($tr['transition']['easing'] == 'easeInQuad') ? ' selected="selected"' : '' ?>>easeInQuad</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutQuad') ? ' selected="selected"' : '' ?>>easeOutQuad</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutQuad') ? ' selected="selected"' : '' ?>>easeInOutQuad</option>
															<option<?= ($tr['transition']['easing'] == 'easeInCubic') ? ' selected="selected"' : '' ?>>easeInCubic</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutCubic') ? ' selected="selected"' : '' ?>>easeOutCubic</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutCubic') ? ' selected="selected"' : '' ?>>easeInOutCubic</option>
															<option<?= ($tr['transition']['easing'] == 'easeInQuart') ? ' selected="selected"' : '' ?>>easeInQuart</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutQuart') ? ' selected="selected"' : '' ?>>easeOutQuart</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutQuart') ? ' selected="selected"' : '' ?>>easeInOutQuart</option>
															<option<?= ($tr['transition']['easing'] == 'easeInQuint') ? ' selected="selected"' : '' ?>>easeInQuint</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutQuint') ? ' selected="selected"' : '' ?>>easeOutQuint</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutQuint') ? ' selected="selected"' : '' ?>>easeInOutQuint</option>
															<option<?= ($tr['transition']['easing'] == 'easeInSine') ? ' selected="selected"' : '' ?>>easeInSine</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutSine') ? ' selected="selected"' : '' ?>>easeOutSine</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutSine') ? ' selected="selected"' : '' ?>>easeInOutSine</option>
															<option<?= ($tr['transition']['easing'] == 'easeInExpo') ? ' selected="selected"' : '' ?>>easeInExpo</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutExpo') ? ' selected="selected"' : '' ?>>easeOutExpo</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutExpo') ? ' selected="selected"' : '' ?>>easeInOutExpo</option>
															<option<?= ($tr['transition']['easing'] == 'easeInCirc') ? ' selected="selected"' : '' ?>>easeInCirc</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutCirc') ? ' selected="selected"' : '' ?>>easeOutCirc</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutCirc') ? ' selected="selected"' : '' ?>>easeInOutCirc</option>
															<option<?= ($tr['transition']['easing'] == 'easeInElastic') ? ' selected="selected"' : '' ?>>easeInElastic</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutElastic') ? ' selected="selected"' : '' ?>>easeOutElastic</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutElastic') ? ' selected="selected"' : '' ?>>easeInOutElastic</option>
															<option<?= ($tr['transition']['easing'] == 'easeInBack') ? ' selected="selected"' : '' ?>>easeInBack</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutBack') ? ' selected="selected"' : '' ?>>easeOutBack</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutBack') ? ' selected="selected"' : '' ?>>easeInOutBack</option>
															<option<?= ($tr['transition']['easing'] == 'easeInBounce') ? ' selected="selected"' : '' ?>>easeInBounce</option>
															<option<?= ($tr['transition']['easing'] == 'easeOutBounce') ? ' selected="selected"' : '' ?>>easeOutBounce</option>
															<option<?= ($tr['transition']['easing'] == 'easeInOutBounce') ? 'selected="selected"' : '' ?>>easeInOutBounce</option>
														</select>
													</td>
												</tr>
												<tr>
													<td class="right"><?= __('Type', 'LayerSlider') ?></td>
													<td>
														<select name="type" data-help="<?= __('The type of the animation, either slide, fade or both (mixed).', 'LayerSlider') ?>">
															<option value="slide"<?= ($tr['transition']['type'] == 'slide') ? ' selected="selected"' : '' ?>><?php _ex('Slide', 'verb', 'LayerSlider') ?></option>
															<option value="fade"<?= ($tr['transition']['type'] == 'fade') ? ' selected="selected"' : '' ?>><?= __('Fade', 'LayerSlider') ?></option>
															<option value="mixed"<?= ($tr['transition']['type'] == 'mixed') ? ' selected="selected"' : '' ?>><?= __('Mixed', 'LayerSlider') ?></option>
														</select>
													</td>
													<td class="right"><?= __('Direction', 'LayerSlider') ?></td>
													<td>
														<select name="direction" data-help="<?= __('The direction of the slide or mixed animation if you’ve chosen this type in the previous settings.', 'LayerSlider') ?>">
															<option value="top"<?= ($tr['transition']['direction'] == 'top') ? ' selected="selected"' : '' ?>><?= __('Top', 'LayerSlider') ?></option>
															<option value="right"<?= ($tr['transition']['direction'] == 'right') ? ' selected="selected"' : '' ?>><?= __('Right', 'LayerSlider') ?></option>
															<option value="bottom"<?= ($tr['transition']['direction'] == 'bottom') ? ' selected="selected"' : '' ?>><?= __('Bottom', 'LayerSlider') ?></option>
															<option value="left"<?= ($tr['transition']['direction'] == 'left') ? ' selected="selected"' : '' ?>><?= __('Left', 'LayerSlider') ?></option>
															<option value="random"<?= ($tr['transition']['direction'] == 'random') ? ' selected="selected"' : '' ?>><?= __('Random', 'LayerSlider') ?></option>
															<option value="topleft"<?= ($tr['transition']['direction'] == 'topleft') ? ' selected="selected"' : '' ?>><?= __('Top left', 'LayerSlider') ?></option>
															<option value="topright"<?= ($tr['transition']['direction'] == 'topright') ? ' selected="selected"' : '' ?>><?= __('Top right', 'LayerSlider') ?></option>
															<option value="bottomleft"<?= ($tr['transition']['direction'] == 'bottomleft') ? ' selected="selected"' : '' ?>><?= __('Bottom left', 'LayerSlider') ?></option>
															<option value="bottomright"<?= ($tr['transition']['direction'] == 'bottomright') ? ' selected="selected"' : '' ?>><?= __('Bottom right', 'LayerSlider') ?></option>
														</select>
													</td>
												</tr>
												<tr>
													<td class="right"><?= __('RotateX', 'LayerSlider') ?></td>
													<td><input type="text" name="rotateX" value="<?= !empty($tr['transition']['rotateX']) ? $tr['transition']['rotateX'] : '0' ?>" data-help="<?= __('The initial rotation of the individual tiles which will be animated to the default (0deg) value around the X axis. You can use negatuve values.', 'LayerSlider') ?>"></td>
													<td class="right"><?= __('RotateY', 'LayerSlider') ?></td>
													<td><input type="text" name="rotateY" value="<?= !empty($tr['transition']['rotateY']) ? $tr['transition']['rotateY'] : '0' ?>" data-help="<?= __('The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Y axis. You can use negatuve values.', 'LayerSlider') ?>"></td>
												</tr>
												<tr>
													<td class="right"><?= __('RotateZ', 'LayerSlider') ?></td>
													<td><input type="text" name="rotate" value="<?= !empty($tr['transition']['rotate']) ? $tr['transition']['rotate'] : '0' ?>" data-help="<?= __('The initial rotation of the individual tiles which will be animated to the default (0deg) value around the Z axis. You can use negatuve values.', 'LayerSlider') ?>"></td>
													<td class="right"><?= __('Scale', 'LayerSlider') ?></td>
													<td><input type="text" name="scale" value="<?= !empty($tr['transition']['scale']) ? $tr['transition']['scale'] : '1.0' ?>" data-help="<?= __('The initial scale of the individual tiles which will be animated to the default (1.0) value.', 'LayerSlider') ?>"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="ls-clear"></div>
				</div>
			</div>
		</div>



			</ls-box>

		</ls-section>

		<ls-section class="ls--form-control ls-publish">

			<?php if(is_writable($upload_dir['basedir'])) : ?>
				<button class="ls--button ls--bg-blue"><?= __('Save changes', 'LayerSlider') ?></button>
			<?php else : ?>
				<ls-p class="ls--text-center ls--strong ls--gray">
					<?= sprintf(__('Before you can save your changes, you need to make your “/wp-content/uploads” folder writable. See the %sCodex%s', 'LayerSlider'), '<a href="https://wordpress.org/support/article/changing-file-permissions/" target="_blank">', '</a>') ?>
				</ls-p>
			<?php endif; ?>

		</ls-section>

	</form>

</div>

<script type="text/javascript">
	var pluginPath = '<?= LS_ROOT_URL ?>/static/';
	var lsTrImgPath = '<?= LS_ROOT_URL ?>/static/admin/img/';
</script>

<script type="text/html" id="ls-tr-builder-list-entry">
	<li>
		<?= lsGetSVGIcon('bars') ?>
		<input type="text" value="<?= __('Untitled', 'LayerSlider') ?>" placeholder="<?= __('Type transition name', 'LayerSlider') ?>">
		<a href="#" title="<?= __('Remove transition', 'LayerSlider') ?>" class="remove">
			<?= lsGetSVGIcon('trash') ?>
		</a>
	</li>
</script>