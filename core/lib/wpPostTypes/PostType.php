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
     * Taxonomies associated to the PostType
     * @var array
     */
    public $taxonomies = [];

    /**
     * The PostType taxonomy
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
     *
     * @param mixed $names          A string for the name, or an array of names
     * @param string $icon          A dashicon class for the menu icon
     * @param array $options        The options for the PostType
     */
    public function __construct($names, $icon = null, $options = [])
    {
        parent::__construct($names, $options);

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
     * Create and add a Taxonomy to the PostType
     *
     * @param mixed $tax_names A string for the taxonomy name, or an array of names
     * @param array $options The options for the Taxonomy
     *
     * @return void
     */
    public function setTaxonomy( $tax_names, $options = [] )
    {
        $this->postTypeTaxonomy = new Taxonomy( $tax_names, $options );
        $this->assignTaxonomyToPostType( $this->postTypeTaxonomy->name );
    }

    /**
     * Assign a Taxonomy to the PostType
     *
     * @param mixed $taxonomies The Taxonomy name(s) to add
     *
     * @return void
     */
    public function assignTaxonomyToPostType( $taxonomies )
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
            'show_in_rest'       => false,
            "supports"           => [
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
            'rewrite'            => [
                'slug' => $this->slug,
            ]
        ];

        $options['labels'] = $this->createLabels();

        // set the menu icon
        if (!isset($options['menu_icon']) && isset($this->icon) ) {
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

        return array_merge( $common_labels, [
            'add_new_item'       => __( 'Add New' ) . ' - ' . $this->singular,
            'edit_item'          => __( 'Edit' ) . ' - ' . $this->singular,
            'view_item'          => __( 'View' ) . ' - ' . $this->singular,
            'search_items'       => __( 'Search' ) . ' - ' . $this->plural,
            'view_items'         => __( 'View' ) . ' - ' . $this->plural,
            'new_item'           => __( 'New' ) . ' - ' . $this->singular,
            'not_found_in_trash' =>
            /* translators: Custom post type taxonomy (category or tag) plural name. Movies, tvShows or persons. 'No %s found in Trash' */
                sprintf( __( 'No %s found in Trash', 'my-movie-database' ), $this->plural ),
        ] );
    }

    /**
     * Register Taxonomies to the PostType
     * @return void
     */
    public function registerTaxonomyToPostType()
    {
        if (!empty($this->taxonomies)) {
            foreach ($this->taxonomies as $taxonomy) {
                register_taxonomy_for_object_type($taxonomy, $this->name);
            }
        }
    }
}