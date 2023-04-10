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
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\ActionHookSubscriberInterface;
use MyMovieDatabase\FilterHookSubscriberInterface;
use MyMovieDatabase\CoreController;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\TemplateFiles;

class AdminController implements ActionHookSubscriberInterface, FilterHookSubscriberInterface {

    /**
     * The resource (data) types made available in the plugin.
     *
     * @since     1.0.0
     * @return    array
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
     * @since     2.5.0
     * @return    ActivationStateChanges
     */
    public $activation_state_changes;
    /**
     * Class object that defines the option page settings functionality
     *
     * @since     2.5.0
     * @return    Settings
     */
    public $settings;
    /**
     * Class object that conditionally edits / modifies wp post type
     *
     * @since     2.5.0
     * @return    EditPostType
     */
    public $edit_post_type = null;
    /**
     * Class object that handles the MMDB metaboxes for the active post types
     *
     * @since     2.5.0
     * @return    PostMetaBox
     */
    public $post_meta_box;

    /**
     * The screen of current WordPress request
     *
     * @since     3.0.0
     * @var       \WP_Screen|null
     */
    public $current_screen;

    /**
     * Initialize the class and set its properties.
     *
     * @since      1.0.0
     * @param      array $available_resource_types
     * @param      array $active_post_types
     */
    public function __construct($available_resource_types, $active_post_types ) {
        $this->activation_state_changes = new ActivationStateChanges();
        $this->available_resource_types = $available_resource_types;
        $this->active_post_types = $active_post_types;
        $this->setAdminSettings();
        $this->setEditWpPosts();
        $this->setPostMetaBoxes();
    }

    /**
     * Get the action hooks to be registered related to the admin-facing functionality.
     *
     * Enqueue scripts
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'admin_enqueue_scripts' => 'enqueue_scripts',
        ];
    }

    /**
     * Get the filter hooks to be registered related to the admin-facing functionality.
     *
     * Hide the meta boxes in the post screens as default behavior
     *
     * @since    2.5.0
     * @access   public
     */
    public function getFilters()
    {
        return [
            'default_hidden_meta_boxes' => [
                'mmdb_hide_meta_box',
                10,
                2
            ]
        ];
    }

    /**
     * Instantiate the class that defines the option page settings functionality for the plugin
     *
     * @since     1.0.0
     */

    private function setAdminSettings() {

        $this->settings = new Settings($this->available_resource_types);
    }

    /**
     * Check settings whether default wp post type should be edited / modified or not
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function hasEditWpPostsSetting() {

        return CoreController::getMmdbOption('mmdb_movie_post_type', MMDB_ADVANCED_OPTION_GROUP,  MovieResourceType::DATA_TYPE_NAME) == 'posts_custom';
    }

    /**
     * Instantiate class that edits / modifies wp post type if settings permit
     *
     * @since     1.0.0
     */
    private function setEditWpPosts() {

        if($this->hasEditWpPostsSetting()){

            $this->edit_post_type = new EditPostType();
        }
    }

    /**
     * Set the screen of current WordPress request
     *
     * @since     3.0.0
     * @return    \WP_Screen|null
     */
    protected function getCurrentScreen() {

        return $this->current_screen = $this->current_screen ?: get_current_screen();
    }

    /**
     * Determine if we are on the plugin settings page
     *
     * @since     3.0.0
     * @return    boolean
     */
    private function isAdminSettingsPage() {
        $screen = $this->getCurrentScreen();
        $screen_id  = 'settings_page_mmdb_settings';

        return $screen->id === $screen_id;
    }

    /**
     * Determine if we are on a mmdb active post type (edit or new post) screen
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function isAdminEditPostPage() {

        $result = false;
        $screen = $this->getCurrentScreen();
        $post_base = $screen->base;
        $post_idtype = $screen->id;
        foreach ($this->active_post_types as $active_post_type) {
            // Check screen hook and current post type
            if ($post_idtype == $active_post_type && $post_base == 'post') {
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Handle the MMDB metaboxes for the active post types
     *
     * @since     1.0.0
     */
    private function setPostMetaBoxes() {

        $this->post_meta_box = new PostMetaBox($this->active_post_types);;
    }

    /**
     * Hides the meta boxes in the post screens as default behavior (if the user has not yet set his screen options)
     *
     * @since     1.0.0
     * @return    array
     */
    public function mmdb_hide_meta_box($hidden) {

        // do this only for our active mmdb post types
        if ($this->isAdminEditPostPage()) {
            $hidden = array(
                'postexcerpt',
                'slugdiv',
                'postcustom',
                'trackbacksdiv',
                'commentstatusdiv',
                'commentsdiv',
                'authordiv',
                'revisionsdiv'
            );
        }
        return $hidden;
    }

    /**
     * Register the JavaScript and the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        $isAdminEditPostPage = $this->isAdminEditPostPage();
        if($isAdminEditPostPage) {
            $edit_js_file = 'admin-edit';
            wp_enqueue_style(
                MMDB_NAME . 'Admin', TemplateFiles::getPublicStylesheet(MMDB_CAMEL_NAME . 'Admin'), [], '1.0.0', 'all' );
            wp_enqueue_script( 'mmodb-admin-edit',  TemplateFiles::getJsFilePath($edit_js_file), ['jquery'],0.1, true);
        }
        elseif($this->isAdminSettingsPage() ) {
            $settings_js_file = 'admin-settings';
            wp_enqueue_script( 'mmodb-admin-settings', TemplateFiles::getJsFilePath($settings_js_file), ['jquery'],0.1, true);
        }
        TemplateFiles::enqueueCommonFiles($isAdminEditPostPage);
    }
}
