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

use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Lib\PostTypes\PostType;

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;
use MyMovieDatabase\Lib\ResourceAPI\GetResourcesEndpoint;

// docs
use MyMovieDatabase\Lib\ResourceTypes\AbstractResourceType;
use MyMovieDatabase\Lib\ResourceAPI\AbstractEndpoint;

class CoreController implements ActionHookSubscriberInterface {

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
     * An instance of the options helper class loaded with the advanced setting values.
     *
     * @since    3.0.0
     * @access   protected
     * @var      OptionsGroup    $advancedSettings
     */
    protected $advancedSettings;

    /**
     * Initialize the class:
     * Set its properties and register the custom post types and taxonomy
     *
     * @since      1.0.0
     */
    public function __construct($advancedSettings) {
        $this->advancedSettings = $advancedSettings;
        $this->available_resource_types = $this->setAdminResourceTypes();
        $this->active_post_types = $this->getActivePostTypes();
        $this->setCustomPostTypes();
        $this->setEndpoints();
    }

    /**
     * Get the action hooks to be registered related to the core functionality.
     *
     * @since    3.0.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'plugins_loaded' => 'load_plugin_textdomain',
        ];
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            Constants::PLUGIN_NAME_DASHES,
            false,
            Constants::PLUGIN_NAME_DASHES . '/languages'
        );
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

            $setting = $this->advancedSettings->getOption(
                $plugin_resource_type->post_type_advanced_setting_key,
                $plugin_resource_type->data_type
            );
            if ($setting != 'no_post') {

                if (substr($setting, 0, 5) === 'posts') {
                    $active_post_types[] = 'post';
                } else {
                    $active_post_types[] = $setting;
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
        $disableGutenberg = $this->advancedSettings->getOption(
            Constants::ADV_OPTION_GUTENBERG_DISABLE,
            false
        );
        $wpCategoriesOption = $this->advancedSettings->getOption(
            Constants::ADV_OPTION_WP_CATEGORIES,
            Constants::OPTION_STRING_VALUE_TRUE
        );
        $hierarchicalTaxonomy = $this->advancedSettings->getOption(
            Constants::ADV_OPTION_TAXONOMY_TYPE,
            Constants::OPTION_STRING_VALUE_TRUE
        );
        if($hierarchicalTaxonomy !== Constants::OPTION_STRING_VALUE_TRUE) {
            $tax_options = [
                'hierarchical' => false,
            ];
        }

        foreach($this->available_resource_types as $plugin_resource_type) {
            $setting = $this->advancedSettings->getOption(
                $plugin_resource_type->post_type_advanced_setting_key,
                $plugin_resource_type->data_type
            );
            if ($setting == $plugin_resource_type->data_type) {

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
			            /* translators: %s: Custom post type category (taxonomy) name: ex Movie, Tv Show or Person Category*/
			            sprintf( __( '%s Category', 'my-movie-database' ), $plugin_resource_type->data_type_label );
                    $tax_names['plural'] =
	                    /* translators: %s: Plural custom post type category (taxonomy) name: ex Movie, Tv Show or Person Categories*/
	                    sprintf( __( '%s Categories', 'my-movie-database' ), $plugin_resource_type->data_type_label );
	            } else {
		            $tax_names['singular'] =
	                    /* translators: %s: Custom post type tag (taxonomy) name: ex Movie, Tv Show or Person Tag */
			            sprintf(__('%s Tag', 'my-movie-database'), $plugin_resource_type->data_type_label);
                    $tax_names['plural'] =
	                    /* translators: %s: Plural custom post type tag (taxonomy) name: ex Movie, Tv Show or Person Tags*/
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
        $api_key = $this->advancedSettings->getOption(
            Constants::ADV_OPTION_API_KEY,
            'c8df48be0b9d3f1ed59ee365855e663a'
        );

        $this->endpoints = [
            new GetResourcesEndpoint($api_key)
        ];
    }
}

