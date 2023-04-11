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
 * @package    my-movie-database
 * @subpackage my-movie-database/includes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Admin\AdminController;

class MyMovieDatabase {

    /**
     * The unique instance of the plugin.
     *
     * @var MyMovieDatabase
     */
    private static $instance;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The wp plugin API registration manager of the plugin.
     *
     * @since    2.5.0
     * @access   protected
     * @var      PluginAPIManager    $manager    The registration manager of the plugin.
     */
    protected $manager;

    /**
     * The core controller object of the plugin.
     *
     * @since    2.5.0
     * @access   protected
     * @var      CoreController    $coreController    The core controller object of the plugin.
     */
    protected $coreController;

    /**
     * The admin controller object of the plugin.
     *
     * @since    2.5.0
     * @access   protected
     * @var      AdminController    $adminController    The admin controller object of the plugin.
     */
    protected $adminController = null;


    /**
     * The public controller object of the plugin.
     *
     * @since    2.5.0
     * @access   protected
     * @var      PublicController    $publicController    The public controller object of the plugin.
     */
    protected $publicController = null;

    /**
     * Initialise the plugin.
     *
     * Set the plugin version, register the textdomain, and run the core controllers.
     *
     * @since    1.0.0
     */

    private function __construct() {

        $this->version = "3.0.0";
        add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain'));

        $this->run();
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
            MMDB_WP_NAME . '/languages'
        );
    }

    /**
     * Instantiate the core controllers.
     *
     * @since    3.0.0
     * @access   private
     */
    private function runCore() {
        $this->coreController = new CoreController();
        foreach ($this->coreController->post_types as $post_type)  {
            // Taxonomies must be registered before PostTypes
            $this->manager->register($post_type->postTypeTaxonomy);
            $this->manager->register($post_type);
        }

        foreach ($this->coreController->endpoints as $endpoint)  {
            $this->manager->register($endpoint);
        }

    }

    /**
     * Load the dependencies and instantiate the admin controller.
     *
     * @since    2.5.0
     * @access   private
     */
    private function runAdmin() {
        FileLoader::loadAdminDependencies();
        $this->adminController = new AdminController(
            $this->coreController->available_resource_types,
            $this->coreController->active_post_types
        );

        $this->manager->register($this->adminController->activation_state_changes);
        $this->manager->register($this->adminController->settings);

        if($this->adminController->edit_post_type){
            $this->manager->register($this->adminController->edit_post_type);
        }

        $this->manager->register($this->adminController->post_meta_box);
        $this->manager->register($this->adminController);
    }


    /**
     * Load the dependencies and instantiate the public controllers.
     *
     * @since    2.5.0
     * @access   private
     */
    private function runPublic() {
        FileLoader::loadPublicDependencies();
        $this->publicController = new PublicController($this->coreController->active_post_types);
        $this->manager->register($this->publicController);
    }

    /**
     * Load the dependencies and instantiate the core controllers.
     *
     * @since    1.0.0
     * @access   private
     */
    private function run() {
        FileLoader::loadCommonDependencies();
        $this->manager = new PluginAPIManager();
        $this->runCore();

        if (is_admin()) {
            $this->runAdmin();
        } else {
            $this->runPublic();
        }
    }

    /**
     * Gets an instance of our plugin.
     *
     * @return MyMovieDatabase
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Log content to error log
     *
     * Enabled when WP_DEBUG_LOG  and WP_DEBUG_LOG are set to true
     * Can be disabled via the mmodb_debug_log filter.
     *
     * @since      2.0.2
     * @param      mixed   $content
     *
     */
    public static function writeToLog ( $content, $optional_msg = null )  {
        if ( !apply_filters(
            'mmodb_debug_log',
            defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG
        )) {
            return;
        }
        $error_msg = MMDB_CAMEL_NAME . ' error';
        if($optional_msg) {
            $error_msg .= ': ' . $optional_msg . PHP_EOL;
        }
        if ( is_array( $content ) || is_object( $content ) ) {
            $error_msg .= print_r( $content, true );
        } else {
            $error_msg .= $content;
        }

        error_log( $error_msg );
    }
}

