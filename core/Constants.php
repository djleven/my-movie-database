<?php
/**
 * The class responsible for keeping track of the core WP translation strings used in this plugin
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/public
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;

class Constants {

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
     * The custom post type screens and the plugin settings. One reason for going down this path relates to the custom
     * post types. Further info to come below.
     * 
     * The translations used have been carefully selected, considering their context to minimise errors in some locales,
     * as well as the sources of these strings to ensure availability and relative stability.
     */

    /** from ? */
    const I18n_CORE_NO = 'No';
    const I18n_CORE_YES = 'Yes';
    const I18n_CORE_ENABLED = 'Enabled';
    const I18n_CORE_DISABLED = 'Disabled';
    const I18n_CORE_NONE = 'None';


    /**  from wp-includes/admin-bar.php */
    const I18n_CORE_DOCUMENTATION = 'Documentation';
    const I18n_CORE_SUPPORT = 'Support';

    /** from ? */
    const I18n_CORE_CATEGORIES= 'Categories';
    const I18n_CORE_TAGS = 'Tags';
    const I18n_CORE_CATEGORIES_TAGS_DESC =  'Categories have hierarchy, meaning that you can nest sub-categories. Tags do not have hierarchy and cannot be nested. Sometimes people start out using one on their posts, then later realize that the other would work better for their content.';


    /**
     * Template styling
     */
    /** from /wp-includes/class-wp-xmlrpc-server.php*/
    const I18n_CORE_TEMPLATE = 'Template';

    /** from wp-includes/class-wp-editor.php */
    const I18n_CORE_BODY = 'Body';
    const I18n_CORE_BODY_CTX = 'table body';
    const I18n_CORE_HEADER = 'Header';
    const I18n_CORE_BG_COLOR = 'Background color';
    const I18n_CORE_TEXT_COLOR = 'Text color';
    const I18n_CORE_WIDTH = 'Width';

}
