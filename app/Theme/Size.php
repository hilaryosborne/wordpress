<?php

namespace App\Theme;

static class Size {

  public static function config() {
    $pathname = dirname(__FILE__) . '/config/size.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Size::config();
    foreach ($config as $k => $size) {
      add_image_size($size['code'], (int)$size['width'], (int)$size['height'], (bool)$size['crop'] );
    }
  }

}
