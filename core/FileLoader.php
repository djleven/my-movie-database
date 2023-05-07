<?php
/**
 * The class responsible for loading plugin PHP files,
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

class FileLoader {

    const MMDB_INC_DIR = MMDB_PLUGIN_DIR . 'core/';
    const MMDB_CONTROLLERS_DIR = self::MMDB_INC_DIR . 'controllers/';
    const MMDB_LIB_DIR = self::MMDB_INC_DIR . 'lib/';
    const MMDB_ADMIN_DIR = self::MMDB_INC_DIR . 'admin/';
    const MMDB_VENDOR_DIR = self::MMDB_INC_DIR . 'vendor/';

    /**
     * Load the required common dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   public
     */
    public function loadCommonDependencies() {

        /**
         * A class responsible for hosting global constants and keeping track of core WP i18n strings used.
         */
        require_once self::MMDB_INC_DIR . 'I18nConstants.php';

        /**
         * A class responsible for hosting constants used in the plugin.
         */
        require_once self::MMDB_INC_DIR . 'Constants.php';

        /**
         * A helper class responsible for accessing setting options.
         */
        require_once self::MMDB_LIB_DIR . 'OptionsGroup.php';

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
         * The class responsible for i18n textdomain functionality.
         */
        require_once self::MMDB_LIB_DIR . 'LanguageManager.php';

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
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/PostTypeEntityAbstract.php';
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/PostType.php';
        require_once self::MMDB_LIB_DIR . 'wpPostTypes/Taxonomy.php';

        /**
         * A class responsible for handling plugin template files.
         */
        require_once self::MMDB_INC_DIR . 'TemplateFiles.php';

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
         * The class responsible for the plugin's cache management.
         */
        require_once self::MMDB_ADMIN_DIR . 'CacheManager.php';

        /**
         * The plugin API endpoint classes
         */
        require_once self::MMDB_LIB_DIR . 'resourceAPI/AbstractEndpoint.php';
        require_once self::MMDB_LIB_DIR . 'resourceAPI/GetResourcesEndpoint.php';
        require_once self::MMDB_LIB_DIR . 'resourceAPI/BuildRequest.php';
    }

    /**
     * Load the required admin side dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   public
     */
    public function loadAdminDependencies($isSettingsPage) {
        if($isSettingsPage) {
            /**
             * A WordPress Settings API wrapper class (by Tareq Hasan).
             */
            require_once self::MMDB_VENDOR_DIR . 'WpSettingsApi.php';

            /**
             * The class responsible for configuring the plugin's admin settings (using the above wrapper class).
             */
            require_once self::MMDB_ADMIN_DIR . 'SettingsHeader.php';
            require_once self::MMDB_ADMIN_DIR . 'SettingsCacheController.php';
            require_once self::MMDB_ADMIN_DIR . 'Settings.php';
        } else {
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
    }

    /**
     * Load the required public facing side dependencies for this plugin.
     *
     * @since    2.0.2
     * @access   public
     */
    public static function loadPublicDependencies() {

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

}
