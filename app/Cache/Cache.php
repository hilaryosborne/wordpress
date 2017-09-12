<?php

namespace App\Cache;

class Cache {

  public static function init($driver) {
    return (new Manager())->setDriver($driver);
  }

}
