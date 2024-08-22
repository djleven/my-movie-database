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

use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Interfaces\FilterHookSubscriberInterface;
use MyMovieDatabase\Lib\OptionsGroup;
use MyMovieDatabase\Lib\WpContentTypes\WpPostContentType;
use MyMovieDatabase\Lib\WpContentTypes\WpAdminPostContentType;
use MyMovieDatabase\Lib\ResourceAPI\BuildRequest;
use MyMovieDatabase\I18nConstants;
use MyMovieDatabase\TemplateFiles;
use MyMovieDatabase\Constants;
class PostMetaBox implements ActionHookSubscriberInterface, FilterHookSubscriberInterface {

    public $mmodb_content;

    /**
     * The plugin's current active post types.
     *
     * @since    1.0.0
     * @var      array $active_post_types
     */
    public $active_post_types;

    /**
     * An instance of the options helper class loaded with the advanced setting values.
     *
     * @since    3.0.0
     * @access   protected
     * @var      OptionsGroup    $advancedSettings
     */
    protected $advancedSettings;

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
     * Initialize the class.
     *
     * @since      3.0.0
     * @param      OptionsGroup $advancedSettings           OptionsGroup class with the advanced setting values
     */
    public function __construct($active_post_types, $advancedSettings) {
        $this->active_post_types = $active_post_types;
        $this->advancedSettings = $advancedSettings;
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
            'admin_enqueue_scripts' => 'enqueue_scripts',
        ];
    }

    /**
     * Get the filter hooks to be registered
     *
     * Hide the meta boxes in the post screens as default behavior
     *
     * @since    2.5.0
     * @access   public
     */
    public function getFilters()
    {
        return [
            'default_hidden_meta_boxes' => [
                'mmdb_hide_meta_box',
                10,
                2
            ]
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
        if ( in_array( $post_type, $this->active_post_types ) ) {
            add_meta_box( 'cs-meta',
                I18nConstants::getTypeLabel( WpPostContentType::postToMovieType( $post_type ) ),
                array( $this, "mmdb_id_class_meta_box" ),
                $post_type,
                'normal',
                'high',
                array( $post_type )
            );
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
        $this->mmodb_content = new WpAdminPostContentType( $post->post_type, $post->ID, $this->advancedSettings );

        echo '<div><h3 class="center-text">' . __( I18nConstants::I18n_CORE_SEARCH ) . '</h3></div>';
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
                /* translators: %s: Number of days. */
                '<span>' . sprintf(__('Cache expires in %s days','my-movie-database'), $cache_manager->getCacheExpiresDaysLeft()) . '</span>';
            $output .=
                '<input type="button" id="mmodb_delete_cache_submit" class="button" value="' . esc_html__('Delete cache now', 'my-movie-database') .'"/>';
            $output .= '</div>';
        }
        $output .= '</div>';
        return $output;
    }

    /**
     * Register the JavaScript and the stylesheets for the post box area.
     *
     * @since    3.0.0
     */
    public function enqueue_scripts() {
        $edit_js_file = 'admin-edit';
        wp_enqueue_style(
            Constants::PLUGIN_NAME_UNDERSCORES . '_admin',
            TemplateFiles::getPublicStylesheet(Constants::PLUGIN_NAME_CAMEL . 'Admin'),
            [],
            '3.0.0',
            'all'
        );
        wp_enqueue_script( Constants::PLUGIN_NAME_UNDERSCORES . '_admin_edit',
            TemplateFiles::getJsFilePath($edit_js_file),
            ['jquery'],
            0.2,
            true
        );
    }

    /**
     * Hides the meta boxes in the post screens as default behavior (if the user has not yet set his screen options)
     *
     * @since     1.0.0
     * @return    array
     */
    public function mmdb_hide_meta_box($hidden, $screen) {

        // do this only for our active mmdb post types
        if ($screen->base === 'post' && in_array($screen->id, $this->active_post_types)) {
            $hidden = array(
                'postexcerpt',
                'slugdiv',
                'postcustom',
                'trackbacksdiv',
                'commentstatusdiv',
                'commentsdiv',
                'authordiv',
                'revisionsdiv'
            );
        }
        return $hidden;
    }
}
