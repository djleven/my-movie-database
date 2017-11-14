<?php
/**
 * The class responsible for finding public template file url's (for ex: css, js, placeholder img).
 *
 * Looks for the 'asset' files in default wordpress theme and falls back to plugin version if unavailable
 *
 * @link       https://e-leven.net/
 * @since      1.1.0
 *
 * @package    My_movie_database
 * @subpackage My_movie_database/public
 * @author     Kostas Stathakos <info@e-leven.net>
 */

class MMDB_Public_Files {

    private $path;

    /**
     * Initialize the class and set its properties.
     *
     * @since      1.1.0
     */
    public function __construct() {

        $this->path = 'mmdb_templates/assets/';
    }

    /**
     * Return the correct scripts file -
     * Check if a custom template exists in the theme folder, if not, load the plugin template file
     *
     * @since      1.0.8
     * @param      string $file_name The file name.
     * @param      string $type The file type / extension.
     * @return     string
     */
    public function mmdb_set_scripts_order($file_name, $type, $ext = null) {

        if(!($ext)) {$ext = $type;}
        $path =  $this->path . $type . '/' . $file_name . '.' . $ext;

        if (locate_template(array($path))) {
            $file = get_theme_file_uri('/' . $path);
        }
        else {
            $file = plugin_dir_url( dirname(__FILE__)) . $path;
        }
        try{
            $thisfile = @fopen($file,'r');
            if( !$thisfile ) {
                throw new Exception("The My Movie Database $type file $file could not be found",404);
            }
        }
        catch( Exception $e ){
            echo "Error : " . $e->getMessage();
            return;
        }

        return $file;
    }

    /**
     * Cast and Crew like profile image url, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object $result The ressource object.
     * @param      object $tmdb The tmdb object.
     * @return     string
     */
    public function mmdb_get_profile_image($result, $tmdb) {

        $image=$result['profile_path'] == null ? $this->mmdb_set_scripts_order('cinema', 'img', 'png') : $tmdb->getSecureImageURL('w132_and_h132_bestv2') . $result['profile_path'];

        return $image;
    }

    /**
     * Poster image url, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object    $mmdb  The ressource object.
     * @return     string
     */
    public function mmdb_get_poster($mmdb) {

        $image=$mmdb->getPoster() == null ? $this->mmdb_set_scripts_order('cinema185', 'img', 'png') : "https://image.tmdb.org/t/p/w185/" . $mmdb->getPoster();

        return $image;
    }

    /**
     * Backdrop poster image url, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object    $mmdb  The ressource object.
     * @return     string
     */
    function mmdb_get_backdrop_poster($mmdb) {

        $image=$mmdb->getPoster() == null ? $this->mmdb_set_scripts_order('cinema100', 'img', 'png')  : "https://image.tmdb.org/t/p/w185/" . $mmdb->getPoster();

        return $image;
    }

    /**
     * Profile poster image url used in admin/persons, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object    $mmdb  The ressource object.
     * @return     string
     */
    function mmdb_get_profile($mmdb) {

        $image=$mmdb->getProfile() == null ? $this->mmdb_set_scripts_order('cinema185', 'img', 'png') : "https://image.tmdb.org/t/p/w185/" . $mmdb->getProfile();

        return $image;
    }

}
