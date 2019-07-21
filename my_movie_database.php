<?php
/**
 * @wordpress-plugin
 * Plugin Name:       My Movie Database
 * Plugin URI:        https://wordpress.org/plugins/my-movie-database/
 * Description:       The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people you choose. The data comes from the Movie Database (TMDb). This plugin was developed to enrich your movie or tvshow critique / review by 'automatically' adding the related information and allowing you to focus on your writing instead.
 * Version:           2.0.0
 * Author:            Kostas Stathakos
 * Author URI:        https://e-leven.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       my-movie-db
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
include_once plugin_dir_path( __FILE__ ) . 'includes/MyMovieDatabase.php';

new MyMovieDatabase\MyMovieDatabase();