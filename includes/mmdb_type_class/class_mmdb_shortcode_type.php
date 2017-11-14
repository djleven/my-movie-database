<?php
/**
 * The file that defines the mmdb shortcode class
 *
 * The MMDB_Shortcode_Type class is a subclass of the abstract MMDB_type class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/mmdb_type_class
 */

class MMDB_Shortcode_Type extends MMDB_Type {

    public $template;
    public $size;
    public $header_color;
    public $body_color;
    public $tmdb_type;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $type_slug   The mmdb content type ('slug') for the object
     * @param      string    $tmdb_id     The tmdb id for the type object
     * @param      string    $template    The template for the type object
     * @param      string    $size        The size for the shortcode template
     * @param      string    $hcolor      The header color for the shortcode template
     * @param      string    $bcolor      The background color for shortcodetemplate
     */
    public function __construct(
        $type_slug = 'movie',
        $tmdb_id = '655',
        $template = null,
        $size = null,
        $hcolor = null,
        $bcolor = null
    ) {

        $this->type_slug = $type_slug;
        $this->tmdb_id = $tmdb_id;
        $this->template = $template;
        $this->size = $size;
        $this->header_color = $hcolor;
        $this->body_color = $bcolor;
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

        return 'shortcode';
    }

    /**
     * Handle the shortcode user input
     *
     * @since    1.0.0
     * @param     $atts  	 	an associative array of attributes, or an empty string if no attributes are given
     * @param     $content   	the enclosed content (if the shortcode is used in its enclosing form)
     * @param     string $tag 	the shortcode tag, useful for shared callback functions
     * @return    string     	The MMDB_Shortcode_Type view
     */
    public function mmdb_shortcode($atts, $content = null, $tag = '') {
        // normalize attributes - lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);

        // override default attributes with user input
        $mmdb_show_atts = shortcode_atts([
            'id' => $this->tmdb_id,
            'type' => $this->type_slug,
            'template' => $this->template,
            'size' => $this->size,
            'body' => $this->body_color,
            'header' => $this->header_color
        ], $atts, $tag);

        return $this->mmdb_the_shortcode_view($mmdb_show_atts);
    }

    /**
     * Create the MMDB_Shortcode_Type object
     *
     * @since    1.0.0
     * @param     array    $mmdb_show_atts    The shortcode attributes
     * @return    object    The MMDB_Shortcode_Type object
     */
    protected function mmdb_set_shortcode_content($mmdb_show_atts) {

        $mmdb_type = new MMDB_Shortcode_Type(
            $mmdb_show_atts['type'],
            $mmdb_show_atts['id'],
            $mmdb_show_atts['template'],
            $mmdb_show_atts['size'],
            $mmdb_show_atts['body'],
            $mmdb_show_atts['header']
        );

        return $mmdb_type;
    }

    /**
     * Setup and render the mmdb shortcode view
     *
     * @since    1.0.0
     * @param     array     $mmdb_show_atts    The shortcode attributes
     * @return    string     		The MMDB_Shortcode_Type view
     */
    protected function mmdb_the_shortcode_view($mmdb_show_atts) {

        $mmdb_type = $this->mmdb_set_shortcode_content($mmdb_show_atts);

        $mmdb_content = $mmdb_type->mmdb_the_template_view($mmdb_type);

        return $mmdb_content['output'];
    }

    /**
     * Get the template setting for type object
     * @since     1.1.1
     * @return    string
     */
    protected function get_template_setting() {

        if($this->template) {
            $setting = $this->template;

        } else {
            $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_tmpl';
            $setting = MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), 'tabs');
        }

        return $setting;
    }

    /**
     * Get the header color setting for type object
     *
     * @since     1.1.1
     * @return    string
     */
    protected function get_header_color_setting() {

        if($this->header_color) {
            $setting = $this->header_color;

        } else {
            $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_header_color';
            $setting = MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), '#265a88');
        }

        return $setting;
    }

    /**
     * Get the body color setting for type object
     *
     * @since     1.1.1
     * @return    string
     */
    protected function get_body_color_setting() {

        if($this->body_color) {
            $setting = $this->body_color;

        } else {
            $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_body_color';
            $setting = MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), '#DCDCDC');
        }

        return $setting;
    }

    /**
     * Get the width setting for type object
     *
     * @since     1.0.2
     * @return    string
     */
    protected function get_width_setting() {

        if($this->size) {
            $setting = $this->size;

        } else {
            $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_width';
            $setting = MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), 'medium');
        }

        return $setting;
    }

    /**
     * Register the shortcode with wordpress
     *
     * @since    1.0.0
     */
    public function mmdb_shortcodes_init() {

        add_shortcode('my_movie_db', array( $this, $this->plugin_slug() . '_shortcode' ));
    }

}

