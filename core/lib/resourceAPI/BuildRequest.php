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
     * The request API key
     *
     * @since 2.1.0
     * @var string
     */
    protected $api_key = "c8df48be0b9d3f1ed59ee365855e663a";

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
     * @throws Exception
     */
    public function __construct($data, $language)
    {
        $this->data = $data;
        $this->options = [
            'api_key' => $this->api_key,
            'language' => $language,
        ];
        $this->generateGETRequestURL();
    }

    /**
     * Generate remote API endpoint request url
     *
     * @return  string
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
            'movie' => 'credits,trailers',
            'person' => 'combined_credits',
            'tvshow' => 'credits'
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
     * @throws  Exception
     */
    protected function resourceTypeUri($type) {
        switch ($type) {
            case 'movie':
            case 'person':
                return $type;
            case 'tvshow':
                return 'tv';
            default:
                 throw new Exception('Invalid resource type specified');
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
}