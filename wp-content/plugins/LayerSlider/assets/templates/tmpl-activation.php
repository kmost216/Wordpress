<?php defined( 'LS_ROOT_FILE' ) || exit; ?>

<lse-b class="lse-dn">

	<lse-b id="tmpl-activation">

		<lse-b id="lse-activation-modal-window">

			<lse-b id="lse-activation-modal-layers" class="kmui-prepend">
				<img class="modal-layer-9" src="<?= LS_ROOT_URL . '/static/admin/img/layer9.jpg' ?>" alt="layer">
				<img class="modal-layer-1" src="<?= LS_ROOT_URL . '/static/admin/img/layer1.jpg' ?>" alt="layer">
				<img class="modal-layer-6" src="<?= LS_ROOT_URL . '/static/admin/img/layer6.png' ?>" alt="layer">
				<img class="modal-layer-4" src="<?= LS_ROOT_URL . '/static/admin/img/layer4.png' ?>" alt="layer">
				<img class="modal-layer-3" src="<?= LS_ROOT_URL . '/static/admin/img/layer3.png' ?>" alt="layer">
				<img class="modal-layer-2" src="<?= LS_ROOT_URL . '/static/admin/img/layer2.png' ?>" alt="layer">
				<img class="modal-layer-7" src="<?= LS_ROOT_URL . '/static/admin/img/layer7.png' ?>" alt="layer">
				<img class="modal-layer-5" src="<?= LS_ROOT_URL . '/static/admin/img/layer5.png' ?>" alt="layer">
				<img class="modal-layer-10" src="<?= LS_ROOT_URL . '/static/admin/img/layer10.png' ?>" alt="layer">
				<img class="modal-layer-8" src="<?= LS_ROOT_URL . '/static/admin/img/layer8.jpg' ?>" alt="layer">
			</lse-b>

			<lse-b class="lse-activation-benefits">
				<lse-h3><?= __('Register your license to receive premium benefits like:', 'LayerSlider') ?>
				</lse-h3>
				<lse-ul>
					<lse-li>
						<?= lsGetSVGIcon('sync-alt',false,['class' => 'lse-it-fix']) ?>
						<?= __('Automatic Updates', 'LayerSlider') ?>
						– <?= __('Always receive the latest LayerSlider version.', 'LayerSlider') ?>
					</lse-li>
					<lse-li>
						<?= lsGetSVGIcon('images','duotone',['class' => 'lse-it-fix']) ?>
						<?= __('Premium Project Templates', 'LayerSlider') ?>
						– <?= __('Access more templates to get started with projects.', 'LayerSlider') ?>
					</lse-li>
					<lse-li>
						<?= lsGetSVGIcon('window-maximize','regular',['class' => 'lse-it-fix']) ?>
						<?= __('Popups', 'LayerSlider') ?>
						– <?= __('With the power of LayerSlider, you can have the nicest popups to get your visitors’ attention.', 'LayerSlider') ?>
					</lse-li>
					<lse-li>
						<?= lsGetSVGIcon('stars',false,['class' => 'lse-it-fix']) ?>
						<?= __('Exclusive Features', 'LayerSlider') ?>
						– <?= __('Unlock exclusive and early-access features.', 'LayerSlider') ?>
					</lse-li>
					<lse-li>
						<?= lsGetSVGIcon('shapes', false ,['class' => 'lse-it-fix']) ?>
						<?= __('Add-Ons & Additional Content', 'LayerSlider') ?>
						– <?= __('Access to special effects, features, and additional ready-to-use content. ', 'LayerSlider') ?>
					</lse-li>
					<lse-li>
						<?= lsGetSVGIcon('question-circle',false,['class' => 'lse-it-fix']) ?>
						<?= __('Product Support', 'LayerSlider') ?>
						– <?= __('Direct help from our Support Team.', 'LayerSlider') ?>
					</lse-li>
				</lse-ul>
			</lse-b>


			<lse-p class="lse-df lse-jcc">
				<a href="<?= admin_url('admin.php?page=layerslider#activationBox') ?>" class="lse-button-activation lse-button lse-it-fix">
					<?= lsGetSVGIcon('key') ?>
					<lse-text>
						<?= __('Register License', 'LayerSlider') ?>
					</lse-text>
				</a>
				<a href="<?= LS_Config::get('purchase_url') ?>" target="_blank" class="lse-button lse-it-fix">
					<?= lsGetSVGIcon('cart-plus') ?>
					<lse-text>
						<?= __('Purchase License', 'LayerSlider') ?>
					</lse-text>
				</a>
			</lse-p>

			<lse-b class="lse-bundled-version">
				<lse-h3><?= __('If LayerSlider came bundled in a theme', 'LayerSlider') ?></lse-h3>
				<lse-p>
					<?= sprintf(
						__('License registration requires a direct purchase of a LayerSlider license if you have received LayerSlider with a theme. Add-Ons and other benefits can greatly enhance your content &amp; workflow. For more information, please refer to %sthis article%s.', 'LayerSlider'),
						'<a href="https://layerslider.com/documentation/#activation" target="_blank">',
						'</a>'
						);
					?>
				</lse-p>
			</lse-b>

		</lse-b>

	</lse-b>

</lse-b>