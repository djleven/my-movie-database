<?php

namespace MyMovieDatabase\Lib\PostTypes;

/**
 * Taxonomy
 *
 * Class for the creation of taxonomies
 *
 * An adaptation based on the work of jjgrainger's PostTypes
 * @link    https://github.com/jjgrainger/PostTypes/
 */
class Taxonomy extends PostTypeEntityAbstract
{
    /**
     * PostTypes to register the Taxonomy to
     * @var array
     */
    public $postTypes = [];

    /**
     * Is the PostTypeEntity registered
     *
     * @return bool
     */
    public function isPostTypeEntityRegistered()
    {
        return taxonomy_exists($this->name);
    }

    /**
     * Register the Taxonomy to WordPress
     *
     * @param $options
     * @return void
     */
    public function wordpressRegistration($options)
    {
        // register the Taxonomy with WordPress
        register_taxonomy($this->name, null, $options);
    }

    /**
     * Assign a PostType to register the Taxonomy to
     *
     * @param  mixed $postTypes
     * @return $this
     */
    public function assignPostTypeToTaxonomy($postTypes)
    {
        $postTypes = is_string($postTypes) ? [$postTypes] : $postTypes;

        foreach ($postTypes as $postType) {
            $this->postTypes[] = $postType;
        }

        return $this;
    }

    /**
     * Register the Taxonomy to PostTypes
     *
     * @return void
     */
    public function registerTaxonomyToPostType()
    {
        // register Taxonomy to each of the PostTypes assigned
        if (!empty($this->postTypes)) {
            foreach ($this->postTypes as $postType) {
                register_taxonomy_for_object_type($this->name, $postType);
            }
        }
    }

    /**
     * Create options for Taxonomy
     *
     * @return array Options to pass to register_taxonomy
     */
    public function createOptions()
    {
        // default options
        $options = [
            'hierarchical' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => [
                'slug' => $this->slug,
            ],
        ];

        $options['labels'] = $this->createLabels();

        // apply overrides
        return array_replace($options, $this->options);
    }
}