<?php

// Prevent direct file access
defined( 'LS_ROOT_FILE' ) || exit;

class LS_Modules {

	protected $moduleList;

	public $uploadsDir;
	public $uploadsBaseDir;
	public $uploadsBaseURL;
	public $modulesDir;
	public $modulesURL;


	public function __construct() {

		$this->uploadsDir 		= wp_get_upload_dir();
		$this->uploadsBaseDir 	= $this->uploadsDir['basedir'];
		$this->uploadsBaseURL 	= $this->uploadsDir['baseurl'];
		$this->modulesDir 		= $this->uploadsBaseDir.'/layerslider/modules';
		$this->modulesURL 		= $this->uploadsBaseURL.'/layerslider/modules';

		$this->moduleList = [

			'pixie' => [
				'name' 		=> __('Image Editor', 'LayerSlider'),
				'handle' 	=> 'pixie-2.0.8',
				'files' 	=> [
					'css' 	=> 'styles.min.css',
					'js' 	=> 'scripts.min.js'
				]
			],

			'font-awesome-5' 	=> [
				'name' 		=> 'Font Awesome 5',
				'icon' 		=> 'font-awesome',
				'handle' 	=> 'font-awesome-5.15.3',
				'file' 		=> 'icons.js'
			],

			'ionicons' 	=> [
				'name' 		=> 'Ionicons',
				'icon' 		=> 'ionicons',
				'handle' 	=> 'ionicons-5.5.1',
				'file' 		=> 'icons.js'
			],

			'line-awesome' 	=> [
				'name' 		=> 'Line Awesome',
				'icon' 		=> 'icons8',
				'handle' 	=> 'lineawesome-1.3.0',
				'file' 		=> 'icons.js'
			],

			'material-filled' 	=> [
				'name' 		=> 'Material Filled',
				'icon' 		=> 'material-icons',
				'handle' 	=> 'material-filled-4.0.0',
				'file' 		=> 'icons.js'
			],

			'material-outlined' 	=> [
				'name' 		=> 'Material Outlined',
				'icon' 		=> 'material-icons',
				'handle' 	=> 'material-outlined-4.0.0',
				'file' 		=> 'icons.js'
			],

			'material-rounded' 	=> [
				'name' 		=> 'Material Rounded',
				'icon' 		=> 'material-icons',
				'handle' 	=> 'material-rounded-4.0.0',
				'file' 		=> 'icons.js'
			],

			'material-sharp' 	=> [
				'name' 		=> 'Material Sharp',
				'icon' 		=> 'material-icons',
				'handle' 	=> 'material-sharp-4.0.0',
				'file' 		=> 'icons.js'
			],

			'material-twotone' 	=> [
				'name' 		=> 'Material Two Tone',
				'icon' 		=> 'material-icons',
				'handle' 	=> 'material-twotone-4.0.0',
				'file' 		=> 'icons.js'
			],
		];

	}


	public function getModuleData( $handle ) {

		if( empty( $this->moduleList[ $handle ] ) ) {
			return false;
		}

		$moduleData = $this->moduleList[ $handle ];
		$moduleDir 	= $this->modulesDir.'/'.$moduleData['handle'];
		$needsDL 	= ! file_exists( $moduleDir ) || count( glob( "$moduleDir/*" ) ) === 0;

		$moduleData['baseURL'] 		= $this->modulesURL.'/'.$moduleData['handle'];
		$moduleData['installed'] 	= ! $needsDL;
		$moduleData['needsDL'] 		= $needsDL;

		return $moduleData;
	}


	public function getAllModuleData() {

		$modules = [];

		foreach( $this->moduleList as $moduleKey => $moduleData ) {
			$modules[ $moduleKey ] = $this->getModuleData( $moduleKey );
		}

		return $modules;
	}

}