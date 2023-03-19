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

use MyMovieDatabase\MyMovieDatabase;
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
     * Setup and return the type view output
     *
     * @param     $admin
     * @return    void  $output           The generated html of the template view
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
                    'debug' => (bool) CoreController::getMmdbOption("mmdb_debug", "mmdb_opt_advanced", false),
                    'date_format' => get_option( 'date_format' ),
                    'overviewOnHover' => (bool) CoreController::getMmdbOption("mmdb_overview_on_hover", "mmdb_opt_advanced", true),
                ],
            ];
        } elseif (in_array($uniqueID, $mmdbID_processed)) {
            return;
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
                'headerFontColor' => $this->getHeaderFontColorSetting(),
                'bodyFontColor' => $this->getBodyFontColorSetting(),
                'transitionEffect' => $this->getTransitionEffectSetting(),
            ],
        ];

        $myVueState = json_encode($myVueState);

        $myVue ='// The Vue instance for the ' . $this->data_type . ' ' . $mmdbID . '
                 MyMovieDb["app.umd"].default(
                   "#' . $this->getVueMountPoint() . '",
                   '. $myVueState . ',
                   ' . $admin . '
                )';

        $this->registerInstantiatingScriptWithWordPress($myVue);

        $mmdbID_processed[] = $uniqueID;
    }

    /**
     * Make sure the script has been registered with WordPress, if not, do so now.
     *
     * @param $content
     * @param bool $firsTry
     *
     * @since     3.0.0
     */
    protected function registerInstantiatingScriptWithWordPress($content, $firsTry = true) {
		$hasInstantiatingScriptBeenAdded = wp_add_inline_script( TemplateFiles::PLUGIN_JS_LIB_FILE, $content );
		if ( ! $hasInstantiatingScriptBeenAdded ) {
			TemplateFiles::enqueuePluginLibrary();
			if ( $firsTry ) {
				$this->registerInstantiatingScriptWithWordPress( $content, false );
			} else {
				MyMovieDatabase::writeToLog(
					$content,
					'Something went wrong registering plugin scripts with WordPress'
				);
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

        $mountBase = $this->getVueMountPoint();
        $output =
            '<div class="mmdb-content ' . $this->data_type .'" id="' . $mountBase . '-vue"> <div id="' . $mountBase . '"> </div></div>';

        if($admin) {
            $output .= PHP_EOL;
            $output .= '<input type="hidden" name="' . self::MMDB_POST_META_ID . '" id="' . self::MMDB_POST_META_ID . '" value="'. $this->tmdb_id .'"/>';
        }

        return $output;
    }
}
