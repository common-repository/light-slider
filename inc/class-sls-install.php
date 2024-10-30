<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SLS_Install {
	public static function install() {
		self::create_tables();
		self::create_roles();
	}

	private static function create_tables() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( self::get_schema() );
	}

	private static function get_schema() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}

		$tables = "
CREATE TABLE {$wpdb->prefix}sls_sliders (
	ID int(11) NOT NULL AUTO_INCREMENT,
	title  varchar(100) NOT NULL,
	theme  varchar(100) NOT NULL,
	params mediumtext NOT NULL,
	created varchar(11) NOT NULL,
	modified varchar(11) NOT NULL,
	PRIMARY KEY (ID)
) $collate;

CREATE TABLE {$wpdb->prefix}sls_slides (
	ID int(11) NOT NULL AUTO_INCREMENT,
	slider_id int(11) NOT NULL,
	params mediumtext NOT NULL,
	layers mediumtext NOT NULL,
	sort int(11) NOT NULL,
	status varchar(10) NOT NULL DEFAULT 'publish',
	PRIMARY KEY (ID)
) $collate;
		";

		return $tables;
	}

	public static function create_roles() {
		$roles = array( 'administrator', 'editor' );

		foreach ( $roles as $role ) {
			if ( ! $role = get_role( $role ) ) {
				continue;
			}

			$role->add_cap( 'access_light_slider'  );
			$role->add_cap( 'publish_light_slider' );
			$role->add_cap( 'delete_light_slider'  );
			$role->add_cap( 'create_light_slider'  );
			$role->add_cap( 'export_light_slider'  );
			$role->add_cap( 'duplicate_light_slider' );
		}
	}
}