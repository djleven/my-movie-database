<?php
/**
 * The file that defines the mmdb admin content class
 *
 * The MMDB_Content_Type is a subclass of the abstract MMDB_type class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.1
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/mmdb_type_class
 */

class MMDB_Admin_Content_Type extends MMDB_Type {


    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.1
     * @param      string    $type_slug   The mmdb content type ('slug') for the object
     * @param      string    $tmdb_id     The tmdb id for the type object
     */
    public function __construct($type_slug, $tmdb_id) {

        $this->type_slug = $type_slug;
        $this->tmdb_id = $tmdb_id;
        $this->public_files = new MMDB_Public_Files;
    }

    /**
     * The wordpress view type
     *
     * @since     1.0.1
     * @return    string
     */
    protected function viewType() {

        return 'admin';
    }

    /**
     * Get the template for the type object
     *
     * @since     1.0.1
     * @return    string
     */
    protected function get_template_setting() {

        return $this->plugin_slug() .'_selected_'. $this->type_slug;

    }

    /**
     * Setup and render the mmdb admin content view
     *
     * @since    1.0.1
     * @param     MMDB_Admin_Content_Type     $mmdb_type    The admin content type
     * @return    string     The mmdb Shortcode_Type view
     */
    public function mmdb_the_admin_content_view($mmdb_type) {

        $mmdb_content = $this->mmdb_the_template_view($mmdb_type, false);

        return $mmdb_content['output'];

    }

}
