<?php

namespace MyMovieDatabase\Lib\PostTypes;

use MyMovieDatabase\I18nConstants;

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
     * @var Taxonomy
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
     * Note about WP get_default_labels() (at wp-app/wp-includes/class-wp-post-type.php)
     * WordPress seems to use the Page instead of Post type translations for (undefined) custom post type labels
     *
     * So defining most of them here explicitly because we want the 'post' label defaults
     *
     * @return array
     */
    protected function createLabels()
    {
        // default labels
        $common_labels = parent::createLabels();
        $labels = I18nConstants::I18n_CORE_POST_TYPE_LABELS;

        return array_merge( $common_labels, [
            'add_new'                  => _x( $labels['Add New'], 'post'),
            'not_found'                => __( $labels['No posts found.']),
            'not_found_in_trash'       => __( $labels['No posts found in Trash.']),
            'add_new_item'             => __( $labels['Add New Post']),
            'edit_item'                => __( $labels['Edit Post']),
            'new_item'                 => __( $labels['New Post']),
            'view_item'                => __( $labels['View Post']),
            'view_items'               => __( $labels['View Posts']),
            'search_items'             => __( $labels['Search Posts']),
            'archives'                 => __( $labels['Post Archives']),
            'attributes'               => __( $labels['Post Attributes']),
            'insert_into_item'         => __( $labels['Insert into post']),
            'uploaded_to_this_item'    => __( $labels['Uploaded to this post']),
            'featured_image'           => _x( $labels['Featured image'], 'post' ),
            'set_featured_image'       => _x( $labels['Set featured image'], 'post' ),
            'remove_featured_image'    => _x( $labels['Remove featured image'], 'post' ),
            'use_featured_image'       => _x( $labels['Use as featured image'], 'post' ),
            'filter_items_list'        => __( $labels['Filter posts list']),
            'items_list_navigation'    => __( $labels['Posts list navigation']),
            'items_list'               => __( $labels['Posts list']),
            'item_published'           => __( $labels['Post published.']),
            'item_published_privately' => __( $labels['Post published privately.']),
            'item_reverted_to_draft'   => __( $labels['Post reverted to draft.']),
            'item_scheduled'           => __( $labels['Post scheduled.']),
            'item_updated'             => __( $labels['Post updated.']),
            'item_link'                => array(
                _x( $labels['Post Link'], 'navigation link block title' ),
            ),
            'item_link_description'    => array(
                _x( $labels['A link to a post.'], 'navigation link block description' ),
            ),
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