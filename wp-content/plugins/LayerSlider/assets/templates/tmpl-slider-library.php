<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<div class="ls-sliders-grid">

<?php

if( ! empty($sliders) ) {
	foreach($sliders as $key => $item) {
		$preview = apply_filters('ls_preview_for_slider', $item );

		if( ! empty( $item['flag_group'] ) ) {
			$groupItems = $item['items'];

			if( empty( $groupItems ) ) { continue; }
			?>
			<div class="slider-item group-item"
				data-id="<?= $item['id'] ?>"
				data-name="<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>"
			>
				<div class="slider-item-wrapper">
					<div class="items">
						<?php
							if( ! empty( $item['items'] ) ) {
							foreach( $groupItems as $groupKey => $groupItem )  {
							$groupPreview = apply_filters('ls_preview_for_slider', $groupItem ); ?>
								<div class="item <?= ($groupItem['flag_deleted'] == '1') ? 'dimmed' : '' ?>">
									<div class="preview" style="background-image: url(<?=  ! empty( $groupPreview ) ? $groupPreview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);">
										<?php if( empty( $groupPreview ) ) : ?>
										<div class="no-preview">
											<?= __('No Preview', 'LayerSlider') ?>
										</div>
										<?php endif ?>
									</div>
								</div>
							<?php } } ?>
					</div>
				</div>
				<div class="info">
					<div class="name">
						<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>
					</div>
				</div>
			</div>
			<div class="ls-hidden">
				<div class="ls-clearfix">
					<?php
						if( ! empty( $item['items'] ) ) {
							foreach( $groupItems as $groupKey => $item ) {
								$preview = apply_filters('ls_preview_for_slider', $item );
								?>
								<div class="slider-item"
									data-id="<?= $item['id'] ?>"
									data-slug="<?= $item['slug'] ?>"
									data-name="<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>"
									data-previewurl="<?=  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>"
									data-slidecount="<?= ! empty( $item['data']['layers'] ) ? count( $item['data']['layers'] ) : 0 ?>"
									data-author="<?= $item['author'] ?>"
									data-date_c="<?= $item['date_c'] ?>"
									data-date_m="<?= $item['date_m'] ?>"
								>
									<div class="slider-item-wrapper">
										<div class="preview" style="background-image: url(<?=  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);">
											<?php if( empty( $preview ) ) : ?>
											<div class="no-preview">
												<h5><?= __('No Preview', 'LayerSlider') ?></h5>
												<small><?= __('Previews are automatically generated from slide images in projects.', 'LayerSlider') ?></small>
											</div>
											<?php endif ?>
										</div>
									</div>
									<div class="info">
										<div class="name">
											<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>
										</div>
									</div>
								</div><?php
							}
						}
					?>
				</div>
			</div>
			<?php

		} else { ?>
			<div class="slider-item"
				data-id="<?= $item['id'] ?>"
				data-slug="<?= $item['slug'] ?>"
				data-name="<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>"
				data-previewurl="<?=  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>"
				data-slidecount="<?= ! empty( $item['data']['layers'] ) ? count( $item['data']['layers'] ) : 0 ?>"
				data-author="<?= $item['author'] ?>"
				data-date_c="<?= $item['date_c'] ?>"
				data-date_m="<?= $item['date_m'] ?>"
			>
				<div class="slider-item-wrapper">
					<div class="preview" style="background-image: url(<?=  ! empty( $preview ) ? $preview : LS_ROOT_URL . '/static/admin/img/blank.gif' ?>);">
						<?php if( empty( $preview ) ) : ?>
						<div class="no-preview">
							<h5><?= __('No Preview', 'LayerSlider') ?></h5>
							<small><?= __('Previews are automatically generated from slide images in projects.', 'LayerSlider') ?></small>
						</div>
						<?php endif ?>
					</div>
				</div>
				<div class="info">
					<div class="name">
						<?= apply_filters('ls_slider_title', stripslashes($item['name']), 40) ?>
					</div>
				</div>
			</div><?php
		}
	}
}
?>

</div>