<?php
/**
 * Defines and orchestrates the core functionality of the plugin.
 *
 * @link       https://e-leven.net/
 * @since      2.0.2 (references to versions before 2.0.2 refer to split from AdminController)
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/controllers
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Lib\PostTypes\PostType;

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;
use MyMovieDatabase\Lib\ResourceAPI\GetResourcesEndpoint;

// docs
use MyMovieDatabase\Lib\ResourceTypes\AbstractResourceType;
use MyMovieDatabase\Lib\ResourceAPI\AbstractEndpoint;

class CoreController {

    /**
     * The resource (data) types made available in the plugin.
     *
     * @since     1.0.0
     * @var    AbstractResourceType[]
     */
    public $available_resource_types;

    /**
     * Active post types as per admin user settings.
     *
     * @since     1.0.0
     * @var    array
     */
    public $active_post_types;

    /**
     * The plugin custom post types
     * @var PostType[]
     */
    public $post_types = [];

    /**
     * Plugin API endpoints.
     *
     * @var AbstractEndpoint[]
     * @since     3.0.0
     */
    public $endpoints;

    /**
     * Initialize the class:
     * Set its properties and register the custom post types and taxonomy
     *
     * @since      1.0.0
     */
    public function __construct() {
        $this->available_resource_types = $this->setAdminResourceTypes();
        $this->active_post_types = $this->getActivePostTypes();
        $this->setCustomPostTypes();
        $this->setEndpoints();
    }

    /**
     * Static method to get plugin options set by admin user.
     *
     * @since      0.7.0
     * @param      string $option  setting option key
     * @param      string $section setting option section
     * @param      string $default default value
     * @return     mixed
     */
    public static function getMmdbOption($option, $section, $default = '') {

        $options = get_option($section);

        if (isset($options[$option]) && $options[$option] !== '') {
            return $options[$option];
        }
        return $default;
    }

    /**
     * Instantiate and return all the tmdb resource (data) types that will be (potentially) available to use ex: tvhows and movies.
     *
     * @since     1.0.0
     * @return    array
     */
    private function setAdminResourceTypes() {

        return [
            new MovieResourceType(),
            new TvshowResourceType(),
            new PersonResourceType()
        ];
    }

    /**
     * Get the active data type names as set in admin settings (ex: tvshow and post).
     *
     * @since     1.0.0
     * @return    array
     */
    private function getActivePostTypes()
    {

        $active_post_types = [];
        $plugin_resource_types = $this->available_resource_types;

        foreach ($plugin_resource_types as $plugin_resource_type) {

            if ($plugin_resource_type->getPostTypeSetting() != 'no_post') {

                if (substr($plugin_resource_type->getPostTypeSetting(), 0, 5) === 'posts') {
                    $active_post_types[] = 'post';
                } else {
                    $active_post_types[] = $plugin_resource_type->getPostTypeSetting();
                }

            }
        }
        return $active_post_types;
    }

    /**
     * Create custom post types and related taxonomy
     *
     * @since     1.0.0
     */
    private function setCustomPostTypes() {

        $tax_options = [];
        $disableGutenberg = self::getMmdbOption(
            'mmdb_disable_gutenberg_post_type',
            MMDB_ADVANCED_OPTION_GROUP,
            false
        );
        $wpCategoriesOption = self::getMmdbOption(
            'mmdb_wp_categories',
            MMDB_ADVANCED_OPTION_GROUP,
            'yes'
        );
        $hierarchicalTaxonomy = self::getMmdbOption(
            'mmdb_hierarchical_taxonomy',
            MMDB_ADVANCED_OPTION_GROUP,
            'yes'
        );
        if($hierarchicalTaxonomy !== 'yes') {
            $tax_options = [
                'hierarchical' => false,
            ];
        }

        foreach($this->available_resource_types as $plugin_resource_type) {
            if ($plugin_resource_type->getPostTypeSetting() == $plugin_resource_type->data_type) {

                $names = [
                    'name' => $plugin_resource_type->data_type,
                    'singular' => $plugin_resource_type->data_type_label,
                    'plural' => $plugin_resource_type->data_type_label_plural,
                    'slug' => $plugin_resource_type->data_type,
                ];

                $tax_names = [
                    'name' => $plugin_resource_type->data_type . '-category',
                    'slug' => $plugin_resource_type->data_type . '-categories',
                ];

	            if($hierarchicalTaxonomy === 'yes') {
		            $tax_names['singular'] =
			            /* translators: Custom post type hierarchical taxonomy (category) name. Movie, TvShow or Person. '%s Category' */
			            sprintf( __( '%s Category', 'my-movie-database' ), $plugin_resource_type->data_type_label );
                    $tax_names['plural'] =
	                    /* translators: Custom post type hierarchical taxonomy (category) plural name. Movie, TvShow or Person. '%s Categories' */
	                    sprintf( __( '%s Categories', 'my-movie-database' ), $plugin_resource_type->data_type_label );
	            } else {
		            $tax_names['singular'] =
			            /* translators: Custom post type non-hierarchical taxonomy (tag) name. Movie, TvShow or Person. '%s Tag' */
			            sprintf(__('%s Tag', 'my-movie-database'), $plugin_resource_type->data_type_label);
                    $tax_names['plural'] =
	                    /* translators: Custom post type non-hierarchical taxonomy (tag) plural name. Movie, TvShow or Person. '%s Tags' */
	                    sprintf(__('%s Tags', 'my-movie-database'), $plugin_resource_type->data_type_label);
				}

                $custom_post_type =
                    new PostType($names, $plugin_resource_type->type_menu_icon, [
                        'show_in_rest' => !$disableGutenberg,
                    ]);
                $custom_post_type->setTaxonomy($tax_names, $tax_options);

                if($wpCategoriesOption !== 'no') {
                    $custom_post_type->assignTaxonomyToPostType(['category', 'post_tag']);
                }

                $this->post_types[] = $custom_post_type;
            }
        }
    }

    /**
     * Set plugin core endpoints
     *
     * @since     2.1.0
     * @return void
     */
    private function setEndpoints() {
        $this->endpoints = [
            new GetResourcesEndpoint()
        ];
    }
}

