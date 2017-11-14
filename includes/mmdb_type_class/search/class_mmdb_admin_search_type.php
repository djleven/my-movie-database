<?php
/**
 * The file that defines the mmdb admin search class
 *
 * The MMDB_Content_Type is a subclass of the abstract MMDB_type class.
 *
 * @link       https://e-leven.net/
 * @since      1.0.1
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/includes/mmdb_type_class
 */

class MMDB_Admin_Search_Type extends MMDB_Type {


    public $type_slug;
    public $tmdb_id;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.1
     * @param      string    $type_slug   The mmdb content type ('slug') for the object
     * @param      string    $tmdb_id     The search key - user input - for the type object
     */
    public function __construct($type_slug, $tmdb_id) {

        $this->type_slug = $type_slug;
        $this->tmdb_id = $tmdb_id;
        $this->public_files = new MMDB_Public_Files;
    }

    /**
     * The wordpress view type
     *
     * @since     1.0.1
     * @return    string
     */
    protected function viewType() {

        return 'admin';
    }

    /**
     * Get the template for the type object
     *
     * @since     1.0.1
     * @return    string
     */
    protected function get_template_setting() {

        return 'mmdb_search_'. $this->type_slug;

    }

    /**
     * Get the appropriate 'search' callback for the TMDB API wrapper used, depending on content type
     *
     * @since     1.0.1
     * @return    string
     */
    protected function getCallback() {

        if ($this->type_slug == 'movie') {

            $callback = 'searchMovie';
        }
        elseif ($this->type_slug == 'tvshow') {

            $callback = 'searchTVShow';
        }

        elseif ($this->type_slug == 'season') {

            $callback = 'searchSeason';
        }
        elseif ($this->type_slug == 'person') {

            $callback = 'searchPerson';
        }
        elseif ($this->type_slug == 'episode') {

            $callback = 'searchEpisode';
        }

        return $callback;

    }

    /**
     * Setup and return the mmdb admin search view (results)
     *
     * @since    1.0.1
     * @param     object     $mmdb_type  	MMDB_Admin_Search_Type object
     * @return    string     The mmdb admin search view
     */
    public function mmdb_the_admin_search_view($mmdb_type) {

        ob_start();
        $tmdb = new TMDB();
        $mmdb_results = $mmdb_type->get_tmdb_content($tmdb);

        if(count($mmdb_results) == 0) {
            $discard = ob_get_clean();
            $result = __("No results found. Please try again", "my_movie_database");
        }

        else {

            $file = $mmdb_type->mmdb_set_template_order($mmdb_type->get_template_setting(), $mmdb_type->type_slug, $mmdb_type->viewType());
            include ($file);
            $result = ob_get_clean();
        }

        return $result;
    }

}

