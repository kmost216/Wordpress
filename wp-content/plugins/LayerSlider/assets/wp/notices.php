<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

// Remove ALL notices from the Slider Builder
if( ! empty( $_GET['page'] ) && false !== strpos( $_GET['page'], 'layerslider' ) ) {
	if(
		( ! empty( $_GET['action'] ) && $_GET['action'] === 'edit' ) ||
		( ! empty( $_GET['section'] ) &&  $_GET['section'] === 'about' )
	) {
		add_action('in_admin_header', function () {
			remove_all_actions('admin_notices');
			remove_all_actions('all_admin_notices');
		}, 1000 );
	}
}


add_action('admin_init', function() {

	add_action('admin_notices', 'layerslider_important_notice');

	if( ! LS_Config::isActivatedSite() ) {
		add_action('after_plugin_row_'.LS_PLUGIN_BASE, 'layerslider_plugins_screen_notice', 10, 3 );
	}
});


function layerslider_important_notice() {

	// Get data
	$notice 	= LS_RemoteData::get('important-notice', false );
	$lastNotice = get_option('ls-last-important-notice', 0);

	// Check if there's an important notice
	if( ! empty( $notice ) ) {

		// Check notice validity
		if( ! empty($notice['date']) && ! empty($notice['title']) && ! empty($notice['message']) ) {

			// Check date
			if( $notice['date'] <= $lastNotice ) {
				return;
			}


			// Check min version (if any)
			if( ! empty( $notice['min_version'] ) ) {
				if( version_compare( LS_PLUGIN_VERSION, $notice['min_version'], '<' ) ) {
					return;
				}
			}


			// Check max version (if any)
			if( ! empty( $notice['max_version'] ) ) {
				if( version_compare( LS_PLUGIN_VERSION, $notice['max_version'], '>' ) ) {
					return;
				}
			}

			// Check audience
			if( ! empty( $notice['unactivated'] ) ) {
				if( LS_Config::isActivatedSite() ) {
					return;
				}
			}

			// Check target pages
			if( ! empty( $notice['url_filter'] ) ) {

				$matches = 0;
				$fragments = explode( ' ', $notice['url_filter'] );

				foreach( $fragments as $fragment ) {
					if( strpos( $_SERVER['REQUEST_URI'], $fragment ) !== false) {
						$matches++;
						break;
					}
				}

				if( ! $matches ) {
					return;
				}
			}

			// Show the notice

			if( ! empty( $notice['banner'] ) ) {
				$bannerStyle = ! empty( $notice['banner']['style'] ) ? $notice['banner']['style'] : '';
				$bannerClass = ! empty( $notice['banner']['class'] ) ? $notice['banner']['class'] : '';

			 ?>

			<div class="layerslider_notice_img ls-v7-banner <?= $bannerClass ?>" style="<?= $bannerStyle ?>">

				<?php if( ! empty( $notice['banner']['url'] ) ) : ?>
				<a href="<?= $notice['banner']['url'] ?>" target="<?= $notice['banner']['target'] ?>" class="banner_link"></a>
				<?php endif ?>


				<?php if( ! empty( $notice['banner']['content'] ) ) : ?>
				<?= $notice['banner']['content'] ?>
				<?php endif ?>

				<a href="<?= wp_nonce_url( admin_url( 'admin.php?page=layerslider&action=hide-important-notice' ), 'hide-important-notice') ?>" class="dashicons dashicons-dismiss" data-help="<?= __('Hide this banner', 'LayerSlider') ?>"></a>

				<?php if( ! empty( $notice['button'] ) && ! empty( $notice['button']['text']) ) : ?>
				<a href="<?= $notice['button']['url'] ?>" target="<?= $notice['button']['target'] ?>" class="button button-read-more" style="<?= ! empty( $notice['button']['style'] ) ? $notice['button']['style'] : ''; ?>">
					<?= $notice['button']['text'] ?>
				</a>
				<?php endif ?>
			</div>

			<?php } else { ?>

			<div class="layerslider_notice ls-v7-banner ls--form-control">
				<img src="<?= ! empty($notice['image']) ? $notice['image'] : LS_ROOT_URL.'/static/admin/img/ls-logo.png' ?>" class="ls-product-icon" alt="LayerSlider icon">
				<h1 class="ls-notice-title"><?= $notice['title'] ?></h1>
				<div class="ls-notice-text">
					<?= $notice['message'] ?>
				</div>

				<div class="ls-button-wrapper">
					<a href="<?= wp_nonce_url( admin_url( 'admin.php?page=layerslider&action=hide-important-notice' ), 'hide-important-notice') ?>" class="ls--button ls--bg-blue"><?= __('OK, I understand', 'LayerSlider') ?></a>
				</div>
			</div>

			<?php }
		}
	}
}


function layerslider_plugins_screen_notice( $plugin_file, $plugin_data, $status ) {
	$table = _get_list_table('WP_Plugins_List_Table');
	if( empty( $plugin_data['update'] ) ) {
	?>
	<tr class="plugin-update-tr active ls-plugin-update-row" data-slug="<?= LS_PLUGIN_SLUG ?>" data-plugin="<?= LS_PLUGIN_BASE ?>">
		<td colspan="<?= $table->get_column_count(); ?>" class="plugin-update colspanchange">
			<div class="update-message notice inline notice-warning notice-alt">
				<p>
					<?php
						printf(__('Register your LayerSlider license to receive live updates and premium benefits. %sPurchase a license%s or %sread the documentation%s to learn more.', 'installer'),
							'<a href="'.LS_Config::get('purchase_url').'" target="_blank">', '</a>', '<a href="https://layerslider.com/documentation/#activation" target="_blank">', '</a>');
					?>
				</p>
			</div>
		</td>
	</tr>
<?php } }

