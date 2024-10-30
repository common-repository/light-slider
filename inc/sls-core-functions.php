<?php

function sls_register_theme(array $theme) {
	sls_instance()->theme_loader()->register($theme);
}

add_action( 'init', 'sls_register_built_in_themes' );
function sls_register_built_in_themes() {
	$themes = array(
		array(
			'id'         => 'basic',
			'name'       => __( 'Basic', 'light-slider' ),
			'folder'     => sls_instance()->plugin_path() . '/themes/basic',
			'folder_url' => sls_instance()->plugin_url() . '/themes/basic',
		),
		array(
			'id'         => 'modern',
			'name'       => __( 'Modern', 'light-slider' ),
			'folder'     => sls_instance()->plugin_path() . '/themes/modern',
			'folder_url' => sls_instance()->plugin_url() . '/themes/modern',
		),
	);

	foreach ( $themes as $theme ) {
		sls_register_theme( $theme );
	}
}