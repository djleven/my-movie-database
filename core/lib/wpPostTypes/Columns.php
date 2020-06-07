<?php

namespace MyMovieDatabase\Lib\PostTypes;

/**
 * Columns
 *
 * Helper class to manage a post type's columns in the admin table
 *
 * An adaptation based on the work of jjgrainger's PostTypes
 * @link    https://github.com/jjgrainger/PostTypes/
 */
class Columns
{
    /**
     * Holds an array of all the defined columns.
     *
     * @var array
     */
    public $items = [];

    /**
     * An array of columns that are sortable.
     *
     * @var array
     */
    public $sortable = [];

    /**
     * Set the all columns
     *
     * @param array $columns an array of all the columns to replace
     */
    public function set($columns)
    {
        $this->items = $columns;
    }


    /**
     * Set columns that are sortable
     *
     * @param  array $sortable  associative array of column and whether it's sortable
     *
     * @return Columns
     */
    public function sortable($sortable)
    {
        foreach ($sortable as $column => $options) {
            $this->sortable[$column] = $options;
        }

        return $this;
    }

    /**
     * Check if an orderby field is a custom sort option.
     *
     * @param  string $orderby the orderby value from query params
     *
     * @return bool
     */
    public function isSortable($orderby)
    {
        if (is_string($orderby) && array_key_exists($orderby, $this->sortable)) {
            return true;
        }

        foreach ($this->sortable as $column => $options) {
            if (is_string($options) && $options === $orderby) {
                return true;
            }
            if (is_array($options) && isset($options[0]) && $options[0] === $orderby) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get meta key for an orderby.
     *
     * @param  string $orderby the orderby value from query params
     *
     * @return mixed|string
     */
    public function sortableMeta($orderby)
    {
        if (array_key_exists($orderby, $this->sortable)) {
            return $this->sortable[$orderby];
        }

        foreach ($this->sortable as $column => $options) {
            if (is_string($options) && $options === $orderby) {
                return $options;
            }
            if (is_array($options) && isset($options[0]) && $options[0] === $orderby) {
                return $options;
            }
        }

        return '';
    }
}