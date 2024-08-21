<?php
/**
 * Defines the properties for editing / modifying the default Wordpress post type
 *
 * @link       https://e-leven.net/
 * @since      1.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core/admin
 * @author     Kostas Stathakos <info@e-leven.net>
 */

namespace MyMovieDatabase\Admin;

use MyMovieDatabase\Interfaces\ActionHookSubscriberInterface;
use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;

class EditPostType implements ActionHookSubscriberInterface {

    /**
     * The label of this type.
     * @var string
     */
    public $type_label;

    /**
     * The plural label of this type.
     * @var string
     */
    public $type_plural;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->type_label = MovieResourceType::getI18nDefaultLabel();
        $this->type_plural = MovieResourceType::getI18nDefaultPluralLabel();
    }

    /**
     * Get the action hooks to be registered related to the main wp post type.
     *
     * @since    2.5.0
     * @access   public
     */
    public function getActions()
    {
        return [
            'admin_head'    => 'mmdb_posts_admin_menu_icons_css',
            'init'          => 'mmdb_change_posts_object_label',
        ];
    }

    /**
     * Overide the admin menu icon (CSS)
     *
     * @since     0.7.0
     */
    public function mmdb_posts_admin_menu_icons_css() {
        ?>
        <style>
            .dashicons-admin-post::before {
                content: '\f234';
            }
        </style>
        <?php
    }

    /**
     * Change the posts labels
     *
     * @since     0.7.0
     */
    public function mmdb_change_posts_object_label() {
        global $wp_post_types;
        $labels = & $wp_post_types['post']->labels;
        $labels->name = $this->type_plural;
        $labels->singular_name = "$this->type_label";
        $labels->menu_name = $this->type_plural;
        $labels->all_items = $this->type_plural;
    }
}
