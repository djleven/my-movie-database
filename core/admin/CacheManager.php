<?php
/**
 * The class that manages the plugin's caching
 *
 * Plugin Convention:
 * Methods in underscore naming represent registered wordpress hook callbacks
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/admin/resourceAPI
 */
namespace MyMovieDatabase\Admin;

class CacheManager {

    /**
     * @var string
     */
    protected $data_type;

    /**
     * @var string
     */
    protected $data_id;

    /**
     * @var string
     */
    public $cache_key;


    const MMDB_TRANSIENT_ID = 'mmodb_';

    /**
     * Initialize the class
     *
     * @since    3.0.0
     *
     * @param      string    $data_type     The data type.
     * @param      string    $data_id       The data id.
     */
    public function __construct($data_type, $data_id) {

        $this->data_type = $data_type;
        $this->data_id = $data_id;
        $this->cache_key = $this->getCacheKey();
    }

    /**
     * Get the transient key
     *
     * @since    3.0.0
     *
     * @return     string
     */
    protected function getCacheKey() {

        return static::MMDB_TRANSIENT_ID . $this->data_type . '_' . $this->data_id . '_' .substr(get_locale(),0,2);
    }

    /**
     * Get the cached data expires key
     *
     * @since    3.0.0
     *
     * @return     string
     */
    protected function getCacheExpiresKey() {

        return '_transient_timeout_'. $this->cache_key;
    }

    /**
     * Get the cached data
     *
     * @since    3.0.0
     *
     * @return mixed
     */
    public function getCachedData() {

        return get_transient($this->cache_key);
    }

    /**
     * Delete the cached data
     *
     * @since    3.0.0
     *
     * @return     bool
     */
    public function deleteCachedData() {

        return delete_transient($this->cache_key);
    }

    /**
     * Cache data
     *
     * @since    3.0.0
     *
     * @return bool
     */
    public function setCacheData($response_data, $duration = MONTH_IN_SECONDS) {

        return set_transient($this->cache_key, $response_data, $duration);
    }

    /**
     * Get the cached data's expires (value) timestamp
     *
     * @since    3.0.0
     *
     * @return int
     */
    public function getCacheExpiresTimestamp() {

        return (int) get_option( $this->getCacheExpiresKey(), 0 );
    }

    /**
     * Get the cached data's expires timestamp left
     *
     * @since    3.0.0
     *
     * @return int
     */
    public function getCacheExpiresTimestampLeft() {
        $expires = $this->getCacheExpiresTimestamp();
        if(!$expires) {
            return $expires;
        }
        return  $expires - time();
    }

    /**
     * Get the cached data's expires date
     *
     * @since    3.0.0
     *
     * @return false|string
     */
    public function getCacheExpiresDate($format = null) {

        if($format === null) {
            $format = get_option( 'date_format' );
        }
        $expires = $this->getCacheExpiresTimestamp();
        if(!$expires) {
            return (bool) $expires;
        }
        return wp_date($format, $expires);
    }

    /**
     * Get the cached data's expires days left
     *
     * @since    3.0.0
     *
     * @return int
     */
    public function getCacheExpiresDaysLeft() {

        $expires = $this->getCacheExpiresTimestampLeft();
        if(!$expires) {
            return $expires;
        }
        return ceil($expires / 86400);
    }
}
