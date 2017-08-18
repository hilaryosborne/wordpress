<?php

namespace App\Theme;

static class Options {

  public static function config() {
    $pathname = dirname(__FILE__) . '/config/options.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Options::config();
    foreach ($config as $k => $option) {
      $built = acf_add_options_page([
        'page_title' => $option['title'],
        'menu_slug' => $option['slug'],
        'redirect' => false
      ]);
      if ($built['children'] && is_array($built['children'])) {
  			Options::submenu($built['children'], $built);
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
      if ($built['children'] && is_array($built['children'])) {
  			Options::submenu($built['children'], $built);
  		}
  	}
  }

}
