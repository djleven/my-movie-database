<?php
/**
 * This class serves as a helper for accessing the option settings.
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/includes/lib
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase\Lib;

class OptionsGroup {
    /**
     * The array of setting values
     *
     * @since    3.0.0
     * @access   protected
     * @var      array    $optionArray
     */
    protected $optionArray;

    /**
     * The option group name
     *
     * @since    3.0.0
     * @access   protected
     * @var      array    $optionGroupName
     */
    protected $optionGroupName;


    /**
     * Initialise the class
     *
     * @since    3.0.0
     * @access   protected
     * @var      string    $optionGroupName The option (group) name to retrieve the values from
     */
    public function __construct($optionGroupName) {
        $this->optionGroupName = $optionGroupName;
        $optionArray = get_option($this->optionGroupName);
        if(!$optionArray) {
            $optionArray = [];
        }

        $this->optionArray = $optionArray;
    }


    /**
     * Get the option by key and return default value if not set
     *
     * @since      3.0.0
     * @param      string $optionKey  setting option key
     * @param      string $default    default value
     * @return     mixed
     */
    public function getOption($optionKey, $default = '') {

        $options = $this->optionArray;

        if (isset($options[$optionKey]) && $options[$optionKey] !== '') {
            return $options[$optionKey];
        }

        return $default;
    }

    /**
     * Delete the option group
     *
     * @since     3.0.0
     * @return    bool
     */
    public function deleteOption() {
        return delete_option($this->optionGroupName);
    }
}

