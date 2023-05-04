<?php
/**
 * Defines the properties of the TMDB person resource (data) types view made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/resourceTypes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib\ResourceTypes;

class PersonResourceType extends AbstractResourceType {

	const DATA_TYPE_NAME = 'person';
	const DATA_TYPE_DEFAULT_ICON = 'dashicons-businessman';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0.0
	 * @param      string    $data_type_label       The data type label.
	 * @param      string    $data_type_label_plural The data type plural label.
	 * @param      string    $type_menu_icon  		The admin menu icon of this type.
	 */
	public function __construct(
        $data_type_label = null,
        $data_type_label_plural = null,
		$type_menu_icon = self::DATA_TYPE_DEFAULT_ICON
	) {
		parent::__construct(
            static::DATA_TYPE_NAME, $data_type_label, $data_type_label_plural, $type_menu_icon
		);
	}

	/**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * @return    array
     */
    public function setHideSectionsSetting() {

	    return $this->getSectionLabels([
		    static::SECTION_2   	  => __( 'Cast credits', 'my-movie-database' ),
		    static::SECTION_3   	  => __( 'Crew credits', 'my-movie-database' ),
	    ]);
	}

    public static function getI18nDefaultLabel() {

        return __('Person', 'my-movie-database');
    }

    /**
     * Get the default translated plural label of the type
     *
     * @since     3.0.0
     * @return    string
     */
    public static function getI18nDefaultPluralLabel() {

        return __('Persons', 'my-movie-database');
    }

    /**
     * Get the default translated category label of the type
     *
     * @since     3.0.0
     * @return    string
     */
    public function getI18nDefaultCategoryLabel() {

        return __('Person category', 'my-movie-database');
    }

    /**
     * Get the default translated plural category label of the type
     *
     * @since     3.0.0
     * @return    string
     */
    public function getI18nDefaultPluralCategoryLabel() {

        return __('Person categories', 'my-movie-database');
    }

    /**
     * Get the default translated tag label of the type
     *
     * @since     3.0.0
     * @return    string
     */
    public function getI18nDefaultTagLabel() {

        return __('Person tag', 'my-movie-database');
    }

    /**
     * Get the default translated plural tag label of the type
     *
     * @since     3.0.0
     * @return    string
     */
    public function getI18nDefaultPluralTagLabel() {

        return __('Person tags', 'my-movie-database');
    }
}

