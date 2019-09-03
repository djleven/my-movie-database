<?php
/**
 * This class serves as the entry point for the plugin.
 *
 * It is used to:
 * - load dependencies,
 * - define internationalization,
 * - instantiate the core plugin controllers for both the public-facing side of the site and the admin area.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Admin\AdminController;

class MyMovieDatabase {

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    const MMDB_VENDOR_DIR = MMDB_PLUGIN_DIR . 'vendor/';
    const MMDB_ADMIN1_DIR = MMDB_PLUGIN_DIR . 'admin/';
    const MMDB_INC_DIR = MMDB_PLUGIN_DIR . 'includes/';
    const MMDB_ADMIN_DIR = self::MMDB_INC_DIR . 'admin/';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin identifier, load the dependencies, define the locale, and run the core controllers.
     *
     * @since    1.0.0
     */

    public function __construct() {

        $this->version = "2.0.1";
        $this->load_dependencies();
        $this->setLocale();
        $this->run();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * A Wordpress Settings API wrapper class (by Tareq Hasan).
         */
        require_once self::MMDB_VENDOR_DIR . 'WpSettingsApi.php';

        /**
         * The class responsible for configuring the settings (using the above wrapper class) required for the
         * plugin.
         */
        require_once self::MMDB_ADMIN_DIR . 'Settings.php';

        /**
         * The classes responsible for defining all actions that occur in the admin area.
         */
        require_once self::MMDB_ADMIN_DIR . 'AdminController.php';

        /**
         * The abstract superclass responsible for the mmdb data types.
         */
        require_once self::MMDB_ADMIN_DIR . 'dataTypes/DataType.php';

        /**
         * The concrete subclasses responsible for the mmdb admin, tvshow and person data types
         */
        require_once self::MMDB_ADMIN_DIR . 'dataTypes/MovieDataType.php';
        require_once self::MMDB_ADMIN_DIR . 'dataTypes/TvshowDataType.php';
        require_once self::MMDB_ADMIN_DIR . 'dataTypes/PersonDataType.php';

        /**
         * A class responsible for customising wordpress post type to accommodate movies
         */
        require_once self::MMDB_ADMIN_DIR . 'EditPostType.php';

        /**
         * A class for creating Wordpress custom post types and custom taxonomies (by jjgrainger).
         */
//        require_once self::MMDB_VENDOR_DIR . 'PostTypes/Columns.php';
        require_once self::MMDB_VENDOR_DIR . 'PostTypes/PostType.php';
        require_once self::MMDB_VENDOR_DIR . 'PostTypes/Taxonomy.php';

        /**
         * The class responsible for the plugin post meta box in the admin area.
         */
        require_once self::MMDB_ADMIN_DIR . 'PostMetaBox.php';

        /**
         * The class responsible for orchestrating actions that occur in the public-facing
         * side of the site.
         */
        require_once self::MMDB_INC_DIR . 'PublicController.php';

        /**
         * A class responsible for handling plugin template files.
         */
        require_once self::MMDB_INC_DIR . 'TemplateFiles.php';

        /**
         * The abstract superclass responsible for the mmdb view types.
         */
        require_once self::MMDB_INC_DIR . 'wpContentTypes/TemplateVueTrait.php';
        require_once self::MMDB_INC_DIR . 'wpContentTypes/WpContentType.php';

        /**
         * The concrete subclasses responsible for the mmdb post and shortcode views
         */
        require_once self::MMDB_INC_DIR . 'wpContentTypes/WpPostContentType.php';
        require_once self::MMDB_INC_DIR . 'wpContentTypes/WpShortcodeContentType.php';

        /**
         * The concrete subclass responsible for the mmdb admin content view
         */
        require_once self::MMDB_INC_DIR . 'wpContentTypes/WpAdminPostContentType.php';
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            MMDB_WP_NAME,
            false,
            MMDB_PLUGIN_DIR . '/languages/'
        );
    }
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the I18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function setLocale() {

        add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain'));
    }

    /**
     * Register the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function run() {

        $plugin_admin = new AdminController();
        new PublicController($plugin_admin->active_post_types);
    }
}

