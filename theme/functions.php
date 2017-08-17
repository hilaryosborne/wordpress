<?php

function boilerplate_setup() {
  // Hide the admin bar
	show_admin_bar(false);
	// Load the JSON configurations
	boilerplate_register_menus();
	boilerplate_register_sizes();
	boilerplate_register_taxonomy();
	boilerplate_register_types();
  // // Register the required menus
	// register_nav_menus(
	// 	['main' => 'Main Menu']
	// );
  // Add custom image sizes
	// add_image_size( 'xlarge', 1800, 1200, false );
}

function boilerplate_register_types() {

}

function boilerplate_register_menus() {

}

function boilerplate_register_sizes() {

}

function boilerplate_register_taxonomy() {

}

add_action('init', 'boilerplate_setup');


function boilerplate_webpack_setup() {

	if (is_admin() || !file_exists(dirname(__FILE__) . '/dist/manifest.json')) { return false; }

	$j_manifest = json_decode(file_get_contents(dirname(__FILE__) . '/dist/manifest.json'),true);

	if (isset($j_manifest['main']['css'])) {
		wp_enqueue_style('webpackcss', get_template_directory_uri().'/dist/'.$j_manifest['main']['css']);
	}

	if (isset($j_manifest['main']['js'])) {
		wp_enqueue_script('webpackjs', get_template_directory_uri().'/dist/'.$j_manifest['main']['js'], [], false, true);
	}
}

add_action('wp_enqueue_scripts', 'boilerplate_webpack_setup');
