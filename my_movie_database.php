<?php
/**
 * @wordpress-plugin
 * Plugin Name:       My Movie Database
 * Plugin URI:        https://wordpress.org/plugins/my-movie-database/
 * Description:       The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people you choose. The data comes from the Movie Database (TMDb). This plugin was developed to enrich your movie or tvshow critique / review by 'automatically' adding the related information and allowing you to focus on your writing instead.
 * Version:           3.0.1
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
if ( defined( 'MMDB_PLUGIN_URL' ) ) {
    die;
}

define( 'MMDB_PLUGIN_URL', plugin_dir_url( __FILE__ ), false );
define( 'MMDB_PLUGIN_DIR', plugin_dir_path( __FILE__ ), false );
define( 'MMDB_PLUGIN_MAIN_FILE', __FILE__, false);

/**
 * The core plugin entry class
 */
include_once plugin_dir_path( __FILE__ ) . 'core/MyMovieDatabase.php';
include_once plugin_dir_path( __FILE__ ) . 'core/FileLoader.php';

MyMovieDatabase\MyMovieDatabase::getInstance();
