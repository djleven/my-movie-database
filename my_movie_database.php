<?php
/**
 * @link              https://e-leven.net/my-movie-database
 * @since             0.6
 * @package           My_movie_database
 *
 * @wordpress-plugin
 * Plugin Name:       My Movie Database
 * Plugin URI:        https://wordpress.org/plugins/my-movie-database/
 * Description:       The My Movie Database plugin compliments your content by adding information about the movies, the television shows and the people you choose. The data comes from the Movie Database (TMDb). This plugin was developed to enrich your movie or tvshow critique / review by 'automatically' adding the related information and allowing you to focus on your writing instead.
 * Version:           1.3.1
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

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class_my_movie_database.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_my_movie_database() {

    $plugin = new My_movie_database();
    $plugin->run();

}
run_my_movie_database();
