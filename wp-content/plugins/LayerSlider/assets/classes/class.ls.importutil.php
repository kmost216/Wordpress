<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

/**
 * Class for working with ZIP archives to import
 * sliders with images and other attachments.
 *
 * @package LS_ImportUtil
 * @since 5.0.3
 * @author John Gera
 * @copyright Copyright (c) 2021  John Gera, George Krupa, and Kreatura Media Kft.
 */

class LS_ImportUtil {

	// Counts the number of sliders imported.
	public $sliderCount = 0;


	// Database ID of the lastly imported slider.
	public $lastImportId;


	// Target folders
	private $uploadsDir, $targetDir, $targetURL, $tmpDir;


	// Imported images
	private $imported = [];


	// Accepts $_FILES
	public function __construct( $archive, $name = null, $groupName = null ) {

		// Attempt to workaround memory limit & execution time issues
		@ini_set( 'max_execution_time', 0 );
		@ini_set( 'memory_limit', apply_filters( 'admin_memory_limit', WP_MAX_MEMORY_LIMIT ) );

		if( empty( $name ) ) {
			$name = $archive;
		}

		// Get uploads folder
		$uploads = wp_upload_dir();

		// Check if /uploads dir is writable
		if( ! is_writable( $uploads['basedir'] ) ) {
			return false;
		}

		// Get target folders
		$this->uploadsDir 	= $uploads['basedir'];
		$this->targetDir 	= $uploads['basedir'].'/layerslider/projects';
		$this->targetURL 	= $uploads['baseurl'].'/layerslider/projects';
		$this->tmpDir 		= $uploads['basedir'].'/layerslider/tmp';

		$type = wp_check_filetype( basename( $name ), [
			'zip' => 'application/zip',
			'json' => 'application/json'
		]);

		// Check for ZIP
		if( ! empty( $type['ext'] ) && $type['ext'] == 'zip') {


			// Remove previous uploads (if any)
			$this->cleanup();

			// Extract ZIP
			if( $this->unpack( $archive) ) {

				// Uploaded folders
				$folders = glob( $this->tmpDir.'/*', GLOB_ONLYDIR );

				$groupId = NULL;
				if( ! empty( $groupName ) && count( $folders ) > 1 ) {
					$groupId = LS_Sliders::addGroup( $groupName );
				}

				foreach( $folders as $key => $dir) {

					$this->imported = [];

					if( ! isset( $_POST['skip_images'] ) ) {
						$this->uploadMedia( $dir );
					}

					if( file_exists($dir.'/settings.json') ) {
						$this->lastImportId = $this->addSlider($dir.'/settings.json', $groupId);
					}
				}

				// Finishing up
				$this->cleanup();
				return true;
			}



		// Check for JSON
		} elseif( ! empty( $type['ext'] ) && $type['ext'] == 'json') {

			// Get decoded file data
			$data = file_get_contents( $archive );
			if( $decoded = base64_decode( $data, true ) ) {
				if( ! $parsed = json_decode( $decoded, true ) ) {
					$parsed = unserialize( $decoded );
				}

			// Since v5.1.1
			} else {
				$parsed = [ json_decode( $data, true ) ];
			}

			// Iterate over imported sliders
			if( is_array( $parsed ) ) {

				// Import sliders
				foreach( $parsed as $item ) {

					// Increment the slider counter
					$this->sliderCount++;

					// Fix for export issue in v4.6.4
					if( is_string( $item ) ) { $item = json_decode($item, true); }

					$this->lastImportId = LS_Sliders::add(
						$item['properties']['title'],
						$item
					);
				}
			}
		}

		// Return false otherwise
		return false;
	}



	public function unpack( $archive ) {

		if( LS_FileSystem::createUploadDirs() ) {
			return LS_FileSystem::unzip( $archive, $this->tmpDir );
		}

		return false;
	}




	public function uploadMedia($dir = null) {

		// Check provided data
		if( empty( $dir ) || ! is_string( $dir ) || ! file_exists( $dir.'/uploads' ) ) {
			return false;
		}

		// Create folder if it isn't exists already
		$targetDir = $this->targetDir . '/' . basename($dir);
		if( ! file_exists( $targetDir ) ) { mkdir($targetDir, 0755); }

		// Include image.php for media library upload
		require_once(ABSPATH.'wp-admin/includes/image.php');

		// Iterate through directory
		foreach(glob($dir.'/uploads/*') as $filePath) {

			$fileName 	= sanitize_file_name(basename($filePath));
			$targetFile = $targetDir.'/'.$fileName;
			$targetURL 	= $this->targetURL.'/'.basename($dir).'/'.$fileName;

			// Validate media
			$filetype = wp_check_filetype($fileName, null);
			if( ! empty( $filetype['ext'] ) && $filetype['ext'] != 'php' ) {

				// New upload
				if( ! $attach_id = $this->attachIDForURL( $targetURL, $targetFile ) ) {

					// Move item to place
					rename($filePath, $targetFile);

					// Upload to media library
					$attachment = [
						'guid' => $targetFile,
						'post_mime_type' => $filetype['type'],
						'post_title' => preg_replace( '/\.[^.]+$/', '', $fileName),
						'post_content' => '',
						'post_status' => 'inherit'
					];

					$attach_id = wp_insert_attachment($attachment, $targetFile, 37);
					if($attach_data = wp_generate_attachment_metadata($attach_id, $targetFile)) {
						wp_update_attachment_metadata($attach_id, $attach_data);
					}

					$this->imported[$fileName] = [
						'id' => $attach_id,
						'url' => $this->targetURL.'/'.basename($dir).'/'.$fileName
					];

				// Already uploaded
				} else {

					$this->imported[$fileName] = [
						'id' => $attach_id,
						'url' => $targetURL
					];
				}
			}
		}

		return true;
	}




	public function addSlider( $file, $groupId = NULL ) {

		// Increment the slider counter
		$this->sliderCount++;

		// Get slider data and title
		$data = json_decode(file_get_contents($file), true);
		$title = $data['properties']['title'];
		$slug = !empty($data['properties']['slug']) ? $data['properties']['slug'] : '';

		// Import Google Fonts used in slider
		if( empty( $data['googlefonts'] ) || ! is_array( $data['googlefonts'] ) ) {
			$data['googlefonts'] = [];
		}

		foreach( $data['googlefonts'] as $fontIndex => $font ) {
			$fontParam = explode(':', $font['param'] );
			$font = urldecode( $fontParam[0] );
			$font = str_replace(['+', '"', "'"], [' ', '', ''], $font);

			$data['googlefonts'][ $fontIndex ] = [ 'param' => $font ];
		}

		// Slider Preview
		if( ! empty($data['meta']) && ! empty($data['meta']['preview']) ) {
			$data['meta']['previewId'] = $this->attachIDForImage($data['meta']['preview']);
			$data['meta']['preview'] = $this->attachURLForImage($data['meta']['preview']);
		}

		// Slider settings
		if(!empty($data['properties']['backgroundimage'])) {
			$data['properties']['backgroundimageId'] = $this->attachIDForImage($data['properties']['backgroundimage']);
			$data['properties']['backgroundimage'] = $this->attachURLForImage($data['properties']['backgroundimage']);
		}


		// Slides
		if(!empty($data['layers']) && is_array($data['layers'])) {
		foreach($data['layers'] as &$slide) {

			if(!empty($slide['properties']['background'])) {
				$slide['properties']['backgroundId'] = $this->attachIDForImage($slide['properties']['background']);
				$slide['properties']['background'] = $this->attachURLForImage($slide['properties']['background']);
			}

			if(!empty($slide['properties']['thumbnail'])) {
				$slide['properties']['thumbnailId'] = $this->attachIDForImage($slide['properties']['thumbnail']);
				$slide['properties']['thumbnail'] = $this->attachURLForImage($slide['properties']['thumbnail']);
			}

			// Layers
			if(!empty($slide['sublayers']) && is_array($slide['sublayers'])) {
			foreach($slide['sublayers'] as &$layer) {

				if( ! empty($layer['image']) ) {
					$layer['imageId'] = $this->attachIDForImage($layer['image']);
					$layer['image'] = $this->attachURLForImage($layer['image']);
				}

				if( ! empty($layer['poster']) ) {
					$layer['posterId'] = $this->attachIDForImage($layer['poster']);
					$layer['poster'] = $this->attachURLForImage($layer['poster']);
				}

				if( ! empty($layer['layerBackground']) ) {
					$layer['layerBackgroundId'] = $this->attachIDForImage($layer['layerBackground']);
					$layer['layerBackground'] = $this->attachURLForImage($layer['layerBackground']);
				}
			}}
		}}

		// Add slider
		return LS_Sliders::add( $title, $data, $slug, $groupId );
	}


	// DEPRECATED: Should not be used
	// It does nothing. It's only here as a compatibility measure.
	public function addGoogleFonts( $data ) {

	}



	public function attachURLForImage($file = '') {

		if( isset($this->imported[ basename($file) ]) ) {
			return $this->imported[ basename($file) ]['url'];
		}

		return $file;
	}


	public function attachIDForImage( $file = '' ) {

		if( isset($this->imported[ basename($file) ]) ) {
			return $this->imported[ basename($file) ]['id'];
		}

		return '';
	}

	public function attachIDForURL( $url, $path ) {

		// Attempt to retrieve the post ID from the built in
		// attachment_url_to_postid() WP function when available.
		if( function_exists('attachment_url_to_postid') ) {
			if( $attachID = attachment_url_to_postid( $url ) ) {
				return $attachID;
			}
		}

		global $wpdb;

		if( empty( $this->uploadsDir ) ) {
			$uploads = wp_upload_dir();
			$this->uploadsDir = trailingslashit($uploads['basedir']);
		}

		$imgPath  = explode( parse_url( $this->uploadsDir, PHP_URL_PATH ), $path );
		$attachs = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $imgPath[1] ) );


		return ! empty( $attachs[0] ) ? $attachs[0] : 0;
	}

	public function cleanup() {
		LS_FileSystem::emptyDir( $this->tmpDir );
	}
}
?>