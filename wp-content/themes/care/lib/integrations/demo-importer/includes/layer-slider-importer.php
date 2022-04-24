<?php

class Care_Layer_Slider_Importer extends Care_File_Importer {

	public function import( $filename ) {

		$import = false;
		if ( class_exists( 'ZipArchive' ) && file_exists( LS_ROOT_PATH . '/classes/class.ls.importutil.php' ) ) {
			include_once LS_ROOT_PATH . '/classes/class.ls.importutil.php';

			$filename = $this->get_temp_path() . $filename;

			if ( file_exists( $filename ) ) {
				$import = new LS_ImportUtil( $filename );
			}
		}

		$status = array();
		//handle error
		if ( $import == true ) {
			$status['status']  = 'success';
			$status['message'] = 'Slider Import Success';
		} else {
			$status['status']  = 'error';
			$status['message'] = $response["error"];
		}

		return $status;
	}

}
