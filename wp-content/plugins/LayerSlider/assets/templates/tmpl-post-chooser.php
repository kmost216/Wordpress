<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<lse-b id="tmpl-post-chooser" class="lse-dn">
	<lse-b id="lse-post-chooser-modal-window">
		<kmw-h1 class="kmw-modal-title"><?= __('Select the Post, Page or Attachment you want to use', 'LayerSlider') ?></kmw-h1>

		<form method="post">
			<?php wp_nonce_field( 'lse_get_search_posts' ) ?>
			<input type="hidden" name="action" value="lse_get_search_posts">
			<table class="lse-light-theme">
				<tbody>
					<tr>
						<td>
							<input class="lse-large" type="search" name="s" placeholder="<?= __('Type here to search ...', 'LayerSlider') ?>">
						</td>
						<td>
							<lse-fe-wrapper class="lse-select">
								<select name="post_type" class="lse-large">
									<option value="page"><?= __('Pages', 'LayerSlider') ?></option>
									<option value="post"><?= __('Posts', 'LayerSlider') ?></option>
									<option value="attachment"><?= __('Attachments', 'LayerSlider') ?></option>
								</select>
							</lse-fe-wrapper>
						</td>
					</tr>
				</tbody>
			</table>
		</form>

		<lse-b class="results lse-post-previews">
			<lse-grid>
				<lse-row>

				</lse-row>
			</lse-grid>
		</lse-b>

	</lse-b>

</lse-b>