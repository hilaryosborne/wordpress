<?php

namespace App\WordPress\Session;

class Flashbag {

  public static function startup() {
    add_action('init','App\WordPress\Session\Flashbag::init');
    add_action('wp_footer','App\WordPress\Session\Flashbag::shutdown');
  }

  public static function init() {
    if (!session_id()) { session_start(); }
    if (!isset($_SESSION['flashbag']) || !is_array($_SESSION['flashbag'])) {
        $_SESSION['flashbag'] = [];
    }
  }

  public static function shutdown() {
    $_SESSION['flashbag'] = [];
  }

  public static function set($path, $value) {
    $_SESSION['flashbag'][$path] = $value;
  }

  public static function get($path, $default=false) {
    return isset($_SESSION['flashbag'][$path]) ? $_SESSION['flashbag'][$path] : $default;
  }

}
