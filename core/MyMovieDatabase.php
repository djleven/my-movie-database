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

    const MMDB_INC_DIR = MMDB_PLUGIN_DIR . 'core/';
    const MMDB_CONTROLLERS_DIR = self::MMDB_INC_DIR . 'controllers/';
    const MMDB_LIB_DIR = self::MMDB_INC_DIR . 'lib/';
    const MMDB_ADMIN_DIR = self::MMDB_INC_DIR . 'admin/';
    const MMDB_VENDOR_DIR = self::MMDB_INC_DIR . 'vendor/';

    /**
     * Initialise the plugin.
     *
     * Set the plugin version, register the textdomain, and run the core controllers.
     *
     * @since    1.0.0
     */

    private function __construct() {

        $this->version = "2.5.0";
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
     * Load the required common dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   private
     */
    private function loadCommonDependencies() {
        /**
         * The class and interfaces responsible for registering the plugin's wordpress plugin API hooks.
         */
        require_once 'PluginAPIInterfaces.php';
        require_once 'PluginAPIManager.php';

        /**
         * The class responsible for defining (shared) core controller functions.
         */
        require_once self::MMDB_CONTROLLERS_DIR . 'CoreController.php';

        /**
         * The abstract superclass responsible for the mmdb resource (data) types.
         */
        require_once self::MMDB_LIB_DIR . 'resourceTypes/AbstractResourceType.php';

        /**
         * The concrete subclasses responsible for the mmdb admin, tvshow and person resource (data) types
         */
        require_once self::MMDB_LIB_DIR . 'resourceTypes/MovieResourceType.php';
        require_once self::MMDB_LIB_DIR . 'resourceTypes/TvshowResourceType.php';
        require_once self::MMDB_LIB_DIR . 'resourceTypes/PersonResourceType.php';

        /**
         * A class for creating Wordpress custom post types and custom taxonomies.
         */
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/Columns.php';
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/PostTypeEntityAbstract.php';
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/PostType.php';
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/Taxonomy.php';

        /**
         * A class responsible for handling plugin template files.
         */
        require_once self::MMDB_INC_DIR . 'TemplateFiles.php';

        require_once self::MMDB_INC_DIR . 'AssetManager.php';

        /**
         * The abstract superclass responsible for the mmdb view types and accompanying trait for Vuejs.
         */
        require_once self::MMDB_LIB_DIR . 'wpContentTypes/TemplateVueTrait.php';
        require_once self::MMDB_LIB_DIR . 'wpContentTypes/WpAbstractContentType.php';

        /**
         * The concrete subclass responsible for the mmdb post view
         */
        require_once self::MMDB_LIB_DIR . 'wpContentTypes/WpPostContentType.php';

        /**
         * The plugin API endpoint classes
         */
        require_once self::MMDB_LIB_DIR . 'resourceAPI/RegisterEndpoint.php';
        require_once self::MMDB_LIB_DIR . 'resourceAPI/GetResourcesEndpoint.php';
        require_once self::MMDB_LIB_DIR . 'resourceAPI/BuildRequest.php';
    }

    /**
     * Load the required admin side dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   private
     */
    private function loadAdminDependencies() {
        /**
         * A Wordpress Settings API wrapper class (by Tareq Hasan).
         */
        require_once self::MMDB_VENDOR_DIR . 'WpSettingsApi.php';

        /**
         * The class responsible for configuring the plugin's admin settings (using the above wrapper class).
         */
        require_once self::MMDB_ADMIN_DIR . 'Settings.php';

        /**
         * The class responsible for orchestrating the plugin's state activation changes.
         */
        require_once self::MMDB_ADMIN_DIR . 'ActivationStateChanges.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once self::MMDB_CONTROLLERS_DIR . 'AdminController.php';

        /**
         * A class responsible for customising wordpress post type to accommodate movies
         */
        require_once self::MMDB_ADMIN_DIR . 'EditPostType.php';

        /**
         * The class responsible for the plugin post meta box in the admin area.
         */
        require_once self::MMDB_ADMIN_DIR . 'PostMetaBox.php';

        /**
         * The concrete subclass responsible for the mmdb admin content view
         */
        require_once self::MMDB_LIB_DIR . 'wpContentTypes/WpAdminPostContentType.php';
    }

    /**
     * Load the required public facing side dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   private
     */
    private function loadPublicDependencies() {

        /**
         * The class responsible for orchestrating actions that occur in the public-facing
         * side of the site.
         */
        require_once self::MMDB_CONTROLLERS_DIR . 'PublicController.php';

        /**
         * The concrete subclass responsible for the shortcode view
         */
        require_once self::MMDB_LIB_DIR . 'wpContentTypes/WpShortcodeContentType.php';
    }

    /**
     * Load the dependencies and instantiate the admin controller.
     *
     * @since    2.5.0
     * @access   private
     */
    private function runAdmin() {
        $this->loadAdminDependencies();
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
        $this->loadPublicDependencies();
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
        $this->loadCommonDependencies();
        $this->manager = new PluginAPIManager();
        $this->coreController = new CoreController();

//        $manager->register($this->coreController);

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
}

