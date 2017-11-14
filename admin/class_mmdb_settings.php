<?php
/**
 * Defines the option page settings functionality for the plugin.
 *
 * @link       https://e-leven.net/
 * @since      0.7.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */

class MMDB_Admin_Settings {

    private $settings_api;
    private $plugin_admin_types;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.7.0
     * @param      array    $plugin_admin_types    The tmdb data types.
     */
    public function __construct($plugin_admin_types) {
        $this->settings_api = new WeDevs_Settings_API;
        $this->plugin_admin_types = $plugin_admin_types;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    /**
     * Initialize and register all the settings sections and fields with Wordpress
     *
     * @since    0.7.0
     * @return void all settings sections and fields
     */

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_options_page( 'The Movie Database for WP Options', 'My Movie Database', 'manage_options', 'mmdb_settings', array($this, 'plugin_page') );
    }

    /**
     * Dynamically get/set the settings sections associated with TMDB data type views available to the plugin
     *
     * @since    1.0.0
     * @return   array   		data type settings sections
     */
    private function get_types_settings_sections() {

        $sections = [];
        $plugin_admin_types = $this->plugin_admin_types;

        foreach($plugin_admin_types as $plugin_admin_type) {

            $sections[] =
                [
                    'id'    => $plugin_admin_type->type_setting_id,
                    'title' => esc_html__( "$plugin_admin_type->type_name Settings", 'my-movie-db' )
                ];
        }

        return $sections;
    }

    /**
     * Get/set the settings sections that go before the TMDB data type views (ex: Basic settings)
     *
     * @since    1.0.0
     * @return   array   'before' settings sections
     */

    /**
    private function get_before_settings_sections() {

    $sections[] =
    array(
    'id'    => 'mmdb_opt_basic',
    'title' => esc_html__( 'Basic Settings', 'my-movie-db' )
    );
    return $sections;
    }
     */

    /**
     * Get/set the settings sections that go after the TMDB data type views (ex: Advanced settings)
     *
     * @since    1.0.0
     * @return   array   'after' settings sections
     */
    private function get_after_settings_sections() {

        $sections[] =
            [
                'id'    => 'mmdb_opt_advanced',
                'title' => esc_html__( 'Advanced Settings', 'my-movie-db' )
            ];

        return $sections;
    }

    /**
     * Get/set all the settings sections to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other seperate section functions which are merged here
     * @return    array    		all settings sections
     */
    private function get_settings_sections() {

        //$sections1 = $this->get_before_settings_sections();
        $sections2 = $this->get_types_settings_sections();
        $sections3 = $this->get_after_settings_sections();

        //$sections = array_merge($sections1, $sections2, $sections3);
        $sections = array_merge($sections2, $sections3);

        return $sections;
    }

    /**
     * Dynamically get/set the settings fields associated with TMDB data type views available to the plugin
     *
     * @since    1.0.0
     * @return   array   		data type settings fields
     */
    private function get_types_settings_fields() {

        $plugin_admin_types = $this->plugin_admin_types;
        $k = 1;
        $merge_settings = [];

        foreach($plugin_admin_types as $plugin_type) {

            $settings_fields[$k] = array(

                $plugin_type->type_setting_id => array(

                    array(
                        'name'    => $plugin_type->tmpl_setting_id,
                        'label'   => esc_html__( "$plugin_type->type_name template", 'my-movie-db' ),
                        'desc'    => esc_html__( 'Select the template to use. The custom template is empty by default', 'my-movie-db' ),
                        'type'    => 'select',
                        'default' => 'tabs',
                        'options' => array(
                            'tabs' => esc_html__( 'With tabs', 'my-movie-db' ),
                            'accordion' => esc_html__( 'With accordion', 'my-movie-db' ),
                            'custom'  => esc_html__( 'Custom template', 'my-movie-db' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->width_setting_id,
                        'label'   => esc_html__( "$plugin_type->type_name width", 'my-movie-db' ),
                        'desc'    => esc_html__( 'Select the responsive widths to use. Full-width if you have a no sidebar layout, one-sidebar if you have, well, one sidebar(!), etc', 'my-movie-db' ),
                        'type'    => 'select',
                        'default' => 'large',
                        'options' => array(
                            'large' => esc_html__( 'Full-width', 'my-movie-db' ),
                            'medium' => esc_html__( 'One sidebar', 'my-movie-db' ),
                            'small' => esc_html__( 'Two sidebars', 'my-movie-db' ),
                        )
                    ),

                    array(
                        'name'    => $plugin_type->pos_setting_id,
                        'label'   => esc_html__( 'Display position', 'my-movie-db' ),
                        'desc'    => esc_html__( 'Choose to display MMDB info before or after the content', 'my-movie-db' ),
                        'type'    => 'radio',
                        'default' => 'after',
                        'options' => array(
                            'after'  => esc_html__( 'After content', 'my-movie-db' ),
                            'before' => esc_html__( 'Before content', 'my-movie-db' )
                        )
                    ),
                    array(
                        'name'    => $plugin_type->sections_setting_id,
                        'label'   => esc_html__( 'Hide sections', 'my-movie-db' ),
                        'desc'    => esc_html__( 'Select the sections to be hidden', 'my-movie-db' ),
                        'type'    => 'multicheck',
                        'default' => '',
                        'options' => $plugin_type->set_hide_sections_setting()
                    ),

                    array(
                        'name'    => $plugin_type->header_color_setting_id,
                        'label'   => esc_html__( 'Header Background Color', 'my-movie-db' ),
                        'desc'    => esc_html__( "Background color for the $plugin_type->type_slug headers", 'my-movie-db' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#265a88'
                    ),
                    array(
                        'name'    => $plugin_type->body_color_setting_id,
                        'label'   => esc_html__( 'Body Color', 'my-movie-db' ),
                        'desc'    => esc_html__( "Background color for the $plugin_type->type_slug content", 'my-movie-db' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#DCDCDC'
                    ),

                )
            );

            $merge_settings  = array_merge( $merge_settings, $settings_fields[$k]);
            $k++;
        }

        return $merge_settings;
    }

    /**
     * Get/set the settings fields that go after the TMDB data type views (ex: Advanced settings fields)
     *
     * @since    1.0.0
     * @return   array   'after' settings fields
     */

    /**
    private function get_before_settings_fields() {

    }
     */

    /**
     * Get/set the settings fields that go after the TMDB data type views (ex: Advanced settings fields)
     *
     * @since    1.0.0
     * @return   array   'after' settings fields
     */
    private function get_after_settings_fields() {

        $settings_fields = array(

            'mmdb_opt_advanced' => array(
                array(
                    'name'    => 'mmdb_movie_post_type',
                    'label'   => esc_html__( 'Enable "Movies" section?', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Movies post type - what is to be done?', 'my-movie-db' ),
                    'type'    => 'radio',
                    'default' => 'movie',
                    'options' => array(
                        'movie'  => esc_html__( 'Yes, use a "Movies" post section (custom post type)', 'my-movie-db' ),
                        'posts_custom' => esc_html__( 'No, use Posts but change the "Posts" menu label to "Movies"', 'my-movie-db' ),
                        'posts'  => esc_html__( 'No, use Posts and leave them as they are', 'my-movie-db' ),
                        'no_post'  => esc_html__( 'None of the above, I only want to use Movies with shortcodes (or not at all)', 'my-movie-db' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_tvshow_post_type',
                    'label'   => esc_html__( 'Enable "Tvshows" section?', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Tvshows post type - what is to be done?', 'my-movie-db' ),
                    'type'    => 'radio',
                    'default' => 'tvshow',
                    'options' => array(
                        'tvshow'  => esc_html__( 'Yes, use a "TvShows" post section (custom post type)', 'my-movie-db' ),
                        'no_post'  => esc_html__( 'No no, I only want to use TvShows with shortcodes (or not at all)', 'my-movie-db' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_person_post_type',
                    'label'   => esc_html__( 'Enable "Persons" section?', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Persons post type - what is to be done?', 'my-movie-db' ),
                    'type'    => 'radio',
                    'default' => 'person',
                    'options' => array(
                        'person'  => esc_html__( 'Yes, use a "Persons" post section (custom post type)', 'my-movie-db' ),
                        'no_post'  => esc_html__( 'No no, I only want to use Persons with shortcodes (or not at all)', 'my-movie-db' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_css_file',
                    'label'   => esc_html__( 'Include plugin css file', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Select when to load the plugin css file, selecting No will never load the plugin css file', 'my-movie-db' ),
                    'type'    => 'select',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, load it for posts that use my-movie-database only', 'my-movie-db' ),
                        'all'  => esc_html__( 'Yes, but load it for all wp pages (for use with archive, etc)', 'my-movie-db' ),
                        'no' => esc_html__( 'No',  'my-movie-db' )
                    )
                ),
                array(
                    'name'    => 'mmdb_bootstrap',
                    'label'   => esc_html__( 'Include bootstrap', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Default templates require bootstrap libraries, select No if you dont want this plugin to include them', 'my-movie-db' ),
                    'type'    => 'select',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, load it for my-movie-database pages only', 'my-movie-db' ),
                        'all'  => esc_html__( 'Yes, but load it for all wp pages', 'my-movie-db' ),
                        'no' => esc_html__( 'No',  'my-movie-db' )
                    )
                ),
                array(
                    'name'    => 'mmdb_wp_categories',
                    'label'   => esc_html__( 'Wordpress Categories', 'my-movie-db' ),
                    'desc'    => esc_html__( 'Default Wordpress categories can be selectable for your your mmdb posts', 'my-movie-db' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, allow movies, tvshows and persons to be associated to wordpress categories', 'my-movie-db' ),
                        'no_archive_pages' => esc_html__( 'Yes, associate them but do not show mmdb type posts in wordpress category pages as it conflicts with my theme or plugins', 'my-movie-db' ),
                        'no'  => esc_html__( 'No, do not use wordpress categories', 'my-movie-db' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_debug',
                    'label'   => esc_html__( 'Debug Mode', 'my-movie-db' ),
                    'desc'    => esc_html__( 'This will simply output the call to TMDB', 'my-movie-db' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => 'OFF',
                        true  => 'ON'
                    )
                ),


            )
        );

        return $settings_fields;
    }

    /**
     * Get/set all the settings fields to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other seperate section functions which are merged here
     * @return    array    		all settings fields
     */
    private function get_settings_fields() {

        //$settings_fields1 = $this->get_before_settings_fields();
        $settings_fields2 = $this->get_types_settings_fields();
        $settings_fields3 = $this->get_after_settings_fields();

        //$settings_fields = array_merge($settings_fields1, $settings_fields2, $settings_fields3);
        $settings_fields = array_merge($settings_fields2, $settings_fields3);
        return $settings_fields;
    }

    /**
     * Make plugin option page
     *
     * @since    0.7.0
     * @return string
     */
    public function plugin_page() {
        echo '<div style="height:70px;"><img src="' . plugin_dir_url( dirname(__FILE__)) . 'admin/img/icon-64x64.png" style="float:left;padding: 10px 0; "/><h1 style="float:left;padding: 15px 10px;">My Movie Database Options</h1></div>';
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

}

