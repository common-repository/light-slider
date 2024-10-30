<?php
/**
 * Plugin Name: Light Slider
 * Plugin URI: http://saturnthemes.com/
 * Description: Light Slider for WordPress
 * Version: 1.0.3
 * Author: SaturnThemes
 * Author URI: http://saturnthemes.com
 * Requires at least: 4.4
 * Tested up to: 4.6
 *
 * Text Domain: light-slider
 * Domain Path: /i18n/languages/
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'SLS_Light_Slider' ) ) {
	class SLS_Light_Slider {
		public $version = '1.0.3';

		protected static $_instance = null;

		public function __construct() {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
		}

		public function init() {
			$this->load_plugin_textdomain();
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		private function define_constants() {
			$this->define( 'SLS_PLUGIN_FILE', __FILE__ );
			$this->define( 'SLS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'SLS_VERSION', $this->version );
		}

		public function includes() {
			include_once( 'inc/class-sls-autoloader.php' );
			include_once( 'inc/class-sls-model.php' );
			include_once( 'inc/class-sls-theme.php' );
			include_once( 'inc/class-sls-theme-loader.php' );
			include_once( 'inc/sls-core-functions.php' );
			include_once( 'inc/sls-widget-functions.php' );
			include_once( 'inc/class-sls-install.php' );
			include_once( 'inc/class-sls-ajax.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-sls-admin.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}
		}

		public function frontend_includes() {
			include_once( 'inc/class-sls-frontend-scripts.php' );
			include_once( 'inc/class-sls-shortcodes.php' );
		}

		public function load_plugin_textdomain() {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'light-slider' );

			load_textdomain( 'light-slider', WP_LANG_DIR . '/light-slider/light-slider-' . $locale . '.mo' );
			load_plugin_textdomain( 'light-slider', false, plugin_basename( dirname( __FILE__ ) ) . '/i18n/languages' );
		}

		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * @return SLS_Theme_Loader
		 */
		public function theme_loader()
		{
			return SLS_Theme_Loader::instance();
		}

		private function init_hooks() {
			register_activation_hook( __FILE__, array( 'SLS_Install', 'install' ) );
			add_action( 'init', array( $this, 'init' ), 0 );
			add_action( 'init', array( 'SLS_Shortcodes', 'init' ) );
		}

		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}
	}
}

function sls_instance() {
	return SLS_Light_Slider::instance();
}

$GLOBALS['sls_instance'] = sls_instance();