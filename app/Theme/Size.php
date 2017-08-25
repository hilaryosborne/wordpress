<?php

namespace App\Theme;

class Size {

  public static function config() {
    $pathname = get_template_directory() . '/config/size.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Size::config();
    foreach ($config as $k => $size) {
      add_image_size($size['code'], (int)$size['width'], (int)$size['height'], (bool)$size['crop'] );
    }
  }

}
