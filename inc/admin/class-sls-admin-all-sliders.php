<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Admin_All_Sliders {
	public static function output() {
		$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action']: '';

		if ( ! empty( $action ) ) {
			call_user_func( array( __CLASS__, $action ) );
		}

		$sliders = SLS_Model::get_instance()->get_sliders();
		$themes = sls_instance()->theme_loader()->get_themes();

		include_once( 'views/html-admin-page-all-sliders.php' );
	}

	public static function duplicate() {
		global $wpdb;

		if ( ! isset( $_REQUEST['nonce']) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'sls_duplicate_slider_nonce' ) ) {
			return;
		}

		// Check User Caps
		if ( ! current_user_can( 'duplicate_light_slider' ) ) {
			return;
		}

		$model = SLS_Model::get_instance();

		$slider = $model->get_slider_by_id( $_REQUEST['id'] );

		if ( empty ( $slider ) ) {
			return;
		}

		$slides = $model->get_slides_by_slider_id( $slider['ID'] );

		// Duplicate slider

		$model->insert_slider( $slider );

		$new_slider_id = $wpdb->insert_id;

		if ( ! empty( $slides ) ) {
			foreach ( $slides as $slide ) {
				$slide['slider_id'] = $new_slider_id;

				$model->insert_slide( $slide );
			}
		}
	}

	public static function delete() {
		global $wpdb;

		if ( ! isset( $_REQUEST['nonce']) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'sls_delete_slider_nonce' ) ) {
			return;
		}

		// Check User Caps
		if ( ! current_user_can( 'delete_light_slider' ) ) {
			return;
		}

		$slider_id = $_REQUEST['id'];

		$model = SLS_Model::get_instance();

		$model->delete_slider( $slider_id );
		$model->delete_slides_by_slider_id( $slider_id );
	}
}