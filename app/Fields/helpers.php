<?php

use Underscore\Types\Arrays;

function field_get($id, $path=false, $default=false) {
    // Retrieve the value
    $value = Arrays::get(get_fields($id), $path);
    // Return the value or return the default
    return $value ? $value : $default;
}

function field_set($id, $path, $value) {
    // Retrieve all the fields for this object
    $fields = get_fields($id);
    // Explode the provided path
    $exploded = explode('.', $path);
    // If there are no resulting elements
    if (!is_array($exploded) || count($exploded) === 0) { return $fields; }
    // Retrieve the root element
    $root = $exploded[0];
    // If the field does not exist then fail out silently
    if (!isset($fields[$root])) { return $fields; }
    // If there is only one key
    if (count($exploded) <= 1) {
        // Set the key outright
        $fields[$root] = $value;
    } // Otherwise this is a nested pathway
    else {
        // Remove the root key
        $subpath = substr($path,strlen($exploded[0])+1);
        // Set the value into the array at the path point
        $value = Arrays::set($fields[$root], $subpath, $value);
        // Update the fields array
        $fields[$root] = $value;
    }
    // Update the acf field value
    update_field($root, $fields[$root], $id);
    // Return the fields for meh reasons
    return $fields;
}