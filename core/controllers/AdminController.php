<?php
/**
 * Defines and orchestrates the admin-specific functionality of the plugin.
 *
 * Plugin Convention:
 * Methods in underscore naming represent registered wordpress hook callbacks
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/controllers
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Controllers;

use MyMovieDatabase\Admin\ActivationStateChanges;
use MyMovieDatabase\Admin\EditPostType;
use MyMovieDatabase\Admin\PostMetaBox;
use MyMovieDatabase\Admin\Settings;
use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Constants;

class AdminController implements ActionHookSubscriberInterface {

    /**
     * The resource (data) types made available in the plugin.
     *
     * @return    array
     * @since     1.0.0
     */
    private $available_resource_types;

    /**
     * Active post types as per admin user settings.
     *
     * @since     1.0.0
     * @return    array
     */
    public $active_post_types;

    /**
     * Class object that handles the plugin activation state changes
     *
     * @return    ActivationStateChanges
     * @since     2.5.0
     */
    public $activation_state_changes;
    /**
     * Class object that defines the option page settings functionality
     *
     * @return    Settings
     * @since     2.5.0
     */
    public $settings;

    /**
     * Class object that handles the MMDB admin metaboxes for the active post types
     *
     * @since     2.5.0
     * @var    PostMetaBox     $post_meta_box
     */
    public $post_meta_box;

    /**
     * Class object that conditionally edits / modifies wp post type
     *
     * @return    EditPostType
     * @since     2.5.0
     */
    public $edit_post_type = null;

    /**
     * An instance of the options helper class loaded with the advanced setting values.
     *
     * @since    3.0.0
     * @access   protected
     * @var      OptionsGroup $advancedSettings
     */
    protected $advancedSettings;

    /**
     * Initialize the class and set its properties.
     *
     * @param      array | null       $available_resource_types
     * @param      array | null       $active_post_types
     * @param      OptionsGroup       $advancedSettings OptionsGroup class with the advanced setting values
     *
     * @since      1.0.0
     */
    public function __construct( $advancedSettings, $available_resource_types = null, $active_post_types = null ) {
        $this->advancedSettings         = $advancedSettings;
        $this->activation_state_changes = new ActivationStateChanges();
        $this->available_resource_types = $available_resource_types;
        $this->active_post_types        = $active_post_types;
        $this->setEditWpPosts();
        if ( $this->available_resource_types ) {
            $this->setAdminSettings();
        } else {
            $this->setPostMetaBoxes();
        }
    }

    /**
     * Get the action hooks to be registered related to the admin-facing functionality.
     *
     * Enqueue scripts
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions() {
        return  [
            'admin_menu' => 'admin_menu',
        ];
    }

    /**
     * Instantiate the class that defines the option page settings functionality for the plugin
     *
     * @since     1.0.0
     */

    private function setAdminSettings() {
        $this->settings = new Settings( $this->available_resource_types );
    }

    /**
     * Handle the MMDB metaboxes for the active post types
     *
     * @since     1.0.0
     */
    private function setPostMetaBoxes() {
        $this->post_meta_box = new PostMetaBox(
            $this->active_post_types,
            $this->advancedSettings
        );
    }

    public function admin_menu() {
        add_options_page(
            'The Movie Database for WP Options',
            'My Movie Database',
            'manage_options',
            'mmdb_settings',
            [ $this->settings, 'plugin_page' ]
        );
    }

    /**
     * Check settings whether default wp post type should be edited / modified or not
     *
     * @return    boolean
     * @since     1.0.0
     */
    private function hasEditWpPostsSetting() {
        $setting = $this->advancedSettings->getOption(
            Constants::ADV_OPTION_POST_TYPE_MOVIE,
            MovieResourceType::DATA_TYPE_NAME
        );

        return $setting == 'posts_custom';
    }

    /**
     * Instantiate class that edits / modifies wp post type if settings permit
     *
     * @since     1.0.0
     */
    private function setEditWpPosts() {

        if ( $this->hasEditWpPostsSetting() ) {

            $this->edit_post_type = new EditPostType();
        }
    }

}
