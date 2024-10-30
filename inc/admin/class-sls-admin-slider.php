<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class SLS_Admin_Slider {
	public static function output() {
		$action = $_REQUEST['action'];

		// Tab
		wp_enqueue_script( 'jquery-tabslet', sls_instance()->plugin_url() . '/assets/js/admin/jquery.tabslet.min.js', array( 'jquery'), SLS_VERSION );

		wp_enqueue_script( 'sls-admin-slider', sls_instance()->plugin_url() . '/assets/js/admin/slider.js', array( 'jquery', 'underscore' ), SLS_VERSION );

		wp_localize_script( 'sls-admin-slider', 'sls_slider_params', array(
			'ajax_url'                     => esc_url( add_query_arg( array(
				'page'   => $_GET['page'],
				'action' => $action
			) ) ),
			'nonce'                        => wp_create_nonce( 'sls_slider_nonce' ),
			'i18n_choose_image'            => __( 'Choose Image', 'light-slider' ),
			'i18n_choose_background_image' => __( 'Choose Background Image', 'light-slider' ),
			'i18n_choose'                  => __( 'Choose', 'light-slider' ),
			'i18n_confirm_delete_slide'    => __( 'Do you want to remove this slide?', 'light-slider' ),
		) );

		$data = self::getData();

		include_once( 'views/html-admin-page-slider.php' );
	}

	public static function getData() {
		$action = $_REQUEST['action'];

		if ( 'add' == $action ) {
			$slider = array(
				'title'  => __( 'Your slider name', 'Light Slider' ),
				'id'     => 0,
				'theme'  => $_REQUEST['theme'],
			);

			$slides = array();
		} else if ( 'edit' == $action ) {
			$model = SLS_Model::get_instance();

			$slider = $model->get_slider_by_id( $_REQUEST['id'] );
			$slides = $model->get_slides_by_slider_id( $slider['ID'] );
		}

		$theme          = sls_instance()->theme_loader()->getTheme( $slider['theme'] );
		$theme_data     = $theme->get_data();
		$element_styles = $theme->get_element_styles();

		$slider = array_merge( $theme_data['slider'], $slider );

		if ( empty( $slider['params']['start_slide'] ) ) {
			$slider['params']['start_slide'] = 1;
		}

		return array(
			'theme'          => $theme,
			'slider'         => $slider,
			'slides'         => $slides,
			'theme_data'     => $theme_data,
			'slide_template' => $theme->get_admin_template_path(),
			'element_styles' => $element_styles,
		);
	}
}