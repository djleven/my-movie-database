<?php
/**
 * @wordpress-plugin
 * Plugin Name:       My Movie Database
 * Plugin URI:        https://wordpress.org/plugins/my-movie-database/
 * Description:       The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people you choose. The data comes from the Movie Database (TMDb). This plugin was developed to enrich your movie or tvshow critique / review by 'automatically' adding the related information and allowing you to focus on your writing instead.
 * Version:           2.0.7
 * Author:            Kostas Stathakos
 * Author URI:        https://e-leven.net/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       my-movie-database
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
if ( defined( 'MMDB_PLUGIN_ID' ) ) {
    die;
}
define( 'MMDB_PLUGIN_ID', 'mmdb' );
define( 'MMDB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MMDB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MMDB_NAME', 'my_movie_database' );
define( 'MMDB_WP_NAME', 'my-movie-database' );
define( 'MMDB_CAMEL_NAME', 'myMovieDatabase' );
define( 'MMDB_ADVANCED_OPTION_GROUP', MMDB_PLUGIN_ID . '_opt_advanced' );

/**
 * The core plugin entry class
 */
include_once plugin_dir_path( __FILE__ ) . 'core/MyMovieDatabase.php';

new ActivationStateChanges();
new MyMovieDatabase\MyMovieDatabase();

/**
 * Define the activation and deactivation sequence tasks for the plugin.
 *
 * @since    2.0.2
 */
class ActivationStateChanges {

    const PLUGIN_ACTIVATED = 'Plugin_Activated';

    public function __construct() {

        register_activation_hook( __FILE__, array( $this, 'on_mmdb_activation') );
//        register_deactivation_hook( __FILE__, array($this,'on_mmdb_deactivation'));
        add_action( 'admin_init', array($this, 'on_load_mmdb') );
    }


    public function on_mmdb_activation() {

        add_option( self::PLUGIN_ACTIVATED, MMDB_NAME );

    }

    public function on_mmdb_deactivation() {

    }

    public function on_load_mmdb() {

        if ( is_admin() && get_option( self::PLUGIN_ACTIVATED ) ===  MMDB_NAME) {

            delete_option( self::PLUGIN_ACTIVATED );

            flush_rewrite_rules();
        }
    }
}
