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
     * Initialize the class and set its properties.
     *
     * @since      1.0.0
     * @param      string    $data_type   The mmdb content type ('slug') for the object
     * @param      string    $post_id     The associated wp post id
     */
    public function __construct($data_type, $post_id) {
        parent::__construct($data_type, $post_id);
        if($this->tmdb_id === 0) {
            $this->tmdb_id = null;
        }
    }
}
