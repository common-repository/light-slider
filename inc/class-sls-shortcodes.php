<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Shortcodes {
	public static function init() {
		$shortcodes = array(
			'light_slider' => __CLASS__ . '::slider',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	public static function slider( $atts ) {
		$atts = shortcode_atts( array(
			'id' => 0
		), $atts, 'light_slider' );

		if ( empty( $atts['id'] ) ) {
			echo esc_html__( 'Slider does not exist', 'light-slider' );
			return;
		}

		$model = SLS_Model::get_instance();

		$slider = $model->get_slider_by_id( $atts['id'] );

		if ( empty( $slider ) ) {
			echo esc_html__( 'Slider does not exist', 'light-slider' );
			return;
		}

		$slides = $model->get_slides_by_slider_id( $slider['ID'] );

		if ( empty( $slides ) ) {
			echo esc_html__( 'Please add slide to slider', 'light-slider' );

			return;
		}

		$theme = sls_instance()->theme_loader()->getTheme( $slider['theme'] );

		include( $theme->get_template_path() );
	}
}