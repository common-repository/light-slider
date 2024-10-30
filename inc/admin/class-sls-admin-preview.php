<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Admin_Preview {
	public static function output() {
		if ( ! empty( $_POST['slider'] ) ) {
			$slider = json_decode( stripslashes( $_POST['slider'] ), true );
			$slides = json_decode( stripslashes( $_POST['slides'] ), true );

			$slider['ID'] = 0;
			$slider['params']['start_slide'] = $_POST['start_slide'];

			self::sort( $slides, 'sort' );
		} else if ( ! empty( $_REQUEST['id'] ) ) {
			$model = SLS_Model::get_instance();

			$slider = $model->get_slider_by_id( $_REQUEST['id'] );
			$slides = $model->get_slides_by_slider_id( $slider['ID'] );
		}

		$theme = sls_instance()->theme_loader()->getTheme( $slider['theme'] );

		if ( ! $theme ) {
			return;
		}

		wp_enqueue_script( 'imagesloaded', sls_instance()->plugin_url() . '/assets/sequence/imagesloaded.pkgd.min.js' );
		wp_enqueue_script( 'hammer', sls_instance()->plugin_url() . '/assets/sequence/hammer.min.js' );
		wp_enqueue_script( 'sequence', sls_instance()->plugin_url() . '/assets/sequence/sequence.min.js' );

		include_once( 'views/html-admin-preview.php' );
	}

	protected static function sort( &$arr, $col, $dir = SORT_ASC ) {
		$sort_col = array();
		foreach ( $arr as $key => $row ) {
			$sort_col[ $key ] = $row[ $col ];
		}

		array_multisort( $sort_col, $dir, $arr );
	}
}