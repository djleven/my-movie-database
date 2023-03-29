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

    /**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * @return    array
     */
    public function setHideSectionsSetting() {

	    return $this->getSectionLabels([
		    static::SECTION_2   	  => __( 'Cast Credits', 'my-movie-database' ),
		    static::SECTION_3   	  => __( 'Crew Credits', 'my-movie-database' ),
	    ]);
	}
}

