<?php

namespace MyMovieDatabase\Lib\PostTypes;

/**
 * PostTypes
 *
 * Class for the creation of custom post types
 *
 * An adaptation based on the work of jjgrainger's PostTypes
 * @link    https://github.com/jjgrainger/PostTypes/
 */
class PostType extends PostTypeEntityAbstract
{
    /**
     * Taxonomies for the PostType
     * @var array
     */
    public $taxonomies = [];

    /**
     * Taxonomies for the PostType
     * @var array
     */
    public $postTypeTaxonomy;

    /**
     * The menu icon for the PostType
     * @var string
     */
    public $icon;

    /**
     * Create a PostType
     * @param mixed $names          A string for the name, or an array of names
     * @param string $i18nTxtDomain The wp text domain to use for i18n
     * @param string $icon          A dashicon class for the menu icon
     * @param array $options        The options for the PostType
     */
    public function __construct($names, $i18nTxtDomain, $icon = null, $options = [])
    {
        parent::__construct($names, $i18nTxtDomain, $options);

        $this->columns()->sortable( [ 'author' => true ] );

        if($icon) {
            $this->icon = $icon;
        }
    }

    /**
     * Is the PostType registered
     *
     * @return bool
     */
    public function isPostTypeEntityRegistered()
    {
        return post_type_exists($this->name);
    }

    public function wordpressRegistration($options)
    {
        // register the post type with WordPress
        register_post_type($this->name, $options);
    }

    /**
     * Register the PostType to WordPress
     *
     * @return void
     */
    public function registerActions()
    {
        // register the PostType
        add_action('init', [$this, 'registerPostTypeEntity']);

        // register Taxonomies to the PostType
        add_action('init', [$this, 'registerTaxonomies']);

        $this->registerColumns();
    }

    /**
     * Set the names for the PostType
     *
     * @param  mixed $tax_names A string for the taxonomy name, or an array of names
     *
     * @return void
     */
    protected function setTaxonomy($tax_names)
    {
        $this->postTypeTaxonomy = new Taxonomy($tax_names, $this->i18nTxtDomain);
        $this->taxonomy($this->postTypeTaxonomy->name);
    }

    /**
     * Add a Taxonomy to the PostType
     * @param  mixed $taxonomies The Taxonomy name(s) to add
     *
     * @return void
     */
    public function taxonomy($taxonomies)
    {
        $taxonomies = is_string($taxonomies) ? [$taxonomies] : $taxonomies;

        foreach ($taxonomies as $taxonomy) {
            $this->taxonomies[] = $taxonomy;
        }
    }

    /**
     * Create options for PostType
     *
     * @return array Options to pass to register_post_type
     */
    protected function createOptions()
    {
        $options =  [
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'has_archive'        => true,
            'hierarchical'       => true,
            "supports" => [
                "title",
                "editor",
                "author",
                "thumbnail",
                "excerpt",
                "trackbacks",
                "custom-fields",
                "comments",
                "revisions",
                "page-attributes",
                "publicize",
                'wpcom-markdown'
            ],
            'rewrite' => [
                'slug' => $this->slug,
            ]
        ];

        $options['labels'] = $this->createLabels();

        // set the menu icon
        if (!isset($options['menu_icon']) && isset($this->icon)) {
            $options['menu_icon'] = $this->icon;
        }

        // apply overrides
        return array_replace($options, $this->options);
    }

    /**
     * Create the labels for the PostType
     *
     * @return array
     */
    protected function createLabels()
    {
        // default labels
        $common_labels = parent::createLabels();

        return array_merge($common_labels, [
            'view_items' =>  __('View') . ' - ' . $this->plural_i18n,
            'new_item' =>  __('New') . ' - ' . $this->singular_i18n,
            'add_new' => __('Add New', $this->i18nTxtDomain),
            'not_found_in_trash' =>
                __('No ' . $this->plural .' found', $this->i18nTxtDomain) . ' ' . __('in Trash', $this->i18nTxtDomain),
        ]);
    }

    /**
     * Register Taxonomies to the PostType
     * @return void
     */
    public function registerTaxonomies()
    {
        if (!empty($this->taxonomies)) {
            foreach ($this->taxonomies as $taxonomy) {
                register_taxonomy_for_object_type($taxonomy, $this->name);
            }
        }
    }

    /**
     * Set query to sort custom columns
     * @param  \WP_Query $query
     */
    public function sortSortableColumns($query)
    {
        // don't modify the query if we're not in the post type admin
        if (!is_admin() || !($query instanceof \WP_Query) || $query->get('post_type') !== $this->name) {
            return;
        }

        $orderby = $query->get('orderby');

        // if the sorting a custom column
        if ($this->columns()->isSortable($orderby)) {
            // get the custom column options
            $meta = $this->columns()->sortableMeta($orderby);

            // determine type of ordering
            if (is_string($meta)) {
                $meta_key = $meta;
                $meta_value = 'meta_value';
            } else {
                $meta_key = $meta[0];
                $meta_value = 'meta_value_num';
            }

            // set the custom order
            $query->set('meta_key', $meta_key);
            $query->set('orderby', $meta_value);
        }
    }
}