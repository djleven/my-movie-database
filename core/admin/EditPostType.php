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

class EditPostType {

    public $type_name;
    public $type_slug;
    public $type_plural;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $type_name       		The name of this type.
     * @param      string    $type_slug       		The slug of this type.
     * @param      string    $type_plural     		The plural name of this type.
     */
    public function __construct($type_name, $type_slug, $type_plural) {

        $this->type_name = $type_name;
        $this->type_slug = $type_slug;
        $this->type_plural = $type_plural;
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
     * Change the posts menu label
     *
     * @since     0.7.0
     */
    public function mmdb_change_posts_menu_label() {
        global $menu;
        global $submenu;
        $menu[5][0] = "$this->type_plural";
        $submenu['edit.php'][5][0] = "$this->type_plural";
        $submenu['edit.php'][10][0] = "Add $this->type_plural";
        echo '';
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
        $labels->singular_name = "$this->type_name";
        $labels->add_new = "Add $this->type_name";
        $labels->add_new_item = "Add $this->type_name";
        $labels->edit_item = "Edit $this->type_name";
        $labels->new_item = "$this->type_name";
        $labels->view_item = "View $this->type_name";
        $labels->search_items = "Search $this->type_plural";
        $labels->not_found = "No $this->type_plural found";
        $labels->not_found_in_trash = "No $this->type_plural found in Trash";
    }
}