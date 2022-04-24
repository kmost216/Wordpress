<?php

class Care_Menu_Importer implements Care_Importer_Interface {

	protected $filename;
	protected $menus = array();

	public function import() {

		$menu_locations = array();

		foreach ( $this->get_menus() as $menu_location => $menu_name ) {
			$menu_item   = get_term_by( 'name', $menu_name, 'nav_menu' );
			$menu_locations[$menu_location] = $menu_item->term_id;
		}

		set_theme_mod( 'nav_menu_locations', $menu_locations);
	}

	public function get_filename() {
		return $this->content_filename;
	}

	public function set_filename( $filename ) {
		$this->content_filename = $filename;
	}

	public function get_menus() {
		return $this->menus;
	}

	public function set_menus( $menus ) {
		return $this->menus = $menus;
	}

}
