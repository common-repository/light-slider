<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SLS_Theme {
	protected $id;
	protected $name;
	protected $folder;
	protected $folder_url;

	protected $theme_data;

	public function __construct(array $theme) {
		$this->id = $theme['id'];
		$this->name = $theme['name'];
		$this->folder = $theme['folder'];
		$this->folder_url = $theme['folder_url'];
	}

	public function get_id() {
		return $this->id;
	}

	public function get_name() {
		return $this->name;
	}

	public function get_thumbnail_url() {
		return $this->folder_url . '/' . ( is_file( $this->folder . '/thumbnail.jpg' ) ?  'thumbnail.jpg' : 'thumbnail.png' );
	}

	public function get_data() {
		if (null === $this->theme_data) {
			$this->theme_data = include( $this->folder . '/data.php' );
		}

		return $this->theme_data;
	}

	public function get_style_url() {
		return $this->folder_url . '/style.css';
	}

	public function get_style_path() {
		return $this->folder . '/style.css';
	}

	public function get_admin_template_path() {
		return $this->folder . '/admin-template.php';
	}

	public function get_template_path() {
		return $this->folder . '/template.php';
	}

	public function get_preview_url() {
		$theme_data = $this->get_data();

		return isset( $theme_data['preview_url'] ) ? $theme_data['preview_url'] : '';
	}

	public function get_element_styles() {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		$style_content = $wp_filesystem->get_contents( $this->get_style_path() );

		if ( empty( $style_content ) ) {
			$style_content = file_get_contents( $this->get_style_path() );
		}

		$element_styles = array();

		if ( preg_match_all( '#\.sls-layout-([\w-0-9]+)#i', $style_content, $layout_matches ) ) {
			$element_styles['layout'] = array();

			foreach ( $layout_matches[1] as $index => $style ) {
				$element_styles['layout'][ trim( $layout_matches[0][ $index ], '.' ) ] = $style;
			}
		}

		if ( preg_match_all( '#\.sls-caption-([\w-0-9]+)#i', $style_content, $caption_matches ) ) {
			$element_styles['caption'] = array();

			foreach ( $caption_matches[1] as $index => $style ) {
				$element_styles['caption'][ trim( $caption_matches[0][ $index ], '.' ) ] = $style;
			}
		}

		if ( preg_match_all( '#\.sls-button-([\w-0-9]+)#i', $style_content, $button_matches ) ) {
			$element_styles['button'] = array();

			foreach ( $button_matches[1] as $index => $style ) {
				$element_styles['button'][ trim( $button_matches[0][ $index ], '.' ) ] = $style;
			}
		}

		if ( preg_match_all( '#\.sls-image-([\w-0-9]+)#i', $style_content, $image_matches ) ) {
			$element_styles['image'] = array();

			foreach ( $image_matches[1] as $index => $style ) {
				$element_styles['image'][ trim( $image_matches[0][ $index ], '.' ) ] = $style;
			}
		}

		return $element_styles;
	}
}