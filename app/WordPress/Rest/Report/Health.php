<?php

namespace App\WordPress\Rest\Report;

class Health {

  public static function init() {
    add_action('rest_api_init', '\App\WordPress\Rest\Report\Health::register');
  }

  public static function register() {
    register_rest_route('report','/health',[
      'methods' => 'GET',
      'callback' => '\App\WordPress\Rest\Report\Health::render',
    ]);
  }

  public static function render($data) {
    return new \WP_REST_Response(['result' => 'Ok']);
  }

}
