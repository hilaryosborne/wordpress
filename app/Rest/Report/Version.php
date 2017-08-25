<?php

namespace App\Rest\Report;

class Version {

  public static function init() {
    add_action('rest_api_init', 'Health::register');
  }

  public static function register() {
    register_rest_route('report','/version',[
      'methods' => 'GET',
      'callback' => 'Version::render',
    ]);
  }

  public static function render($data) {
    return new \WP_REST_Response(['result' => 'Ok']);
  }

}
