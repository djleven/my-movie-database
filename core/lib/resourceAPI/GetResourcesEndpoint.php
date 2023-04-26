<?php
/**
 * The class that defines the plugin's main WP API endpoint
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

use MyMovieDatabase\MyMovieDatabase;
use WP_REST_Request;
use WP_REST_Response;

use MyMovieDatabase\Admin\CacheManager;

class GetResourcesEndpoint extends AbstractEndpoint {

    /**
     * TMDb API key to use
     *
     * @since 3.0.0
     * @var string
     */
    protected $api_key;

    const MMDB_GET_DATA_WP_API_ENDPOINT = '/get-data';

    /**
     * Initialize the class and set its properties.
     *
     * @since        3.0.0
     *
     * @param string   $api_key
     */
    public function __construct($api_key) {
        parent::__construct();
        $this->api_key = $api_key;
    }

    /**
     * Action callback to register the get data endpoint with WP API
     *
     * @since     2.1.0
     * @return    void
     */
    public function register_endpoint_callback() {
        $this->registerEndpoint(
            'get_resource_data',
            self::MMDB_GET_DATA_WP_API_ENDPOINT
        );
    }

    /**
     * Call and get response from remote API endpoint
     *
     * @since     2.1.0
     *
     * @param  $data
     * @return array
     */
    public function getDataFromRemoteAPI($data) {

        try {
            $request = new BuildRequest($data, substr(get_locale(), 0, 2), $this->api_key);
            return wp_remote_get(
                $request->getRequestURL(),
                ['timeout' => 30]
            );
        } catch (\Exception $e) {
            MyMovieDatabase::writeToLog($data, 'Error code: ' . $e->getCode() . 'Error Msg: ' .  $e->getMessage());
        }
    }
    /**
     * Get the resource data
     *
     * Return cached data if it exists in database (as transient)
     * Otherwise, call the remote server endpoint to retrieve the data and save as transient
     *
     * @since     2.1.0
     *
     * @param   WP_REST_Request $request
     * @return   bool | WP_REST_Response
     */
    public function get_resource_data(WP_REST_Request $request) {

        $data = $request->get_params();

        //  Check if cached version exists
        if(isset($data['id'])) {

            $cache_manager = new CacheManager($data['type'], $data['id']);
            $transient_data = $cache_manager->getCachedData();
            if (!($transient_data === false)) {
                return $transient_data;
            }
        } elseif(!isset($data['query'])) {
            MyMovieDatabase::writeToLog($data, "Invalid params provided: Either 'id or 'query' must be set.");
            return false;
        }

        // HTTP request to get data since no transient version exists
        $response = $this->getDataFromRemoteAPI($data);
        $response_status = wp_remote_retrieve_response_code($response);
        if($response_status >= '300') {
            MyMovieDatabase::writeToLog($response, 'There was a problem fetching data: Request status: ' . $response_status);
            return false;
        }

        $response_data = wp_remote_retrieve_body($response);
        if(wp_remote_retrieve_response_code($response))
        if (empty($response_data) || (is_wp_error($response))) {
            $error_message = 'An error has occurred. Failed to fetch resource data.';
            if (is_wp_error($response)) {
                $error_message =$response->get_error_message();
            }

            MyMovieDatabase::writeToLog($response, $error_message);
            return false;
        }

        $response_data = $this->processResponseData($response_data);

        $response = new WP_REST_Response($response_data, 200);
        if(isset($cache_manager)) {
            // Store response in database for a month
            $cache_manager->setCacheData($response_data);
        }
        return $response;
    }

    protected function processResponseData($data) {

        return $data;
    }
}