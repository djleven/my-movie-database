<?php
/**
 * The file that defines the mmdb content class
 *
 * The MMDB_Content_Type is a subclass of the abstract MMDB_type class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/mmdb_type_class
 */

class MMDB_Content_Type extends MMDB_Type {

    public $post_id;
    public $tmdb_type;

    /**
     * Initialize the class and set its properties.
     *
     * @since      1.0.0
     * @param      string    $type_slug   The mmdb content type ('slug') for the object
     * @param      string    $post_id     The wp post id for the type object
     */
    public function __construct($type_slug, $post_id) {

        $this->type_slug = $type_slug;
        $this->post_id = $post_id;
        $this->tmdb_id = $this->get_post_metaID_setting();
        $data_type = $this->data_type_class() . $type_slug;
        $this->tmdb_type = new $data_type($type_slug);
        $this->public_files = new MMDB_Public_Files;
    }

    /**
     * The wordpress view type
     *
     * @since     1.0.0
     * @return    string
     */
    protected function viewType() {

        return 'content';
    }

    /**
     * Get the template setting for type object
     * @since     1.0.0
     * @return    string
     */
    protected function get_template_setting() {

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_tmpl';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), 'tabs');
    }

    /**
     * Get the position setting for type object
     *
     * @since     1.0.0
     * @return    string
     */

    protected function get_position_setting() {

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_pos';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), 'after');
    }

    /**
     * Get the post meta (TMDB id) setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    protected function get_post_metaID_setting() {

        $idMovie = get_post_meta($this->post_id, 'MovieDatabaseID', true);
        return $idMovie;
    }

    /**
     * Determine if the rendered mmdb content view goes before or after the wp content
     *
     * @since      1.0.0
     * @param      string $content     The wp content
     * @param      string $mmdb_type   The mmdb type object.
     * @param      string $templ       The mmdb content.
     * @return     string
     */
    public function mmdb_order_the_content($content, $mmdb_type, $templ) {

        $position = $mmdb_type->get_position_setting();
        if ($position == 'after') {
            $new_content = $content;
            $new_content.= $templ;
        }
        else {
            $new_content = $templ;
            $new_content.= $content;
        }
        return $new_content;
    }

}

