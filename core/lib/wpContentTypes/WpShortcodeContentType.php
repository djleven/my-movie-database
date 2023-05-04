<?php
/**
 * The file that defines the mmdb shortcode class
 *
 * The WpShortcodeContentType class is a subclass of the WpAbstractContentType class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;
use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Lib\ResourceTypes\AbstractResourceType;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;

class WpShortcodeContentType extends WpAbstractContentType {

    protected $header_color;
    protected $body_color;
    protected $header_font_color;
    protected $body_font_color;
    protected $size;
    /**
     * The user input shortcode attributes
     * @since     2.0.0
     * array | string
     */
    protected $attributes;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param     $attributes  array | string  The user input shortcode attributes
     *            returns empty string if no input parameters exist
     * @param      OptionsGroup  $advancedSettings   OptionsGroup class with the advanced setting values
     * Available valid parameters:
     *
     * type       The mmdb content type ('slug') for the object
     * id         The tmdb id for the type object
     * template   The template for the type object
     * size       The size for the shortcode template
     * header             The background color for the header of the shortcode template
     * body               The background color for the body of the shortcode template
     * header_font_color  The header text color for the shortcode template
     * body_font_color    The body text color for the shortcode template
     */

    public function __construct($attributes, $advancedSettings) {
        $this->attributes = $attributes;
        parent::__construct(
            $this->constructAttributes('type',  MovieResourceType::DATA_TYPE_NAME),
            $advancedSettings
        );

        $this->tmdb_id = (int) $this->constructAttributes('id', 655);
        $this->template = $this->getTemplateSetting();
        $this->size = $this->constructAttributes('size');
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

        if($this->size) {
            return $this->size;

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
