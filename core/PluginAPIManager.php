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
            $this->register_actions($object);
        }
        if ($object instanceof FilterHookSubscriberInterface) {
            $this->register_filters($object);
        }

        if ($object instanceof ShortcodeHookSubscriberInterface) {
            $this->register_shortcodes($object);
        }
    }

    /**
     * Register an object with a specific action hook.
     *
     * @param ActionHookSubscriberInterface $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function register_action($object, $name, $parameters)
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
    private function register_actions($object)
    {
        foreach ($object->get_actions() as $name => $parameters) {
            $this->register_action($object, $name, $parameters);
        }
    }

    /**
     * Register an object with a specific filter hook.
     *
     * @param FilterHookSubscriberInterface $object
     * @param string                        $name
     * @param mixed                         $parameters
     */
    private function register_filter($object, $name, $parameters)
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
    private function register_filters($object)
    {
        foreach ($object->get_filters() as $name => $parameters) {
            $this->register_filter($object, $name, $parameters);
        }
    }

    /**
     * Registers an object with all its shortcode hooks.
     *
     * @param ShortcodeHookSubscriberInterface $object
     */
    private function register_shortcodes($object)
    {
        foreach ($object->get_shortcodes() as $name => $callback) {
            add_shortcode($name, array($object, $callback));
        }
    }
}