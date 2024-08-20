<?php
/**
 * The class responsible for storing the constants used in this plugin
 *
 * @link       https://e-leven.net/
 * @since      3.0.0
 *
 * @package    my-movie-database
 * @subpackage my-movie-database/core
 * @author     Kostas Stathakos <info@e-leven.net>
 */
namespace MyMovieDatabase;


class Constants {

    /**
     * Global Plugin Naming
     */
    const PLUGIN_ID_INIT = 'mmdb';
    const PLUGIN_NAME_DASHES = 'my-movie-database';
    const PLUGIN_NAME_UNDERSCORES = 'my_movie_database';
    const PLUGIN_NAME_CAMEL = 'myMovieDatabase';

    /**
     * Advanced Settings Group
     */
    const ADVANCED_OPTION_GROUP_NAME = self::PLUGIN_ID_INIT . '_opt_advanced';
    const ADV_OPTION_POST_TYPE_MOVIE = self::PLUGIN_ID_INIT . '_movie_post_type';
    const ADV_OPTION_POST_TYPE_TV = self::PLUGIN_ID_INIT . '_tvshow_post_type';
    const ADV_OPTION_POST_TYPE_PERSON = self::PLUGIN_ID_INIT . '_person_post_type';
    const ADV_OPTION_TAXONOMY_TYPE = self::PLUGIN_ID_INIT . '_hierarchical_taxonomy';
    const ADV_OPTION_WP_CATEGORIES = self::PLUGIN_ID_INIT . '_wp_categories';
    const ADV_OPTION_OVERVIEW_HOVER = self::PLUGIN_ID_INIT . '_overview_on_hover';
    const ADV_OPTION_CSS_FILE_INC = self::PLUGIN_ID_INIT . '_css_file';
    const ADV_OPTION_API_KEY = self::PLUGIN_ID_INIT . '_tmdb_api_key';
    const ADV_OPTION_GUTENBERG_DISABLE = self::PLUGIN_ID_INIT . '_disable_gutenberg_post_type';
    const ADV_OPTION_DEBUG_ENABLE = self::PLUGIN_ID_INIT . '_debug';


    /**
     * Cache Manager Settings Group
     */
    const CACHE_MANAGER_OPTION_GROUP_NAME = self::PLUGIN_ID_INIT . '_opt_cache_manager';
    const CACHE_MANAGER_DELETE_TYPE = self::PLUGIN_ID_INIT . '_delete_cache_type';
    const CACHE_MANAGER_DELETE_ID = self::PLUGIN_ID_INIT . '_delete_cache_id';

    const ADMIN_OPTIONS_PAGE = 'admin_options_page';
    const ADMIN_EDIT_POST_PAGE = 'admin_edit_post_page';

    /**
     * Credits Settings Group
     */
    const CREDITS_OPTION_GROUP_NAME = self::PLUGIN_ID_INIT . '_opt_credits';
    const CREDITS_TRANSLATION_ID = self::PLUGIN_ID_INIT . '_translation_credits';
    const CREDITS_DEVELOPMENT_ID = self::PLUGIN_ID_INIT . '_development_credits';

    /**
     * Settings Option Values
     */
    const OPTION_VALUE_TMPL_TABS = 'tabs';
    const OPTION_VALUE_TMPL_ACCORDION = 'accordion';

    const OPTION_VALUE_TRANSITION_FADE = 'fade';
    const OPTION_VALUE_TRANSITION_BOUNCE = 'bounce';
    const OPTION_VALUE_TRANSITION_NONE = 'none';

    const OPTION_VALUE_SIZE_LARGE = 'large';
    const OPTION_VALUE_SIZE_MEDIUM = 'medium';
    const OPTION_VALUE_SIZE_SMALL = 'small';

    const OPTION_VALUE_POS_BEFORE_CONTENT = 'before';
    const OPTION_VALUE_POS_AFTER_CONTENT = 'after';

    const OPTION_VALUE_COLOR_DEFAULT_ONE = '#265a88';
    const OPTION_VALUE_COLOR_DEFAULT_TWO = '#DCDCDC';

    // TODO: Migration script to convert these to boolean
    const OPTION_STRING_VALUE_TRUE = 'yes';
    const OPTION_STRING_VALUE_FALSE = 'no';
}
