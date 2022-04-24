<?php

class LS_FileSystem {


	public static function addIndexPHP( $dir ) {

		if( ! file_exists( $dir.'/index.php' ) ) {
			@file_put_contents( $dir.'/index.php', '<?php // Silence is golden.');
		}
	}


	public static function emptyDir( $path ) {

		if( ! file_exists( $path ) ) {
			return true;
		}

		if( is_file( $path ) ) {
			return @unlink($path);

		} elseif( is_dir( $path ) ) {
			$scan = glob( rtrim ( $path, '/' ).'/*' );
			foreach( $scan as $index => $item) {
				self::emptyDir( $item );
			}

			return @rmdir($path);
		}

		return true;
	}



	public static function deleteDir( $dir ) {

		if( ! self::emptyDir( $dir ) ) {
			return false;
		}

		return @rmdir( $dir );
	}



	public static function createUploadDirs() {

		$uploads 		= wp_upload_dir();
		$uploadsBaseDir = $uploads['basedir'];

		// Check if /uploads dir is writable
		if( ! is_writable( $uploadsBaseDir ) ) {
			return false;
		}

		$directories = [
			$uploadsBaseDir.'/layerslider',
			$uploadsBaseDir.'/layerslider/tmp',
			$uploadsBaseDir.'/layerslider/modules',
			$uploadsBaseDir.'/layerslider/projects'
		];

		foreach( $directories as $dir ) {

			if( ! is_dir( $dir ) ) {
				wp_mkdir_p( $dir );
				LS_FileSystem::addIndexPHP( $dir );
			}
		}

		return true;
	}



	public static function unzip( $archive, $to ) {

		require_once( ABSPATH.'wp-admin/includes/file.php' );

		// Unpack archive
		WP_Filesystem();
		global $wp_filesystem;

		$file = unzip_file( $archive, $to );

		if( is_wp_error( $file ) ) {

			if( ! defined('FS_METHOD') ) {
				define('FS_METHOD', 'direct');
				WP_Filesystem();
			}

			$file = unzip_file( $archive, $to );

			if( is_wp_error( $file ) ) {
				return false;
			}
		}

		return true;
	}
}