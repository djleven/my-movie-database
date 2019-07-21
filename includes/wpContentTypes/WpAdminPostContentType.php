<?php
/**
 * The file that defines the mmdb admin content class
 *
 * The WpPostContentType is a subclass of the abstract MMDB_type class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.1
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/wpContentType
 */
namespace MyMovieDatabase\WpContentTypes;
class WpAdminPostContentType extends WpPostContentType {

    /**
     * Setup and return the type view output
     *
     * @since     1.0.0
     *
     * @return array
     */
    protected function getVueComponentsToLoad() {
        $components = parent::getVueComponentsToLoad();
        $components['entry']['path'] = '';
        $components['entry']['filename'] = 'admin';
        $components['other99']['path'] = '';
        $components['other99']['filename'] = 'index';

        return $components;
    }

}
