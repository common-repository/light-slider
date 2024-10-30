<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_AJAX {
	public static function init() {
		self::add_ajax_events();
	}

	public static function add_ajax_events() {
		// sls_EVENT => nopriv
		$ajax_events = array(
			'save_slider' => false,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_sls_' . $ajax_event, array( __CLASS__, $ajax_event ) );

			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_sls_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	public static function save_slider() {
		if ( ! isset( $_POST['nonce'], $_POST['slider'], $_POST['slides'] ) ) {
			wp_send_json_error( 'missing_fields' );
			exit;
		}

		if ( ! wp_verify_nonce( $_POST['nonce'], 'sls_slider_nonce' ) ) {
			wp_send_json_error( 'bad_nonce' );
			exit;
		}

		// Check User Caps
		if ( ! current_user_can( 'create_light_slider' ) ) {
			wp_send_json_error( 'missing_capabilities' );
			exit;
		}

		$slider          = $_POST['slider'];
		$slider['ID']    = isset( $slider['ID'] ) ? intval( $slider['ID'] ) : 0;
		$slider['title'] = sanitize_text_field( $slider['title'] );
		$slider['theme'] = sanitize_text_field( $slider['theme'] );

		$slides = $_POST['slides'];
		$slides = ! empty( $slides ) && is_array( $slides ) ? $slides : array();
		foreach ( $slides as $slide_index => $slide ) {
			$slides[ $slide_index ]['sort']   = isset( $slides[ $slide_index ]['sort'] ) ? intval( $slides[ $slide_index ]['sort'] ) : 1;
			$slides[ $slide_index ]['status'] = isset( $slides[ $slide_index ]['status'] ) ? sanitize_text_field( $slides[ $slide_index ]['status'] ) : 'publish';
		}

		global $wpdb;

		$table_slider = $wpdb->prefix . 'sls_sliders';
		$table_slide  = $wpdb->prefix . 'sls_slides';

		$now = current_time( 'Y-m-d' );

		$data = array(
			'title'    => $slider['title'],
			'theme'    => $slider['theme'],
			'params'   => json_encode( isset( $slider['params'] ) ? $slider['params'] : array() ),
			'created'  => $now,
			'modified' => $now,
		);

		$format = array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
		);

		if ( empty( $slider['ID'] ) ) {
			$wpdb->insert( $table_slider, $data, $format );

			$slider_id = $wpdb->insert_id;
		} else {
			$slider_id = $slider['ID'];

			$wpdb->update( $table_slider, $data, array( 'ID' => $slider['ID'] ), $format );

			$wpdb->delete( $table_slide, array( 'slider_id' => $slider['ID'] ) );
		}

		foreach ( (array) $slides as $slide ) {
			if ( empty( $slide ) ) {
				continue;
			}

			$wpdb->insert(
				$table_slide,
				array(
					'slider_id' => $slider_id,
					'params'    => json_encode( isset( $slide['params'] ) ? $slide['params'] : array() ),
					'layers'    => json_encode( isset( $slide['layers'] ) ? $slide['layers'] : array() ),
					'sort'      => isset( $slide['sort'] ) ? $slide['sort'] : 1,
					'status'    => isset( $slide['status'] ) ? $slide['status'] : 'publish',
				),
				array(
					'%d',
					'%s',
					'%s',
					'%d',
					'%s',
				)
			);
		}

		$response = array();

		if ( empty( $slider['ID'] ) ) {
			$response['redirect'] = admin_url( "?page=light-slider&action=edit&id={$slider_id}&theme={$slider['theme']}" );
		}

		wp_send_json_success( $response );
	}
}

SLS_AJAX::init();