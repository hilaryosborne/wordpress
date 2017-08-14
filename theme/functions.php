<?php

function boilerplate_setup() {
  // Hide the admin bar
	show_admin_bar(false);
  // Register the required menus
	register_nav_menus(
		['main' => 'Main Menu']
	);
  // Add custom image sizes
	// add_image_size( 'xlarge', 1800, 1200, false );
}

add_action('init', 'boilerplate_setup');


function boilerplate_webpack_setup() {

	if (is_admin() || !file_exists(dirname(__FILE__) . '/dist/manifest.json')) { return false; }

	$j_manifest = json_decode(file_get_contents(dirname(__FILE__) . '/dist/manifest.json'),true);

	if (isset($j_manifest['main']['css'])) {
		wp_enqueue_style('webpackcss', home_url().$j_manifest['main']['css']);
	}

	if (isset($j_manifest['main']['js'])) {
		wp_enqueue_script('webpackjs', home_url().$j_manifest['main']['js'], [], false, true);
	}
}

add_action('wp_enqueue_scripts', 'boilerplate_webpack_setup');
