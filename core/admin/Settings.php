<?php
/**
 * Defines the option page settings functionality for the plugin.
 *
 * @link       https://e-leven.net/
 * @since      0.7.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\ActionHookSubscriberInterface;

class Settings implements ActionHookSubscriberInterface {

    private $settings_api;
    private $plugin_resource_types;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.7.0
     * @param      array    $plugin_resource_types    The tmdb resource (data) types.
     */
    public function __construct($plugin_resource_types) {
        $this->settings_api = new \WeDevs_Settings_API;
        $this->plugin_resource_types = $plugin_resource_types;
    }

    /**
     * Get the action hooks to be registered related to the admin settings.
     *
     * Enqueue scripts
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'admin_init'   => 'admin_init',
            'admin_menu'   => 'admin_menu',
        ];
    }

    /**
     * Initialize and register all the settings sections and fields with Wordpress
     *
     * @since    0.7.0
     * @return void all settings sections and fields
     */

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->getSettingsSections() );
        $this->settings_api->set_fields( $this->getSettingsFields() );

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
    private function getTypeSections() {

        $sections = [];

        foreach($this->plugin_resource_types as $plugin_resource_type) {

            $sections[] =
                [
                    'id'    => $plugin_resource_type->type_setting_id,
                    'title' => esc_html__( $plugin_resource_type->data_type_label, 'my-movie-database' ) . ' ' .  esc_html__( 'Settings', 'my-movie-database' )
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
    private function getBeforeTypesSections() {

    $sections[] =
    array(
    'id'    => 'mmdb_opt_basic',
    'title' => esc_html__( 'Basic Settings', 'my-movie-database' )
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
    private function getAfterTypesSections() {

        return [[
                'id'    => MMDB_ADVANCED_OPTION_GROUP,
                'title' => esc_html__( 'Advanced Settings', 'my-movie-database' )
            ]];
    }

    /**
     * Get/set all the settings sections to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other seperate section functions which are merged here
     * @return    array    		all settings sections
     */
    private function getSettingsSections() {

        return array_merge(
//            $this->getBeforeTypesSections(),
            $this->getTypeSections(),
            $this->getAfterTypesSections()
        );
    }

    /**
     * Dynamically get/set the settings fields associated with TMDB data type views available to the plugin
     *
     * @since    1.0.0
     * @return   array   		data type settings fields
     */
    private function getTypeSectionFields() {

        $plugin_resource_types = $this->plugin_resource_types;
        $k = 1;
        $merge_settings = [];

        foreach($plugin_resource_types as $plugin_type) {

            $settings_fields[$k] = array(

                $plugin_type->type_setting_id => array(

                    array(
                        'name'    => $plugin_type->tmpl_setting_id,
                        'label'   => __( $plugin_type->data_type_label, 'my-movie-database' ). ' - ' . __( 'template', 'my-movie-database' ),
                        'desc'    => esc_html__( 'Select the template to use', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => 'tabs',
                        'options' => array(
                            'tabs' => esc_html__( 'With tabs', 'my-movie-database' ),
                            'accordion' => esc_html__( 'With accordion', 'my-movie-database' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->width_setting_id,
                        'label'   => __( $plugin_type->data_type_label, 'my-movie-database' ). ' - ' . __( 'width', 'my-movie-database' ),
                        'desc'    => esc_html__( 'Select the responsive widths to use. Full-width if you have a no sidebar layout, one-sidebar if you have, well, one sidebar(!), etc', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => 'large',
                        'options' => array(
                            'large' => esc_html__( 'Full-width', 'my-movie-database' ),
                            'medium' => esc_html__( 'One sidebar', 'my-movie-database' ),
                            'small' => esc_html__( 'Two sidebars', 'my-movie-database' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->transition_effect_setting_id,
                        'label'   => esc_html__( "Transition effect", 'my-movie-database' ),
                        'desc'    => esc_html__( 'Select the transition effect to use when switching sections', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => 'fade',
                        'options' => array(
                            'fade' => esc_html__( 'Fade', 'my-movie-database' ),
                            'bounce' => esc_html__( 'Bounce', 'my-movie-database' ),
                            'none' => esc_html__( 'None', 'my-movie-database' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->pos_setting_id,
                        'label'   => esc_html__( 'Display position', 'my-movie-database' ),
                        'desc'    => esc_html__( 'Choose to display MMDB info before or after the content', 'my-movie-database' ),
                        'type'    => 'radio',
                        'default' => 'after',
                        'options' => array(
                            'after'  => esc_html__( 'After content', 'my-movie-database' ),
                            'before' => esc_html__( 'Before content', 'my-movie-database' )
                        )
                    ),
                    array(
                        'name'    => $plugin_type->sections_setting_id,
                        'label'   => esc_html__( 'Hide sections', 'my-movie-database' ),
                        'desc'    => esc_html__( 'Select the sections to be hidden', 'my-movie-database' ),
                        'type'    => 'multicheck',
                        'default' => '',
                        'options' => $plugin_type->setHideSectionsSetting()
                    ),

                    array(
                        'name'    => $plugin_type->header_color_setting_id,
                        'label'   => esc_html__( 'Header Background Color', 'my-movie-database' ),
                        'desc'    => esc_html__( "Background color for the template header", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#265a88'
                    ),
	                array(
		                'name'    => $plugin_type->header_font_color_setting_id,
		                'label'   => esc_html__( 'Header Font Color', 'my-movie-database' ),
		                'desc'    => esc_html__( "Font color for the template header", 'my-movie-database' ),
		                'type'    => 'color',
		                'sanitize_callback' => 'sanitize_text_field',
		                'default' => '#DCDCDC'
	                ),
                    array(
                        'name'    => $plugin_type->body_color_setting_id,
	                    /* translators: This should say 'Body Background Color' instead of 'Body Color' . Please translate as 'Body Background Color' */
                        'label'   => esc_html__( 'Body Color', 'my-movie-database' ),
                        'desc'    => esc_html__( "Background color for the template content", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#DCDCDC'
                    ),
	                array(
		                'name'    => $plugin_type->body_font_color_setting_id,
		                'label'   => esc_html__( 'Body Font Color', 'my-movie-database' ),
		                'desc'    => esc_html__( "Font color for the template content", 'my-movie-database' ),
		                'type'    => 'color',
		                'sanitize_callback' => 'sanitize_text_field',
		                'default' => '#265a88'
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
    private function getBeforeTypeSectionsFields() {

    }
     */

    /**
     * Get/set the settings fields that go after the TMDB data type views (ex: Advanced settings fields)
     *
     * @since    1.0.0
     * @return   array   'after' settings fields
     */
    private function getAfterTypeSectionsFields() {

        return [
            MMDB_ADVANCED_OPTION_GROUP => array(
                array(
                    'name'    => 'mmdb_movie_post_type',
                    'label'   => esc_html__( 'Enable "Movies" section?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Movies post type - what is to be done?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'movie',
                    'options' => array(
                        'movie'  => esc_html__( 'Yes, use a "Movies" post section (custom post type)', 'my-movie-database' ),
                        'posts_custom' => esc_html__( 'No, use Posts but change the "Posts" menu label to "Movies"', 'my-movie-database' ),
                        'posts'  => esc_html__( 'No, use Posts and leave them as they are', 'my-movie-database' ),
                        'no_post'  => esc_html__( 'None of the above, I only want to use Movies with shortcodes (or not at all)', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_tvshow_post_type',
                    'label'   => esc_html__( 'Enable "Tvshows" section?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Tvshows post type - what is to be done?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'tvshow',
                    'options' => array(
                        'tvshow'  => esc_html__( 'Yes, use a "TvShows" post section (custom post type)', 'my-movie-database' ),
                        'no_post'  => esc_html__( 'No no, I only want to use TvShows with shortcodes (or not at all)', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_person_post_type',
                    'label'   => esc_html__( 'Enable "Persons" section?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Persons post type - what is to be done?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'person',
                    'options' => array(
                        'person'  => esc_html__( 'Yes, use a "Persons" post section (custom post type)', 'my-movie-database' ),
                        'no_post'  => esc_html__( 'No no, I only want to use Persons with shortcodes (or not at all)', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_gutenberg_post_type',
                    'label'   => esc_html__( 'Enable the Gutenberg editor for the plugin post types?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Use the Gutenberg editor?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => __('No'),
                        true  => __('Yes'),
                    )
                ),
                array(
                    'name'    => 'mmdb_css_file',
                    'label'   => esc_html__( 'Include plugin css file', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Select when to load the plugin css file, selecting No will never load the plugin css file', 'my-movie-database' ),
                    'type'    => 'select',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, load it for posts that use my-movie-database only', 'my-movie-database' ),
                        'all'  => esc_html__( 'Yes, but load it for all wp pages (for use with archive, etc)', 'my-movie-database' ),
                        'no' => esc_html__( 'No',  'my-movie-database' )
                    )
                ),
                array(
                    'name'    => 'mmdb_wp_categories',
                    'label'   => esc_html__( 'Wordpress Categories', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Default Wordpress categories can be selectable for your your mmdb posts', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, allow movies, tvshows and persons to be associated to wordpress categories', 'my-movie-database' ),
                        'no_archive_pages' => esc_html__( 'Yes, associate them but do not show mmdb type posts in wordpress category pages as it conflicts with my theme or plugins', 'my-movie-database' ),
                        'no'  => esc_html__( 'No, do not use wordpress categories', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_hierarchical_taxonomy',
                    'label'   => esc_html__( 'Hierarchical Categories', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Plugin categories can be hierarchical (have parents / children) or not. Non-hierarchical categories behave like wordpress tags', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, I want the standard hierarchical categories', 'my-movie-database' ),
                        'no'  => esc_html__( 'No, I want categories to be in the form of tags', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_overview_on_hover',
                    'label'   => esc_html__( "Overview on hover", 'my-movie-database' ),
                    'desc'    => esc_html__( 'Show description on hover for person credits and tvshow seasons', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => true,
                    'options' => array(
                        true => __('Yes'),
                        false => __('No'),
                    )
                ),
                array(
                    'name'    => 'mmdb_debug',
                    'label'   => esc_html__( 'Debug Mode', 'my-movie-database' ),
                    'desc'    => esc_html__( "Will output data received from TMDB in your browser's (web developer tools) console", 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => esc_html__('Disabled'),
                        true  => esc_html__('Enabled')
                    )
                )
            )
        ];
    }

    /**
     * Get/set all the settings fields to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other seperate section functions which are merged here
     * @return    array    		all settings fields
     */
    private function getSettingsFields() {

        return array_merge(
//                $this->getBeforeTypeSectionsFields(),
                $this->getTypeSectionFields(),
                $this->getAfterTypeSectionsFields()
        );

    }

    /**
     * Get/set all the settings fields to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     * @since    1.0.0 			split into other seperate section functions which are merged here
     *
     * @return    array
     */
    private function getHeaderInfo() {

        return [
            [
                'title' => esc_html__( 'Get Help',  'my-movie-database' ),
                'rows' => [
                    [
                        'title' => esc_html__( 'Documentation',  'my-movie-database' ),
                        'span_class' => 'dashicons-editor-help',
                        'url' => 'https://mymoviedatabase.cinema.ttic.ca/how-to-use-the-mmdb-plugin/',
                        'url-text' => esc_html__( 'How to use the plugin.',  'my-movie-database' )
                    ],
                    [
                        'title' => esc_html__( 'Documentation',  'my-movie-database' ),
                        'span_class' => 'dashicons-admin-tools',
                        'url' => 'https://mymoviedatabase.cinema.ttic.ca/plugin-configuration-mmdb-options-page/',
                        'url-text' => esc_html__( 'Configuration options',  'my-movie-database' )
                    ],
                    [
                        'title' => esc_html__( 'Support',  'my-movie-database' ),
                        'span_class' => 'dashicons-tickets-alt',
                        'url' => 'https://wordpress.org/support/plugin/my-movie-database/',
                        'text' => esc_html__( 'Still can\'t figure it out?',  'my-movie-database' ),
                        'url-text' => esc_html__( 'Open up a ticket.',  'my-movie-database' )
                    ],
                ],
            ],
            [
                'title' => esc_html__( 'Give Help - Contribute',  'my-movie-database' ),
                'rows' => [
                    [
                        'title' => esc_html__( 'Review',  'my-movie-database' ),
                        'span_class' => 'dashicons-star-half',
                        'url' => 'https://wordpress.org/support/plugin/my-movie-database/reviews/',
                        'text' => esc_html__( 'It means a lot to us.',  'my-movie-database' ),
                        'url-text' => esc_html__( 'Please leave your review.',  'my-movie-database' ),
                    ],
                    [
                        'title' => esc_html__( 'Translate',  'my-movie-database' ),
                        'span_class' => 'dashicons-flag',
                        'url' => 'https://translate.wordpress.org/projects/wp-plugins/my-movie-database/',
                        'text' => __( 'Help'),
                        'url-text' => esc_html__( 'translate the plugin in your language.',  'my-movie-database' )
                    ],
                    [
                        'title' => esc_html__( 'Donate',  'my-movie-database' ),
                        'span_class' => 'dashicons-buddicons-community',
                        'url' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Y5DGNQGZU92N6',
                        'text' => esc_html__( 'Or if you prefer, maybe',  'my-movie-database'  ),
                        'url-text' => esc_html__( 'buy us a beer?',  'my-movie-database'  )
                    ],
                ]
            ]
        ];
    }

    /**
     * Make plugin option page
     *
     * @since    0.7.0
     * @return  void
     */
    public function plugin_page() {
        ?>
        <style>
            .mmdb_admin_header {
                height: 70px;
            }
            .mmdb_admin_header .admin-logo {
                float:left;
                padding: 10px 0;
            }
            .mmdb_admin_header h1 {
                float:left;
                padding: 15px 10px;
            }
            .mmdb-row {
                clear: both;
            }
            .mmdb-row h3 {
                margin: 0;
                text-align: center;
            }
            .mmdb-row .update-nag span {
                padding-right: 5px;
            }
        </style>
        <div class="mmdb_admin_header">
            <img src="<?php echo MMDB_PLUGIN_URL ;?>static/img/icon-64x64.png" class="admin-logo"/>
            <h1><?php echo __( 'My Movie Database',  'my-movie-database' ) . ' - ' . __( 'Settings' );?></h1>
        </div>
        <div class="mmdb-row">
            <?php foreach($this->getHeaderInfo() as $info) :?>
            <div class="update-nag">
                <h3><?php echo $info['title']?></h3>
                <ul>
                    <?php foreach($info['rows'] as $row) :?>
                    <li>
                        <span class="dashicons <?php echo $row['span_class']?>"></span><strong><?php echo $row['title']?>:</strong>
                        <?php $text = isset($row['text']) ? $row['text'] : ''; echo $text; ?>
                        <a href="<?php echo $row['url']?>" target="_blank">
                            <?php echo $row['url-text']?>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php endforeach;?>
        </div>

        <div class="wrap">

        <?php

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

}

