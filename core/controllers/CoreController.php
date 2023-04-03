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
use MyMovieDatabase\Lib\PostTypes\Taxonomy;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;
use MyMovieDatabase\Lib\ResourceAPI\GetResourcesEndpoint;

class CoreController {

    /**
     * The resource (data) types made available in the plugin.
     *
     * @since     1.0.0
     * @return    array
     */
    public $available_resource_types;
    /**
     * Active post types as per admin user settings.
     *
     * @since     1.0.0
     * @return    array
     */
    public $active_post_types;

    /**
     * Initialize the class:
     * Set its properties and register the custom post types and taxonomy
     *
     * @since      1.0.0
     */
    public function __construct() {

        $this->available_resource_types = $this->setAdminResourceTypes();
        $this->active_post_types = $this->getActivePostTypes();
        $this->registerCustomPostTypes();
        $this->registerEndpoints();
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

        if (isset($options[$option])) {
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

        $plugin_resource_types = [];
        $plugin_resource_types[] = new MovieResourceType(
			'movie',
			__('Movie', 'my-movie-database'),
			__('Movies', 'my-movie-database'),
			'dashicons-video-alt'
        );
        $plugin_resource_types[] = new TvshowResourceType(
			'tvshow',
			__('TvShow', 'my-movie-database'),
			__('TvShows', 'my-movie-database'),
			'dashicons-welcome-view-site'
        );
        $plugin_resource_types[] = new PersonResourceType(
			'person',
			__('Person', 'my-movie-database'),
			__('Persons', 'my-movie-database'),
			'dashicons-businessman'
        );

        return $plugin_resource_types;
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
     * Register / create custom post types and related taxonomy
     *
     * @since     1.0.0
     */
    private function registerCustomPostTypes() {

        $plugin_resource_types = $this->available_resource_types;
        $custom_post_types = [];
        $custom_taxonomy = [];
        $tax_options = [];
        $i = 0;
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

        foreach($plugin_resource_types as $plugin_resource_type) {
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

                $custom_taxonomy[$i] =
                    new Taxonomy($tax_names, $tax_options);

                $custom_post_types[$i] =
                    new PostType($names, $plugin_resource_type->type_menu_icon, [
                        'show_in_rest' => !$disableGutenberg,
                    ]);
                $custom_post_types[$i]->taxonomy($custom_taxonomy[$i]->name);
                $custom_post_types[$i]->columns()->sortable( [ 'taxonomy-' . $custom_taxonomy[$i]->name => true ] );

                if($wpCategoriesOption !== 'no') {
                    $custom_post_types[$i]->taxonomy(['category', 'post_tag']);
                    $custom_post_types[$i]->columns()->sortable( ['categories' => true, 'tags' => true ] );
                }

                $custom_taxonomy[$i]->registerActions();
                $custom_post_types[$i]->registerActions();

                $i++;

            }
        }
        return;
    }

    /**
     * Register plugin Endpoints with WP API
     *
     * @since     2.1.0
     * @return void
     */
    private function registerEndpoints() {

        new GetResourcesEndpoint();
    }

}

