<?php
/**
 * Defines the properties of the TMDB show view data types made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin\DataTypes;

class MovieDataType extends DataType{

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
