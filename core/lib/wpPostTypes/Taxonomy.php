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
    public $posttypes = [];

    /**
     * Register the Taxonomy to WordPress
     *
     * @return void
     */
    public function registerActions()
    {
        // register the taxonomy, set priority to 9
        // so taxonomies are registered before PostTypes
        add_action('init', [$this, 'registerPostTypeEntity'], 9);

        // assign taxonomy to post type objects
        add_action('init', [$this, 'registerTaxonomyToObjects']);
    }

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
     * @param  mixed $posttypes
     * @return $this
     */
    public function posttype($posttypes)
    {
        $posttypes = is_string($posttypes) ? [$posttypes] : $posttypes;

        foreach ($posttypes as $posttype) {
            $this->posttypes[] = $posttype;
        }

        return $this;
    }

    /**
     * Register the Taxonomy to PostTypes
     *
     * @return void
     */
    public function registerTaxonomyToObjects()
    {
        // register Taxonomy to each of the PostTypes assigned
        if (!empty($this->posttypes)) {
            foreach ($this->posttypes as $posttype) {
                register_taxonomy_for_object_type($this->name, $posttype);
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
            'rewrite' => [
                'slug' => $this->slug,
            ],
        ];

        $options['labels'] = $this->createLabels();

        // apply overrides
        return array_replace($options, $this->options);
    }
}