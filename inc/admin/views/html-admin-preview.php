<style>
	html.wp-toolbar {
		padding-top: 0;
	}

	body {
		background: #fff !important;
	}

	#wpadminbar,
	#adminmenuwrap,
	#adminmenuback,
	#wpfooter,
	#screen-meta,
	#screen-meta-links,
	#querylist,
	#wpbody-content > * {
		display: none;
	}

	#wpcontent,
	#wpfooter {
		margin-left: 0 !important;
		padding-left: 0 !important;
		padding-bottom: 0 !important;
	}

	.sls-slider {
		display: block !important;
	}
</style>
<?php
include( $theme->get_template_path() );
?>