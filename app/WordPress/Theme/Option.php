<?php

namespace App\WordPress\Theme;

class Option {

  public static function config() {
    $pathname = get_template_directory() . '/config/options.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Option::config();
    foreach ($config as $k => $option) {
      $built = acf_add_options_page([
        'page_title' => $option['title'],
        'menu_slug' => $option['slug'],
        'redirect' => false
      ]);
      if (isset($option['children']) && is_array($option['children'])) {
  			Option::submenu($option['children'], $built);
  		}
    }
  }

  public static function submenu($collection, $parent) {
    foreach ($collection as $k => $option) {
      $built = acf_add_options_sub_page([
        'page_title' => $option['title'],
        'menu_slug' => $parent['menu_slug'].$option['slug'],
        'parent_slug' => $parent['menu_slug']
      ]);
      if (isset($option['children']) && is_array($option['children'])) {
  			Option::submenu($option['children'], $built);
  		}
  	}
  }

}
