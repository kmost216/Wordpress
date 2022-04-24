<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script type="text/html" id="tmpl-version-warning">

	<img id="lse-creature-oh-no" src="<?= LS_ROOT_URL ?>/static/admin/img/creature-oh-no.png" alt="Plugin Update Required">

	<lse-h1><?= __('Plugin Update Required', 'LayerSlider') ?></lse-h1>

	<lse-p><?= sprintf(__('This project template requires a newer version of LayerSlider in order to work properly. This is due to additional features introduced in a later version than you have. For updating instructions, please refer to our %sonline documentation%s.', 'LayerSlider'), '<a href="https://layerslider.com/how-to-update/" target="_blank">', '</a>') ?></lse-p>
</script>