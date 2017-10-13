<?php

namespace App\WordPress\Theme;

class Partial {

  protected $scope;

  protected $context;

  protected $supported = ['.php','.tmpl.php','.html'];

  public function __construct($scope, $context='') {
    $this->scope = $scope;
    $this->context = $context;
  }

  public function setSupported($list) {
    $this->supported = $list;
  }

  public function getTemplatePath() {
    $filename = $this->context ? $this->scope.'-'.$this->context : $this->scope;
    $template_dir = get_template_directory().'/';
    $filepath = false;
    foreach ($this->supported as $k => $extension) {
      if ($filepath) { continue; }
      $template_path = str_replace('.','/',$template_dir.$filename).$extension;
      if (file_exists($template_path)) {
         $filepath = $template_path;
      }
    }
    if (!$filepath) {
      throw new \Exception('Partial with name '.$filename.' does not exists');
    }
    return $filepath;
  }

  public function get($params) {
    $template_path = $this->getTemplatePath();
    if (!$template_path) { return false; }
    extract($params);
    include $template_path;
  }

}
