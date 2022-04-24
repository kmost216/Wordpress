<?php

interface Care_Importer_Interface {

	public function import();

	public function get_filename();

	public function set_filename( $filename );

}