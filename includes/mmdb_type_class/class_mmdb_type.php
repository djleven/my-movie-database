<?php
/**
 * The file that defines the MMDB_Type abstract class
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/mmdb_type_class
 */

abstract class MMDB_Type {

    public $type_slug;
    public $tmdb_id;
    public $public_files;

    /**
     * The mmdb wordpress view type convention
     * Used to organise the structure of template files
     *
     * @since     1.0.0
     * @return    string
     */
    abstract protected function viewType();

    /**
     * Set the data type class prefix to use
     *
     * @since     1.0.9
     * @return    string
     */
    protected function data_type_class() {

        return 'MMDB_Data_Type_';
    }

    /**
     * Set the plugin slug to use
     *
     * @since     1.0.9
     * @return    string
     */
    protected function plugin_slug() {

        return 'mmdb';
    }

    /**
     * The options page group for the concrete MMDB_Type object (based on the latter's wp post type)
     *
     * @since     1.0.0
     * @return    string
     */
    protected function post_setting_group() {

        $post_setting_group	= $this->plugin_slug() .'_opt_'. $this->type_slug .'s';
        return $post_setting_group;
    }

    /**
     * Get the appropriate 'get' callback for the TMDB API wrapper, depending on mmdb view type
     *
     * Used to create MMDB_Type_Content object in version 1.0.0
     * 	+added 	  MMDB_Type_Admin_Content object in version 1.0.1
     * @since     1.0.0
     * @return    string
     */
    protected function getCallback() {

        $callback = null;
        if ($this->type_slug == 'movie') {

            $callback = 'getMovie';
        }
        elseif ($this->type_slug == 'tvshow') {

            $callback = 'getTvshow';
        }
        elseif ($this->type_slug == 'season') {

            $callback = 'getSeason';
        }
        elseif ($this->type_slug == 'person') {

            $callback = 'getPerson';
        }
        //elseif ($this->type_slug == 'episode') {

        //$callback = 'getEpisode';
        //}

        return $callback;
    }

    /**
     * Call the tmdb api and get the data for type object
     *
     * @since     1.0.0
     * @param     object   $mmdb    The TMDB object
     * @return    object
     */
    protected function get_tmdb_content($mmdb) {

        $tmdb_content = null;
        $MetaID = $this->tmdb_id;
        $callback = $this->getCallback();

        if($MetaID && $callback) {
            $tmdb_content = $mmdb->$callback($MetaID);
        }
        return $tmdb_content;
    }

    /**
     * Return the correct template file -
     * Check if a custom template exists in the theme folder, if not, load the plugin template file
     *
     * @since    1.0.0
     * @param      string $template The chosen mmdb template.
     * @param      string $type The mmdb content type (ex:TvShow).
     * @param      string $viewType The wordpress view type (ex:shortcodes or content).
     * @return     string
     */
    protected function mmdb_set_template_order($template, $type, $viewType) {

        if ($theme_file = locate_template(array($this->plugin_slug() .'_templates/'. $viewType . '/' . $type . '/' . $template . '.php'))) {
            $file = $theme_file;
        }
        else {
            // php 7 removed for backwards compatibility with php 5
            // $file = dirname(__FILE__, 3).'/'. $this->plugin_slug() .'_templates/' . $viewType . '/' . $type . '/' . $template . '.php';
            $file = dirname(__FILE__).'/../../'. $this->plugin_slug() .'_templates/' . $viewType . '/' . $type . '/' . $template . '.php';
        }
        try{
            $thisfile = @fopen($file,'r');
            if( !$thisfile ) {
                throw new Exception("The My Movie Database template file $file could not be found",404);
            }
        }
        catch( Exception $e ){
            echo "Error : " . $e->getMessage();
            return;
        }

        return $file;
    }

    /**
     * Return the correct template-part (partial) file -
     *
     * @since    1.0.1
     * @param      string $template The chosen mmdb partial template.
     * @param      string $viewType The wordpress view type (ex:shortcodes or content).
     * @return     string
     */
    protected function mmdb_get_template_part($template, $viewType = 'partials') {

        $partial = $this->mmdb_set_template_order($template, $this->type_slug, $viewType);

        return $partial;
    }


    /**
     * Check a view section against the show/hide admin settings
     *
     * @since    1.0.0
     * @return   boolean
     */
    protected function mmdb_show_section($type) {
        $show = true;
        $settings = null;

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_sections';
        $settings = MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group());

        if ($settings != null) {
            if (in_array($type, $settings)) {
                $show = false;
            }
        }

        return $show;
    }

    /**
     * Retrieve view sections that are to be visible based on show/hide admin settings
     *
     * @since    1.0.0
     * @return   array
     */
    protected function mmdb_show_settings() {
        $views = $this->tmdb_type->sections;
        $result = [];
        foreach($views as $view) {

            $view_value = $this->mmdb_show_section($view);
            $result[$view] = $view_value;

        }

        return $result;

    }

    /**
     * Check visible view sections for data availability
     *
     * @since    1.0.3
     * @param    $views  array
     * @param    $mmdb   Object
     * @return   array
     */
    protected function mmdb_show_if_data($views, $mmdb) {

        $result = [];
        foreach($views as $view => $view_value) {
            if($view_value) {
                $view_value = $this->tmdb_type->show_section_if($view,$mmdb);
            }
            $result[$view] = $view_value;
        }

        return $result;
    }

    /**
     * Get the width setting for type object
     *
     * @since     1.0.2
     * @return    string
     */
    protected function get_width_setting() {

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_width';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), 'medium');
    }

    /**
     * Get the bootstrap width class for multiple column situations like cast or crew
     *
     * @since     1.0.2
     * @return    string
     */
    protected function get_multiple_column_css() {

        $css_class	= '';
        $post_setting	= $this->get_width_setting();

        if ($post_setting=='large') {
            $css_class	= 'col-lg-3 col-md-3 col-sm-6';
        }
        elseif ($post_setting=='medium') {
            $css_class	= 'col-lg-3 col-md-4 col-sm-6';
        }

        elseif ($post_setting=='small') {
            $css_class	= 'col-lg-4 col-md-6 col-sm-6';
        }

        return $css_class;
    }

    /**
     * Get the bootstrap width class for two column situations like in movie-main.php
     *
     * @since     1.0.2
     * @return    string
     */
    protected function get_two_column_css() {

        $css_class	= 'col-lg-6 col-md-6 col-sm-6';
        $post_setting	= $this->get_width_setting();

        if ($post_setting=='small') {
            $css_class	= 'col-lg-6 col-md-6 col-sm-6';
        }

        return $css_class;
    }

    /**
     * Get the header color setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    protected function get_header_color_setting() {

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_header_color';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), '#265a88');
    }

    /**
     * Get the body color setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    protected function get_body_color_setting() {

        $post_setting_name	= $this->plugin_slug() .'_'. $this->type_slug .'_body_color';
        return MMDB_Admin::mmdb_get_option($post_setting_name, $this->post_setting_group(), '#DCDCDC');
    }

    /**
     * Dynamilcally generate CSS from CSS related admin settings
     *
     * @since    1.0.0
     * @param    $mmdbID   string
     * @param    $template string
     * @return   string
     */
    protected function my_dynamic_styles($mmdbID, $template) {

        $styles = [];
        $header_color = $this->get_header_color_setting();
        $uniqueID = '#mmdb-content_' . $mmdbID;
        $type = $this->type_slug;

        $css[$uniqueID . " ." . $this->plugin_slug() . "-header"]["background-color"] = $header_color;
        if($template == 'tabs') {
            $css[$uniqueID . " .nav-tabs > li.active > a,". $uniqueID ." .nav-tabs > li > a:hover"]["background-color"] = $header_color;
            $css[$uniqueID . " .nav-tabs > li.active > a,". $uniqueID ." .nav-tabs > li > a:hover"]["border"] = $header_color . " 1px solid";
            $css[$uniqueID . " .nav-tabs > li.active > a,". $uniqueID ." .nav-tabs > li > a:hover"]["border-color"] = $header_color;
        }
        elseif($template == 'accordion') {
            $css[$uniqueID . " .panel,". $uniqueID ." .panel-default > .panel-heading"]["background-color"] = $header_color;
        }
        $css[$uniqueID . " ." . $this->plugin_slug() . "-body"]["background-color"] = $this->get_body_color_setting();

        $output_css = '';
        foreach($css as $style => $style_array) {

            $output_css.= $style . '{';

            foreach($style_array as $property => $value) {
                $output_css.= $property . ':' . $value . ';';
            }

            $output_css.= '}';
        }
        echo '<style>' . $output_css . '</style>';
    }

    /**
     * Setup and return the type view output and object
     *
     * @since     1.0.0
     * @param     object   $mmdb_type    The concrete MMDB_Type object
     * @param     boolean  $rules    	 Include admin option view settings
     * @return    array
     * @return    object 	$mmdb_type    The concrete MMDB_Type object
     * @return    string	$output    	  The generated template view
     */
    public function mmdb_the_template_view($mmdb_type, $rules = true) {

        $file = null;
        $template = $mmdb_type->get_template_setting();
        $type_slug = $mmdb_type->type_slug;
        $file = $mmdb_type->mmdb_set_template_order($template, $type_slug, $mmdb_type->viewType());

        if ($file) {
            $tmdb = new TMDB();
            $mmdb = $mmdb_type->get_tmdb_content($tmdb);
            if ($mmdb) {
                ob_start();
                $mmdbID = $mmdb->getID() . '_' . $type_slug;
                $mmdbImagePath = $tmdb->getSecureImageURL('w185');
                $mmdbPosterPath = $tmdb->getSecureImageURL('w300');
                $mmdbProfilePath = $tmdb->getSecureImageURL('w132_and_h132_bestv2');
                if ($rules) {
                    $show_settings = $mmdb_type->mmdb_show_if_data($mmdb_type->mmdb_show_settings(), $mmdb);
                    $mmdb_type->my_dynamic_styles($mmdbID, $template);
                }
                include ($file);
                $output = ob_get_clean();

                return array($this->plugin_slug() .'_type' => $mmdb_type, 'output' => $output);
            }
            // @todo: exceptions - else, etc
        }

        return null;
    }

}
