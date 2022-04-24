<?php 
/**
* Plugin Name: Smart Grid Gallery
* Plugin URI: http://topdevs.net/smart-grid-gallery/
* Description: Turn boring WordPress [gallery] into dynamic responsive grid gallery with many options.
* Version: 1.4.5
* Author: topdevs.net
* Author URI: http://codecanyon.net/user/topdevs?ref=topdevs
* Requires at least: 3.5
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once 'includes/justified-gallery/JustifiedGalleryClass.php';
require_once 'includes/SmartGridGalleryClass.php';
require_once 'includes/tinymce/SmartGridGalleryTinyMCE.php';
require_once 'includes/tinymce/tinymce-options.php';

?>