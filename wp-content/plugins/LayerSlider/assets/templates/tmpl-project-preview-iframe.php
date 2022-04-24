<?php

	// Prevent direct file access
	defined( 'LS_ROOT_FILE' ) || exit;

	$wp_scripts = wp_scripts();

	$uploads = wp_upload_dir();
	$uploads['baseurl'] = set_url_scheme( $uploads['baseurl'] );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>LayerSlider Preview</title>

	<!-- Preview CSS & JS -->
	<link rel="stylesheet" href="<?= LS_ROOT_URL.'/static/admin/css/project-iframe.css?ver='.LS_PLUGIN_VERSION ?>">
	<script src="<?= LS_ROOT_URL.'/static/admin/js/webfontloader.js?ver='.LS_PLUGIN_VERSION ?>"></script>
	<script src="<?= LS_ROOT_URL.'/static/admin/js/project-iframe.js?ver='.LS_PLUGIN_VERSION ?>"></script>

	<!-- LayerSlider CSS -->
	<link rel="stylesheet" href="<?= LS_ROOT_URL.'/static/layerslider/css/layerslider.css?ver='.LS_PLUGIN_VERSION ?>">

	<!-- External libraries: jQuery & GreenSock -->
	<script src="<?= site_url( $wp_scripts->registered['jquery-core']->src ) ?>"></script>
	<script src="<?= LS_ROOT_URL.'/static/layerslider/js/layerslider.utils.js?ver='.LS_PLUGIN_VERSION ?>"></script>

	<!-- LayerSlider script files -->
	<script src="<?= LS_ROOT_URL.'/static/layerslider/js/layerslider.transitions.js?ver='.LS_PLUGIN_VERSION ?>"></script>
	<script src="<?= LS_ROOT_URL.'/static/layerslider/js/layerslider.kreaturamedia.jquery.js?ver='.LS_PLUGIN_VERSION ?>"></script>

	<!-- LayerSlider Popup plugin -->
	<link rel="stylesheet" href="<?= LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.css?ver='.LS_PLUGIN_VERSION ?>">
	<script src="<?= LS_ROOT_URL.'/static/layerslider/plugins/popup/layerslider.popup.js?ver='.LS_PLUGIN_VERSION ?>"></script>

	<!-- LayerSlider Origami plugin -->
	<link rel="stylesheet" href="<?= LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.css?ver='.LS_PLUGIN_VERSION ?>">
	<script src="<?= LS_ROOT_URL.'/static/layerslider/plugins/origami/layerslider.origami.js?ver='.LS_PLUGIN_VERSION ?>"></script>

	<!-- Font Awesome 4 -->
	<link rel="stylesheet" href="<?= LS_ROOT_URL.'/static/font-awesome-4/css/font-awesome.min.css?ver='.LS_PLUGIN_VERSION ?>">

	<!-- User CSS -->
	<?php if( file_exists( $uploads['basedir'].'/layerslider.custom.css' ) ) : ?>
	<link rel="stylesheet" href="<?= $uploads['baseurl'].'/layerslider.custom.css?ver='.LS_PLUGIN_VERSION ?>">
	<?php endif ?>

	<!-- Custom Transitions -->
	<?php if( file_exists( $uploads['basedir'].'/layerslider.custom.transitions.js' ) ) : ?>
	<script src="<?= $uploads['baseurl'].'/layerslider.custom.transitions.js?ver='.LS_PLUGIN_VERSION ?>"></script>
	<?php endif ?>
</head>
<body>
	<div id="lse-project-scroll-wrapper">
		<div id="lse-project-wrapper"></div>
	</div>
	<div id="lse-project-scroll-icon">
		<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="mouse-alt" class="svg-inline--fa fa-mouse-alt fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M224 0h-64A160 160 0 0 0 0 160v192a160 160 0 0 0 160 160h64a160 160 0 0 0 160-160V160A160 160 0 0 0 224 0zm128 352a128.14 128.14 0 0 1-128 128h-64A128.14 128.14 0 0 1 32 352V160A128.14 128.14 0 0 1 160 32h64a128.14 128.14 0 0 1 128 128zM192 80a48.05 48.05 0 0 0-48 48v32a48 48 0 0 0 96 0v-32a48.05 48.05 0 0 0-48-48zm16 80a16 16 0 0 1-32 0v-32a16 16 0 0 1 32 0z"></path></svg>
	</div>
</body>
</html>