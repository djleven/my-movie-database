<?php
/**
 * 	This class handles all the data you can get from a Person
 *
 *	@package TMDB-V3-PHP-API
 * 	@author Alvaro Octal | <a href="https://twitter.com/Alvaro_Octal">Twitter</a>
 * 	@version 0.1
 * 	@date 11/01/2015
 * 	@link https://github.com/Alvaroctal/TMDB-PHP-API
 * 	@copyright Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 */

class Person{

    //------------------------------------------------------------------------------
    // Class Constants
    //------------------------------------------------------------------------------

    const MEDIA_TYPE_PERSON = 'person';

    //------------------------------------------------------------------------------
    // Class Variables
    //------------------------------------------------------------------------------

    private $_data;

    /**
     * 	Construct Class
     *
     * 	@param array $data An array with the data of the Person
     */
    public function __construct($data) {
        $this->_data = $data;
    }

    //------------------------------------------------------------------------------
    // Get Variables
    //------------------------------------------------------------------------------

    /** 
     *  Get the Person's name
     *
     *  @return string
     */
    public function getName() {
        return $this->_data['name'];
    }

    /** 
     *  Get the Person's id
     *
     *  @return int
     */
    public function getID() {
        return $this->_data['id'];
    }

    /** 
     *  Get the Person's profile image
     *
     *  @return string
     */
    public function getProfile() {
        return $this->_data['profile_path'];
    }


    /** 
     *  Get the Person's profile biography
     *
     *  @return string
     */
    public function getΒiography() {
        return $this->_data['biography'];
    }


    /** 
     *  Get the Person's birthday
     *
     *  @return string
     */
    public function getBirthday() {
        return $this->_data['birthday'];
    }

    /** 
     *  Get the Person's deathday
     *
     *  @return string
     */
    public function getDeathday() {
        return $this->_data['deathday'];
    }

    /** 
     *  Get the Person's place of birth
     *
     *  @return string
     */
    public function getPlaceOfBirth() {
        return $this->_data['place_of_birth'];
    }

    /** 
     *  Get the Person's imdb id
     *
     *  @return string
     */
    public function getImbdID() {
        return $this->_data['imdb_id'];
    }

    /** 
     *  Get the Person's popularity
     *
     *  @return int
     */
    public function getPopularity() {
        return $this->_data['popularity'];
    }

    /**
     *  Get the Person's MovieRoles
     *
     *  @return MovieRole[]
     */
    public function getMovieRoles() {
        $movieRoles = array();

        foreach($this->_data['movie_credits']['cast'] as $data){
            $movieRoles[] = new MovieRole($data, $this->getID());
        }

        return $movieRoles;
    }

    /**
     *  Get the Person's TVShowRoles
     *
     *  @return TVShowRole[]
     */
    public function getTVShowRoles() {
        $tvShowRoles = array();

        foreach($this->_data['tv_credits']['cast'] as $data){
            $tvShowRoles[] = new TVShowRole($data, $this->getID());
        }

        return $tvShowRoles;
    }

    /**
     *  Get the Person's Movie Crew Credits
     *
     *  @return MovieRole[]
     */
    public function getMovieJobs() {
        $movieRoles = array();

        foreach($this->_data['movie_credits']['crew'] as $data){
            $movieRoles[] = new MovieJob($data, $this->getID());
        }

        return $movieRoles;
    }

    /**
     *  Get the Person's TVShow Crew Credits
     *
     *  @return TVShowRole[]
     */
    public function getTVShowJobs() {
        $tvShowRoles = array();

        foreach($this->_data['tv_credits']['crew'] as $data){
            $tvShowRoles[] = new TVShowJob($data, $this->getID());
        }

        return $tvShowRoles;
    }

    /**
     *  Count the Person's MovieRoles
     *
     *  @return MovieRole[]
     */
    public function getMovieRoleCount() {

        $movieRoles = count($this->_data['movie_credits']['cast']);

        return $movieRoles;
    }

    /**
     *  Count the Person's TVShowRoles
     *
     *  @return MovieRole[]
     */
    public function getTvRoleCount() {

        $tvShowRoles = count($this->_data['tv_credits']['cast']);

        return $tvShowRoles;
    }

    /**
     *  Count the Person's Movie Crew Credits
     *
     *  @return MovieRole[]
     */
    public function getMovieCrewCount() {

        $movieRoles = count($this->_data['movie_credits']['crew']);

        return $movieRoles;
    }

    /**
     *  Count the Person's TVShow Crew Credits
     *
     *  @return MovieRole[]
     */
    public function getTvCrewCount() {

        $tvShowRoles = count($this->_data['tv_credits']['crew']);

        return $tvShowRoles;
    }


    /**
     * 	Get the Person's imdb id
     *
     * 	@return string
     */
    public function getImdbID() {
        return $this->_data['imdb_id'];
    }

    /**
     * 	Get the Person's homepage
     *
     * 	@return string
     */
    public function getHomePage() {
        return $this->_data['homepage'];
    }


    /**
     *  Get Generic.<br>
     *  Get a item of the array, you should not get used to use this, better use specific get's.
     *
     *  @param string $item The item of the $data array you want
     *  @return array
     */
    public function get($item = ''){
        return (empty($item)) ? $this->_data : $this->_data[$item];
    }

    //------------------------------------------------------------------------------
    // Export
    //------------------------------------------------------------------------------

    /**
     *  Get the JSON representation of the Episode
     *
     *  @return string
     */
    public function getJSON() {
        return json_encode($this->_data, JSON_PRETTY_PRINT);
    }


    /**
     * @return string
     */
    public function getMediaType(){
        return self::MEDIA_TYPE_PERSON;
    }
}
?>
