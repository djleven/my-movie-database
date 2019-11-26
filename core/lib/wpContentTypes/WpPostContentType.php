<?php
/**
 * The class that defines the mmdb post content
 *
 * The WpPostContentType is a subclass of the abstract WpAbstractContentType class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;

class WpPostContentType extends WpAbstractContentType {

    public $post_id;

    /**
     * Initialize the class and set its properties.
     *
     * @since      1.0.0
     * @param      string    $data_type   The mmdb content type ('slug') for the object
     * @param      string    $post_id     The associated wp post id
     */
    public function __construct($data_type, $post_id) {
        $this->data_type = self::postToMovieType($data_type);
        $this->post_id = $post_id;
        $this->tmdb_id = $this->getPostMetaIdSetting();
        $this->template = $this->getTemplateSetting();
        $this->size = $this->getWidthSetting();
        $this->components = $this->getVueComponentsToLoad();
    }

    /**
     * Get the position setting for type object
     *
     * @since     1.0.0
     * @return    string
     */

    private function getPositionSetting() {

        return $this->getResourceTypeSetting( 'pos', 'after');
    }

    /**
     * Get the post meta (TMDB id) setting for type object
     *
     * @since     1.0.0
     * @return    string
     */
    private function getPostMetaIdSetting() {

        return get_post_meta($this->post_id, self::MMDB_POST_META_ID, true);
    }

    /**
     * Place the mmdb content view before or after the wp content
     *
     * @since      1.0.0
     * @param      string $content     The wp content.
     * @return     string
     */
    public function orderTheContent($content) {

        $mmdb_content = $this->templateViewOutput();
        $position = $this->getPositionSetting();
        if ($position == 'after') {
            $new_content = $content;
            $new_content.= $mmdb_content;
        }
        else {
            $new_content = $mmdb_content;
            $new_content.= $content;
        }
        return $new_content;
    }

    /**
     * Return movie instead of post
     *
     * When using the wp post type for movies
     *
     * @since      1.0.0
     * @param      string $type     The wp post type.
     * @return     string
     */
    public static function postToMovieType($type) {

        if ($type == 'post') {
            return 'movie';
        }
        else {
            return $type;
        }
    }

}

