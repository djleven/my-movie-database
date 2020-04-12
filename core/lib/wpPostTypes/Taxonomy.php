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

    /**
     * Create labels for the Taxonomy
     * @return array
     */
    public function createLabels()
    {
        // default labels
        $common_labels = parent::createLabels();

       return array_merge($common_labels, [
            'update_item' => __('Update') . ' - ' . __($this->singular, MMDB_WP_NAME),
            'new_item_name' => __('New') . ' ' .  __('Name') . ' - ' . __($this->singular, MMDB_WP_NAME),
            'parent_item' => __('Parent'). ' - ' . __($this->singular, MMDB_WP_NAME),

            'popular_items' => __('Popular ' . $this->plural, MMDB_WP_NAME),
            'separate_items_with_commas' => __('Separate ' . $this->plural . ' with commas', MMDB_WP_NAME),
            'add_or_remove_items' => __('Add or remove') . ' ' . $this->plural,
        ]);
    }
}