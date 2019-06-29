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

    const SMALL_PLACEHOLDER = 'cinema';
    const MEDIUM_PLACEHOLDER = 'cinema185';
    const LARGE_PLACEHOLDER = 'cinema300';

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
     * @param      null $ext
     * @return     string
     */
    public function mmdbSetScriptsOrder($file_name, $type, $ext = null) {

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
     * @param      object $result The resource object.
     * @param      string $path
     * @param      string $placeholderSize
     * @param      string $type
     * @param      string $ext
     * @return     string
     */
    public function mmdbGetCreditProfileImage(
        $result,
        $path,
        $placeholderSize = 'small',
        $type = 'img',
        $ext = 'png'
    ) {
        $image = $result['profile_path'];
        return $image ?
            $path . $image
            : $this->mmdbSetScriptsOrder($this->mmdbGetPlaceholder($placeholderSize), $type, $ext);

    }

    /**
     * Poster image url, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object $mmdb The resource object.
     * @param      string $path
     * @param      null | string $placeholderSize
     * @param      string $type
     * @param      string $ext
     * @return     string
     */
    public function mmdbGetPoster(
        $mmdb,
        $path,
        $placeholderSize = 'medium',
        $type = 'img',
        $ext = 'png'
    ) {
        $image = $mmdb->getPoster();

        return $image ?
            $path . $image
            : $this->mmdbSetScriptsOrder($this->mmdbGetPlaceholder($placeholderSize), $type, $ext);
    }

    /**
     * Backdrop poster image url, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object    $mmdb  The resource object.
     * @param      string    $path
     * @return     string
     */
    function mmdbGetBackdropPoster($mmdb, $path) {

        return $this->mmdbGetPoster($mmdb, $path,'medium');
    }

    /**
     * Profile poster image url used in admin/persons, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      object    $mmdb  The resource object.
     * @param      string    $path
     * @param      null | string $placeholderSize
     * @param      string $type
     * @param      string $ext
     * @return     string
     */
    function mmdbGetProfile(
        $mmdb,
        $path,
        $placeholderSize = 'medium',
        $type = 'img',
        $ext = 'png'
    ) {
        $image = $mmdb->getProfile();

        return $image ?
            $path . $image
            : $this->mmdbSetScriptsOrder($this->mmdbGetPlaceholder($placeholderSize), $type, $ext);
    }

    /**
     * Profile poster image url used in admin/persons, return placeholder img if empty.
     *
     * @since      1.0.0
     * @param      string $placeholderSize
     * @return     string
     */
    function mmdbGetPlaceholder($placeholderSize) {

        if ($placeholderSize === 'small') {
            return self::SMALL_PLACEHOLDER;
        } else if($placeholderSize === 'medium') {
            return self::MEDIUM_PLACEHOLDER;
        } else if($placeholderSize === 'large') {
            return self::LARGE_PLACEHOLDER;
        } else {
            return self::SMALL_PLACEHOLDER;
        }
    }

}
