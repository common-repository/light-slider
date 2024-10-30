<?php
return array(
	'slider' => array(
		'params' => array(
			'enable_autoplay' => 'yes',
			'layout' => 'full-width',
			'width' => '100%',
			'height' => '400px',
			'autoplay_delay' => 5000,
			'navigation_arrows' => 'yes',
		),
	),
	'slide' => array(
		'layout' => 'style1',
		'sort' => 1,
		'layers' => array(
			'caption' => array(
				'id' => 'caption',
				'name' => __( 'Caption', 'light-slider' ),
				'type' => 'caption',
				'content' => 'Image Caption',
			),
		),
	),
);