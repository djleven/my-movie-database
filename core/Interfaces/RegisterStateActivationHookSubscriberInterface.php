<?php
/**
 * Wordpress plugin API interfaces
 * @link       https://carlalexander.ca/polymorphism-wordpress-interfaces/#an-example:-wordpress-plugin-api-manager
 * @since      2.5.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Carl Alexander github.com/carlalexander
 *             Kostas Stathakos <info@e-leven.net>
 */

namespace MyMovieDatabase\Interfaces;

/**
 * RegisterActivationHookSubscriberInterface is used by an object that needs to subscribe to
 * WordPress Activation/Deactivation hooks.
 */
interface RegisterStateActivationHookSubscriberInterface
{
    /**
     * Returns an array of register activation state hooks that the object needs to be subscribed to.
     *
     * The array key is the plugin filename.
     * The value is the method (callback) name
     *
     * array('plugin_file_name' => 'method_name')
     *
     * @return array
     */
    public function getRegisterActivationHooks();

    /**
     * Returns an array of register deactivation state hooks that the object needs to be subscribed to.
     *
     * The array key is the plugin filename.
     * The value is the method (callback) name
     *
     * array('plugin_file_name' => 'method_name')
     *
     * @return array
     */
    public function getRegisterDeactivationHooks();
}
