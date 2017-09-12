<?php

namespace App\Cache\Driver;

class FlatFile {

  protected $path;

  public function __construct($pathway) {
    $this->path = $pathway;
  }

  public function save($pathway,$value) {

  }

  public function retrieve($pathway) {

  }

}
