<?php
/**
 * Coordinates the public-facing functionality of the plugin.
 *
 * Plugin Convention:
 * Methods in underscore naming represent registered wordpress hook callbacks
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/controllers
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Lib\WpContentTypes\WpPostContentType;
use MyMovieDatabase\Lib\WpContentTypes\ShortcodeContentType;

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;

class PublicController implements ActionHookSubscriberInterface, FilterHookSubscriberInterface, ShortcodeHookSubscriberInterface {

    const MMDB_SHORTCODE = 'my_movie_db';
    const MMDB_SHORTCODE_ALT = 'my-movie-db';

    /**
     * Active post types as per admin user settings.
     *
     * @since     1.0.0
     * @return    array
     */
    private $active_post_types;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    array  $active_post_types  active post types as per settings
     */
    public function __construct($active_post_types = []) {

        $this->active_post_types = $active_post_types;
    }

    /**
     * Get the action hooks to be registered related to the public-facing functionality.
     *
     * Enqueue scripts and styles
     * Post content hook for mmdb post content
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'wp_enqueue_scripts' => 'enqueue_scripts',
            'the_content' => 'post_content_view_hook',
        ];
    }

    /**
     * Get the filter hooks to be registered related to the public-facing functionality.
     *
     * Remove shortcode content from RSS feeds
     * Conditionally include custom post types on archive pages
     *
     * @since    2.5.0
     * @access   public
     */
    public function getFilters()
    {
        $filters = [
            'the_content_feed' => 'remove_shortcode_from_feed',
        ];
        if($this->postTypesToArchivePagesSetting() === 'yes') {
            $filters['pre_get_posts'] =  'post_types_to_archive_pages';
        }

        return $filters;
    }

    /**
     * Get the shortcodes to be registered.
     *
     * @since    2.5.0
     * @access   public
     */
    public function getShortcodes()
    {
        return [
            self::MMDB_SHORTCODE => 'shortcode_content_view_hook',
            self::MMDB_SHORTCODE_ALT => 'shortcode_content_view_hook',
        ];
    }

    /**
     * Determine if we are on a mmdb active post type screen
     *
     * @since     1.0.0
     * @return    boolean | string
     */
    private function isActiveMmdbContent(){

        $result = false;
        $screen = get_post_type();

        foreach ($this->active_post_types as $active_post_type) {
            // Check screen hook and current post type
            if ($screen == $active_post_type) {
                $result = $active_post_type;
            }
        }

        return $result;
    }

    /**
     * Determine if we are on a screen where an mmdb shortcode is being used
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function isActiveMmdbShortcode(){

        $result = false;
        global $post;
        // $post not set on 404 pages, returns Trying to get property of non-object
        if (isset( $post )) {

            $result = has_shortcode( $post->post_content, self::MMDB_SHORTCODE) ||
                has_shortcode( $post->post_content, self::MMDB_SHORTCODE_ALT);
        }

        return $result;
    }

    /**
     * Determine if we are on an active mmdb screen
     *
     * @since     1.0.0
     * @return    boolean
     */
    private function isActiveMmdbScreen(){

        $result = false;
        if($this->isActiveMmdbShortcode()) {
            $result = true;
        }
        elseif($this->isActiveMmdbContent()) {
            $result = true;
        }

        return $result;
    }

    /**
     * Orchestrate the setup and rendering of the mmdb post content view
     *
     * @since    1.0.0
     * @param     string     $content  The wp $content
     * @return    string     The mmdb WpPostContentType view output
     */
    public function post_content_view_hook($content) {

        if($this->isActiveMmdbContent() && !is_feed()) {

            $post_id = get_the_ID();
            $post_type = get_post_type($post_id);
            $mmdb_type = new WpPostContentType($post_type, $post_id);
            if($mmdb_type->tmdb_id) {
                return $mmdb_type->orderTheContent($content);
            }
        }

        return $content;
    }

    /**
     * Shortcode hook callback
     * Handle the shortcode user input and render the shortcode content view
     *
     * @since     1.0.0
     * @param     $atts    array | string
     *                     associative array of attributes, or an empty string if no attributes given
     *
     * @return    string   The ShortcodeContentType view
     */
    public function shortcode_content_view_hook($atts) {
        // normalize attributes - lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
        $mmdb_type = new ShortcodeContentType($atts);

        return $mmdb_type->templateViewOutput();
    }

    /**
     * Register the JavaScript and CSS for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        TemplateFiles::enqueueCommonFiles($this->isActiveMmdbScreen());
    }

    /**
     * Include mmdb custom post types in wordpress category pages if option is selected
     *
     * @since    1.2.0
     */
    private function postTypesToArchivePagesSetting()
    {
        return CoreController::getMmdbOption(
            'mmdb_wp_categories',
            MMDB_ADVANCED_OPTION_GROUP,
            'yes'
        );
    }

    /**
     * Modify wp query to include mmdb custom post types
     * in wordpress category pages
     *
     * @since    1.2.0
     *
     * @param    WP_Query    $query
     * @return   WP_Query
     */
    public function post_types_to_archive_pages($query) {

        if( is_category() || is_tag()) {
            $post_type = get_query_var('post_type');
            if (!$post_type) {
                $post_type =
                    [
                        'nav_menu_item',
                        'post',
                        MovieResourceType::DATA_TYPE_NAME,
                        TvshowResourceType::DATA_TYPE_NAME,
                        PersonResourceType::DATA_TYPE_NAME
                    ];
            }
            $query->set('post_type',$post_type);
        }

        return $query;
    }

    /**
     * Remove the shortcode content from RSS feed hook callback
     *
     * @since    2.0.0
     * @param    $content string  The current post content.
     * @return   mixed
     */
    public function remove_shortcode_from_feed($content){

        remove_shortcode(self::MMDB_SHORTCODE);
        remove_shortcode(self::MMDB_SHORTCODE_ALT);

        return $content;
    }
}
