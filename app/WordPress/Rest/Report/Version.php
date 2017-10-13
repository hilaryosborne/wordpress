<?php

namespace App\WordPress\Rest\Report;

class Version {

  public static function init() {
    add_action('rest_api_init', '\App\WordPress\Rest\Report\Version::register');
  }

  public static function register() {
    register_rest_route('report','/version',[
      'methods' => 'GET',
      'callback' => '\App\WordPress\Rest\Report\Version::render',
    ]);
  }

  public static function render($data) {
    return new \WP_REST_Response(['result' => 'Ok']);
  }

}
