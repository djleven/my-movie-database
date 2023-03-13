<?php
/**
 * This trait defines the Vuejs related functionality for WpContentType concrete classes
 *
 * @link       https://e-leven.net/
 * @since      2.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/lib/wpContentTypes
 */
namespace MyMovieDatabase\Lib\WpContentTypes;

use MyMovieDatabase\TemplateFiles;
use MyMovieDatabase\CoreController;

trait TemplateVueTrait
{
    /**
     * Create the vue mount point selector id
     *
     * @since     2.0.0
     * @return    string	$output    	  The generated template view
     */
    protected function getVueMountPoint() {

        return 'mmdb-content_' . $this->getUniqueID();
    }

    /**
     * Create the template translation strings as a Javascript object
     *
     * @since      2.0.0
     * @return     void
     */
    protected function localizeTemplateScript() {

        global $wp_scripts;
        $type = $this->data_type;
        if ($type === 'movie' || $type === 'tvshow' || $type === 'person') {
            $script_handle = MMDB_PLUGIN_ID . $type . '__t';
            $existing_script = $wp_scripts->get_data(MMDB_NAME, 'data');
            $jsonFile = TemplateFiles::getJavascriptI18nSetting($type);
            if ($jsonFile) {
                // check to see it has not already been registered
                if (empty($existing_script) || strpos($existing_script, $script_handle) === false) {
                    wp_localize_script(MMDB_NAME, $script_handle, $this->jsonToWordpressI18n($jsonFile));
                }
            }
        }
    }

    /**
     * Convert JSON key/value to WordPress I18n array
     *
     * Array to be used in wp_localize_script
     *
     * @since      2.0.0
     * @param      string $json
     * @return     array
     */
    protected function jsonToWordpressI18n($json) {
        $array = [];
        $json_data = json_decode($json, true);
        if($json_data) {
            foreach ($json_data as $key => $value) {
                $array[$key] = __($value , MMDB_WP_NAME);
            }
        }
        return $array;
    }

    /**
     * Setup and return the type view output
     *
     * @param     $admin
     * @return    string  $output           The generated html of the template view
     * @since     1.0.0
     */
    public function createVueInstance($admin) {

        global $mmdbID_processed;
        global $mmdb_single_run_settings;
        $uniqueID = $this->getUniqueID();

        if(!is_array($mmdbID_processed)) {
            $mmdb_single_run_settings = [
                'global_conf' => [
                    'locale' => get_locale(),
                    'debug' => CoreController::getMmdbOption("mmdb_debug", "mmdb_opt_advanced", 0),
                    'date_format' => get_option( 'date_format' ),
                    'overviewOnHover' => (bool) CoreController::getMmdbOption("mmdb_overview_on_hover", "mmdb_opt_advanced", true),
                ],
                'placeholder_paths' => [
                    'small' => TemplateFiles::getSmallImagePlaceholder(),
                    'medium' => TemplateFiles::getImagePlaceholder(),
                    'large' => TemplateFiles::getLargeImagePlaceholder(),
                ]
            ];
        } elseif (in_array($uniqueID, $mmdbID_processed)) {
            return false;
        }

        $mmdbID = $this->tmdb_id;
        if(!$mmdbID) {
            $mmdbID = 0;
        }

        $myVueState = [
            'id' => $mmdbID,
            'type' => $this->data_type,
            'template' => $this->template,
            'global_conf' => $mmdb_single_run_settings['global_conf'],
            'showSettings' => $this->showSectionSettings(),
            'cssClasses' => [
                'multipleColumn' => $this->getMultipleColumnStyle(),
                'twoColumn' => $this->getTwoColumnStyle(),
                'headerColor' => $this->getHeaderColorSetting(),
                'bodyColor' => $this->getBodyColorSetting(),
                'transitionEffect' => $this->getTransitionEffectSetting(),
            ],
            'placeholder' => $mmdb_single_run_settings['placeholder_paths']
        ];

        $myVueState = json_encode($myVueState);

        $myVue ='// The Vue instance for the ' . $this->data_type . ' ' . $mmdbID . '
                 MyMovieDb["app.umd"].default(
                   "#' . $this->getVueMountPoint() . '",
                   '. $myVueState . ',
                   ' . MMDB_PLUGIN_ID . $this->data_type . '__t' . ',
                   ' . $admin . '
                )';

        $this->registerInstantiatingScriptWithWorpdress($myVue);

        $mmdbID_processed[] = $uniqueID;
    }
	protected function registerInstantiatingScriptWithWorpdress($content, $firsTry = true) {
		$hasInstantiatingScriptBeenAdded = wp_add_inline_script( MMDB_NAME, $content );
		if ( ! $hasInstantiatingScriptBeenAdded ) {
			TemplateFiles::enqueuePluginLibrary();
			if ( $firsTry ) {
				$this->registerInstantiatingScriptWithWorpdress( $content, false );
			} else {
				var_dump( 'errorororoorrr' );
			}
		}
	}


    /**
     * Setup and return the type view output
     *
     * @since     1.0.0
     * @return    string	$output    The generated html of the template view
     */
    public function templateVueOutput() {

        $admin = false;
        if( get_class($this) === 'MyMovieDatabase\Lib\WpContentTypes\WpAdminPostContentType') {
            $admin = true;
        }

        $this->createVueInstance($admin);
	    $this->localizeTemplateScript();

        $mountBase = $this->getVueMountPoint();
        $output =
            '<div id="' . $mountBase . '-vue"> <div id="' . $mountBase . '"> </div></div>';

        if($admin) {
            $output .= PHP_EOL;
            $output .= '<input type="hidden" name="' . self::MMDB_POST_META_ID . '" id="' . self::MMDB_POST_META_ID . '" value="'. $this->tmdb_id .'"/>';
        }

        return $output;
    }
}
