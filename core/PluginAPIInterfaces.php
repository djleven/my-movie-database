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

namespace MyMovieDatabase;

/**
 * ActionHookSubscriberInterface is used by an object that needs to subscribe to
 * WordPress action hooks.
 */
interface ActionHookSubscriberInterface
{
    /**
     * Returns an array of actions that the object needs to be subscribed to.
     *
     * The array key is the name of the action hook. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('action_name' => 'method_name')
     *  * array('action_name' => array('method_name', $priority))
     *  * array('action_name' => array('method_name', $priority, $accepted_args))
     *
     * @return array
     */
    public function getActions();
}

/**
 * FilterHookSubscriberInterface is used by an object that needs to subscribe to
 * WordPress filter hooks.
 */
interface FilterHookSubscriberInterface
{
    /**
     * Returns an array of filters that the object needs to be subscribed to.
     *
     * The array key is the name of the filter hook. The value can be:
     *
     *  * The method name
     *  * An array with the method name and priority
     *  * An array with the method name, priority and number of accepted arguments
     *
     * For instance:
     *
     *  * array('filter_name' => 'method_name')
     *  * array('filter_name' => array('method_name', $priority))
     *  * array('filter_name' => array('method_name', $priority, $accepted_args))
     *
     * @return array
     */
    public function getFilters();
}

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

/**
 * ShortcodeHookSubscriberInterface is used by an object that needs to register
 * WordPress shortcodes.
 */
interface ShortcodeHookSubscriberInterface
{
    /**
     * Returns an array of shortcodes that the object needs to register.
     *
     * The array key is the name of the shortcode.
     * The value is the method (callback) name
     *
     * array('shortcode_name' => 'method_name')
     *
     * @return array
     */
    public function getShortcodes();
}

