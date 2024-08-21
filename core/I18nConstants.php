<?php
/**
 * The class responsible for keeping track of the core WP translation strings used in this plugin
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

use MyMovieDatabase\Lib\ResourceTypes\MovieResourceType;
use MyMovieDatabase\Lib\ResourceTypes\TvshowResourceType;
use MyMovieDatabase\Lib\ResourceTypes\PersonResourceType;

class I18nConstants {

    /**
     * The class responsible for keeping track of the core WP translation strings used in this plugin
     *
     * Well, there's more to it. Apparently, the WordPress translate platform ignores the text-domain when creating
     * POT files. So in order to avoid having WP core i18n be added to their POT file, we will load them 'dynamically'.
     *
     * Using core wp i18n strings is considered a bad practise. There are multiple core pot files, there are serious
     * questions of context and other reasons to recommend against this. Although there obviously is merit in these
     * arguments, it seems to me that there are also some valid reasons to do so.
     *
     * The current use of core translation strings by this plugin is 99% for the WordPress backend;
     * The custom post type screens and the plugin settings.
     *
     * The translations used have been carefully selected, considering their context to minimise errors in some locales,
     * as well as the sources of these strings to ensure availability and relative stability.
     *
     * Obviously it's really nice not to have to translate some basic strings like 'Yes/No', 'Enabled/Disabled' again
     * and again, especially for simple plugin settings.
     * Another reason for going down this path relates to the custom post types. See info below.
     */

    /*
    * wp-admin/includes/ajax-actions.php
    * wp-admin/includes/ajax-actions.php
    * wp-admin/includes/class-wp-debug-data.php
    * wp-admin/includes/class-wp-debug-data.php
    * wp-admin/includes/class-wp-debug-data.php:
    * wp-admin/includes/class-wp-plugins-list-table.php
    * wp-admin/includes/update.php:231 wp-admin/includes/update.php
    * wp-admin/includes/class-wp-ms-themes-list-table.php
     */
    const I18n_CORE_VERSION = 'Version %s';

    /*
     * wp-signup.php
     * wp-admin/includes/class-wp-debug-data.php
     * wp-admin/includes/class-wp-links-list-table.php
     */
    const I18n_CORE_NO = 'No';
    const I18n_CORE_YES = 'Yes';

    /* wp-admin/includes/class-wp-debug-data.php */
    const I18n_CORE_ENABLED = 'Enabled';
    const I18n_CORE_DISABLED = 'Disabled';

    /* wp-admin/includes/meta-boxes.php */
    const I18n_CORE_NONE = 'None';


    /* wp-includes/admin-bar.php */
    const I18n_CORE_DOCUMENTATION = 'Documentation';
    const I18n_CORE_SUPPORT = 'Support';

    /* wp-includes/media-template.php */
    const I18n_CORE_ADVANCED_OPTIONS = 'Advanced Options';

    /*
     * wp-includes/blocks/categories.php
     * wp-includes/theme-compat/sidebar.php:129
     * wp-includes/category-template.php
     * wp-includes/widgets/class-wp-widget-categories.php
     * wp-includes/js/dist/block-library.js
     * wp-includes/js/dist/components.js
     * wp-admin/edit-link-form.php
     * wp-admin/includes/class-wp-links-list-table.php
     * wp-admin/includes/upgrade.php:
     */
    const I18n_CORE_CATEGORIES= 'Categories';

    /*
     * wp-includes/admin-bar.php
     * wp-includes/blocks/search.php
     * wp-includes/class-wp-editor.php
     * wp-includes/media.php
     * wp-includes/js/dist/block-editor.js
     * wp-includes/js/dist/components.js
     * wp-includes/js/dist/edit-site.js
     * wp-admin/includes/class-wp-media-list-table.php
     * wp-admin/includes/class-wp-theme-install-list-table.php
     * wp-admin/includes/nav-menu.php
     * wp-admin/includes/template.php
     * wp-admin/includes/theme-install.php
     * */
    const I18n_CORE_SEARCH = 'Search';

    /* wp-includes/widgets/class-wp-widget-tag-cloud.php */
    const I18n_CORE_TAGS = 'Tags';

    /*  wp-admin/tools.php */
    const I18n_CORE_CATEGORIES_TAGS_DESC =  'Categories have hierarchy, meaning that you can nest sub-categories. Tags do not have hierarchy and cannot be nested. Sometimes people start out using one on their posts, then later realize that the other would work better for their content.';

    /**
     * Template styling
     */

    /*
     * wp-includes/class-wp-xmlrpc-server.php
     * wp-includes/js/dist/edit-site.js
     * wp-admin/includes/class-wp-posts-list-table.php
     * wp-admin/includes/meta-boxes.php
     */
    const I18n_CORE_TEMPLATE = 'Template';

    /* wp-includes/class-wp-editor.php */
    const I18n_CORE_BODY = 'Body';
    const I18n_CORE_BODY_CTX = 'table body';
    const I18n_CORE_HEADER = 'Header';
    const I18n_CORE_BG_COLOR = 'Background color';
    const I18n_CORE_TEXT_COLOR = 'Text color';

    /* wp-includes/theme.json */
    const I18n_CORE_LARGE = 'Large';
    const I18n_CORE_MEDIUM = 'Medium';
    const I18n_CORE_SMALL = 'Small';

    /*
    * wp-includes/media.php:4585 wp-includes/js/dist/block-editor.js
    * wp-includes/js/dist/block-library.js
    * wp-includes/js/dist/editor.js:5967 wp-admin/includes/template.php
    * wp-admin/nav-menus.php:936 wp-admin/plugin-editor.php
    * wp-admin/theme-editor.php
    */
    const I18n_CORE_SELECT = 'Select';

    /*
    * wp-admin/update-core.php:802 wp-admin/update-core.php:810
    */
    const I18n_CORE_TRANSLATIONS = 'Translations';

    /*
    * wp-admin/credits.php:27
    * wp-admin/includes/plugin-install.php:786
    */
    const I18n_CORE_CONTRIBUTORS = 'Contributors';

    /*
    * wp-admin/about.php:40
    * wp-admin/credits.php:14 wp-admin/credits.php:44
    * wp-admin/freedoms.php:41
    * wp-admin/privacy.php:35
    * */
    const I18n_CORE_CREDITS = 'Credits';

    /**
     * Custom post type creation
     *
     * WordPress seems to use the Page instead of Post type translations (default labels) for custom post type labels
     * that have not been defined during their creation. In other words, the default labels fallback to
     * 'pages' instead of 'posts'.
     *
     * So when creating a custom post type we're explicitly defining (almost) all  of them (because we want 'posts').
     * In the context of the purpose of this file (the bad practise), I really could not bear to see
     * the below included in this plugin's POT file.
     *
     * These come from WP get_default_labels() (at wp-app/wp-includes/class-wp-post-type.php)
     */
    const I18n_CORE_POST_TYPE_LABELS = [
        'Add New'                      => 'Add New',
        'No posts found.'              => 'No posts found.',
        'No posts found in Trash.'     => 'No posts found in Trash.',
        'Add New Post'                 => 'Add New Post',
        'Edit Post'                    => 'Edit Post',
        'New Post'                     => 'New Post',
        'View Post'                    => 'View Post',
        'View Posts'                   => 'View Posts',
        'Search Posts'                 => 'Search Posts',
        'Post Archives'                => 'Post Archives',
        'Post Attributes'              => 'Post Attributes',
        'Insert into post'             => 'Insert into post',
        'Uploaded to this post'        => 'Uploaded to this post',
        'Featured image'               => 'Featured image',
        'Set featured image'           => 'Set featured image',
        'Remove featured image'        => 'Remove featured image',
        'Use as featured image'        => 'Use as featured image',
        'Filter posts list'            => 'Filter posts list',
        'Posts list navigation'        => 'Posts list navigation',
        'Posts list'                   => 'Posts list',
        'Post published.'              => 'Post published.',
        'Post published privately.'    => 'Post published privately.',
        'Post reverted to draft.'      => 'Post reverted to draft.',
        'Post scheduled.'              => 'Post scheduled.',
        'Post updated.'                => 'Post updated.',
        'Post Link'                    => 'Post Link',
        'A link to a post.'            => 'A link to a post.',
    ];

    public static function getTypeLabel($type) {

        if ($type === MovieResourceType::DATA_TYPE_NAME) {
            return MovieResourceType::getI18nDefaultLabel();
        }

        if ($type === TvshowResourceType::DATA_TYPE_NAME) {
            return TvshowResourceType::getI18nDefaultLabel();
        }

        if ($type === PersonResourceType::DATA_TYPE_NAME) {
            return PersonResourceType::getI18nDefaultLabel();
        }

        return $type;
    }
}
