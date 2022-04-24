<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-canceled-activation-modal">
	<kmw-h1 class="kmw-modal-title"><?= __('Why do I need to re-enter my license key?', 'LayerSlider') ?></kmw-h1>
	<p><?= __('You can only use a LayerSlider license key on one live site unless you’ve purchased a multi-use license. The most common reason for seeing this notification is because you’ve probably used the same license key on another site. Your license key is still valid, and you can re-register it. However, please consider purchasing additional licenses if you have multiple websites.', 'LayerSlider') ?></p>

	<p><?= __('Other potential reasons why you see this notification:', 'LayerSlider') ?></p>
	<ul>
		<li><?= __('you’ve moved your site, or your domain name has changed;', 'LayerSlider') ?></li>
		<li><?= __('you’ve remotely deregistered your site using our online tools or asked us to do the same on your behalf;', 'LayerSlider') ?></li>
		<li><?= __('you’re using a non-genuine copy of LayerSlider', 'LayerSlider') ?></li>
		<li><?= __('your purchase has been refunded or the transaction disputed;', 'LayerSlider') ?></li>
	</ul>

	<p><?= sprintf(__('If none of these reasons can explain your case and you feel it happened mistakenly, please let us know by %sopening a support ticket%s or contacting us via our %sContact Form%s. We’re here to help with uncovering potential issues and restoring premium benefits.', 'LayerSlider'), '<a href="https://kreatura.ticksy.com/" target="_blank">', '</a>', '<a href="https://layerslider.com/contact/" target="_blank">', '</a>' ) ?></p>
</script>