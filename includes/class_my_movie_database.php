<?php
/**
 * The core plugin class.
 *
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * Used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier and current version of the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes
 * @author     Kostas Stathakos <info@e-leven.net>
 */

class My_movie_database {

    /**
     * The loader that's responsible for maintaining and registering most hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      My_movie_database_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifiers of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     * @var      string    $plugin_slug    The slug used to uniquely identify this plugin.
     */
	protected $plugin_name;
	protected $plugin_slug;


    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'my_movie_database';
        $this->plugin_slug = 'my_movie_db';
        $this->version = '1.2.1';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating (many of) the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_mmdb_loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_mmdb_i18n.php';

        /**
         * A Wordpress Settings API wrapper class (by Tareq Hasan).
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/class_wp_settings_api.php';

        /**
         * The class responsible for configuring the settings (using the above wrapper class) required for the
         * plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class_mmdb_settings.php';

        /**
         * The classes responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class_mmdb_admin.php';

        /**
         * The abstract superclass responsible for the mmdb data types.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mmdb_data_type_class/class_mmdb_data_type.php';

        /**
         * The concrete subclasses responsible for the mmdb admin, tvshow and person data types
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mmdb_data_type_class/class_mmdb_movie_data_type.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class_mmdb_admin_posts.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mmdb_data_type_class/class_mmdb_tvshow_data_type.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/mmdb_data_type_class/class_mmdb_person_data_type.php';

        /**
         * A class for creating Wordpress custom post types and custom taxonomies (by jjgrainger).
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/PostTypes/Columns.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/PostTypes/PostType.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/lib/PostTypes/Taxonomy.php';

        /**
         * The class responsible for the plugin post meta box in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class_mmdb_post_meta_box.php';

        /**
         * The TMDB API (TheMovieDatabase) wrapper used (multiple contibutors)
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/tmdb_api/tmdb-api.php';

        /**
         * The class responsible for orchestrating actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_mmdb_public.php';

        /**
         * The class responsible for finding public file url's (ex: css, js, placeholder img).
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class_mmdb_public_files.php';

        /**
         * The abstract superclass responsible for the mmdb view types.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_type_class/class_mmdb_type.php';

        /**
         * The concrete subclass responsible for the mmdb admin content view
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_type_class/class_mmdb_admin_type.php';

        /**
         * The concrete subclass responsible for the mmdb admin search view
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_type_class/search/class_mmdb_admin_search_type.php';

        /**
         * The concrete subclass responsible for the mmdb content view
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_type_class/class_mmdb_content_type.php';

        /**
         * The concrete subclass responsible for the mmdb shortcodes
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_type_class/class_mmdb_shortcode_type.php';

        /**
         * Template helper functions left over from procedurial plugin version (to be emptied)
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mmdb_views_helper.php';

        $this->loader = new My_movie_database_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the My_movie_database_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new My_movie_database_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new MMDB_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_filter('default_hidden_meta_boxes', $plugin_admin, 'mmdb_hide_meta_box',10,2);
    }

    /**
     * Register the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new MMDB_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'the_content', $plugin_public, 'mmdb_the_content_view' );

        $register_shortcode = new MMDB_Shortcode_Type();
        $register_shortcode->mmdb_shortcodes_init();

    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    My_movie_database_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}
