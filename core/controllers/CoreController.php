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
namespace MyMovieDatabase\Controllers;

use MyMovieDatabase\Constants;
use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Lib\PostTypes\PostType;
use MyMovieDatabase\Lib\LanguageManager;
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
     * An instance of the LanguageManager class to handle all things i18n textdomain related.
     *
     * @since    3.0.2
     * @access   public
     * @var      LanguageManager    $languageManager
     */
    public $languageManager;

    /**
     * Initialize the class:
     * Set its properties and register the custom post types and taxonomy
     *
     * @since      1.0.0
     */
    public function __construct($advancedSettings) {
        $this->languageManager = new LanguageManager();
        $this->advancedSettings = $advancedSettings;
        $this->available_resource_types = $this->getAdminResourceTypes();
        $this->active_post_types = $this->getActivePostTypes();
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
            'init' => 'set_custom_post_types',
        ];
    }

    /**
     * Instantiate and return all the tmdb resource (data) types that will be (potentially) available to use ex: tvhows and movies.
     *
     * @since     1.0.0
     * @return    array
     */
    private function getAdminResourceTypes() {

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
    public function set_custom_post_types() {

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
            $plugin_resource_type->setDefaultLabels();
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

	            if($hierarchicalTaxonomy === Constants::OPTION_STRING_VALUE_TRUE ) {
		            $tax_names['singular'] = $plugin_resource_type->getI18nDefaultCategoryLabel();
                    $tax_names['plural'] = $plugin_resource_type->getI18nDefaultPluralCategoryLabel();
	            } else {
		            $tax_names['singular'] = $plugin_resource_type->getI18nDefaultTagLabel();
                    $tax_names['plural'] = $plugin_resource_type->getI18nDefaultPluralTagLabel();
				}

                $custom_post_type =
                    new PostType($names, $plugin_resource_type->type_menu_icon, [
                        'show_in_rest' => !$disableGutenberg,
                    ]);
                $custom_post_type->setTaxonomy($tax_names, $tax_options);

                if($wpCategoriesOption !== Constants::OPTION_STRING_VALUE_FALSE) {
                    $custom_post_type->assignTaxonomyToPostType(['category', 'post_tag']);
                }

                $custom_post_type->postTypeTaxonomy->registerPosTypeEntity();
                $custom_post_type->registerPosTypeEntity();
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

