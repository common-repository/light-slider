<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Theme_Loader {
	protected static $_instance = null;

	protected $themes = array();

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function register( array $theme ) {
		$this->themes[ $theme['id'] ] = new SLS_Theme( $theme );
	}

	public function get_themes() {
		return $this->themes;
	}

	/**
	 * @param $themeId
	 *
	 * @return SLS_Theme|null
	 */
	public function getTheme( $themeId ) {
		return isset( $this->themes[ $themeId ] ) ? $this->themes[ $themeId ] : null;
	}
}