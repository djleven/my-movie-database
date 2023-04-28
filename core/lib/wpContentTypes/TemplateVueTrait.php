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

use MyMovieDatabase\Constants;

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
        $mmdbID = $this->tmdb_id;
        $myVueState = [
            'id' => $mmdbID,
            'type' => $this->data_type,
            'template' => $this->template,
            'global_conf' => $this->getGlobalConfForJSView(),
            'showSettings' => $this->showSectionSettings(),
            'styling' => [
                'size' => $this->getWidthSetting(),
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
				$load_css_file = $this->advancedSettings->getOption(
					Constants::ADV_OPTION_CSS_FILE_INC,
					Constants::OPTION_STRING_VALUE_TRUE
			);
			TemplateFiles::enqueueCommonFiles($load_css_file !== Constants::OPTION_STRING_VALUE_FALSE);
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
     * @since     3.0.0
     * @return    array	$output    The generated html of the template view
     */
    protected function getGlobalConfForJSView() {

        return [
            'locale' => get_locale(),
            'debug' =>
                (bool) $this->advancedSettings->getOption(Constants::ADV_OPTION_DEBUG_ENABLE, false),
            'date_format' => get_option( 'date_format' ),
            'overviewOnHover' =>
                (bool) $this->advancedSettings->getOption(Constants::ADV_OPTION_OVERVIEW_HOVER, true),
        ];
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
        return
            '<div class="mmdb-content ' . $this->data_type .'" id="' . $mountBase . '-vue"> <div id="' . $mountBase . '"> </div></div>';
    }
}