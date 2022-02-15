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

use MyMovieDatabase\ActionHookSubscriberInterface;
use MyMovieDatabase\RegisterStateActivationHookSubscriberInterface;

class ActivationStateChanges implements ActionHookSubscriberInterface, RegisterStateActivationHookSubscriberInterface {

    const PLUGIN_ACTIVATED = 'Plugin_Activated';

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

        add_option( self::PLUGIN_ACTIVATED, MMDB_NAME );

    }

    public function on_mmdb_deactivation() {

    }

    public function on_load_mmdb() {

        if ( get_option( self::PLUGIN_ACTIVATED ) ===  MMDB_NAME) {

            delete_option( self::PLUGIN_ACTIVATED );

            flush_rewrite_rules();
        }
    }
}
