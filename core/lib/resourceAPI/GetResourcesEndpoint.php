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

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class GetResourcesEndpoint extends RegisterEndpoint {

    const MMDB_GET_DATA_WP_API_ENDPOINT = '/get-data';
    const MMDB_TRANSIENT_ID = 'mmodb_';

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
     * @return array | WP_Error
     */
    public function getDataFromRemoteAPI($data) {

        try {
            $request = new BuildRequest($data, substr(get_locale(), 0, 2));
        } catch (\Exception $e) {
            return new WP_Error($e->getCode(), $e->getMessage(), $data);
        }
        return wp_remote_get(
            $request->getRequestURL(),
            ['timeout' => 30]
        );
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
     * @return   WP_Error | WP_REST_Response
     */
    public function get_resource_data(WP_REST_Request $request) {

        $data = $request->get_params();

        //  Check if cached version exists
        if(isset($data['id'])) {
            $transient_key = self::MMDB_TRANSIENT_ID . $data['type'] . '_' . $data['id'] . '_' .substr(get_locale(),0,2);
            $transient_data = get_transient($transient_key);
            if (!($transient_data === false)) {
                return $transient_data;
            }
        } elseif(!isset($data['query'])) {
            return new WP_Error('', "Invalid params provided: Either 'id or 'query' must be set.", $data);
        }

        // HTTP request to get data since no transient version exists
        $response = $this->getDataFromRemoteAPI($data);
        $response_data = wp_remote_retrieve_body($response);
        if (empty($response_data) || (is_wp_error($response))) {
            $error_message = 'An error has occurred. Failed to fetch resource data.';
            if (is_wp_error($response)) {
                $error_message =$response->get_error_message();
            }
//            $this->logEndpointErrors($error_message, 'EndpointController:get_resource_data');
            return new WP_Error('', $error_message , $response);
        }

        $response_data = $this->processResponseData($response_data);

        $response = new WP_REST_Response($response_data, 200);
        if(isset($transient_key)) {
            // Store response in database for a month
            set_transient($transient_key, $response_data, MONTH_IN_SECONDS);
        }
        return $response;
    }

    protected function processResponseData($data) {

        return $data;
    }
}