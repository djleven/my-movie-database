<?php
/**
 * The class responsible for finding template file paths and related functionality
 *
 * Looks for the files in default wordpress theme first and falls back to plugin's version if unavailable
 * UPDATE: As of v3.0.0, the latter only applied to css files
 *
 * @link       https://e-leven.net/
 * @since      1.1.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Constants;

class TemplateFiles {

	CONST ASSETS_PUBLIC_PATH   = 'assets/';
	CONST ASSETS_PUBLIC_JS_PATH = self::ASSETS_PUBLIC_PATH . 'js/';
	CONST PLUGIN_JS_LIB_FILE   = 'app.umd';

    /**
     * Return the correct assets (public) file url ( now used only for css)
     * Check if file exists in the theme folder, if not load the plugin template file
     *
     * @since      1.0.8
     * @param      string        $path       Folder and file name relative to assets folder.
     * @return     string
     */
	public static function getPublicFile($path) {
		$path = self::ASSETS_PUBLIC_PATH . $path;

		$theme_path = Constants::PLUGIN_NAME_DASHES . '/' . $path;
		if (locate_template(array($theme_path))) {
			return get_theme_file_uri('/' . $theme_path);
		}

		return plugin_dir_url( dirname(__FILE__)) . $path;
	}

    /**
     * Return the correct css file url to enqueue (can be overridden by theme folder)
     *
     * @since      3.0.0
     * @param      string        $fileName       The file name without extension.
     * @return     string
     */
	public static function getPublicStylesheet($fileName) {

		$path = 'css/' . $fileName . '.css';

		return self::getPublicFile($path);
	}

    /**
     * Return the js file url to enqueue (can NOT be overridden by theme folder)
     *
     * @since      3.0.0
     * @param      string        $fileName         The file name without extension.
     * @param      string        $filePrependPath  The path to add right before the file.
     * @return     string
     */
    public static function getJsFilePath($fileName, $filePrependPath = '') {

        return MMDB_PLUGIN_URL . TemplateFiles::ASSETS_PUBLIC_JS_PATH . $filePrependPath . $fileName . '.js';
    }

    /**
     * Register the JavaScript and CSS for both public-facing and admin sides of the site.
     *
     *
     * @since    1.0.0
     * @param    $load_css_file  boolean
     */
    public static function enqueueCommonFiles($load_css_file) {

        self::enqueuePluginLibrary();
        if($load_css_file) {
            wp_enqueue_style(
                Constants::PLUGIN_NAME_UNDERSCORES,
                TemplateFiles::getPublicStylesheet(Constants::PLUGIN_NAME_CAMEL),
                [],
                '3.0.1',
                'all'
            );
        }
    }

	/**
	 * Enqueue plugin main library
	 *
	 * @since      3.0.0
	 * @return     void
	 */
	public static function enqueuePluginLibrary() {
		$mmdb_js_file = TemplateFiles::getJsFilePath(self::PLUGIN_JS_LIB_FILE, 'app/');
		wp_enqueue_script( self::PLUGIN_JS_LIB_FILE, $mmdb_js_file, ['wp-i18n'],1.1, true);
		wp_set_script_translations(
			self::PLUGIN_JS_LIB_FILE,
			'my-movie-database',
			MMDB_PLUGIN_DIR . 'languages'
		);
    }
}
