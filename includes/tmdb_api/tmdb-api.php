<?php
/**
 * TMDB API v3 PHP class - wrapper to API version 3 of 'themoviedb.org
 * API Documentation: http://help.themoviedb.org/kb/api/about-3
 * Documentation and usage in README file
 *
 * @package TMDB-V3-PHP-API
 * @author adangq <adangq@gmail.com>
 * @copyright 2012 pixelead0
 * @date 2012-02-12
 * @link http://www.github.com/pixelead
 * @version 0.0.2
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 *
 * Portions of this file are based on pieces of TMDb PHP API class - API 'themoviedb.org'
 * @Copyright Jonas De Smet - Glamorous | https://github.com/glamorous/TMDb-PHP-API
 * Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 * @date 10.12.2010
 * @version 0.9.10
 * @author Jonas De Smet - Glamorous
 * @link {https://github.com/glamorous/TMDb-PHP-API}
 *
 * Added config class to make external configuration more easy
 * @Copyright Deso85 | https://github.com/deso85/TMDB-PHP-API
 * Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 * @date 02.04.2016
 * @version 0.5
 * @author Deso85
 * @link {https://github.com/deso85/TMDB-PHP-API}
 *
 */

include("controller/classes/data/Collection.php");
include("controller/classes/data/Company.php");
include("controller/classes/data/Episode.php");
include("controller/classes/data/Genre.php");
include("controller/classes/data/Movie.php");
include("controller/classes/data/Person.php");
include("controller/classes/data/Role.php");
include("controller/classes/data/Season.php");
include("controller/classes/data/TVShow.php");
include("controller/classes/roles/MovieRole.php");
include("controller/classes/roles/TVShowRole.php");
include("controller/classes/jobs/MovieJob.php");
include("controller/classes/jobs/TVShowJob.php");
include("controller/classes/config/APIConfiguration.php");
include("controller/classes/config/Configuration.php");


class TMDB {

    #@var string url of API TMDB
    const _API_URL_ = "https://api.themoviedb.org/3/";

    #@var string Version of this class
    const VERSION = '0.5';

    #@var array of config parameters
    private $config;

    #@var array of TMDB config
    private $apiconfiguration;

    /**
     * 	Construct Class
     *
     * 	@param array $cnf The necessary configuration
     */
    public function __construct($config = null) {

        // Set configuration
        $this->setConfig($config);

        // Load the API configuration
        if (! $this->_loadConfig()){
            echo _("Unable to read configuration, verify that the API key is valid");
            exit;
        }
    }

    //------------------------------------------------------------------------------
    // Configuration Parameters
    //------------------------------------------------------------------------------

    /**
     *  Set configuration parameters
     *
     * 	@param array $config
     */
    private function setConfig($config) {
        $this->config = new Configuration($config);
    }

    /**
     * 	Get the config parameters
     *
     * 	@return array $config
     */
    private function getConfig() {
        return $this->config;
    }

    //------------------------------------------------------------------------------
    // API Key
    //------------------------------------------------------------------------------



    /**
     *  Set the API Key
     *
     * 	@param string $apikey
     */
    public function setAPIKey($apikey) {
        $this->getConfig()->setAPIKey($apikey);
    }

    //------------------------------------------------------------------------------
    // Language
    //------------------------------------------------------------------------------

    /**
     *  Set the language
     *	By default english
     *
     * 	@param string $lang
     */
    public function setLang($lang = 'en') {
        $this->getConfig()->setLang($lang);
    }

    /**
     * 	Get the language
     *
     * 	@return string
     */
    public function getLang() {
        return $this->getConfig()->getLang();
    }

    //------------------------------------------------------------------------------
    // TimeZone
    //------------------------------------------------------------------------------

    /**
     *  Set the timezone
     *	By default 'Europe/London'
     *
     * 	@param string $timezone
     */
    public function setTimeZone($timezone = 'Europe/London') {
        $this->getConfig()->setTimeZone($timezone);
    }

    /**
     * 	Get the timezone
     *
     * 	@return string
     */
    public function getTimeZone() {
        return $this->getConfig()->getTimeZone();
    }

    //------------------------------------------------------------------------------
    // Adult Content
    //------------------------------------------------------------------------------

    /**
     *  Set adult content flag
     *	By default false
     *
     * 	@param boolean $adult
     */
    public function setAdult($adult = false) {
        $this->getConfig()->setAdult($adult);
    }

    /**
     * 	Get the adult content flag
     *
     * 	@return string
     */
    public function getAdult() {
        return $this->getConfig()->getAdult();
    }

    //------------------------------------------------------------------------------
    // Debug Mode
    //------------------------------------------------------------------------------

    /**
     *  Set debug mode
     *	By default false
     *
     * 	@param boolean $debug
     */
    public function setDebug($debug = false) {
        $this->getConfig()->setDebug($debug);
    }

    /**
     * 	Get debug status
     *
     * 	@return boolean
     */
    public function getDebug() {
        return $this->getConfig()->getDebug();
    }

    //------------------------------------------------------------------------------
    // Config
    //------------------------------------------------------------------------------

    /**
     * 	Loads the configuration of the API
     *
     * 	@return boolean
     */
    private function _loadConfig() {
        $this->_apiconfiguration = new APIConfiguration($this->_call('configuration'));

        return ! empty($this->_apiconfiguration);
    }

    /**
     * 	Get Configuration of the API (Revisar)
     *
     * 	@return Configuration
     */
    public function getAPIConfig() {
        return $this->_apiconfiguration;
    }

    //------------------------------------------------------------------------------
    // Get Variables
    //------------------------------------------------------------------------------

    /**
     *	Get the URL images
     * 	You can specify the width, by default original
     *
     * 	@param String $size A String like 'w185' where you specify the image width
     * 	@return string
     */
    public function getImageURL($size = 'original') {
        return $this->_apiconfiguration->getImageBaseURL().$size;
    }

    public function getSecureImageURL($size = 'original') {
        return $this->_apiconfiguration->getSecureImageBaseURL().$size;
    }
    //------------------------------------------------------------------------------
    // API Call
    //------------------------------------------------------------------------------

    /**
     * 	Makes the call to the API and retrieves the data as a JSON
     *
     * 	@param string $action	API specific function name for in the URL
     * 	@param string $appendToResponse	The extra append of the request
     * 	@return array
     */
    private function _call($action, $appendToResponse = '') {

        $url = self::_API_URL_.$action .'?api_key='. $this->getConfig()->getAPIKey() .'&language='. $this->getConfig()->getLang() .'&append_to_response='. implode(',', (array) $appendToResponse) .'&include_adult='. $this->getConfig()->getAdult();

        if ($this->getConfig()->getDebug()) {
            echo '<pre><a href="' . $url . '">check request</a></pre>';
        }

        //use Wordpress' HTTP API instead of own curl function - multiple benefits - pointed out by Ipstenu
        $results = wp_remote_get($url);
        //$http_code = wp_remote_retrieve_response_code( $results );

        return (array) json_decode(($results['body']), true);
    }

    //------------------------------------------------------------------------------
    // Get Data Objects
    //------------------------------------------------------------------------------

    /**
     * 	Get a Movie
     *
     * 	@param int $idMovie The Movie id
     * 	@param array $appendToResponse The extra append of the request
     * 	@return Movie
     */
    public function getMovie($idMovie, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('movie');

        return new Movie($this->_call('movie/' . $idMovie, $appendToResponse));
    }

    /**
     * 	Get a TVShow
     *
     * 	@param int $idTVShow The TVShow id
     * 	@param array $appendToResponse The extra append of the request
     * 	@return TVShow
     */
    public function getTVShow($idTVShow, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('tvshow');

        return new TVShow($this->_call('tv/' . $idTVShow, $appendToResponse));
    }

    /**
     * 	Get a Season
     *
     *  @param int $idTVShow The TVShow id
     *  @param int $numSeason The Season number
     * 	@param array $appendToResponse The extra append of the request
     * 	@return Season
     */
    public function getSeason($idTVShow, $numSeason, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('season');

        return new Season($this->_call('tv/'. $idTVShow .'/season/' . $numSeason, $appendToResponse), $idTVShow);
    }

    /**
     * 	Get a Episode
     *
     *  @param int $idTVShow The TVShow id
     *  @param int $numSeason The Season number
     *  @param int $numEpisode the Episode number
     * 	@param array $appendToResponse The extra append of the request
     * 	@return Episode
     */
    public function getEpisode($idTVShow, $numSeason, $numEpisode, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('episode');

        return new Episode($this->_call('tv/'. $idTVShow .'/season/'. $numSeason .'/episode/'. $numEpisode, $appendToResponse), $idTVShow);
    }

    /**
     * 	Get a Person
     *
     * 	@param int $idPerson The Person id
     * 	@param array $appendToResponse The extra append of the request
     * 	@return Person
     */
    public function getPerson($idPerson, $appendToResponse = null) {
        $appendToResponse = (isset($appendToResponse)) ? $appendToResponse : $this->getConfig()->getAppender('person');

        return new Person($this->_call('person/' . $idPerson, $appendToResponse));
    }

    //------------------------------------------------------------------------------
    // Searches
    //------------------------------------------------------------------------------

    /**
     *  Search Movie
     *
     * 	@param string $movieTitle The title of a Movie
     * 	@return Movie[]
     */
    public function searchMovie($movieTitle){

        $movies = array();

        $result = $this->_call('search/movie', '&query='. urlencode($movieTitle));

        foreach($result['results'] as $data){
            $movies[] = new Movie($data);
        }

        return $movies;
    }

    /**
     *  Search TVShow
     *
     * 	@param string $tvShowTitle The title of a TVShow
     * 	@return TVShow[]
     */
    public function searchTVShow($tvShowTitle){

        $tvShows = array();

        $result = $this->_call('search/tv', '&query='. urlencode($tvShowTitle));

        foreach($result['results'] as $data){
            $tvShows[] = new TVShow($data);
        }

        return $tvShows;
    }

    /**
     *  Search Person
     *
     * 	@param string $personName The name of the Person
     * 	@return Person[]
     */
    public function searchPerson($personName){

        $persons = array();

        $result = $this->_call('search/person', '&query='. urlencode($personName));

        foreach($result['results'] as $data){
            $persons[] = new Person($data);
        }

        return $persons;
    }

}
?>
