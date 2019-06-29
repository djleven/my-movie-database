<?php
/**
 * Coordinating the public-facing functionality of the plugin.
 *
 * Also the hooks to enqueue the public-specific stylesheet and JavaScript.
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/public
 * @author     Kostas Stathakos <info@e-leven.net>
 */

class MMDB_Public {

    private $plugin_name;
	private $version;
	private $public_files;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->public_files = new MMDB_Public_Files;
        $this->mmdPostTypesToArchivePagesSetting();
    }

    /**
     * Get the currently active post types for the plugin
     *
     * @since    1.0.0
     * @return   array    Active post types
     */
    public function active_post_types() {

        $plugin_admin = new MMDB_Admin( $this->plugin_name, $this->version );
        $active_post_types = $plugin_admin->get_active_post_types();

        return $active_post_types;
    }

    /**
     * Determine if we are on a mmdb active post type screen
     *
     * @since     1.0.0
     * @return    boolean
     */
    public function is_active_mmdb_content(){

        $active_post_types = $this->active_post_types();
        $result = false;
        $screen = get_post_type();

        foreach ($active_post_types as $active_post_type) {
            // Check screen hook and current post type
            if ($screen == $active_post_type) {
                $result = true;
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
    public function is_active_mmdb_shortcode(){

        $result = false;
        global $post;
        // $post not set on 404 pages, returns Trying to get property of non-object
        if (isset( $post )) {

            if ( has_shortcode( $post->post_content, 'my_movie_db') ) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * Determine if we are on an active mmdb screen
     *
     * @since     1.0.0
     * @return    boolean
     */
    public function is_active_mmdb_screen(){

        $result = false;
        if($this->is_active_mmdb_shortcode()) {
            $result = true;
        }
        elseif($this->is_active_mmdb_content()) {
            $result = true;
        }

        return $result;
    }

    /**
     * Setup the mmdb content
     *
     * @return MMDB_Content_Type
     */
    public function mmdb_set_mmdb_content() {

        $post_id = get_the_ID();
        $post_type = get_post_type($post_id);
        $type_attr = mmdb_get_type_attr($post_type);
        $mmdb_type = new MMDB_Content_Type($type_attr, $post_id);

        return $mmdb_type;
    }

    /**
     * Orchestrate the setup and rendering of the mmdb content view (for posts not shortcodes)
     *
     * @since    1.0.0
     * @param     string     $content  The wp $content
     * @return    string     The mmdb Shortcode_Type view
     */
    public function mmdb_the_content_view($content) {

        if($this->is_active_mmdb_content()) {

            $mmdb_type = $this->mmdb_set_mmdb_content();
            $mmdb_content = $mmdb_type->mmdb_the_template_view($mmdb_type);
            if($mmdb_content) {
                return $mmdb_content['mmdb_type']->mmdb_order_the_content($content, $mmdb_content['mmdb_type'], $mmdb_content['output']);
            }
        }

        return $content;
    }

    /**
     * Get the mmdb css file to enqueue
     *
     * @since    1.0.9
     */
    public function get_mmdb_asset_files() {

        return
            wp_enqueue_style( $this->plugin_name, $this->public_files->mmdbSetScriptsOrder($this->plugin_name, 'css'), array(), $this->version, 'all' );
            /**
             * Unused so far js file for front-end - empty file for future use
             *
            wp_enqueue_script( $this->plugin_name, $this->public_files->mmdbSetScriptsOrder($this->plugin_name, 'js'), array( 'jquery' ) )
             */
    }

    /**
     * Get the bootsrap files to enqueue
     *
     * @since    1.0.9
     */
    public function get_bootsrap_files() {

        return
            wp_enqueue_style( 'bootstrap', $this->public_files->mmdbSetScriptsOrder('bootstrap', 'css'), array() ) .
            wp_enqueue_script( 'bootstrap', $this->public_files->mmdbSetScriptsOrder('bootstrap.min', 'js'), array( 'jquery' ) );
    }

    /**
     * Register the JavaScript and CSS for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        /**
         * An instance of this class is passed to the run() function
         * defined in My_movie_database_Loader as all (or almost all!) of the hooks are defined
         * in that particular class.
         *
         * The My_movie_database_Loader creates the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $css_file = MMDB_Admin::mmdb_get_option('mmdb_css_file', 'mmdb_opt_advanced', 'yes');
        $bootstrap = MMDB_Admin::mmdb_get_option('mmdb_bootstrap', 'mmdb_opt_advanced', 'yes');
        // Check to load only on mmdb active post types screens.
        if($this->is_active_mmdb_screen()) {

            if( $css_file == 'yes') {
                $this->get_mmdb_asset_files();
            }
            if ($bootstrap == 'yes') {
                $this->get_bootsrap_files();
            }
        }
        // Load for all public facing screens below.
        if ($bootstrap == 'all'){
            $this->get_bootsrap_files();
        }
        if( $css_file == 'all') {
            $this->get_mmdb_asset_files();
        }
    }

    /**
     * Include mmdb custom post types in wordpress category pages if option is selected
     *
     * @since    1.2.0
     */
    public function mmdPostTypesToArchivePagesSetting()
    {
        $wpCategoriesOption = MMDB_Admin::mmdb_get_option(
            'mmdb_wp_categories',
            'mmdb_opt_advanced',
            'yes'
        );

        if($wpCategoriesOption === 'yes') {

            add_filter('pre_get_posts', array ($this, 'mmdPostTypesToArchivePages'));
        }
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
    public function mmdPostTypesToArchivePages($query) {

        if( is_category() ) {
            $post_type = get_query_var('post_type');
            if (!$post_type) {
                $post_type =
                    [
                        'nav_menu_item',
                        'post',
                        'movie',
                        'tvshow',
                        'person'
                    ];
            }
            $query->set('post_type',$post_type);
        }

        return $query;
    }

}
