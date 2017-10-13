<?php

namespace App\WordPress\Theme;

class Webpack {

  public static function init() {

    add_action('wp_enqueue_scripts', function(){

      if (is_admin() || !file_exists(get_template_directory() . '/dist/manifest.json')) { return false; }

    	$j_manifest = json_decode(file_get_contents(get_template_directory(). '/dist/manifest.json'),true);

    	if (isset($j_manifest['main']['css'])) {
    		wp_enqueue_style('webpackcss', get_template_directory_uri().'/dist/'.$j_manifest['main']['css']);
    	}

    	if (isset($j_manifest['main']['js'])) {
    		wp_enqueue_script('webpackjs', get_template_directory_uri().'/dist/'.$j_manifest['main']['js'], [], false, true);
    	}

    });

  }

}
