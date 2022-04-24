<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

$queryArgs = [
	'post_status' => 'publish',
	'limit' => 100,
	'posts_per_page' => 100,
	'suppress_filters' => false
];

if(!empty($slider['properties']['post_orderby'])) {
	$queryArgs['orderby'] = $slider['properties']['post_orderby']; }

if(!empty($slider['properties']['post_order'])) {
	$queryArgs['order'] = $slider['properties']['post_order']; }

if(!empty($slider['properties']['post_type'])) {
	$queryArgs['post_type'] = $slider['properties']['post_type']; }

if(!empty($slider['properties']['post_categories'][0])) {
	$queryArgs['category__in'] = $slider['properties']['post_categories']; }

if(!empty($slider['properties'][0])) {
	$queryArgs['tag__in'] = $slider['properties']['post_tags']; }

if(!empty($slider['properties']['post_taxonomy']) && !empty($slider['properties']['post_tax_terms'])) {
	$queryArgs['tax_query'][] = [
		'taxonomy' => $slider['properties']['post_taxonomy'],
		'field' => 'id',
		'terms' => $slider['properties']['post_tax_terms']
	];
}

$posts = LS_Posts::find($queryArgs)->getParsedObject();
?>
<script type="text/javascript" class="lse-dn" id="ls-posts-json">window.lsPostsJSON = <?= $posts ? json_encode($posts) : '[]' ?> || [];</script>

<div id="tmpl-post-options">
	<div id="lse-post-options">
		<kmw-h1 class="kmw-modal-title"><?= __('Target posts with the filters below', 'LayerSlider') ?></kmw-h1>
		<div class="ls-configure-posts-modal">

			<lse-grid id="lse-content-type-filters" class="lse-white-theme">
				<lse-row>

					<lse-col>

						<!-- Post types -->
						<select data-param="post_type" name="post_type" class="lse-scrollbar lse-scrollbar-dark" multiple="multiple">
							<?php foreach($postTypes as $item) : ?>
							<?php if(isset($slider['properties']['post_type']) &&  in_array($item['slug'], $slider['properties']['post_type'])) : ?>
							<option value="<?= $item['slug'] ?>" selected="selected"><?= ucfirst($item['name']) ?></option>
							<?php else : ?>
							<option value="<?= $item['slug'] ?>"><?= ucfirst($item['name']) ?></option>
							<?php endif ?>
							<?php endforeach; ?>
						</select>

					</lse-col>

					<lse-col>

						<!-- Post categories -->
						<select data-param="post_categories" name="post_categories" class="lse-scrollbar lse-scrollbar-dark" multiple="multiple">
							<option value="0"><?= __('Don’t filter categories', 'LayerSlider') ?></option>
							<?php foreach ($postCategories as $item): ?>
							<?php if(isset($slider['properties']['post_categories']) && in_array($item->term_id, $slider['properties']['post_categories'])) : ?>
							<option value="<?= $item->term_id ?>" selected="selected"><?= ucfirst($item->name) ?></option>
							<?php else : ?>
							<option value="<?= $item->term_id ?>"><?= ucfirst($item->name) ?></option>
							<?php endif ?>
							<?php endforeach ?>
						</select>

					</lse-col>

					<lse-col>

						<!-- Post tags -->
						<select data-param="post_tags" name="post_tags" class="lse-scrollbar lse-scrollbar-dark" multiple="multiple">
							<option value="0"><?= __('Don’t filter tags', 'LayerSlider') ?></option>
							<?php foreach ($postTags as $item): ?>
							<?php if(isset($slider['properties']['post_tags']) && in_array($item->term_id, $slider['properties']['post_tags'])) : ?>
							<option value="<?= $item->term_id ?>" selected="selected"><?= ucfirst($item->name) ?></option>
							<?php else : ?>
							<option value="<?= $item->term_id ?>"><?= ucfirst($item->name) ?></option>
							<?php endif ?>
							<?php endforeach ?>
						</select>

					</lse-col>

					<lse-col>

						<!-- Post taxonomies -->
						<lse-fe-wrapper class="lse-select">
							<select data-param="post_taxonomy" name="post_taxonomy" class="lse-post-taxonomy">
								<option value="0"><?= __('Don’t filter taxonomies', 'LayerSlider') ?></option>
								<?php foreach ($postTaxonomies as $key => $item): ?>
								<?php if(isset($slider['properties']['post_taxonomy']) && $slider['properties']['post_taxonomy'] == $key) : ?>
								<option value="<?= $item->name ?>" selected="selected"><?= $item->labels->name ?></option>
								<?php else : ?>
								<option value="<?= $item->name ?>"><?= $item->labels->name ?></option>
								<?php endif ?>
								<?php endforeach ?>
							</select>
						</lse-fe-wrapper>

						<!-- Taxonomy terms -->
						<?php if(!empty($slider['properties']['post_taxonomy'])) : ?>
						<?php $postTaxTerms = get_terms($slider['properties']['post_taxonomy']); ?>
						<?php else : ?>
						<?php $postTaxTerms = []; ?>
						<?php endif ?>
						<select data-param="post_tax_terms" name="post_tax_terms" class="lse-scrollbar lse-scrollbar-dark" multiple="multiple">
							<?php foreach ($postTaxTerms as $item): ?>
							<?php if(isset($slider['properties']['post_tax_terms']) && in_array($item->term_id, $slider['properties']['post_tax_terms'])) : ?>
							<option value="<?= $item->term_id ?>" selected="selected"><?= $item->name ?></option>
							<?php else : ?>
							<option value="<?= $item->term_id ?>"><?= $item->name ?></option>
							<?php endif ?>
							<?php endforeach ?>
						</select>

					</lse-col>

				</lse-row>

			</lse-grid>

			<lse-table-wrapper class="lse-light-theme">

				<table>
					<tr>
						<td>
							<?= _e('Order results by', 'LayerSlider') ?>
						</td>
						<td>
							<lse-fe-wrapper class="lse-select">
								<?php lsGetSelect($lsDefaults['slider']['postOrderBy'], $slider['properties'], ['data-param' => $lsDefaults['slider']['postOrderBy']['keys']]) ?>
							</lse-fe-wrapper>
							<lse-fe-wrapper class="lse-select">
								<?php lsGetSelect($lsDefaults['slider']['postOrder'], $slider['properties'], ['data-param' => $lsDefaults['slider']['postOrder']['keys']]) ?>
							</lse-fe-wrapper>
						</td>
					</tr>
					<tr>
						<td>
							<?= _e('On this slide, use post from matches: ', 'LayerSlider') ?>
						</td>
						<td>
							<lse-fe-wrapper class="lse-select">
								<select data-param="post_offset" name="post_offset" class="lse-post-offset">
									<option value="-1"><?= __('next in line', 'LayerSlider') ?></option>
									<?php for($c = 0; $c < 50; $c++) : ?>
									<option value="<?= $c ?>"><?= ls_ordinal_number($c+1) ?></option>
									<?php endfor ?>
								</select>
							</lse-fe-wrapper>
						</td>
					</tr>
				</table>

			</lse-table-wrapper>


			</lse-table-wrapper>

			<lse-h2><?= _e('Preview from currenty matched elements', 'LayerSlider') ?></lse-h2>
			<lse-table-wrapper class="lse-post-previews">
				<lse-wrapper>
					<lse-grid class="lse-scrollbar lse-scrollbar-dark">
						<lse-row>
						</lse-row>
					</lse-grid>
				</lse-wrapper>
			</lse-table-wrapper>
		</div>
	</div>
</div>
