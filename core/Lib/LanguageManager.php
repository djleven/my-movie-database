<?php
/**
 * Orchestrates the i18n textdomain and language file loading functionality of the plugin.
 *
 * @link       https://e-leven.net/
 * @since      3.0.2
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/lib/
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib;

use MyMovieDatabase\Constants;
use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Interfaces\FilterHookSubscriberInterface;

/**
 * Besides registering the plugin textdomain this class is responsible for:
 *
 * 1-) Fixing the incorrect hash in the JSON filename that WordPress will look for
 *
 * This is related to https://github.com/wp-cli/i18n-command/issues/127
 * Problem is the WP_CLI i18n makePot is not detecting the language strings inside the (webpack) bundled js app file
 * that ships with the plugin. As a workaround, the original file of the js app (i18n.js) that holds all the language
 * strings is included in the plugin as a dummy file with the sole purpose of having the language strings detected.
 *
 * This results in a miscalculated hash
 *
 * md5('assets/js/app/i18n.js') = 4a703481cd11f3975571aec5fc83a803
 * md5('assets/js/app/app.umd.js') = 7d15a23e5780208e6e977a7174aa290f
 *
 *
 * 2-) Modifying language file load order hierarchy to add a (final) local locale-less fallback for both JSON and MO files
 * For JSON files we also add a hash-less and handle-less name version.
 *  - see handle_i18n_json_files() and add_fallback_i18n_mo_file_if_needed() respectively
 *
 * About local locale-less fallback:
 *
 * This plugin ships with some basic translation files.
 * There files may be partial translations and / or not editor approved / peer reviewed.
 * These basic translation files have no locale, only language (ex: 'fr', not 'fr-FR').
 *
 * These files are referred to as 'local' (+ non-locale files).
 * Those that originate from translate.wordpress.org are referred to as 'remote' (and found in plugins/languages folder).
 *
 * When there are no local or remote locale specific files available (ex: 'fr-CA'), this class will load these generic
 * local (non-locale) files (ex: 'fr', if existing). This method is the case for both for .mo and .json files.
 *
 * In the case of non multi-locale languages like Spanish, French, German, etc., the principle is that if the user locale is
 * say Belgian French (fr-BG), and there is only a fr-FR translation available, it is preferable to use this as fallback
 * instead of English.
 * Or, as in the case of non-multi locale generic files, simply, that it is better to have a partial imperfect translation
 * rather than none at all.
 *
 * Some code based on https://vedovini.net/2013/12/18/smart-fallback-mechanism-for-loading-text-domains-in-wordpress/
 *
 * Caveat: Use of .mo translation files in the (php) code are available only after the 'load_textdomain_mofile' filter has fired.
 *
 * In this here plugin, with some minor modifications, this is fine. Beats copying the same .mo files for each locale.
 *
 * @since     3.0.2
 * @return    string
 */
class LanguageManager implements ActionHookSubscriberInterface, FilterHookSubscriberInterface {

    CONST LANGUAGE_FOLDER = 'languages';
    CONST LOCAL_LANGUAGES_PATH = 'plugins/' . Constants::PLUGIN_NAME_DASHES . '/' . self::LANGUAGE_FOLDER;
    CONST REMOTE_LANGUAGES_PATH = self::LANGUAGE_FOLDER . '/plugins';

    /**
     * Get the action hooks to be registered.
     *
     * @since    2.5.0 (moved in this file on v3.0.2)
     * @access   public
     */
    public function getActions()
    {
        return [
            'plugins_loaded' => 'load_plugin_textdomain',
        ];
    }

    /**
     * Get the action hooks to be registered.
     *
     * @since    3.0.2
     * @access   public
     */
    public function getFilters()
    {
        return [
            'load_textdomain_mofile'       => ['add_fallback_i18n_mo_file_if_needed',10, 2],
            'load_script_translation_file' => ['handle_i18n_json_files',10, 2]
        ];
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0 (moved in this file on v3.0.2)
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            Constants::PLUGIN_NAME_DASHES,
            false,
            Constants::PLUGIN_NAME_DASHES . '/' . static::LANGUAGE_FOLDER
        );
    }

    /**
     * The 'load_script_translation_file' filter callback for mo files
     *
     * WordPress will look for the following mo files in this order (ex in sv_SE locale, all paths in wp-content/):
     *
     * 1-) languages/plugins/my-movie-database-sv_SE.mo
     * 2-) plugins/my-movie-database/languages/my-movie-database-sv_SE.mo
     *
     * To the above we will add a final fallback, the non-locale specific local file:
     *
     * 3-) plugins/my-movie-database/languages/my-movie-database-sv.mo
     *
     * Plugins such as Loco Translate do their magic at a later time, so even a custom file location such as
     * 'languages/loco/plugins', in this case, works.
     */
    public function add_fallback_i18n_mo_file_if_needed($src) {

        if ($this->isNonExistentLocalTranslation($src)) {
            /** 3 */
            $src = $this->stripAllAfterLocaleFromFilepath($src);
        }

        /** 1 and 2 */
        return $src;
    }

    /**
     * Determine if source path lead to a non-existent local language file
     *
     * @since     3.0.2
     * @return    bool
     */
    protected function isNonExistentLocalTranslation($src) {

        return $this->str_contains($src, '/plugins/' . Constants::PLUGIN_NAME_DASHES . '/' . static::LANGUAGE_FOLDER . '/')
            && !is_readable($src);
    }

    /**
     * The 'load_script_translation_file' filter callback for JSON files
     *
     * Assuming that a language file is not present in the system, the 'load_script_translation_file' filter will be
     * fired 3 times (for current textdomain) with the following $file values in this order
     * (ex in sv_SE locale, all paths in wp-content/):
     *
     * a-) plugins/my-movie-database/languages/my-movie-database-sv_SE-app.umd.json
     * b-) plugins/my-movie-database/languages/my-movie-database-sv_SE-7d15a23e5780208e6e977a7174aa290f.json
     * c-) languages/plugins/my-movie-database-sv_SE-7d15a23e5780208e6e977a7174aa290f.json
     *
     * To the above (WordPress) hierarchy, this method will add 2 more options
     * - a local locale specific filepath without the wp handle (number 2 below)
     * - a final fallback, the non-locale specific local file (number 5)
     *
     * So the final order will be (all paths in wp-content/):
     *
     * 1-) plugins/my-movie-database/languages/my-movie-database-sv_SE-app.umd.json
     * 2-) plugins/my-movie-database/languages/my-movie-database-sv_SE.json
     * 3-) plugins/my-movie-database/languages/my-movie-database-sv_SE-4a703481cd11f3975571aec5fc83a803.json
     * 4-) languages/plugins/my-movie-database-sv_SE-4a703481cd11f3975571aec5fc83a803.json
     * 5-) plugins/my-movie-database/languages/plugins/my-movie-database-sv.json
     *
     * Plugins such as Loco Translate do their magic at a later time, so even a custom file location such as
     * 'languages/loco/plugins', in this case, works.
     *
     * @since     3.0.2
     * @return    bool
     */
    public function handle_i18n_json_files($file, $handle) {
        if (!$this->str_contains($file, Constants::PLUGIN_NAME_DASHES)) {
            return $file;
        }

        if($this->str_contains($file, $handle)) {
            /** 1 and 2 */
            return $this->handleFilesWithHandleJSON($file, $handle);
        }

        $inCorrectHash = '-7d15a23e5780208e6e977a7174aa290f';
        if($this->str_contains($file, $inCorrectHash)) {
            /** 3, 4 and 5*/
            return $this->handleFilesWithHashAndFinalFallbackJSON($file, $inCorrectHash);
        }

        return $file;
    }

    /**
     * Handle JSON i18n files for priority 1 and 2
     *
     * 1-) plugins/my-movie-database/languages/my-movie-database-sv_SE-app.umd.json
     * 2-) plugins/my-movie-database/languages/my-movie-database-sv_SE.json
     *
     * @since     3.0.2
     * @return    string
     */
    protected function handleFilesWithHandleJSON($file, $handle) {
        if ( is_readable( $file ) ) {
            /** 1 */
            return $file;
        }
        $handleNameStringToReplace = '-' . $handle;

        /** 2 */
        return str_replace( $handleNameStringToReplace, '', $file );
    }

    /**
     * Handle JSON i18n files with hash and non-locale specific final fallback, priorities 3, 4 and 5.
     *
     * 3-) plugins/my-movie-database/languages/my-movie-database-sv_SE-4a703481cd11f3975571aec5fc83a803.json
     * 4-) languages/plugins/my-movie-database-sv_SE-4a703481cd11f3975571aec5fc83a803.json
     * 5-) plugins/my-movie-database/languages/plugins/my-movie-database-sv.json
     *
     * @since     3.0.2
     * @return    string
     */
    protected function handleFilesWithHashAndFinalFallbackJSON($file, $inCorrectHash) {
        $correctHash = '-4a703481cd11f3975571aec5fc83a803';
        /** 3 and 4 */
        $file = str_replace($inCorrectHash, $correctHash, $file);
        if($this->str_contains($file, self::REMOTE_LANGUAGES_PATH) && !is_readable($file)) {
            /** We are in 4 and the file does not exist, hence 5 */
            return str_replace(
                self::REMOTE_LANGUAGES_PATH,
                self::LOCAL_LANGUAGES_PATH,
                $this->stripAllAfterLocaleFromFilepath($file)
            );
        }

        /** 3 or 4 */
        return $file;
    }

    /**
     * Implement a str_contains placeholder function for earlier PHP versions.
     *
     * TODO: remove when PHP 8 is minimum requirement
     *
     * @param     string $haystack
     * @param     string $needle
     * @return    bool
     * @since     3.1.0
     */
    protected function str_contains($haystack, $needle) {
        return strpos($haystack, $needle) !== false;
    }


    /**
     * Get the final fallback path to a local non-locale specific translation file.
     *
     * @since     3.0.2
     * @return    string
     */
    protected function stripAllAfterLocaleFromFilepath($src) {
        extract(pathinfo($src));
        $pos = strrpos($filename, '_');

        /** if locale part exists (ex:Afrikaans has no locale) */
        if ($pos !== false) {
            /** cut off the locale, leaving the language part only */
            $filename = substr($filename, 0, $pos);
            $src = $dirname . '/' . $filename . '.' . $extension;
        }

        return $src;
    }
}
