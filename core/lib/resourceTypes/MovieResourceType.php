<?php
/**
 * Defines the properties of the TMDB movie resource (data) types view made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/resourceTypes
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib\ResourceTypes;

class MovieResourceType extends AbstractResourceType {

    /**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * @return    array
     */
    public function setHideSectionsSetting() {

        return [
            static::SECTION_OVERVIEW  => __( 'Overview Text', MMDB_WP_NAME ),
            static::SECTION_2   	  => __( 'Cast', MMDB_WP_NAME ),
            static::SECTION_3   	  => __( 'Crew', MMDB_WP_NAME ),
            static::SECTION_4   	  => __( 'Trailer', MMDB_WP_NAME )
        ];
    }
}
