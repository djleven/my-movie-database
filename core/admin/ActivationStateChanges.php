<?php
/**
 * Define the activation and deactivation sequence tasks for the plugin.
 *
 * @link       https://e-leven.net/
 * @since    2.0.2
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Admin;

use MyMovieDatabase\Constants;
use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Interfaces\RegisterStateActivationHookSubscriberInterface;

class ActivationStateChanges implements ActionHookSubscriberInterface, RegisterStateActivationHookSubscriberInterface {

    const PLUGIN_ACTIVATED_OPTION = Constants::PLUGIN_ID_INIT . '_opt_plugin_activated';

    public $pluginFile = MMDB_PLUGIN_MAIN_FILE;

    /**
     * Get the action hooks to be registered.
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'admin_init' => 'on_load_mmdb',
        ];
    }

    /**
     * Get the activation hooks to be registered.
     *
     * @since    2.5.0
     * @access   public
     */
    public function getRegisterActivationHooks()
    {
        return [
            $this->pluginFile => 'on_mmdb_activation',
        ];
    }

    /**
     * Get the deactivation hooks to be registered.
     *
     * @since    2.5.0
     * @access   public
     */
    public function getRegisterDeactivationHooks()
    {
        return [
//            $this->pluginFile => 'on_mmdb_deactivation',
        ];
    }

    public function on_mmdb_activation() {

        add_option( self::PLUGIN_ACTIVATED_OPTION, Constants::PLUGIN_NAME_CAMEL );

    }

    public function on_mmdb_deactivation() {

    }

    public function on_load_mmdb() {

        if ( get_option( self::PLUGIN_ACTIVATED_OPTION ) ===  Constants::PLUGIN_NAME_CAMEL) {

            delete_option( self::PLUGIN_ACTIVATED_OPTION );

            flush_rewrite_rules();
        }
    }
}
