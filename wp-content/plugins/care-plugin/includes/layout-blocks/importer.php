<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Admin
 */
class Care_Plugin_Layout_Block_Importer {
	
	const POST_TYPE = 'layout_block';
	const BULK_EXPORT_ACTION = 'export_layout_blocks_bulk';

	public function __construct() {
		add_action( 'admin_menu', array($this, 'add_menu_page') );
	}

	public function add_menu_page() {
		$page_parent = 'edit.php?post_type=' . self::POST_TYPE;

		add_submenu_page( $page_parent, 'Import/Export', 'Import/Export', 'manage_options', '_layout_block_importer', array($this, 'page') );
	}

	protected function generate_hidden_inputs($data) {
		foreach ($data as $key => $value) {
			if ($key == 'post_content') {
				echo "<textarea class=\"hidden\" name=\"items[{$data['id']}][{$key}]\">{$value}</textarea>";
			} else {
				echo "<input name=\"items[{$data['id']}][{$key}]\" type=\"hidden\" value=\"{$value}\">";
			}
		}
	}

	public function page() {
		echo '<h1>' . esc_html_e( 'Import', 'care-plugin' ) . '</h1>';
		
		if ( isset( $_POST['scp_upload'] ) && check_admin_referer( 'scp-upload-nonce' ) ) {

			    // Check export file if any
				if( ! is_uploaded_file( $_FILES['import_file']['tmp_name'] ) ) {
					header( 'Location: '.$_SERVER['REQUEST_URI'].'&error=1' );
					die( 'No data received.' );
				}
			        
		        // Get decoded file data
				// $data = base64_decode(file_get_contents($_FILES['import_file']['tmp_name']));
				$data = file_get_contents( $_FILES['import_file']['tmp_name'] );
				$data = json_decode( $data, true );

				if ( isset( $data['items'] ) ) {

					?>
					<form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" enctype="multipart/form-data"> 

						<input type="hidden" name="scp_import" value="1">
						<?php wp_nonce_field( 'scp-import-nonce' ); ?>
						<h3><?php esc_html_e( 'Import Layout Blocks', 'prescolaire' ); ?></h3>
						<?php foreach ($data['items'] as $layout_block): ?>
							
							<p>
								<label for="<?php echo esc_attr( $layout_block['id'] ); ?>">
									<input id="<?php echo esc_attr( $layout_block['id'] ); ?>" type="checkbox" name="selected[]" value="<?php echo esc_attr( $layout_block['id'] ); ?>">
									<?php echo esc_html( $layout_block['post_title'] ); ?>
								</label>
							</p>
							<p><img src="<?php echo esc_url( $layout_block['thumbnail'] ); ?>"></p>
							<p><?php $this->generate_hidden_inputs( $layout_block ) ?></p>
						<?php endforeach ?>
						<p class="submit">
							<button type="submit" class="button button-primary"><?php esc_html_e( 'Import', 'prescolaire' ); ?></button>
						</p>
					</form>
					<?php
					
				}			  

		} else if ( isset( $_POST['scp_import'] ) && check_admin_referer( 'scp-import-nonce' ) ) {

			if ( isset( $_POST['selected'] ) && isset( $_POST['items'] ) ) {
				foreach ( $_POST['selected'] as $id ) {
					if ( isset( $_POST['items'][$id] ) ) {
						$this->create_new_post( $_POST['items'][$id] );
					}
				}
			}
			// create new layout block
			// save meta
			esc_html_e( 'Import complete.', 'care-plugin' );
		} else {

			$this->get_upload_form();
		}

	}

	protected function create_new_post( $item ) {

		if ( ! current_user_can( 'edit_posts' ) || ! is_array( $item ) ) {
			return false;
		}

		$data = array(
			'post_type'    => self::POST_TYPE,
			'post_title'   => wp_strip_all_tags( $item['post_title'] ),
			'post_content' => trim( stripslashes( $item['post_content'] ) ),
			'post_status'  => 'publish',
			'post_author'  => get_current_user_id(),
		);
		 
		$post_id = wp_insert_post( $data );

		if ( $post_id ) {
			// page css
			// shortcode css
			update_post_meta( $post_id, '_wpb_post_custom_css', $item['_wpb_post_custom_css'] );
			update_post_meta( $post_id, '_wpb_shortcodes_custom_css', $item['_wpb_shortcodes_custom_css'] );
			update_post_meta( $post_id, '_wpb_vc_js_status', 'true' );
			update_post_meta( $post_id, 'scp_google_fonts', $item['scp_google_fonts'] );

			return $post_id;
		}

		return false;
	}

	public function get_upload_form() {
		?>
		<hr>
		<form method="post" action="" enctype="multipart/form-data"> 
			<input type="hidden" name="scp_upload" value="1">
			<?php wp_nonce_field( 'scp-upload-nonce' ); ?>
			<h3><?php esc_html_e( 'Import Layout Blocks', 'prescolaire' ); ?></h3>
			<p><input type="file" name="import_file"></p>
			<p class="submit">
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Upload file', 'prescolaire' ); ?></button>
			</p>
		</form>

		<?php
	}

}

new Care_Plugin_Layout_Block_Importer();
