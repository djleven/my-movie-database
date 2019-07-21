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
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use PostTypes\PostType;
use PostTypes\Taxonomy;
use MyMovieDatabase\TemplateFiles;
use MyMovieDatabase\Admin\DataTypes\MovieDataType;
use MyMovieDatabase\Admin\DataTypes\TvshowDataType;
use MyMovieDatabase\Admin\DataTypes\PersonDataType;

class AdminController {

    /**
     * The data types made available in the plugin.
     *
     * @since     1.0.0
     * @return    array
     */
    private $set_admin_data_types;
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
     */
    public function __construct() {

        $this->set_admin_data_types = $this->setAdminDataTypes();
        $this->active_post_types = $this->getActivePostTypes();
        $this->setAdminSettings();
        $this->registerCustomPostTypes();
        $this->editWpPosts();
        $this->registerPostMetaBoxes();
        $this->registerRemainingHooks();
    }

    /**
     * Instantiate and return all the tmdb data types that will be (potentially) available to use ex: tvhows and movies.
     *
     * @since     1.0.0
     * @return    array
     */
    private function setAdminDataTypes() {

        $plugin_admin_types = [];
        $plugin_admin_types[] = new MovieDataType('movie', 'Movie', 'dashicons-video-alt');
        $plugin_admin_types[] = new TvshowDataType('tvshow', 'TvShow', 'dashicons-welcome-view-site');
        $plugin_admin_types[] = new PersonDataType('person', 'Person', 'dashicons-businessman');

        return $plugin_admin_types;
    }

    /**
     * Instantiate the class that defines the option page settings functionality for the plugin
     *
     * @since     1.0.0
     */

    private function setAdminSettings() {

        $settings = new Settings($this->set_admin_data_types);
        add_action( 'admin_init', array($settings, 'admin_init') );
        add_action( 'admin_menu', array($settings, 'admin_menu') );
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
     * Register / create custom post types and related taxonomy
     *
     * @since     1.0.0
     */
    private function registerCustomPostTypes() {

        $plugin_admin_types = $this->set_admin_data_types;
        $custom_post_types = [];
        $custom_taxonomies = [];
        $i = 0;
        $wpCategoriesOption = AdminController::getMmdbOption(
            'mmdb_wp_categories',
            MMDB_ADVANCED_OPTION_GROUP,
            'yes'
        );

        foreach($plugin_admin_types as $plugin_admin_type) {
            if ($plugin_admin_type->getPostTypeSetting() == $plugin_admin_type->data_type) {

                $custom_post_types[$i] = new PostType(
                    $plugin_admin_type->data_type,
                    [
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
                            "page-attributes"
                        ],
                        'rewrite' => [
                            'slug' => $plugin_admin_type->data_type
                        ],
                    ]
                );
                $custom_post_types[$i]->icon($plugin_admin_type->type_menu_icon);
                $taxonomy = $plugin_admin_type->data_type . '-category';
                $custom_post_types[$i]->taxonomy($taxonomy);
                if($wpCategoriesOption !== 'no') {
                    $custom_post_types[$i]->taxonomy('category');
                }
                $custom_post_types[$i]->register();

                $tax_names = [
                    'name' => $taxonomy,
                    'singular' => "$plugin_admin_type->data_type_label Category",
                    'plural' => "$plugin_admin_type->data_type_label Categories",
                    'slug' => $plugin_admin_type->data_type . '-categories',
                ];
                $custom_taxonomies[$i] = new Taxonomy($tax_names);
                $custom_taxonomies[$i]->register();
                $i++;

            }
        }
        return;
    }

    /**
     * Check settings whether default wp post type should be edited / modified or not
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function editWpPostsSetting() {

        if($this->getMmdbOption('mmdb_movie_post_type', MMDB_ADVANCED_OPTION_GROUP, 'movie') == 'posts_custom') {

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
     * Get the active data type names as set in admin settings (ex: tvshow and post).
     *
     * @since     1.0.0
     * @return    array
     */
    public function getActivePostTypes() {

        $active_post_types = [];
        $plugin_admin_types = $this->set_admin_data_types;

        foreach($plugin_admin_types as $plugin_admin_type) {

            if ($plugin_admin_type->getPostTypeSetting() != 'no_post') {

                if (substr($plugin_admin_type->getPostTypeSetting() , 0, 5) === 'posts') {
                    $active_post_types[] = 'post';
                }
                else {
                    $active_post_types[] = $plugin_admin_type->getPostTypeSetting();
                }

            }
        }
        return $active_post_types;
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

        TemplateFiles::enqueueCommonFiles($this->isAdminEditPostPage());
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

