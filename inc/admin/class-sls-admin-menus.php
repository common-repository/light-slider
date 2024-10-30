<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLS_Admin_Menu {
	protected $menu_slug = 'light-slider';

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		add_menu_page( __( 'Light Slider', 'light-slider' ), __( 'Light Slider', 'light-slider' ), 'access_light_slider', $this->menu_slug, array( $this, 'all_sliders_page' ), 'dashicons-format-gallery' );
	}

	public function all_sliders_page() {
		$action = ! empty( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

		switch ($action) {
			case 'add':
			case 'edit':
				SLS_Admin_Slider::output();

				break;
			case 'preview':
				SLS_Admin_Preview::output();

				break;
			default:
				SLS_Admin_All_Sliders::output();
				break;
		}
	}
}

return new SLS_Admin_Menu();