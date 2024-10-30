<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Frontend_Scripts {
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
	}

	public static function load_scripts() {
		global $posts;

		$theme_styles = array();

		$model = SLS_Model::get_instance();

		if ( ! empty( $posts ) ) {

			foreach ( $posts as $post ) {

				if ( preg_match_all( '#\[light_slider\s*id\s*=\s*"(\d+)"\]#', $post->post_content, $matches ) ) {

					foreach( $matches[1] as $slider_id ) {

						$slider = $model->get_slider_by_id( $slider_id );

						if ( ! empty( $slider ) ) {

							$handle = 'sls-theme-' . $slider['theme'];

							if ( ! empty( $theme_styles[ $handle ] ) ) {
								continue;
							}

							$theme = sls_instance()->theme_loader()->getTheme( $slider['theme'] );
							wp_enqueue_style( $handle, $theme->get_style_url() );

							$theme_styles[ $handle ] = true;

						}

					}

				}

			}

		}

		if ( ! empty( $theme_styles ) ) {
			wp_enqueue_script( 'imagesloaded', sls_instance()->plugin_url() . '/assets/sequence/imagesloaded.pkgd.min.js' );
			wp_enqueue_script( 'hammer', sls_instance()->plugin_url() . '/assets/sequence/hammer.min.js' );
			wp_enqueue_script( 'sequence', sls_instance()->plugin_url() . '/assets/sequence/sequence.min.js' );
		}
	}
}

SLS_Frontend_Scripts::init();