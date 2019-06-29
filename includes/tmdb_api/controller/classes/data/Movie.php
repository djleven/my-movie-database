<?php
/**
 * 	This class handles all the data you can get from a Movie
 *
 *	@package TMDB-V3-PHP-API
 * 	@author Alvaro Octal | <a href="https://twitter.com/Alvaro_Octal">Twitter</a>
 * 	@version 0.2
 * 	@date 02/04/2016
 * 	@link https://github.com/Alvaroctal/TMDB-PHP-API
 * 	@copyright Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 */

class Movie{

    //------------------------------------------------------------------------------
    // Class Constants
    //------------------------------------------------------------------------------

    const MEDIA_TYPE_MOVIE = 'movie';

    //------------------------------------------------------------------------------
    // Class Variables
    //------------------------------------------------------------------------------

    private $_data;
    private $_tmdb;

    /**
     * 	Construct Class
     *
     * 	@param array $data An array with the data of the Movie
     */
    public function __construct($data) {
        $this->_data = $data;
    }

    //------------------------------------------------------------------------------
    // Get Variables
    //------------------------------------------------------------------------------

    /**
     * 	Get the Movie's id
     *
     * 	@return int
     */
    public function getID() {
        return $this->_data['id'];
    }

    /**
     * 	Get the Movie's title
     *
     * 	@return string
     */
    public function getTitle() {
        return $this->_data['title'];
    }

    /**
     * 	Get the Movie's tagline
     *
     * 	@return string
     */
    public function getTagline() {
        return $this->_data['tagline'];
    }

    /**
     * 	Get the Movie Directors IDs
     *
     * 	@return array
     */
    public function getDirectorIds() {
        $director_ids = [];

        $crew = $this->_data['credits']['crew'];

        foreach ($crew as $crew_member) {

            if ($crew_member['job'] == 'Director'){
                array_push($director_ids, $crew_member["id"]);
            }
        }
        return $director_ids;
    }
    /**
     * 	Get the Movie's Poster
     *
     * 	@return string
     */
    public function getPoster() {
        return $this->_data['poster_path'];
    }

    /**
     * 	Get the Movie's vote average
     *
     * 	@return int
     */
    public function getVoteAverage() {
        return $this->_data['vote_average'];
    }

    /**
     * 	Get the Movie's vote count
     *
     * 	@return int
     */
    public function getVoteCount() {
        return $this->_data['vote_count'];
    }

    /**
     * 	Get the Movie's trailers
     *
     * 	@return array
     */
    public function getTrailers() {
        return $this->_data['trailers'];
    }

    /**
     * 	Get the Movie's youtube trailer
     *
     * 	@return string | null
     */

    public function getTrailer() {

        $trailer = $this->getTrailers();

        if($trailer['youtube']){
            return $trailer['youtube'][0]['source'];
        }

        return null;
    }

    /**
     * 	Get the Movie's genres
     *
     * 	@return Genre[]
     */
    public function getGenres() {
        $genres = [];

        foreach ($this->_data['genres'] as $data) {
            $genres[] = new Genre($data);
        }

        return $genres;
    }

    /**
     * 	Get the Movie's reviews
     *
     * 	@return Review[]
     */
    public function getReviews() {
        $reviews = [];

        foreach ($this->_data['review']['result'] as $data) {
            $reviews[] = new Review($data);
        }

        return $reviews;
    }

    /**
     * 	Get the Movie's companies
     *
     * 	@return Company[]
     */
    public function getCompanies() {
        $companies = [];

        foreach ($this->_data['production_companies'] as $data) {
            $companies[] = new Company($data);
        }

        return $companies;
    }

    /**
     * 	Get the Movie's runtime
     *
     * 	@return string
     */
    public function getRuntime() {
        return $this->_data['runtime'];
    }

    /**
     * 	Get the Movie's runtime
     *
     * 	@return string
     */
    public function getOverview() {
        return $this->_data['overview'];
    }

    /**
     * 	Get the Movie's original language
     *
     * 	@return string
     */
    public function getOrigLang() {
        return $this->_data['original_language'];
    }

    /**
     * 	Get the Movie's original title
     *
     * 	@return string
     */
    public function getOrigTitle() {
        return $this->_data['original_title'];
    }

    /**
     * Get the Movie's release date
     *
     * @param null $format
     * @return string
     */
    public function getRelDate($format = null) {
        return mmdbFormatDate($format, $this->_data['release_date']);
    }

    /**
     * 	Get the Movie's cast
     *
     * 	@return array
     */
    public function getCast() {
        $cast = [];

        foreach ($this->_data['credits']['cast']as $data) {

            $cast[] = $data;

        }
        if($cast) {
            usort($cast,function($a,$b){
                $c = $a['order'] - $b['order'];
                return $c;
            });
        }

        return $cast;
    }

    /**
     * 	Get the Movie's crew
     *
     * 	@return array
     */
    public function getCrew() {
        $cast = [];

        foreach ($this->_data['credits']['crew']as $data) {

            $cast[] = $data;
        }

        return $cast;
    }

    /**
     * 	Get the Movie's spoken languages
     *
     * 	@return array
     */
    public function getLanguages() {
        $langs = [];

        foreach ($this->_data['spoken_languages'] as $data) {

            $langs[] = $data;
        }

        return $langs;
    }

    /**
     * 	Get the Movie's translations
     *
     * 	@return array
     */

    public function getTranslations() {
        $trans = [];

        foreach ($this->_data['translations']['translations'] as $data) {

            $trans[] = $data;
        }

        return $trans;
    }

    /**
     *  Get Generic.<br>
     *  Get a item of the array, you should not get used to use this, better use specific get's.
     *
     * 	@param string $item The item of the $data array you want
     * 	@return array
     */
    public function get($item = ''){
        return (empty($item)) ? $this->_data : $this->_data[$item];
    }

    //------------------------------------------------------------------------------
    // Import an API instance
    //------------------------------------------------------------------------------

    /**
     *	Set an instance of the API
     *
     *	@param TMDB $tmdb An instance of the api, necessary for the lazy load
     */
    public function setAPI($tmdb){
        $this->_tmdb = $tmdb;
    }

    //------------------------------------------------------------------------------
    // Export
    //------------------------------------------------------------------------------

    /**
     * 	Get the JSON representation of the Movie
     *
     * 	@return string
     */
    public function getJSON() {
        return json_encode($this->_data, JSON_PRETTY_PRINT);
    }

    /**
     * @return string
     */
    public function getMediaType(){
        return self::MEDIA_TYPE_MOVIE;
    }
}
?>
