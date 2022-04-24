<?php

defined( 'LS_ROOT_FILE' ) || exit;

$registered = LS_Config::isActivatedSite();

$iconModules = [
	$modules['font-awesome-5'],
	'Material Design',
	$modules['material-filled'],
	$modules['material-outlined'],
	$modules['material-rounded'],
	$modules['material-sharp'],
	$modules['material-twotone'],
	__('More Icon Families', 'LayerSlider'),
	$modules['ionicons'],
	$modules['line-awesome'],
];

?>
<div class="ls-d-none">
	<div id="tmpl-insert-icons-sidebar">
		<div class="kmw-sidebar-title">
			<?= __('Icon Library', 'LayerSlider') ?>
		</div>
		<kmw-navigation class="km-tabs-list" data-disable-auto-rename>

			<kmw-menutitle>
				<kmw-menutext>Font Awesome</kmw-menutext>
			</kmw-menutitle>

			<kmw-menuitem class="kmw-active" data-url="<?= LS_ROOT_URL . '/static/font-awesome-4/icons.js' ?>">
				<?= lsGetSVGIcon('font-awesome-flag', 'brands', false, 'kmw-icon') ?>
				<kmw-menutext>Font Awesome 4</kmw-menutext>
				<?= lsGetSVGIcon('spinner-third', 'duotone', [ 'class' => 'lse-spinner' ]); ?>
			</kmw-menuitem>

			<?php foreach( $iconModules as $iconModule ) : ?>
			<?php if( is_string( $iconModule ) ) : ?>
			<kmw-menutitle>
				<kmw-menutext><?= $iconModule ?></kmw-menutext>
			</kmw-menutitle>
			<?php else : ?>
			<kmw-menuitem data-module='<?= json_encode( $iconModule ) ?>' data-url="<?= $iconModule['baseURL'] .'/'. $iconModule['file'] ?>"<?= ( $registered && ! empty( $iconModule['installed'] ) ) ? '' : 'class="kmw-disabled"' ?>>
				<?= lsGetSVGIcon( $iconModule['icon'], 'brands', false, 'kmw-icon') ?>
				<kmw-menutext><?= $iconModule['name'] ?></kmw-menutext>
				<?= lsGetSVGIcon('spinner-third', 'duotone', [ 'class' => 'lse-spinner' ]); ?>

				<?php if( ! $registered ) : ?>
				<?= lsGetSVGIcon('lock', false, [
						'class' => 'lse-premium-lock',
						'data-tt' => '',
						'data-tt-de' => 0.1
				]) ?>
				<lse-tt class="lse-premium"><?= __('This icon family requires license registration. Click on the padlock icon to learn more.', 'LayerSlider') ?></lse-tt>
				<?php elseif( empty( $iconModule['installed'] ) ) : ?>
				<?= lsGetSVGIcon('arrow-alt-down', false, [
					'class' => 'lse-installable-icon',
					'data-tt' => ''
				]) ?>
				<lse-tt><?= __('Click to install icon family.', 'LayerSlider') ?></lse-tt>
				<?php endif ?>
			</kmw-menuitem>
			<?php endif ?>
			<?php endforeach ?>



		</kmw-navigation>
	</div>

	<lse-b id="tmpl-insert-icons-modal">
		<kmw-h1 class="kmw-modal-title"><?= __('Font Awesome 4', 'LayerSlider') ?></kmw-h1>

		<lse-b class="kmw-modal-toolbar" style="margin-top: 10px;">
			<input type="search" name="s" id="lse-icons-search-input" class="lse-modal-search" placeholder="<?= __('Filter icon family...', 'LayerSlider') ?>">
			<lse-b class="lse-icons-credits">
				<lse-b class="lse-icons-credits-item">
					<lse-b class="lse-icons-count">786</lse-b> Icons
				</lse-b>
				<lse-b class="lse-icons-credits-item lse-icon-type-font" data-tt data-tt-de="0.1">
					<?= __('Icon Font', 'LayerSlider') ?>
				</lse-b>
				<lse-tt><?= __('Icon fonts can slightly impact page load speed as they require all glyphs to be loaded. SVG icons from the other families can be loaded individually, and they can perform better in some cases.', 'LayerSlider') ?></lse-tt>
				<lse-b class="lse-icons-credits-item lse-icon-type-svg" data-tt data-tt-de="0.1">SVG</lse-b>
				<lse-tt><?= __('Scalable Vector Graphics', 'LayerSlider') ?></lse-tt>
				<lse-b class="lse-icons-credits-item lse-icon-type-svg" data-tt data-tt-de="0.1">
					<?= __('Performance Friendly', 'LayerSlider') ?>
				</lse-b>
				<lse-tt>
					<?= __('SVG icons can be loaded as individual objects, making it a great choice when it comes to site load performance.', 'LayerSlider') ?>
				</lse-tt>
				<lse-b class="lse-icons-credits-item lse-icons-author">
					<a href="https://fontawesome.com/v4.7.0/" target="_blank">Font Awesome</a>
					<?= lsGetSVGIcon('external-link-alt') ?>
				</lse-b>
			</lse-b>
		</lse-b>

		<lse-b id="lse-icons-panel-ctr" class="lse-icons-panel-ctr lse-scrollbar lse-scrollbar-dark">
			<lse-b id="lse-icons-panel-display" class="lse-icons-display-areas">
			</lse-b>
		</lse-b>
		<lse-b id="lse-icons-panel-search-ctr" class="lse-icons-panel-ctr lse-icons-hide lse-scrollbar lse-scrollbar-dark">
			<lse-b id="lse-icons-panel-search-display" class="lse-icons-display-areas">
			</lse-b>
		</lse-b>
	</lse-b>
</div>