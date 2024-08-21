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

