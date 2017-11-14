<?php
/**
 * Defines the properties of the TMDB view data types made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */

abstract class MMDB_Data_Type {

    public $type_name;
    public $type_slug;
    public $type_menu_icon;
    public $plugin_slug;
    public $type_plural;
    public $post_setting_group;
    public $type_setting_id;
    public $tmpl_setting_id;
    public $width_setting_id;
    public $pos_setting_id;
    public $sections_setting_id;
    public $body_color_setting_id;
    public $header_color_setting_id;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $type_name       		The name of this type.
     * @param      string    $type_slug       		The slug of this type.
     * @param      string    $type_menu_icon  		The admin menu icon of this type.
     */
    public function __construct($type_slug, $type_name= null, $type_menu_icon = null) {

        $this->type_name = $type_name;
        $this->type_slug = $type_slug;
        $this->type_menu_icon = $type_menu_icon;
        $this->plugin_slug = 'mmdb';
        $this->type_plural = $this->get_name_type_plural();
        $this->post_setting_group = $this->get_post_setting_group();
        $this->type_setting_id = $this->make_type_setting_id();
        $this->tmpl_setting_id = $this->make_type_setting_slug('tmpl');
        $this->width_setting_id = $this->make_type_setting_slug('width');
        $this->pos_setting_id = $this->make_type_setting_slug('pos');
        $this->sections_setting_id = $this->make_type_setting_slug('sections');
        $this->body_color_setting_id = $this->make_type_setting_slug('body_color');
        $this->header_color_setting_id = $this->make_type_setting_slug('header_color');
    }

    /**
     * Get the plural name for the post type setting
     *
     * @since     1.0.2
     * @return    string
     */
    public function get_name_type_plural() {

        return $this->type_name . 's';
    }

    /**
     * Get the post type setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    public function get_post_type_setting() {

        $post_setting_name	= $this->plugin_slug .'_'. $this->type_slug .'_post_type';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group , $this->type_slug);
    }

    /**
     * Get the post type setting group
     *
     * @since     1.0.2
     * @return    string
     */
    public function get_post_setting_group() {

        return $this->plugin_slug .'_opt_advanced';
    }

    /**
     * Make the setting id tag for the data type object (used by Settings class)
     *
     * @since     1.0.0
     * @return    string
     */
    protected function make_type_setting_id() {

        $post_setting_slug	= $this->plugin_slug .'_opt_'. $this->type_slug . 's';
        return $post_setting_slug;
    }

    /**
     * Make a setting tag for the data type object (used by Settings class)
     *
     * @since     1.0.0
     * @param     string    $setting_slug  	The setting slug for the setting make
     * @return    string
     */
    protected function make_type_setting_slug($setting_slug) {

        $post_setting_slug	= $this->plugin_slug .'_'. $this->type_slug . '_' . $setting_slug;
        return $post_setting_slug;
    }

    /**
     * Get section function to check for prerequisites
     *
     * @since     1.0.3
     * @param     string $section
     * @param     Movie | TVShow | Person $mmdb
     * @return    array
     */
    public function show_section_if($section,$mmdb) {

        $check_function = 'show_' . $section . '_if';

        return $this->$check_function($mmdb);
    }

    /**
     * Check the section prerequisites
     *
     * @since     1.0.3
     * @param     Movie | TVShow | Person $mmdb
     * @return    bool
     */
    public function show_overview_text_if($mmdb) {

        if($mmdb) {
            // @todo do something with it
        }
        return true;
    }
}

