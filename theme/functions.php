<?php

use App\Theme\{Webpack,Size,Menu,Option,Taxonomy,Types};
use App\Rest\Report\{Health,Version};
use App\Session\{Flashbag}

function boilerplate_setup() {
  // Hide the admin bar
	show_admin_bar(false);
	// Load the JSON configurations
	Webpack::init();
	// Session
	Flashbag::startup();
	// Configuration
	Size::init();
	Menu::init();
	Option::init();
	Taxonomy::init();
	Types::init();
	// Rest Endpoints
	Health::init();
	Version::init();
}

add_action('init', 'boilerplate_setup');
