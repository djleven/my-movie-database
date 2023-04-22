<?php
/**
 * The file that defines the WpAbstractContentType abstract class
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;

use MyMovieDatabase\CoreController;
use MyMovieDatabase\Lib\ResourceTypes\AbstractResourceType;

abstract class WpAbstractContentType {

    use TemplateVueTrait;

    public $data_type;
    public $tmdb_id;
    public $template;

    /**
     * The tmdb post meta identifier
     *
     * @since     2.0.0
     */
    const MMDB_POST_META_ID = 'MovieDatabaseID';

    /**
     * Get unique content type ID
     *
     * @since     2.0.0
     * @return    string	$output    	  The generated template view
     */
    protected function getUniqueID() {

        return $this->tmdb_id . '_' . $this->data_type;
    }

    /**
     * The options page group for the WpContentType object (based on it's data type)
     *
     * @since     1.0.0
     * @return    string
     */
    protected function getResourceTypeSettingGroup() {

        return AbstractResourceType::makeTypeSettingGroupId($this->data_type);
    }

    /**
     * Factory method to get a data type setting
     *
     * @since     2.0.0
     * @param     $settingId    string    The setting id
     * @param     $default      string    The default value if no setting exists
     * @return    mixed
     */
    protected function getResourceTypeSetting($settingId, $default = '') {

        $post_setting_name	= MMDB_PLUGIN_ID . '_' . $this->data_type . '_' . $settingId;
        return CoreController::getMmdbOption($post_setting_name, $this->getResourceTypeSettingGroup(), $default);
    }

    /**
     * Get the template setting for type object
     * @since     1.0.0
     * @return    string
     */
    protected function getTemplateSetting() {

        return $this->getResourceTypeSetting( 'tmpl', 'tabs');
    }

    /**
     * Get the header color setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    protected function getHeaderColorSetting() {

        return $this->getResourceTypeSetting( 'header_color', '#265a88');
    }

	/**
	 * Get the header font color setting for type object
	 *
	 * @since     3.0.0
	 * @return    string
	 */
	protected function getHeaderFontColorSetting() {

		return $this->getResourceTypeSetting( 'header_font_color', '#DCDCDC');
	}

    /**
     * Get the body color setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    protected function getBodyColorSetting() {

        return $this->getResourceTypeSetting( 'body_color', '#DCDCDC');
    }

	/**
	 * Get the body color setting for type object
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	protected function getBodyFontColorSetting() {

		return $this->getResourceTypeSetting( 'body_font_color', '#265a88');
	}

    /**
     * Get the transition effect setting for type object
     *
     * @since     2.0.0
     * @return    string
     */
    protected function getTransitionEffectSetting() {

        return $this->getResourceTypeSetting( 'transition_effect', 'fade');
    }

    /**
     * Get the width setting for type object
     *
     * @since     1.0.2
     * @return    string
     */
    protected function getWidthSetting() {

        return $this->getResourceTypeSetting( 'width', 'medium');
	}

    /**
     * Associative array of visibility settings fot the data type sections
     *
     * @since    1.0.0
     * @param    array $sections
     * @return   array
     */
    protected function showSectionSettings($sections = null) {

        $result = [];
        if(!$sections) {
            $sections = AbstractResourceType::getSections();
        }
        $settings = $this->getResourceTypeSetting('sections', []);

        foreach($sections as $section) {
            $visible = true;
            if (is_array($settings) && in_array($section, $settings)) {
                $visible = false;
            }
            $result[$section] = $visible;
        }

        return $result;
    }

    /**
     * Setup and return the type view output
     *
     * @since     1.0.0
     * @return    string	$output    	  The generated template view
     */
    public function templateViewOutput() {

        ob_start();
        echo $this->templateVueOutput();

        return ob_get_clean();
    }
}
