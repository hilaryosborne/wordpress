<?php

namespace App\Theme;

class Taxonomy {

  public static function config() {
    $pathname = get_template_directory() . '/config/taxonomy.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Taxonomy::config();
    foreach ($config as $k => $type) {
      register_post_type($type['code'],$type['target'],$type['args']);
    }
  }

}
