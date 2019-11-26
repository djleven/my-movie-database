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

use MyMovieDatabase\CoreController;
use MyMovieDatabase\TemplateFiles;

class AdminController {

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
     * Initialize the class and set its properties.
     *
     * @since      1.0.0
     * @param      array $available_resource_types
     * @param      array $active_post_types
     */
    public function __construct($available_resource_types, $active_post_types ) {

        $this->available_resource_types = $available_resource_types;
        $this->active_post_types = $active_post_types;
        $this->setAdminSettings();
        $this->editWpPosts();
        $this->registerPostMetaBoxes();
        $this->registerRemainingHooks();
    }

    /**
     * Instantiate the class that defines the option page settings functionality for the plugin
     *
     * @since     1.0.0
     */

    private function setAdminSettings() {

        $settings = new Settings($this->available_resource_types);
        add_action( 'admin_init', array($settings, 'admin_init') );
        add_action( 'admin_menu', array($settings, 'admin_menu') );
    }

    /**
     * Check settings whether default wp post type should be edited / modified or not
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function editWpPostsSetting() {

        if(CoreController::getMmdbOption('mmdb_movie_post_type', MMDB_ADVANCED_OPTION_GROUP, 'movie') == 'posts_custom') {

            return true;
        }

        return false;
    }

    /**
     * Instantiate class that edits / modifies wp post type if settings permit
     *
     * @since     1.0.0
     */
    private function editWpPosts() {

        if($this->editWpPostsSetting()){

            $edit_post_type = new EditPostType('Movie', 'movie', 'Movies');
            add_action('admin_head', array($edit_post_type, 'mmdb_posts_admin_menu_icons_css'));
            add_action('init', array($edit_post_type, 'mmdb_change_posts_object_label'));
            add_action('admin_menu', array($edit_post_type, 'mmdb_change_posts_menu_label'));
        }

        return;
    }

    /**
     * Determine if we are on a mmdb active post type (edit or new post) screen
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function isAdminEditPostPage() {

        $result = false;
        $screen = get_current_screen();
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
     * Make / register MMDB metaboxes for the active post types
     *
     * @since     1.0.0
     */
    private function registerPostMetaBoxes() {

        $post_meta_box = new PostMetaBox($this->active_post_types);
        add_action('add_meta_boxes', array($post_meta_box, 'mmdb_add_post_meta_boxes'));
        add_action('save_post', array($post_meta_box, 'mmdb_save_post_class_meta'));
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
            wp_enqueue_style(
                MMDB_NAME . 'Admin', TemplateFiles::getPublicFile(MMDB_CAMEL_NAME . 'Admin', 'css'), [], '1.0.0', 'all' );
        }
        TemplateFiles::enqueueCommonFiles($isAdminEditPostPage);
    }

    /**
     * Register the remaining hooks related to the admin area functionality.
     *
     * @since    1.0.0
     */
    private function registerRemainingHooks() {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts'));
        add_filter('default_hidden_meta_boxes', array($this, 'mmdb_hide_meta_box'),10,2);

    }

}

