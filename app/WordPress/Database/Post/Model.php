<?php

namespace App\WordPress\Database\Post;

use Underscore\Types\Arrays;

class Model {

    public $attributes = [];

    public $fields = [];

    public $updated = [];

    public static $post_type = 'post';

    public static function find($args) {
        if (!is_array($args)) {
            return (new Model())->load($args);
        }
    }

    public function getID() {
        return $this->attributes['ID'];
    }

    public function get_field($path, $default=false) {
        // Retrieve the value
        $value = Arrays::get($this->fields, $path);
        // Return the value or return the default
        return $value ? $value : $default;
    }

    public function set_field($path, $value) {
        // Retrieve all the fields for this object
        $fields = $this->fields;
        $updated = $this->updated;
        // Format the field value
        $formated = field_format($this->getID(), $path, $value);
        // Set the value into the array at the path point
        $this->fields = Arrays::set($fields, $path, $formated);
        $this->updated = Arrays::set($updated, $path, $value);
        return $this;
    }

    public function save() {
        $pid = $this->getID();
        if (!$pid) {
            // Update post fields
            $pid = wp_update_post($this->attributes);
            // Load any attributes
            $this->loadPost($pid);
        }
        // Update and reload the fields
        $this->saveFields()->loadFields();

        return $this;
    }

    public function load($pid) {
        return (new Model())
            ->loadPost($pid)
            ->loadFields();
    }

    public function remove() {

    }

    protected function loadPost($pid) {
        $post = (array)get_post($pid);
        $this->attributes = [];
        foreach ($post as $label => $value) {
            $this->attributes[$label] = $value;
        }
        return $this;
    }

    protected function loadFields() {
        $fields = get_fields($this->getID());
        $this->fields = [];
        foreach ($fields as $code => $value) {
            $this->fields[$code] = get_field($code,$this->getID());
        }
        return $this;
    }

    protected function saveFields() {
        $pid = $this->getID();
        $fields = $this->updated;
        foreach ($fields as $fieldName => $fieldValue) {
            $savedValue = $this->fields[$fieldName];
            if (!$savedValue) {
                delete_field($fieldName, $pid);
            } else {
                $fieldObj = get_field_object($fieldName, $pid);
                update_field($fieldObj['key'], $savedValue, $pid);
            }

        }
        return $this;
    }

}