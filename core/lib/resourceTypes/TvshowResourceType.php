<?php
/**
 * Defines the properties of the TMDB tvshow resource (data) types view made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/resourceTypes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib\ResourceTypes;

class TvshowResourceType extends AbstractResourceType {

	const DATA_TYPE_NAME = 'tvshow';
	const DATA_TYPE_DEFAULT_ICON = 'dashicons-welcome-view-site';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.0.0
	 * @param      string    $data_type_label       The data type label.
	 * @param      string    $data_type_label_plural The data type plural label.
	 * @param      string    $type_menu_icon  		The admin menu icon of this type.
	 */
	public function __construct(
		$data_type_label = '',
		$data_type_label_plural = '',
		$type_menu_icon = self::DATA_TYPE_DEFAULT_ICON
	) {
		parent::__construct(
			static::DATA_TYPE_NAME,
			$data_type_label ? $data_type_label : __('TvShow', 'my-movie-database'),
			$data_type_label_plural ? $data_type_label_plural : __('TvShows', 'my-movie-database'),
			$type_menu_icon
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
		    static::SECTION_4   	  => __( 'Seasons', 'my-movie-database' ),
	    ]);
	}
}

