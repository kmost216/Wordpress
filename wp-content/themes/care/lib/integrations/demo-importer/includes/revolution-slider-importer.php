<?php

class Care_Revolution_Slider_Importer implements Care_Importer_Interface {

	protected $demo_files_path;
	protected $filename;
	protected $temp_path_transient = 'wheels_rev_temp_path';


	public function import_main_zip() {

		if ( ! defined( 'RS_PLUGIN_PATH' ) ) {
			return;
		}

		WP_Filesystem();

		$filepath = $_FILES["import_file"]["tmp_name"];

		global $wp_filesystem;

		$upload_dir = wp_upload_dir();
		$d_path     = $upload_dir['basedir'] . '/arstemp/';
		$unzipfile  = unzip_file( $filepath, $d_path );

		if ( is_wp_error( $unzipfile ) && ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' ); // lets try direct.

			WP_Filesystem();  //WP_Filesystem() needs to be called again since now we use direct !

			$unzipfile = unzip_file( $filepath, $d_path );
			if ( is_wp_error( $unzipfile ) ) {
				$d_path    = RS_PLUGIN_PATH . 'arstemp/';
				$unzipfile = unzip_file( $filepath, $d_path );

				if ( is_wp_error( $unzipfile ) ) {
					$f      = basename( $filepath );
					$d_path = str_replace( $f, '', $filepath );

					$unzipfile = unzip_file( $filepath, $d_path );
				}
			}
		}

		set_transient( $this->temp_path_transient, $d_path, 12 * HOUR_IN_SECONDS );
	}

	public function cleanup() {
		WP_Filesystem();
		global $wp_filesystem;
		$wp_filesystem->delete( $this->get_temp_path(), true );
		delete_transient( $this->temp_path_transient );
	}

	public function get_sliders() {
		if ( $this->get_temp_path() ) {
			return array_map( 'basename', glob( $this->get_temp_path() . '*.zip' ) );
		}

		return array();
	}

	protected function get_temp_path() {
		return get_transient( $this->temp_path_transient );
	}

	public function import( $exact_filepath = false ) {

		if ( defined( 'RS_PLUGIN_PATH' ) && file_exists( RS_PLUGIN_PATH . 'includes/slider.class.php' ) ) {
			require_once( RS_PLUGIN_PATH . 'includes/slider.class.php' );


			if ( $exact_filepath ) {
				$exact_filepath = $this->get_temp_path() . $exact_filepath;
			}

			$slider   = new RevSliderSlider();
			$response = $slider->importSliderFromPost( true, true, $exact_filepath, false, false, true );

			$sliderID = intval( $response["sliderID"] );


			$status = array();
			// handle error
			if ( $response["success"] == false ) {
				$status['status']  = 'error';
				$status['message'] = $response["error"];
			} else {
				$status['status']  = 'success';
				$status['message'] = 'Slider Import Success';
			}

			return $status;

		}
	}

	public function get_filename() {
		return $this->content_filename;
	}

	public function set_filename( $filename ) {
		$this->content_filename = $filename;
	}

	public function get_demo_files_path() {
		return $this->demo_files_path;
	}

	public function set_demo_files_path( $path ) {
		$this->demo_files_path = $path;
	}

}
