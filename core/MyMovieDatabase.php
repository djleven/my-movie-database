<?php
/**
 * This class serves as the entry point for the plugin.
 *
 * It is used to:
 * - load dependencies,
 * - instantiate the core plugin controllers
 * - register relevant classes with the PluginAPIManager
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/includes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Controllers\CoreController;
use MyMovieDatabase\Controllers\AdminController;
use MyMovieDatabase\Controllers\PublicController;

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
     * The class responsible for loading plugin dependencies.
     *
     * @since    3.0.0
     * @access   protected
     * @var      FileLoader    $fileLoader
     */
    protected $fileLoader;

    /**
     * An instance of the options helper class loaded with the advanced setting values.
     *
     * @since    3.0.0
     * @access   protected
     * @var      OptionsGroup    $advancedSettings
     */
    protected $advancedSettings;

    /**
     * Initialise the plugin.
     *
     * @since    1.0.0
     */

    private function __construct() {
        $this->version = '3.1.1';
        $this->manager = new PluginAPIManager();
        $this->advancedSettings = new OptionsGroup(Constants::ADVANCED_OPTION_GROUP_NAME);
        $this->run();
    }

    /**
     * Instantiate the core controllers.
     *
     * @since    3.0.0
     * @access   private
     */
    private function runCore() {
        $this->coreController = new CoreController($this->advancedSettings);
        $this->manager->register($this->coreController);
        $this->manager->register($this->coreController->languageManager);

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
        $isSettingsPage = $this->isAdminSettingsPage();
        $this->adminController = new AdminController(
            $this->advancedSettings,
            $isSettingsPage ? $this->coreController->available_resource_types : null,
            $this->coreController->active_post_types
        );

        $this->manager->register($this->adminController->activation_state_changes);

        if($isSettingsPage) {
            require_once ABSPATH . 'wp-admin/includes/translation-install.php';
            $this->adminController->settings->setVersion($this->version);
            $this->manager->register( $this->adminController->settings );
            $this->manager->register( $this->adminController->settings->cacheController );
        } else {
            $this->manager->register($this->adminController->post_meta_box);
        }
        if($this->adminController->edit_post_type){
            $this->manager->register($this->adminController->edit_post_type);
        }

        $this->manager->register($this->adminController);

    }

    /**
     * Load the dependencies and instantiate the public controllers.
     *
     * @since    2.5.0
     * @access   private
     */
    private function runPublic() {
        $this->publicController = new PublicController(
            $this->advancedSettings,
            $this->coreController->active_post_types
        );
        $this->manager->register($this->publicController);
    }

    /**
     * Load the dependencies and instantiate the core controllers.
     *
     * @since    1.0.0
     * @access   private
     */
    private function run() {
        $this->runCore();
        if (is_admin()) {
            $this->runAdmin();
        } else {
            $this->runPublic();
        }
    }

    /**
     * Determine if we are on the plugin setting - or related - page
     *
     * @since     3.0.0
     * @return    boolean
     */
    protected function isAdminSettingsPage() {

        return (isset($_REQUEST['page']) && $_REQUEST['page'] === "mmdb_settings") || (isset($_REQUEST['option_page']));
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
        $error_msg = Constants::PLUGIN_NAME_CAMEL . ' error';
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
