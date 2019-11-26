<?php
/**
 * The file that defines the mmdb admin content class
 *
 * The WpPostContentType is a subclass of the WpAbstractContentType class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.1
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;

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
