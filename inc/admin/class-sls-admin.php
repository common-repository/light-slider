<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class SLS_Admin {
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	public function includes() {
		include_once( 'class-sls-admin-menus.php' );
	}

	public function admin_scripts() {
		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';

		if ( 'toplevel_page_light-slider' != $screen_id ) {
			return;
		}

		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
		$is_slider_page = 'add' == $action || 'edit' == $action;

		if ( $is_slider_page ) {

			// Color Picker
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			// Image Upload
			wp_enqueue_media();

		}

		// Load theme style
		if ( ! empty( $_REQUEST['theme'] ) ) {

			$theme = sls_instance()->theme_loader()->getTheme( $_REQUEST['theme'] );

			if ( $theme ) {

				wp_enqueue_style( 'sls-admin-theme-' . $theme->get_id(), $theme->get_style_url(), array(), null );

			}

		}

		wp_enqueue_style( 'sls-admin', sls_instance()->plugin_url() . '/assets/css/admin.css', array( 'wp-jquery-ui-dialog' ), null );
		wp_enqueue_script( 'sls-admin', sls_instance()->plugin_url() . '/assets/js/admin/script.js', array( 'jquery', 'jquery-ui-dialog', 'jquery-ui-sortable' ), SLS_VERSION );

		wp_localize_script( 'sls-admin', 'sls_admin_params', array(
			'ajax_url'                  => admin_url( 'admin-ajax.php' ),
			'i18n_confirm_delete_slide' => __( 'Do you want to remove this slider?', 'light-slider' ),
		) );
	}
}

return new SLS_Admin();