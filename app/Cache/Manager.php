<?php

namespace App\Cache;

class Manager {

  public function __construct() {

  }

  public function setDriver($driver) {
    $this->driver = $driver;
  }

}
