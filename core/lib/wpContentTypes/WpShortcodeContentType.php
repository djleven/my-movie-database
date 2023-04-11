<?php
/**
 * The file that defines the mmdb shortcode class
 *
 * The ShortcodeContentType class is a subclass of the WpAbstractContentType class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;
use MyMovieDatabase\Lib\ResourceTypes\AbstractResourceType;

class ShortcodeContentType extends WpAbstractContentType {

	public $header_color;
	public $body_color;
	public $header_font_color;
	public $body_font_color;
    /**
     * The user input shortcode attributes
     * @since     2.0.0
     * array | string
     */
    public $attributes;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param     $attributes  array | string  The user input shortcode attributes
     *            returns empty string if no input parameters exist
     *
     * Available valid parameters:
     *
     * type       The mmdb content type ('slug') for the object
     * id         The tmdb id for the type object
     * size       The template for the type object
     * $size      The size for the shortcode template
     * header     The header color for the shortcode template
     * body       The background color for shortcodetemplate
     *
     */

    public function __construct($attributes) {
        $this->attributes = $attributes;
        $this->data_type = $this->constructAttributes('type', 'movie');
        $this->tmdb_id = $this->constructAttributes('id', '655');
        $this->template = $this->getTemplateSetting();
        $this->size = $this->getWidthSetting();
	    $this->header_color = $this->constructAttributes('header');
	    $this->body_color = $this->constructAttributes('body');
	    $this->header_font_color = $this->constructAttributes('header_font_color');
	    $this->body_font_color = $this->constructAttributes('body_font_color');
    }

    /**
     * Get the template setting for type object
     * @since     2.0.0
     * @param     $att      string
     * @param     $default  mixed
     * @return    mixed
     */
    protected function constructAttributes($att, $default = null) {

        if(is_array($this->attributes)) {
            if(isset($this->attributes[$att])) {
                return $this->attributes[$att];
            }
        }
        return $default;
    }

    /**
     * Get the template setting for type object
     *
     * @since     1.1.1
     * @return    string
     */
    protected function getTemplateSetting() {

        $setting = $this->constructAttributes('template');
        if(isset($setting)) {

            return $setting;
        }
        return parent::getTemplateSetting();
    }

    /**
     * Get the width setting for type object
     *
     * @since     1.0.2
     * @return    string
     */
    protected function getWidthSetting() {

        $setting = $this->constructAttributes('size');
        if(isset($setting)) {

            return $setting;
        }

        return parent::getWidthSetting();
    }

    /**
     * Get the header color setting for type object
     *
     * @since     1.1.1
     * @return    string
     */
    protected function getHeaderColorSetting() {

        if($this->header_color) {
            return $this->header_color;

        }
        return parent::getHeaderColorSetting();
    }

	/**
	 * Get the header font color setting for type object
	 *
	 * @since     3.0.0
	 * @return    string
	 */
	protected function getHeaderFontColorSetting() {

		if($this->header_font_color) {
			return $this->header_font_color;

		}
		return parent::getHeaderFontColorSetting();
	}

	/**
     * Get the body color setting for type object
     *
     * @since     1.1.1
     * @return    string
     */
    protected function getBodyColorSetting() {

        if($this->body_color) {
            return $this->body_color;

        }
        return parent::getBodyColorSetting();
    }

	/**
	 * Get the body color setting for type object
	 *
	 * @since     3.0.0
	 * @return    string
	 */
	protected function getBodyFontColorSetting() {

		if($this->body_font_color) {
			return $this->body_font_color;

		}
		return parent::getBodyFontColorSetting();
	}

    /**
     * Associative array of visibility settings fot the data type sections
     *
     * @since    1.0.0
     * @param    array $sections
     * @return   array
     */
    protected function showSectionSettings($sections = null)
    {
        $result = [];
        $sections = AbstractResourceType::getSections();

        $setting = $this->constructAttributes('section');
        if(isset($setting)) {

            foreach($sections as $section) {
                $visible = false;
                if ($section === $setting) {
                    $visible = true;
                }
                $result[$section] = $visible;
            }

            return $result;
        }

        return parent::showSectionSettings($sections);
    }

}
