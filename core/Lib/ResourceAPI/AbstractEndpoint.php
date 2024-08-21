<?php
/**
 * This class handles registering a plugin endpoint with WP API
 *
 * Plugin Convention:
 * Methods in underscore naming represent registered wordpress hook callbacks
 *
 * @link       https://e-leven.net/
 * @since      2.1.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/lib/resourceAPI
 */
namespace MyMovieDatabase\Lib\ResourceAPI;

use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;

abstract class AbstractEndpoint implements ActionHookSubscriberInterface {

    const MMDB_WP_API_NAMESPACE = 'my-movie-db';
    const MMDB_WP_API_VERSION = '/v2';

    /**
     * Whether to display the endpoint int the WP public index
     *
     * @since 2.1.0
     * @var bool
     */
    protected $show_in_index;

    /**
     * Whether endpoint access requires user log-in or not
     *
     * @since 2.1.0
     * @var bool
     */
    protected $require_log_in;

    abstract public function register_endpoint_callback();

    /**
     * Initialize the class and set its properties.
     *
     * @since        2.1.0
     *
     * @param bool   $show_in_index
     * @param bool   $require_log_in
     */
    public function __construct($show_in_index = true, $require_log_in = false) {
        $this->show_in_index = $show_in_index;
        $this->require_log_in = $require_log_in;
    }

    /**
     * Get the action hooks related to registering endpoints with the WordPress API
     *
     * Enqueue scripts
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'rest_api_init' => 'register_endpoint_callback',
        ];
    }

    /**
     * Action callback to register a plugin endpoint with WP API
     *
     * @since     2.1.0
     *
     * @param     string $endpoint_callback
     * @param     string $route
     * @param     string $methods
     * @return    void
     */
    protected function registerEndpoint($endpoint_callback, $route, $methods = 'GET') {
        register_rest_route(
            self::MMDB_WP_API_NAMESPACE . self::MMDB_WP_API_VERSION,
            $route,
            [
                'methods' => $methods,
                'callback' => array($this, $endpoint_callback),
                'show_in_index' => $this->show_in_index,
                'permission_callback' => array($this, 'require_logged_in_permission')
            ]
        );
    }

    /**
     * Determine if log-in permissions are met
     *
     * @since     2.1.0
     * @return    bool
     */
    public function require_logged_in_permission() {

        if($this->require_log_in) {

            return is_user_logged_in();
        }

        return true;
    }
}