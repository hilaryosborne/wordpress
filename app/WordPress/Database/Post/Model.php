<?php

namespace App\WordPress\Database\Post;

use Underscore\Types\Arrays;

class Model {

    /**
     * Post Attributes
     * The list of post object attributes
     * @var array
     */
    public $attributes = [];

    /**
     * ACF Fields List
     * The list of formated list values
     * @var array
     */
    public $fields = [];

    /**
     * Fields To Be Updated
     * This is the list of ACF fields to be updated
     * @var array
     */
    public $updated = [];

    /**
     * Define the post type
     * Could be used in extensions of this class
     * @var string
     */
    public static $post_type = 'post';


    public static function find($args) {
        if (!is_array($args)) {
            return (new Model())->load($args);
        }
    }

    public function getID() {
        // Return the post ID if there is one
        return isset($this->attributes['ID']) ? $this->attributes['ID'] : null;
    }

    public function get_attribute($path, $default=false) {
        // Retrieve the value
        $value = Arrays::get($this->attributes, $path);
        // Return the value or return the default
        return $value ? $value : $default;
    }

    public function set_attribute($path, $value) {
        // If someone is trying to update the post ID
        if ($path === 'ID') { throw new \Exception('Please dont update the post ID'); }
        // Set the attribute list
        $this->attributes = Arrays::set($this->attributes, $path, $value);
        // Return for method chaining
        return $this;
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
        // Retrieve the to be updated fields for this object
        $updated = $this->updated;
        // Format the field value
        $formatted = field_format($this->getID(), $path, $value);
        // Set the formatted value into the fields array
        $this->fields = Arrays::set($fields, $path, $formatted);
        // Set the raw value in the to be updated field list
        $this->updated = Arrays::set($updated, $path, $value);
        // Return for method chaining
        return $this;
    }

    public function remove_field($path) {
        // Call the set field object with a null value
        // This will be picked up in the save fields method
        $this->set_field($path, null);
        // Return for method chaining
        return $this;
    }

    public function save() {
        // Retrieve the current post ID
        $pid = $this->getID();
        // If there is no post ID then create a new post
        if (!$pid) {
            // Update post fields
            $pid = wp_update_post($this->attributes);
            // Load any attributes
            $this->loadPost($pid);
        }
        // Update and reload the fields
        $this->saveFields()->loadFields();
        // Return for method chaining
        return $this;
    }

    public function load($pid) {
        // Return a built instance of the model
        return (new Model())
            // Load the post attributes
            ->loadPost($pid)
            // Load the ACF fields
            ->loadFields();
    }

    public function remove() {
        // If no post ID then throw an exception
        // We can only load fields for an actual post object
        if (!$this->getID()) { throw new \Exception('No post is loaded'); }
        // Delete the post with the loaded post id
        wp_delete_post($this->getID());
        // Return for method chaining
        return $this;
    }

    protected function loadPost($pid) {
        // Attempt to retrieve the post
        $post = (array)get_post($pid);
        // If no post was found then exception
        if (!$post) { throw new \Exception('No post found with ID '.$pid); }
        // Reset the attributes array
        $this->attributes = [];
        // Loop through all of the post attributes
        foreach ($post as $label => $value) {
            // Populate the attributes collection
            $this->attributes[$label] = $value;
        }
        // Return for method chaining
        return $this;
    }

    protected function loadFields() {
        // If no post ID then throw an exception
        // We can only load fields for an actual post object
        if (!$this->getID()) { throw new \Exception('No post is loaded'); }
        // Retrieve all of the fields for this post
        $fields = get_fields($this->getID());
        // Reset the fields collection
        $this->fields = [];
        // If no fields were found then return out
        if (!$fields || !is_array($fields)) { return $this; }
        // Loop through all of the fields found
        foreach ($fields as $code => $value) {
            // Populate the field with the formatted value of the field
            $this->fields[$code] = get_field($code,$this->getID());
        }
        // Return for method chaining
        return $this;
    }

    protected function saveFields() {
        // If no post ID then throw an exception
        // We can only load fields for an actual post object
        if (!$this->getID()) { throw new \Exception('No post is loaded'); }
        // Retrieve the post id for this post
        $pid = $this->getID();
        // Retrieve the updated fields list
        $update = $this->updated;
        // If there are no fields to be updated then return out
        if (!$update || !is_array($update) || count($update) === 0) { return $this; }
        // Loop through each of the fields to be updated
        foreach ($update as $name => $value) {
            // If the value has been set to null
            if (!$value) {
                // Delete the ACF field from the post
                delete_field($name, $pid);
            } // Otherwise if the field has a value
            else {
                // Retrieve the field object
                $object = get_field_object($name, $pid);
                // Update the field meta value
                update_field($object['key'], $value, $pid);
            }
        }
        // Return for method chaining
        return $this;
    }

}