<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-keyboard-shortcuts">
	<lse-b id="lse-keyboard-shortcuts-modal-window">
		<kmw-h1 class="kmw-modal-title"><?= __('Keyboard Shortcuts', 'LayerSlider') ?></kmw-h1>

		<lse-b class="lse-notification lse-bg-highlight">
			<?= lsGetSVGIcon('info-circle') ?>
			<lse-text><?= sprintf(__('Some keyboard shortcuts may not work when you’re interacting with form elements. This is because many keys have special purpose while typing into a text field. To avoid issues, some shortcuts are temporarily disabled until the form element loses its focused state (i.e. the glowing ring around it). To overcome this inconvenience, simply press %s. This will unfocus the form item you’re working with and re-enable all keyboard shortcuts.', 'LayerSlider'), '<kbd class="lse-key lse-key-wide lse-key-enter"></kbd>') ?></lse-text>
		</lse-b>

		<lse-h2><?= __('General interface shortcuts', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td><kbd class="lse-key lse-key-wide">esc</kbd></td>
						<td><?= __('Close active interface elements like panels, modal windows, etc.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><kbd class="lse-key lse-key-wide lse-key-enter"></kbd> </lse-i><?= __('in text fields', 'LayerSlider') ?></lse-i></td>
						<td><?= __('Lose focus on current form item to make all keyboard shortcuts accessible.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><kbd class="lse-key lse-key-wide lse-key-enter"></kbd> </lse-i><?= __('on selected layer', 'LayerSlider') ?></lse-i></td>
						<td><?= __('Quick edit the selected layer, so you can change its contents in the preview area.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key">E</kbd></td>
						<td><?= __('Toggle the search panel.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td><kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key">F</kbd></td>
						<td><?= __('Toggle fullscreen editing mode.', 'LayerSlider') ?></td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>

		<lse-h2><?= __('Undo & Redo', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key">Z</kbd>
						</td>
						<td><?= __('Undo. Erases the last change done to the slide revering it to an older state.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key">Y</kbd>
							</lse-i class="lse-n1">or</lse-i><br>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key lse-key-wide lse-key-shift"></kbd> +
							<kbd class="lse-key">Z</kbd>
						</td>
						<td><?= __('Redo. Reverses the undo or advances the buffer to a more current state.', 'LayerSlider') ?></td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>


		<lse-h2><?= __('Save & Publish', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key">S</kbd>
						</td>
						<td><?= __('Save the project as a draft.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> + <kbd class="lse-key lse-key-wide lse-key-shift"></kbd> + <kbd class="lse-key">S</kbd>
						</td>
						<td><?= __('Publish the project, so changes go live on front-end pages.', 'LayerSlider') ?></td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>


		<lse-h2><?= __('Live Preview', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td><kbd class="lse-key lse-key-wide lse-key-space"></kbd></td>
						<td><?= __('Toggle slide preview mode to see your work in action.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							( <kbd class="lse-key lse-key-wide lse-key-alt"></kbd> /
							<kbd class="lse-key lse-key-wide lse-key-shift"></kbd> ) +
							<kbd class="lse-key lse-key-wide lse-key-space"></kbd>
						</td>
						<td><?= __('Toggle layer preview mode to see only the  selected layers animating. You can change layer properties in this mode and they will be reflected in real-time.', 'LayerSlider') ?></td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>

		<lse-h2><?= __('Managing layers', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> +
							<kbd class="lse-key">A</kbd>
						</td>
						<td><?= __('Add new layer.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> +
							<kbd class="lse-key">C</kbd>
						</td>
						<td><?= __('Copy selected layers, so you can paste them on different slides or move across projects. <br>Please note: to avoid conflicts with the OS native copy event, this action will only work when there’s no active text selection on the page.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> +
							<kbd class="lse-key">X</kbd>
						</td>
						<td><?= __('Copy and remove selected layers in a single step.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> +
							<kbd class="lse-key">V</kbd>
						</td>
						<td><?= __('Paste previously copied layers.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> +
							<kbd class="lse-key">D</kbd>
						</td>
						<td><?= __('Duplicate selected layers.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							<kbd class="lse-key lse-key-wide lse-key-backspace"></kbd>
						</td>
						<td><?= __('Remove selected layers.', 'LayerSlider') ?></td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>

		<lse-h2><?= __('Positioning layers', 'LayerSlider') ?></lse-h2>
		<lse-table-wrapper>
			<table>
				<thead>
					<th><?= __('Shortcut', 'LayerSlider') ?></th>
					<th><?= __('Description', 'LayerSlider') ?></th>
				</thead>
				<tbody>
					<tr>
						<td>
							<lse-b class="lse-key-arrows">
								<kbd class="lse-key lse-key-arrows-up"></kbd>
								<kbd class="lse-key lse-key-arrows-right"></kbd>
								<kbd class="lse-key lse-key-arrows-bottom"></kbd>
								<kbd class="lse-key lse-key-arrows-left"></kbd>
							</lse-b>
						</td>
						<td><?= __('Move layers in any direction by a pixel on the slide canvas.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							( <kbd class="lse-key lse-key-wide lse-key-alt"></kbd> /
							<kbd class="lse-key lse-key-wide lse-key-shift"></kbd> ) +
							<lse-b class="lse-key-arrows">
								<kbd class="lse-key lse-key-arrows-up"></kbd>
								<kbd class="lse-key lse-key-arrows-right"></kbd>
								<kbd class="lse-key lse-key-arrows-bottom"></kbd>
								<kbd class="lse-key lse-key-arrows-left"></kbd>
							</lse-b>
						</td>
						<td><?= __('Move layers in any direction by 10 pixels on the slide canvas.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							</lse-i>Hold</lse-i>
							<kbd class="lse-key lse-key-wide lse-key-shift"></kbd>
							</lse-i>while dragging layers</lse-i>
						</td>
						<td><?= __('Move layers along their vertical or horizontal axis only.', 'LayerSlider') ?></td>
					</tr>
					<tr>
						<td>
							</lse-i>Hold</lse-i>
							<kbd class="lse-key lse-key-wide lse-key-ctrl"></kbd> </lse-i>while dragging layers</lse-i>
						</td>
						<td>
							<?= __('Disable layer snapping to freely move layers around.', 'LayerSlider') ?>
						</td>
					</tr>
				</tbody>
			</table>
		</lse-table-wrapper>



	</lse-b>
</script>