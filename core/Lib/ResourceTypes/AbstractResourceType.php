<?php
/**
 * Defines the properties of the TMDB resource (data) types made available to the plugin.
 *
 * Used to create wordpress post types and settings.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/resourceTypes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib\ResourceTypes;

use MyMovieDatabase\Constants;

abstract class AbstractResourceType {
    public $data_type;
	public $data_type_label;
	public $data_type_label_plural;
    public $type_menu_icon;
    public $type_setting_id;
    public $tmpl_setting_id;
    public $width_setting_id;
    public $pos_setting_id;
    public $sections_setting_id;
    public $body_color_setting_id;
    public $body_font_color_setting_id;
    public $header_color_setting_id;
    public $header_font_color_setting_id;
    public $transition_effect_setting_id;
    public $post_type_advanced_setting_key;

    const SECTION_OVERVIEW = 'overview_text';
    const SECTION_2 = 'section_2';
    const SECTION_3 = 'section_3';
    const SECTION_4 = 'section_4';
    const IMDB_LINK = 'imdb_link';
    const HOMEPAGE_LINK = 'homepage_link';

    abstract public static function getI18nDefaultLabel();
    abstract public static function getI18nDefaultPluralLabel();
    abstract public function getI18nDefaultCategoryLabel();
    abstract public function getI18nDefaultPluralCategoryLabel();
    abstract public function getI18nDefaultTagLabel();
    abstract public function getI18nDefaultPluralTagLabel();

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $data_type       		The data type.
     * @param      string    $data_type_label       The data type label.
     * @param      string    $data_type_label_plural The data type plural label.
     * @param      string    $type_menu_icon  		The admin menu icon of this type.
     */
    public function __construct(
        $data_type,
        $data_type_label = null,
        $data_type_label_plural = null,
        $type_menu_icon = null
    ) {
        if($data_type_label){
            $this->data_type_label = $data_type_label;
        }
        if($data_type_label_plural){
            $this->data_type_label_plural = $data_type_label_plural;
        }

        $this->data_type = $data_type;
        $this->type_menu_icon = $type_menu_icon;
        $this->type_setting_id = self::makeTypeSettingGroupId($this->data_type);
        $this->tmpl_setting_id = $this->makeTypeSetting('tmpl');
        $this->width_setting_id = $this->makeTypeSetting('width');
        $this->pos_setting_id = $this->makeTypeSetting('pos');
        $this->sections_setting_id = $this->makeTypeSetting('sections');
        $this->body_color_setting_id = $this->makeTypeSetting('body_color');
        $this->body_font_color_setting_id = $this->makeTypeSetting('body_font_color');
        $this->header_color_setting_id = $this->makeTypeSetting('header_color');
        $this->header_font_color_setting_id = $this->makeTypeSetting('header_font_color');
        $this->transition_effect_setting_id = $this->makeTypeSetting('transition_effect');
        $this->post_type_advanced_setting_key = $this->getPostTypeAdvancedSettingKey();
    }

    /**
     * Get the post type (advanced) setting key for type object
     *
     * @since     1.0.0
     * @return    string
     */
    public function getPostTypeAdvancedSettingKey() {

        return Constants::PLUGIN_ID_INIT . '_' . $this->data_type . '_post_type';
    }

    /**
     * Make the setting id tag for the data type object
     *
     * @since     1.0.0
     * @param     string  $data_type  The data type
     * @return    string
     */
    public static function makeTypeSettingGroupId($data_type) {

        return Constants::PLUGIN_ID_INIT . '_opt_' . $data_type . 's';
    }

    /**
     * Make a setting tag for the data type object (used by Settings class)
     *
     * @since     1.0.0
     * @param     string    $setting 	The setting slug for the setting make
     * @return    string
     */
    protected function makeTypeSetting($setting) {

        return Constants::PLUGIN_ID_INIT . '_' . $this->data_type . '_' . $setting;
    }

    /**
     * Get the data type view sections
     *
     * @since     2.0.0
     * @return    array
     */
    public static function getSections() {

        return [
            static::SECTION_OVERVIEW,
            static::HOMEPAGE_LINK,
            static::IMDB_LINK,
            static::SECTION_2,
            static::SECTION_3,
            static::SECTION_4
        ];
    }


    /**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * added to abstract in 3.0.0
     *
     * @return    array
     */
	public function getSectionLabels($sectionLabels, $hasIMDB = true) {

        $overview_section = [
            static::SECTION_OVERVIEW  => __( 'Overview Text', 'my-movie-database' ),
            static::HOMEPAGE_LINK     => sprintf(
            /* translators: %s: Link destination, ex: homepage, wikipedia, IMDb or TMDb. */
                esc_html__( 'Link to %s', 'my-movie-database' ),
                esc_html__( 'Website', 'my-movie-database' )
            ),
        ];

        if($hasIMDB) {
            $overview_section[static::IMDB_LINK] = sprintf(
            /* translators: %s: Link destination, ex: homepage, wikipedia, IMDb or TMDb. */
                esc_html__( 'Link to %s', 'my-movie-database' ),
                'IMDb'
            );
        }

		return array_merge($overview_section, [
			static::SECTION_2   	  => __( 'Cast', 'my-movie-database' ),
			static::SECTION_3   	  => __( 'Crew', 'my-movie-database' )
		], $sectionLabels);
	}

    /**
     * Set the default name labels for type object
     *
     * @since     3.0.0
     * @return    void
     */
    public function setDefaultLabels() {
        $this->data_type_label = static::getI18nDefaultLabel();;
        $this->data_type_label_plural = static::getI18nDefaultPluralLabel();
    }
}

