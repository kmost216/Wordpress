<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-purchase-webshopworks-popups">
	<lse-b id="lse-activation-modal-window" class="tmpl-webshopworks-benefits">

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

		<lse-b class="lse-webshopworks-benefits">
			<lse-p><?= __('This is an additional content pack that’s being sold separately from your LayerSlider license. It was created by another party and we don’t have the ownership to distribute it for free. However, we absolutely love their work and we felt the urge to share it with the world. So we’ve partnered with them to bring this content pack to you.', 'LayerSlider') ?></lse-p>

			<lse-p><?= __('For $10 you receive unlimited use. Purchase once and use it on any current and future sites. This pack will grow and buyers will automatically receive any additional content for free.', 'LayerSlider') ?></lse-p>

			<lse-p><?= sprintf(__('Already purchased and believe you’re seeing this message mistakenly? Please make sure you’ve imported your previous Envato licenses (if there’s any) on the %sYour Account%s page using the same email address that you’ve provided during the checkout. If you need assistance, please %scontact us%s and we will gladly help.', 'LayerSlider'), '<a target="_blank" href="https://account.kreaturamedia.com/">', '</a>', '<a target="_blank" href="https://layerslider.com/contact/">', '</a>') ?></lse-p>
		</lse-b>

		<lse-p class="lse-df lse-jcc">

			<a target="_blank" href="https://layerslider.com/popups/webshopworks/#purchase" class="lse-button"><?= __('Buy Now', 'LayerSlider') ?></a>

			<a target="_blank" href="https://layerslider.com/popups/webshopworks/#info" class="lse-button-more-info lse-button"><?= __('More Details', 'LayerSlider') ?></a>
		</lse-p>


	</lse-b>
</script>