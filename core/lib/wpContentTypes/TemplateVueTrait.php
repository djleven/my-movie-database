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
        $type =$this->data_type;
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
     * Get an associative array of vue components to load, each with path and filename
     *
     * @since      2.0.0
     * @return     array
     */
    protected function getVueComponentsToLoad() {

        $array = [];
        if($this->template) {
            $components = TemplateFiles::getVueComponentsToLoadSetting($this->data_type);
            $json_data = json_decode($components, true);

            $count = 0;
            if($json_data) {
                foreach ($json_data[$this->template] as $key => $value) {
                    $isArray = is_array($value);
                    if($key === 'common') {
                        if($isArray) {
                            foreach ($value as $otherValue) {
                                $array[$key . $count]['path'] = 'common';
                                $array[$key . $count]['filename'] = $otherValue;
                                $count++;
                            }
                        }
                    } else {
                        if($isArray) {
                            $array[$key]['path'] = $value[0];
                            $array[$key]['filename'] = $value[1];
                        } else {
                            $array[$key]['path'] = '';
                            $array[$key]['filename'] = $value;
                        }
                    }

                }
            }
            $array['template']['path'] = 'templates';
            $array['template']['filename'] = $this->template;
        }

        return $array;
    }

    /**
     * Create the script content that registers the required Vue components via httpVueLoader
     *
     * @return string
     */
    protected function vueComponentsBasePath() {
        return 'components';
    }

    /**
     * Register the required Vue components and return the last component's wp registration handle
     *
     * @return string  last component's wp registration handle
     */
    protected function registerVueComponents() {

        $components_to_add = [];
        $component_script_handles = [];
        $count = 0;
        foreach ($this->components as $key => $component) {
            if($component['filename']) {
                $components_to_add[$count] =
                    TemplateFiles::getPublicFile(
                        $component['filename'],
                        self::COMPONENTS_ROOT_FOLDER . $component['path'],
                        'js',
                        false);
                wp_enqueue_script(
                    'vueComponent-' . $component['filename'], $components_to_add[$count], array( 'vue', 'vuex' ), 0.3, true);
                $component_script_handles[$count] = 'vueComponent-' . $component['filename'];
                $count++;
            }
        }

        add_filter( 'script_loader_tag', array($this, 'replace_js_tag_with_babel'), 10, 3 );

        return end($component_script_handles);
    }

    /**
     * Replace Vue components and myMovieDatabase.js script tag with babel type
     * @param string $tag     The <script> tag for the enqueued script.
     * @param string $handle  The script's registered handle.
     * @return string
     */
    public function replace_js_tag_with_babel( $tag, $handle ) {
        $handleStartsWith = 'vueComponent-';
        $isVueComponent = substr_compare($handle, $handleStartsWith, 0, strlen($handleStartsWith)) === 0;
        if ( $isVueComponent || $handle === MMDB_NAME ) {
            $tag = str_replace( "<script type='text/javascript'", "<script type='text/babel'", $tag );
        }

        return $tag;
    }

    /**
     * Setup and return the type view output
     *
     * @since     1.0.0
     * @param     string  $lastVueComponent The last registered vue component handle to add inline script to
     * @return    string  $output           The generated html of the template view
     */
    public function createVueInstance($lastVueComponent) {

        global $mmdbID_processed;
        $uniqueID = $this->getUniqueID();
        if(is_array($mmdbID_processed) && in_array($uniqueID, $mmdbID_processed)) {
            return false;
        }

        $mmdbID = $this->tmdb_id;
        if(!$mmdbID) {
            $mmdbID = 0;
        }

        $myVue ='// The Vue instance for the ' . $this->data_type . ' ' . $mmdbID . '
                 new Vue({
                    el: "#' . $this->getVueMountPoint() . '",
                    store: new Vuex.Store({
                        state: {
                            id: ' . $mmdbID . ',
                            type: "' . $this->data_type .'",
                            template: "' . $this->template . '",
                            showSettings: ' . json_encode($this->showSectionSettings()) . ',
                            __t: ' . MMDB_PLUGIN_ID . $this->data_type . '__t' . ',
                            cssClasses: {
                                multipleColumn: "' . $this->getMultipleColumnStyle() . '",
                                twoColumn: "' . $this->getTwoColumnStyle() . '",
                                headerColor: "' . $this->getHeaderColorSetting() . '",
                                bodyColor: "' . $this->getBodyColorSetting() . '",
                                transitionEffect: "' . $this->getTransitionEffectSetting() . '"
                            },
                            placeholder: {
                                small: "' . TemplateFiles::getSmallImagePlaceholder() . '",
                                medium: "' . TemplateFiles::getImagePlaceholder() . '",
                                large: "' . TemplateFiles::getLargeImagePlaceholder() . '"
                            },
                            components: ' . json_encode($this->components) . ',
                            content: null,
                            credits: null,
                            activeTab: "overview"
                        },
                        mutations: {
                            addContent: function (state, payload) {
                                state.content = payload
                            },
                            addCredits: function (state, payload) {
                                state.credits = payload
                            },
                            setActive: function (state, activeTab) {
                                state.activeTab = activeTab
                            },
                            setID: function (state, id) {
                                state.id = id
                            },
                        }
                    })
                });';

        wp_add_inline_script( $lastVueComponent, $myVue);
        $mmdbID_processed[] = $uniqueID;
    }

    /**
     * Setup and return the type view output
     *
     * @since     1.0.0
     * @return    string	$output    The generated html of the template view
     */
    public function templateVueOutput() {

        $lastVueComponent = $this->registerVueComponents();
        $this->localizeTemplateScript();
        $this->createVueInstance($lastVueComponent);
        $vueComponent = $this->components['entry']['filename'];

        $output =
            '<div id="' . $this->getVueMountPoint() . '"><' . $vueComponent .'></' . $vueComponent .'></div>';

        if( get_class($this) === 'MyMovieDatabase\Lib\WpContentTypes\WpAdminPostContentType') {
            $output .= PHP_EOL;
            $output .= '<input type="hidden" name="' . self::MMDB_POST_META_ID . '" id="' . self::MMDB_POST_META_ID . '" value="'. $this->tmdb_id .'"/>';
        }

        return $output;
    }
}
