<?php

namespace App\Theme;

class Menu {

  public static function config() {
    $pathname = get_template_directory() . '/config/menus.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Menu::config();
    $collection = [];
    foreach ($config as $k => $menu) {
      $collection[$menu['code']] = $menu['label'];
    }
    register_nav_menus($collection);
  }

}
