<?php

use Underscore\Types\Arrays;

use App\WordPress\Fields\Manager;

function field_get($id, $path, $default=false) {
    // Return found fields
    return Manager::get($id, $path, $default);
}

function field_set($id, $path, $value) {
    // Return found fields
    return Manager::set($id, $path, $value);
}

function field_format($id, $path, $value=null) {
    // If no value was passed then get the live value
    if (is_null($value)) {
        // Repopulate with the live value
        $value = field_get($id, $path);
    }
    // Return found fields
    return Manager::format($id, $path, $value);
}