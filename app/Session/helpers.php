<?php

function flashbag() {
  return (new \App\Flashbag());
}

function flashbag_set($path, $value) {
  return flashbag()::set($path, $value);
}

function flashbag_get($path, $default=false) {
  return flashbag()::get($path,$default);
}
