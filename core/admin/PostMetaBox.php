<?php
/**
 * Defines and orchestrates the post metabox and related template rendering
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\Lib\WpContentTypes\WpPostContentType;
use MyMovieDatabase\Lib\WpContentTypes\WpAdminPostContentType;

class PostMetaBox {

    public $active_post_types;

    /**
     * The tmdb post meta identifier
     *
     * @since     2.0.0
     */
    const MMDB_POST_META_ID = 'MovieDatabaseID';

    /**
     * Initialize the class and add the meta box hooks
     *
     * @since    1.0.0
     * @param    array    $active_post_types     The plugin's current active post types.
     */
    public function __construct($active_post_types) {

        $this->active_post_types = array($active_post_types);
    }

    /**
     * Add the meta box to the active plugin post types
     *
     * @since     0.7.0
     * @param 	  string 	$post_type	 WP post type.
     */
    public function mmdb_add_post_meta_boxes($post_type) {

        $active_post_types = $this->active_post_types;

        foreach ($active_post_types as $active_post_type) {

            //limit meta box to active post types
            if (in_array($post_type, $active_post_type)) {
                add_meta_box('cs-meta',
                    esc_html__(WpPostContentType::postToMovieType($post_type), MMDB_WP_NAME),
                    array($this, "mmdb_id_class_meta_box"),
                    $post_type,
                    'normal',
                    'high',
                    array($post_type)
                );
            }
        }
    }

    /**
     * Prepare the meta box html content
     *
     * @since     0.7.0
     * @param 	  object WP_Post 	$post	 The post object.
     * @param 	  object WP_Post 	$args	 The $callback_args array.
     */
    public function mmdb_id_class_meta_box($post, $args) {
        // Add a nonce field to be checked later on.
        wp_nonce_field('mmdb_class_nonce_check', 'mmdb_class_nonce_check_value');
        $mmdb_type = new WpAdminPostContentType($post->post_type, $post->ID);

        echo '<div><h3 class="center-text">' . __("Search Database", "my-movie-db") . '</h3></div>';
        echo $mmdb_type->templateViewOutput();
    }

    /**
     * Saves the meta box post metadata
     *
     * @since     0.7.0
     * @param     string $post_id The wp post id.
     * @return    string
     */
    function mmdb_save_post_class_meta($post_id) {
        // Check if our nonce is set.
        if (!isset($_POST['mmdb_class_nonce_check_value'])) {
            return $post_id;
        }
        $nonce = $_POST['mmdb_class_nonce_check_value'];
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'mmdb_class_nonce_check')) {
            return $post_id;
        }
        // If this is an autosave do nothing.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        /* Sanitize user input and save*/
        $tmdbid = sanitize_text_field($_POST[self::MMDB_POST_META_ID]);
        update_post_meta($post_id, self::MMDB_POST_META_ID, $tmdbid);
    }
}


