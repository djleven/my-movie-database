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

class MMDB_Data_Type_movie extends MMDB_Data_Type{

    /**
     * Set the hidden sections labels
     *
     * @since     1.0.2
     * @return    array
     */
    public function set_hide_sections_setting() {

        return [
            static::SECTION_OVERVIEW  => __( 'Overview Text', 'my-movie-db' ),
            static::SECTION_2   	  => __( 'Cast', 'my-movie-db' ),
            static::SECTION_3   	  => __( 'Crew', 'my-movie-db' ),
            static::SECTION_4   	  => __( 'Trailer', 'my-movie-db' )
        ];
    }

    /**
     * Check the section prerequisites
     *
     * @since     1.0.3
     * @param     Movie $mmdb
     * @return    boolean
     */
    public function show_section_2_if($mmdb) {

        if($mmdb->getCast()) {
            return true;
        }

        return false;
    }

    /**
     * Check the section prerequisites
     *
     * @since     1.0.3
     * @param     Movie $mmdb
     * @return    boolean
     */
    public function show_section_3_if($mmdb) {

        if($mmdb->getCrew()) {
            return true;
        }

        return false;
    }

    /**
     * Check the section prerequisites
     *
     * @since     1.0.3
     * @param     Movie $mmdb
     * @return    boolean
     */
    public function show_section_4_if($mmdb) {

        if($mmdb->getTrailer()) {
            return true;
        }

        return false;
    }
}
