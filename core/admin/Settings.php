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

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;

use MyMovieDatabase\Constants;
use MyMovieDatabase\TemplateFiles;

class Settings implements ActionHookSubscriberInterface {

    use SettingsHeader;

    private $settings_api;
    private $plugin_resource_types;

    /**
     * The screen of current WordPress request
     *
     * @since     3.0.0
     * @var       SettingsCacheController
     */
    public $cacheController;


    /**
     * Initialize the class and set its properties.
     *
     * @since    0.7.0
     * @param      array    $plugin_resource_types    The tmdb resource (data) types.
     */
    public function __construct($plugin_resource_types) {
        $this->cacheController = new SettingsCacheController();
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
            'admin_enqueue_scripts' => 'enqueue_scripts',
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

    /**
     * Register the script(s) for the settings page.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        $settings_js_file = 'admin-settings';
        wp_enqueue_script( 'mmodb-admin-settings', TemplateFiles::getJsFilePath($settings_js_file), ['jquery'],0.1, true);
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
                    'title' => esc_html__( $plugin_resource_type->data_type_label, 'my-movie-database' )
                ];
        }

        return $sections;
    }

    /**
     * Get/set the settings sections that go after the TMDB data type views (ex: Advanced settings)
     *
     * @since    1.0.0
     * @return   array   'after' settings sections
     */
    private function getAfterTypesSections() {

        return [[
                'id'    => MMDB_ADVANCED_OPTION_GROUP,
                'title' => esc_html__( Constants::I18n_CORE_ADVANCED_OPTIONS )
            ],
            [
                'id'    => Constants::CACHE_MANAGER_OPTION_GROUP,
                'title' => esc_html__( 'Cache manager', 'my-movie-database' ),
            ]
        ];
    }

    /**
     * Get/set all the settings sections to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other separate section functions which are merged here
     * @return    array    		all settings sections
     */
    private function getSettingsSections() {

        return array_merge(
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
                        'label'   =>  __( Constants::I18n_CORE_TEMPLATE ),
                        'desc'    => esc_html__( 'Select the template to use', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => 'tabs',
                        'options' => array(
                            'tabs' => esc_html__( 'With tabs', 'my-movie-database' ),
                            'accordion' => esc_html__( 'With accordion', 'my-movie-database' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->header_color_setting_id,
                        'label'   => __( Constants::I18n_CORE_HEADER ) . ' - ' . __( Constants::I18n_CORE_BG_COLOR ),
                        'desc'    => __( "Background color for the template header", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#265a88'
                    ),
                    array(
                        'name'    => $plugin_type->header_font_color_setting_id,
                        'label'   => __( Constants::I18n_CORE_HEADER ) . ' - ' . __( Constants::I18n_CORE_TEXT_COLOR ),
                        'desc'    => esc_html__( "Font color for the template header", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#DCDCDC'
                    ),
                    array(
                        'name'    => $plugin_type->body_color_setting_id,
                        'label'   => _x( Constants::I18n_CORE_BODY, Constants::I18n_CORE_BODY_CTX  ) . ' - ' . __( Constants::I18n_CORE_BG_COLOR),
                        'desc'    => esc_html__( "Background color for the template content", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#DCDCDC'
                    ),
                    array(
                        'name'    => $plugin_type->body_font_color_setting_id,
                        'label'   => _x( Constants::I18n_CORE_BODY, Constants::I18n_CORE_BODY_CTX ) . ' - ' . __( Constants::I18n_CORE_TEXT_COLOR ),
                        'desc'    => esc_html__( "Font color for the template content", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => '#265a88'
                    ),
                    array(
                        'name'    => $plugin_type->width_setting_id,
                        'label'   => esc_html__( 'Size of Images / Columns', 'my-movie-database'),
                        'desc'    => esc_html__( 'Select the size of images for sections that display lists (ex: Crew and cast sections). Also affects column size of the responsive grid layout.', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => 'large',
                        'options' => array(
                            'large' => __( Constants::I18n_CORE_LARGE),
                            'medium' => __( Constants::I18n_CORE_MEDIUM),
                            'small' => __( Constants::I18n_CORE_SMALL),
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
                            'none' => __( Constants::I18n_CORE_NONE ),
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

                )
            );

            $merge_settings  = array_merge( $merge_settings, $settings_fields[$k]);
            $k++;
        }

        return $merge_settings;
    }

    /**
     * Get the label for the "enable plugin'/s custom post type section" setting
     *
     * @param string $type
     *
     * @return   string
     * @since    3.0.0
     */
    private function getEnableSectionLabel($type) {
        return sprintf(
            esc_html__( 'Enable "%s" section?', 'my-movie-database' ),
            __($type, 'my-movie-database')
        );
    }

    /**
     * Get the label for the "enable plugin'/s custom post type section" 'Yes' option
     *
     * @param string $type
     *
     * @return   string
     * @since    3.0.0
     */
    private function getEnableSectionYesOptionLabel($type) {
        return __( Constants::I18n_CORE_YES ) . '. '
               . sprintf(
                   esc_html__('Use a "%s" posts section (custom post type)', 'my-movie-database' ),
                   __($type, 'my-movie-database')
               );
    }

    /**
     * Get the label for the "enable plugin'/s custom post type section" 'No' option
     *
     * @param string $type
     * @param null $no_msg
     *
     * @return   string
     * @since    3.0.0
     */
    private function getEnableSectionNoOptionLabel($type, $no_msg = null) {

        if($no_msg === null) {
            $no_msg = __( Constants::I18n_CORE_NO );
        }
        return $no_msg . '. '
               . sprintf(
                   esc_html__('I only want to use "%s" with shortcodes and / or Gutenberg Blocks (or not at all)', 'my-movie-database' ),
                   __($type, 'my-movie-database')
               );
    }

    /**
     * Get/set the settings fields that go after the TMDB data type views (ex: Advanced settings fields)
     *
     * @since    1.0.0
     * @return   array   'after' settings fields
     */
    private function getAfterTypeSectionsFields() {

        $movies_label = MovieResourceType::getI18nDefaultPluralLabel();
        $tv_shows_label = TvshowResourceType::getI18nDefaultPluralLabel();
        $people_label = PersonResourceType::getI18nDefaultPluralLabel();

        return [
            MMDB_ADVANCED_OPTION_GROUP => array(
                array(
                    'name'    => 'mmdb_movie_post_type',
                    'label'   => $this->getEnableSectionLabel($movies_label),
                    'type'    => 'radio',
                    'default' => 'movie',
                    'options' => array(
                        'movie'  => $this->getEnableSectionYesOptionLabel($movies_label),
                        'posts_custom' => esc_html__( 'No, use Posts but change the "Posts" menu label to "Movies"', 'my-movie-database' ),
                        'posts'  => esc_html__( 'No, use Posts and leave them as they are', 'my-movie-database' ),
                        'no_post'  => $this->getEnableSectionNoOptionLabel(
                                'Movies',
                                esc_html__( 'None of the above', 'my-movie-database' )
                        )
                    )
                ),
                array(
                    'name'    => 'mmdb_tvshow_post_type',
                    'label'   => $this->getEnableSectionLabel($tv_shows_label),
                    'type'    => 'radio',
                    'default' => 'tvshow',
                    'options' => array(
                        'tvshow'  => $this->getEnableSectionYesOptionLabel($tv_shows_label),
                        'no_post'  => $this->getEnableSectionNoOptionLabel($tv_shows_label),
                    )
                ),
                array(
                    'name'    => 'mmdb_person_post_type',
                    'label'   => $this->getEnableSectionLabel($people_label),
                    'type'    => 'radio',
                    'default' => 'person',
                    'options' => array(
                        'person'  => $this->getEnableSectionYesOptionLabel($people_label),
                        'no_post' => $this->getEnableSectionNoOptionLabel($people_label),
                    )
                ),
                array(
                    'name'    => 'mmdb_hierarchical_taxonomy',
                    'label'   => __( Constants::I18n_CORE_CATEGORIES ) . ' / ' . __( Constants::I18n_CORE_TAGS ) ,
                    'desc' => esc_html__( 'Select the type of taxonomy to be created for each enabled post type section.', 'my-movie-database' ) . PHP_EOL . __( Constants::I18n_CORE_CATEGORIES_TAGS_DESC ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => __( Constants::I18n_CORE_CATEGORIES ),
                        'no'  => __( Constants::I18n_CORE_TAGS ),
                    )
                ),
                array(
                    'name'    => 'mmdb_wp_categories',
                    'label'   => esc_html__( 'Wordpress Categories', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes'  => esc_html__( 'Yes, allow movies, tvshows and persons to be associated to wordpress categories', 'my-movie-database' ),
                        'no_archive_pages' => esc_html__( 'Yes, associate them but do not show mmdb type posts in wordpress category pages as it conflicts with my theme or plugins', 'my-movie-database' ),
                        'no'  => esc_html__( 'No, do not use wordpress categories', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => 'mmdb_overview_on_hover',
                    'label'   => esc_html__( "Overview on hover", 'my-movie-database' ),
                    'desc'    => esc_html__( 'Show description on hover for person credits and tvshow seasons', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => true,
                    'options' => array(
                        false => __(Constants::I18n_CORE_NO),
                        true  => __(Constants::I18n_CORE_YES),
                    )
                ),
                array(
                    'name'    => 'mmdb_css_file',
                    'label'   => esc_html__( 'Include plugin css file', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Select when to load the plugin css file, selecting No will never load the plugin css file', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 'yes',
                    'options' => array(
                        'yes' => __(Constants::I18n_CORE_YES),
                        'no'  => __(Constants::I18n_CORE_NO),
                    )
                ),
                array(
                    'name'    => 'mmdb_tmdb_api_key',
                    'label'   => sprintf(esc_html__( '%s API key', 'my-movie-database'), 'TMDb'),
                    'desc'    => sprintf(esc_html__( 'Enter your %s API key.', 'my-movie-database' ), 'TMDb'),
                    'type'    => 'password',
                    'sanitize_callback' => 'sanitize_key',
                ),
                array(
                    'name'    => 'mmdb_disable_gutenberg_post_type',
                    'label'   => esc_html__( 'Disable the Gutenberg editor?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Stop using the Gutenberg editor for the plugin\'s post types?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => __(Constants::I18n_CORE_NO),
                        true  => __(Constants::I18n_CORE_YES),
                    )
                ),
                array(
                    'name'    => 'mmdb_debug',
                    'label'   => esc_html__( 'Debug Mode', 'my-movie-database' ),
                    'desc'    => esc_html__( "Will output data received from TMDB in your browser's (web developer tools) console", 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => __(Constants::I18n_CORE_DISABLED),
                        true  => __(Constants::I18n_CORE_ENABLED)
                    )
                )
            )
        ];
    }

    /**
     * Get the cache manager settings fields
     *
     * @since    3.0.0
     * @return   array
     */
    private function getCacheManagerFields() {

        return [
            Constants::CACHE_MANAGER_OPTION_GROUP => [
                [
                    'name'    => Constants::CACHE_MANAGER_DELETE_TYPE,
                    'label'   => esc_html__( 'Resource type to delete', 'my-movie-database' ),
                    'type'    => 'select',
                    'default' => 'select',
                    'options' => [
                        ''  => __( Constants::I18n_CORE_SELECT),
                        'movie'  => esc_html__( 'Movies', 'my-movie-database' ),
                        'tvshow' => esc_html__( 'Tv Show', 'my-movie-database' ),
                        'person'  => esc_html__( 'Person', 'my-movie-database' ),
                    ]
                ],
                [
                    'name'    => Constants::CACHE_MANAGER_DELETE_ID,
                    'label'   => esc_html__( 'Resource TMDb id to delete', 'my-movie-database'),
                    'desc'    => esc_html__( 'Enter the TMDb id of the cached resource to delete', 'my-movie-database' ),
                    'type'    => 'number',
                    'sanitize_callback' => 'sanitize_key',
                ],
            ],
        ];
    }


    /**
     * Get/set all the settings fields to be then initialized and registered via `admin_init` hook
     *
     * @since    0.7.0
     *
     * @since    1.0.0 			split into other separate section functions which are merged here
     * @return    array    		all settings fields
     */
    private function getSettingsFields() {

        return array_merge(
                $this->getTypeSectionFields(),
                $this->getAfterTypeSectionsFields(),
                $this->getCacheManagerFields()
        );
    }

    /**
     * Make plugin option page
     *
     * @since    0.7.0
     * @return  void
     */
    public function plugin_page() {
        $this->getSettingsPageHtml();
        ?>
        <div class="wrap">
        <?php
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

}
