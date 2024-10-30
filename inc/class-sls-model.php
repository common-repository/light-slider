<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Model {

	public $sliders_table;
	public $slides_table;

	protected static $instance;

	/**
	 * @var wpdb
	 */
	protected $wpdb;

	protected function __construct() {
		global $wpdb;

		$this->wpdb = $wpdb;

		$this->sliders_table = $this->wpdb->prefix . 'sls_sliders';
		$this->slides_table = $this->wpdb->prefix . 'sls_slides';
	}

	public static function get_instance() {
		if (!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function get_sliders() {
		$sliders = $this->wpdb->get_results( "SELECT * FROM {$this->sliders_table}", ARRAY_A );

		$sliders = is_array( $sliders ) ? $sliders : array();

		foreach ( $sliders as $index => $slider ) {
			$sliders[ $index ]['params'] = $this->decode( $slider['params'] );
		}

		return $sliders;
	}

	public function get_slider_by_id( $id ) {
		$slider = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM {$this->sliders_table} WHERE ID = %d", $id ), ARRAY_A );

		if ($slider) {
			$slider['params'] = $this->decode( $slider['params'] );
		}

		return $slider;
	}

	public function insert_slider( array $slider ) {
		return $this->wpdb->insert(
			$this->sliders_table,
			array(
				'title'    => $slider['title'],
				'theme'    => $slider['theme'],
				'params'   => $this->encode( isset( $slider['params'] ) ? $slider['params'] : array() ),
				'created'  => $this->get_now_date(),
				'modified' => $this->get_now_date(),
			),
			array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			)
		);
	}

	public function get_slides_by_slider_id( $slider_id ) {
		$slides = $this->wpdb->get_results( $this->wpdb->prepare( "SELECT * FROM {$this->slides_table} WHERE slider_id = %d AND status = 'publish' ORDER BY sort ASC", $slider_id ), ARRAY_A );

		$slides = is_array( $slides ) ? $slides : array();

		foreach ( $slides as $index => $slide ) {
			$slides[ $index ]['params'] = $this->decode( $slide['params'] );
			$slides[ $index ]['layers'] = $this->decode( $slide['layers'] );
		}

		return $slides;
	}

	public function delete_slider( $id ) {
		return $this->wpdb->delete( $this->sliders_table, array( 'ID' => $id ) );
	}

	public function insert_slide( array $slide ) {
		return $this->wpdb->insert(
			$this->slides_table,
			array(
				'slider_id' => $slide['slider_id'],
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

	public function delete_slides_by_slider_id( $slider_id ) {
		return $this->wpdb->delete( $this->slides_table, array( 'slider_id' => $slider_id ) );
	}

	public function get_now_date() {
		return current_time( 'Y-m-d' );
	}

	protected function encode( $value ) {
		return json_encode( $value );
	}

	protected function decode( $value ) {
		return json_decode( $value, true );
	}
}