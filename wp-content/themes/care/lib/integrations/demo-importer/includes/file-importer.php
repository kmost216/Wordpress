<?php

class Care_File_Importer {

	protected $temp_path_transient = 'wheels_temp_path';
	protected $temp_dirname        = 'wheels_temp';
	protected $single_location     = false;

	public function upload_zip( $filepath = null ) {

		if ( ! $filepath ) {
			return;
		}

		WP_Filesystem();

		global $wp_filesystem;

		$upload_dir = wp_upload_dir();
		$d_path     = $upload_dir['basedir'] . "/{$this->temp_dirname}/";
		$unzipfile  = unzip_file( $filepath, $d_path );

		if ( is_wp_error( $unzipfile ) && ! defined( 'FS_METHOD' ) ) {
			define( 'FS_METHOD', 'direct' ); //lets try direct.

			WP_Filesystem();  //WP_Filesystem() needs to be called again since now we use direct !

			$unzipfile = unzip_file( $filepath, $d_path );
			if ( is_wp_error( $unzipfile ) ) {

				if ( ! $this->single_location ) {
					if ( defined( 'CARE_PLUGIN_PATH' ) ) {
						$d_path    = SCP_PLUGIN_PATH . "{$this->temp_dirname}/";
						$unzipfile = unzip_file( $filepath, $d_path );
					}

					if ( is_wp_error( $unzipfile ) ) {
						$f      = basename( $filepath );
						$d_path = str_replace( $f, '', $filepath );

						$unzipfile = unzip_file( $filepath, $d_path );
					}
				}
			}
		}

		if (! is_wp_error( $unzipfile ) ) {
			set_transient( $this->temp_path_transient, $d_path, 12 * HOUR_IN_SECONDS );
			return true;
		}

		return false;
	}

	public function read_zip_files_from_temp_path( $subfolder = '' ) {

		if ( $this->get_temp_path() ) {
			$path = $this->get_temp_path() . $subfolder;
			return array_map( 'basename', glob( trailingslashit( $path ) . '*.zip' ) );
		}

		return array();
	}

	public function cleanup() {

		WP_Filesystem();
		global $wp_filesystem;
		$wp_filesystem->delete( $this->get_temp_path(), true );
		delete_transient( $this->temp_path_transient );
	}

	protected function get_temp_path() {
		return get_transient( $this->temp_path_transient );
	}

}
