<?php defined( 'LS_ROOT_FILE' ) || exit; ?>
<script id="lse-revisions-welcome-template" type="text/html">

	<lse-b id="lse-revisions-welcome">

		<kmw-h1 class="kmw-modal-title">
			<lse-b class="lse-tac">
				<?= __('You Can Now Rewind Time', 'LayerSlider') ?>
			</lse-b>
		</kmw-h1>

		<lse-p class="lse-tac">
			<?= _e('Have a peace of mind knowing that your project edits are always safe and you can revert back unwanted changes or faulty saves at any time. This feature serves not just as a backup solution, but a complete version control system where you can visually compare the changes you have made along the way.', 'LayerSlider') ?>
		</lse-p>

		<?php if( ! LS_Config::isActivatedSite() ) : ?>
		<lse-b class="lse-notification lse-bg-highlight">
			<?= lsGetSVGIcon('info-circle') ?>
			<lse-text><?= sprintf(__('Project Revisions is a premium feature. Register your LayerSlider license in order to enjoy our premium benefits. %sPurchase a license%s or %sread the documentation%s to learn more. %sGot LayerSlider in a theme?%s', 'LayerSlider'), '<a href="'.LS_Config::get('purchase_url').'" target="_blank">', '</a>', '<a href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>', '<a href="https://layerslider.com/documentation/#activation-bundles" target="_blank">', '</a>') ?></lse-text>
		</lse-b>
		<?php endif ?>

		<lse-b class="lse-tac lse-media-wrapper">
			<video autoplay loop muted poster="<?= LS_ROOT_URL ?>/static/admin/img/revisions_v7.jpg">
				<source src="https://layerslider.com/media/revisions_v7.mp4" type="video/mp4">
			</video>
 		</lse-b>

	</lse-b>

</script>