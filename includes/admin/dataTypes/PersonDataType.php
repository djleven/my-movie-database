<?php
/**
 * Defines the properties of the TMDB person view data types made available to the plugin.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin\DataTypes;

class PersonDataType extends DataType{

    /**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * @return    array
     */
    public function setHideSectionsSetting() {

        return [
            static::SECTION_OVERVIEW  => __( 'Overview Text', MMDB_WP_NAME ),
            static::SECTION_2   	  => __( 'Cast Credits', MMDB_WP_NAME ),
            static::SECTION_3   	  => __( 'Crew Credits', MMDB_WP_NAME ),
        ];
    }
}

