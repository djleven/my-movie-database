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

use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;
use MyMovieDatabase\Constants;
use MyMovieDatabase\I18nConstants;
use MyMovieDatabase\TemplateFiles;
use MyMovieDatabase\Vendor\WpSettingsApi;

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
     * The current version of the plugin.
     *
     * @since    3.0.2
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.7.0
     * @param      array    $plugin_resource_types    The tmdb resource (data) types.
     */
    public function __construct($plugin_resource_types) {
        $this->cacheController = new SettingsCacheController();
        $this->settings_api = new WpSettingsApi;
        $this->plugin_resource_types = $plugin_resource_types;
    }

    /**
     * Get the action hooks to be registered related to the option settings.
     *
     * @since    3.0.0
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
        wp_enqueue_script(
            Constants::PLUGIN_ID_INIT . '_admin_settings',
            TemplateFiles::getJsFilePath($settings_js_file),
            ['jquery'],
            0.1,
            true
        );
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
                'id'    => Constants::ADVANCED_OPTION_GROUP_NAME,
                'title' => esc_html__( I18nConstants::I18n_CORE_ADVANCED_OPTIONS )
            ],
            [
                'id'    => Constants::CACHE_MANAGER_OPTION_GROUP_NAME,
                'title' => esc_html__( 'Cache manager', 'my-movie-database' ),
            ],
            [
                'id'    => Constants::CREDITS_OPTION_GROUP_NAME,
                'html'  => true,
                'desc' => esc_html__( 'This plugin is made possible by the data The Movie Database (TMDb) provides, and we are grateful for their tremendous generosity.', 'my-movie-database' ),
                'title' => esc_html__( I18nConstants::I18n_CORE_CREDITS ),
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
                        'label'   =>  __( I18nConstants::I18n_CORE_TEMPLATE ),
                        'desc'    => esc_html__( 'Select the template to use', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => Constants::OPTION_VALUE_TMPL_TABS,
                        'options' => array(
                            /* translators: Refers to the tabs template. */
                            Constants::OPTION_VALUE_TMPL_TABS => esc_html__( 'With tabs', 'my-movie-database' ),
                            /* translators: Refers to the accordion template. */
                            Constants::OPTION_VALUE_TMPL_ACCORDION => esc_html__( 'With accordion', 'my-movie-database' ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->header_color_setting_id,
                        'label'   => __( I18nConstants::I18n_CORE_HEADER ) . ' - ' . __( I18nConstants::I18n_CORE_BG_COLOR ),
                        'desc'    => __( "Background color for the template header", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => Constants::OPTION_VALUE_COLOR_DEFAULT_ONE
                    ),
                    array(
                        'name'    => $plugin_type->header_font_color_setting_id,
                        'label'   => __( I18nConstants::I18n_CORE_HEADER ) . ' - ' . __( I18nConstants::I18n_CORE_TEXT_COLOR ),
                        'desc'    => esc_html__( "Font color for the template header", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => Constants::OPTION_VALUE_COLOR_DEFAULT_TWO
                    ),
                    array(
                        'name'    => $plugin_type->body_color_setting_id,
                        'label'   => _x( I18nConstants::I18n_CORE_BODY, I18nConstants::I18n_CORE_BODY_CTX  ) . ' - ' . __( I18nConstants::I18n_CORE_BG_COLOR),
                        'desc'    => esc_html__( "Background color for the template content", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => Constants::OPTION_VALUE_COLOR_DEFAULT_TWO
                    ),
                    array(
                        'name'    => $plugin_type->body_font_color_setting_id,
                        'label'   => _x( I18nConstants::I18n_CORE_BODY, I18nConstants::I18n_CORE_BODY_CTX ) . ' - ' . __( I18nConstants::I18n_CORE_TEXT_COLOR ),
                        'desc'    => esc_html__( "Font color for the template content", 'my-movie-database' ),
                        'type'    => 'color',
                        'sanitize_callback' => 'sanitize_text_field',
                        'default' => Constants::OPTION_VALUE_COLOR_DEFAULT_ONE
                    ),
                    array(
                        'name'    => $plugin_type->width_setting_id,
                        'label'   => esc_html__( 'Size of images / columns', 'my-movie-database'),
                        'desc'    => esc_html__( 'Select the size of images for sections that display lists (ex: Crew and cast sections). Also affects column size of the responsive grid layout.', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' =>  Constants::OPTION_VALUE_SIZE_MEDIUM,
                        'options' => array(
                            Constants::OPTION_VALUE_SIZE_LARGE => __( I18nConstants::I18n_CORE_LARGE),
                            Constants::OPTION_VALUE_SIZE_MEDIUM => __( I18nConstants::I18n_CORE_MEDIUM),
                            Constants::OPTION_VALUE_SIZE_SMALL => __( I18nConstants::I18n_CORE_SMALL),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->transition_effect_setting_id,
                        'label'   => esc_html__( "Transition effect", 'my-movie-database' ),
                        'desc'    => esc_html__( 'Select the transition effect to use when switching sections', 'my-movie-database' ),
                        'type'    => 'select',
                        'default' => Constants::OPTION_VALUE_TRANSITION_FADE,
                        'options' => array(
                            /* translators: Refers a transition effect name. */
                            Constants::OPTION_VALUE_TRANSITION_FADE => esc_html__( 'Fade', 'my-movie-database' ),
                            /* translators: Refers a transition effect name. */
                            Constants::OPTION_VALUE_TRANSITION_BOUNCE => esc_html__( 'Bounce', 'my-movie-database' ),
                            Constants::OPTION_VALUE_TRANSITION_NONE => __( I18nConstants::I18n_CORE_NONE ),
                        )
                    ),
                    array(
                        'name'    => $plugin_type->pos_setting_id,
                        'label'   => esc_html__( 'Display position', 'my-movie-database' ),
                        'desc'    => esc_html__( 'Choose to display MMDB info before or after the content', 'my-movie-database' ),
                        'type'    => 'radio',
                        'default' => Constants::OPTION_VALUE_POS_AFTER_CONTENT,
                        'options' => array(
                            Constants::OPTION_VALUE_POS_AFTER_CONTENT  => esc_html__( 'After content', 'my-movie-database' ),
                            Constants::OPTION_VALUE_POS_BEFORE_CONTENT => esc_html__( 'Before content', 'my-movie-database' )
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
            /* translators: %s: Post type, ex: movie, tv show or person section. */
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
        return __( I18nConstants::I18n_CORE_YES ) . '. '
               . sprintf(
                   /* translators: %s: Post type, ex: movie, tv show or person section. */
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
            $no_msg = __( I18nConstants::I18n_CORE_NO );
        }
        return $no_msg . '. '
               . sprintf(
                   /* translators: %s: Plural version of resource / post type, ex: use movies, tv shows or persons. */
                   esc_html__('I only want to use "%s" with shortcodes (or not at all)', 'my-movie-database' ),
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
            Constants::ADVANCED_OPTION_GROUP_NAME => array(
                array(
                    'name'    => Constants::ADV_OPTION_POST_TYPE_MOVIE,
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
                    'name'    => Constants::ADV_OPTION_POST_TYPE_TV,
                    'label'   => $this->getEnableSectionLabel($tv_shows_label),
                    'type'    => 'radio',
                    'default' => 'tvshow',
                    'options' => array(
                        'tvshow'  => $this->getEnableSectionYesOptionLabel($tv_shows_label),
                        'no_post'  => $this->getEnableSectionNoOptionLabel($tv_shows_label),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_POST_TYPE_PERSON,
                    'label'   => $this->getEnableSectionLabel($people_label),
                    'type'    => 'radio',
                    'default' => 'person',
                    'options' => array(
                        'person'  => $this->getEnableSectionYesOptionLabel($people_label),
                        'no_post' => $this->getEnableSectionNoOptionLabel($people_label),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_TAXONOMY_TYPE,
                    'label'   => __( I18nConstants::I18n_CORE_CATEGORIES ) . ' / ' . __( I18nConstants::I18n_CORE_TAGS ) ,
                    'desc' => esc_html__( 'Select the type of taxonomy to be created for each enabled post type section.', 'my-movie-database' ) . PHP_EOL . __( I18nConstants::I18n_CORE_CATEGORIES_TAGS_DESC ),
                    'type'    => 'radio',
                    'default' => Constants::OPTION_STRING_VALUE_TRUE,
                    'options' => array(
                        Constants::OPTION_STRING_VALUE_TRUE  => __( I18nConstants::I18n_CORE_CATEGORIES ),
                        Constants::OPTION_STRING_VALUE_FALSE => __( I18nConstants::I18n_CORE_TAGS ),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_WP_CATEGORIES,
                    'label'   => esc_html__( 'Wordpress Categories', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Default Wordpress categories can be selectable for your your mmdb posts', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => Constants::OPTION_STRING_VALUE_TRUE,
                    'options' => array(
                        Constants::OPTION_STRING_VALUE_TRUE  => esc_html__( 'Yes, allow movies, tvshows and persons to be associated to wordpress categories', 'my-movie-database' ),
                        'no_archive_pages' => esc_html__( 'Yes, associate them but do not show mmdb type posts in wordpress category pages as it conflicts with my theme or plugins', 'my-movie-database' ),
                        Constants::OPTION_STRING_VALUE_FALSE => esc_html__( 'No, do not use wordpress categories', 'my-movie-database' ),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_OVERVIEW_HOVER,
                    'label'   => esc_html__( "Overview on hover", 'my-movie-database' ),
                    'desc'    => esc_html__( 'Show description on hover for person credits and tvshow seasons', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => true,
                    'options' => array(
                        true  => __(I18nConstants::I18n_CORE_YES),
                        false => __(I18nConstants::I18n_CORE_NO),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_CSS_FILE_INC,
                    'label'   => esc_html__( 'Include plugin css file', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => Constants::OPTION_STRING_VALUE_TRUE,
                    'options' => array(
                        Constants::OPTION_STRING_VALUE_TRUE  => __(I18nConstants::I18n_CORE_YES),
                        Constants::OPTION_STRING_VALUE_FALSE => __(I18nConstants::I18n_CORE_NO),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_API_KEY,
                    /* translators: %s: Name of API service provider, ex: TMDb, Google. */
                    'label'   => sprintf(esc_html__( '%s API key', 'my-movie-database'), 'TMDb'),
                    /* translators: %s: Name of API service provider, ex: TMDb, Google. */
                    'desc'    => sprintf(esc_html__( 'Enter your %s API key.', 'my-movie-database' ), 'TMDb'),
                    'type'    => 'password',
                    'sanitize_callback' => 'sanitize_key',
                ),
                array(
                    'name'    => Constants::ADV_OPTION_GUTENBERG_DISABLE,
                    'label'   => esc_html__( 'Disable the Gutenberg editor?', 'my-movie-database' ),
                    'desc'    => esc_html__( 'Stop using the Gutenberg editor for the plugin\'s post types?', 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => __(I18nConstants::I18n_CORE_NO),
                        true  => __(I18nConstants::I18n_CORE_YES),
                    )
                ),
                array(
                    'name'    => Constants::ADV_OPTION_DEBUG_ENABLE,
                    'label'   => esc_html__( 'Debug Mode', 'my-movie-database' ),
                    'desc'    => esc_html__( "Will output data received from TMDB in your browser's (web developer tools) console", 'my-movie-database' ),
                    'type'    => 'radio',
                    'default' => 0,
                    'options' => array(
                        false => __(I18nConstants::I18n_CORE_DISABLED),
                        true  => __(I18nConstants::I18n_CORE_ENABLED)
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
            Constants::CACHE_MANAGER_OPTION_GROUP_NAME => [
                [
                    'name'    => Constants::CACHE_MANAGER_DELETE_TYPE,
                    'label'   => esc_html__( 'Delete cached resource', 'my-movie-database' ),
                    /* translators: Resource type, ex: movie, tv show or person resource. */
                    'desc'   => esc_html__( 'Select the type of cached resource to delete', 'my-movie-database'),
                    'type'    => 'select',
                    'default' => '',
                    'options' => [
                        ''  => __( I18nConstants::I18n_CORE_SELECT),
                        'movie'  => esc_html__( 'Movies', 'my-movie-database' ),
                        'tvshow' => esc_html__( 'Tv Show', 'my-movie-database' ),
                        'person'  => esc_html__( 'Person', 'my-movie-database' ),
                    ]
                ],
                [
                    'name'    => Constants::CACHE_MANAGER_DELETE_ID,
                    /* translators: %s: Name of the resource provider, ex: TMDb, Google. */
                    'desc'   => sprintf(esc_html__( 'Enter the %s id of the cached resource to delete', 'my-movie-database'), 'TMDb'),
                    'type'    => 'number',
                    'sanitize_callback' => 'sanitize_key',
                ],
            ],
        ];
    }

    /**
     * Get the credits fields
     *
     * @since    3.0.4
     * @return   array
     */
    private function getCreditFields() {

        $dev_thanks =
            'Heartfelt thank you to <a href="https://screenopolis.com" target="_blank" rel="noopener noreferrer"><b>Screenopolis</b></a> for their immense contribution to the development of the <b>My Movie Database Pro</b> plugin.';
        return [
            Constants::CREDITS_OPTION_GROUP_NAME => [
                [
                    'name'    => Constants::CREDITS_DEVELOPMENT_ID,
                    'label' => esc_html__( 'Development',  'my-movie-database' ),
                    'desc'   => $dev_thanks,
                    'type'    => 'html',
                ],
                [
                    'name'    => Constants::CREDITS_TRANSLATION_ID,
                    'label' => __( I18nConstants::I18n_CORE_TRANSLATIONS ),
                    'desc'   => Credits::getLanguages(),
                    'type'    => 'html',
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
                $this->getCacheManagerFields(),
                $this->getCreditFields()
        );
    }

    /**
     * Make plugin option page
     *
     * @since    0.7.0
     * @return  void
     */
    public function plugin_page() {
        $this->getSettingsPageHtml($this->version);
        ?>
        <div class="wrap">
        <?php
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Set plugin version
     *
     * @since    3.0.2
     *
     * @param      string  $version
     * @return  void
     */
    public function setVersion($version) {
        $this->version = $version;
    }
}
