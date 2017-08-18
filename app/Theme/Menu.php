<?php

namespace App\Theme;

static class Menu {

  public static function config() {
    $pathname = dirname(__FILE__) . '/config/menus.json';
    return is_file($pathname) ? json_decode(file_get_contents($pathname), true) : [] ;
  }

  public static function init() {
    $config = Menu::config();
    $collection = [];
    foreach ($config as $k => $menu) {
      $collection[$menu['code']] => $menu['label'];
    }
    register_nav_menus($collection);
  }

}
