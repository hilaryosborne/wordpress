<?php

namespace App\WordPress\Fields;

use Underscore\Types\Arrays;

class Manager {

    public static function get($id, $path=false, $default=false) {
        // Retrieve the value
        $value = Arrays::get(get_fields($id), $path);
        // Return the value or return the default
        return $value ? $value : $default;
    }

    public static function set($id, $path, $value) {
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

    public static function format($id, $path, $value) {
        // THIS NEEDS REGEX WORK!
        $filtered = preg_replace("/(\.[0-9]+\.)/", ".",$path);
        $filtered = preg_replace("/(\.[0-9]+)/", "",$filtered);
        $filtered = preg_replace("/([0-9]+\.)/", "",$filtered);
        // Replace all dots with subfields
        // Child field objects are stored within subfields
        $prepared = str_replace('.','.sub_fields.', $filtered);
        // Attempt to retrieve the field object
        $object = Arrays::get(Meta::get($id), $prepared);
        // If no object was found then return the provided variables
        // Do this incase fields have been moved or removed
        if (!$object) { return $value; }
        // Rebuild the acf cache key
        // This cache key is directly from ACF
        $cache_key = "format_value/post_id={$id}/name={$object['name']}";
        // Apply ACF filters
        // These filters are directly from ACF
        $value = apply_filters( "acf/format_value", $value, $id, $object );
        $value = apply_filters( "acf/format_value/type={$object['type']}", $value, $id, $object );
        $value = apply_filters( "acf/format_value/name={$object['_name']}", $value, $id, $object );
        $value = apply_filters( "acf/format_value/key={$object['key']}", $value, $id, $object );
        // update cache
        acf_set_cache($cache_key, $value);
        // Return the filtered value
        return $value;
    }

}