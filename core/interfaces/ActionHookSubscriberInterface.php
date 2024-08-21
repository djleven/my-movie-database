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
