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

use MyMovieDatabase\CoreController;

abstract class AbstractResourceType {

    public $data_type;
    public $data_type_label;
    public $type_menu_icon;
    public $type_setting_id;
    public $tmpl_setting_id;
    public $width_setting_id;
    public $pos_setting_id;
    public $sections_setting_id;
    public $body_color_setting_id;
    public $header_color_setting_id;
    public $transition_effect_setting_id;

    const SECTION_OVERVIEW = 'overview_text';
    const SECTION_2 = 'section_2';
    const SECTION_3 = 'section_3';
    const SECTION_4 = 'section_4';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $data_type       		The data type.
     * @param      string    $data_type_label       The data type label.
     * @param      string    $type_menu_icon  		The admin menu icon of this type.
     */
    public function __construct($data_type, $data_type_label= null, $type_menu_icon = null) {

        $this->data_type_label = $data_type_label;
        $this->data_type = $data_type;
        $this->type_menu_icon = $type_menu_icon;
        $this->type_setting_id = self::makeTypeSettingGroupId($this->data_type);
        $this->tmpl_setting_id = $this->makeTypeSetting('tmpl');
        $this->width_setting_id = $this->makeTypeSetting('width');
        $this->pos_setting_id = $this->makeTypeSetting('pos');
        $this->sections_setting_id = $this->makeTypeSetting('sections');
        $this->body_color_setting_id = $this->makeTypeSetting('body_color');
        $this->header_color_setting_id = $this->makeTypeSetting('header_color');
        $this->transition_effect_setting_id = $this->makeTypeSetting('transition_effect');
    }

    /**
     * Get the post type setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    public function getPostTypeSetting() {

        $post_setting_name	= MMDB_PLUGIN_ID . '_' . $this->data_type . '_post_type';
        return CoreController::getMmdbOption($post_setting_name, MMDB_ADVANCED_OPTION_GROUP , $this->data_type);
    }

    /**
     * Make the setting id tag for the data type object
     *
     * @since     1.0.0
     * @param     string  $data_type  The data type
     * @return    string
     */
    public static function makeTypeSettingGroupId($data_type) {

        return  MMDB_PLUGIN_ID . '_opt_' . $data_type . 's';
    }

    /**
     * Make a setting tag for the data type object (used by Settings class)
     *
     * @since     1.0.0
     * @param     string    $setting 	The setting slug for the setting make
     * @return    string
     */
    protected function makeTypeSetting($setting) {

        return  MMDB_PLUGIN_ID . '_' . $this->data_type . '_' . $setting;
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
            static::SECTION_2,
            static::SECTION_3,
            static::SECTION_4
        ];
    }
}

