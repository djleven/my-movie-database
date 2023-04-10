<?php
/**
 * Defines and orchestrates the post metabox and related template rendering
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\WpContentTypes\WpPostContentType;
use MyMovieDatabase\Lib\WpContentTypes\WpAdminPostContentType;
use MyMovieDatabase\Lib\ResourceAPI\BuildRequest;
use MyMovieDatabase\Constants;

class PostMetaBox implements ActionHookSubscriberInterface {

    public $active_post_types;
    public $mmodb_content;

    /**
     * The tmdb post meta identifier
     *
     * @since     2.0.0
     */
    const MMDB_POST_META_ID = 'MovieDatabaseID';

    /**
     * The id of the delete cache field
     *
     * @since     3.0.0
     */
    const MMDB_SHOULD_DELETE_CACHED = 'mmodb_should_delete_cached';

    /**
     * Initialize the class and add the meta box hooks
     *
     * @param array $active_post_types The plugin's current active post types.
     *
     * @since    1.0.0
     */
    public function __construct( $active_post_types ) {

        $this->active_post_types = array( $active_post_types );
    }

    /**
     * Get the action hooks to be registered related to the plugin's use of the meta-box.
     *
     * Enqueue scripts
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions() {
        return [
            'add_meta_boxes' => 'mmdb_add_post_meta_boxes',
            'save_post'      => 'mmdb_save_post_class_meta',
        ];
    }

    /**
     * Add the meta box to the active plugin post types
     *
     * @param string $post_type WP post type.
     *
     * @since     0.7.0
     */
    public function mmdb_add_post_meta_boxes( $post_type ) {

        $active_post_types = $this->active_post_types;

        foreach ( $active_post_types as $active_post_type ) {

            //limit meta box to active post types
            if ( in_array( $post_type, $active_post_type ) ) {
                add_meta_box( 'cs-meta',
                    Constants::getTypeLabel( WpPostContentType::postToMovieType( $post_type ) ),
                    array( $this, "mmdb_id_class_meta_box" ),
                    $post_type,
                    'normal',
                    'high',
                    array( $post_type )
                );
            }
        }
    }

    /**
     * Prepare the meta box html content
     *
     * @param object $post WP_Post     The post object.
     * @param object $args WP_Post     The $callback_args array.
     *
     * @since     0.7.0
     */
    public function mmdb_id_class_meta_box( $post, $args ) {
        // Add a nonce field to be checked later on.
        wp_nonce_field( 'mmdb_class_nonce_check', 'mmdb_class_nonce_check_value' );
        $this->mmodb_content = new WpAdminPostContentType( $post->post_type, $post->ID );

        echo '<div><h3 class="center-text">' . __( Constants::I18n_CORE_SEARCH ) . '</h3></div>';
        echo $this->mmodb_content->templateViewOutput();
        echo $this->addAfterContentHtml();
    }

    /**
     * Saves the meta box post metadata
     *
     * @param string $post_id The wp post id.
     *
     * @return    string
     * @since     0.7.0
     */
    function mmdb_save_post_class_meta( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['mmdb_class_nonce_check_value'] ) ) {
            return $post_id;
        }
        $nonce = $_POST['mmdb_class_nonce_check_value'];
        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, 'mmdb_class_nonce_check' ) ) {
            return $post_id;
        }
        // If this is an autosave do nothing.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        $tmdbid = sanitize_text_field( $_POST[ self::MMDB_POST_META_ID ] );
        if ( ($should_delete_cache = $_POST[self::MMDB_SHOULD_DELETE_CACHED])  === "1" ) {
            $cache_manager = new CacheManager(WpPostContentType::postToMovieType( $_POST['post_type'] ), $tmdbid);
            $delete_cache = $cache_manager->deleteCachedData();

            return $post_id;
        }

        update_post_meta( $post_id, self::MMDB_POST_META_ID, $tmdbid );
    }

    /**
     * Add TMDb link, id (readonly input) and purge cache controls after the mMoDb content
     *
     * @since 3.0.0
     * @return string
     */
    private function addAfterContentHtml( ) {
        $cache_manager = new CacheManager($this->mmodb_content->data_type, $this->mmodb_content->tmdb_id);
        $cached_data = $cache_manager->getCachedData();
        $tmdb_link = BuildRequest::getTMDBLink($this->mmodb_content->data_type, $this->mmodb_content->tmdb_id);
        $output = '<input type="hidden" id="' . self::MMDB_SHOULD_DELETE_CACHED . '" name="' . self::MMDB_SHOULD_DELETE_CACHED . '" value="0"/>';
        $output .= PHP_EOL;
        $output .= '<div class="mmdb-after-content">';
        $output .= PHP_EOL;
        $output .= '<div><span><a id="mmodb_tmdb_link" href="' . $tmdb_link . '" target="_blank">TMDb</a> id:</span>';
        $output .= PHP_EOL;
        $output .=
            '<input type="text" id="'. self::MMDB_POST_META_ID . '" name="'. self::MMDB_POST_META_ID . '"  value="'. $this->mmodb_content->tmdb_id .'" readonly size="15" />';
        $output .= '</div>';
        if($cached_data) {
            $output .= '<div id="mmodb_delete_cache">';
            $output .= PHP_EOL;
            $output .=
                '<span>' . sprintf(__('Cache expires in %s days','my-movie-database'), $cache_manager->getCacheExpiresDaysLeft()) . '</span>';
            $output .=
                '<input type="button" id="mmodb_delete_cache_submit" class="button" value="' . esc_html__('Delete cache now', 'my-movie-database') .'"/>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }
}

