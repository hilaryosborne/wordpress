<?php

namespace App\Theme;

static class Taxonomy {

  public static function config() {
    $pathname = dirname(__FILE__) . '/config/taxonomy.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Taxonomy::config();
    foreach ($config as $k => $type) {
      register_post_type($type['code'],$type['target'],$type['args']);
    }
  }

}
