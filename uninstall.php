<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// To uninstall the plugin completely you need to define SLS_UNINSTALL_PLUGIN constant in wp-config.php file
// before deleting it from plugins page
if ( defined( 'SLS_UNINSTALL_PLUGIN' ) ) {

	global $wpdb;

	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "sls_sliders" );
	$wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "sls_slides" );

	// TODO: Remove all roles
}