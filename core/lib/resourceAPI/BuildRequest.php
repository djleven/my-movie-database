<?php
/**
 * This class builds API requests
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

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;
use Exception;

class BuildRequest
{
    /**
     * The remote endpoint base url
     *
     * @since 2.1.0
     * @var string
     */
    protected $base_url = 'https://api.themoviedb.org/3/';

    /**
     * The request data
     *
     * @since 2.1.0
     * @var string
     */
    protected $data;

    /**
     * The request uri
     *
     * @since 2.1.0
     * @var string
     */
    protected $uri;

    /**
     * The request options
     *
     * @since 2.1.0
     * @var string
     */
    protected $options;

    /**
     * Initialize the class and set its properties.
     *
     * @param  array $data
     * @param  string $language
     * @param  string $api_key
     * @throws Exception
     */
    public function __construct($data, $language, $api_key)
    {
        $this->data = $data;
        $this->options = [
            'api_key' => $api_key,
            'language' => $language,
        ];
        $this->generateGETRequestURL();
    }

    /**
     * Generate remote API endpoint request url
     *
     * @return  void
     * @throws  Exception
     * @since   2.1.0
     */
    protected function generateGETRequestURL()
    {
        if (isset($this->data['query'])) {
            $this->getSearchRequestParams();
        } else {
            $this->getSingleRequestParams();
        }
    }

    /**
     * Create single resource request
     *
     * @throws Exception
     * @since  2.1.0
     */
    protected function getSingleRequestParams(){

        $credit_uri = [
            MovieResourceType::DATA_TYPE_NAME => 'credits,trailers',
            PersonResourceType::DATA_TYPE_NAME => 'combined_credits',
            TvshowResourceType::DATA_TYPE_NAME => 'credits'
        ];

       $this->uri = $this->resourceTypeUri($this->data['type']) . '/' . $this->data['id'];

        $this->options = array_merge($this->options, [
            'append_to_response' => $credit_uri[$this->data['type']]
        ]);
    }

    /**
     * Create search request
     *
     * @throws Exception
     * @since  2.1.0
     */
    protected function getSearchRequestParams(){

        $this->uri = 'search/' . $this->resourceTypeUri($this->data['type']);

        $this->options = array_merge($this->options, [
            'query' => $this->data['query']
        ]);
    }

    /**
     * Convert plugin type to API type uri
     *
     * @since   2.1.0
     *
     * @param   string $type
     * @return  string
     */
    protected static function resourceTypeUri($type) {
        switch ($type) {
            case MovieResourceType::DATA_TYPE_NAME :
            case PersonResourceType::DATA_TYPE_NAME:
                return $type;
            case TvshowResourceType::DATA_TYPE_NAME:
                return 'tv';
            default:
                return $type;;
        }
    }

    /**
     * Generate remote API endpoint request url
     *
     * @since   2.1.0
     * @return  string
     */
    public function getRequestURL()
    {
        return $this->base_url . $this->uri . '?' . http_build_query($this->options);
    }

    /**
     * Generate the TMDd website URL fort a resource
     *
     * @param string $data_type The data type.
     * @param string $data_id The data id.
     *
     * @return  string
     * @since   3.0.0
     */
    public static function getTMDBLink($data_type, $data_id)
    {
        $site_URL = 'https://www.themoviedb.org/';
        return $site_URL . static::resourceTypeUri($data_type) . '/' . $data_id;
    }
}