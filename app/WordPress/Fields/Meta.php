<?php

namespace App\WordPress\Fields;

use Underscore\Types\Arrays;

class Meta {

    public static function get($pid) {
        // Retrieve all of the field objects for this post
        $objects = get_field_objects($pid);
        // If no objects were returned then return out
        if (!is_array($objects)) { return []; }
        // Loop through each of the found objects
        foreach ($objects as $name => $object) {
            // If this object does not have sub fields then move along
            if (!isset($object['sub_fields']) || !is_array($object['sub_fields'])) { continue; }
            // Otherwise run this object through the meta child formatter
            $objects[$name]['sub_fields'] = self::meta_child($object['sub_fields']);
        }
        // Return the list of meta objects
        return $objects;
    }


    public static function meta_child($subfields) {
        // A place to stored the filtered object list
        $filtered = [];
        // Loop through each of the provided subfields
        foreach ($subfields as $k => $subfield) {
            // The following are observations and should not be relied on
            // This name is typically used from cloned fields
            if (isset($subfield['__name'])) {
                $name = $subfield['__name'];
            } // This name is typically used for grouped fields
            elseif (isset($subfield['_name'])) {
                $name = $subfield['_name'];
            } // This name is commonly used for non subtask fields
            else { $name = $subfield['name']; }
            // If this field object has sub fields
            if (isset($subfield['sub_fields']) && is_array($subfield['sub_fields'])) {
                // Run the sub fields through the meta child formatter
                $subfield['sub_fields'] = self::meta_child($subfield['sub_fields']);
            }
            // IMPORTANT!
            // Repopulate the filtered collection with the relevant name
            // This is important for matching up field objects with get_fields result
            // Don't ask me why this isn't already done within ACF
            $filtered[$name] = $subfield;
        }
        // Return the filtered list
        return $filtered;
    }

}