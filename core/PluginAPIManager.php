<?php
/**
 * Registers the plugin's hooks using the wordpress plugin API
 * @link       https://carlalexander.ca/polymorphism-wordpress-interfaces/#an-example:-wordpress-plugin-api-manager
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Carl Alexander github.com/carlalexander
 *             Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Interfaces\FilterHookSubscriberInterface;
use MyMovieDatabase\Interfaces\RegisterStateActivationHookSubscriberInterface;
use MyMovieDatabase\Interfaces\ShortcodeHookSubscriberInterface;

/**
 * PluginAPIManager handles registering actions and hooks with the
 * WordPress Plugin API.
 */
class PluginAPIManager
{
    /**
     * Registers an object with the WordPress Plugin API.
     *
     * @param mixed $object
     */
    public function register($object)
    {
        if ($object instanceof ActionHookSubscriberInterface) {
            $this->registerActions($object);
        }
        if ($object instanceof FilterHookSubscriberInterface) {
            $this->registerFilters($object);
        }

        if ($object instanceof ShortcodeHookSubscriberInterface) {
            $this->registerShortcodes($object);
        }

        if ($object instanceof RegisterStateActivationHookSubscriberInterface) {
            $this->registerActivationStateHooks($object);
        }
    }

    /**
     * Register an object with a specific action hook.
     *
     * @param ActionHookSubscriberInterface $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function registerAction($object, $name, $parameters)
    {
        if (is_string($parameters)) {
            add_action($name, array($object, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            add_action($name, array($object, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10, isset($parameters[2]) ? $parameters[2] : 1);
        }
    }

    /**
     * Registers an object with all its action hooks.
     *
     * @param ActionHookSubscriberInterface $object
     */
    private function registerActions($object)
    {
        foreach ($object->getActions() as $name => $parameters) {
            $this->registerAction($object, $name, $parameters);
        }
    }

    /**
     * Register an object with a specific filter hook.
     *
     * @param FilterHookSubscriberInterface $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function registerFilter($object, $name, $parameters)
    {
        if (is_string($parameters)) {
            add_filter($name, array($object, $parameters));
        } elseif (is_array($parameters) && isset($parameters[0])) {
            add_filter($name, array($object, $parameters[0]), isset($parameters[1]) ? $parameters[1] : 10, isset($parameters[2]) ? $parameters[2] : 1);
        }
    }

    /**
     * Registers an object with all its filter hooks.
     *
     * @param FilterHookSubscriberInterface $object
     */
    private function registerFilters($object)
    {
        foreach ($object->getFilters() as $name => $parameters) {
            $this->registerFilter($object, $name, $parameters);
        }
    }

    /**
     * Registers an object with all its activation state changes hooks.
     *
     * @param RegisterStateActivationHookSubscriberInterface $object
     */
    private function registerActivationStateHooks($object)
    {
        foreach ($object->getRegisterActivationHooks() as $name => $callback) {
            register_activation_hook($name, array($object, $callback));
        }

        foreach ($object->getRegisterDeactivationHooks() as $name => $callback) {
            register_deactivation_hook($name, array($object, $callback));
        }
    }

    /**
     * Registers an object with all its shortcodes.
     *
     * @param ShortcodeHookSubscriberInterface $object
     */
    private function registerShortcodes($object)
    {
        foreach ($object->getShortcodes() as $name => $callback) {
            add_shortcode($name, array($object, $callback));
        }
    }
}