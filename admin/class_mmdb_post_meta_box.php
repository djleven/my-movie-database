<?php
/**
 * Defines and orchestrates the post metabox and related admin side (search and 'selected') template rendering
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */

class MMDB_Meta_Box {

    public $active_post_types;

    /**
     * Initialize the class and add the meta box hooks
     *
     * @since    1.0.0
     * @param    array    $active_post_types     The plugin's current active post types.
     */
    public function __construct($active_post_types) {

        $this->active_post_types = array($active_post_types);
        add_action('add_meta_boxes', array($this, 'mmdb_add_post_meta_boxes'));
        add_action('save_post', array($this, 'mmdb_save_post_class_meta'));
        add_action('wp_ajax_search_mmdb', array($this, 'my_ajax_search_mmdb'));

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
                    esc_html__($post_type, 'my-movie-db'),
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
     * @return 	  string
     */
    public function mmdb_id_class_meta_box($post, $args) {

        // Add a nonce field to be checked later on.
        wp_nonce_field('mmdb_class_nonce_check', 'mmdb_class_nonce_check_value');
        $mmdb_existing_id = esc_attr(get_post_meta($post->ID, 'MovieDatabaseID', true));
        //var_dump($args);
        $post_type = $args['args'][0];

        if ($mmdb_existing_id) {
            $type_get = mmdb_get_type_attr($post_type);
            $mmdb_type = new MMDB_Admin_Content_Type($type_get, $mmdb_existing_id);
            echo $mmdb_type->mmdb_the_admin_content_view($mmdb_type);

        }
        else {
            include plugin_dir_path( dirname( __FILE__ ) ) .  $this->mmdb_no_selection_template();

        }

        include plugin_dir_path( dirname( __FILE__ ) ) . $this->mmdb_post_meta_fields_template();

    }

    /**
     * Set and return the template for when no selection exists
     *
     * @since     1.0.1
     * @return    string
     */
    public function mmdb_no_selection_template() {

        return 'admin/partials/mmdb_no_selection.php';

    }

    /**
     * Set and return the template for the post meta fields
     *
     * @since     1.0.1
     * @return    string
     */
    public function mmdb_post_meta_fields_template() {

        return 'admin/partials/mmdb_post_meta_fields.php';

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
        // If this is an autosave, we do nothing.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        /* Sanitize user input */
        $tmdbid = sanitize_text_field($_POST['MovieDatabaseID']);
        // Update our meta field.
        update_post_meta($post_id, 'MovieDatabaseID', $tmdbid);
    }

    /**
     * The ajax search callback function
     *
     * @since     0.7.0
     */
    public function my_ajax_search_mmdb() {

        if (!empty($_POST['key'])) {

            $result = $this->mmdb_search(
                sanitize_text_field($_POST['key']),
                sanitize_text_field($_POST['posttype'])
            );
        }
        else {

            $result = esc_html__("You have not entered anything in the search field", "my-movie-db");
        }
        header("Content-Type: application/json");
        echo json_encode($result);
        // Don't forget to always exit in the ajax function.
        exit();
    }

    /**
     * Setup and render the html for the search results
     *
     * @since     0.7.0
     * @param      string $key The search input returned from js
     * @param      string $post_type The post type returned from js
     * @return     string
     */
    public function mmdb_search($key,$post_type) {

        $post_type = str_replace("post-type-", "", $post_type);

        $type_get = mmdb_get_type_attr($post_type);
        $mmdb_type = new MMDB_Admin_Search_Type($type_get, $key);

        $result = $mmdb_type->mmdb_the_admin_search_view($mmdb_type);

        return $result;
    }
}


