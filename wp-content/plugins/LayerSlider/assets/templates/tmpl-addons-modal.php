<?php


defined( 'LS_ROOT_FILE' ) || exit;

include LS_ROOT_PATH . '/classes/class.ls.modules.php';

$moduleManager = new LS_Modules;
$modules = $moduleManager->getAllModuleData();

?>


<script type="text/html" id="tmpl-addons-modal-sidebar">
	<div class="ls-addon-name"></div>
	<div class="ls-addon-desc"></div>

	<ls-button><?= __('Activate Add-On', 'LayerSlider') ?></ls-button>
</script>

<script type="text/html" id="tmpl-addons-modal">
	<form method="post" id="ls-addons-modal-window">
		<?php wp_nonce_field('install-addons'); ?>


		<kmw-h1 class="kmw-modal-title"><?= __('LayerSlider Add-Ons', 'LayerSlider') ?></kmw-h1>

		<?php foreach( $modules as $handle => $module ) : ?>
		<div class="ls-addon-item ls-active">
			<div class="ls-addon-item-name">
				<?= $module['name'] ?>
			</div>
		</div>
		<?php endforeach ?>



		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				popups
			</div>
		</div>

		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				revisions
			</div>
		</div>

		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				origami
			</div>
		</div>

		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				play by scroll
			</div>
		</div>



		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				Premium Popups
			</div>
		</div>

		<div class="ls-addon-item">
			<div class="ls-addon-item-name">
				font awesome
			</div>
		</div>


	</form>
</script>