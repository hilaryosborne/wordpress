<?php

use App\Theme\{Webpack,Size,Menu,Option,Taxonomy,Types};
use App\Rest\Report\{Health,Version};
use App\Session\{Flashbag};
use App\Cache\{Cache};
use App\Cache\Driver\{FlatFile};

function boilerplate_setup() {
  // Hide the admin bar
	show_admin_bar(false);
	// Load the JSON configurations
	Webpack::init();
	// Session
	Flashbag::startup();
	// Caching
	Cache::init(new FlatFile('cache'));
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
